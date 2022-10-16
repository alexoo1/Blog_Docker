<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>blog php</title>
    <meta charset="UTF-8">
</head>
<body>

<?php if (isset($_SESSION["userid"])): ?>

    <h1>Blog php</h1>
-->    <p><a href="logout.php">Déconnexion</a></p>

<?php else: ?>

    <p><a href="login.php">Connectez-vous</a> ou <a href="signup.html">créez un compte</a></p>

<?php endif; ?>

</body>
</html>
