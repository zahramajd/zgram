<?php require_once '../init.php';

$q = urldecode($_GET['text']);

db()->dialogs->insertOne([
        'from' => User::current()->_id . '',
        'to' => $_GET['to'],
        'text' => $q,
    ]
);


// Parse and extract users

preg_match_all('/(?<=@)[^\s]+/', $q, $results);

foreach ($results as $result) {

    // Try to find user
    $u = User::find_by('username', $result[0]);

    if ($u == null)
        continue;

    if (!in_array($_GET['to'],$u->peers->getArrayCopy())) {
        continue;
    }

    // Mention
    $u->update([
        '$addToSet' => [
            'mentions' => $_GET['to']
        ]
    ]);


}



