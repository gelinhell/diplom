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
                        <button class="dropbtn" >Заявки на дипломные работы</button>
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
                            <button class="dropbtn_active">Предоставление прав на просмотр</button>
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

    
<!-- Форма поиска -->
    <form id="serch" action="accept_all_serch.php" method="post">
        <div class="wrapper_serch">
            <div class="block_serch">
                <div class="block_row_stud">
    
                
                     
                        <!-- Выбор студента  -->
                        <div class="blok_item_st">
                                <label id="ser">Студент выполнявший работу:</label> <br>
                           
                                <?php
                                

                                    $select = mysqli_query($connect,"SELECT DISTINCT name_student FROM `work_view`"); 
                                ?>
                                    <input type="text" list="filed_s_st_z" id="filed_s_st"  name="full_name_stud" autocomplete="off"/>
                                    <datalist id="filed_s_st_z" class="form_control"  > 
                                        
                                            <?php   while (($row = $select->fetch_array()) ) :?>

                                                <option value="<?= $row[0];?>"><?= $row['name_student']?></option> 

                                            <?php endwhile ?>
                                    </datalist>
                               
                            </div>

                         <!-- Выбор руководителя -->
                            <div class="blok_item_st">
                                <label id="ser">ФИО руководителя:</label> <br>
                           
                                <?php
                                    $select = mysqli_query($connect,"SELECT DISTINCT accepted_teacher.id, accepted_teacher.full_name FROM `work_view` INNER JOIN `accepted_teacher` ON accepted_teacher.id = work_view.name_lead"); 
                                ?>
                                    <input type="text" list="filed_s_st_x" id="filed_s_st"  name="full_name_lead" autocomplete="off"/>
                                    <datalist id="filed_s_st_x" class="form_control"  > 
                                        
                                            <?php   while (($row = $select->fetch_array()) ) :?>

                                                <option value="<?= $row[1];?>"><?= $row[1]?></option> 

                                            <?php endwhile ?>
                                    </datalist>
                               
                            </div>


                        <!-- Выбор темы -->
                      

                            <div class="blok_item_st">
                                <label id="ser">Тема работы:</label> <br>
                           
                                <?php
                                    $select = mysqli_query($connect,"SELECT DISTINCT name_work FROM `work_view`"); 
                                ?>
                                    <input type="text" list="filed_s_st_temaс" id="filed_s_st_tema"  name="them_name" autocomplete="off"/>
                                    <datalist id="filed_s_st_temaс" class="form_control"  > 
                                        
                                            <?php   while (($row = $select->fetch_array()) ) :?>

                                                <option value="<?= $row[0];?>"><?= $row['name_work']?></option> 

                                            <?php endwhile ?>
                                    </datalist>
                               
                            </div>



                    

                        <!-- Выбор года -->
                        

                            <div class="blok_item_st">
                                <label id="ser">Год защиты:</label> <br>
                           
                                <?php
                                    $select = mysqli_query($connect,"SELECT DISTINCT year FROM `work_view`"); 
                                ?>
                                    <input type="text" list="filed_s_st_year_a" id="filed_s_st_year"  name="year_work" autocomplete="off"/>
                                    <datalist id="filed_s_st_year_a" class="form_control"  > 
                                        
                                            <?php   while (($row = $select->fetch_array()) ) :?>

                                                <option value="<?= $row[0];?>"><?= $row['year']?></option> 

                                            <?php endwhile ?>
                                    </datalist>
                               
                            </div>


                        <!-- Выбор студента которому была назначена -->
                      



                            <div class="blok_item_st">
                                <label id="ser">Предоставлено студенту:</label> <br>
                           
                                <?php
                                    $select = mysqli_query($connect,"SELECT DISTINCT accepted_users.id, accepted_users.full_name, groups_stud.name_group FROM ((`work_view` INNER JOIN `accepted_users` ON accepted_users.id = work_view.whom_work) INNER JOIN `groups_stud` ON groups_stud.id = accepted_users.group_user)"); 
                                ?>
                                    <input type="text" list="filed_s_st_naz_c" id="filed_s_st_naz"  name="group_user" autocomplete="off"/>
                                    <datalist id="filed_s_st_naz_c" class="form_control"  > 
                                        
                                            <?php   while (($row = $select->fetch_array()) ) :?>

                                                <option value="<?= $row['full_name'];?>"><?= $row['full_name']?></option> 

                                            <?php endwhile ?>
                                    </datalist>
                               
                            </div>

                        <div class="block_column_ser_six">
                            <div class="block_item_ser_six">

                             <button id="bt_serch_teach" type="submit">Найти</button>
                                
                            </div>
                        </div>

                    
    
                </div>
            </div>
            
        </div>
    </form>

    <br>
<!-- Найденные работы -->

    <?php
        $full_name_stud = $_POST['full_name_stud'];
        $full_name_lead = $_POST['full_name_lead'];
        $them_name = $_POST['them_name'];    
        $year_work = $_POST['year_work']; 
        $whom_work = $_POST['whom_work'];  

        $contents = mysqli_query($connect, "SELECT work_view.id_work, work_view.name_work, work_view.year, work_view.name_student, accepted_users.full_name, accepted_teacher.full_name, work_view.id FROM (( `work_view` INNER JOIN `accepted_users` ON accepted_users.id = work_view.whom_work) INNER JOIN `accepted_teacher`ON accepted_teacher.id = work_view.name_lead) 
                                            WHERE `name_work` LIKE '%$them_name%' AND work_view.year LIKE '%$year_work%' AND `name_student` LIKE '%$full_name_stud%' AND accepted_users.full_name LIKE '%$whom_work%' AND accepted_teacher.full_name LIKE '%$full_name_lead%'");
        $contents = mysqli_fetch_all($contents);
        foreach ($contents as $content) {
    ?>


    <div class="wrapper_ser">
                <div class="block_ser">
                    <div class="block_row_ser_teach">
        
                    

                            <div class="block_column_ser_one">  
                                <div class="block_item_ser_one">

                                    <label id="ser_s_st">Студент:</label> </br>
                                    <p id="cont_del_fio_one"><?= $content[3] ?></p>

                                </div>
                            </div>

                            <div class="block_column_ser_two">
                                <div class="block_item_ser_two">

                                    <label id="ser_s">Руководитель:</label> </br>
                                    <p id="cont_del_fio"><?= $content[5] ?></p>
                                    
                                </div>
                            </div>

                            <div class="block_column_ser_three">
                                <div class="block_item_ser_three">

                                    <label id="ser_s">Тема работы:</label> </br>
                                    <p id="cont_del_tem"><?= $content[1] ?></p>
                                    
                                </div>
                            </div>


                            <div class="block_column_ser_five">
                                <div class="block_item_ser_five">

                                    <label id="ser_s">Год защиты:</label> </br>
                                    <p id="cont_del_year"><?= $content[2] ?></p>
                                    
                                </div>
                            </div>

                            <div class="block_column_ser_two">
                                <div class="block_item_ser_two">

                                    <label id="ser_s">Назначена студенту:</label> </br>
                                    <p id="cont_del_st"><?= $content[4] ?></p>
                                    
                                </div>
                            </div>

                            <div class="block_column_ser_six">
                                <div class="block_item_ser_six">

                                    <a target="_blank" id="btn_open_teach" href="/open_file_all.php?id='.<?= $content[0] ?>.'"><batton >Открыть</batton></a> 

                                    <a  id="btn_open_teach" href="/vendor/delete_prava.php?id='.<?= $content[6] ?>.'"><batton >Удалить</batton></a>
                                    
                                </div>
                            </div>

                        
        
                    </div>
                </div>
            </div>
            


        <?php
            }
        ?>