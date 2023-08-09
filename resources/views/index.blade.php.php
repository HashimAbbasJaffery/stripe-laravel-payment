<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <input id="card-holder-name" type="text">
    
        <!-- Stripe Elements Placeholder -->
        <div id="card-element"></div>
        <button data-secret="{{ $intent->client_secret }}">Pay!</button>
    
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const public_key = "pk_test_51NdGHoSJ0DwCQcRrCtQOmGMTz0ipW4CHXaU9Ufuf6ozUADqt0dDksYjD7MhucehUKaV6Vz8m9uGOnaSqEAbvKM4400xRmrAFcT";
        const stripe = Stripe(public_key);

        const elements = stripe.elements();

        const cardElement = elements.create("card");

        cardElement.mount("#card-element");
    </script>
</body>
</html>