<?php
    require_once 'vendor/connect.php';
    session_start();

    if (!$_SESSION['teacher']) {
        header('Location: index.php');
    }

    $id = $_GET['id'];
    $id_f = array($id);

    unset($_SESSION['work_id']);

   
   foreach($id_f as $key => $item){
       $id_f[$key] = preg_replace('/[^0-9]+/', '', $item);
    }
    
    $_SESSION['student_id'] = [
        "id" => $id_f[0],
       
    ];
    //echo $id_f[0];

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


<!-- Права предоставляются... -->

    <div class="wrapper_ser">
        <div class="block_prava_st_zag">
            <div class="block_row_ser_zag">

                <div class="block_column_ser_one">  
                    <div class="block_item_ser_one">

                        <label id="ser_s_zag">Предоставлени права студенту:</label> </br>
                    

                    </div>
                </div>

            </div>
        </div>
    </div>

<!-- Личная информация о студенте -->
     
    <?php
       
       
       $students = mysqli_query($connect, "SELECT accepted_users.id, accepted_users.full_name, accepted_users.email, groups_stud.name_group, direction.name_dir FROM ((`accepted_users` INNER JOIN `groups_stud` ON groups_stud.id = accepted_users.group_user) INNER JOIN `direction`ON direction.id = groups_stud.Direction_id) WHERE accepted_users.id = '$id_f[0]'");
       $students = mysqli_fetch_all($students);
       foreach ($students as $student) {

   ?>


    <div class="wrapper_student">
        <div class="block_student">
            <div class="block_row_student">

            

                <div class="block_column_student">  
                    <div class="block_item_student">

                        <label id="ser_st">ФИО студента:</label> </br>
                        <p id="st_dan"><?= $student[1] ?></p>

                    </div>
                </div>

                <div class="block_column_student">
                    <div class="block_item_student">

                        <label id="ser_st">Направление:</label> </br>
                        <p id="st_dan_direct"><?= $student[4] ?></p>
                    </div>
                </div>


                <div class="block_column_student">
                  
                    <div class="block_item_student">

                        <label id="ser_st">Группа:</label> </br>
                        <p id="st_dan_gr"><?= $student[3] ?></p>
                        
                    </div>
                </div>



                <div class="block_column_ser_six">
                    <div class="block_item_ser_six">

                    <a  id="bt_open" href="/access.php"><batton >Назад</batton></a>
                        
                    </div>
                </div>
               

            </div>
        </div>
            
        </div>
    <?php
       }
       ?>
               
                
<!-- Оглавление добавленных работ студенту -->
    <div class="wrapper_ser">
        <div class="block_prava_ogl">
            <div class="block_prava">

            

                    <div class="block_column_ser_one">  
                        <div class="block_item_ser_one">

                            <label id="ser_prava_dob">Доступные для просмотра работы:</label> </br>
                           

                        </div>
                    </div>


            </div>
        </div>
    </div>

<!-- Отображение добавленных работ -->       

    <?php
       
       
            $contents = mysqli_query($connect, "SELECT work_view.name_work, work_view.id_work, work_view.year, work_view.name_student, accepted_teacher.full_name, direction.name_dir, work_view.email_stud, accepted_users.full_name, accepted_users.id, work_view.id FROM((( `work_view` INNER JOIN `accepted_teacher` ON accepted_teacher.id = work_view.name_lead) INNER JOIN `direction` ON direction.id = work_view.direction) INNER JOIN `accepted_users` ON accepted_users.id = work_view.whom_work) WHERE work_view.whom_work = '$id_f[0]' AND work_view.code_work = accepted_users.code_work ");
            $contents = mysqli_fetch_all($contents);
            foreach ($contents as $content) {

        ?>
                
                <div class="wrapper_ser_cr">
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
                                                <p id="cont"><?= $content[0] ?></p>
                                                
                                            </div>
                                        </div>

                                        <div class="block_column_ser_four">
                                            <div class="block_item_ser_four">

                                                <label id="ser_s">Направление обучения:</label> </br>
                                                <p id="cont_fhour"><?= $content[5] ?></p>
                                                
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

                                                <a target="_blank" id="bt_open" href="/open_file_all.php?id='.<?= $content[1] ?>.'"><batton >Открыть</batton></a>
                                                
                                            </div>
                                        </div>

                                        <div class="block_column_ser_six">
                                            <div class="block_item_ser_six">

                                                <a  id="bt_open" href="/vendor/st_prava_dell.php?id='.<?= $content[9] ?>.'"><batton >Удалить</batton></a>
                                                
                                            </div>
                                        </div>

                                    
                    
                                </div>
                            </div>
                        </div>
            
                        

                        <?php
                            }
                            ?>
                            <br><br><br><br>

        


<!-- Все работы оглавление -->   

    <div class="wrapper_ser">
        <div class="block_prava_ogl">
            <div class="block_prava">

            

                    <div class="block_column_ser_one">  
                        <div class="block_item_ser_one">

                            <label id="ser_prava_dob">Все работы:</label> </br>
                           

                        </div>
                    </div>


            </div>
        </div>
    </div>

<!-- Поиск по всем работам -->

    <form id="serch" action="student_prava_serch.php" method="post">
        <div class="wrapper_serch">
            <div class="block_serch">
                <div class="block_row_stud">
    
                
              

                        <!--  Выбор студента -->
                            <div class="blok_item_st">
                                <label id="ser">ФИО студента</label> <br>
                                
                                <?php
                                

                                    $select = mysqli_query($connect,"SELECT DISTINCT name_student FROM `work`"); 
                                ?>
                                    <input type="text" list="filed_s_st_z" id="filed_s_st"  name="full_name_stud" autocomplete="off"/>
                                    <datalist id="filed_s_st_z" class="form_control"  > 
                                        
                                            <?php   while (($row = $select->fetch_array()) ) :?>

                                                <option value="<?= $row['name_student'];?>"><?= $row['name_student']?></option> 

                                            <?php endwhile ?>
                                    </datalist>
                                
                            </div>

                         <!-- Выбор руководителя -->
                  

                            <div class="blok_item_st">
                                <label id="ser">ФИО руководителя</label> <br>
                                
                                <?php
                                

                                    $select = mysqli_query($connect,"SELECT DISTINCT  accepted_teacher.full_name FROM `accepted_teacher` INNER JOIN `work` ON accepted_teacher.id = work.name_lead"); 
                                ?>
                                    <input type="text" list="filed_s_st_q" id="filed_s_st"  name="full_name_lead" autocomplete="off"/>
                                    <datalist id="filed_s_st_q" class="form_control"  > 
                                        
                                            <?php   while (($row = $select->fetch_array()) ) :?>

                                                <option value="<?= $row['full_name'];?>"><?= $row['full_name']?></option> 

                                            <?php endwhile ?>
                                    </datalist>
                                
                            </div>


                        <!-- Выбор темы -->
                  


                            <div class="blok_item_st">
                                <label id="ser">Тема работы</label> <br>
                                
                                <?php
                                

                                    $select = mysqli_query($connect,"SELECT DISTINCT name_work FROM `work`"); 
                                ?>
                                    <input type="text" list="filed_s_st_tema_s" id="filed_s_st_tema"  name="them_name" autocomplete="off"/>
                                    <datalist id="filed_s_st_tema_s" class="form_control"  > 
                                        
                                            <?php   while (($row = $select->fetch_array()) ) :?>

                                                <option value="<?= $row['name_work'];?>"><?= $row['name_work']?></option> 

                                            <?php endwhile ?>
                                    </datalist>
                                
                            </div>


                        <!-- Выбор темы -->
                        
                             <div class="blok_item_st">
                                <label id="ser">Направление обучения</label> <br>
                                
                                <?php
                                

                                    $select = mysqli_query($connect,"SELECT DISTINCT  direction.name_dir FROM `direction` INNER JOIN `work` ON direction.id = work.direction"); 
                                ?>
                                    <input type="text" list="filed_s_st_tema_w" id="filed_s_st_tema"  name="direction" autocomplete="off"/>
                                    <datalist id="filed_s_st_tema_w" class="form_control"  > 
                                        
                                            <?php   while (($row = $select->fetch_array()) ) :?>

                                                <option value="<?= $row['name_dir'];?>"><?= $row['name_dir']?></option> 

                                            <?php endwhile ?>
                                    </datalist>
                                
                            </div>
                    

                        <!-- Выбор года -->
                      

                            <div class="blok_item_st">
                                <label id="ser">Год защиты</label> <br>
                                
                                <?php
                                

                                    $select = mysqli_query($connect,"SELECT DISTINCT year FROM `work`"); 
                                ?>
                                    <input type="text" list="filed_s_st_year_z" id="filed_s_st_year"  name="year_work" autocomplete="off"/>
                                    <datalist id="filed_s_st_year_z" class="form_control"  > 
                                        
                                            <?php   while (($row = $select->fetch_array()) ) :?>

                                                <option value="<?= $row['year'];?>"><?= $row['year']?></option> 

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

<!-- Отображение всех работ  -->
    <?php
       
       
        $contzents = mysqli_query($connect, "SELECT work.name_work, work.id, work.year, work.name_student, accepted_teacher.full_name, direction.name_dir, work.email_stud FROM(( `work` INNER JOIN `accepted_teacher` ON accepted_teacher.id = work.name_lead) INNER JOIN `direction` ON direction.id = work.direction)  ");
        $contzents = mysqli_fetch_all($contzents);
        foreach ($contzents as $contzent) {
            ?>


    <div class="wrapper_ser_cr">
                <div class="block_ser">
                    <div class="block_row_ser">
        
                    

                            <div class="block_column_ser_one">  
                                <div class="block_item_ser_one">

                                    <label id="ser_s">Студент:</label> </br>
                                    <p id="cont_one"><?= $contzent[3] ?></p>

                                </div>
                            </div>

                            <div class="block_column_ser_two">
                                <div class="block_item_ser_two">

                                    <label id="ser_s">Руководитель:</label> </br>
                                    <p id="cont"><?= $contzent[4] ?></p>
                                    
                                </div>
                            </div>

                            <div class="block_column_ser_three">
                                <div class="block_item_ser_three">

                                    <label id="ser_s">Тема работы:</label> </br>
                                    <p id="cont"><?= $contzent[0] ?></p>
                                    
                                </div>
                            </div>

                            <div class="block_column_ser_four">
                                <div class="block_item_ser_four">

                                    <label id="ser_s">Направление обучения:</label> </br>
                                    <p id="cont_fhour"><?= $contzent[5] ?></p>
                                    
                                </div>
                            </div>

                            <div class="block_column_ser_five">
                                <div class="block_item_ser_five">

                                    <label id="ser_s">Год защиты:</label> </br>
                                    <p id="cont_five"><?= $contzent[2] ?></p>
                                    
                                </div>
                            </div>

                            <div class="block_column_ser_six">
                                <div class="block_item_ser_six">

                                    <a target="_blank" id="bt_open" href="/open_file_all.php?id='.<?= $contzent[1] ?>.'"><batton >Открыть</batton></a>
                                    
                                </div>
                            </div>

                            <div class="block_column_ser_six">
                                <div class="block_item_ser_six">

                                    <a  id="bt_open" href="/vendor/st_prava_allow.php?id='.<?= $contzent[1] ?>.'"><batton >Добавить</batton></a>
                                    
                                </div>
                            </div>

                        
        
                    </div>
                </div>
            </div>
            


        <?php
            }
        ?>