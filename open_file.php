<?php



session_start();
require_once 'vendor/connect.php';

$danny_user = $_SESSION['user']['email'];

$email_check_studs = mysqli_query($connect, "SELECT * FROM `work` WHERE `email_stud` = '$danny_user' ");
if (mysqli_num_rows($email_check_studs) > 0 ) {

    $email_check_studs = mysqli_fetch_all($email_check_studs);
    foreach ($email_check_studs as $email_check_stud) {

        mb_internal_encoding("UTF-8");
        
        $filePath =  $email_check_stud[8] ;
        if (!file_exists($filePath)) {
            echo "The file $filePath does not exist";
            die();
        }
        $filename=" $email_check_stud[9] ";

        header('Content-type:application/pdf');
        header('Content-disposition: inline; filename="'.$filename.'"');
        header('content-Transfer-Encoding:binary');
        header('Accept-Ranges:bytes');
        readfile($filePath);
      
    }
}else{
    $email_check_works = mysqli_query($connect, "SELECT * FROM `works_check` WHERE `email_stud` = '$danny_user' ");
    if (mysqli_num_rows($email_check_works) > 0 ) {

        $email_check_works = mysqli_fetch_all($email_check_works);
        foreach ($email_check_works as $email_check_work) {
    
            mb_internal_encoding("UTF-8");
            
            $filePath =  $email_check_work[8] ;
            if (!file_exists($filePath)) {
                echo "The file $filePath does not exist";
                die();
            }
            $filename=" $email_check_work[9] ";
    
            header('Content-type:application/pdf');
            header('Content-disposition: inline; filename="'.$filename.'"');
            header('content-Transfer-Encoding:binary');
            header('Accept-Ranges:bytes');
            readfile($filePath);
          
        }
    }else{

        $email_check_works_rejs = mysqli_query($connect, "SELECT * FROM `works_reject` WHERE `email_stud` = '$danny_user' ");
        if (mysqli_num_rows($email_check_works_rejs) > 0 ) {
    
            $email_check_works_rejs = mysqli_fetch_all($email_check_works_rejs);
            foreach ($email_check_works_rejs as $email_check_works_rej) {
        
                mb_internal_encoding("UTF-8");
                
                $filePath =  $email_check_works_rej[8] ;
                if (!file_exists($filePath)) {
                    echo "The file $filePath does not exist";
                    die();
                }
                $filename=" $email_check_works_rej[9] ";
        
                header('Content-type:application/pdf');
                header('Content-disposition: inline; filename="'.$filename.'"');
                header('content-Transfer-Encoding:binary');
                header('Accept-Ranges:bytes');
                readfile($filePath);
              
            }
        }

    }

    
}
?>
