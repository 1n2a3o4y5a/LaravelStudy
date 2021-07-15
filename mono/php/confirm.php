<?php 
require './Cognito.php';

$cognito = new Cognito();

$response = $cognito->confirm($_POST);
var_dump($response);
?>