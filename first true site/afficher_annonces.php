<?php

session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['userid'])) {
    header("Location: index.php");
    exit();
}
?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "toofals";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Pour prendre en charge les caractères UTF-8
    $conn->exec("SET NAMES 'utf8'");
} catch(PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
// Récupérer le nombre de publications pour chaque catégorie
$categories = [
    "2000_6000" => "prix BETWEEN 2000 AND 6000",
    "6000_15000" => "prix BETWEEN 6000 AND 15000",
    "16000_plus" => "prix < 16000",
    "express" => "mode_livraison = 'express'"
];
$category_counts = [];
try {
    foreach ($categories as $key => $condition) {
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM publication WHERE $condition");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $category_counts[$key] = $result['count'];
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<?php
// Inclure le fichier de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "toofals";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Pour prendre en charge les caractères UTF-8
    $conn->exec("SET NAMES 'utf8'");
} catch(PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

// Requête pour compter les publications par catégories
$count2000To6000 = $conn->query("SELECT COUNT(*) FROM publication WHERE prix BETWEEN 2000 AND 6000")->fetchColumn();
$count6000To15000 = $conn->query("SELECT COUNT(*) FROM publication WHERE prix BETWEEN 6000 AND 15000")->fetchColumn();
$countAbove15000 = $conn->query("SELECT COUNT(*) FROM publication WHERE prix BETWEEN 15000 AND 1000000")->fetchColumn();
$countExpressDelivery = $conn->query("SELECT COUNT(*) FROM publication WHERE mode_livraison = 'express'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher les Annonces</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div style="background-color: white;" >
<h1>Bienvenue, <span style="color: orangered ;">🪄<?php echo htmlspecialchars($_SESSION['username']); ?>👋</span>! commence a <a href="afficher_annonces.php">acheter</a> ou <a href="anonce.php">POSTULER</a> des annonces.</h1>
<a href="logout.php">❌❌Se déconnecter❌❌</a>
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
                <a style="color: white; text-decoration: underline;" class="nav-link" href="contact.php"><i class='bx bxs-contact'></i> Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="booster.html"><i class='bx bxs-rocket'></i> Booster</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#"><i class='bx bxs-cart'></i> Panier</a>
            </li>
            <li class="nav-item">
                <a  style="color: white;" class="nav-link" href="register.php"><i class='bx bxs-user'></i> INSCRIPTION</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class='bx bxs-box'></i> Produit</a>
            </li>
        </ul>
    </div>
</nav>
<!-- Main Content -->
<div class="container mt-4">
    <div class="bg-info p-4 text-white d-flex justify-content-between align-items-center">
        <div>
            <h1>Vente de Bijoux</h1>
            <p>Découvrez notre collection exclusive de bijoux fabriqués avec soin et passion. Trouvez la pièce parfaite pour chaque occasion.</p>
            <a href="anonce.php" > <button style="background-color: orangered; color:white; padding: 10px; border-radius:10px; border-color: orangered;">publier l'annonce</button></a>
            <a href="contact.php" > <button style="background-color: orangered; color:white; padding: 10px; border-radius:10px; border-color: orangered;">Nous contacter</button></a>
        </div>
       
    </div>
    <!-- Search Bar -->
    <!-- Buttons with Badges -->
    <h1>Bienvenue sur <span style="font-zize: 24px; color:red;">FOKA</span>'SHOP</h1>
    <main>
        <form action="search.php" method="get" class="search-form">
            <input type="text" name="keyword" placeholder="Recherchez par quartier, prix , titre" class="search-input">
            <button type="submit" class="search-button">Rechercher</button>
        </form><br><br>

        <div class="button-container">
            <a href="search.php?filter=2000-6000" class="filter-button">2000 à 6000 XFA <span class="badge"><?= $count2000To6000 ?></span></a>
            <a href="search.php?filter=6000-15000" class="filter-button">6000 à 15000 XFA <span class="badge"><?= $count6000To15000 ?></span></a>
            <a href="search.php?filter=15000-1000000" class="filter-button">15000 XFA et plus <span class="badge"><?= $countAbove15000 ?></span></a>
            <a href="search.php?filter=express" class="filter-button">Livraison Express <span class="badge"><?= $countExpressDelivery ?></span></a>
        </div>
    </main>
    <!-- Color Changing Border Div with Cards -->
    <div class="color-changing-border mt-4 p-4">
        <div class="d-flex justify-content-center" style=" display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    ">
            <div class="card mr-2" style="width: 18rem;">
                <img src="aop.jpeg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">creer ton site web en 2 semaines!</h5>
                    <p class="card-text">contactez nous sur </p>
                    <a href="https://wa.me/+237658923374/?text= bojour divin je veux avoir  un site web ." style="font-zize:30px; color: green">
    <i class="bi bi-whatsapp" style="font-zize:30px; color: green;"></i>
    </a>
    
                </div>
            </div>
           
           
        </div>
    </div>
</div><br><br>
<div class="grid-container">
    <?php
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "toofals";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Sélection des publications depuis la base de données
        $stmt = $conn->query("SELECT * FROM publication");
        $publications = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Affichage des cartes pour chaque publication
        foreach ($publications as $publication) {
            ?>
            <div class="card">
            <div class="card-title">👉<?php echo $publication['titre']; ?></div>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($publication['photo1']); ?>" alt="Photo" class="card-image">
                <div class="card-content">
                    
                   
                    <div class="card-details">
                        <p>⭐⭐⭐⭐⭐</p>
                        <div class="card-quartier">Quartier: <?php echo $publication['quartier']; ?></div>
                        <div class="card-price" style="color:green;  "> <?php echo $publication['prix']; ?>XAF</div>
                       
                    </div>
                    <div class="card-date"> <?php echo $publication['date_publication']; ?></div>
                    
                    <a href="detaildepublication.php?id=<?php echo $publication['id']; ?>" class="card-link">👉Voir plus</a>
                </div>
            </div>
            <?php
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    ?>
</div>
<div class="container my-5">
        <div class="newsletter-div mx-auto d-flex flex-column justify-content-center align-items-center text-center">
            <h1>Inscrivez-vous à la newsletter</h1>
            <p>Recevez les dernières nouvelles et mises à jour directement dans votre boîte mail.</p>
            <form class="newsletter-form" id="newsletterForm" action="#" method="post" >
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class='bx bxs-envelope' style="font-size: 58px; color: rgb(148, 214, 247);"></i></span>
                        </div>
                        <input type="email" class="form-control" placeholder="Entrez votre email" required style=" padding: 10px; height: 70px;" id="email" name="email">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="padding: 10px; width: 300px; background-color: rgb(107, 14, 173);" id="subscribeBtn">Envoyer</button>
                <p id="message"></p>
            </form>
        </div>
    </div>


<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-column" style=" color: white;">
                <h3 style=" color: red;">À propos de nous</h3>
                <p>Nous sommes une plateforme dédiée à la publication et la consultation d'annonces dans votre région. Trouvez ce que vous cherchez parmi une large sélection de produits et services.</p>
            </div>
            <div class="footer-column">
                <h3 style=" color: red;">Nos services</h3>
                <ul >
                    <li style=" color: white;"><a href="afficher_annonces.php" style=" color: white;">Publications récentes</a></li>
                    <li style=" color: white;" ><a href="https://gozem.co/cm/fr/"style=" color: white;">Services de livraison</a></li>
                    <li style=" color: white;" ><a href="contact.php"style=" color: white;">Assistance client</a></li>
                    <li style=" color: white;" ><a href="contact.php"style=" color: white;">Guides d'utilisation</a></li>
                </ul>
            </div>
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
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="script.js"></script>
</body>
</div>
</html>
