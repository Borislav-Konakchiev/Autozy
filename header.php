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
            <a href="add_listing.php">Добави обява</a>
            <a href="search.php">Търсене</a>
            <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Ако потребителят е логнат, показваме линк за изход -->
            <a href="">Моите обяви</a>
            <a href="logout.php">Изход</a>
        <?php else: ?>
            <!-- Ако потребителят не е логнат, показваме линк за вход -->
            <a href="login.php">Вход</a>
            <a href="register.php">Регистрация</a>
        <?php endif; ?>

        
        </nav>
    </header>
</html>