<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="TaskFlow">
    <meta name="description" content="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="<?= base_url('assets/css/styleprofil.css') ?>" rel="stylesheet">
    <link rel="icon" href="/favicon.ico">
    <title>Task-Flow</title>
</head>
<body>
    <div class="container">
        <div class="profile-card">
            <div class="info-card">
                <h2>Votre email</h2>
                <hr>
                <p>email</p>
            </div>
            
            <div class="name-section">
                <div class="info-card">
                    <h2>Votre nom</h2>
                    <hr>
                    <p>nom</p>
                </div>
                <a href="<?= base_url('connexion/mdp_oublie') ?>" class="btn-modifier">Modifier le mot de passe</a>
            </div>
            
            <div class="info-card">
                <h2>Statuts et Priorités</h2>
                <hr>
                <div class="status-priorities">
                    <h3>Statuts</h3>
                    <?php foreach ($statuts as $statut): ?>
                        <div class="color-picker">
                            <span><?= esc($statut['libelle']) ?></span>
                            <input type="color" id="statut_<?= $statut['id'] ?>" value="<?= esc($statut['couleur']) ?>">
                        </div>
                    <?php endforeach; ?>

                    <h3>Priorités</h3>
                    <?php foreach ($priorites as $priorite): ?>
                        <div class="color-picker">
                            <span><?= esc($priorite['libelle']) ?></span>
                            <input type="color" id="priorite_<?= $priorite['id'] ?>" value="<?= esc($priorite['couleur']) ?>">
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Bouton Enregistrer déplacé ici -->
                <button id="enregistrer" class="btn-enregistrer">Enregistrer les modifications</button>
            </div>

            <!-- Bouton Supprimer compte -->
            <button id="supprimer" class="btn-supprimer">Supprimer le compte</button>
        </div>
    </div>

    <script>
        document.getElementById('enregistrer').addEventListener('click', function() {
            let couleurs = {
                statuts: {},
                priorites: {}
            };

            document.querySelectorAll('[id^="statut_"]').forEach(function(el) {
                couleurs.statuts[el.id.split('_')[1]] = el.value;
            });

            document.querySelectorAll('[id^="priorite_"]').forEach(function(el) {
                couleurs.priorites[el.id.split('_')[1]] = el.value;
            });

            // Envoyer les données au serveur (à implémenter)
            console.log(couleurs);
        });

        document.getElementById('supprimer').addEventListener('click', function() {
            if (confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')) {
                // Action de suppression du compte (à implémenter)
                console.log('Compte supprimé');
            }
        });
    </script>

</body>
</html>
