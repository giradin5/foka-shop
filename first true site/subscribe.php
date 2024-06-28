<?php
// Vérifier que la requête est bien de type POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer l'e-mail depuis les données POST
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if ($email) {
        // Enregistrer l'e-mail dans votre base de données ou autre traitement
        // Exemple simplifié : enregistrer dans un fichier (à adapter en fonction de votre besoin)
        $file = 'subscribers.txt';
        file_put_contents($file, $email . PHP_EOL, FILE_APPEND);

        // Répondre avec un succès
        $response = ['success' => true];
    } else {
        // Répondre avec une erreur d'e-mail invalide
        $response = ['success' => false];
    }

    // Envoyer la réponse au format JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Si la méthode n'est pas POST, renvoyer une erreur
http_response_code(405);
exit('Method Not Allowed');
?>
