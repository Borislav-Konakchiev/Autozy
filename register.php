<?php
session_start();
include 'db.php'; // Свързваме се с базата данни

if (isset($_POST['submit'])) {
    // Вземаме данните от формата
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Хешираме паролата преди да я съхраним
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Проверка дали потребителското име вече съществува
    $query = "SELECT * FROM Users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "Потребителското име вече е заето!";
    } else {
        // Вмъкване на новия потребител в базата данни
        $query = "INSERT INTO Users (username, password, email) VALUES ('$username', '$hashed_password', '$email')";
        $result = mysqli_query($connection, $query);

        if ($result) {
            echo "Регистрацията беше успешна!";
        } else {
            echo "Грешка при регистрацията.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="register-page">
    <header>
        <h1>Autozy</h1>
        <nav>
        <a href="index.php">Начало</a>
            <a href="">Добави обява</a>
            <a href="">Търсене</a>
            <a href="">Моите обяви</a>
            <a href="login.php">Влизане</a>
            <a href="register.php">Регистрация</a>
        </nav>
    </header>
    
    <div class="register-page-container">
        <div class="form-container">
            <h2>Регистрация</h2>
            <form action="register.php" method="POST">
                <label for="name">Име:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Имейл:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Парола:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Регистрирай се</button>
            </form>
        </div>
     </div>
</body>
</html>
