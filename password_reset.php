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
    <title>Сброс пароля</title>
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

                <form id="form_general" action="vendor/reset.php" method="post">

                    <div class="block_column_f_in">
                        <div class="blok_item_f_in">

                            <label id="f_in">Адрес электронной почты:</label> </br>
                            <input id="filed" type="text" name="email" placeholder="Введите свой email">
                        </div>

                        <button id="bt_reg" type="submit">Сбросить</button>

                    <p>
                         <a id="a_reg" href="/index.php">Вернуться назад</a>
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