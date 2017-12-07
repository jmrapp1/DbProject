<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once("../../services/DatabaseService.php");
require_once('../../services/UserService.php');;
require_once('../../services/SessionService.php');
require_once('../../services/ServiceError.php');

if (isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = UserService::Instance()->getUser($username, $password);
    if (!($user instanceof ServiceError)) {
        SessionService::Instance()->createSession($user->Login_ID);
        $_SESSION['success'] = "You have logged in successfully.";
    } else {
        $_SESSION['error'] = $user->getError();
    }
} else {
    $_SESSION['error'] = 'Please enter a username and password.';
}

// Redirect where needed
if (isset($_POST['redirect'])) {
    header('Location: ' . $_POST['redirect']);
}