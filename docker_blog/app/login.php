<?php
session_start();
define('BASEPATH', true); //access connection script if you omit this line file will be blank
require 'database.php'; //require connection script

$_SESSION['userid'] = '';

//if(isset($_POST['submit']))
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    try {
        $user = 'root';
        $pass = 'password';
        $dbname = 'db';

        $pdo = new PDO("mysql:host=$dbname:3306;dbname=data", "$user", "$pass");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        /*$query = $pdo->prepare("SELECT * FROM user WHERE email = :email");
        $query->execute([
            ":email" => $_POST['email']
        ]);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            echo "l'utilisateur n'existe pas";
            die;
        }

        if ($user['password'] !== $_POST['password']) {
            echo "le mot de passe est incorrect";
            die;
        }

        session_regenerate_id();

        $_SESSION["userid"] = $user;
        http_response_code(302);
        header("location: /index.php");
        exit;*/


        //ensure fields are not empty
        $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
        $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;

        //Retrieve the user account information for the given username.
        $query = "SELECT userid, email, password FROM user WHERE email = :email";
        $stmt = $pdo->prepare($query);

        //Bind value.
        $stmt->bindValue(':email', $email);

        //Execute.
        $stmt->execute();

        //Fetch row.
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        //If $row is FALSE.
        if ($user === false) {
            echo '<script>alert("Le compte n\'existe pas")</script>';
        } else {

            /*//Compare and decrypt passwords.
            $validPassword = password_verify($passwordAttempt, $user['password']);

            //If $validPassword is TRUE, the login has been successful.
            if ($validPassword) {
                //Provide the user with a login session.
                $_SESSION['userid'] = $email;
                echo '<script>window.location.replace("index.php");</script>';
                exit;

            } else {
                //$validPassword was FALSE. Passwords do not match.
                echo '<script>alert("Email ou mot de passe incorrect")</script>';
            }*/
            $userEmail = $_POST['email'];
            $userPwd = $_POST['password'];

            if (!$user) {
                echo "l'utilisateur n'existe pas";
                die;
            }

            if ($user['password'] !== $userPwd) {
                echo "le mot de passe est incorrect";
                die;
            }

            //Provide the user with a login session.
            $_SESSION['userid'] = $email;
            echo '<script>window.location.replace("index.php");</script>';
            exit;
        }
    }catch(PDOException $e){
        $error = "Error: ".$e->getMessage();
        echo '<script>alert("'.$error.'")</script>';
    }
}
?>


<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>
<body>
<div id="container">
    <form action="login.php" method="POST">
        <h1>Connexion</h1>

        <label><b>Mail</b></label>
        <input type="email" placeholder="Entrer l'email de l'utilisateur" name="email" required>

        <label><b>Mot de passe</b></label>
        <input type="password" placeholder="Entrer le mot de passe" name="password" required>

        <input type="submit" id='submit' value='Se connecter'>
    </form>
</div>
</body>
</html>