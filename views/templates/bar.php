<div class="bar">
    <p>Hello: <?php echo $name ?? ''; ?></p>

    <a class="button" href="/logout">Log Out</a>
</div>

<?php if($_SESSION['admin'] ?? null) { ?>
    <div class="services-bar">
        <a class="button" href="/admin">View Appointments</a>
        <a class="button" href="/services">View Services</a>
        <a class="button" href="/services/create">New Service</a>
    </div>
<?php } ?>