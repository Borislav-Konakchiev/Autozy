<?php
session_start();
include 'db.php'; // Свързваме се с базата данни

$message = null;
$message_class = "";


if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Хешираме паролата преди да я съхраним
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Проверка дали потребителското име вече съществува
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        $message = "Потребителското име вече е заето!";
        $message_class = "error";
    } else {
        // Вмъкване на новия потребител в базата данни
        $query = "INSERT INTO users (username, password, email) VALUES ('$username', '$hashed_password', '$email')";
        $result = mysqli_query($connection, $query);
        
        if ($result) { 
            $message = "Регистрацията беше успешна!";
            $message_class = "success";

        } else {
            $message = "Грешка при регистрацията";
            $message_class = "error";
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

    <?php include('header.php'); ?>
    
    <div class="register-page-container">
        <div class="form-container">
       

            <h2>Регистрация</h2>
            <?php if ($message): ?>
            <div class="message-box <?php echo $message_class; ?>">
            <?php echo $message; ?>
            </div>
            <?php endif; ?>
            <form action="register.php" method="POST">
                <label for="name">Име:</label>
                <input type="text" id="username" name="username" required>

                <label for="email">Имейл:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Парола:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" name="submit">Регистрирай се</button>
            </form>
        </div>
     </div>
     

</body>
</html>
