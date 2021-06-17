<?php
    require_once 'connect.php';

    $id = $_GET['id'];
    $id_f = array($id);

    
   foreach($id_f as $key => $item){
       $id_f[$key] = preg_replace('/[^0-9]+/', '', $item);
    }
    
   
    //echo $id_f[0];

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
    $serch_email_st = mysqli_query($connect, "SELECT * FROM `work` WHERE `id` = '$id_f[0]'");
    while ( $row = $serch_email_st->fetch_array() ) {
       
        utf8mail($row[6], "Проверка работы", "Ваша работа '" . $row[1] . "' была исключена из спика доступных. За подробностями обращайтесь к преподавателю." );
    
    }   

            
    $applications = mysqli_query($connect, "INSERT INTO `works_check` SELECT * FROM `work` WHERE `id` = $id_f[0]");

    $applications = mysqli_query($connect, "DELETE FROM `work` WHERE `id` = $id_f[0]");

    header('Location: ../request_dip_acc.php');
            
        
?>