<?php
require './Cognito.php';

$cognito = new Cognito();

if ($_POST !== Array()) {
    $cognito->confirm($_POST);
    $_POST = Array();
}

?>


<html>

<head>
</head>

<body>
    <p>
    <?php echo $_POST == Array(); ?>
    </p>
    <form action="" method="POST">
        <input type="number" placeholder="confirmation code" name="confirmation_code">
        <input type="submit">
    </form>
</body>

</html>