<?php
session_start();

if (!$_SESSION['user']) {
    header('Location: index.php');
}

require_once 'connect.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Поиск дипломных работ</title>
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
                        <h2 style="margin: 10px 0;" id="name_user"><?= $_SESSION['user']['full_name'] ?> </h2>
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
                            <a id="btn_menu" href="../profile.php" class="logout">Добавить дипломную работу</a>
                        </div>
                    </div>  

                    

                    <div class="block_column_m">
                        <div class="blok_item_m">
                            <a id="active_menu" href="../add_work.php" class="logout">Найти дипломную работу</a>
                        </div>
                    </div>

                </div>
            </div>

        </div>

<!-- Форма поиска -->
    
    <form id="serch" action="serch.php" method="post">
        <div class="wrapper_serch">
            <div class="block_serch">
                <div class="block_row_serch">
    
                

                        <div class="block_column_ser_one">  
                            <div class="block_item_ser_one">

                                <label id="ser">ФИО студента:</label> </br>
                                <input id="filed_s_one" type="text" name="full_name_stud" placeholder="Введите полное имя студента">

                            </div>
                        </div>

                        <div class="block_column_ser_two">
                            <div class="block_item_ser_two">

                                <label id="ser">ФИО руководителя:</label> </br>
                                <input id="filed_s" type="text" name="full_name_lead" placeholder="Введите полное имя руководителя">
                                
                            </div>
                        </div>

                        <div class="block_column_ser_three">
                            <div class="block_item_ser_three">

                                <label id="ser">Тема работы:</label> </br>
                                <input id="filed_s" type="text" name="work_theme" placeholder="Введите тему работы">
                                
                            </div>
                        </div>

                        <div class="block_column_ser_four">
                            <div class="block_item_ser_four">

                                <label id="ser">Направление обучения:</label> </br>
                                <input id="filed_s_fhour" type="text" name="direct_study" placeholder="Введите направление обучения">
                                
                            </div>
                        </div>

                        <div class="block_column_ser_five">
                            <div class="block_item_ser_five">

                                <label id="ser">Год защиты:</label> </br>
                                <input id="filed_s_five" type="text" name="year_prof" placeholder="Год защиты">
                                
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





<!-- Найденные работы -->
    <?php

        
        $full_name_stud = $_POST['full_name_stud'];
            $full_name_lead = $_POST['full_name_lead'];
            $work_theme = $_POST['work_theme'];
            $direct_study = $_POST['direct_study'];
            $year_prof = $_POST['year_prof'];

            $serch_works = mysqli_query($connect, "SELECT * FROM `work` WHERE   ( `full_name_stud` LIKE '%$full_name_stud%' AND `full_name_lead` LIKE '%$full_name_lead%' ) AND (`work_theme` LIKE '%$work_theme%' ) AND (`direct_study` LIKE '%$direct_study%') AND (`year_prof` LIKE '%$year_prof%' ) ");
            $serch_works = mysqli_fetch_all($serch_works);
            foreach ($serch_works as $serch_work) {
                ?>

            <div class="wrapper_ser">
                <div class="block_ser">
                    <div class="block_row_ser">
        
                    

                            <div class="block_column_ser_one">  
                                <div class="block_item_ser_one">

                                    <label id="ser_s">Студент:</label> </br>
                                    <p id="cont_one"><?= $serch_work[2] ?></p>

                                </div>
                            </div>

                            <div class="block_column_ser_two">
                                <div class="block_item_ser_two">

                                    <label id="ser_s">Руководитель:</label> </br>
                                    <p id="cont"><?= $serch_work[3] ?></p>
                                    
                                </div>
                            </div>

                            <div class="block_column_ser_three">
                                <div class="block_item_ser_three">

                                    <label id="ser_s">Тема работы:</label> </br>
                                    <p id="cont"><?= $serch_work[4] ?></p>
                                    
                                </div>
                            </div>

                            <div class="block_column_ser_four">
                                <div class="block_item_ser_four">

                                    <label id="ser_s">Направление обучения:</label> </br>
                                    <p id="cont_fhour"><?= $serch_work[5] ?></p>
                                    
                                </div>
                            </div>

                            <div class="block_column_ser_five">
                                <div class="block_item_ser_five">

                                    <label id="ser_s">Год защиты:</label> </br>
                                    <p id="cont_five"><?= $serch_work[6] ?></p>
                                    
                                </div>
                            </div>

                            <div class="block_column_ser_six">
                                <div class="block_item_ser_six">

                                    <a target="_blank" id="bt_open" href="/open_file_all.php?id='.<?= $serch_work[0] ?>.'"><batton >Открыть</batton></a>
                                    
                                </div>
                            </div>

                        
        
                    </div>
                </div>
            </div>




        <?php
            }
        ?>





</body>