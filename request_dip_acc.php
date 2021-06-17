<?php
session_start();

if (!$_SESSION['teacher']) {
    header('Location: index.php');
}

require_once 'vendor/connect.php';

unset($_SESSION['student_id']);
unset($_SESSION['work_id']);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Принятые работы</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>
<!-- Шапка сайта -->

    <header>
        <div class="wrapper">
            <div class="block">
                <div class="block_row">
                    <div class="block_column">
                        <div class="blok_item">
                            <label id="logo">Diplom</label>
                        </div>
                    </div>  

                    <div class="block_column">
                        <div class="blok_item">
                        <h2 style="margin: 10px 0;" id="name_user"><?= $_SESSION['teacher']['full_name'] ?> </h2>
                        </div>
                    </div> 

                    

                    <div class="block_column">
                        <div class="blok_item">
                            <a id="bt_ex" href="vendor/logout.php" class="logout">Выйти</a>
                        </div>
                    
                    </div>
                </div>
            </div>

        </div>
    </header>



<!-- менюшка сайта -->
    <div class="wrapper_m">
        <div class="block_m">
            <div class="block_row_m">

                <div class="block_column_m">
                    <div class="blok_item_m">
                    <div class="dropdown">
                        <button class="dropbtn_active" >Заявки на дипломные работы</button>
                        <div class="dropdown-content">
                            <a href="request_dip_new.php">Новые заявки</a>
                            <a href="request_dip_acc.php">Принятые работы</a>
                            
                        </div>
                    </div>

                    </div>
                </div>  

                 <div class="block_column_m">
                    <div class="blok_item_m">
                        
                        <a id="btn_menu" href="profile_teacher.php" class="logout" >Личный кабинет</a>
                    </div>
                </div> 

                <div class="block_column_m">
                    <div class="blok_item_m">
                        <div class="dropdown">
                            <button class="dropbtn">Предоставление прав на просмотр</button>
                            <div class="dropdown-content">
                                <a href="access.php">Предоставить студенту</a>
                                <a href="access_all.php">Все предоставленные работы</a>
                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

<!-- Заголовок страницы -->

    <div class="wrapper_zag_zav">
        <div class="block_m">
            <div class="block_row_m">

                

                 <div class="block_column_m">
                    <div class="blok_item_m">
                        <p id="zag_zav">Принятые Вами работы</p>
                
                    </div>
                </div> 

             

            </div>
        </div>

    </div>

<!-- Контент страницы -->


            <?php 
                $email_teacher = $_SESSION['teacher']['email'];
                
                $select = mysqli_query($connect,"SELECT work.name_work, work.id, work.year, work.name_student, accepted_teacher.full_name, direction.name_dir FROM(( `work` INNER JOIN `accepted_teacher` ON accepted_teacher.id = work.name_lead) INNER JOIN `direction` ON direction.id = work.direction) WHERE `email` = '$email_teacher'");
                while ( $row = $select->fetch_array() ) {
            ?>
    <div class="wrapper_ser">
        <div class="block_ser">
            <div class="block_row_ser">


                <div class="block_column_ser_one">  
                    <div class="block_item_ser_one">

                        <label id="ser_s">Студент:</label> </br>
                        <p id="cont_one"><?= $row['name_student'] ?></p>

                    </div>
                </div>

                <div class="block_column_ser_two">
                    <div class="block_item_ser_two">

                        <label id="ser_s">Руководитель:</label> </br>
                        <p id="cont"><?= $row['full_name'] ?></p>
                        
                    </div>
                </div>

                <div class="block_column_ser_three">
                    <div class="block_item_ser_three">

                        <label id="ser_s">Тема работы:</label> </br>
                        <p id="cont"><?= $row['name_work'] ?></p>
                        
                    </div>
                </div>

                <div class="block_column_ser_four">
                    <div class="block_item_ser_four">

                        <label id="ser_s">Направление обучения:</label> </br>
                        <p id="cont_fhour"><?= $row['name_dir'] ?></p>
                        
                    </div>
                </div>

                <div class="block_column_ser_five">
                    <div class="block_item_ser_five">

                        <label id="ser_s">Год защиты:</label> </br>
                        <p id="cont_five"><?= $row['year'] ?></p>
                        
                    </div>
                </div>

                <div class="block_column_ser_six">
                    <div class="block_item_ser_six">

                        <a target="_blank" id="bt_open" href="/open_file_teach_new.php?id='.<?= $row[1] ?>.'"><batton >Открыть</batton></a>
                        
                    </div>
                </div>
                
                <div class="block_column_ser_six">
                    <div class="block_item_ser_six">

                        <a  id="bt_open" href="/vendor/delete_file_teach_acc.php?id='.<?= $row[1] ?>.'"><batton >Удалить</batton></a>
                        
                    </div>
                </div>

                

            </div>
        </div>
    </div>
    <?php
                    }
                ?>