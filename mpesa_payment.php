<?php
include 'daraja_config.php';

function generateAccessToken()
{
    $credentials = base64_encode(CONSUMER_KEY . ':' . CONSUMER_SECRET);
    $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $curl_response = curl_exec($curl);
    $result = json_decode($curl_response);

    return $result->access_token;
}

function lipaNaMpesaOnline($amount, $phoneNumber, $accountReference, $transactionDesc)
{
    $accessToken = generateAccessToken();
    if (!$accessToken) {
        echo json_encode(["error" => "Failed to generate access token"]);
        exit;
    }
    $timestamp = date('YmdHis');
    $password = base64_encode(SHORTCODE . LIPA_NA_MPESA_ONLINE_PASSKEY . $timestamp);

    $curl_post_data = array(
        'BusinessShortCode' => SHORTCODE,
        'Password' => $password,
        'Timestamp' => $timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $amount,
        'PartyA' => $phoneNumber,
        'PartyB' => SHORTCODE,
        'PhoneNumber' => $phoneNumber,
        'CallBackURL' => LIPA_NA_MPESA_ONLINE_CALLBACK_URL,
        'AccountReference' => $accountReference,
        'TransactionDesc' => $transactionDesc
    );

    $data_string = json_encode($curl_post_data);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $accessToken));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

    $curl_response = curl_exec($curl);
    return json_decode($curl_response);
}