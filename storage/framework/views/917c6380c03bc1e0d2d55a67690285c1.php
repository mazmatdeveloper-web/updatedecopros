<p>Key from config: <?php echo e(env('STRIPE_SECRET')); ?></p>
<p>Key from env: <?php echo e(env('STRIPE_KEY')); ?></p>
<form method="POST" id="payment-form">
    <?php echo csrf_field(); ?>
    <div id="card-element"></div>
    <input type="hidden" name="stripeToken" id="stripeToken">
    <button type="submit" id="pay-button">Pay $10</button>
</form>

<script src="https://js.stripe.com/v3/"></script>

<script>
    const stripe = Stripe( "<?php echo e(env('STRIPE_KEY')); ?>");
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
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/2025 Projects/updatedecopros/resources/views/payment.blade.php ENDPATH**/ ?>