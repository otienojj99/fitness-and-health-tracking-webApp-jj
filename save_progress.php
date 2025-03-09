<?php
include 'config.php';

// include 'met_calc.php';
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("Received POST data: " . print_r($_POST, true));
    if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
    } else {
        die("Error: User ID is missing!");
    }
    if (isset($_POST['exercise_id']) && !empty($_POST['exercise_id'])) {
        $exercise_id  = isset($_POST['exercise_id']) ?  array_map(fn($e) => htmlspecialchars(trim($e), ENT_QUOTES, 'UTF-8'), $_POST['exercise_id']) : [];
    } else {
        die("Error: Exercise ID is missing!");
    }

    // file_put_contents("debug_log.txt", print_r($_POST, true));
    $meals = isset($_POST['meal']) ? array_map(fn($m) => htmlspecialchars(trim($m), ENT_QUOTES, 'UTF-8'), $_POST['meal']) : [];
    $conn->beginTransaction();
    try {
        $activity_type = isset($_POST['activity_type']) ? htmlspecialchars(trim($_POST['activity_type'])) : '';
        $log_date = isset($_POST['log_date']) ? htmlspecialchars(trim($_POST['log_date'])) : '';
        if ($activity_type === "Workout") {
            $activityFactor = isset($_POST['activityFactor']) ? htmlspecialchars(trim($_POST['activityFactor']), ENT_QUOTES, 'UTF-8') : '';
            // $exercise = isset($_POST['exercise']) ? array_map(fn($x) => htmlspecialchars(trim($x), ENT_QUOTES, 'UTF-8'), $_POST['exercise']) : [];
            $sets = isset($_POST['sets']) ?  array_map(fn($s) => htmlspecialchars(trim($s), ENT_QUOTES, 'UTF-8'), $_POST['sets']) : [];
            $reps = isset($_POST['reps']) ? array_map(fn($r) => htmlspecialchars(trim($r), ENT_QUOTES, 'UTF-8'), $_POST['reps']) : [];
            $duration = isset($_POST['duration']) ?  array_map(fn($d) => htmlspecialchars(trim($d), ENT_QUOTES, 'UTF-8'), $_POST['duration']) : [];
            $calories_burned = isset($_POST['calories_burned']) ? array_map(fn($c) => htmlspecialchars(trim($c), ENT_QUOTES, 'UTF-8'), $_POST['calories_burned']) : [];
            error_log("Workout Log Debug: " . json_encode([
                "user_id" => $user_id,
                "log_date" => $log_date,
                "exercise_id" => $exercise_id,
                "sets" => $sets,
                "reps" => $reps,
                "duration" => $duration,
                "activityFactor" => $activityFactor,
                "calories_burned" => $calories_burned
            ]));


            $query = "INSERT INTO workout_logs(user_id,log_date,sets,reps,duration,activity_factor,calories_burned, exercise_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            for ($i = 0; $i < count($exercise_id); $i++) {
                $stmt->execute([
                    $user_id,
                    $log_date,
                    // $exercise[$i],
                    $sets[$i],
                    $reps[$i],
                    $duration[$i],
                    $activityFactor,
                    $calories_burned[$i],
                    $exercise_id[$i]

                    // $calories_burned
                    // $total_calories_burned
                ]);
            }
            error_log("Calories Burned: " . print_r($calories_burned, true));
            $conn->commit();
            echo json_encode(["success" => true, "message" => "Workout log saved successfully."]);
            // echo "Workout log saved successfully.";
        } elseif ($activity_type === "Diet") {
            $meals = isset($_POST['meal']) ? array_map(fn($m) => htmlspecialchars(trim($m), ENT_QUOTES, 'UTF-8'), $_POST['meal']) : [];
            // $calories_intake = isset($_POST['calories_intake']) ? $_POST['calories_intake'] : [];
            $protein = isset($_POST['protein']) ? array_map(fn($p) => htmlspecialchars(trim($p), ENT_QUOTES, 'UTF-8'), $_POST['protein']) : [];
            $carbs = isset($_POST['carbs']) ? array_map(fn($c) => htmlspecialchars(trim($c), ENT_QUOTES, 'UTF-8'), $_POST['carbs']) : [];
            $fats = isset($_POST['fats']) ? array_map(fn($f) => htmlspecialchars(trim($f), ENT_QUOTES, 'UTF-8'), $_POST['fats']) : [];
            $calories_consumed = isset($_POST['calories_intake']) ? array_map(fn($y) => htmlspecialchars(trim($y), ENT_QUOTES, 'UTF-8'), $_POST['calories_intake']) : [];
            // echo "Calories being inserted: " . $calories_consumed;
            if (count($meals) !== count($protein) || count($meals) !== count($carbs) || count($meals) !== count($fats) || count($meals) !== count($calories_consumed)) {
                echo json_encode(["error" => "Invalid input data: Array lengths do not match!"]);
                exit;
            }
            file_put_contents("debug_log.txt", "Calories Intake Array: " . print_r($calories_consumed, true), FILE_APPEND);


            $query = "INSERT INTO diet_logs(user_id, meal, calories_intake, protein, carbs, fats, log_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            for ($i = 0; $i < count($meals); $i++) {
                $stmt->execute([
                    $user_id,
                    $meals[$i],
                    $calories_consumed[$i],
                    $protein[$i],
                    $carbs[$i],
                    $fats[$i],
                    $log_date
                ]);
            }
            // echo "Diet log saved successfully.";
            echo json_encode(["success" => true, "message" => "Diet log saved successfully."]);
            $conn->commit();
        } else {
            die("Error: Invalid activity type!");
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
        // $conn->rollBack();
        // file_put_contents("db_error_log.txt", $e->getMessage());
        die("Error: " . $e->getMessage());
    }
}
