<?php
session_start(); // Започваме сесията
session_unset(); // Изчистваме всички сесийни променливи
session_destroy(); // Унищожаваме сесията
header("Location: index.php"); // Пренасочваме към началната страница
exit();
?>
