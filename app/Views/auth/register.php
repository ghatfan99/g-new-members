<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte</title>
    <link rel="stylesheet" href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>">
</head>

<body>
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center" style="margin-top: 45px;">
            <div class="jumbotron">
                <h2 class="text-center">
                    Fiche de Renseignements pour tous les personnels du laboratoire G-SCOP
                </h2>
                <h3 class="text-center text-secondary">
                    <i> Details Form for the whole G-SCOP lab staff </i>
                </h3>
            </div>
            <div class="col-6 mx-auto">
                <h4>Créer un compte / Sign up</h4>
                <hr>
                <form action="<?= base_url('auth/save'); ?>" method="POST" autocomplete="off">
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

                    <div class="form-group mb-3 has-validation">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" placeholder="Entrez votre email ici" value="<?= set_value('email'); ?>" />
                        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'email') : ''; ?></span>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" name="password" placeholder="Entrez votre mot de passe" value="<?= set_value('password'); ?>" />
                        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'password') : ''; ?></span>
                    </div>

                    <div class="form-group mb-3">
                        <label for="cfpassword" class="form-label">Confirmer votre mot de passe</label>
                        <input type="password" class="form-control" name="cfpassword" placeholder="Confirmer votre mot de passe" value="<?= set_value('cfpassword'); ?>" />
                        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'cfpassword') : ''; ?></span>
                    </div>

                    <div class="form-group mb-3">
                        <button class="btn btn-primary btn-block" type="submit">
                            Enregistrer
                        </button>
                    </div> <br>
                    <a href="<?= site_url('auth/index'); ?>">J'ai déjà un compte</a>
                </form>
            </div>
        </div>
    </div>

</body>

</html>