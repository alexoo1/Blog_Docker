<?php
define('BASEPATH', true); //access connection script if you omit this line file will be blank
require 'database.php'; //require connection script

if(isset($_POST['submit'])){
    try {
        $user = 'root';
        $pass = 'password';
        $dbname = 'db';

        $pdo = new PDO("mysql:host=$dbname:3306;dbname=data", "$user", "$pass");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



        $user = $_POST['lastName'];
        $email = $_POST['email'];
        $pass = $_POST['password'];

        //encrypt password
        $pass = password_hash($pass, PASSWORD_BCRYPT, array("cost" => 12));

        //Check if username exists
        $query = "SELECT COUNT(email) AS num FROM user WHERE email =      :email";
        $stmt = $pdo->prepare($query);

        $stmt->bindValue(':email', $_POST['email']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row['num'] > 0){
            echo '<script>alert("Cet email est déjà utilisé")</script>';
        }

        else{

            $stmt = $pdo->prepare("INSERT INTO user (lastName, firstName, email, password) 
    VALUES (:lastName,:firstName, :email, :password)");
            $stmt->bindParam(':lastName', $_POST['lastName']);
            $stmt->bindParam(':firstName', $_POST['firstName']);
            $stmt->bindParam(':email', $_POST['email']);
            $stmt->bindParam(':password', $_POST['password']);


            if($stmt->execute()){
                //redirect to another page
                echo '<script>window.location.replace("signup-success.html")</script>';

            }else{
                echo '<script>alert("An error occurred")</script>';
            }
        }
    }catch(PDOException $e){
        $error = "Error: " . $e->getMessage();
        echo '<script type="text/javascript">alert("'.$error.'");</script>';
    }
}

?>