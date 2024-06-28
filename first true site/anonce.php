<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['userid'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publier une Annonce</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="anonce.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Publier une Annonce</h2>
        <a href="afficher_annonces.php" > <button style="background-color: orangered; color:white; padding: 10px; border-radius:10px; border-color: orangered;">retour a la boutique</button></a>
        <form id="annonceForm" enctype="multipart/form-data" method="POST" action="save_annonce.php">
            
            <div class="form-group">
                <label for="titre"><i class='bx bx-bookmark'></i> Titre</label>
                <input type="text" class="form-control" id="titre" name="titre" required>
            </div>
            <div class="form-group">
                <label for="description"><i class='bx bx-align-left'></i> Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="quartier"><i class='bx bx-map'></i> Quartier</label>
                <input type="text" class="form-control plm" id="quartier" name="quartier" required>
            </div>
            <div class="form-group">
                <label for="prix"><i class='bx bx-money'></i> Prix</label>
                <input type="text" class="form-control plm" id="prix" name="prix" required>
            </div>
            
            <div class="form-group">
                <label for="prix_carton"><i class='bx bx-box'></i> numero de telephone</label>
                <input type="tel" class="form-control" id="prix_carton" name="prix_carton">
            </div>
            
            <div class="form-group">
                <label for="mode_livraison"><i class='bx bx-truck'></i> Mode de Livraison</label>
                <select class="form-control" id="mode_livraison" name="mode_livraison">
                    <option value="je me deplace gratuitement.">je me deplace gratuitement.</option>
                    <option value="je me deplace au frais du client.">je me deplace au frais du client.</option>
                    <option value="je recois uniquement.">je recois uniquement.</option>
                    <option value="je me deplace uniquement.">je me deplace uniquement.</option>
                    <option value="Nous avons un service livraison allant de 1000frc a 2000frc ou plus.">Nous avons un service livraison allant de 1000frc a 2000frc ou plus.</option>
                </select>
            </div>
            <div class="flex">
            <div class="form-group">
                <label for="photo1"><i class='bx bx-image'></i> Photo 1</label>
                <input type="file" class="form-control" id="photo1" name="photo1" accept="image/*" required>
                <img id="preview1" class="preview">
            </div>
            <div class="form-group">
                <label for="photo2"><i class='bx bx-image'></i> Photo 2</label>
                <input type="file" class="form-control" id="photo2" name="photo2" accept="image/*">
                <img id="preview2" class="preview">
            </div>
            <div class="form-group">
                <label for="photo3"><i class='bx bx-image'></i> Photo 3</label>
                <input type="file" class="form-control" id="photo3" name="photo3" accept="image/*">
                <img id="preview3" class="preview">
            </div>
            </div>
            <button type="submit" class="btn btn-primary">Publier</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('photo1').addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('preview1').src = URL.createObjectURL(file);
            }
        });
        document.getElementById('photo2').addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('preview2').src = URL.createObjectURL(file);
            }
        });
        document.getElementById('photo3').addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('preview3').src = URL.createObjectURL(file);
            }
        });
    </script>
</body>
</html>
