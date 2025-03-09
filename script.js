$(document).ready(function() {
    $("#logForm").submit(function(event) {
        event.preventDefault();
        let formData = $(this).serialize();
        console.log("Form Data:", formData);
        $.ajax({
            url: "save_progress.php",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                console.log("AJAX Response:", response);
                if (response.success) {
                    $("#message").html(
                        `<div class="alert alert-success" role="alert">${response.message}</div>`
                    );
                    // location.reload();
                } else {
                    $("#message").html(
                        `<div class="alert alert-danger" role="alert">${response.message}</div>`
                    );
                }
            },
            error: function(xhr, status, error) {
                $("#message").html(
                    '<div class="alert alert-danger" role="alert">AJAX Error: ' + error + '</div>'  +   '<div class="alert alert-danger" role="alert">Response Text: ' + xhr.responseText + '</div>'
                );
                console.error("AJAX Error:", error);
                console.error("Response Text:", xhr.responseText);
            }
        });
    });
});

let ajaxTimeout;

$(document).on("change", "select[name='exercise_id[]']", function() {
   console.log("Dropdown changed!"); 
//    console.log("Inspecting exerciseSelect:" + $("select[name='exercise_id[]']").length);
    let entryGroup = $(this).closest(".entry-group");
    let user_id = $("input[name='user_id']").val();
    let exercise_id = $(this).val();
    // let caloriesBurnedInput = entryGroup.find('input[name="calories_burned[]"]').val();
    let durationFieldWrapper = entryGroup.find(".duration-field");
    let durationInput = durationFieldWrapper.find("input[name='duration[]']");
    let exercise_ids = [exercise_id];
    
   if(exercise_id){
    durationFieldWrapper.show()
   }else{durationFieldWrapper.hide()}
   let duration = durationInput.val();
   
    // Debugging
    durationInput.off("change").on("change", function() {
        clearTimeout(ajaxTimeout); // Clear the timeout
        let duration = $(this).val();
        let durations = [duration];
    

    if (user_id && exercise_id && duration) {
        console.log("Sending AJAX Data:", {
            user_id,
            exercise_id,
            duration,
           
        });
        $.ajax({
            url: "met_calc.php",
            type: "POST",
            dataType: "json",
            data: {
                user_id:user_id,
                exercise_id:exercise_ids,
                duration:durations,
               
            },
            success: function(response) {
                console.log("MET Calculation Response:", response); // Debugging
                if (response.calories_burned) {
                    $(".calories-burned-input").html(
                        `<div class="alert alert-success" role="alert">${response.calories_burned}</div>`
                    );
                    $(".total-calories-burned").html(
                        `<div class="alert alert-success" role="alert">${response.total_calories_burned}</div>`
                    );
                    console.log("Calories Burned:", response.total_calories_burned); // Debugging
                } else {
                    console.error("No calories_burned in response:", response);
                    alert("Error: " + response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                console.error("Response Text:", xhr.responseText);
            }
        });
    }else{
        console.error("Missing required data:", { user_id, exercise_id, duration });
    }
})
});

let debounceTimer;
let dataSubmitted = false; // Flag to track if data has been submitted

$(document).on("input", ".entry-group input", function () {
    clearTimeout(debounceTimer); // Clear the previous timer

    // Reset the flag if the user edits a field after submission
    if (dataSubmitted) {
        dataSubmitted = false;
        console.log("Data submission reset. Ready for new input.");
    }

    debounceTimer = setTimeout(() => {
        let entryGroup = $(this).closest(".entry-group");
        let diet_id = $("input[name='user_id']").val();
        let diet_entry_id = entryGroup.find("input[name='id[]']").val();
        let meal_name = entryGroup.find("select[name='meal[]']").val().trim();
        let protein = parseInt(entryGroup.find("input[name='protein[]']").val()) || 0;
        let carb = parseInt(entryGroup.find("input[name='carbs[]']").val()) || 0;
        let fat = parseInt(entryGroup.find("input[name='fats[]']").val()) || 0;
        let caloriesIntake = entryGroup.find("input[name='calories_intake[]']").val();

        // Debug the extracted values
        console.log("Extracted Values:");
        console.log("Protein:", protein);
        console.log("Carbs:", carb);
        console.log("Fats:", fat);
        console.log("Meal:", meal_name);
        console.log("Calories Intake Value Before Sending:", caloriesIntake || "EMPTY");
        console.log("Diet ID:", diet_entry_id);

        // Check if all required fields are filled
        if (diet_entry_id && meal_name && protein >= 0 && carb >= 0 && fat >= 0 && !dataSubmitted) {
            // Set the flag to prevent multiple submissions
            dataSubmitted = true;

            // Send the data via AJAX
            $.ajax({
                url: "caloriesCalc.php",
                type: "POST",
                dataType: "json",
                data: {
                    id: [diet_entry_id],
                    user_id: diet_id,
                    meal_name: meal_name,
                    protein: [protein],
                    carbs: [carb],
                    fats: [fat],
                    calorie_consumed: [caloriesIntake]
                },
                success: function (response) {
                    console.log("Calories Calculation Response:", response);
                    if (response.total_calorie_intake !== null && response.total_calorie_intake !== undefined) {
                        $(".calories-burned-input").html(
                            `<div class="alert alert-success" role="alert">${response.calorie_consumed}</div>`
                        );
                        $(".total-calories-burned").html(
                            `<div class="alert alert-success" role="alert">${response.total_calorie_intake}</div>`
                        );
                    } else {
                        console.error("No calories_intake response:", response);
                        alert("Error: " + response.error);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                    console.error("Response Text:", xhr.responseText);
                }
            });
        } else {
            console.log("Waiting for all fields to be filled or data already submitted.");
        }
    }, 10000); // 500ms debounce delay
});

document.addEventListener("DOMContentLoaded", function(){
    fetch("displayLogs.php")
    .then(response => response.json())
    .then(data=>{
        const dietLogsBody = document.getElementById("diet-logs-body");
        const workoutLogsBody = document.getElementById("workout-logs-body");

        data.diet_logs.forEach(log => {
            const row = `
            <tr class="border-b">
                <td class="py-2 px-4 text-center">${log.log_date}</td>
                <td class="py-2 px-4 text-center">${log.meal}</td>
                <td class="py-2 px-4 text-center">${log.protein}g</td>
                <td class="py-2 px-4 text-center">${log.carbs}g</td>
                <td class="py-2 px-4 text-center">${log.fats}g</td>
                <td class="py-2 px-4 text-center">${log.calories_intake} kcal</td>
            </tr>`;
        dietLogsBody.innerHTML += row;
        });
        data.workout_logs.forEach(log => {
            const row = `
                <tr class="border-b">
                    <td class="py-2 px-4 text-center">${log.log_date}</td>
                    <td class="py-2 px-4 text-center">${log.name}</td>
                    <td class="py-2 px-4 text-center">${log.exercise_name}</td>
                    <td class="py-2 px-4 text-center">${log.met_value}</td>
                    <td class="py-2 px-4 text-center">${log.duration} min</td>
                </tr>`;
            workoutLogsBody.innerHTML += row;
        });
    }).catch(error => console.error("Error fetching logs:", error));
})
 
