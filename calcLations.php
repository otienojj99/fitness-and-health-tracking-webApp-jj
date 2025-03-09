<?php
include 'config.php';
session_start();

header('Content-Type: application/json');

$user_id = $_GET['user_id'] ?? null;
if ($user_id) {
    echo json_encode(getTDEE($user_id, $conn));
} else {
    echo json_encode(["error" => "User ID is required"]);
}

function getTdee($user_id, $conn)
{

    $query = "SELECT gender, current_weight,height,age FROM goals WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return ["error" => "User not found"];
    }

    $query = "SELECT activity_factor FROM workout_logs WHERE user_id = ?  ORDER BY log_date DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute([$user_id]);
    $workout = $stmt->fetch(PDO::FETCH_ASSOC);

    $activity_factor = $workout ? $workout['activity_factor'] : 1.2;

    if ($user['gender'] == 'male') {
        $bmr = 10 * $user['current_weight'] + 6.25 * $user['height'] - 5 * $user['age'] + 5;
    } else {
        $bmr = 10 * $user['current_weight'] + 6.25 * $user['height'] - 5 * $user['age'] - 161;
    }
    $tdee = $bmr * $activity_factor;
    $weight = $user['current_weight'];
    $height = $user['height'];
    $age = $user['age'];
    $gender = $user['gender'];

    $height_in_meters = $height / 100;

    $bmi = $weight / ($height_in_meters ** 2);
    if ($bmi < 18.5) {
        $bmi_category = "Underweight";
    } elseif ($bmi >= 18.5 && $bmi < 24.9) {
        $bmi_category = "Normal weight";
    } elseif ($bmi >= 25 && $bmi < 29.9) {
        $bmi_category = "Overweight";
    } else {
        $bmi_category = "Obese";
    }
    return ["TDEE" => round($tdee, 2), "BMI" => round($bmi, 2), "BMI_CATEGORY" => $bmi_category];
}


// Get user_id from request