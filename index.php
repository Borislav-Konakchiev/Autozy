<!DOCTYPE html>
<?php
session_start(); // Започваме сесията
?>

<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autozy</title>
</head>
<body>
   <?php include('header.php'); ?>
</body>
</html>

<?php
include('db.php');
// Извличане на всички коли
$query = "SELECT c.car_id, b.brand_name, c.model, c.year, c.price, c.mileage, t.transmission_type, f.fuel_type_name,   (SELECT image_path FROM car_images WHERE car_id = c.car_id LIMIT 1) AS image_path
          FROM Cars c
          JOIN Brands b ON c.brand_id = b.brand_id
          JOIN Transmissions t ON c.transmission_id  = t.transmission_id 
          JOIN FuelTypes f ON c.fuel_type_id = f.fuel_type_id";
$result = mysqli_query($connection, $query);

// Проверка дали има резултати
if (mysqli_num_rows($result) > 0) {
    echo '<div class="car-listings">';

    // Извеждаме всяка кола
    while ($car = mysqli_fetch_assoc($result)) {
        echo '<div class="car-card">';
        // Покажи снимка, ако има:
    if (!empty($car['image_path'])) {
        echo '<img src="' . htmlspecialchars($car['image_path']) . '" alt="Снимка на кола">';
    }
        echo '<h3>' . htmlspecialchars($car['brand_name']) . ' ' . htmlspecialchars($car['model']) . '</h3>';
        echo '<p><strong>Година:</strong> ' . $car['year'] . '</p>';
        echo '<p><strong>Цена:</strong> ' . number_format($car['price'], 2) . ' лв</p>';
        echo '<p><strong>Пробег:</strong> ' . $car['mileage'] . ' км</p>';
        echo '<p><strong>Скоростна кутия:</strong> ' . htmlspecialchars($car['transmission_type']) . '</p>';
        echo '<p><strong>Тип гориво:</strong> ' . htmlspecialchars($car['fuel_type_name']) . '</p>';
        echo '</div>';
    }

    echo '</div>';
} else {
    echo '<p>Няма налични обяви.</p>';
}

mysqli_close($connection);
?>
