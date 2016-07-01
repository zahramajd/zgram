<?php require_once '../init.php';

$result = [];

// Get peers
foreach (User::current()->peers() as $peer) {
    $u = $peer->toArray();
    $result[] = $u;
}

// Get Unknown messages
$unknown_users = db()->dialogs->distinct('from', ['$and' => [
    ['to' => User::current()->_id . ''],
    ['from' => ['$nin' => User::current()->peers]]
]]);

$unknown_users2 = db()->dialogs->distinct('to', ['$and' => [
    ['from' => User::current()->_id . ''],
    ['to' => ['$nin' => User::current()->peers]]
]]);


foreach (array_unique(array_merge($unknown_users, $unknown_users2)) as $unknown_user) {
    $u = User::find_by_id($unknown_user);
    if ($u->type == 'person')
        $result[] = $u->toArray();
}

echo json_encode($result);