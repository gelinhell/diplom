<?php
    require_once 'vendor/connect.php';

    $id = $_GET['id'];
    $id_f = array($id);

    
   foreach($id_f as $key => $item){
       $id_f[$key] = preg_replace('/[^0-9]+/', '', $item);
    }
    
   
    //echo $id_f[0];


    $open_file_ids = mysqli_query($connect, "SELECT * FROM `works_check` WHERE `id` = '$id_f[0]' ");
    
        if(mysqli_num_rows($open_file_ids) > 0){
        
            $open_file_ids = mysqli_fetch_all($open_file_ids);
            foreach ($open_file_ids as $open_file_id) {

                mb_internal_encoding("UTF-8");
                
                $filePath =  $open_file_id[8] ;
                if (!file_exists($filePath)) {
                    echo "The file $filePath does not exist";
                    die();
                }
                $filename=" $open_file_id[9] ";

                header('Content-type:application/pdf');
                header('Content-disposition: inline; filename="'.$filename.'"');
                header('content-Transfer-Encoding:binary');
                header('Accept-Ranges:bytes');
                readfile($filePath);
            }
        }else{
            $open_file_accs = mysqli_query($connect, "SELECT * FROM `work` WHERE `id` = '$id_f[0]' ");

            $open_file_accs = mysqli_fetch_all($open_file_accs);
            foreach ($open_file_accs as $open_file_acc) {

                mb_internal_encoding("UTF-8");
                
                $filePath =  $open_file_acc[8] ;
                if (!file_exists($filePath)) {
                    echo "The file $filePath does not exist";
                    die();
                }
                $filename=" $open_file_acc[9] ";

                header('Content-type:application/pdf');
                header('Content-disposition: inline; filename="'.$filename.'"');
                header('content-Transfer-Encoding:binary');
                header('Accept-Ranges:bytes');
                readfile($filePath);
            }
        }
    
?>