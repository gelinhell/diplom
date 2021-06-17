<?php

    require_once 'connect.php';
    session_start();

    $id = $_GET['id'];
    $id_f = array($id); /*id - работы*/

    
    foreach($id_f as $key => $item){
        $id_f[$key] = preg_replace('/[^0-9]+/', '', $item);
    }
    
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




    $id_teacher = $_SESSION['teacher']['id'];
    $name_table_teach = $_SESSION['teacher']['name_table'];
    $id_stud = $_SESSION['student_id']['id']; /*id  - студента */
   
    //echo $id_f[0];

    $code_work = rand(100000, 9999999);

    /* Проверка на уже имеющиеся работы */

    $check_accepted_work = mysqli_query($connect, "SELECT * FROM `work_view` WHERE `whom_work` = '$id_stud'");
    if (mysqli_num_rows($check_accepted_work) > 0) {

        header('Location: ../student_prava_serch.php');
		die($_SESSION['message'] = 'Данному студенту нельзя назначить еще одну работу.');
    }else{
        
        /*выбираем все из work*/ 
        $work_is_works = mysqli_query($connect, "SELECT * FROM `work` WHERE id = '$id_f[0]'");
        $work_is_works = mysqli_fetch_all($work_is_works);
        foreach ($work_is_works as $work_is_work) {
            
            /*Добавляем в work_view вместе с кодом и именем студента (можно сменить на id)*/
            $add_work_view = mysqli_query($connect, "INSERT INTO `work_view` (`id`, `id_work`, `name_work`, `year`, `name_lead`, `direction`, `name_student`, `email_stud`, `email_teach`, `tmp_way`, `name_file`, `code_work`, `whom_work`, `id_teacher`) VALUES ( NULL, '$work_is_work[0]', '$work_is_work[1]', '$work_is_work[2]', '$work_is_work[3]', '$work_is_work[4]', '$work_is_work[5]', '$work_is_work[6]', '$work_is_work[7]', '$work_is_work[8]', '$work_is_work[9]', '$code_work', '$id_stud', $id_teacher)");

            /*Добавляем код в accepted_users*/
            $select = mysqli_query($connect,"UPDATE `accepted_users` SET `code_work` = '$code_work' WHERE `id` = '$id_stud'");


            // ищем id самой строчки
            $serchs = mysqli_query($connect,"SELECT * FROM `work_view` WHERE `code_work` = '$code_work'");
            $serchs = mysqli_fetch_all($serchs);
            foreach ($serchs as $serch) {


                /* Добавляем код в Таблицу индивидуальную для преподавателя */
                $add_work_view = mysqli_query($connect, "INSERT INTO `$name_table_teach` (`id`, `code_rand`, `id_work_diplom`) VALUES (NULL, '$code_work', '$serch[0]')");

            }

            $serchs = mysqli_query($connect,"SELECT * FROM `accepted_users` WHERE `id` = '$id_stud'");
            $serchs = mysqli_fetch_all($serchs);
            foreach ($serchs as $serch) {

            utf8mail($serch[3], "Доступ к работе", "Вам был одобрен просмотр работы '" . $work_is_work[1] . "'." );


            }

            
            header('Location: ../student_prava_serch.php');
		    
 
            
        }
        
    }
     
?>