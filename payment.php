<?php
session_start();
include 'config.php';
$paypal = include 'paypal_config.php';
include 'mpesa_payment.php';
include 'calc.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}
$user_id = $_SESSION['user_id'];
$plan = $data['plan'] ?? 'Standard';
$payment_method = $data['payment_method'] ?? '';
$amount = ($plan == 'Advanced') ? 20.00 : 10.00;
$email = $data['email'] ?? "";
$payment_status = 'Pending';
$full_name = $data['name'] ?? '';


try {
    if ($payment_method === 'Paypal') {

        $email = $data['email'] ?? "";
        $query = "INSERT INTO payments (user_id, plan, payment_method, amount, email, payment_status) 
    VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$user_id, $plan, $payment_method, $amount, $email, $payment_status]);

        echo json_encode(["success" => "Payment processed successfully"]);
    } elseif ($payment_method === 'Mpesa') {
        if (!isset($data['mpesa_contact']) || empty($data['mpesa_contact'])) {
            echo json_encode(["error" => "Phone number is required for Mpesa payment"]);
            exit;
        }

        $phone = formatPhoneNumber($data['mpesa_contact']);
        $transactionDesc = "Payment for " . $plan . " fitness plan";
        $accountReference = "FitnessSubscription";
        $mpesa_response = lipaNaMpesaOnline($amount, $phone, $accountReference, $transactionDesc);



        // echo '<pre>';
        // print_r($mpesa_response);
        // echo '</pre>';

        // Save Mpesa payment
        $query = "INSERT INTO payments (user_id, plan, payment_method, amount, name, contact_number, payment_status) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$user_id, $plan, $payment_method, $amount, $full_name, $phone, $payment_status]);

        echo json_encode([
            "mpesa_response" => $mpesa_response,
            "success" => "Payment processed successfully"
        ]);
    } else {
        echo json_encode(['error' => 'Invalid payment method']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
