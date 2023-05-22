<h1 class="page-name">Create New Appointment</h1>
<p class="page-description">Choose your services enter your information</p>

<?php include_once __DIR__ . '/../templates/bar.php'; ?>


<nav class="tabs">
    <button class="current" type="button" data-step="1">Services</button>
    <button type="button" data-step="2">Appointment Details</button>
    <button type="button" data-step="3">Summary</button>
</nav>

<div id="step-1" class="section">
    <h2>Services</h2>
    <p class="text-center">Choose your services below</p>
    <div id="services" class="services-list"></div>
</div> 
<div id="step-2" class="section">
    <h2>Your Information and appointment</h2>
    <p class="text-center">Enter your information and appointment date</p>

    <form class="form">
        <div class="field">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" placeholder="Your Name" value="<?php echo $name; ?>" disabled>
        </div>

        <div class="field">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" min="<?php  echo date('Y-m-d', strtotime('+2 day'))?>">
        </div>

        

        <div class="field">
            <label for="time">Time</label>
            <input type="time" name="time" id="time">
        </div>
        <input type="hidden" id="id" value="<?php echo $id; ?>" disabled>

    </form>
</div> 
<div id="step-3" class="section summary-content">
    <h2>Summary</h2>
    <p class="text-center">Verify that the information is correct</p>
</div> 

<div class="pagination">
    <button id="previous" class="button">&laquo; Previous</button>
    <button id="next" class="button">Next &raquo;</button>
</div>
    

<?php 
    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
    ";
?>