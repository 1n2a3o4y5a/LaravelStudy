<?php 
require './Cognito.php';

$cognito = new Cognito();

$response = $cognito->login($_POST);
var_dump($response);
?>