<?php

session_start();
require_once 'connect.php';

$email = $_POST['email'];
$code = $_POST['code'];
$new_password = md5($_POST['new_password']);

$check_accepted_email = mysqli_query($connect, "SELECT * FROM `accepted_users` WHERE `email` = '$email' AND `code` = '$code'");
if (mysqli_num_rows($check_accepted_email) > 0) {

    
    mysqli_query($connect, "UPDATE `accepted_users` SET `password` = '$new_password' WHERE `email` = '$email'");

    $_SESSION['message'] = 'Пароль успешно изменен. Можете войти в свой аккаунт.' ;
    header('Location: ../index.php');

}else{

    $check_accepted_teacher = mysqli_query($connect, "SELECT * FROM `accepted_teacher` WHERE `email` = '$email' AND `code` = '$code'");
    if (mysqli_num_rows($check_accepted_teacher) > 0) {

        mysqli_query($connect, "UPDATE `accepted_teacher` SET `password` = '$new_password' WHERE `email` = '$email'");

        $_SESSION['message'] = 'Пароль успешно изменен. Можете войти в свой аккаунт.' ;
        header('Location: ../index.php');

    }else{

        $_SESSION['message'] = 'Данного электронного адреса не существует' ;
        header('Location: ../reset_ending.php');

    }



}