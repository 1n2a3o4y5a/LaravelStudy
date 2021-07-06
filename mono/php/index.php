<?php
require './Cognito.php';

$cognito = new Cognito();

if ($_POST !== Array()) {
    $cognito->initialOauth($_POST);
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
        <input type="email" placeholder="email" name="email">
        <input type="phone_number" placeholder="phone number" name="phone_number">
        <input type="password" placeholder="password" name="password">
        <input type="submit">
    </form>
</body>

</html>