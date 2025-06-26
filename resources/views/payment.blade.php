<p>Key from config: {{ env('STRIPE_SECRET') }}</p>
<p>Key from env: {{ env('STRIPE_KEY') }}</p>
<form method="POST" id="payment-form">
    @csrf
    <div id="card-element"></div>
    <input type="hidden" name="stripeToken" id="stripeToken">
    <button type="submit" id="pay-button">Pay $10</button>
</form>

<script src="https://js.stripe.com/v3/"></script>

<script>
    const stripe = Stripe( "{{env('STRIPE_KEY')}}");
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    const form = document.getElementById('payment-form');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const { token, error } = await stripe.createToken(card);

        if (error) {
            alert(error.message);
        } else {
            document.getElementById('stripeToken').value = token.id;
            form.submit();
        }
    });
</script>
