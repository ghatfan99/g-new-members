<?= $this->extend('layout/dashboard-layout'); ?>
<?= $this->section('content'); ?>

<div class="col mx-auto my-auto">
    <div class="card-body">
        <div class="col col-md-8 mx-auto my-auto">
            <form action="<?= base_url('comptes/update_compte/' . $user_info['id_user']); ?>" method="POST" autocomplete="off">
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
                    <input type="nom" class="form-control" name="nom" placeholder="Entrez votre nom ici" value="<?= $user_info['nom']; ?>" />
                    <span class="text-danger"><?= isset($validation) ? display_error($validation, 'nom') : ''; ?></span>
                </div>

                <!-- Prenom -->
                <div class="form-group mb-3 has-validation">
                    <label for="prenom" class="form-label">Prenom <span class="required">*</span></label>
                    <input type="prenom" class="form-control" name="prenom" placeholder="Entrez votre prenom ici" value="<?= $user_info['prenom']; ?>" />
                    <span class="text-danger"><?= isset($validation) ? display_error($validation, 'prenom') : ''; ?></span>
                </div>

                <!-- Email -->
                <div class="form-group mb-3 has-validation">
                    <label for="email" class="form-label">Email <span class="required">*</span></label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Entrez votre email ici" value="<?= $user_info['email']; ?>" />
                    <span class="text-danger"><?= isset($validation) ? display_error($validation, 'email') : ''; ?></span>
                </div>

                <!-- Status -->
                <div class="form-group mb-3 has-validation">
                    <label for="statutOptions" class="form-label">
                        Statut <span class="required">*</span>
                        <i class="fas fa-info-circle" title="Le statut 'Gestionnaire Administratif' au sein de notre système
                         est lié au rôle d'administrateur. Lorsqu'un utilisateur est attribué le statut de 'Gestionnaire Administratif',
                         cela implique automatiquement qu'il possède des privilèges et des responsabilités associés à un administrateur."></i>
                    </label>
                    <select class="form-control" name="statutOptions" id="statutOptions">
                        <option value="gestionrh" <?= set_select('statutOptions', 'gestionrh'); ?>>Gestionnaire Administratif</option>
                        <option value="phd" <?= $user_info['na_status'] === 'phd' ? 'selected' : ''; ?>>Phd</option>
                        <option value="ipostdoc" <?= $user_info['na_status'] === 'ipostdoc' ? 'selected' : ''; ?>>Ingénieur / Postdoc</option>
                        <option value="autres" <?= $user_info['na_status'] === 'autres' ? 'selected' : ''; ?>>Autres</option>
                        <option value="chercheurEc" <?= $user_info['na_status'] === 'chercheurEc' ? 'selected' : ''; ?>>Chercheurs</option>
                    </select>
                    <span class="text-danger"><?= isset($validation) ? display_error($validation, 'statutOptions') : ''; ?></span>
                </div>

                <!-- Le compte est actif par defaut -->
                <div class="form-check" title="Préciser si le compte utilisateur est actif où non, pour se connecter à l'application il faut que le compte soit actif">
                    <input type="checkbox" class="form-check-input" id="actif" name="actif" <?= $user_info['actif'] === 't' ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="actif">
                        <strong>
                            Compte actif
                        </strong>
                    </label>
                </div>

                <hr>
                <p class="alert alert-danger pt-3">
                    Attention : L'administrateur dispose de tous les droits sur le site. Il est essentiel de faire preuve de prudence et de responsabilité dans l'utilisation de ces droits pour garantir le bon fonctionnement et la sécurité du site.
                </p>

                <div class="form-check" title="Préciser si l'utilisateur a le droit administrateur (créer et supprimer des personnes)">
                    <input type="checkbox" class="form-check-input" id="admin_hidden" name="admin_hidden" disabled>
                    <!-- Add a hidden input field to store the value of the checkbox -->
                    <input type="hidden" name="admin" value="<?= ($user_info['role'] === 't') ? 'on' : ''; ?>">


                    <label class="form-check-label" for="admin_hidden">
                        <strong>
                            Administrateur
                        </strong>
                    </label>
                </div>

                <div class="form-group mt-3 col-md-4 mx-auto">
                    <button class="btn btn-primary btn-block" type="submit">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
        <hr>
    </div>
</div>

<?= $this->endSection(); ?>