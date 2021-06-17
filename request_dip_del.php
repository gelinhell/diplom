<?php
session_start();

if (!$_SESSION['teacher']) {
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
                        <a id="btn_menu" href="access.php" class="logout" >Найти дипломную работу</a>
                    </div>
                </div>

            </div>
        </div>

    </div>