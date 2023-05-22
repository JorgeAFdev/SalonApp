<h1 class="page-name">Reset Password</h1>
<p class="page-description">Enter your new password below</p>

<?php include_once __DIR__ . '/../templates/alerts.php'; ?>

<?php if($error) return?> <!-- Fake token -->
<form class="form" method="POST">  
    <div class="field">
    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Your New Password">
    </div>
    <input type="submit" class="button" value="Save new Password">
        
</form>

<div class="actions">
    <a href="/">Already have an account? Log in</a>
    <a href="/create-account">Don't you have an account yet? Create one</a>
</div>