<?php
session_start();

if (!$_SESSION['teacher']) {
    header('Location: index.php');
}

require_once 'connect.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="../assets/css/main.css">
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
                            <a id="bt_ex" href="logout.php" class="logout">Выйти</a>
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
                            <a href="../request_dip_new.php">Новые заявки</a>
                            <a href="../request_dip_acc.php">Принятые работы</a>
                            
                        </div>
                    </div>

                    </div>
                </div>  

                 <div class="block_column_m">
                    <div class="blok_item_m">
                        
                        <a id="btn_menu" href="../profile_teacher.php" class="logout" >Личный кабинет</a>
                    </div>
                </div> 

                <div class="block_column_m">
                    <div class="blok_item_m">
                        <div class="dropdown">
                            <button class="dropbtn_active">Предоставление прав на просмотр</button>
                            <div class="dropdown-content">
                                <a href="../access.php">Предоставить студенту</a>
                                <a href="../access_all.php">Все предоставленные работы</a>
                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


<!-- Форма поиска -->

    <form id="serch_teacher" action="serch_teacher.php" method="post">
        <div class="wrapper_serch_teacher">
            <div class="block_serch_teacher">
                <div class="block_row_serch_teacher">
    
                

                        <!-- Выбор имени студента -->
                        <div class="block_column_ser_five">
                                <label id="ser">Направление обучения</label> 
                                <div class="block_item_ser_five">
                                <?php
                                

                                    $select = mysqli_query($connect,"SELECT * FROM `accepted_users`"); 
                                ?>
                                    <input type="text" list="filed_s_fhour_x" id="filed_s_one" name="full_name_stud" autocomplete="off"/>
                                    <datalist id="filed_s_fhour_x" class="form_control" > 
                                        
                                            <?php   while (($row = $select->fetch_array()) ) :?>

                                                <option value="<?= $row['full_name'];?>"><?= $row['full_name']?></option> 

                                            <?php endwhile ?>
                                    </datalist>
                                </div>
                            </div>


                        

                         <!-- Выбор направления -->
                         <div class="block_column_ser_five">
                                <label id="ser">Направление обучения</label> 
                                <div class="block_item_ser_five">
                                <?php
                                

                                    $select = mysqli_query($connect,"SELECT DISTINCT  direction.name_dir FROM ((`accepted_users` INNER JOIN `groups_stud` ON groups_stud.id = accepted_users.group_user) INNER JOIN `direction` ON direction.id = groups_stud.Direction_id)"); 
                                ?>
                                    <input type="text" list="filed_s_fhour" id="filed_s_fhour_new"  name="direct_study" autocomplete="off"/>
                                    <datalist id="filed_s_fhour" class="form_control"  > 
                                        
                                            <?php   while (($row = $select->fetch_array()) ) :?>

                                                <option value="<?= $row['name_dir'];?>"><?= $row['name_dir']?></option> 

                                            <?php endwhile ?>
                                    </datalist>
                                </div>
                            </div>
                            
                       


                         <!-- Выбор группы -->
                         <div class="block_column_ser_five">
                                <label id="ser">Группа</label> 
                                <div class="block_item_ser_five">
                                <?php
                                

                                    $select = mysqli_query($connect,"SELECT DISTINCT  groups_stud.name_group FROM (`accepted_users` INNER JOIN `groups_stud` ON groups_stud.id = accepted_users.group_user) "); 
                                ?>
                                    <input type="text" list="filed_dir_ser_st_z" id="filed_dir_ser_st"  name="group_user" autocomplete="off"/>
                                    <datalist id="filed_dir_ser_st_z" class="form_control"  > 
                                        
                                            <?php   while (($row = $select->fetch_array()) ) :?>

                                                <option value="<?= $row['name_group'];?>"><?= $row['name_group']?></option> 

                                            <?php endwhile ?>
                                    </datalist>
                                </div>
                            </div>

                        <div class="block_column_ser_six">
                            <div class="block_item_ser_six">

                             <button id="bt_reg" type="submit">Найти</button>
                                
                            </div>
                        </div>

                    
    
                </div>
            </div>
            
        </div>
    </form>

<!-- Контент поиска -->

<?php

        
    $full_name_stud = $_POST['full_name_stud'];
    $direct_study = $_POST['direct_study'];
    $group_user = $_POST['group_user'];                                       

    $serch_works = mysqli_query($connect, "SELECT accepted_users.id,accepted_users.full_name, groups_stud.name_group, direction.name_dir FROM(( `accepted_users` INNER JOIN `groups_stud` ON groups_stud.id = accepted_users.group_user) INNER JOIN `direction` ON direction.id = groups_stud.Direction_id) WHERE full_name LIKE '%$full_name_stud%' AND name_dir LIKE '%$direct_study%' AND name_group LIKE '%$group_user%'");
    $serch_works = mysqli_fetch_all($serch_works);
    foreach ($serch_works as $serch_work) {
        ?>

    <div class="wrapper_serch_teacher_stud">
        <div class="block_ser">
            <div class="block_row_ser">

            

                    <div class="block_column_ser_one">  
                        <div class="block_item_ser_one">

                            <label id="ser_s">Студент:</label> </br>
                            <p id="cont_one"><?= $serch_work[1] ?></p>

                        </div>
                    </div>

                   

                    <div class="block_column_ser_three">
                        <div class="block_item_ser_three">

                            <label id="ser_s">Направление обучения:</label> </br>
                            <p id="cont_ser_st"><?= $serch_work[3] ?></p>
                            
                        </div>
                    </div>

                    <div class="block_column_ser_four">
                        <div class="block_item_ser_four">

                            <label id="ser_s">Группа:</label> </br>
                            <p id="cont_fhour_ser_st"><?= $serch_work[2] ?></p>
                            
                        </div>
                    </div>

                  

                    <div class="block_column_ser_six">
                        <div class="block_item_ser_six">

                            <a  id="bt_open" href="/student_prava.php?id='.<?= $serch_work[0] ?>.'"><batton >Открыть</batton></a>
                            
                        </div>
                    </div>

                

            </div>
        </div>
    </div>




<?php
    }
?>


