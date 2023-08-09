<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <div id="card-element"></div>
        <input id="card-holder-name" type="text">
    
        <!-- Stripe Elements Placeholder -->
        <button id="card-button" data-secret="{{ $intent->client_secret }}">Pay!</button>
    
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const public_key = "pk_test_51NdGHoSJ0DwCQcRrCtQOmGMTz0ipW4CHXaU9Ufuf6ozUADqt0dDksYjD7MhucehUKaV6Vz8m9uGOnaSqEAbvKM4400xRmrAFcT";
        const stripe = Stripe(public_key);

        const elements = stripe.elements();

        const cardElement = elements.create("card");

        cardElement.mount("#card-element");
    </script>
    <script>
        const dispatch = (url, header, success, failed) => {
            axios.post(url, header)
            .then(res => {
                success(res);
            })
            .catch(() => {
                failed();
            })
        }
        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        cardButton.addEventListener('click', async (e) => {
            const { setupIntent, error } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: { name: cardHolderName.value }
                    }
                }
            );
        
            if (error) {
                // Display "error.message" to the user...
                console.log(error.message);
            } else {
                // The card has been verified successfully...
                dispatch("/subscribe", {
                    paymentMethodId: setupIntent.payment_method
                }, res => {
                    console.log(res)
                }, () => {
                    alert("Failed");
                })
            }
        });
    </script>
</body>
</html>