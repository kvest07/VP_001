<?php
$localhost = "mysql:host=localhost; charset=utf8;";
$pdo= new PDO($localhost, 'root', '');
$pdo->query('use burgers');

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$street = $_POST['street'];
$house = $_POST['home'];
$block = $_POST['part'];
$appt = $_POST['appt'];
$floor = $_POST['floor'];
$comment = $_POST['comment'];


if (empty($email)) {
    echo "Email не указан";
    exit();
}

$sql = "SELECT id FROM `Users` WHERE email='" .$email. "'";
$smt = $pdo->prepare($sql);
$smt -> execute();

$result =$smt -> fetch();


if ($result===false) {
    $sql = "INSERT INTO `Users`(`name`, `email`, `Phone`) VALUES ('".$name."','".$email."','".$phone."')";
    $smt = $pdo->prepare($sql);
    $smt->execute();

    $sql = "SELECT id FROM `Users` WHERE email='" .$email. "' ";
    $smt = $pdo->prepare($sql);
    $smt -> execute();
    $result =$smt -> fetch();

    $sql = "INSERT INTO `Orders`(`user_id`, `street`, `apartment`, `comment`, `block`, `house`, `floor`) VALUES ('".$result[0]."','".$street."','".$appt."','".$comment."','".$block."','".$house."','".$floor."')";
    $smt = $pdo->prepare($sql);
    $smt->execute();

    $query_1 = "SELECT MAX(`id`) FROM `Orders`";
    $smt = $pdo->prepare($query_1);
    $smt -> execute();
    $result_1 = $smt -> fetch();

    $query = "SELECT COUNT(*) FROM `Orders` WHERE `user_id`= '".$result[0]."' ";
    $smt_1 = $pdo->prepare($query);
    $smt_1 -> execute();
    $result_2 = $smt_1 -> fetch();

    $text = "Заказ № $result_1[0].
Заказ - DarkBeefBurger за 500 рублей, 1 шт.
Ваш заказ будет доставлен по адресу ул. $street,дом $house,корпус $block,этаж $floor, кв.$appt
Это ваш $result_2[0] заказ!!!";

    mail("$email", 'msg', "$text");

    echo 'Письмо с данными о заказе было отправлено на почту';

} else {
    $sql = "INSERT INTO `Orders`(`user_id`, `street`, `apartment`, `comment`, `block`, `house`, `floor`) VALUES ('".$result[0]."',' ".$street."','".$appt."','".$comment."','".$block."','".$house."','".$floor."')";
    $smt = $pdo->prepare($sql);
    $smt->execute();

    $query_1 = "SELECT MAX(`id`) FROM `Orders`";
    $smt = $pdo->prepare($query_1);
    $smt -> execute();
    $result_1 = $smt -> fetch();

    $query = "SELECT COUNT(*) FROM `Orders` WHERE `user_id`= '".$result[0]."' ";
    $smt_1 = $pdo->prepare($query);
    $smt_1 -> execute();
    $result_2 = $smt_1 -> fetch();

    $text = "Заказ № $result_1[0].
Заказ - DarkBeefBurger за 500 рублей, 1 шт.
Ваш заказ будет доставлен по адресу ул. $street,дом $house,корпус $block,этаж $floor, кв.$appt
Это ваш $result_2[0] заказ!!!";

    mail("$email", 'msg', "$text");

    echo 'Спасибо. Письмо, с данными о заказе, было отправлено на почту!';
}
