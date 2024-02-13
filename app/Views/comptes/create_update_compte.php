<?= $this->extend('layout/dashboard-layout'); ?>
<?= $this->section('content'); ?>

<div class="col mx-auto my-auto">
    <div class="card-body">
        <div class="col col-md-8 mx-auto my-auto">
            <form action="<?= base_url('comptes/save_update_compte/' . ($user_info['id_user'] ?? '')); ?>" method="POST" autocomplete="off">
                <?= csrf_field(); ?>

                <!--  ********* View success and fail messages ******** -->
                <?php if (!empty(session()->getFlashdata('fail'))) : ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('fail'); ?>
                    </div>
                <?php endif ?>

                <?php if (!empty(session()->getFlashdata('success'))) : ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('success'); ?>
                    </div>
                <?php endif ?>
                <!-- ************************************************** -->

                <!-- Nom -->
                <div class="form-group mb-3 has-validation">
                    <label for="nom" class="form-label">Nom <span class="required">*</span></label>
                    <input type="text" class="form-control" name="nom" placeholder="Entrez votre nom ici" value="<?= $user_info['nom'] ?? set_value('nom'); ?>" />
                    <span class="text-danger"><?= isset($validation) ? display_error($validation, 'nom') : ''; ?></span>
                </div>
                <!-- ******************** -->

                <!-- Prenom -->
                <div class="form-group mb-3 has-validation">
                    <label for="prenom" class="form-label">Prenom <span class="required">*</span></label>
                    <input type="text" class="form-control" name="prenom" placeholder="Entrez votre prenom ici" value="<?= $user_info['prenom'] ?? set_value('prenom'); ?>" />
                    <span class="text-danger"><?= isset($validation) ? display_error($validation, 'prenom') : ''; ?></span>
                </div>
                <!-- ******************** -->

                <!-- Email -->
                <div class="form-group mb-3 has-validation">
                    <label for="email" class="form-label">Email <span class="required">*</span></label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Entrez votre email ici" value="<?= $user_info['email'] ?? set_value('email'); ?>" />
                    <span class="text-danger"><?= isset($validation) ? display_error($validation, 'email') : ''; ?></span>
                </div>
                <!-- ******************** -->

                <!-- Date debut -->
                <div class="form-group mb-3 has-validation">
                    <label for="dateDebut">
                        Date début :<span class="required">*</span>
                    </label>
                    <input type="date" class="form-control" id="dateDebut" placeholder="Entrez la date de début du séjour" name="dateDebut" value="<?= $user_info['date_debut'] ?? set_value('date_debut'); ?>" />
                    <span class="text-danger"><?= isset($validation) ? display_error($validation, 'dateDebut') : ''; ?></span>
                </div>
                <!-- ******************** -->

                <!-- Date fin -->
                <div class="form-group mb-3 has-validation">
                    <label for="dateFin">
                        Date fin :<span class="required">*</span>
                    </label>
                    <input type="date" class="form-control" id="dateFin" placeholder="Entrez la date de fin du séjour" name="dateFin" value="<?= $user_info['date_fin'] ?? set_value('date_fin'); ?>" />
                    <span class="text-danger"><?= isset($validation) ? display_error($validation, 'dateFin') : ''; ?></span>
                </div>
                <!-- ******************** -->

                <!-- Status -->
                <div class="form-group mb-3 has-validation">
                    <label for="statutOptions" class="form-label">
                        Statut <span class="required">*</span>
                        <i class="fas fa-info-circle" title="Le statut 'Gestionnaire Administratif' au sein de notre système
                         est lié au rôle d'administrateur. Lorsqu'un utilisateur est attribué le statut de 'Gestionnaire Administratif',
                         cela implique automatiquement qu'il possède des privilèges et des responsabilités associés à un administrateur."></i>
                    </label>
                    <select class="form-control" name="statutOptions" id="statutOptions">
                        <option value="" disabled selected>Sélectionnez un statut</option>
                        <option value="gestionrh" <?= set_select('statutOptions', 'gestionrh', isset($user_info['na_status']) && $user_info['na_status'] === 'gestionrh'); ?>>Gestionnaire Administratif</option>
                        <option value="phd" <?= set_select('statutOptions', 'phd', isset($user_info['na_status']) && $user_info['na_status'] === 'phd'); ?>>Phd</option>
                        <option value="ipostdoc" <?= set_select('statutOptions', 'ipostdoc', isset($user_info['na_status']) && $user_info['na_status'] === 'ipostdoc'); ?>>Ingénieur / Postdoc</option>
                        <option value="autres" <?= set_select('statutOptions', 'autres', isset($user_info['na_status']) && $user_info['na_status'] === 'autres'); ?>>Autres</option>
                        <option value="chercheurEc" <?= set_select('statutOptions', 'chercheurEc', isset($user_info['na_status']) && $user_info['na_status'] === 'chercheurEc'); ?>>Chercheurs</option>
                    </select>
                    <span class="text-danger"><?= isset($validation) ? display_error($validation, 'statutOptions') : ''; ?></span>
                </div>
                <!-- ******************** -->

                <!-- Le compte est actif par defaut -->
                <div class="form-check" title="Préciser si le compte utilisateur est actif où non, pour se connecter à l'application il faut que le compte soit actif">
                    <input type="checkbox" class="form-check-input" id="actif" name="actif" <?= ($operation === 'create') ? 'checked' : (isset($user_info['actif']) && $user_info['actif'] === 't' ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="actif">
                        <strong>
                            Compte actif <?php echo $operation; ?>
                        </strong>
                    </label>
                </div>
                <!-- ******************** -->

                <hr>
                <p class="alert alert-danger pt-3">
                    Attention : L'administrateur dispose de tous les droits sur le site. Il est essentiel de faire preuve de prudence et de responsabilité dans l'utilisation de ces droits pour garantir le bon fonctionnement et la sécurité du site.
                </p>

                <div class="form-check" title="Préciser si l'utilisateur a le droit administrateur (créer et supprimer des personnes)">
                    <input type="hidden" class="form-check-input" id="admin" name="admin">
                    <!-- Add a hidden input field to store the value of the checkbox -->
                    <input type="checkbox" class="form-check-input" id="admin_hidden" name="admin_hidden" <?= isset($user_info['role']) && $user_info['role'] === 't' ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="admin_hidden">
                        <strong>
                            Administrateur
                        </strong>
                    </label>
                </div>

                <div class="form-group mt-3 col-md-4 mx-auto">
                    <button class="btn btn-primary btn-block" type="submit">
                        <?= isset($user_info) ? 'Mettre à jour' : 'Enregistrer'; ?>
                    </button>
                </div>
            </form>
        </div>
        <hr>
    </div>
</div>

<?= $this->endSection(); ?>