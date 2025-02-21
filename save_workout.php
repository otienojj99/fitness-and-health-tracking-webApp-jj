<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
    } else {
        die("Error: User ID is missing!");
    }
    // $user_id = $_POST['user_id'];
    $workout_name = isset($_POST['workout_name']) ? trim($_POST['workout_name']) : '';
    $workout_type = isset($_POST['workout_type']) ? trim($_POST['workout_type']) : '';
    $days = isset($_POST['days']) ? $_POST['days'] : [];
    $exercises = isset($_POST['exercises']) ? $_POST['exercises'] : [];
    $sets = isset($_POST['sets']) ? $_POST['sets'] : [];
    $reps = isset($_POST['reps']) ? $_POST['reps'] : [];
    $duration = isset($_POST['duration']) ? $_POST['duration'] : '';
    $intensity = isset($_POST['intensity']) ? $_POST['intensity'] : '';

    if (empty($workout_name) || empty($workout_type)  || empty($duration) || empty($intensity) || empty($duration)) {
        die("Error: All fields are required!");
        throw new Exception("Please fill all required fields.");
    }

    $conn->beginTransaction();

    try {
        $query = "INSERT INTO workout_plans(user_id, workout_name, workout_type,  duration, intensity) VALUES(:user_id, :workout_name, :workout_type,  :duration, :intensity)";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':user_id' => $user_id,
            ':workout_name' => $workout_name,
            ':workout_type' => $workout_type,
            ':duration' => $duration,
            ':intensity' => $intensity
        ]);

        $workout_id = $conn->lastInsertId();
        foreach ($days as $day) {
            $query = "INSERT INTO workout_days(workout_id, day) VALUES(:workout_id, :day)";
            $stmt = $conn->prepare($query);
            $stmt->execute([
                ':workout_id' => $workout_id,
                ':day' => $day
            ]);
        }
        for ($i = 0; $i < count($exercises); $i++) {
            if (empty($exercises[$i]) || empty($sets[$i]) || empty($reps[$i])) {
                echo "Error: All fields are required!";
            }
            $query = "INSERT INTO workout_exercises(workout_id, exercise_name, sets, reps) VALUES(:workout_id, :exercise_name, :sets, :reps)";
            echo "Inserting: " . $exercises[$i] . ", Sets: " . $sets[$i] . ", Reps: " . $reps[$i] . "<br>";
            $stmt = $conn->prepare($query);
            $stmt->execute([
                ':workout_id' => $workout_id,
                ':exercise_name' => htmlspecialchars(trim($exercises[$i])),
                ':sets' => intval($sets[$i]),
                ':reps' => intval($reps[$i])
            ]);
        }
        $conn->commit();
        echo "Workout plan saved successfully!";
        header('Location: dashbord.php');
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
        echo "Error: " . $e->getMessage();
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    error_log("DEBUG: Request Method: " . $_SERVER['REQUEST_METHOD']);
    echo "Error: Invalid request method!";
} else {
    error_log("DEBUG: Request Method: " . $_SERVER['REQUEST_METHOD']);
    error_log("DEBUG: POST Data: " . print_r($_POST, true));
    error_log("DEBUG: Session Data: " . print_r($_SESSION, true));
    die("Error: Invalid request");
    // print_r($_POST);
}
