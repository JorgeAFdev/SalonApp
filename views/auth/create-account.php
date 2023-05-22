<h1 class="page-name">Create Account</h1>
<p class="page-description">Fill out the form below to create an account</p>

<?php include_once __DIR__ . '/../templates/alerts.php'; ?>

<form class="form" action="/create-account" method="POST">
    <div class="field">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Your Name" value="<?php echo s($user->name) ?>">
    </div>

    <div class="field">
        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" name="last_name" placeholder="Your Last Name" value="<?php echo s($user->last_name) ?>">
    </div>

    <div class="field">
        <label for="phone_number">Phone Number</label>
        <input type="tel" id="phone_number" name="phone_number" placeholder="Your Phone Number" value="<?php echo s($user->phone_number) ?>">
    </div>

    <div class="field">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Your Email" value="<?php echo s($user->email) ?>">
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Your Password">
    </div>

    <input type="submit" class="button" value="Create Account">
</form>

<div class="actions">
    <a href="/">Already have an account? Log In</a>
</div>