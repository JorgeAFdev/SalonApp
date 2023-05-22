<h1 class="page-name">New Service</h1>
<p class="page-description">Fill in all the fields to add a new service</p>

<?php 
    include_once __DIR__ . '/../templates/bar.php';
    include_once __DIR__ . '/../templates/alerts.php';
?>

<form class="form" action="/services/create" method="POST">
    <?php include_once __DIR__ . '/form.php'; ?>
    <input type="submit" class="button" value="Save Service">
</form>