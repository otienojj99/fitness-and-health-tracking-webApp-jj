<?php
include 'config.php'; //  path to include the config file
session_start();
$message = ""; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if((isset($_POST['register']))){
    $fullname = isset($_POST['FullName']) ?trim( $_POST['FullName']) : '';
    $username = isset($_POST['Username']) ? trim(htmlspecialchars($_POST['Username'])) : '';
    $email = isset($_POST['Email']) ? trim($_POST['Email']) : '';
    $password1 = isset($_POST['Password1']) ?trim( $_POST['Password1']) : '';
    $password2 = isset($_POST['Password2']) ? trim($_POST['Password2']) : '';
    

    if(empty($fullname) || empty($username) || empty($email) || empty($password1) || empty($password2)){
        $message = "All fields are required.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $message = "Follow a valid emai formating";
    }
    // elseif(!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password1)){
    //     $message = "Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
        
    // }
    // Check if passwords match
    elseif($password1 !== $password2) {
        $message = "Passwords do not match.";
    } 
    else {
        $hashed_password = password_hash($password1, PASSWORD_DEFAULT);

        // Insert user into the database
        try{
        $stmt = $conn->prepare("INSERT INTO User_registration (FullName,Username, Email, Password1) VALUES (:FullName, :Username, :Email, :Password1)");
        $stmt->execute([':FullName'=>$fullname,':Username' => $username, ':Email' => $email, ':Password1' => $hashed_password]);

        $message = "Registration successful! Please log in.";
        // $_SESSION['username'] = $user['username'];
        // // Redirect to login page
        // header('Location: dashboard.php');
        // exit();
        } catch (PDOException $e){
            $message = "Error: " . $e->getMessage();
        }
    }
    }
    

    if(isset($_POST['login'])){
        $username = isset($_POST['Username']) ? htmlspecialchars(trim($_POST['Username'])) : '';
        $password1 = isset($_POST['Password1']) ? $_POST['Password1'] : '';
        if(empty($username) || empty( $password1)){
            $message = "Please enter your login credentials";
        }

        $stmt = $conn->prepare("SELECT UserId, Username, Password1 FROM User_registration WHERE Username = :Username");
        $stmt->execute([':Username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password1, $user['Password1'])) {
            $_SESSION['user_id'] = $user['UserId'];
            $_SESSION['username'] = $user['Username'];
            header('Location: dashboard.php');
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
    <!-- <link rel="stylesheet" href="css/style.css"> Adjust the path to your CSS file -->
     <style>
        .container{
            width: 100%;
            /* margin: 50px auto; */
            height: 100vh; box-shadow: 0 0 10px rgba(0,0,0,0.2); background: #f0f0f0;
            border-radius: 10px; overflow: hidden; position: relative;
        }
        .main-cont{
            display: flex; justify-content: center; align-items: center; 

        }
        .overlay-pic{
            width: 100%;
            height: 100vh;
            background-color: black; margin: 0; padding: 0; 
        }
        .form-box{padding: 40px;  width: 100%; border: 1px solid #ddd; border-radius: 10px;  position: absolute; transition: 0.5s ease-in-out; margin: 0px;}
        .hidden { display: none; }
        .switch { cursor: pointer; color: blue; text-decoration: underline; }
        
     </style>
</head>
<body>
   <div class="main-cont">
   <div class="container">
    <div class="cont1">
    <div id="login-box" class="form-box signup-container">
    <?php if (!empty($message)) echo "<p style='color: red;'>$message</p>"; ?>
    <h1>Loggin</h1>
    <form method="POST">
    <label for="username">Username:</label>
    <input type="text" id="Username" name="Username" required> <br>
    <label for="password">Password:</label>
    <input type="password" id="Password1" name="Password1" required><br>
    <button type="submit" name="login">Login</button>
    </form>
    <p>Don't have an account? <span class="switch" onclick="swapForm('register')">Sign up</span></p>
    </div>
   
   <div id="register-box" class="form-box hidden">
   <h1>Register</h1>
    <?php if (isset($error)): ?>
        <p><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="fullname">Fullname:</label>
        <input type="text" id="FullName" name="FullName" required>
        <label for="username">Username:</label>
        <input type="text" id="Username" name="Username" required>
        <label for="email">Email:</label>
        <input type="email" id="Email" name="Email" required>
        <label for="password">Password:</label>
        <input type="password" id="Password1" name="Password1" required>
        <!-- <span id="passwordError" style="color: red;"></span> -->
        <label for="password2">Confirm Password:</label>
        <input type="password" id="Password2" name="Password2" required>
        <button type="submit" name="register">Register</button>
    </form>
    <p>Already have an account? <span class="switch" onclick="swapForm('login')">Sign in</span></p>
   </div>
   
   </div>
  
   </div>
   <div class="overlay-pic">
        <h1>hello</h1>
    </div>
   </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
    function swapForm(form){
        if(form === 'register'){
            document.getElementById('login-box').classList.add('hidden');
            document.getElementById('register-box').classList.remove('hidden');
        }else{
            document.getElementById('register-box').classList.add('hidden');
            document.getElementById('login-box').classList.remove('hidden');
        }
    }
   document.getElementById('Password1').addEventListener('input', function(){
    var password = this.value;
    var erroSpan = document.getElementById('passwordError');
    var regex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    if(!regex.test(password)){
        erroSpan.textContent =  "Password must have at least 8 characters, one uppercase, one lowercase, one number, and one special character.";
    }else{
        erroSpan.textContent = "";
    }
   });
   </script>
</body>
</html>
