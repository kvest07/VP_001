<?php
$localhost = "mysql:host=localhost; charset=utf8;";
$pdo= new PDO($localhost, 'root', '');
$pdo->query('use burgers');

$smt = $pdo->query('SELECT * FROM `Users`');
$result = $smt->fetchAll(PDO::FETCH_ASSOC);

echo "<h1>База пользователей</h1>";

foreach ($result as $key => $value) {
    echo '<br>';
    foreach ($value as $k => $v) {
        echo $k . ' : '  .$v . '<br>';
    }
}


$smt2 = $pdo->query('SELECT * FROM `Orders`');
$result2 = $smt2->fetchAll(PDO::FETCH_ASSOC);

echo "<h1>База заказов</h1>";

foreach ($result2 as $key => $value) {
    echo '<br>';
    foreach ($value as $k => $v) {
        echo $k . ' : '  .$v . '<br>';
    }
}