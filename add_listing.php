<?php
session_start();
include 'db.php';
include 'header.php';

// Ако не е логнат потребителят, го пренасочваме към login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


// Зареждаме марките от базата
$brand_query = mysqli_query($connection, "SELECT * FROM brands");
//Зареждаме горивата и екстрите от базата
$fuel_query = mysqli_query($connection, "SELECT * FROM fueltypes");
$feature_query = mysqli_query($connection, "SELECT * FROM features");

$message = null;

if (isset($_POST['submit'])) {
    $brand_id = $_POST['brand_id'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $price = $_POST['price'];
    $mileage = $_POST['mileage'];
    $fuel_type = $_POST['fuel_type'];
    $user_id = $_SESSION['user_id'];
    $features = isset($_POST['features']) ? $_POST['features'] : [];

    // Вмъкваме обявата
    $stmt = mysqli_prepare($connection, "INSERT INTO cars (user_id, brand_id, model, year, price, mileage, fuel_type_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iissiii", $user_id, $brand_id, $model, $year, $price, $mileage, $fuel_type);
    mysqli_stmt_execute($stmt);
    $car_id = mysqli_insert_id($connection);

    // Вмъкваме екстрите
    foreach ($features as $feature_id) {
        $feature_id = intval($feature_id);
        mysqli_query($connection, "INSERT INTO car_features (car_id, feature_id) VALUES ($car_id, $feature_id)");
    }

    // Качваме снимките в директория images/ и записваме в базата
    $upload_dir = "images/";
    if (isset($_FILES['images']['tmp_name']) && is_array($_FILES['images']['tmp_name'])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            // Проверяваме за грешки при качване
            if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                $filename = basename($_FILES['images']['name'][$key]);
                $target = $upload_dir . time() . "_" . $filename;

                if (move_uploaded_file($tmp_name, $target)) {
                    mysqli_query($connection, "INSERT INTO car_images (car_id, image_path) VALUES ($car_id, '$target')");
                } else {
                    // Грешка при преместване на файла
                    $message .= " Възникна грешка при качването на файла " . $filename . ".";
                }
            } else {
                // Грешка при качване на файла
                $message .= " Възникна грешка при качването на файл. Код на грешката: " . $_FILES['images']['error'][$key] . ".";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Добави обява</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="listing-page">
<div class="form-container">
    <h2>Добави нова обява</h2>

    <?php if ($message): ?>
        <div class="success-message"><?php echo $message; ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">


        <label>Марка:</label>
        <select name="brand_id" required>
        <?php while ($row = mysqli_fetch_assoc($brand_query)): ?>
        <option value="<?php echo $row['brand_id']; ?>"><?php echo $row['brand_name']; ?></option>
        <?php endwhile; ?>
        </select>

        <label>Модел:</label>
        <input type="text" name="model" required>

        <label>Година:</label>
        <input type="number" name="year" required>

        <label>Цена:</label>
        <input type="number" name="price" required>

        <label>Пробег (км):</label>
        <input type="number" name="mileage" required>

        <label>Гориво:</label>
        <select name="fuel_type" required>
            <?php while ($row = mysqli_fetch_assoc($fuel_query)): ?>
                <option value="<?php echo $row['fuel_type_id']; ?>"><?php echo $row['fuel_type_name']; ?></option>
            <?php endwhile; ?>
        </select>

        <label>Екстри:</label>
        <?php while ($row = mysqli_fetch_assoc($feature_query)): ?>
            <div><input type="checkbox" name="features[]" value="<?php echo $row['feature_id']; ?>"> <?php echo $row['feature_name']; ?></div>
        <?php endwhile; ?>

        <label>Снимки:</label>
        <input type="file" name="images[]" multiple accept="image/*">

        <button type="submit" name="submit">Добави обява</button>
    </form>
</div>
</body>
</html>