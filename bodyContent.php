<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Document</title>
</head>
<style>
    .features {
        height: 2000px;
    }

    .image-features {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;

    }


    .pic {
        height: 600px;
        box-shadow: 10px 10px 20px 5px rgba(195, 28, 117, 0.5);
        position: relative;
    }

    .pic img {
        height: 600px;
        width: 400px;
        display: block;
        transition: transform 0.5s;
    }

    .pic2 {
        display: flex;
        flex-direction: column;
        gap: 5px;
        /* position: relative; */
    }

    .pic2 img {
        height: 300px;
        display: block;
        /* transform: 0.5s; */
    }

    .pic-2 {
        position: relative;
    }

    .pic-2 img {
        display: block;
        transition: transform 0.5s;
    }

    .heading1 {
        text-align: center;
        color: #FFF;
        padding-top: 30px;
        font-size: 20px;
        font-weight: 700;
    }

    .features .layer {
        width: 100%;
        height: 0;
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgb(234, 255, 0));
        border-radius: 10px;
        position: absolute;
        left: 0;
        bottom: 0;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        /* padding: 0 30px; */
        text-align: center;
        font-size: 16px;
        transition: height 0.5s;
        color: #FFF;
        font-weight: 700;

    }

    .pic-2:hover img {
        transform: scale(1.01);
    }

    .pic-2:hover .layer {
        height: 100%;
    }

    .pic:hover img {
        transform: scale(1.01);
    }

    .pic:hover .layer {
        height: 100%;
    }

    .layer h3 {
        font-weight: 500;
        color: #0be8f4;
    }

    .layer a {
        margin-top: 20px;
        text-decoration: none;
        font-size: 18px;
        line-height: 60px;
        background: #FFF;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        text-align: center;
    }

    .payments {
        margin-top: 80px;
        color: #FFF;
    }

    .head-2 {
        text-align: center;
    }

    .plans {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 50px;
        position: relative;
    }

    /* .plans2:hover {
            transition: box-shadow 0.1s ease-out;
        } */
    .plans2 {
        width: 300px;
        background: #FFF;
        height: 400px;
        color: #0D0C0C;
        border-top-left-radius: 50px;
        border-bottom-right-radius: 50px;
        border-bottom-left-radius: 10px;
        border-top-right-radius: 10px;
        padding: 10px;
        position: relative;
        /* transition: box-shadow 0.2s ease-out; */
    }

    .plans2::before {
        content: "";
        position: absolute;
        inset: -4px;
        /* Expands slightly outside the div */
        border-radius: inherit;
        /* Inherits the same border-radius */
        padding: 4px;
        /* Thickness of the animated border */
        background: linear-gradient(45deg, red, yellow, blue, green);
        background-size: 300% 300%;
        animation: border-gradient 3s infinite linear;
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask-composite: exclude;
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
    }

    @keyframes border-gradient {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .plans2 h3 {
        text-align: center;
    }

    .plans2 p {
        text-align: center;
    }

    .plans2 li {
        font-size: 18px;
        font-weight: 800;
        line-height: 30px;
    }

    .concact-cont {
        text-align: center;
    }

    .social {
        /* padding: 40px; */
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 200px;
    }

    .social .whatsapp {
        margin-top: 30px;
        text-decoration: none;
        font-size: 30px;
        line-height: 70px;
        background: green;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        text-align: center;
        color: #FFF;
    }

    .social .fbook {
        margin-top: 30px;
        text-decoration: none;
        font-size: 30px;
        line-height: 70px;
        background: rgb(24, 68, 242);
        width: 70px;
        height: 70px;
        border-radius: 30%;
        text-align: center;
        color: #FFF;
    }

    .cont-head {
        text-align: center;
        margin-top: 30px;
        color: #FFF;
    }

    .social .mess {
        margin-top: 30px;
        text-decoration: none;
        font-size: 30px;
        line-height: 70px;
        background: #FFF;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        text-align: center;
    }

    .x-tweet {
        margin-top: 30px;
        text-decoration: none;
        font-size: 30px;
        line-height: 70px;
        background: #FFF;
        width: 70px;
        height: 70px;
        border-radius: 30%;
        text-align: center;
        color: #0D0C0C;
    }

    .social .phone {
        margin-top: 30px;
        text-decoration: none;
        font-size: 30px;
        line-height: 70px;
        background: #0099FF;
        width: 70px;
        height: 70px;
        border-radius: 30%;
        text-align: center;
        color: #FFF;
    }
    form input, form textarea{
    width: 100%;
    border: 0;
    outline: none;
     background: #262626;
     padding: 15px;
     margin: 15px 0;
     color: #fff;
     font-size: 18px;
     border-radius: 6px;

}
form .btn2{
    padding: 14px 60px;
    font-size: 18px;
    margin-top: 20px;
    cursor: pointer;
    background: #3F46C0;
    border-radius: 30px;

}
.copyright{
    width: 100%;
    text-align: center;
    padding: 25px;
    background: #262626;
    font-weight: 300;
    margin-top: 20px;
    color: #FFF;
}
.copyright i{
    color: #ff004f;

}
.btn{
    display: block;
    margin: 50px auto;
    width: fit-content;
    border: 1px solid #ff004f;
    border-radius: 6px;
   font-weight: 700;
    text-decoration: none;
    color: #0D0C0C;
    transition: background 0.5s;

}
.form-data{
    margin-top: 50px;
   width: 100%;
   justify-content: center;
   display: flex;
   flex-direction: column;
   align-items: center;
   
}
</style>

<body>

    <div class="features">
        <div class="heading1">
            <h1>Features</h1>
        </div>
        <div class="image-features">
            <div class="pic">
                <img src="images/240_F_328574721_RitWLxpxcIYZZdFophcqGT2dfK2eSQuk.jpg" alt="">
                <div class="layer">
                    <h3>AI-Powered Recommendations </h3>
                    <p>Personalize your fitness journey by setting up your profile with age, weight, height, and fitness goals.</p>
                    <a href=""><i class="fa-solid fa-brain"></i></a>
                </div>
            </div>
            <div class="pic2">
                <div class="pic-2"> <img src="images/original-89ac0dfc8969efd5cc87ca1c46d63090.png" alt="">
                    <div class="layer">
                        <h3>Activity Logs</h3>
                        <p> Automatically log workouts, steps, and calories burned to monitor daily activities.</p>
                        <a href=""><i class="fa-solid fa-chart-line"></i></a>
                    </div>
                </div>
                <div class="pic-2"> <img src="images/original-9defc341f07b18b2df14e25358b27ec5.png" alt="">
                    <div class="layer">
                        <h3>Profile setup</h3>
                        <p> Personalize your fitness journey by setting up your profile with age, weight, height, and fitness goals.</p>
                        <a href=""><i class="fa-solid fa-user"></i></a>
                    </div>
                </div>
            </div>
            <div class="pic">
                <img src="images/original-b538ac8197ab6893f563b8c64e028937.png" alt="">
                <div class="layer">
                    <h3>Goals Analysis</h3>
                    <p> Set, track, and analyze your health and fitness goals with smart insights and progress tracking.</p>
                    <a href=""><i class="fa-solid fa-bullseye"></i></a>
                </div>
            </div>
        </div>
        <div class="payments">
            <div class="head-2">
                <h1>Pricing/Payments Plan</h1>
            </div>
            <div class="plans">
                <div class="plans2" id="hoverBox">
                    <h3>Free Plan 🆓</h3>
                    <p>KES 0</p>
                    <ul>
                        <li>Basic workout tracking</li>
                        <li>Limited goal setting</li>
                        <li>Access to general fitness tips</li>
                        <li>Community support</li>
                    </ul>
                </div>
                <div class="plans2">
                    <h3> Standard Plan 💳 <br>(Affordable Monthly Plan)</h3>
                    <p>KES 1</p>
                    <ul>
                        <li>Everything in Free Plan</li>
                        <li>Advanced goal analysis</li>
                        <li>Personalized activity recommendations</li>
                        <li>Detailed nutrition tracking</li>
                    </ul>
                </div>
                <div class="plans2">
                    <h3>Premium Plan 🔥 <br> (Full Access Plan)</h3>
                    <P>KES 2</P>
                    <ul>
                        <li>Everything in Standard Plan</li>
                        <li>AI-powered health insights</li>
                        <li>Custom meal & workout plans</li>
                        <li>Exclusive trainer guidance</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="contacts">
            <div class="cont-head">
                <h1>Contact us</h1>
            </div>
            <div class="concact-cont">
                <div class="social">
                    <a href="" class="whatsapp"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="" class="fbook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="" class="mess"><i class="fa-brands fa-facebook-messenger"></i></a>
                    <a href="" class="x-tweet"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="" class="phone"><i class="fa-solid fa-phone"></i></a>
                </div>
            </div>
            <div class="form-data">
                <form name="submit-to-google-sheet">
                    <input type="text" name="Name" placeholder="your name" required>
                    <input type="email" name="Email" placeholder="your email" required>
                    <textarea name="Message" rows="6" placeholder="your Message"></textarea>
                    <button type="submit" class="btn btn2">submit</button>
                </form>
            </div>
            <div class="copyright">
                <p>copyright <i class="fa-sharp fa-regular fa-copyright"></i> jasper.made with me</p>
            </div>
        </div>
    </div>
    <!-- <script>
        const hoverBox = document.getElementById("hoverBox");
        hoverBox.addEventListener("mousemove", e =>{
            const {left, top, width, height} = hoverBox.getBoundingClientRect();
            const x = e.clientX - (left + width/2);
            const y = e.clientY - (top + height/2);
            hoverBox.style.boxShadow = `${x * 0.2}px ${y * 0.2}px 20px rgba(206, 215, 179, 0.5)`;
        });
        hoverBox.addEventListener("mouseleave", () => {
            box.style.boxShadow = "none";
        });
    </script> -->
</body>

</html>