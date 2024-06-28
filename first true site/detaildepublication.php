<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail de la Publication</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<div style="background-color: white;">
<body>

<?php
// Vérification de l'existence du paramètre 'id' dans l'URL
if (isset($_GET['id'])) {
    $publication_id = $_GET['id'];

    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "toofals";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Sélection de la publication spécifique depuis la base de données
        $stmt = $conn->prepare("SELECT * FROM publication WHERE id = :id");
        $stmt->bindParam(':id', $publication_id);
        $stmt->execute();
        $publication = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($publication) {
            ?>
            <nav class="navbar navbar-expand-lg navbar-light ">
    <a class="navbar-brand" href="#"><span style="font-zize: 24px; color:red;">FOKA</span>'SHOP</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="afficher_annonces.php"><i class='bx bxs-home'></i> Maison</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.php"><i class='bx bxs-contact'></i> Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="booste.html"><i class='bx bxs-rocket'></i> Booster</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#"><i class='bx bxs-cart'></i> Panier</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="register.php"><i class='bx bxs-user'></i> Utilisateur</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class='bx bxs-box'></i> Produit</a>
            </li>
        </ul>
    </div>
</nav><br><br>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($publication['photo1']); ?>" class="d-block w-100" alt="Photo 1">
                                </div>
                                <div class="carousel-item">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($publication['photo2']); ?>" class="d-block w-100" alt="Photo 2">
                                </div>
                                <div class="carousel-item">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($publication['photo3']); ?>" class="d-block w-100" alt="Photo 3">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h2 style="color:orangered;"><?php echo $publication['titre']; ?></h2><br><br>
                        <p> <?php echo $publication['description']; ?></p>
                        <p>Quartier: 🔜 <?php echo $publication['quartier']; ?></p><br><br>
                        <p style="color: green;"> <?php echo $publication['prix']; ?>XAF</p><br><br>
                        <p style="color:red;">livraison:👉 <?php echo $publication['mode_livraison']; ?></p><br><br>
                        <p style="color:red;">Date de Publication: <?php echo $publication['date_publication']; ?></p><br><br><br>
                        <a  style="background-color:green;" href="https://wa.me/+237<?PHP echo $publication['prix_carton'] ?>/?text= Bonjour je suis intéressé par  👉<?php echo $publication['titre']; ?> sur Foka'shop. Est-ce qu'il coûte vraiment <?php echo $publication['prix']; ?> XAF ? " target="_blank" class="btn btn-WhatsApp">Acheter via WhatsApp</a>
                        <a   style="background-color: orangered; padding:20px; color:white; text-decoration:none;" href="tel:+237<?PHP echo $publication['prix_carton'] ?>">contacter l'annonceur</a>
                    </div>
                </div>
            </div><br><br>
            <?php
        } else {
            echo "<p>Aucune publication trouvée avec l'ID spécifié.</p>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
} else {
    echo "<p>Paramètre d'ID manquant dans l'URL.</p>";
}
?>

<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
           
            <div class="footer-column">
                <h3 style=" color: red;">Contactez-nous</h3>
                <ul>
                    <li style=" color: white;">Adresse: logbesssou, douala, cameroun</li>
                    <li style=" color: white;">Téléphone: <a href="tel:+123456789" style=" color: orange;">+237 658923374</a></li>
                    <li style=" color: white;">Email: <a href="mailto:info@example.com" style=" color: orange;">giradintchinda@gmail.com</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <ul class="social-icons">
                <li style=" color: white;"><a href="https://web.facebook.com/?ref=homescreenpwa&_rdc=1&_rdr" class="boxicon-facebook" target="_blank"><i class="bi bi-facebook" style="  color:white;"></i></a></li>
                <li><a href="#" class="boxicon-twitter" target="_blank"><i class="bi bi-twitter-x"></i></a></li>
                <li><a href="instagramme.com" class="boxicon-instagram" target="_blank"><i class="bi bi-instagram"></i></a></li>
                <li><a href="#" class="boxicon-linkedin" target="_blank" style="  color:white;"><i class="bi bi-linkedin"></i></a></li>
            </ul>
            <p style=" color: white;">&copy; 2024  realisé avec ❤️ par <a href="+237658923374" style="  color: orange;">GIRADIN-TCHINDA</a>. Tous droits réservés.</p>
        </div>
    </div>
    <a href="#" class="back-to-top"><i class="boxicon-chevron-up"></i></a>
    <a href="https://wa.me/votre-numero-de-telephone" class="whatsapp-float" target="_blank">
    <i class="bi bi-whatsapp"></i>
    </a>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</div>
</html>
