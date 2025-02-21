$(document).ready(function() {
    $(".reps-sets-fields, .duration-field").hide();

    function initializeEventListeners() {
        $("#categorySelect").change(function() {
            let categoryId = $(this).val();
            let exerciseSelect = $(this).closest(".entry-group").find("#exerciseSelect");
            let repsSetsFields = $(this).closest(".entry-group").find(".reps-sets-fields");
            let durationField = $(this).closest(".entry-group").find(".duration-field");
            console.log("Selected Category ID:", categoryId);
            exerciseSelect.html('<option value="">Select Exercise</option>');
            repsSetsFields.hide();
            durationField.hide();
            if (categoryId) {
                $.ajax({
                    url: "get_exersice.php",
                    type: "GET",
                    data: {
                        category_id: categoryId
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log("Received Data:", response); // Debugging log
                        if (response.length > 0) {
                            $.each(response, function(index, exercise) {
                                exerciseSelect.append('<option value="' +
                                    exercise
                                    .id +
                                    '" data-name="' + exercise.name
                                    .toLowerCase() + '">' + exercise.name +
                                    '</option>');
                            });
                        } else {
                            console.log("No exercises found for this category.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        console.error("Response Text:", xhr.responseText);
                    }
                })

            }
        });
    }

    initializeEventListeners();
})
$(document).ready(function() {
    $("#log_date").datepicker({
        dateFormat: 'yy-mm-dd'
    });

    $("#addWorkout").click(function() {
        $("#workoutList").append(`
            <div class="entry-group">
                <select id="categorySelect">
                <option value="">Select Category</option>
                <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <select id="exerciseSelect">
                <option value="">Select Exercise</option>
            </select>
            <div class="reps-sets-fields" style="display: none;">
                <input type="number" name="sets[]" placeholder="Sets" min="1" required>
                <input type="number" name="reps[]" placeholder="Reps" min="1" required>
            </div>
            <div class="duration-field" style="display: none;">
                <input type="number" name="duration[]" placeholder="Duration (min)" min="1" required>
            </div>
                <button type="button" class="remove-btn">X</button>
            </div>
        `);
    });

    $("#addMeal").click(function() {
        $("#dietList").append(`
            <div class="entry-group">
                <input type="text" name="meal[]" placeholder="Meal Name" required>
                <input type="number" name="calories_intake[]" placeholder="Calories" min="1" required>
                <input type="number" name="protein[]" placeholder="Protein (g)" min="0">
                <input type="number" name="carbs[]" placeholder="Carbs (g)" min="0">
                <input type="number" name="fats[]" placeholder="Fats (g)" min="0">
                <button type="button" class="remove-btn">X</button>
            </div>
        `);
    });

    $(document).on("click", ".remove-btn", function() {
        $(this).closest(".entry-group").remove();
    });
    $(document).off("change", "#exerciseSelect").on("change", "#exerciseSelect", function() {
        let selectedExercise = $(this).find("option:selected");
        let exerciseName = selectedExercise.text();
        let repsSetsFields = $(this).closest(".entry-group").find(".reps-sets-fields");
        let durationField = $(this).closest(".entry-group").find(".duration-field");
        console.log("Selected Exercise Name:", exerciseName);

        if (exerciseName === "Squats" || exerciseName === "Calisthenics (e.g., sit-ups, abdominal crunches), light effort" || exerciseName ===
            "Upper body exercise, arm ergometer" ||
            exerciseName === "Resistance training" || exerciseName ===
            "Circuit training" || exerciseName === "Slide board exercise, general") {
            repsSetsFields.show();
            durationField.hide();
        } else {
            repsSetsFields.hide();
            durationField.show();
        }
    });

    $("#activity_type").change(function() {
        let selectedType = $(this).val();
        if (selectedType === "Workout") {
            $("#workout-section").show();
            $("#diet-section").hide();
            $("#workout-section input").attr("required", true);
            $("#diet-section input").removeAttr("required");
        } else if (selectedType === "Diet") {
            $("#diet-section").show();
            $("#workout-section").hide();
            // $("#workout-section input").removeAttr("required");
            $("#diet-section input").attr("required", true);
            $("#workout-section input").removeAttr("required");
        } else {
            $("#workout-section").hide();
            $("#diet-section").hide();
            $("#workout-section input, #diet-section input").removeAttr("required");
        }
    });
});