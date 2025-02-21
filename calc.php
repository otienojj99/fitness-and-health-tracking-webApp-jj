<?php 
function bMRCalc($weightInKg, $heightInCm, $age, $isMale, $activityPlanner){
    switch($activityPlanner){
        case 'sedentary':
            $multipl = 1.2;
            break;
        case 'lightly_active':
            $multipl = 1.375;
            break;
        case 'moderately_active':
            $multipl = 1.55;
            break;
        case 'very_active':
            $multipl = 1.725;
            break;
        case 'super_active':
            $multipl = 1.9;
            break;
        default:
        $multipl = 1.2;
    }
    if($isMale){
        $bmr = (10 * $weightInKg) + (6.25 * $heightInCm) - (5 * $age) + 5;
    } else{
        $bmr = (10 * $weightInKg) + (6.25 * $heightInCm) - (5 * $age) - 161;
    }

    $tdee = $bmr *  $multipl;
    return  $tdee;
}

$result = bMRCalc(50, 178, 20, true, 'very_active');
echo $result;


?>