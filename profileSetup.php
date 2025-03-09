<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Error: User is not logged in. Please log in first.");
}
$user_id = $_SESSION['user_id'];
// include 'goal_save.php'
// if (!isset($_SESSION['User_id'])) {
//     header('Location: login.php');
//     exit;
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <title>Document</title>
</head>
<style>
    html,
    body {
        overflow: auto;
        padding: 0;
        margin: 0;
    }

    .contain {
        height: 100%;
        margin: 20px;
        box-shadow: 0 0 5px #262626;
        padding: 30px;
        border-radius: 30px;
    }

    .main-cont {
        height: 100%;
        width: 100%;
        justify-content: center;
        align-items: center;
        display: flex;
    }

    form {
        width: 100%;
        height: 100%;
        /* display: flex; */
    }

    .goals {
        height: 80px;
        background-color: #fff;
        color: black;
        font-size: 18px;
        font-weight: 900;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .goals input[type="checkbox"] {
        width: 20px;
        height: 20px;
        appearance: none;
        border: 1px solid #007BFF;
        border-radius: 4px;
        display: inline-block;
        position: relative;
    }

    .goals input[type="checkbox"]:checked {
        background-color: #007BFF;
    }

    .goals input[type="checkbox"]::before {
        content: "✔";
        font-size: 16px;
        color: white;
        position: absolute;
        left: 4px;
        top: -2px;
        display: none;
    }

    .goals input[type="checkbox"]:checked::before {
        display: block;
    }

    .form-cont {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    select {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        background-color: #fff;
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        appearance: none;
    }

    .select-wrapper {
        position: relative;
    }

    .select-wrapper::after {
        content: "▼";
        font-size: 14px;
        color: black;
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translate(-50%);
        pointer-events: none;
    }

    label {
        font-weight: 500;
    }

    select:hover {
        border-color: #007BFF;
    }

    select:focus {
        outline: none;
        border-color: #007BFF;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    input[type="text"],
    input[type="number"] {
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 10px;
        outline: none;
    }

    input[type="text"],
    input[type="number"] {
        border-color: #007BFF;
    }

    input[type="text"],
    input[type="number"] {
        border-color: #007BFF;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .input-wrapper {
        position: relative;
        width: 100%;
    }

    .input-wrapper input {
        width: 80%;
        padding: 10px 40px 10px 10px;
        /*Leave space for the icon */
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .input-wrapper i {
        position: absolute;
        right: 80px;
        top: 70%;
        transform: translateY(-50%);
        color: #cc5500;
    }

    .input-wrapper {
        margin-bottom: 15px;
    }

    /* .input-wrapper label{} */
    .input-wrapper input {
        padding: 10px;
    }

    form textarea {
        width: 80%;
        /* border: 0; */
        outline: none;
        /* background: #262626; */
        padding: 15px;
        border: 1px solid #ccc;
        margin: 15px 0;
        color: #262626;
        font-size: 18px;
        border-radius: 6px;
        resize: none;

    }

    .popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
    }

    button {
        display: block;
        width: 150px;
        height: 40px;
        margin: 20px auto;
        border: 1px solid #ff004f;
        background-color: #3F46C0;
        border-radius: 20px;
        transition: background 0.5s;
        font-weight: 600;
        font-size: 17px;
        cursor: pointer;
    }
</style>

<body>
    <!-- <div class="header">
        <?php //include 'navbar.php' 
        ?>
    </div> -->

    <div class="main-cont">
        <div class="contain">
            <form action="goal_save.php" method="POST" id="goalForm">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <h3>Select yous goals</h3>
                <div class="goals">
                    <label for="wt">Weight Loss</label>
                    <input type="checkbox" name="weightLoss" id="WeightLoss" value="Weight Loss">
                    <label for="mg">Muscle Gain</label>
                    <input type="checkbox" name="muscleGain" id="MuscleGain" value="Muscle Gain">
                    <label for="ed">Endurance</label>
                    <input type="checkbox" name="endurance" id="endurance" value="Endurance">
                    <label for="gf">General Fitness</label>
                    <input type="checkbox" name="generalFitness" id="generalFitness" value="General Fitness">
                    <!-- <label for="wt">Weight Loss</label>
                    <input type="checkbox" name="WeightLoss" id="WeightLoss"><br> -->
                </div>
                <div>
                    <h3> Fitness & Strength Goals</h3>
                    <div class="form-cont">
                        <div class="select-wrapper" style="width: 43%;">
                            <label for="fitness">Push-Ups</label>
                            <select id="goal_type" name="goal_type">
                                <option value="">Select Push-ups goals</option>
                                <option value="5 pushups/day">5 pushups/day</option>
                                <option value="10 pushups/day">10 pushups/day</option>
                                <option value="20 pushups/day">20 pushups/day</option>
                                <option value="30 pushups/day">30 pushups/day</option>
                                <option value="40 pushups/day">40 pushups/day</option>
                                <option value="50 pushups/day">50 pushups/day</option>
                                <option value="grater">50 to 100 pushups/day</option>
                                <option value="greatest">More than 100 pushups/day</option>
                            </select> <br>
                        </div>
                        <div class="select-wrapper">
                            <label for="squats">Squats(Optional)</label>
                            <select name="squats" id="squats">
                                <option value="">Select a Your squats(Optional)</option>
                                <option value="10 squats/week">10 squats/week</option>
                                <option value="20 squats/week">20 squats/week</option>
                                <option value="30 squats/week">30 squats/week</option>
                                <option value="40 squats/week">40 squats/week</option>
                                <option value="50 squats/week">50 squats/week</option>
                                <option value="Morethan 50 squats/week">Morethan 50 squats/week</option>
                            </select> <br>
                        </div>
                    </div>
                    <h3>Weight & Body Composition Goals</h3>
                    <div class="form-cont">
                        <div class="select-wrapper" style="width: 43%;">
                            <label for="">Weight Loss</label>
                            <select name="b-workout" id="b-workout">
                                <option value="">Select(Optional)</option>
                                <option value="2kg in a mounth">2kg in a mounth</option>
                                <option value="4kg in a mounth">4kg in a mounth</option>
                                <option value="6kg in a mounth">6kg in a mounth</option>
                                <option value="8kg in a mounth">8kg in a mounth</option>
                                <option value="10kg in a mounth">10kg in a mounth</option>
                                <option value="more than 10kg in a mounth">more than 10kg in a mounth</option>
                            </select>
                        </div>
                        <div class="select-wrapper" style="width: 48%;">
                            <label for="">Muscle Gain</label>
                            <select name="m-workout" id="m-workout">
                                <option value="">Select (Optional)</option>
                                <option value="2kg in a mounth">2kg in a mounth</option>
                                <option value="4kg in a mounth">4kg in a mounth</option>
                                <option value="6kg in a mounth">6kg in a mounth</option>
                                <option value="8kg in a mounth">8kg in a mounth</option>
                                <option value="10kg in a mounth">10kg in a mounth</option>
                                <option value="more than 10kg in a mounth">more than 10kg in a mounth</option>
                            </select>
                        </div>
                    </div>
                    <h3>🏃 Running & Endurance Goals</h3>
                    <div class="form-cont">
                        <div class="select-wrapper" style="width: 43%;">
                            <label for="">Running Distance</label>
                            <select name="r-workout" id="r-workout">
                                <option value="">Select(Optional)</option>
                                <option value="1km">1km</option>
                                <option value="2km">2km</option>
                                <option value="3km">3km</option>
                                <option value="4km">4km </option>
                                <option value="Above 5km">Above 5km</option>
                            </select>
                        </div>
                        <div class="select-wrapper" style="width: 48%;">
                            <!-- <h3>Jump Rope </h3> -->
                            <label for="">Jump Rope</label>
                            <select name="j-workout" id="j-workout">
                                <option value="">Select(Optional)</option>
                                <option value="10 jumps/day">10 jumps/day</option>
                                <option value="20 jumps/day">20 jumps/day</option>
                                <option value="30 jumps/day">30 jumps/day</option>
                                <option value="40 jumps/day">40 jumps/day </option>
                                <option value="50 jumps/day">50 jumps/day</option>
                                <option value="Above 100 jumps/day">Above 100 jumps/day</option>
                            </select>
                        </div>
                    </div>
                    <h3>🍎 Nutrition & Lifestyle Goals</h3>
                    <div class="form-cont">
                        <div class="select-wrapper" style="width: 43%;">
                            <label for="">Water Intake</label>
                            <select name="h-water" id="h-water" required>
                                <option value="">Select</option>
                                <option value="1L per day">1L per day</option>
                                <option value="2L per day">2L per day</option>
                                <option value="3L per day">3L per day</option>
                                <option value="4L per day">4L per day </option>
                                <option value="5L per day">5L per day</option>
                                <option value="Above 5L per day">Above 5L per day</option>
                            </select>

                        </div>
                        <div class="select-wrapper" style="width: 48%;">
                            <label for="">Healthy Nutrition</label>
                            <select name="h-food" id="h-food" required>
                                <option value="">Select</option>
                                <option value="1 week">1 week</option>
                                <option value="2 week">2 weeks</option>
                                <option value="1 month">1 month</option>
                                <option value="2 months">2 months </option>
                                <option value="5 months">5 months</option>
                                <option value="Above 6 months">Above 6 months</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <h3>Current Weight & Strength Level</h3>
                        <div class="form-cont">
                            <div class="input-wrapper">
                                <label for="current_weight">Current Weight (kg):</label> <br>
                                <input type="text" id="current_weight" name="current_weight" min="1" step="0.1"
                                    placeholder="Current Weight (kg)" required>
                                <i class="fas fa-dumbbell"></i>
                            </div>
                            <div class="input-wrapper">
                                <label for="current_strength"> Current Strength Level (kg):</label>
                                <input type="text" id="current_strength" name="current_strength" min="1" step="0.5"
                                    placeholder="Current Strength Level (kg)"> <br>
                                <i class="fas fa-dumbbell"></i>
                            </div>
                        </div>
                        <h3>Age and Height</h3>
                        <div class="form-cont">
                            <div class="input-wrapper">
                                <label for="current_weight">Age:</label> <br>
                                <input type="text" id="age" name="age" min="1" step="0.1" placeholder="Age">
                            </div>
                            <div class="input-wrapper">
                                <label for="current_strength">Height:</label>
                                <input type="text" id="height" name="height" min="1" step="0.5" placeholder="Height">
                                <br>
                            </div>
                        </div>
                        <h3>Current Running & Target Date</h3>
                        <div class="form-cont">
                            <div class="input-wrapper">
                                <label for="current_running"> Current Running Distance (km):</label>
                                <input type="number" id="current_running" name="current_running" min="1" step="0.1"><br>
                                <i class="fas fa-person-running"></i>
                            </div>
                            <div class="input-wrapper">
                                <label for="target_date"> Target Date:</label> <br>
                                <input type="text" id="target_date" name="target_date" required>
                                <i class="fas fa-calendar-alt"></i>

                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <h3>Gender</h3>
                    <label for="male">Male</label>
                    <input type="radio" id="gender" name="gender" value="Male" required>
                    <label for="female">Female</label>
                    <input type="radio" id="gender" name="gender" value="Female" required>
                </div>
                <div>
                    <h3>Payment plan</h3>
                    <label for="Free_plan">Free plan</label>
                    <input type="radio" id="free" name="plan" value="free">
                    <label for="Free_plan">Starndard</label>
                    <input type="radio" id="starndard" name="plan" value="starndard" required>
                    <label for="Free_plan">Advance</label>
                    <input type="radio" id="advanced" name="plan" value="advanced" required>
                </div>

                <button type="submit">Save Goal</button>
            </form>
        </div>

        <div class="overlay" id="overlay">
            <div class="popup" id="payment_popup">
                <h3 id="planTitle"></h3>
                <p id="planDesc"></p>
                <label><input type="radio" name="payment" value="mpesa"> Mpesa</label>
                <div id="paypal-button-container1">
                    <label><input type="radio" name="payment" value="paypal"> PayPal</label>
                </div>
                <div id="mpesaFields" style="display:none;">
                    <input type="text" id="mpesaName" name="name" placeholder="Full Name">
                    <input type="text" id="mpesaNumber" name="mpesa_contact" placeholder="Mpesa Number">

                </div>
                <!-- <button id="confirmPayment" disabled>Proceed</button> -->

                <div id="paypal-container" style="display:none;">
                    <?php include 'payment_ui.php'; ?>
                </div>

                <button id="confirmPayment" disabled>Proceed</button>
            </div>


        </div>

    </div>

    <!-- <script src="https://www.paypal.com/sdk/js?client-id=YOUR_PAYPAL_CLIENT_ID"></script> -->
    <script>
        $(document).ready(function() {
            $("#target_date").datepicker({
                dateFormat: "yy-mm-dd", // Format for database storage (YYYY-MM-DD)
                minDate: 0, // Prevent users from selecting past dates
                changeMonth: true, // Allow month selection
                changeYear: true // Allow year selection
            });
        });

        const form = document.getElementById('goalForm');
        const popup = document.getElementById('payment_popup');
        const overlay = document.getElementById('overlay');
        const planTitle = document.getElementById('planDesc');
        const planDesc = document.getElementById('planDesc');
        const mpesaFields = document.getElementById('mpesaFields');
        const paymentOptions = document.querySelectorAll('input[name="payment"]');
        const confirmBtn = document.getElementById('confirmPayment');
        const paypalContainer = document.getElementById('paypal-container');

        confirmBtn.disabled = true;

        form.addEventListener('submit', function() {
            const selectedPlan = document.querySelector('input[name="plan"]:checked').value;
            if (selectedPlan === 'free') {
                alert('Goals saved! Redirecting to dashboard...');
            } else {
                event.preventDefault();
                popup.style.display = 'block';
                overlay.style.display = 'block';
                planTitle.innerText = selectedPlan.toUpperCase() + ' Plan';
                planDesc.innerText = 'You have selected the ' + selectedPlan +
                    ' plan. Choose a payment method below:';
            }

        });
        paymentOptions.forEach(option => {
            option.addEventListener('change', function() {
                confirmBtn.disabled = false;
                if (this.value === 'mpesa') {
                    mpesaFields.style.display = 'block';
                    paypalContainer.style.display = 'none'; // Hide PayPal buttons
                    confirmBtn.style.display = 'block';

                } else if (this.value === 'paypal') {
                    paypalContainer.style.display = 'block';
                    mpesaFields.style.display = 'none'; // Hide Mpesa fields
                    confirmBtn.style.display = 'none';
                }
            });
        });

        confirmBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const selectedPlanElement = document.querySelector('input[name="plan"]:checked');
            const selectedPlan = selectedPlanElement.value;
            console.log(selectedPlanElement)
            if (!selectedPlanElement) {
                alert("Please select a plan.");
                console.log(selectedPlanElement)
                return;
            }
            // const phoneNumber = document.getElementById("mpesa_contact").value;
            const inputPhoneNumber = document.querySelector('input[name="mpesa_contact"]');
            const accountNameOwner = document.querySelector('input[name="name"]');
            const accountHolder = accountNameOwner.value.trim();
            console.log(accountHolder)
            const phoneNumber = inputPhoneNumber.value.trim();
            console.log(phoneNumber)
            if (!phoneNumber) {
                alert("Please enter your Mpesa phone number.");
                console.log(phoneNumber)
                return;
            }
            const modal = document.getElementById("payment_popup")
            fetch("payment.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        plan: selectedPlan,
                        payment_method: "Mpesa",
                        mpesa_contact: phoneNumber,
                        name: accountHolder
                    }),
                })
                .then((response) => response.json())
                .then((data) => {
                    alert(data.success || data.error);
                    console.log(data);
                    if (data.success) {
                        window.location.href = "dashbord.php";
                        modal.style.display = 'none';
                        overlay.style.display = 'none';
                    }
                })
        })

        // confirmBtn.addEventListener('click', function() {
        //     modal.style.display = 'none';
        //     overlay.style.display = 'none';
        //     form.submit();
        // });
    </script>

</body>

</html>