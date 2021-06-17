<?php
session_start();

if ($_SESSION['user']) {
    header('Location: profile.php');
}

if ($_SESSION['admin']) {
    header('Location: profile_ad.php');
}

require_once 'vendor/connect.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
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

                    

                   
                </div>
            </div>

        </div>
    </header>




<!-- Форма регистрации -->

    <div class="wrapper_in">
        <div class="block_f_in">
            <div class="block_row_f_in">

                <form id="form_general" action="vendor/signup.php" method="post" enctype="multipart/form-data">   

                    <div class="block_column_f_in">
                        <div class="blok_item_f_in">

                            <label id="f_in">ФИО</label> </br>
                            <input id="filed" type="text" name="full_name" placeholder="Введите свое полное имя" required>
                        </div>

                    

                        

                        <div class="blok_item_f_in">

                            <label id="f_in">Почта</label> </br>
                            <input id="filed" type="email" name="email" placeholder="Введите адрес своей почты" required>
                        </div>

                        <div class="blok_item_f_in">

                            <label id="f_in">Пароль</label> </br>
                            <input id="filed" type="password" name="password" placeholder="Введите пароль" required>
                        </div>

                        <div class="blok_item_f_in">

                            <label id="f_in">Подтверждение пароля</label> </br>
                            <input id="filed" type="password" name="password_confirm" placeholder="Подтвердите пароль" required>
                        </div>

                        <!-- Выбор группы -->
                            <div class="blok_item_f_in">
                                <label id="f_in">Группа</label> 
                                <?php
                                

                                    $select = mysqli_query($connect,"SELECT * FROM `groups_stud`"); 
                                ?>
                                    <select id="filed_dir" class="form-control" name="group_user">  
                                        <?php   while (($row = $select->fetch_array()) ) :?>

                                            <option value="<?= $row['id'];?>"><?= $row['name_group']?></option> 

                                        <?php endwhile ?>
                                    </select>
                        
                            </div>

                         

                    </div>

                
                    <button id="bt_reg" type="submit">Зарегестрироваться</button>

                    <p>
                        У вас уже есть аккаунт? - <a id="a_reg" href="/">Войдите</a>!
                    </p>

                
                </form>
                    
            
            </div>
        </div>
    </div>


<?php
    if ($_SESSION['message']) {
        echo '<p id="msg"> ' . $_SESSION['message'] . ' </p>';
    }
    unset($_SESSION['message']);
?>













</body>