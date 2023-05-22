<h1 class="page-name">Administration Panel</h1>
<?php include_once __DIR__ . '/../templates/bar.php'; ?>

<h2>Search appointments</h2>
<div class="search">
    <form class="form" action="">
        <div class="field">
            <label for="date">Date</label>
            <input type="date" id="date" name="date" value="<?php echo $date; ?>">
        </div>
    </form>
</div>

<?php
    if(count($appointments) === 0) {
        echo "<h2>There are no appointments</h2>";
    }
?>

<div id="admin-appointments">
    <ul class="appointments">
            <?php  
                $idappointment = 0;
                foreach($appointments as $key => $appointment) {
                    if($idappointment !== $appointment->id) {
                        $total = 0;
            ?>
            <li>
                <p>ID: <span><?php echo $appointment->id; ?> </span></p>
                <p>Time: <span><?php echo $appointment->time; ?> </span></p>
                <p>Client: <span><?php echo $appointment->client; ?> </span></p>
                <p>Email: <span><?php echo $appointment->email; ?> </span></p>
                <p>Phone Number: <span><?php echo $appointment->phone_number; ?> </span></p>

                <h3>Services</h3>
            <?php 
                $idappointment = $appointment->id;
            } // End IF
                $total += $appointment->price;
            ?>
                <p class="service"> <?php echo $appointment->service . " " . $appointment->price; ?></p>

            <?php 
                $current = $appointment->id;
                $next = $appointments[$key + 1]->id ?? 0;

                if(isLast($current, $next)) { ?>
                   <p class="total">Total: <span> <?php echo $total; ?>$</span></p> 

                   <form action="/api/delete" method="POST">
                        <input type="hidden" name="id" value="<?php echo $appointment->id ?>"> 
                        <input type="submit" class="button-delete" value="Delete">
                   </form>
            <?php } 
        } // End Foreach ?>
    </ul>
</div>

<?php 
    $script = "<script src='build/js/searcher.js'></script>"
?>