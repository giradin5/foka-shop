<?php
session_start();



// Connexion à la base de données
$host = 'localhost';
$db = 'toofals';
$user = 'root';
$pass = '';

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);

// Récupérer les données des utilisateurs
$users = $pdo->query('SELECT * FROM user')->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les données des publications avec les noms d'utilisateurs
$publications = $pdo->query('
    SELECT p.id, p.userid, p.prix_carton, p.created_at, p.description, p.photo1, p.photo2, p.photo3, p.titre, u.username 
    FROM publication p
    JOIN user u ON p.userid = u.id
')->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les utilisateurs connectés et déconnectés
$connected_users = count($pdo->query('SELECT * FROM user WHERE id = "connected"')->fetchAll(PDO::FETCH_ASSOC));
$disconnected_users = count($pdo->query('SELECT * FROM user WHERE id = "disconnected"')->fetchAll(PDO::FETCH_ASSOC));

// Récupérer le nombre total d'utilisateurs
$total_users = count($users);

// Récupérer le nombre total de visiteurs (exemple fixe pour la démonstration)
$total_visitors = 1294;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.1/dist/boxicons.js"></script>
    <style>
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #f8f9fa;
            width: 250px;
            padding-top: 20px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .card-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            border-radius: 8px;
            color: white;
        }
        .card-box .box-icon {
            font-size: 50px;
        }
        .bg-primary { background: #007bff; }
        .bg-success { background: #28a745; }
        .bg-danger { background: #dc3545; }
        .nav-link {
            cursor: pointer;
        }
        .publication-image {
            width: 90px;
            height: auto;
        }
    </style>
    <script>
        function showSection(section) {
            document.querySelectorAll('.section').forEach(function (el) {
                el.style.display = 'none';
            });
            document.getElementById(section).style.display = 'block';
        }

        function deletePublication(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette publication ?')) {
                window.location.href = 'delete_publication.php?id=' + id;
            }
        }

        function blockPublication(id) {
            if (confirm('Êtes-vous sûr de vouloir bloquer cette publication ?')) {
                window.location.href = 'block_publication.php?id=' + id;
            }
        }
    </script>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-sticky">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" onclick="showSection('dashboard-section')">
                        <box-icon type='solid' name='dashboard'></box-icon>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="showSection('users-section')">
                        <box-icon type='solid' name='user'></box-icon>
                        Utilisateurs <span class="badge badge-primary"><?= $total_users ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="showSection('connected-user-section')">
                        <box-icon type='solid' name='user-check'></box-icon>
                        Connectées <span class="badge badge-primary"><?= $connected_users ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="showSection('disconnected-users-section')">
                        <box-icon type='solid' name='user-minus'></box-icon>
                        Déconnectées <span class="badge badge-primary"><?= $disconnected_users ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="showSection('publications-section')">
                        <box-icon type='solid' name='file'></box-icon>
                        Publications <span class="badge badge-primary"><?= count($publications) ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="showSection('visitors-section')">
                        <box-icon type='solid' name='visitor'></box-icon>
                        Visiteurs <span class="badge badge-primary"><?= $total_visitors ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <box-icon type='solid' name='log-out'></box-icon>
                        Déconnexion
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard</h1>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card-box bg-primary">
                    <div>
                        <h5 class="card-title">Connectées</h5>
                        <h3><?= $connected_users ?></h3>
                    </div>
                    <box-icon class="box-icon" name='user-check' type='solid' color='#ffffff'></box-icon>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-box bg-success">
                    <div>
                        <h5 class="card-title">Inscrits</h5>
                        <h3><?= $total_users ?></h3>
                    </div>
                    <box-icon class="box-icon" name='user' type='solid' color='#ffffff'></box-icon>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-box bg-danger">
                    <div>
                        <h5 class="card-title">Déconnectées</h5>
                        <h3><?= $disconnected_users ?></h3>
                    </div>
                    <box-icon class="box-icon" name='user-minus' type='solid' color='#ffffff'></box-icon>
                </div>
            </div>
        </div>

        <div id="users-section" class="section" style="display: none;">
            <h2>Utilisateurs</h2>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['id']) ?></td>
                                <td><?= htmlspecialchars($user['username']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <button class="btn btn-danger btn-sm" onclick="deleteUser(<?= $user['id'] ?>)">Supprimer</button>
                                    <button class="btn btn-warning btn-sm" onclick="blockUser(<?= $user['id'] ?>)">Bloquer</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="publications-section" class="section" style="display: none;">
            <h2>Publications</h2>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>#User ID</th>
                            <th>🔜Username</th>
                            <th>📲telephone</th>
                            <th>✅Date</th>
                            <th>💲Description</th>
                            <th>👉Titre</th>
                            <th>#Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($publications as $publication): ?>
                            <tr>
                                <td style="background-color: blue; color: white;"><?= htmlspecialchars($publication['id']) ?></td>
                                <td style="background-color: red; color: white;"><?= htmlspecialchars($publication['userid']) ?></td>
                                <td style="color: blue;"><?= htmlspecialchars($publication['username']) ?></td>
                                <td style="color: red;"><?= htmlspecialchars($publication['prix_carton']) ?></td>
                                <td style="color: blue;"><?= htmlspecialchars($publication['created_at']) ?></td>
                                <td><?= htmlspecialchars($publication['description']) ?></td>
                                
                                <td style="color: orangered; font-zize: 24px;"><?= htmlspecialchars($publication['titre']) ?></td>
                                <td>
                                    <button class="btn btn-danger btn-sm" onclick="deletePublication(<?= $publication['id'] ?>)">Supprimer</button>
                                    <button class="btn btn-warning btn-sm" onclick="blockPublication(<?= $publication['id'] ?>)">Bloquer</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
