<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
   <link rel="icon" type="image/x-icon" href="images/OIP (7).jpg">
   <link rel="stylesheet" href="style.css">
   <title>G-fit</title>
</head>
<style>
    body{ padding: 0; margin: 0; overflow: hidden; font-family: "Montserrat", serif;}
.header{
    display: flex;
    margin: 0;
    background-color: #0D0C0C;
    width: 100%;
    padding: 10px;
    align-items: center;
    justify-content: center;
    gap: 300px;
    font-weight: 700;
}
.logo{
    width: 60px; margin: 0; padding: 0;
    height: 60px;
    border-radius: 50%; 
}
.menubar nav a{text-decoration: none; color: #0D0C0C;}
.menubar nav li{list-style: none;}
.logo img{width: 70px; padding: 0; height: 70px;border-radius: 50%;}
.menubar nav{display: flex; justify-content: center; align-items: center; padding: 20px; gap: 40px;}
.menubar{width: 600px; background-color: #FFFFFF; border-radius: 35px;}
.menubar .span1{background-color: #0D0C0C; width: 130px; color: #FFFFFF; text-align: center; height: 20px;border-radius: 20px; }
.signup button{background-color: #3F46C0; width: 90px; color: #FFFFFF; height: 40px; border: none; border-radius: 20px; font-weight: 800;}

</style>
<body>
    <div class="container">
        <div class="header">
            <div class="logo"><a href="index.php"><img src="images/OIP (7).jpg" alt=""></a></div>
            <div class="menubar">
                <nav>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Features</a></li>
                    <li><a href="#">Pricing/plans</a></li>
                    <li><a href="#"><div class="span1">Contact</div></a></li>

                </nav>
            </div>
            <div class="signup"><button>SignUp</button></div>
        </div>
    </div>
</body>
</html>