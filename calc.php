<?php
// function bMRCalc($weightInKg, $heightInCm, $age, $isMale, $activityPlanner){
//     switch($activityPlanner){
//         case 'sedentary':
//             $multipl = 1.2;
//             break;
//         case 'lightly_active':
//             $multipl = 1.375;
//             break;
//         case 'moderately_active':
//             $multipl = 1.55;
//             break;
//         case 'very_active':
//             $multipl = 1.725;
//             break;
//         case 'super_active':
//             $multipl = 1.9;
//             break;
//         default:
//         $multipl = 1.2;
//     }
//     if($isMale){
//         $bmr = (10 * $weightInKg) + (6.25 * $heightInCm) - (5 * $age) + 5;
//     } else{
//         $bmr = (10 * $weightInKg) + (6.25 * $heightInCm) - (5 * $age) - 161;
//     }

//     $tdee = $bmr *  $multipl;
//     return  $tdee;
// }

// $result = bMRCalc(50, 178, 20, true, 'very_active');
// echo $result;

function formatPhoneNumber($phoneNumber)
{
    // Remove any non-numeric characters
    $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

    // Ensure the phone number starts with '254'
    if (substr($phoneNumber, 0, 1) == '0') {
        $phoneNumber = '254' . substr($phoneNumber, 1);
    } elseif (substr($phoneNumber, 0, 3) != '254') {
        $phoneNumber = '254' . $phoneNumber;
    }

    return $phoneNumber;
}