<?php
include 'config.php';

$query = "SELECT 
g.user_id, 
g.age, 
g.gender, 
g.current_weight, 
g.height, 
w.activity_factor,  -- Now fetching activity_level from workout_logs
c.calories_intake, d.protein, d.carbs, d.fats
FROM goals g
JOIN user_registration u ON u.UserId = g.user_id
JOIN workout_logs w ON w.user_id = g.user_id
JOIN diet_logs d ON d.user_id = g.user_id
JOIN calories_log c ON c.user_id = g.user_id;
";


$stmt = $conn->prepare($query);
$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Convert to JSON format for Python
echo json_encode($data);