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
    <title>Личный кабинет</title>
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
                        <button class="dropbtn">Заявки на дипломные работы</button>
                        <div class="dropdown-content">
                            <a href="request_dip_new.php">Новые заявки</a>
                            <a href="request_dip_acc.php">Принятые работы</a>
                            
                        </div>
                    </div>

                        
                    </div>
                </div>  

                 <div class="block_column_m">
                    <div class="blok_item_m">
                        
                        <a id="active_menu" href="profile_teacher.php" class="logout" >Личный кабинет</a>
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
<!-- Данные преподавателя -->

    <div class="wrapper_prof">
        <div class="block_prof">
            <div class="block_row_prof">

            <?php 
                $email_user = $_SESSION['teacher']['email'];
                
                $select = mysqli_query($connect,"SELECT users_data.full_name, users_data.email, departament.name_dep FROM `users_data` INNER JOIN `departament` ON departament.id = users_data.departament_id WHERE `email` = '$email_user'");
                while ( $row = $select->fetch_array() ) {
            ?>
                         
                
                
                
                <div class="block_column_prof">  
                    <div class="block_item_prof">
                        <br><br>
                        <label id="prof_pe">Личные данные преподавателя:</label> </br>
                        

                    </div>
                </div>

                <div class="block_column_prof">  
                    <div class="block_item_prof">

                        <label id="prof_p">ФИО преподавателя:</label> </br>
                        <p id="cont_p"><?= $row['full_name'] ?></p>
                        

                    </div>
                </div>

                <div class="block_column_prof">
                    <div class="block_item_prof">

                        <label id="prof_p">Кафедра:</label> </br>
                        <p id="cont_p"><?= $row['name_dep'] ?></p>
                        
                    </div>
                </div>

                <div class="block_column_prof">
                    <div class="block_item_prof">

                        <label id="prof_p">Электронная почта:</label> </br>
                        <p id="cont_p"><?= $row['email'] ?></p>
                        
                    </div>
                </div>

                

                    <?php
                }
                ?>