<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id']; // Assuming user is logged in
$response = [];

try {
    $workout_query = "SELECT w.log_date, w.sets, w.reps, w.duration, w.activity_factor, w.calories_burned, 
       e.name AS exercise_name, e.met_value, 
       c.name
       FROM workout_logs w
       INNER JOIN exercises e ON w.exercise_id = e.id
       INNER JOIN exercise_categories c ON e.category_id = c.id
       WHERE w.user_id = ?
       ORDER BY w.log_date DESC
         LIMIT 5";

    $stmt = $conn->prepare($workout_query);
    $stmt->execute([$user_id]);
    $response['workout_logs'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $diet_query = "SELECT meal, calories_intake, protein, carbs, fats, log_date FROM diet_logs WHERE diet_id = ? ORDER BY log_date DESC LIMIT 5 ";
    $stmt = $conn->prepare($diet_query);
    $stmt->execute([$user_id]);
    $response['diet_logs'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($response);
} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
