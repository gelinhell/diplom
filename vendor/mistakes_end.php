<?php
    require_once 'connect.php';
    session_start();

    $id_work = $_SESSION['work_id']['id'];
    //echo($id_work);
    
    $text = $_POST['comment'];
    //echo($text);
   /*
    
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
    $serch_email_st = mysqli_query($connect, "SELECT * FROM `works_check` WHERE `id` = '$id_work'");
    while ( $row = $serch_email_st->fetch_array() ) {
       
        utf8mail($row[6], "Проверка работы", "Ваша работа '" . $row[1] . "' была отклонена. ". '<br>' . "Для уточнения подробностей зайдите в веб-приложение 'Diplom'." . '<br>' . "http://cs66446.tmweb.ru/index.php" );
    
    }    
          */  
    $select = mysqli_query($connect,"SELECT * FROM `works_check` WHERE `id` = '$id_work'");
    while ( $row = $select->fetch_array() ) {
        mysqli_query($connect,"INSERT INTO `works_reject` (`id`, `name_work`, `year`, `name_lead`, `direction`, `name_student`, `email_stud`, `email_teach`, `tmp_way`, `name_file`, `reasons`) 
                                                    VALUES ('$id_work', '$row[1]', '$row[2]', '$row[3]', '$row[4]', '$row[5]', '$row[6]', '$row[7]', '$row[8]', '$row[9]', '$text')");
        
    }
          

    $applications = mysqli_query($connect, "DELETE FROM `works_check` WHERE `id` = $id_work");

    mysqli_query($connect, "UPDATE `works_reject` SET `reasons` = '$text' WHERE `id` = '$id_work'");

    header('Location: ../request_dip_new.php');
          
       
?>