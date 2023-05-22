<?php 
        foreach($alerts as $key => $messages):
            foreach($messages as $message):
?>
    <div class="alert-container">
        <div class="alert <?php echo $key; ?>" >
            <?php echo $message; ?>
        </div>
    </div>
<?php
         endforeach;
        endforeach;
?>