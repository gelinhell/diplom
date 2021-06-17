<?php
session_start();
require_once 'vendor/connect.php';
$all_files = $_FILES["filename"];

// Функция конвертации
	function translit_file($filename){
		$converter = array(
			'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
			'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
			'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
			'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
			'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
			'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
			'э' => 'e',    'ю' => 'yu',   'я' => 'ya',

			'А' => 'A',    'Б' => 'B',    'В' => 'V',    'Г' => 'G',    'Д' => 'D',
			'Е' => 'E',    'Ё' => 'E',    'Ж' => 'Zh',   'З' => 'Z',    'И' => 'I',
			'Й' => 'Y',    'К' => 'K',    'Л' => 'L',    'М' => 'M',    'Н' => 'N',
			'О' => 'O',    'П' => 'P',    'Р' => 'R',    'С' => 'S',    'Т' => 'T',
			'У' => 'U',    'Ф' => 'F',    'Х' => 'H',    'Ц' => 'C',    'Ч' => 'Ch',
			'Ш' => 'Sh',   'Щ' => 'Sch',  'Ь' => '',     'Ы' => 'Y',    'Ъ' => '',
			'Э' => 'E',    'Ю' => 'Yu',   'Я' => 'Ya',
		);
		
		$new = '';
		
		$file = pathinfo(trim($filename));
		if (!empty($file['dirname']) && @$file['dirname'] != '.') {
			$new .= rtrim($file['dirname'], '/') . '/';
		}

		if (!empty($file['filename'])) {
			$file['filename'] = str_replace(array(' ', ','), '-', $file['filename']);
			$file['filename'] = strtr($file['filename'], $converter);
			$file['filename'] = mb_ereg_replace('[-]+', '-', $file['filename']);
			$file['filename'] = trim($file['filename'], '-');					
			$new .= $file['filename'];
		}

		if (!empty($file['extension'])) {
			$new .= '.' . $file['extension'];
		}
		
			return $new;
	}
	

	$new_file_name = translit_file($_FILES['filename']['name']);
	$origin_file_name = time() .  $new_file_name;


/* Входные данные */ 
	$email_stud = $_SESSION['user']['email'];
	$full_name_stud = $_SESSION['user']['full_name'];

	$full_name_lead = $_POST['full_name_lead'];
	$work_theme = $_POST['work_theme'];
	$direct_study = $_POST['direct_study'];
	$year_prof = $_POST['year_prof'];

// функция для нормальной отправки русского текста
	function utf8mail($to,$s,$body){
	$from_name="Права для просмотра";
	$from_a = "Dima@diplom.kz";
	$reply="Dima@diplom.kz";
	$s= "=?utf-8?b?".base64_encode($s)."?=";
	$headers = "MIME-Version: 1.0\r\n";
	$headers.= "From: =?utf-8?b?".base64_encode($from_name)."?= <".$from_a.">\r\n";
	$headers.= "Content-Type: text/plain;charset=utf-8\r\n";
	$headers.= "Reply-To: $reply\r\n";  
	$headers.= "X-Mailer: PHP/" . phpversion();
	mail($to, $s, $body, $headers);
	} 




/* Ограничение на добавление файлов */

	if($_FILES['filename']['type'] !== "application/pdf"){
		header('Location: ../profile.php');
		die($_SESSION['message'] = 'Загружать файлы можно только в расширении ".pdf"');
	};


/* Загрузка файла */

	$check_file_works = mysqli_query($connect, "SELECT * FROM `work` WHERE `email_stud` = '$email_stud' ");
    if (mysqli_num_rows($check_file_works) > 0 ) {

        $_SESSION['message'] = 'Вы уже загружали работу.';
        header('Location: ../profile.php');
        
           

    }else{

		$check_file_check_work = mysqli_query($connect, "SELECT * FROM `works_check` WHERE `email_stud` = '$email_stud' ");
    	if (mysqli_num_rows($check_file_check_work) > 0 ) {

			$_SESSION['message'] = 'Вы уже загружали работу.';
       	 	header('Location: ../profile.php');

		}else{

			$check_file_work_reject = mysqli_query($connect, "SELECT * FROM `works_reject` WHERE `email_stud` = '$email_stud' ");
    		if (mysqli_num_rows($check_file_work_reject) > 0 ) {

				$_SESSION['message'] = 'Вы уже загружали работу.';
				header('Location: ../profile.php');

			}else{


				if(move_uploaded_file($_FILES['filename']['tmp_name'], 'files/'.$origin_file_name)){

					$select = mysqli_query($connect,"SELECT * FROM `accepted_teacher` WHERE `id` = '$full_name_lead'");
                	while ( $row = $select->fetch_array() ) {

						$tmp_way = 'files/'.$origin_file_name;
						$email_teacger =  $row['email'];
						
						mysqli_query($connect, "INSERT INTO `works_check` (`id`, `name_work`, `year`, `name_lead`, `direction`, `name_student`, `email_stud`, `email_teach`, `tmp_way`, `name_file`) VALUES (NULL, '$work_theme', '$year_prof', '$full_name_lead', '$direct_study', '$full_name_stud', '$email_stud', '$email_teacger', '$tmp_way', '$origin_file_name')");

					}

					
					$serchs = mysqli_query($connect,"SELECT * FROM `accepted_teacher` WHERE `id` = '$full_name_lead'");
					$serchs = mysqli_fetch_all($serchs);
					foreach ($serchs as $serch) {
					
						utf8mail($serch[2], "Запросы на проверку", "К вам на проверку поступила работа от '" . $full_name_stud . "' по теме '" . " $work_theme'" );

					}

					$_SESSION['message'] = 'Файл Успешно загружен.';
					header('Location: ../profile.php');

					$_SESSION['tema'] = [
						"work_theme" => $tema['work_theme']
					];

				

				}else {
					$_SESSION['message'] = 'Ошибка загрузка файла.';
					header('Location: ../profile.php');

				}
		
			}
		
		}
	
	
	
	}







 
                                   









?>



