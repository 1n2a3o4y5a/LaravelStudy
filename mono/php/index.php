<?php
require './Cognito.php';

$cognito = new Cognito();

// if ($_POST !== Array()) {
//     $cognito->signUp($_POST);
//     $signupFlag = false;
// }

?>


<html>

<head>
</head>

<body>
    <p>
    <!-- <?php echo $_POST == Array(); ?> -->
    <?php echo $cognito->signupFlag; ?>
    </p>
    <?php if ($cognito->signupFlag): ?>
    <form action="" method="POST">
        <input type="email" placeholder="email" name="email">
        <input type="phone_number" placeholder="phone number" name="phone_number">
        <input type="password" placeholder="password" name="password">
        <input type="submit" onclick="<?php echo $cognito->signUp($_POST); ?>">
    </form>
    <?php else: ?>
        <form action="" method="POST">
        <input type="number" placeholder="confirmation code" name="confirmation_code">
        <input type="submit" onclick="<?php echo $cognito->confirm($_POST); ?>">
    </form>
    <?php endif; ?>
    </form>
</body>

</html>