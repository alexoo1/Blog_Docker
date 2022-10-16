<?php
$user = 'root';
$pass = 'password';
$dbname = 'db';

try{
    $pdo = new PDO("mysql:host=$dbname:3306;dbname=data", "$user", "$pass");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo 'connection failed: '.$e->getMessage();
}