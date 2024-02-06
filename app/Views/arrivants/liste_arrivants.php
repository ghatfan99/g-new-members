<?= $this->extend('layout/dashboard-layout'); ?>
<?= $this->section('content'); ?>
<div class="row mx-auto my-auto" mt-3>
    <div class="col col-md-12 mx-auto">
        <p class="lead alert alert-info">La liste des nouveaux arrivants en attente de compléter leurs information par le RH dans <strong>SILOSE</strong>
        </p>
        <hr>
        <div id="accordion">
            <!-- PHD -->
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#phd" aria-expanded="true" aria-controls="phd">
                            Doctorants / <i>Phd</i>
                        </button>
                    </h5>
                </div>

                <div id="phd" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <table id="phdTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Genre</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Date de naissance</th>
                                    <th>Ville de naissance</th>
                                    <th>Nationalité</th>
                                    <th>Email</th>
                                    <th>Titre de thèse</th>
                                    <th>&#201;cole doctorale</th>
                                    <th>Dernier diplôme</th>
                                    <th>Etablissement Der Diplôme</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($phd) : ?>
                                    <?php foreach ($phd as $elt) : ?>
                                        <tr>
                                            <td><?php echo $elt->user_genre; ?></td>
                                            <td><?php echo $elt->nom; ?></td>
                                            <td><?php echo $elt->prenom; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($elt->date_naiss)); ?></td>
                                            <td><?php echo $elt->ville_naiss; ?></td>
                                            <td><?php echo $elt->nationalite_details[0]["nationalite"]; ?></td>
                                            <td><?php echo $elt->email; ?></td>
                                            <td><?php echo $elt->titre_these; ?></td>
                                            <td class="info-cursor" title="<?php echo $elt->phd_doc_details[0]["nom_ed"]; ?>">
                                                <?php echo $elt->phd_doc_details[0]["sigle_ed"]; ?>
                                            </td>
                                            <td><?php echo $elt->phd_der_diplome; ?></td>
                                            <td><?php echo $elt->phd_etab_der_diplome; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- ************************************** -->

            <!-- Chercheurs & EC -->
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#ec" aria-expanded="false" aria-controls="ec">
                            Chercheur ou Enseignant chercheur
                        </button>
                    </h5>
                </div>
                <div id="ec" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <table id="ecTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Genre</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Date de naissance</th>
                                    <th>Ville de naissance</th>
                                    <th>Nationalité</th>
                                    <th>Email</th>
                                    <th>Corps Grade</th>
                                    <th>Section</th>
                                    <th>&#201;cole doctorale</th>
                                    <th>Date HDR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($ec) : ?>
                                    <?php foreach ($ec as $elt) : ?>
                                        <tr>
                                            <td><?php echo $elt->user_genre; ?></td>
                                            <td><?php echo $elt->nom; ?></td>
                                            <td><?php echo $elt->prenom; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($elt->date_naiss)); ?></td>
                                            <td><?php echo $elt->ville_naiss; ?></td>
                                            <td><?php echo $elt->nationalite_details[0]["nationalite"]; ?></td>
                                            <td><?php echo $elt->email; ?></td>
                                            <td class="info-cursor" title="<?php echo $elt->corps_grade_details[0]["nom_corps_grade"]; ?>">
                                                <?php echo $elt->corps_grade_details[0]["code_corps_grade"]; ?>
                                            </td>
                                            <td class="info-cursor" title="<?php echo $elt->section_details[0]["nom_section"]; ?>">
                                                <?php echo $elt->section_details[0]["nom_court_section"]; ?>
                                            </td>
                                            <td class="info-cursor" title="<?php echo $elt->ec_doc_details[0]["nom_ed"]; ?>">
                                                <?php echo $elt->ec_doc_details[0]["sigle_ed"]; ?>
                                            </td>
                                            <td><?php echo date('d/m/Y', strtotime($elt->ec_date_hdr)); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- ************************************** -->

            <!-- Postdoc & Ingénieurs -->
            <div class="card">
                <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#ipostdoc" aria-expanded="false" aria-controls="ipostdoc">
                            Ingénieur, PostDoc / Engineer
                        </button>
                    </h5>
                </div>
                <div id="ipostdoc" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <table id="ipostdocTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Genre</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Date de naissance</th>
                                    <th>Ville de naissance</th>
                                    <th>Nationalité</th>
                                    <th>Email</th>
                                    <th>Dernier diplôme</th>
                                    <th>Etablissement Der Diplôme</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($ipostdoc) : ?>
                                    <?php foreach ($ipostdoc as $elt) : ?>
                                        <tr>
                                            <td><?php echo $elt->user_genre; ?></td>
                                            <td><?php echo $elt->nom; ?></td>
                                            <td><?php echo $elt->prenom; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($elt->date_naiss)); ?></td>
                                            <td><?php echo $elt->ville_naiss; ?></td>
                                            <td><?php echo $elt->nationalite_details[0]["nationalite"]; ?></td>
                                            <td><?php echo $elt->email; ?></td>
                                            <td><?php echo $elt->i_postdoc_der_diplome; ?></td>
                                            <td><?php echo $elt->i_postdoc_etab_der_diplome; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- ************************************** -->

            <!-- Autres -->
            <div class="card">
                <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#autres" aria-expanded="false" aria-controls="autres">
                            Stagiaires, Collaborateurs bénévoles, Doctorants extérieurs, ... (Statut : Autre)
                        </button>
                    </h5>
                </div>
                <div id="autres" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <table id="autresTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Genre</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Date de naissance</th>
                                    <th>Ville de naissance</th>
                                    <th>Nationalité</th>
                                    <th>Email</th>
                                    <th>Dernier diplôme</th>
                                    <th>Etablissement Der Diplôme</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($autres) : ?>
                                    <?php foreach ($autres as $elt) : ?>
                                        <tr>
                                            <td><?php echo $elt->user_genre; ?></td>
                                            <td><?php echo $elt->nom; ?></td>
                                            <td><?php echo $elt->prenom; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($elt->date_naiss)); ?></td>
                                            <td><?php echo $elt->ville_naiss; ?></td>
                                            <td><?php echo $elt->nationalite_details[0]["nationalite"]; ?></td>
                                            <td><?php echo $elt->email; ?></td>
                                            <td><?php echo $elt->autres_der_diplome; ?></td>
                                            <td><?php echo $elt->autres_etab_der_diplome; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- ************************************** -->
        </div>
    </div>
</div>
<?= $this->endSection(); ?>