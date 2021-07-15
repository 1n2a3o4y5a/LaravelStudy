<?php
require './Cognito.php';

$cognito = new Cognito();

$response = $cognito->signUp($_POST);
header('Location: http://'.$_SERVER['HTTP_HOST'].'/front/confirm_form.php', true, 307);

?>

<html>
</html>