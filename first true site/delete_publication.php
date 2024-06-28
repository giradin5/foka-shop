<?php
$host = 'localhost';
$db = 'toofals';
$user = 'root';
$pass = '';

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM publication WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: dashboard.php');
exit;
?>
