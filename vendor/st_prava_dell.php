<?php
    require_once 'connect.php';
    session_start();

    $id = $_GET['id'];
    $id_f = array($id); //Номер самой строчки, а не работы

    
   foreach($id_f as $key => $item){
       $id_f[$key] = preg_replace('/[^0-9]+/', '', $item);
    }

    $id_stud = $_SESSION['student_id']['id'];
    $name_table_teach = $_SESSION['teacher']['name_table'];
   
    // функция для нормальной отправки русского текста
        function utf8mail($to,$s,$body){
        $from_name="Права для просмотра";
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


   
   // echo $id_f[0];


   $thems = mysqli_query($connect,"SELECT * FROM `work_view` WHERE `id` = '$id_f[0]'");
   $thems = mysqli_fetch_all($thems);
   foreach ($thems as $them) {


       $serchs = mysqli_query($connect,"SELECT * FROM `accepted_users` WHERE `id` = '$id_stud'");
       $serchs = mysqli_fetch_all($serchs);
       foreach ($serchs as $serch) {

           utf8mail($serch[3], "Доступ к работе", "Вам был запрещен просмотр работы '" . $them[2] . "'." );


       }
   }


    // Удаление работы из work_view
    $applications = mysqli_query($connect, "DELETE FROM `work_view` WHERE `id` = $id_f[0]");

    // удаление кода из accepted_users 
    $select = mysqli_query($connect,"UPDATE `accepted_users` SET `code_work` = NULL WHERE `id` = '$id_stud'");
    
    // Удаление кода из индивидуальной таблицы Преподавателя 
    $applications = mysqli_query($connect, "DELETE FROM `$name_table_teach` WHERE `id_work_diplom` = $id_f[0]");

   

    header('Location: ../student_prava_serch.php');
   
            
  
?>