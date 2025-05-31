<?php
require_once '../include/db_config.php';
session_start();
$error_message = isset($_GET['error']) ? htmlspecialchars(urldecode($_GET['error'])) : '';
$success_message = isset($_GET['success']) ? htmlspecialchars(urldecode($_GET['success'])) : '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un compte - Khadamati</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-100 to-white min-h-screen flex items-center justify-center">

    <div class="absolute top-5 left-5 flex items-center gap-2">
        
        
    </div>

    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-xl">
        <?php if ($error_message): ?>
            <div class="text-red-600 text-center mb-4"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="text-green-600 text-center mb-4"><?php echo $success_message; ?></div>
        <?php endif; ?>
<img src="images/logok.jpg" alt="Khadamati Logo" class="h-10">
        <h1 class="text-2xl font-bold text-center mb-6">Créer un compte</h1>
        
        <form method="POST" action="../partie_client/insert_client.php" class="space-y-5" id="form">
            <div>
                <label for="name" class="block font-semibold">Nom complet</label>
                <input type="text" id="nom" name="nom" required class="w-full px-4 py-2 border rounded-lg" placeholder="Votre nom">
            </div>
            <div>                <label for="email" class="block font-semibold">Adresse e-mail</label>
                <input type="email" id="email" name="email" required class="w-full px-4 py-2 border rounded-lg" placeholder="exemple@mail.com">
            </div>
            <div>
                <label for="password" class="block font-semibold">Mot de passe</label>
                <input type="password" id="password" name="password" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label for="confirm-password" class="block font-semibold">Confirmer le mot de passe</label>
                <input type="password" id="confirm-password" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="terms" required>
                <label for="terms">J'accepte les <a href="#" class="text-blue-500 underline">conditions d'utilisation</a></label>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold">Créer un compte</button>
        </form>

        <p class="mt-4 text-center text-sm">
            Vous avez déjà un compte ?
            <a href="login_client.php" class="text-blue-500 underline">Connexion</a>
        </p>
    </div>    <script>
        document.getElementById("form").addEventListener("submit", function(e) {
            const pass = document.getElementById("password").value;
            const confirm = document.getElementById("confirm-password").value;
            if (pass !== confirm) {
                e.preventDefault();
                alert("Les mots de passe ne correspondent pas ! Veuillez réessayer.");
            }
            if (pass.length < 6) {
                e.preventDefault();
                alert("Le mot de passe doit contenir au moins 6 caractères.");
            }
        });
    </script>
</body>
</html>