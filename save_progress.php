<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
        // $exercise_id = $_POST['exercise_id'];
    } else {
        die("Error: User ID is missing!");
    }
    // if (isset($_POST['exercise_id']) && !empty($_POST['exercise'])) {
    //     $exercise_id = $_POST['exercise_id'];
    // } else {
    //     die("Error: Exercise ID is missing!");
    // }
    $meals = isset($_POST['meal']) ? array_map(fn($m) => htmlspecialchars(trim($m), ENT_QUOTES, 'UTF-8'), $_POST['meal']) : [];
    $conn->beginTransaction();
    try {
        $activity_type = isset($_POST['activity_type']) ? htmlspecialchars(trim($_POST['activity_type'])) : '';
        $log_date = isset($_POST['log_date']) ? htmlspecialchars(trim($_POST['log_date'])) : '';
        if ($activity_type === "Workout") {
            $activityFactor = isset($_POST['activityFactor']) ? htmlspecialchars(trim($_POST['activityFactor']), ENT_QUOTES, 'UTF-8') : '';
            $exercise = isset($_POST['exercise']) ? array_map(fn($x) => htmlspecialchars(trim($x), ENT_QUOTES, 'UTF-8'), $_POST['exercise']) : [];
            $sets = isset($_POST['sets']) ?  array_map(fn($s) => htmlspecialchars(trim($s), ENT_QUOTES, 'UTF-8'), $_POST['sets']) : [];
            $reps = isset($_POST['reps']) ? array_map(fn($r) => htmlspecialchars(trim($r), ENT_QUOTES, 'UTF-8'), $_POST['reps']) : [];
            $duration = isset($_POST['duration']) ?  array_map(fn($d) => htmlspecialchars(trim($d), ENT_QUOTES, 'UTF-8'), $_POST['duration']) : [];
            $exercise_id  = isset($_POST['exercise_id']) ?  array_map(fn($e) => htmlspecialchars(trim($e), ENT_QUOTES, 'UTF-8'), $_POST['exercise_id']) : [];
            $query = "INSERT INTO workout_logs(user_id,log_date,exercise,sets,reps,duration,activity_factor, exercise_id) VALUES (?, ?, ?, ?, ?, ?, ?,?)";
            $stmt = $conn->prepare($query);
            for ($i = 0; $i < count($exercise); $i++) {
                $stmt->execute([
                    $user_id,
                    $log_date,
                    $exercise[$i],
                    $sets[$i],
                    $reps[$i],
                    $duration[$i],
                    $activityFactor,
                    $exercise_id[$i]
                ]);
                $conn->commit();
                echo "Workout log saved successfully.";
            }
        } elseif ($activity_type === "Diet") {
            $meals = isset($_POST['meal']) ? array_map(fn($m) => htmlspecialchars(trim($m), ENT_QUOTES, 'UTF-8'), $_POST['meal']) : [];
            // $calories_intake = isset($_POST['calories_intake']) ? $_POST['calories_intake'] : [];
            $protein = isset($_POST['protein']) ? array_map(fn($p) => htmlspecialchars(trim($p), ENT_QUOTES, 'UTF-8'), $_POST['protein']) : [];
            $carbs = isset($_POST['carbs']) ? array_map(fn($c) => htmlspecialchars(trim($c), ENT_QUOTES, 'UTF-8'), $_POST['carbs']) : [];
            $fats = isset($_POST['fats']) ? array_map(fn($f) => htmlspecialchars(trim($f), ENT_QUOTES, 'UTF-8'), $_POST['fats']) : [];

            $query = "INSERT INTO diet_logs(diet_id, meal, protein, carbs, fats, log_date) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            for ($i = 0; $i < count($meals); $i++) {
                $stmt->execute([
                    $user_id,
                    $meals[$i],
                    $protein[$i],
                    $carbs[$i],
                    $fats[$i],
                    $log_date
                ]);

                echo "Diet log saved successfully.";
            }
        } else {
            die("Error: Invalid activity type!");
        }
    } catch (PDOException $e) {
        // $conn->rollBack();
        die("Error: " . $e->getMessage());
    }
}