<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
</head>

<body>

    <div id="paypal-button-container"></div>
    <script
        src="https://www.paypal.com/sdk/js?client-id=AR2Sw0Cw20zM3B1QXgXgn5fBjtZdavIUZMFXoehDo60tya6JSeZEv7JYTgZKD5R39IUMdowT5uqSPLXB">
    </script>
    <script>
    paypal.Buttons({
        createOrder: function(data, actions) {
            let selectedPlan = document.querySelector('input[name="plan"]:checked').value;
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: selectedPlan === "Standard" ? "10.00" : "20.00"
                    }
                }]
            })
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                let selectedPlan = document.querySelector('input[name="plan"]:checked').value;
                fetch('payment.php', {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            plan: selectedPlan,
                            payment_method: "Paypal",
                            email: details.payer.email_address
                        })
                    })
                    .then(response => response.text())
                    .then(text => {
                        console.log("Raw Response:",
                            text); // Check the actual response in console
                        return text ? JSON.parse(text) :
                        {}; // Convert to JSON only if there's content
                    })
                    .then(data => {
                        alert(data.success || data.error);
                        console.log(data)
                        if (data.success) {
                            window.location.href = "dashbord.php"
                        }
                    })
            })
        }
    }).render('#paypal-button-container');
    </script>
</body>

</html>