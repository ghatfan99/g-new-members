<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>">
</head>

<body>
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center" style="margin-top: 70px;">
            <div class="jumbotron">
                <h2 class="text-center">
                    Fiche de Renseignements pour tous les personnels du laboratoire G-SCOP
                </h2>
                <h3 class="text-center text-secondary">
                    <i> Details Form for the whole G-SCOP lab staff </i>
                </h3>
            </div>
            <div class="col-6 mx-auto">
                <h4>Connexion / Sign In</h4>
                <hr>
                <form class="mb-lg-4" action="<?= base_url('auth/check'); ?>" method="POST" autocomplete="off">
                    <?= csrf_field(); ?>
                    <!--  ********* View success and fail messages ******** -->
                    <?php if (!empty(session()->getFlashdata('fail'))) : ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('fail'); ?>
                        </div>
                    <?php endif ?>
                    <?php if (session()->has('success')) : ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success'); ?>
                        </div>
                    <?php endif ?>
                    <!-- ************************************************** -->

                    <div class="form-group mb-3 has-validation">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Entrez votre email ici" value="<?= set_value('email'); ?>" />
                        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'email') : ''; ?></span>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Entrez votre mot de passe" value="<?= set_value('password'); ?>" />
                        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'password') : ''; ?></span>
                    </div>

                    <div class="form-group mb-3">
                        <button class="btn btn-primary btn-block" type="submit">
                            Se connecter
                        </button>
                    </div>
                    <br>
                    <a href="<?= site_url('auth/register'); ?>" title="Pour vous inscrire, il est nécessaire d'avoir un email valide renseigné par le service RH dans l'application.
                    To register, you must have a valid email provided by the HR in the application.">
                        Vous n'avez pas de compte? S'inscrire / <i>Sign up</i>
                    </a>
                </form>
                <!--    Legal information -->
                <div class="text-center mb-3">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#legalModal">
                        Voir les Mentions Légales et la Politique de Confidentialité <br> <i>View Legal Notices and Privacy Policy</i>
                    </button>
                </div>
                <div class="modal fade" id="legalModal" tabindex="-1" role="dialog" aria-labelledby="legalModalLabel" aria-hidden="true" >
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="legalModalLabel">Mentions Légales et Politique de Confidentialité / <i>Legal Notices and Privacy Policy</i></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container mt-5">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header bg-primary text-white text-center">
                                                    <h5 class="mb-0">Entête Juridique / <i>Legal Entity</i></h5>
                                                </div>
                                                <div class="card-body text-center">
                                                    <p>
                                                        <b>Grenoble Alpes University</b><br>
                                                        <b>G-SCOP</b><br>
                                                        46 Av. Félix Viallet, 38000 Grenoble<br>
                                                        04 76 57 50 71<br>
                                                        contact-g-scop@grenoble-inp.fr<br>
                                                        <img src="<?= base_url('images/logo_gscop.gif') ?>" alt="G-SCOP"> <br>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="container mt-5">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="accordion">
                                                <!-- French Card - Open by Default -->
                                                <div class="card">
                                                    <div class="card-header bg-success text-white" id="headingFrench">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link text-white text-bold" data-toggle="collapse" data-target="#collapseFrench" aria-expanded="true" aria-controls="collapseFrench">
                                                                Protection des Données Personnelles (RGPD)
                                                            </button>
                                                        </h5>
                                                    </div>

                                                    <div id="collapseFrench" class="collapse show" aria-labelledby="headingFrench" data-parent="#accordion">
                                                        <div class="card-body">
                                                            <p>
                                                                <b>Collecte des Données Personnelles : </b><br>
                                                                Nous collectons certaines informations personnelles lorsque vous utilisez notre site.
                                                                Les types de données que nous collectons peuvent inclure votre nom, prénom, adresse, numéro de téléphone, adresse e-mail, etc.
                                                                Ces informations sont collectées lorsque vous les fournissez volontairement.
                                                                <br>
                                                                Les données fournies via ce formulaire sont enregistrées de manière électronique par le service informatique du laboratoire G-SCOP.
                                                                Cela nous permet de vous accueillir de manière plus efficace dans notre laboratoire et de mieux préparer vos accès informatiques,
                                                                ainsi que d'anticiper vos besoins. <br>
                                                                Les informations collectées seront uniquement partagées avec les destinataires suivants :
                                                                les services informatiques et administratifs du laboratoire. Elles seront conservées pendant une période de 15 jours à compter de la soumission du formulaire.
                                                                <br>
                                                                Vous pouvez accéder aux données vous concernant, les rectifier, demander leur effacement ou exercer votre droit à la limitation du traitement de vos données.
                                                                (en fonction de la base légale du traitement, mentionner également : Vous pouvez retirer à tout moment votre consentement au traitement de vos données.
                                                                Vous pouvez également vous opposer au traitement de vos données, Vous pouvez également exercer votre droit à la portabilité de vos données).
                                                                <br>
                                                                Consultez le site <a href="https://www.cnil.fr/fr">CNIL</a> pour plus d'informations sur vos droits.
                                                                <br>

                                                                Pour exercer ces droits ou pour toute question sur le traitement de vos données dans ce dispositif,
                                                                vous pouvez contacter (le cas échéant, notre délégué à la protection des données ou le service chargé de l’exercice de ces droits) :
                                                                <br>
                                                                <a href="mailto:gscop-dev@grenoble-inp.fr">Correspondant RGPD</a> , 45 Avenue félix viallet, 04 76 57 50 71
                                                                <br> <br>
                                                                Si vous estimez, après nous avoir contactés, que vos droits « Informatique et Libertés » ne sont pas respectés,
                                                                vous pouvez adresser une réclamation à la <a href="https://www.cnil.fr/fr">CNIL</a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- English Card -->
                                                <div class="card">
                                                    <div class="card-header bg-success text-white text-bold" id="headingEnglish">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link text-white collapsed" data-toggle="collapse" data-target="#collapseEnglish" aria-expanded="false" aria-controls="collapseEnglish">
                                                                Personal Data Protection (GDPR)
                                                            </button>
                                                        </h5>
                                                    </div>

                                                    <div id="collapseEnglish" class="collapse" aria-labelledby="headingEnglish" data-parent="#accordion">
                                                        <div class="card-body">
                                                            <p>
                                                                <strong>Collection of Personal Data:</strong><br>
                                                                We collect certain personal information when you use our site.
                                                                The types of data we collect may include your name, surname, address, phone number, email address, etc.
                                                                This information is collected when you voluntarily provide it.
                                                                <br>
                                                                The information collected on this form is recorded in a computerized file by the IT department of the G-SCOP laboratory to better welcome you to our laboratory and better prepare
                                                                your computer accesses as well as anticipate your needs. <br>
                                                                The collected data will only be disclosed to the following recipients: IT and administrative services of the laboratory.
                                                                The data is retained for 15 days after form submission.
                                                                <br>
                                                                You can access, rectify, request the erasure of your data, or exercise your right to restrict the processing of your data.
                                                                (Depending on the legal basis for processing, also mention: You can withdraw your consent to the processing of your data at any time. You can also object to the processing of your data; You can also exercise your right to data portability.).
                                                                <br>
                                                                Visit the <a href="https://www.cnil.fr/en">CNIL</a> website for more information about your rights.
                                                                <br>
                                                                To exercise these rights or for any questions about the processing of your data in this system,
                                                                you can contact (if applicable, our data protection officer or the service responsible for exercising these rights): <a href="mailto:gscop-dev@grenoble-inp.fr">RGPD correspondant</a>, 45 Avenue Félix Viallet, 04 76 57 50 71.
                                                                <br> <br>
                                                                If, after contacting us, you believe that your "Information Technology and Freedoms" rights are not being respected,
                                                                you can file a complaint with the <a href="https://www.cnil.fr/en">CNIL</a>.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--    ***************** -->
                <!--    ***************** -->
            </div>
        </div>

    </div>
    <script src="<?= base_url(); ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url(); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>