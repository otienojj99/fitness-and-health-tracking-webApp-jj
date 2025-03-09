<?php
include 'config.php';

file_put_contents("debug_log.txt", "POST Data: " . print_r($_POST, true) . "\n", FILE_APPEND);
error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
try {
    header('Content-Type: application/json');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        error_log("Received POST dat: " . print_r($_SERVER['REQUEST_METHOD'], true));
        error_log("Received POST data of met_valued: " . print_r($_POST, true));
        if (!isset($_POST['user_id']) || empty($_POST['user_id'])) {
            echo (json_encode(["error" => "User ID is missing!"]));
            exit;
        }

        $user_id = $_POST['user_id'];
        $sql = "SELECT current_weight FROM goals WHERE user_id = ? order by created_at desc limit 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id]);
        $weightRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$weightRow || !isset($weightRow['current_weight'])) {
            echo (json_encode(["error" => "No weight data found for this user!"]));
            exit;
        }
        $current_weight = $weightRow['current_weight'];
        if (!isset($_POST['exercise_id']) || !is_array($_POST['exercise_id']) || empty($_POST['exercise_id'])) {
            error_log("Exercise IDs: " . print_r($_POST['exercise_id'], true));
            echo (json_encode(["error" => "Exercise is missing! or invalid!"]));
            exit;
        }
        if (!isset($_POST['duration']) || !is_array($_POST['duration']) || empty($_POST['duration'])) {
            echo json_encode(["error" => "Duration data is missing or invalid!"]);
            exit;
        }
        $exercise_ids = $_POST['exercise_id'];
        $durations = $_POST['duration'];
        $calories_per_exercise = [];
        $total_calories_burned = 0;



        foreach ($exercise_ids as $key => $exercise_id) {
            $duration = isset($durations[$key]) ? $durations[$key] : 0;
            $duration_in_hours = $duration / 60;


            $sql = "SELECT met_value FROM exercises WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$exercise_id]);
            $exerciseRow = $stmt->fetch(PDO::FETCH_ASSOC);


            if (!$exerciseRow) {
                file_put_contents("debug_log.txt", "No MET value found for Exercise ID: $exercise_id\n", FILE_APPEND);

                continue;
                // die(json_encode(["error" => "No exercise data found for this exercise!"]));
            }
            $met_value = $exerciseRow['met_value'];
            file_put_contents("debug_log.txt", "MET: $met_value, Weight: $current_weight, Duration (hours): $duration_in_hours\n", FILE_APPEND);
            if ($met_value == 0) {
                file_put_contents("debug_log.txt", "Invalid MET value for Exercise ID: $exercise_id\n", FILE_APPEND);
                continue;
            }


            $calories_burned = $met_value * $current_weight * $duration_in_hours;
            file_put_contents("debug_met_calc.txt", "Calories Burned: $calories_burned\n", FILE_APPEND);
            $calories_per_exercise[] = [
                "exercise_id" => $exercise_id,
                "met_value" => $met_value,
                "duration" => round($duration, 2),
                "calories_burned" => round($calories_burned, 2)
            ];
            $total_calories_burned += $calories_burned;
        }
        echo json_encode([
            "calories_burned" => round($calories_burned, 2),
            "total_calories_burned" => round($total_calories_burned, 2),
            "calories_per_exercise" => $calories_per_exercise
        ]);
    } else {
        echo json_encode(["error" => "Invalid request method!"]);
    }
} catch (PDOException $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(["error" => "Error: " . $e->getMessage()]);
}
