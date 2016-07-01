<?php  require_once '../init.php';


$profile=User::find_by_id($_GET['id']);

$result=$profile->toArray();

echo json_encode($result);