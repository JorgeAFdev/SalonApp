<h1 class="page-name">Login</h1>
<p class="page-description">Log in with your data</p>

<?php include_once __DIR__ .  "/../templates/alerts.php"; ?>
<form class="form" action="/" method="POST">
    <div class="field">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Your Email" name="email"> 
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Your Password" name="password"> 
    </div>

    <input type="submit" class="button" value="Log In">
</form>

<div class="actions">
    <a href="/create-account">Don't you have an account yet? Create one</a>
    <a href="/forgot-password">Forgot your password?</a>
</div>