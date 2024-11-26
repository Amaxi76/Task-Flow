<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="box shadow-lg d-flex flex-row">
            <!-- Section gauche avec le formulaire -->
            <div class="md-6 bg-custom text-white p-4">
                <h2 class="text-center mb-4">Inscription</h2>
                <?php echo form_open('UtilisateurControleur/inscription', ['class' => 'needs-validation', 'novalidate' => '']); ?>

                <div class="form-floating mb-3">
                    <?php echo form_input('email', set_value('email'), 'class="form-control" id="floatingEmail" placeholder="name@example.com" required'); ?>
                    <?php echo form_label('E-mail', 'floatingEmail'); ?>
                    <?= validation_show_error('email') ?>
                </div>

                <div class="form-floating mb-3">
                    <?php echo form_input('nom', set_value('nom'), 'class="form-control" id="floatingNom" placeholder="Votre nom" required'); ?>
                    <?php echo form_label('Nom', 'floatingNom'); ?>
                    <?= validation_show_error('nom') ?>
                </div>

                <div class="form-floating mb-3">
                    <?php echo form_password('mot_de_passe', '', 'class="form-control" id="floatingPassword" placeholder="Mot de passe" required'); ?>
                    <?php echo form_label('Mot de passe', 'floatingPassword'); ?>
                    <?= validation_show_error('mot_de_passe') ?>
                </div>

                <div class="form-floating mb-3">
                    <?php echo form_password('confirmerMdp', '', 'class="form-control" id="floatingConfirmPassword" placeholder="Confirmer le mot de passe" required'); ?>
                    <?php echo form_label('Confirmer le mot de passe', 'floatingConfirmPassword'); ?>
                    <?= validation_show_error('confirmerMdp') ?>
                </div>

                <?php echo form_submit('submit', 'S\'inscrire', 'class="btn btn-light w-100"'); ?>
                <?php echo form_close(); ?>

                <p class="text-center mt-3">
                    <span>Déjà inscrit ?</span> <a href="<?= site_url('connexion') ?>" class="text-white">Connectez-vous</a>
                </p>
            </div>

            <!-- Section droite avec le logo -->
            <div class="md-6 d-flex align-items-center justify-content-center bg-white">
                <img src="<?= base_url('assets/images/Logo.png') ?>" alt="Logo" class="logo mx-auto d-block">
            </div>
        </div>
    </div>

    <script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>
