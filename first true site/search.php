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


// Initialiser les variables
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
$keyword = isset($_GET['keyword']) ? '%' . $_GET['keyword'] . '%' : '%';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 30;
$offset = ($page - 1) * $limit;

// Construire la requête SQL en fonction du filtre ou du mot-clé
if ($filter) {
    switch ($filter) {
        case '2000-6000':
            $sql = "SELECT * FROM publication WHERE prix BETWEEN 2000 AND 6000 LIMIT :limit OFFSET :offset";
            break;
        case '6000-15000':
            $sql = "SELECT * FROM publication WHERE prix BETWEEN 6000 AND 15000 LIMIT :limit OFFSET :offset";
            break;
        case '15000+':
            $sql = "SELECT * FROM publication WHERE prix > 15000 LIMIT :limit OFFSET :offset";
            break;
        case 'express':
            $sql = "SELECT * FROM publication WHERE mode_livraison = 'express' LIMIT :limit OFFSET :offset";
            break;
        case 'je me deplace au frais du client':
                $sql = "SELECT * FROM publication WHERE mode_livraison = 'je me deplace au frais du client' LIMIT :limit OFFSET :offset";
                break;
        default:
            $sql = "SELECT * FROM publication WHERE 1 LIMIT :limit OFFSET :offset";
    }
} else {
    $sql = "SELECT * FROM publication WHERE titre LIKE :keyword OR description LIKE :keyword OR quartier LIKE :keyword LIMIT :limit OFFSET :offset";
    $sql = "SELECT * FROM publication WHERE titre LIKE :keyword OR prix_carton LIKE :keyword OR quartier LIKE :keyword LIMIT :limit OFFSET :offset";
}

// Préparer et exécuter la requête
$stmt = $conn->prepare($sql);
if (!$filter) {
    $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
}
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Compter le nombre total de publications pour la pagination
if ($filter) {
    switch ($filter) {
        case '2000-6000':
            $total_sql = "SELECT COUNT(*) FROM publication WHERE prix BETWEEN 2000 AND 6000";
            break;
        case '6000-15000':
            $total_sql = "SELECT COUNT(*) FROM publication WHERE prix BETWEEN 6000 AND 15000";
            break;
        case '15000':
            $total_sql = "SELECT COUNT(*) FROM publication WHERE prix BETWEEN 15000 and 1000000";
            break;
        case 'express':
            $total_sql = "SELECT COUNT(*) FROM publication WHERE mode_livraison = 'express'";
            break;
        default:
            $total_sql = "SELECT COUNT(*) FROM publication WHERE 1";
    }
} else {
    $total_sql = "SELECT COUNT(*) FROM publication WHERE titre LIKE :keyword OR description LIKE :keyword OR quartier LIKE :keyword";
}

$total_stmt = $conn->prepare($total_sql);
if (!$filter) {
    $total_stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
}
$total_stmt->execute();
$total_publications = $total_stmt->fetchColumn();
$total_pages = ceil($total_publications / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche  </title>
    <link rel="stylesheet" href="styles.css">
</head>
<div  style="background-color: white;">
<body>
    <header>
        <h1>Résultats de recherche consulter d'autres <a href="afficher_annonces.php">annonces</a> ou <a href="contact.php">contactez nous</a>.</h1>
    </header>

    <main>
        <div class="card-container" style="  display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin: 20px auto; /* Centrage horizontal avec marges */
    max-width: 1000px;;">
            <?php if (count($result) > 0): ?>
                <?php foreach ($result as $publication): ?>
                <div class="card">
                    <img src="data:image/jpeg;base64,<?= base64_encode($publication['photo1']) ?>" alt="<?= htmlspecialchars($publication['titre']) ?>">
                    <div class="card-content">
                        <h2><?= htmlspecialchars($publication['titre']) ?></h2>
                        
                        <p>Quartier: <strong><?= htmlspecialchars($publication['quartier']) ?></strong></p>
                        <p style="color:green; font-zize:25px; "> <span class="price"><?php echo $publication['prix']; ?> XFA</span></p>
                        <p> <span class="date"><?= htmlspecialchars($publication['date_publication']) ?></span></p>
                        <a href="detaildepublication.php?id=<?= $publication['id'] ?>" class="btn-details">Détails</a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun résultat trouvé.</p>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <?php if ($total_pages > 1 && $page <= $total_pages): ?>
                <?php if ($page > 1): ?>
                    <a href="search.php?page=<?= $page - 1 ?>" class="page-link">&laquo; Précédent</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="search.php?page=<?= $i ?>" class="page-link<?= ($i == $page) ? ' current' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="search.php?page=<?= $page + 1 ?>" class="page-link">Suivant &raquo;</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </main>

    <footer class="site-footer">
        <!-- Votre contenu de footer ici -->
        <div class="footer-bottom">
            <ul class="social-icons">
                <li style=" color: white;"><a href="#" class="boxicon-facebook" target="_blank"><i class="bi bi-facebook" style="  color:white;"></i></a></li>
                <li><a href="#" class="boxicon-twitter" target="_blank"><i class="bi bi-twitter-x"></i></a></li>
                <li><a href="#" class="boxicon-instagram" target="_blank"><i class="bi bi-instagram"></i></a></li>
                <li><a href="#" class="boxicon-linkedin" target="_blank" style="  color:white;"><i class="bi bi-linkedin"></i></a></li>
            </ul>
            <p style=" color: white;">&copy; 2024  realisé avec ❤️ par <a href="+237658923374" style="  color: orange;">GIRADIN-TCHINDA</a>. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</div>
</html>

<?php
// Fermer la connexion à la base de données
$conn = null;
?>
