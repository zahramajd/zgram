<?php require_once '../init.php';


$p_id = $_GET['id'];


$results = User::current()->get_messages($p_id);

$r = [];

foreach ($results as $result) {
    $r[] = [
        '_id' => $result->_id . '',
        'from' => $result->from,
        'text' => $result->text,
        'is_me' => ($result->from == $_SESSION['_id'])
    ];
}

echo json_encode($r);
