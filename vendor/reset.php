<?php

session_start();
require_once 'connect.php';

$email = $_POST['email'];


//print($email);
//print mail("name@my.ru","header","text");

// функция для нормальной отправки русского текста
function utf8mail($to,$s,$body){
        $from_name="Сброс пароля Диплом";
        $from_a = "Dima@diplom.kz";
        $reply="Dima@diplom.kz";
        $s= "=?utf-8?b?".base64_encode($s)."?=";
        $headers = "MIME-Version: 1.0\r\n";
        $headers.= "From: =?utf-8?b?".base64_encode($from_name)."?= <".$from_a.">\r\n";
        $headers.= "Content-Type: text/plain;charset=utf-8\r\n";
        $headers.= "Reply-To: $reply\r\n";  
        $headers.= "X-Mailer: PHP/" . phpversion();
        mail($to, $s, $body, $headers);
    }

//Условие проверки и отправки    
$check_accepted_email = mysqli_query($connect, "SELECT * FROM `accepted_users` WHERE `email` = '$email'");
if (mysqli_num_rows($check_accepted_email) > 0) {

    $code = rand(100000, 9999999);

    utf8mail($email, "Сброс пароля Диплом", "Код для сброса пароля:" . $code);

    mysqli_query($connect, "UPDATE `accepted_users` SET `code` = '$code' WHERE `email` = '$email'");

    $_SESSION['message'] = 'Код для смены пароля отправлен к Вам на почту.' ;
    header('Location: ../reset_ending.php');

}else{

    $check_accepted_teacher = mysqli_query($connect, "SELECT * FROM `accepted_teacher` WHERE `email` = '$email'");
    if (mysqli_num_rows($check_accepted_teacher) > 0) {

        $code = rand(100000, 9999999);
        utf8mail($email, "Сброс пароля Диплом", "Код для сброса пароля:" . $code);
        mysqli_query($connect, "UPDATE `accepted_teacher` SET `code` = '$code' WHERE `email` = '$email'");

        $_SESSION['message'] = 'Код для смены пароля отправлен к Вам на почту.' ;
        header('Location: ../reset_ending.php');

    }else{

        $_SESSION['message'] = 'Данного электронного адреса не существует' ;
        header('Location: ../vendor/password_reset.php');

    }



}
















?>