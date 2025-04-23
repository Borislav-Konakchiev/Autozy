<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Autozy</title>
</head>
<header>
        <h1>Autozy</h1>
        <nav>
            <a href="index.php">Начало</a>
            <a href="">Добави обява</a>
            <a href="">Търсене</a>
            <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Ако потребителят е логнат, показваме линк за изход -->
            <a href="">Моите обяви</a>
            <a href="logout.php">Изход</a>
        <?php else: ?>
            <!-- Ако потребителят не е логнат, показваме линк за влизане -->
            <a href="login.php">Влизане</a>
            <a href="register.php">Регистрация</a>
        <?php endif; ?>

        
        </nav>
    </header>
</html>