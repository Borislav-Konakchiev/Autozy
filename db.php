<?php
$host = "localhost"; // Или адресът на вашия MySQL сървър
$username = "root";  // Вашето потребителско име за базата данни
$password = "";      // Паролата за базата данни (ако има такава)
$database = "autozydb"; // Името на вашата база данни

// Създаване на връзка с базата данни
$connection = mysqli_connect($host, $username, $password, $database);

// Проверка дали връзката е успешна
if (!$connection) {
    die("Неуспешна връзка: " . mysqli_connect_error());
}
?>
