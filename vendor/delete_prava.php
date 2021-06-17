<?php
    require_once 'connect.php';
    session_start();

    $id = $_GET['id'];
    $id_f = array($id); // id строчки

    
    foreach($id_f as $key => $item){
    $id_f[$key] = preg_replace('/[^0-9]+/', '', $item);
    }

    
    

    $name_table_teach = $_SESSION['teacher']['name_table'];

    //echo($name_table_teach);

   //echo $id_f[0];

    // Находим емэйл студента, чтобы удалить у него рандомный код 
    $contents = mysqli_query($connect, "SELECT * FROM `work_view` WHERE `id` =  $id_f[0]");
    $contents = mysqli_fetch_all($contents);
    foreach ($contents as $content) {

        // удаление кода из accepted_users 
        $select = mysqli_query($connect,"UPDATE `accepted_users` SET `code_work` = NULL WHERE `code_work` = '$content[11]'");
        
        

    }

    // Удаление кода из индивидуальной таблицы Преподавателя 
    $applications = mysqli_query($connect, "DELETE FROM `$name_table_teach` WHERE `id_work_diplom` = $id_f[0]");


   
  
 
        // Удаление работы из work_view
        $applications = mysqli_query($connect, "DELETE FROM `work_view` WHERE `id` = $id_f[0]");

    

    header('Location: ../access_all.php');
      
?>