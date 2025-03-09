<?php
include 'config.php';
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}
$user_id = $_SESSION['user_id'];
// var_dump($_SESSION);
// exit;
if ($user_id) {
    $query = "SELECT target_date FROM goals WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$user_id]);
    $goal = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($goal) {
        $targetDate = strtotime($goal['target_date']);
        $currentDate = time();
        $daysRemaining = ceil(($currentDate - $targetDate) / 86400);


        if ($daysRemaining == 0) {
            echo json_encode(["reminder" => "Your target date has been reached! Set up new fitness goals."]);
        } else {
            echo json_encode(["reminder" => "You have $daysRemaining days left to reach your goal!"]);
        }
    } else {
        echo json_encode(["error" => "No goals found."]);
    }
} else {
    echo json_encode(["error" => "User not logged in"]);
}