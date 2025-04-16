<?php
session_start();

// Проверка дали потребителят вече е логнат
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db.php'; // Свързване с базата данни

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Заявка за намиране на потребителя по имейл
    $query = "SELECT * FROM Users WHERE email = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Проверка на паролата
        if (password_verify($password, $user['password'])) {
            // Записване на сесията и пренасочване към началната страница
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['name'];
            header('Location: index.php');
            exit();
        } else {
            $error_message = "Невалидна парола!";
        }
    } else {
        $error_message = "Потребителят не съществува!";
    }
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
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

    <div class="login-container">
        <form action="login.php" method="POST">
            <h2>Вход</h2>
            <?php if (isset($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <label for="email">Имейл:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Парола:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Влез</button>
        </form>
    </div>
</body>
</html>
