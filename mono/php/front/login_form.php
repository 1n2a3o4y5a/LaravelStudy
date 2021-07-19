<?php


?>


<html>

<head>
</head>

<body>
    <p>
    </p>
    <form action="http://<?php echo $_SERVER['HTTP_HOST'] ?>/login.php" method="POST">
        <input type="email" placeholder="email" name="email">
        <input type="password" placeholder="password" name="password">
        <input type="submit">
    </form>
</body>

</html>