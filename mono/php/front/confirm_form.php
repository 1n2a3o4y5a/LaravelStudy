<?php

?>


<html>

<head>
</head>

<body>
    <p>
    <?php echo $_POST['email'] ?>
    </p>
    <form action="http://<?php echo $_SERVER['HTTP_HOST'] ?>/confirm.php" method="POST">
        <input type="hidden" name="email" value="<?php echo $_POST['email'] ?>">
        <input type="number" placeholder="confirmation code" name="confirmation_code">
        <input type="submit">
    </form>
</body>

</html>