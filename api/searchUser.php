<?php  require_once '../init.php';

$result = [];

$name=$_GET['q'];

$regex = ".*$name.*";

$results=$db->users->find( [
    '$or'=>[
    ['username'=>['$regex'=>$regex]],
        ['name'=>['$regex'=>$regex]],
    ]
])->toArray();

$r=[];
foreach ($results as $result){
    $r[]=@[
      '_id'=>$result->_id.'',
        'username'=>$result->username,
        'name'=>$result->name,
        'type'=>$result->type,
    ];
}


echo json_encode($r);