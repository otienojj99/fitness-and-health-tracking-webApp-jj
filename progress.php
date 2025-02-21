<?php
include 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Error: User is not logged in. Please log in first.");
}

$stmt = $conn->query("SELECT * FROM exercise_categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Log Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.min.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    .entry-group {
        display: flex;
        gap: 10px;
        margin-bottom: 5px;
    }

    .remove-btn {
        background: red;
        color: white;
        border: none;
        padding: 5px;
        cursor: pointer;
    }
    </style>
</head>

<body>

    <h2>Progress Log Form</h2>
    <form action="save_progress.php" method="POST">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
        <label for="activity_type">Activity Type:</label>
        <select id="activity_type" name="activity_type" required>
            <option value="Workout">Workout</option>
            <option value="Diet">Diet</option>
        </select><br><br>

        <label for="log_date">Date & Time:</label>
        <input type="text" id="log_date" name="log_date" required><br><br>
        <div id="workout-section">
            <label>Workout Details:</label> <button type="button" id="addWorkout">+ Add Exercise</button><br>
            <div id="workoutList">
                <div class="entry-group">
                    <!-- <label for="categorySelect">Select Category:</label> -->
                    <select id="categorySelect">
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select id="exerciseSelect">
                        <option value="">Select Exercise</option>
                    </select>
                    <!-- <input type="" name="exercise[]" placeholder="Exercise Name" required> -->
                    <div class="reps-sets-fields" style="display: none;">
                        <input type="number" name="sets[]" placeholder="Sets" min="1" required>
                        <input type="number" name="reps[]" placeholder="Reps" min="1" required>
                    </div>
                    <div class="duration-field" style="display: none;">
                        <input type="number" name="duration[]" placeholder="Duration (min)" min="1" required>
                    </div>
                    <!-- <input type="number" name="calories_burned[]" placeholder="Calories Burned" min="0"> -->

                </div>
            </div>
            <label for="log_activityFactor">Activity Factor:</label>
            <select name="activityFactor" id="activityFactor">
                <option value="1.2">Sedentary (little or no exercise)</option>
                <option value="1.375">Lightly active (light exercise/sports 1-3 days/week)</option>
                <option value="1.55">Moderately active (moderate exercise/sports 3-5 days/week)</option>
                <option value="1.725">Very active (hard exercise/sports 6-7 days a week)</option>
                <option value="1.9">Super active (very hard exercise & physical job or 2x training)</option>
            </select>
        </div>
        <br>
        <!-- Display total calories banned -->

        <div id="diet-section" style="display: none;">
            <label>Diet Details:</label> <button type="button" id="addMeal">+ Add Meal</button><br>
            <div id="dietList">
                <div class="entry-group">
                    <input type="text" name="meal[]" placeholder="Meal Name">
                    <!-- <input type="number" name="calories_intake[]" placeholder="Calories" min="1" required> -->
                    <input type="number" name="protein[]" placeholder="Protein (g)" min="0">
                    <input type="number" name="carbs[]" placeholder="Carbs (g)" min="0">
                    <input type="number" name="fats[]" placeholder="Fats (g)" min="0">
                </div>
            </div>
        </div>
        <!-- Display total calories consumed -->
        <br>
        <button type="submit">Save Progress</button>
    </form>

    <script>
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
            let repsSetsExercises = ["Squats", "Calisthenics", "Upper body exercise, arm ergometer",
                "Resistance training", "Circuit training", "Slide board exercise, general"
            ];
            console.log("Selected Exercise Name:", exerciseName);

            if (repsSetsExercises.includes(exerciseName)) {
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
    </script>

</body>

</html>