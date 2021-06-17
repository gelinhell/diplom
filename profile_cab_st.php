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
                        
                        <a id="btn_menu" href="profile.php" class="logout" >Добавить дипломную работу</a>
                    </div>
                </div>  

                 <div class="block_column_m">
                    <div class="blok_item_m">
                        
                        <a id="active_menu" href="profile_cab_st.php" class="logout" >Личный кабинет</a>
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

<!-- Содержимое страницы -->
    <div class="wrapper_prof">
        <div class="block_prof">
            <div class="block_row_prof">

            <?php 
                $email_user = $_SESSION['user']['email'];
                
                $select = mysqli_query($connect,"SELECT accepted_users.full_name, accepted_users.email, groups_stud.name_group, direction.code, direction.name_dir FROM(( `accepted_users` INNER JOIN `groups_stud` ON groups_stud.id = accepted_users.group_user) INNER JOIN `direction` ON direction.id = groups_stud.Direction_id) WHERE `email` = '$email_user'");
                while ( $row = $select->fetch_array() ) {
            ?>
            
            
            <div class="block_column_prof">  
                    <div class="block_item_prof">
                        <br><br>
                        <label id="prof_pe">Личные данные студента:</label> </br>
                        

                    </div>
                </div>

                <div class="block_column_prof">  
                    <div class="block_item_prof">

                        <label id="prof_p">ФИО студента:</label> </br>
                        <p id="cont_p"><?= $row['full_name'] ?></p>
                        

                    </div>
                </div>

                <div class="block_column_prof">
                    <div class="block_item_prof">

                        <label id="prof_p">Направление обучения:</label> </br>
                        <p id="cont_p"><?= $row['code'] ?></p>
                        
                    </div>
                </div>

                <div class="block_column_prof">
                    <div class="block_item_prof">

                        <label id="prof_p">Направление обучения:</label> </br>
                        <p id="cont_p"><?= $row['name_dir'] ?></p>
                        
                    </div>
                </div>

                <div class="block_column_prof">
                    <div class="block_item_prof">

                        <label id="prof_p">Группа:</label> </br>
                        <p id="cont_p"><?= $row['name_group'] ?></p>
                        
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
                

                        
        
            </div>
        </div>
    </div>

    </body>
</html>