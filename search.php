<?php
session_start();
include 'db.php';

// Зареждаме филтрите
$brands = mysqli_query($connection, "SELECT * FROM brands");
$fueltypes = mysqli_query($connection, "SELECT * FROM fueltypes");
$transmissions = mysqli_query($connection, "SELECT * FROM transmissions");

$conditions = [];
$params = [];

// Проверка за филтри и изграждане на заявката
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET)) {
    if (!empty($_GET['brand_id'])) {
        $conditions[] = "c.brand_id = " . intval($_GET['brand_id']);
    }
    if (!empty($_GET['model'])) {
        $model = mysqli_real_escape_string($connection, $_GET['model']);
        $conditions[] = "c.model LIKE '%$model%'";
    }
    if (!empty($_GET['year'])) {
        $conditions[] = "c.year = " . intval($_GET['year']);
    }
    if (!empty($_GET['price_min'])) {
        $conditions[] = "c.price >= " . intval($_GET['price_min']);
    }
    if (!empty($_GET['price_max'])) {
        $conditions[] = "c.price <= " . intval($_GET['price_max']);
    }
    if (!empty($_GET['mileage_max'])) {
        $conditions[] = "c.mileage <= " . intval($_GET['mileage_max']);
    }
    if (!empty($_GET['fuel_type_id'])) {
        $conditions[] = "c.fuel_type_id = " . intval($_GET['fuel_type_id']);
    }
    if (!empty($_GET['transmission_id'])) {
        $conditions[] = "c.transmition_id = " . intval($_GET['transmission_id']);
    }
}

$whereClause = count($conditions) > 0 ? "WHERE " . implode(" AND ", $conditions) : "";

// Основна заявка
$query = "
SELECT c.*, b.brand_name, f.fuel_type_name, t.transmission_type,
       (SELECT image_path FROM car_images WHERE car_id = c.car_id LIMIT 1) as image
FROM cars c
JOIN brands b ON c.brand_id = b.brand_id
JOIN fueltypes f ON c.fuel_type_id = f.fuel_type_id
JOIN transmissions t ON c.transmission_id = t.transmission_id
$whereClause
ORDER BY c.car_id DESC
";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Търсене на обява</title>
    <link rel="stylesheet" href="style.css">
</head>
<?php include 'header.php'; ?>
<body class="search-page">

<div class="form-container">
    <h2>Филтри за търсене</h2>
    <form method="GET" action="search.php">

    
        <label>Марка:</label>
        <select name="brand_id">
            <option value="">-- Избери --</option>
            <?php while ($row = mysqli_fetch_assoc($brands)): ?>
                <option value="<?= $row['brand_id'] ?>" <?= isset($_GET['brand_id']) && $_GET['brand_id'] == $row['brand_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['brand_name']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Модел:</label>
        <input type="text" name="model" value="<?= $_GET['model'] ?? '' ?>">

        <label>Година:</label>
        <input type="number" name="year" value="<?= $_GET['year'] ?? '' ?>">

        <label>Цена от (лв):</label>
        <input type="number" name="price_min" value="<?= $_GET['price_min'] ?? '' ?>">

        <label>Цена до (лв):</label>
        <input type="number" name="price_max" value="<?= $_GET['price_max'] ?? '' ?>">

        <label>Макс. пробег (км):</label>
        <input type="number" name="mileage_max" value="<?= $_GET['mileage_max'] ?? '' ?>">

        <label>Гориво:</label>
        <select name="fuel_type_id">
            <option value="">-- Избери --</option>
            <?php while ($row = mysqli_fetch_assoc($fueltypes)): ?>
                <option value="<?= $row['fuel_type_id'] ?>" <?= isset($_GET['fuel_type_id']) && $_GET['fuel_type_id'] == $row['fuel_type_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['fuel_type_name']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Трансмисия:</label>
        <select name="transmission_id">
            <option value="">-- Избери --</option>
            <?php while ($row = mysqli_fetch_assoc($transmissions)): ?>
                <option value="<?= $row['transmission_id'] ?>" <?= isset($_GET['transmission_id']) && $_GET['transmission_id'] == $row['transmission_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['transmission_type']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Търси</button>
    </form>
</div>

<?php if (mysqli_num_rows($result) > 0): ?>
    <div class="car-listings">
        <?php while ($car = mysqli_fetch_assoc($result)): ?>
            <div class="car-card">
                <?php if (!empty($car['image'])): ?>
                    <img src="<?= htmlspecialchars($car['image']) ?>" alt="Снимка на колата">
                <?php endif; ?>
                <h3><?= htmlspecialchars($car['brand_name']) . ' ' . htmlspecialchars($car['model']) ?></h3>
                <p><strong>Година:</strong> <?= $car['year'] ?></p>
                <p><strong>Цена:</strong> <?= number_format($car['price'], 2) ?> лв</p>
                <p><strong>Пробег:</strong> <?= $car['mileage'] ?> км</p>
                <p><strong>Гориво:</strong> <?= htmlspecialchars($car['fuel_type_name']) ?></p>
                <p><strong>Трансмисия:</strong> <?= htmlspecialchars($car['transmission_type']) ?></p>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p style="text-align: center;">Няма намерени обяви по зададените критерии.</p>
<?php endif; ?>

</body>
</html>
