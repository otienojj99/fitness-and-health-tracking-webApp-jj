<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Error: User is not logged in. Please log in first.");
}
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Plan Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .exercise-group {
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
    <h2>Workout Plan Form</h2>
    <form action="save_workout.php" method="POST">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
        <label for="workout_name">Workout Name:</label>
        <input type="text" id="workout_name" name="workout_name" required><br><br>

        <label for="workout_type">Workout Type:</label>
        <select id="workout_type" name="workout_type" required>
            <option value="Strength & Cardio">Strength & Cardio</option>
            <option value="Flexibility & Endurance">Flexibility & Endurance</option>
        </select><br><br>

        <label>Days per Week:</label><br>
        <input type="checkbox" name="days[]" value="Monday"> Monday
        <input type="checkbox" name="days[]" value="Tuesday"> Tuesday
        <input type="checkbox" name="days[]" value="Wednesday"> Wednesday
        <input type="checkbox" name="days[]" value="Thursday"> Thursday
        <input type="checkbox" name="days[]" value="Friday"> Friday
        <input type="checkbox" name="days[]" value="Saturday"> Saturday
        <input type="checkbox" name="days[]" value="Sunday"> Sunday
        <br><br>

        <label>Exercises:</label> <button type="button" id="addExercise">+ Add Exercise</button><br>
        <div id="exerciseList">
            <div class="exercise-group">
                <input type="text" name="exercises[]" placeholder="Exercise Name" required>
                <input type="number" name="sets[]" placeholder="Sets" min="1" required>
                <input type="number" name="reps[]" placeholder="Reps" min="1" required>
            </div>
        </div>
        <br>

        <label for="duration">Duration per Session (Minutes):</label>
        <input type="number" id="duration" name="duration" min="10" required><br><br>

        <label for="intensity">Intensity Level:</label>
        <select id="intensity" name="intensity" required>
            <option value="Low">Low</option>
            <option value="Medium">Medium</option>
            <option value="High">High</option>
        </select><br><br>
        <button type="submit">Save Workout Plan</button>
    </form>

    <script>
        $(document).ready(function() {
            $("#addExercise").click(function() {
                $("#exerciseList").append(`
                    <div class="exercise-group">
                        <input type="text" name="exercises[]" placeholder="Exercise Name" required>
                        <input type="number" name="sets[]" placeholder="Sets" min="1" required>
                        <input type="number" name="reps[]" placeholder="Reps" min="1" required>
                        <button type="button" class="remove-btn">X</button>
                    </div>
                `);
            });

            $(document).on("click", ".remove-btn", function() {
                $(this).closest(".exercise-group").remove();
            });
        });
    </script>

</body>

</html>