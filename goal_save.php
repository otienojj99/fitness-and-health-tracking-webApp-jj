<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
    } else {
        die("Error: User ID is missing!");
    }


    // $user_id = (int) $_POST['user_id'];
    $weight_loss = isset($_POST['weightLoss']) ? 1 : 0;
    $muscle_gain = isset($_POST['muscleGain']) ? 1 : 0;
    $endurance = isset($_POST['endurance']) ? 1 : 0;
    $general_fitness = isset($_POST['generalFitness']) ? 1 : 0;

    $pushups = isset($_POST['pushups']) ? htmlspecialchars(trim($_POST['pushups']), ENT_QUOTES, 'UTF-8') : '';
    $squats = isset($_POST['squats']) ? htmlspecialchars(trim($_POST['squats']), ENT_QUOTES, 'UTF-8') : '';
    $weight_loss_goal = isset($_POST['b-workout']) ? htmlspecialchars(trim($_POST['b-workout']), ENT_QUOTES, 'UTF-8') : '';
    $muscle_gain_goal = isset($_POST['m-workout']) ? htmlspecialchars(trim($_POST['m-workout']), ENT_QUOTES, 'UTF-8') : '';
    $running_distance = isset($_POST['r-workout']) ? htmlspecialchars(trim($_POST['r-workout']), ENT_QUOTES, 'UTF-8') : '';
    $jump_rope = isset($_POST['j-workout']) ? htmlspecialchars(trim($_POST['j-workout']), ENT_QUOTES, 'UTF-8') : '';
    $water_intake = isset($_POST['h-water']) ? htmlspecialchars(trim($_POST['h-water']), ENT_QUOTES, 'UTF-8') : '';
    $healthy_nutrition = isset($_POST['h-food']) ? htmlspecialchars(trim($_POST['h-food']), ENT_QUOTES, 'UTF-8') : '';
    $current_weight = isset($_POST['current_weight']) ? htmlspecialchars(trim($_POST['current_weight']), ENT_QUOTES, 'UTF-8') : '';
    $current_strength = isset($_POST['current_strength']) ? htmlspecialchars(trim($_POST['current_strength']), ENT_QUOTES, 'UTF-8') : '';
    $height = isset($_POST['height']) ? htmlspecialchars(trim($_POST['height']), ENT_QUOTES, 'UTF-8') : '';
    $age = isset($_POST['age']) ? htmlspecialchars(trim($_POST['age']), ENT_QUOTES, 'UTF-8') : '';
    $current_running = isset($_POST['current_running']) ? htmlspecialchars(trim($_POST['current_running']), ENT_QUOTES, 'UTF-8') : '';
    $target_date = isset($_POST['target_date']) ? htmlspecialchars(trim($_POST['target_date']), ENT_QUOTES, 'UTF-8') : null;
    $payment_plan = isset($_POST['plan']) ? htmlspecialchars(trim($_POST['plan']), ENT_QUOTES, 'UTF-8') : '';
    $gender = isset($_POST['gender']) ? htmlspecialchars(trim($_POST['gender']), ENT_QUOTES, 'UTF-8') : '';
    $valid_genders = ['Male', 'Female'];
    if (!in_array($gender, $valid_genders)) {
        die("Invalid gender selection.");
    }

    try {
        $query = "INSERT INTO goals(user_id, weight_loss, muscle_gain, endurance,
               general_fitness, pushups_goal, squats_goal, weight_loss_target,
               muscle_gain_target, running_distance, jump_rope_goal, water_intake, healthy_nutrition,
               current_weight, current_strength, age, height, current_running, target_date, gender,
               payment_plan
            )VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $stmt = $conn->prepare($query);
        $stmt->execute([
            $user_id,
            $weight_loss,
            $muscle_gain,
            $endurance,
            $general_fitness,
            $pushups,
            $squats,
            $weight_loss_goal,
            $muscle_gain_goal,
            $running_distance,
            $jump_rope,
            $water_intake,
            $healthy_nutrition,
            $current_weight,
            $current_strength,
            $age,
            $height,
            $current_running,
            $target_date,
            $gender,
            $payment_plan
        ]);
        echo "Goal data successfully inserted!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
