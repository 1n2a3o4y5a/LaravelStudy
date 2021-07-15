<?php


?>


<html>

<head>
</head>

<body>
    <p>
    </p>
    <form action="http://<?php echo $_SERVER['HTTP_HOST'] ?>/signup.php" method="POST">
        <input type="email" placeholder="email" name="email">
        <input type="phone_number" placeholder="phone number" name="phone_number">
        <input type="password" placeholder="password" name="password">
        <input type="submit">
    </form>
</body>

</html>