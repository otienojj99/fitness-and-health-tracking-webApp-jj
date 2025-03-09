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
        html,
        body {
            overflow: auto;
            padding: 0;
            margin: 0;
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

        .contain {
            height: 100%;
            margin: 20px;
            box-shadow: 0 0 5px #262626;
            padding: 30px;
            border-radius: 30px;
        }

        .main-cont {
            height: 100%;
            width: 100%;
            justify-content: center;
            align-items: center;
            display: flex;
        }

        form {
            width: 100%;
            height: 100%;
            /* display: flex; */
        }

        .goals {
            height: 80px;
            background-color: #fff;
            color: black;
            font-size: 18px;
            font-weight: 900;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .goals input[type="checkbox"] {
            width: 20px;
            height: 20px;
            appearance: none;
            border: 1px solid #007BFF;
            border-radius: 4px;
            display: inline-block;
            position: relative;
        }

        .goals input[type="checkbox"]:checked {
            background-color: #007BFF;
        }

        .goals input[type="checkbox"]::before {
            content: "✔";
            font-size: 16px;
            color: white;
            position: absolute;
            left: 4px;
            top: -2px;
            display: none;
        }

        .goals input[type="checkbox"]:checked::before {
            display: block;
        }

        .btn {
            display: block;
            width: 150px;
            height: 40px;
            margin: 20px auto;
            border: 1px solid #ff004f;
            background-color: #3F46C0;
            border-radius: 20px;
            transition: background 0.5s;
            font-weight: 600;
            font-size: 17px;
            cursor: pointer;
        }

        select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #fff;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            appearance: none;
        }

        select:focus {
            outline: none;
            border-color: #007BFF;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        input[type="text"],
        input[type="number"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 10px;
            outline: none;
        }

        input[type="text"],
        input[type="number"] {
            border-color: #007BFF;
        }

        .form-cont {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        input[type="text"],
        input[type="number"] {
            border-color: #007BFF;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
    </style>
</head>

<body>
    <!-- <div class="header">
        <?php //include 'navbar.php' 
        ?>
    </div> -->
    <div class="main-cont">
        <div class="contain">
            <h2>Workout Plan Form</h2>
            <form action="save_workout.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <div style="display: flex; align-items: center; gap: 40px; ">
                    <label for="workout_name">Workout Name:</label><br>
                    <input type="text" id="workout_name" name="workout_name" required>

                    <div class="form-cont">

                        <div class="select-wrapper">
                            <label for="workout_type">Workout Type:</label>
                            <select id="workout_type" name="workout_type" required>
                                <option value="Strength & Cardio">Strength & Cardio</option>
                                <option value="Flexibility & Endurance">Flexibility & Endurance</option>
                            </select><br><br>
                        </div>
                    </div>
                </div>

                <label>Days per Week:</label><br>
                <div class="goals">
                    <input type="checkbox" name="days[]" value="Monday"> Monday
                    <input type="checkbox" name="days[]" value="Tuesday"> Tuesday
                    <input type="checkbox" name="days[]" value="Wednesday"> Wednesday
                    <input type="checkbox" name="days[]" value="Thursday"> Thursday
                    <input type="checkbox" name="days[]" value="Friday"> Friday
                    <input type="checkbox" name="days[]" value="Saturday"> Saturday
                    <input type="checkbox" name="days[]" value="Sunday"> Sunday
                </div>
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

                <label for="duration">Duration per Session (Minutes):</label><br>
                <input type="number" id="duration" name="duration" min="10" required><br><br>

                <label for="intensity">Intensity Level:</label>
                <div class="form-cont">
                    <div class="select-wrapper">
                        <select id="intensity" name="intensity" required>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select><br><br>
                    </div>
                </div>
                <button type="submit" class="btn">Save</button>
            </form>
        </div>
    </div>
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