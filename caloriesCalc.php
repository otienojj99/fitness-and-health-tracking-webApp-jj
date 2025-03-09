<?php
include 'config.php';

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
file_put_contents("debug_log.txt", "POST Data: " . print_r($_POST, true) . "\n", FILE_APPEND);
error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // error_log("REQUEST METHOD: " . print_r($_SERVER, true));
        // error_log("Received POST data in diet: " . print_r($_POST, true));
        if (!isset($_POST['user_id']) || empty($_POST['user_id'])) {
            // $user_id = $_POST['userId'];
            echo json_encode(["error" => "Diet ID is missing!"]);
            exit;
        }
        if (!isset($_POST['id']) || !is_array($_POST['id'])) {
            echo json_encode(["error" => "Missing or invalid 'id' array!"]);
            exit;
        }
        if (!isset($_POST['meal_name']) || empty($_POST['meal_name'])) {
            echo json_encode(["error" => "Meal name is missing!"]);
            exit;
        }


        if (
            !isset($_POST['protein']) || !is_array($_POST['protein']) ||
            !isset($_POST['carbs']) || !is_array($_POST['carbs']) ||
            !isset($_POST['fats']) || !is_array($_POST['fats'])
        ) {
            echo json_encode(["error" => "Invalid input data!"]);
            exit;
        }

        // $diet_id = $_POST['diet_id'];
        $user_id = $_POST['user_id'];
        $ids = $_POST['id'];
        $meal_names = [];

        $proteins = isset($_POST['protein']) ? $_POST['protein'] : [];
        $carbs = isset($_POST['carbs']) ? $_POST['carbs'] : [];
        $fats = isset($_POST['fats']) ? $_POST['fats'] : [];
        $calorie_intake_per_diet = [];
        $total_calorie_intake = 0;
        foreach ($ids as $index => $id) {
            $meal_name = isset($meal_names[$index]) ? $meal_names[$index] : null;
            $protein = isset($proteins[$index]) ? (int)$proteins[$index] : 0;
            $carb = isset($carbs[$index]) ? (int)$carbs[$index] : 0;
            $fat = isset($fats[$index]) ? (int)$fats[$index] : 0;


            $sql = "SELECT meal, protein, carbs, fats FROM diet_logs WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);
            $dietRow = $stmt->fetch(PDO::FETCH_ASSOC);


            file_put_contents("debug_log.txt", "Database values: " . print_r($dietRow, true) . "\n", FILE_APPEND);

            if (!$dietRow) {
                file_put_contents("debug_log.txt", "calorie value for  ID: $diet_id\n", FILE_APPEND);
                $calorie_consumed = 0;
                // continue;
            } else {
                $meal_name = $dietRow['meal']; // Assign meal name correctly
            }
            $calorie_consumed = ($protein * 4) + ($carb * 4) + ($fat * 9);

            // Update the calories_intake column in the database
            $insertQuery = "INSERT INTO calories_log (user_id, calories_intake) VALUES (?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->execute([$user_id, $calorie_consumed]);  // Correct order


            // $diets = $dietRow;
            // error_log("Received POST data in diet: " . print_r($diets, true));

            file_put_contents("debug_log.txt", "Protein: $protein, Carbs: $carb, Fats: $fat, Calories: $calorie_consumed\n", FILE_APPEND);
            if (empty($_POST['calories_intake'][0])) {
                $_POST['calories_intake'][0] = $calorie_consumed;
            }


            error_log("Calories Calculated in Backend: $calorie_consumed");
            error_log("Protein: $protein, Carbs: $carb, Fats: $fat, Calories: $calorie_consumed");
            file_put_contents("debug_met_calc.txt", "Calories consumed:$calorie_consumed\n", FILE_APPEND);
            $calorie_intake_per_diet[] = [
                "id" => $id,
                "meal" => $meal_name,
                "protein" => $protein,
                "carbs" => $carb,
                "fats" => $fat,
                "calorie_consumed" => round($calorie_consumed, 2)
            ];
            error_log("Received POST data in diet: " . print_r($calorie_intake_per_diet, true));
            // $calorie_intake_per_diet[] =   $calorie_consumed;
            $total_calorie_intake +=  $calorie_consumed;
            error_log("Received POST data in diet of total: " . print_r($total_calorie_intake, true));
        }
        echo json_encode([
            "calorie_consumed" => $calorie_consumed,
            "total_calorie_intake" => $total_calorie_intake,
            "calorie_intake_per_diet" => $calorie_intake_per_diet
        ]);
    } else {
        echo json_encode(["error" => "Method not allowed!"]);
    }
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
} catch (PDOException $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(["error" => "Error: " . $e->getMessage()]);
}
