<?php

include '../server/connection.php';

$result = mysqli_query($conn, "SELECT * FROM payment");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {

    ?>

        <img src="../<?= $row['payment_proof']; ?>" alt="" class="img-responsive">

    <?php } ?>


</body>

</html>