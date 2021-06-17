<?php



session_start();
require_once 'vendor/connect.php';

$danny_user = $_SESSION['user']['email'];

$email_check_studs = mysqli_query($connect, "SELECT * FROM `work` WHERE `email_stud` = '$danny_user' ");
if (mysqli_num_rows($email_check_studs) > 0) {

    $email_check_studs = mysqli_fetch_all($email_check_studs);
    foreach ($email_check_studs as $email_check_stud) {

        unlink($email_check_stud[8]);
    }

    mysqli_query($connect, "DELETE FROM `work` WHERE `email_stud` = '$danny_user'");

    $_SESSION['message'] = 'Файл успешно удален.' ;
    header('Location: ../profile.php');

}else{ 
    
    $email_work_checks = mysqli_query($connect, "SELECT * FROM `works_check` WHERE `email_stud` = '$danny_user' ");
    if (mysqli_num_rows($email_work_checks) > 0) {
    
        $email_work_checks = mysqli_fetch_all($email_work_checks);
        foreach ($email_work_checks as $email_work_check) {
    
            unlink($email_work_check[8]);
        }
    
        mysqli_query($connect, "DELETE FROM `works_check` WHERE `email_stud` = '$danny_user'");
    
        $_SESSION['message'] = 'Файл успешно удален.' ;
        header('Location: ../profile.php');
    
    }else{

        $email_work_rejects = mysqli_query($connect, "SELECT * FROM `works_reject` WHERE `email_stud` = '$danny_user' ");
        if (mysqli_num_rows($email_work_rejects) > 0) {
    
            $email_work_rejects = mysqli_fetch_all($email_work_rejects);
            foreach ($email_work_rejects as $email_work_reject) {
        
                unlink($email_work_reject[8]);
            }
        
            mysqli_query($connect, "DELETE FROM `works_reject` WHERE `email_stud` = '$danny_user'");
        
            $_SESSION['message'] = 'Файл успешно удален.' ;
            header('Location: ../profile.php');
    
        }else{
            
            $_SESSION['message'] = 'Вы еще не загружали файл.' ;
            header('Location: ../profile.php');

        }
    }

}

















?>
