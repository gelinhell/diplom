<?php
session_start();
unset($_SESSION['user']);
unset($_SESSION['admin']);
unset($_SESSION['tema']);
unset($_SESSION['teacher']);
unset($_SESSION['student_id']);
header('Location: ../index.php');