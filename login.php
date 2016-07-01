<?php
define('NO_LOGIN', true);
require_once "init.php";

if(isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    die();
}

if (isset($_POST['action'])) {

    $u = $_POST['usr'];
    $p = $_POST['psw'];

    switch ($_POST['action']) {
        case 'signup':

            // First check for user existence
            $current = $db->users->findOne(['username' => $u]);
            if ($current != null) {
                $message = 'User already exists';
                break;
            }

            $db->users->insertOne([
                'username' => $u,
                'password' => $p,
                'type' => 'person',
                'peers' => [],
            ]);

            $message = 'Signup OK';

            break;
        case 'login':
            // Login
            $current = $db->users->findOne(['username' => $u, 'password' => $p]);

            if ($current == null) {
                $message = 'Invalid username or password';
                break;
            } else {
                $_SESSION['_id'] = $current->_id.'';
                header('Location: .');
            }

            break;
    }

}
?>
<head>
    <title>Zgram</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">

</head>
<div class="flex">
    <?php if (isset($message)): ?>
        <div class="alert alert-danger"><?php echo $message ?></div><?php endif; ?>
    <form action="login.php" method="post" class="login-form">
        <label for="usr">Username </label>
        <input type="text" name="usr" id="usr">
        <br>
        <label for="pwd">Password </label>
        <input type="text" name="psw" id="pwd">
        <br><br>
        <button type="submit" name="action" value="login" class="btn btn-danger btn-sm">log &nbsp; in</button>
        <br><br>
        <button type="submit" name="action" value="signup" class="btn btn-success btn-sm">sign up</button>
    </form>

</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
