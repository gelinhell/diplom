<?php

    session_start();
    require_once 'connect.php';

    $email = $_POST['email'];
    $password = md5($_POST['password']);



	

/* вход */ 	


    $check_accepted_users = mysqli_query($connect, "SELECT * FROM `accepted_users` WHERE `email` = '$email' AND `password` = '$password'");
    if (mysqli_num_rows($check_accepted_users) > 0) {

        $accepted_users = mysqli_fetch_assoc($check_accepted_users);

        $_SESSION['user'] = [
            "id" => $accepted_users['id'],
            "full_name" => $accepted_users['full_name'],
            "email" => $accepted_users['email'],
        ];

        

        header('Location: ../profile_cab_st.php');

     } else {

        $check_accepted_teachers = mysqli_query($connect, "SELECT * FROM `accepted_teacher` WHERE `email` = '$email' AND `password` = '$password'");
        if (mysqli_num_rows($check_accepted_teachers) > 0) {

            $accepted_teachers = mysqli_fetch_assoc($check_accepted_teachers);

            $_SESSION['teacher'] = [
                "id" => $accepted_teachers['id'],
                "full_name" => $accepted_teachers['full_name'],
                "email" => $accepted_teachers['email'],
                "name_table" => $accepted_teachers['name_table'],
            ];
    
            header('Location: ../profile_teacher.php');

        }else{
            $_SESSION['message'] = 'Неверный логин или пароль';
            header('Location: ../index.php');
        }



       
    }   
    ?>

<pre>
    <?php
    print_r($check_accepted_users);
    print_r($accepted_users);
    ?>
</pre>
 