<h1 class="page-name">Reset Your Password</h1>
<p class="page-description">Enter your email address below, and we'll send you instructions on how to reset your password.</p>

<?php include_once __DIR__ . '/../templates/alerts.php'; ?>

<form class="form" action="/forgot-password" method="POST">
    <div class="field">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Your Email">
    </div>

    <input type="submit" class="button" value="Send Instructions">
</form>

<div class="actions">
    <a href="/">Already have an account? Log In</a>
    <a href="/create-account">Don't you have an account yet? Create one</a>
</div>

