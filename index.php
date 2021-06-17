<?php
session_start();

if ($_SESSION['user']) {
    header('Location: profile.php');
}
if ($_SESSION['admin']) {
    header('Location: profile_ad.php');
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
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

<!-- Форма авторизации -->



    <div class="wrapper_in">
        <div class="block_f_in">
            <div class="block_row_f_in">

                <form id="form_general" action="vendor/signin.php" method="post">

                    <div class="block_column_f_in">
                        <div class="blok_item_f_in">

                            <label id="f_in">Адрес электронной почты:</label> </br>
                            <input id="filed" type="text" name="email" placeholder="Введите свой логин" required>
                        </div>

                        <div class="blok_item_f_in">

                            <label id="f_in">Пароль:</label> </br>
                            <input id="filed" type="password" name="password" placeholder="Введите пароль" required>
                        </div>
                    </div>

                
                    <button id="bt_reg" type="submit">Войти</button>

                    <p>
                        У вас нет аккаунта? - <a id="a_reg" href="/register.php">Зарегистрируйтесь</a>.
                    </p>

                    <p>
                        Забыли парль? - <a id="a_reg" href="/password_reset.php">Перейдите по ссылке</a>.
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
</html>