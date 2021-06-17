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
                        
                        <a id="active_menu" href="profile.php" class="logout" >Добавить дипломную работу</a>
                    </div>
                </div>  

                 <div class="block_column_m">
                    <div class="blok_item_m">
                        
                        <a id="btn_menu" href="profile_cab_st.php" class="logout" >Личный кабинет</a>
                    </div>
                </div> 



               



                <div class="block_column_m">
                    <div class="blok_item_m">
                        <a id="btn_menu" href="add_work.php" class="logout" >Просмотр разрешенных работ</a>
                    </div>
                </div>


                




            </div>
        </div>

    </div>
<br>
<!-- Не принятая работа -->
<?php 
                $email_user = $_SESSION['user']['email'];
                
                $select = mysqli_query($connect,"SELECT works_reject.name_work, works_reject.id, works_reject.year, works_reject.name_student, accepted_teacher.full_name, direction.name_dir, works_reject.reasons FROM(( `works_reject` INNER JOIN `accepted_teacher` ON accepted_teacher.id = works_reject.name_lead) INNER JOIN `direction` ON direction.id = works_reject.direction) WHERE `email_stud` = '$email_user'");
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

                    
                   


            </div>
        </div>
    </div>
<!-- причина -->

<div class="wrapper_otziv">
        <div class="block_m">
            <div class="block_row_m">

            <form id="" action="mistakes_end.php" method="post">

                 <div class="block_column_m">
                    <div class="blok_item_m">
                         
                        <label id="f_in">Ваша работа была отклонена по причине(-ам):</label> </br>
                        <p><textarea name="comment" id="text_otz" disabled><?= $row['reasons'] ?></textarea></p>
                        
                       
                    </div>
                </div> 

            </form>

            </div>
        </div>

    </div>
    <?php
                    }
                ?>


<!-- форма отправки файлов -->
    <div class="wrapper_in">
        <div class="block_f_in">
            <div class="block_row_f_in">
                
                <form id="form_general" action="form.php" method="post" enctype="multipart/form-data">

                    <div class="block_column_f_in">

                    <label id="f_gl">Форма отправки файла:</label> </br>

                        <!-- Написание темы -->
                            <div class="blok_item_f_in">

                                <label id="f_in">Тема дипломной работы</label> 
                                <input id="filed_d" type="text" name="work_theme" placeholder="Введите свое полное имя студента" required> 
                            </div>

                       

                        <!-- Написание года -->
                            <div class="blok_item_f_in">

                                <label id="f_in">Год защиты</label> 
                                <input id="filed_d" type="text" name="year_prof" placeholder="Введите свое полное имя студента" required>
                            </div>

                        <!-- Выбор руководителя -->
                            <div class="blok_item_f_in">
                                <label id="f_in">ФИО руководителя</label> 
                                <?php
                                

                                    $select = mysqli_query($connect,"SELECT * FROM `accepted_teacher`"); 
                                ?>
                                    <select id="filed_d" class="form-control" name="full_name_lead">  
                                        <?php   while (($row = $select->fetch_array()) ) :?>

                                            <option value="<?= $row[0]?>"><?= $row[1]?></option> 

                                        <?php endwhile ?>
                                    </select>
                        
                            </div>

                        <!-- Выбор направления -->
                            <div class="blok_item_f_in">
                                <label id="f_in">Направление обучения</label> 
                                <?php
                                

                                    $select = mysqli_query($connect,"SELECT * FROM `direction`"); 
                                ?>
                                    <select id="filed_dir" class="form-control" name="direct_study">  
                                        <?php   while (($row = $select->fetch_array()) ) :?>

                                            <option value="<?= $row['id'];?>"><?= $row['name_dir']?></option> 

                                        <?php endwhile ?>
                                    </select>
                        
                            </div>
                    </div>

                
                    <input id="otp_file_f" type="file" name="filename"><br>
                    <input id="otp_file" type="submit" value="Отправить">
                    
                </form>

                
            
            
            </div>
        </div>
    </div>



   

<!-- Открытие работы -->
    <form id="form_open_file" action="open_file.php" method="post" enctype="multipart/form-data" target="_blank">


        <button id="btn_open" type="submit" > Открыть файл  </button>
        
        
    </form>

    <form id="form_open_file" action="delete_file.php" method="post" enctype="multipart/form-data" >


        <button id="btn_delete" type="submit" > Удалить файл  </button>
        
        
    </form>


<!-- Вывод ошибок -->
    <?php
        if ($_SESSION['message']) {
            echo '<p id="msg"> ' . $_SESSION['message'] . ' </p>';
        }
        unset($_SESSION['message']);
    ?>


<br><br><br><br><br><br><br><br><br><br><br>
    </body>
</html>