<?php
// Inclure l'autoload de Composer
require 'C:/Users/JARDIN divin/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($phone) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'giradintchinda@gmail.com'; // Remplacez par votre adresse e-mail
            $mail->Password = 'Chimisteprof'; // Remplacez par votre mot de passe ou mot de passe d'application
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom($email, $name);
            $mail->addAddress('giradintchinda@gmail.com'); 

            $mail->isHTML(false);
            $mail->Subject = 'New Contact Form Submission';
            $mail->Body    = "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message";

            $mail->send();
            echo 'Message sent successfully!';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Please fill all the fields correctly.";
    }
} else {
    echo "Invalid request method.";
}
?>
