<?php
include 'config.php';

try {
    if (isset($_GET['category_id']) && !empty($_GET['category_id'])) {
        $category_id = $_GET['category_id'];
        $sql = "SELECT id, name FROM exercises WHERE category_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo json_encode(["error" => "Failed to prepare statement."]);
            exit;
        }
        $stmt->bindParam(1, $category_id, PDO::PARAM_INT);
        $stmt->execute();
        $exercises = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($exercises);
    } else {
        echo json_encode([]);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}