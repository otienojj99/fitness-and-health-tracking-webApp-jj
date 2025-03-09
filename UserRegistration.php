<?php
include 'config.php'; //  path to include the config file
session_start();
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ((isset($_POST['register']))) {
        $fullname = isset($_POST['FullName']) ? trim($_POST['FullName']) : '';
        $username = isset($_POST['Username']) ? trim(htmlspecialchars($_POST['Username'])) : '';
        $email = isset($_POST['Email']) ? trim($_POST['Email']) : '';
        $password1 = isset($_POST['Password1']) ? trim($_POST['Password1']) : '';
        $password2 = isset($_POST['Password2']) ? trim($_POST['Password2']) : '';


        if (empty($fullname) || empty($username) || empty($email) || empty($password1) || empty($password2)) {
            $message = "All fields are required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Follow a valid emai formating";
        }
        // elseif(!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password1)){
        //     $message = "Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character.";

        // }
        // Check if passwords match
        elseif ($password1 !== $password2) {
            $message = "Passwords do not match.";
        } else {
            $hashed_password = password_hash($password1, PASSWORD_DEFAULT);

            // Insert user into the database
            try {
                $stmt = $conn->prepare("INSERT INTO User_registration (FullName,Username, Email, Password1) VALUES (:FullName, :Username, :Email, :Password1)");
                $stmt->execute([':FullName' => $fullname, ':Username' => $username, ':Email' => $email, ':Password1' => $hashed_password]);

                $message = "Registration successful! Please log in.";
                // $_SESSION['username'] = $user['username'];
                // // Redirect to login page
                // header('Location: dashboard.php');
                // exit();
            } catch (PDOException $e) {
                $message = "Error: " . $e->getMessage();
            }
        }
    }


    if (isset($_POST['login'])) {
        $username = isset($_POST['Username']) ? htmlspecialchars(trim($_POST['Username'])) : '';
        $password1 = isset($_POST['Password1']) ? $_POST['Password1'] : '';
        if (empty($username) || empty($password1)) {
            $message = "Please enter your login credentials";
        }

        $stmt = $conn->prepare("SELECT UserId, Username, Password1 FROM User_registration WHERE Username = :Username");
        $stmt->execute([':Username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password1, $user['Password1'])) {
            $_SESSION['user_id'] = $user['UserId'];
            $_SESSION['username'] = $user['Username'];
            header('Location: dashbord.php');
            exit();
        } else {
            $message = "Invalid login credentials";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- <link rel="stylesheet" href="css/style.css"> Adjust the path to your CSS file -->
    <style>
    body {
        font-family: Arial, sans-serif;
        background: #f6f5f7;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        display: flex;
        justify-content: center;
        /* height: 100vh; */
        border-radius: 10px;
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
        background: #f0f0f0;
        border-radius: 10px;
        overflow: hidden;
        position: relative;
        /* width: 100%; */
        max-width: 100%;
        min-height: 600px;
        align-items: center;

    }

    .main-cont {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }



    .form-box {
        /* padding: 40px; */
        width: 100%;
        /* border: 1px solid #ddd;
        border-radius: 10px; */
        /* position: relative; */
        transition: 0.5s ease-in-out;
        height: 100%;
        margin: 0px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        /* position: absolute; */
        transition: all 0.6s ease-in-out;
    }

    .hidden {
        display: none;
    }

    .switch {
        cursor: pointer;
        color: blue;
        text-decoration: underline;
    }

    .cont1 {
        /* display: none; */
        flex-direction: column;
        align-items: center;
        transition: all 0.3s ease-in-out;
    }

    .logo img {
        width: 70px;
        padding: 0;
        height: 70px;
        border-radius: 50%;
        text-align: center;

    }

    .logo {

        width: 60px;
        margin: 0;
        padding: 0;
        height: 60px;
        border-radius: 50%;
    }

    .cont11 {
        flex: 1;
        height: 100%;
    }

    .side-cont,
    .side-cont1 {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 500px;
        height: 600px;
        background: linear-gradient(to right, #F3904F, #3B4371);
        text-align: center;
        flex-direction: column;
        /* max-width: 100%; */
        flex: 1;
        transition: all 0.3s ease-in-out;

    }


    .form-container {
        background: #fff;
        border-radius: 10px;
        /* box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22); */
        padding: 20px;
        padding-left: 70px;
        width: 400px;
        background-color: transparent;
        /* flex: 1; */
        /* justify-content: center;
        display: flex;
        flex-direction: column;
        align-items: center; */
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
    }

    .input-container {
        position: relative;
        margin-bottom: 20px;
    }

    .input-container .icon {
        position: absolute;
        left: 10px;
        top: 40%;
        transform: translateY(-50%);
        color: #999;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
        width: calc(100% - 100px);
        padding: 10px 10px 10px 30px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 20px;
    }

    button {
        width: 50%;
        padding: 10px;
        background-color: #ff416c;
        border: none;
        border-radius: 5px;
        color: #fff;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background-color: #ff4b2b;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="main-cont">
            <div class="cont1">
                <div id="login-box" class="form-box signup-container">
                    <?php if (!empty($message)) echo "<p style='color: red;'>$message</p>"; ?>
                    <!-- <h1>Loggin</h1> -->
                    <div class="form-container">
                        <div class="cont11">
                            <form method="POST">
                                <label for="username">Username:</label>
                                <div class="input-container">
                                    <i class="fas fa-user icon"></i>
                                    <input type="text" id="Username" name="Username" required> <br>
                                </div>
                                <label for="password">Password:</label>
                                <div class="input-container">
                                    <i class="fas fa-lock icon"></i>
                                    <input type="password" id="Password1" name="Password1" required><br>
                                </div>
                                <button type="submit" name="login">Login</button>
                            </form>
                        </div>
                        <p>Don't have an account? </p>
                    </div>
                    <div class="side-cont" style=" border-top-left-radius: 50px;
        border-bottom-left-radius: 50px;">
                        <div class="logo"><a href="index.php"><img src="images/OIP (7).jpg" alt=""></a></div>
                        <h2>Hi, There</h2>
                        <h1>Loggin</h1>
                        <p>The only place to enjoy pain and benefit from it</p>
                        <p><span class="switch" onclick="swapForm('register')">Sign up</span></p>
                    </div>
                </div>

                <div id="register-box" class="form-box hidden">

                    <?php if (isset($error)): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                    <?php endif; ?>
                    <div class="side-cont1" style=" border-top-right-radius: 50px;
        border-bottom-right-radius: 50px;">
                        <div class="logo"><a href="index.php"><img src="images/OIP (7).jpg" alt=""></a></div>
                        <h2>Welcome Back </h2>
                        <h2>Register</h2>
                        <p>The only place to enjoy pain and benefit from it</p>
                        <p> <span class="switch" onclick="swapForm('login')">Sign in</span></p>
                    </div>
                    <div class="form-container">
                        <div>
                            <form method="POST">
                                <label for="fullname">Fullname:</label>
                                <div class="input-container">
                                    <input type="text" id="FullName" name="FullName" required>
                                </div>
                                <label for="username">Username:</label>
                                <div class="input-container">
                                    <i class="fas fa-user icon"></i>
                                    <input type="text" id="Username" name="Username" required>
                                </div>
                                <label for="email">Email:</label>
                                <div class="input-container">
                                    <i class="fas fa-envelope icon"></i>
                                    <input type="email" id="Email" name="Email" required>
                                </div>
                                <label for="password">Password:</label>
                                <div class="input-container">
                                    <i class="fas fa-lock icon"></i>
                                    <input type="password" id="Password1" name="Password1" required>
                                    <!-- <span id="passwordError" style="color: red;"></span> -->
                                </div>
                                <label for="password2">Confirm Password:</label>
                                <div class="input-container">
                                    <i class="fas fa-lock icon"></i>
                                    <input type="password" id="Password2" name="Password2" required>
                                </div>
                                <button type="submit" name="register">Register</button>
                            </form>

                        </div>
                        <p>Already have an account?</p>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function swapForm(form) {
        if (form === 'register') {
            document.getElementById('login-box').classList.add('hidden');
            document.getElementById('register-box').classList.remove('hidden');
        } else {
            document.getElementById('register-box').classList.add('hidden');
            document.getElementById('login-box').classList.remove('hidden');
        }
    }
    document.getElementById('Password1').addEventListener('input', function() {
        var password = this.value;
        var erroSpan = document.getElementById('passwordError');
        var regex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        if (!regex.test(password)) {
            erroSpan.textContent =
                "Password must have at least 8 characters, one uppercase, one lowercase, one number, and one special character.";
        } else {
            erroSpan.textContent = "";
        }
    });
    </script>
</body>

</html>