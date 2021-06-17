<?php
session_start();

if (!$_SESSION['user']) {
    header('Location: index.php');
}

require_once 'vendor/connect.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Дипломные работы</title>
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
                        <h2 style="margin: 10px 0;" id="name_user"><?= $_SESSION['user']['full_name'] ?> </h2>
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
                            <a id="btn_menu" href="profile.php" class="logout">Добавить дипломную работу</a>
                        </div>
                    </div>  

                    <div class="block_column_m">
                    <div class="blok_item_m">
                        
                        <a id="btn_menu" href="profile_cab_st.php" class="logout" >Личный кабинет</a>
                    </div>
                </div> 
                    

                    <div class="block_column_m">
                        <div class="blok_item_m">
                            <a id="active_menu" href="add_work.php" class="logout">Просмотр разрешенных работ</a>
                        </div>
                    </div>

                </div>
            </div>

        </div>



<!-- Предоставил доступ -->
            <?php
                $email_st_c = $_SESSION['user']['email'];

                $codes = mysqli_query($connect, "SELECT * FROM `accepted_users` WHERE `email` = '$email_st_c' ");
                $codes = mysqli_fetch_all($codes);
                foreach ($codes as $code) { 

                    $name_teachers = mysqli_query($connect, "SELECT work_view.id_work, accepted_teacher.full_name FROM (`work_view` INNER JOIN `accepted_teacher` ON accepted_teacher.id = work_view.id_teacher) WHERE work_view.code_work = '$code[6]'");
                    $name_teachers = mysqli_fetch_all($name_teachers);
                    foreach ($name_teachers as $name_teacher) { 


                    
                    
                
            ?>


    <form id="serch" action="vendor/serch.php" method="post">
        <div class="wrapper_serch">
            <div class="block_serch">
                <div class="block_row_serch">
    
                

                        <div class="block_column_ser_one">  
                            <div class="block_item_ser_one">

                                <label id="ser">Предоставил доступ к работе:</label> </br>
                                <p id="cont_one"><?= $name_teacher[1] ?></p>

                            </div>
                        </div>

                       
                    
    
                </div>
            </div>
            
        </div>
    </form>

    <?php
        }
        }
    ?>

<br>
<!-- Контент сайта -->
        
<?php
                $email_st_c = $_SESSION['user']['email'];

                $code_twos = mysqli_query($connect, "SELECT * FROM `accepted_users` WHERE `email` = '$email_st_c' ");
                $code_twos = mysqli_fetch_all($code_twos);
                foreach ($code_twos as $code_two) { 
                    $code_work = $code_two[6];
                }
                    $contents = mysqli_query($connect, "SELECT work_view.id_work, work_view.name_work, work_view.year, work_view.name_student, accepted_teacher.full_name  FROM (`work_view` INNER JOIN `accepted_teacher` ON accepted_teacher.id = work_view.name_lead)  WHERE work_view.code_work = '$code_work'");
                    $contents = mysqli_fetch_all($contents);
                    foreach ($contents as $content) {
                
            ?>

           

    <div class="wrapper_ser">
                <div class="block_ser">
                    <div class="block_row_ser">
        
           

                            <div class="block_column_ser_one">  
                                <div class="block_item_ser_one">

                                    <label id="ser_s">Студент:</label> </br>
                                    <p id="cont_one"><?= $content[3] ?></p>

                                </div>
                            </div>

                            <div class="block_column_ser_two">
                                <div class="block_item_ser_two">

                                    <label id="ser_s">Руководитель:</label> </br>
                                    <p id="cont"><?= $content[4] ?></p>
                                    
                                </div>
                            </div>

                            <div class="block_column_ser_three">
                                <div class="block_item_ser_three">

                                    <label id="ser_s">Тема работы:</label> </br>
                                    <p id="cont_tema"><?= $content[1] ?></p>
                                    
                                </div>
                            </div>

                           

                            <div class="block_column_ser_five">
                                <div class="block_item_ser_five">

                                    <label id="ser_s">Год защиты:</label> </br>
                                    <p id="cont_five"><?= $content[2] ?></p>
                                    
                                </div>
                            </div>

                            <div class="block_column_ser_six">
                                <div class="block_item_ser_six">

                                    <a target="_blank" id="bt_open" href="/open_file_all.php?id='.<?= $content[0] ?>.'"><batton >Открыть</batton></a>
                                    
                                </div>
                            </div>
                            <?php
            }
        ?>

                        
        
                    </div>
                </div>
            </div>
            


     



</body>
</html>