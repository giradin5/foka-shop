<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['userid'])) {
    header("Location: index.php");
    exit();
}

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "toofals";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $quartier = $_POST['quartier'];
    $prix = $_POST['prix'];
    $prix_carton = $_POST['prix_carton'];
    $mode_livraison = $_POST['mode_livraison'];
    $userid = $_SESSION['userid'];
    
    $photo1 = file_get_contents($_FILES['photo1']['tmp_name']);
    $photo2 = file_get_contents($_FILES['photo2']['tmp_name']);
    $photo3 = file_get_contents($_FILES['photo3']['tmp_name']);

    $stmt = $conn->prepare("INSERT INTO publication (titre, description, quartier, prix, prix_carton, mode_livraison, photo1, photo2, photo3, userid) 
                            VALUES (:titre, :description, :quartier, :prix, :prix_carton, :mode_livraison, :photo1, :photo2, :photo3, :userid)");
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':quartier', $quartier);
    $stmt->bindParam(':prix', $prix);
    $stmt->bindParam(':prix_carton', $prix_carton);
    $stmt->bindParam(':mode_livraison', $mode_livraison);
    $stmt->bindParam(':photo1', $photo1, PDO::PARAM_LOB);
    $stmt->bindParam(':photo2', $photo2, PDO::PARAM_LOB);
    $stmt->bindParam(':photo3', $photo3, PDO::PARAM_LOB);
    $stmt->bindParam(':userid', $userid);

    $stmt->execute();

    header('Location: afficher_annonces.php');
    exit();
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
