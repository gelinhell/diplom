<?php

    session_start();
    require_once 'connect.php';

    $full_name = $_POST['full_name'];
    $group_user = $_POST['group_user'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

   

    
    $check_accepted_email = mysqli_query($connect, "SELECT * FROM `accepted_users` WHERE `email` = '$email'  " );
    
    if (mysqli_num_rows($check_accepted_email) > 0 ) {

        
        header('Location: ../register.php');
        die($_SESSION['message'] = 'Такой адрес электронной почты уже существует.');
           

    }else{
        
        $check_accepted_email_teach = mysqli_query($connect, "SELECT * FROM `accepted_teacher` WHERE `email` = '$email'  " );
        if (mysqli_num_rows($check_accepted_email_teach) > 0 ) {
            header('Location: ../register.php');
            die($_SESSION['message'] = 'Такой адрес электронной почты уже существует.');
        }else{
        

            $check_data_email = mysqli_query($connect, "SELECT * FROM `users_data` WHERE `email` = '$email' AND `full_name` = '$full_name' ");
            if(mysqli_num_rows($check_data_email) > 0){
                
            

                if ($password === $password_confirm) {
                
                    $password = md5($password);


                    if($group_user != "1"){
                        
                    
                        mysqli_query($connect, "INSERT INTO `accepted_users` (`id`, `full_name`, `group_user`, `email`, `password`) VALUES (NULL, '$full_name', '$group_user', '$email', '$password')");
                        $_SESSION['message'] = 'Вы успешно Зарегистрировались как Студент.';
                        header('Location: ../index.php');

                    }else{

                        /* Функция транслитератора  */
                            function translit($value)
                            {
                                $converter = array(
                                    'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
                                    'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
                                    'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
                                    'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
                                    'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
                                    'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
                                    'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
                            
                                    'А' => 'A',    'Б' => 'B',    'В' => 'V',    'Г' => 'G',    'Д' => 'D',
                                    'Е' => 'E',    'Ё' => 'E',    'Ж' => 'Zh',   'З' => 'Z',    'И' => 'I',
                                    'Й' => 'Y',    'К' => 'K',    'Л' => 'L',    'М' => 'M',    'Н' => 'N',
                                    'О' => 'O',    'П' => 'P',    'Р' => 'R',    'С' => 'S',    'Т' => 'T',
                                    'У' => 'U',    'Ф' => 'F',    'Х' => 'H',    'Ц' => 'C',    'Ч' => 'Ch',
                                    'Ш' => 'Sh',   'Щ' => 'Sch',  'Ь' => '',     'Ы' => 'Y',    'Ъ' => '',
                                    'Э' => 'E',    'Ю' => 'Yu',   'Я' => 'Ya',   ' ' => '_',
                                );
                            
                                $value = strtr($value, $converter);
                                return $value;
                            }

                        /* Смена имени Преподавателя на английское */

                         $new_teacher_name = translit($full_name);
                            
                        /* Добавление нового Преподавателя в базу данных вместе с новым именем */
                        mysqli_query($connect, "INSERT INTO `accepted_teacher` (`id`, `full_name`, `email`, `password`, `name_table`) VALUES (NULL, '$full_name', '$email', '$password', '$new_teacher_name')");

                        /* Создание таблицы для Преподавателя по измененному имени */
                        $create_table_teach = mysqli_query($connect,"CREATE TABLE `diplom`.`$new_teacher_name` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `code_rand` VARCHAR(355) NULL , `id_work_diplom` INT(11) NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");


                        $_SESSION['message'] = 'Вы успешно зарегестрировались как Преподаватель.' ;
                        header('Location: ../index.php');
                        
                    }


                    
                }else {
                    $_SESSION['message'] = 'Пароли не совпадают';
                    header('Location: ../register.php');
            
                }
            }else{
                $_SESSION['message'] = 'Такого адреса электронной почты нет в системе.';
                    header('Location: ../register.php');

            }
        }
    }
    
    
?>
