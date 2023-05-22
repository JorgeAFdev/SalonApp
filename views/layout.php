<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon App</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="/../build/css/app.css">
</head>
<body>
    <div class="container-app">
        <div class="image">
            <img src="/build/img/1.webp" alt="Professional barber giving a beard trim to a client in a salon">
        </div>
        <div class="app">
            <?php echo $content; ?>
        </div>   
        
        <?php
            echo $script ?? '';
        ?>
</body>
</html>