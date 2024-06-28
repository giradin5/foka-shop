document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('newsletterForm');
    const emailInput = document.getElementById('email');
    const message = document.getElementById('message');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        // Validation simple de l'e-mail (peut être amélioré)
        const email = emailInput.value.trim();
        if (!isValidEmail(email)) {
            showMessage('Adresse e-mail invalide.');
            return;
        }

        // Envoi des données via AJAX
        const formData = new FormData();
        formData.append('email', email);

        fetch('subscribe.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('Inscription réussie ! Merci.');
                form.reset();
            } else {
                showMessage('Erreur lors de l\'inscription. Veuillez réessayer.');
            }
        })
        .catch(error => {
            showMessage('Erreur de connexion. Veuillez réessayer.');
        });
    });

    function isValidEmail(email) {
        // Validation simple d'adresse e-mail (peut être adaptée selon vos besoins)
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function showMessage(msg) {
        message.textContent = msg;
    }
});
