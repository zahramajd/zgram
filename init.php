<?php

// Start Session
session_start();

// Composer
require_once 'vendor/autoload.php';

// Includes
require_once 'models/User.php';

// Connect to database
global $db;
$m = new MongoDB\Client('mongodb://172.17.0.1:27017');
$db = $m->zgram;

function db() {
    global $db;
    return $db;
}

// Check login
if (!isset($_SESSION['_id']) && !defined('NO_LOGIN')) {
    header('Location: login.php');
    die();
}

global $current;
if (isset($_SESSION['_id']))
    $current = User::find_by_id($_SESSION['_id']);


// Check Block
if(User::current()!=null && User::current()->isBlocked()){
    echo "<h1>DAMN SPAMMER!</h1>";
    die();
}
