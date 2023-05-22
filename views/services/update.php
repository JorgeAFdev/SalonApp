<h1 class="page-name">Update Service</h1>
<p class="page-description">Modify the values of the form</p>
<?php 
    include_once __DIR__ . '/../templates/bar.php';
    include_once __DIR__ . '/../templates/alerts.php';
?>
<form class="form" method="POST">
    <?php include_once __DIR__ . '/form.php'; ?>
    <input type="submit" class="button button-update" value="Update Service">
</form>