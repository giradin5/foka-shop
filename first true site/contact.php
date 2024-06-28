<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['user_name'];
    $email = $_POST['user_email'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        // Configuration du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'giradintchinda@gmail.com'; // Remplacez par votre adresse Gmail
        $mail->Password = 'Chimisteprof'; // Remplacez par votre mot de passe Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinataires
        $mail->setFrom($email, $name);
        $mail->addAddress('your-email@example.com', 'Your Name'); // Remplacez par votre adresse de réception

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body    = "Name: $name<br>Email: $email<br>Message: $message";

        $mail->send();
        echo "Message sent successfully!";
    } catch (Exception $e) {
        echo "Failed to send message. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact-foka</title>
    <link rel="stylesheet" href="contact.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
</head>
<div style=" background-color: white;">
<body>


    <div class="container">
        <div class="contact-card">
            <div class="contact-left">
                <img src="A-112.jpg" alt="Contact Image">
                <div class="contact-info">
                    <h2>Contactez NOUS</h2>
                    <p style="font-zize: 30px; color: white;">
                    </span> N'hésitez pas à remplir notre formulaire de contact ! Que vous souhaitiez <a href="anonce.php">postuler</a> pour un poste, <a href="register.php">s'inscrire</a> à notre newsletter, ou découvrir les dernières <a href="afficher_annonces.php">annonces</a> disponibles, notre équipe est là pour vous aider..
</p>

                </div>
            </div><br><br><br><br><br><br>
            <div class="contact-right">
                <form id="contact-form" method="POST" action="">
                    <div class="form-group">
                        <i class='bx bx-user'></i>
                        <input type="text" name="user_name" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <i class='bx bx-envelope'></i>
                        <input type="email" name="user_email" placeholder="Your Email" required>
                    </div>
                    <div class="form-group">
                        <i class='bx bx-message'></i>
                        <textarea name="message" placeholder="Your Message" required></textarea>
                    </div>
                    <button type="submit" style="font-zize: 20px; background-color: orangered;">Send Message</button>
                </form>
            </div>
        </div>
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3979.5329361036546!2d9.708507914266192!3d4.051056047323277!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x10610d30e92039c7%3A0x2f0c71a27dc20db8!2sDouala%2C%20Cameroon!5e0!3m2!1sen!2sus!4v1624467896762!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div><br><br>
      
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
          
  <a href="https://wa.me/ton-numero-whatsapp" class="whatsapp-float" target="_blank">
    <i class="fa fa-whatsapp my-float"></i>
  </a>
    </footer>
</body>
</div>
</html>
