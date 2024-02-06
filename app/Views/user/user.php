<?= $this->extend('layout/dashboard-layout'); ?>
<?= $this->section('content'); ?>
<div class="row mx-auto my-auto" mt-3>
    <div class="col col-md-10 mx-auto">
        <!--  ********* View success and fail messages ******** -->
        <div id="message-container">
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
        </div>
        <!-- ************************************************** -->
        <p class="lead alert alert-info">
            Les informations utilisateurs
        </p>
        <hr>
        <div class="jumbotron">
            <h2 class="text-center">
                Fiche de Renseignements pour tous les personnels du laboratoire G-SCOP
            </h2>
            <h3 class="text-center">
                <i> Details Form for the whole G-SCOP lab staff </i>
            </h3>
        </div>
        <?php echo session()->get('form_submitted'); ?>
        <form id="nouveauxArrivantF" action="<?= base_url('user/save_data'); ?>" method="POST" autocomplete="off">

            <!-- Le genre -->
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="genre">Genre :<span class="required">*</span></label>
                        <select class="form-control" id="genre" name="genre" required>
                            <option value="Mme" <?= isset($user_shared_info['genre']) && $user_shared_info['genre'] === 'Mme' ? 'selected' : '' ?>>Mme/<i>Mrs</i></option>
                            <option value="Mr" <?= isset($user_shared_info['genre']) && $user_shared_info['genre'] === 'Mr' ? 'selected' : '' ?>>M/<i>Mr</i></option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- ******************** -->

            <!-- Nom -->
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="nom">Nom <i>/ Last Name</i> : <span class="required">*</span></label>
                        <input type="text" class="form-control" id="nom" placeholder="Enter le nom" name="nom" required value="<?= isset($user_shared_info['nom']) ? $user_shared_info['nom'] : '' ?>">
                    </div>
                </div>
            </div>
            <!-- ******************** -->

            <!-- Prénom -->
            <div class=" row justify-content-center">
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="prenom">Prénom <i>/ First Name</i> : <span class="required">*</span></label>
                        <input type="text" class="form-control" id="prenom" placeholder="Enter le prénom" name="prenom" required value="<?= isset($user_shared_info['prenom']) ? $user_shared_info['prenom'] : '' ?>">
                    </div>
                </div>
            </div>
            <!-- ******************** -->

            <!-- Nom patronomique -->
            <div class=" row justify-content-center">
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="nomPatronomique">Nom patronomique <i>/ Maiden name :</i> </label>
                        <input type="text" class="form-control" id="nomPatronomique" placeholder="Enter le nom patronomique" name="nomPatronomique" value="<?= isset($user_shared_info['nom_patronomique']) ? $user_shared_info['nom_patronomique'] : '' ?>">
                    </div>
                </div>
            </div>
            <!-- ******************** -->

            <!-- Date de naissance -->
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="dateNaiss">
                            Date de naissance <i>/ Birth date :</i> <span class="required">*</span>
                        </label>
                        <?php
                        $formatted_date = isset($user_shared_info['date_naiss']) ? date("Y-m-d", strtotime($user_shared_info['date_naiss'])) : '';
                        ?>
                        <input type="date" class="form-control" id="dateNaiss" placeholder="jj/mm/yyyy (dd/mm/yyyy)" name="dateNaiss" required value="<?= $formatted_date ?>">

                    </div>
                </div>
            </div>
            <!-- ******************** -->

            <!-- Ville de naissance -->
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="villeNaiss">Ville de naissance <i>/ City of birth :</i></label>
                        <input type="text" class="form-control villeNaiss" id="villeNaiss" placeholder="Entrer la ville de naissance" name="villeNaiss" value="<?= isset($user_shared_info['ville_naiss']) ? $user_shared_info['ville_naiss'] : '' ?>">
                    </div>
                </div>
            </div>
            <!-- ******************** -->

            <!-- Département de naissance -->
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="depNaiss">
                            Département de naissance /<i>Birth department</i>:<i class="fas fa-info-circle warning" title="Autre pour les personnes nées à l'étranger / Autre for people born abroad"></i>
                        </label>
                        <select type="text" class="form-control" name="depNaiss" id="depNaiss" placeholder="Entrer votre département de naissance / Birth department (Autre for non french birth)" value="<?= isset($user_shared_info['num_departement']) ? $user_shared_info['num_departement'] : '' ?>">
                            <option value="" disabled <?= !isset($user_shared_info['num_departement']) || empty($user_shared_info['num_departement']) ? 'selected' : '' ?>>
                                Sélectionner votre département de naissance
                            </option>
                            <?php foreach ($departements as $depNaiss) : ?>
                                <option value="<?= $depNaiss['num_departement'] ?>" <?= isset($user_shared_info['num_departement']) && $user_shared_info['num_departement'] === $depNaiss['num_departement'] ? 'selected' : '';
                                                                                    if ($depNaiss['num_departement'] === '99') echo 'style="background-color: lightgray;"' ?>>
                                    <?= $depNaiss['nom_departement'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <!-- ******************** -->

            <!-- Pays de naissance -->
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="paysNaiss">Pays <i>/ Country :</i><span class="required">*</span></label>
                        <select type="text" class="form-control" id="paysNaiss" placeholder="Entrer votre pays de naissance" name="paysNaiss" required value="<?= isset($user_shared_info['pays_naiss']) ? $user_shared_info['pays_naiss'] : '' ?>">
                            <option value="" disabled <?= !isset($user_shared_info['pays']) || empty($user_shared_info['pays']) ? 'selected' : '' ?>>
                                Sélectionner votre pays de naissance
                            </option>
                            <?php foreach ($pays as $paysElt) : ?>
                                <option value="<?= $paysElt['code_iso_pays'] ?>" <?= isset($user_shared_info['pays_naiss']) && $user_shared_info['pays_naiss'] === $paysElt['code_iso_pays'] ? 'selected' : '' ?>>
                                    <?= $paysElt['pays'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <!-- ******************** -->

            <!-- Nationalité -->
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="nationalite">Nationalité <i>/ Nationality</i> :<span class="required">*</span></label>
                        <select class="form-control" id="nationalite" name="nationalite" required>
                            <option value="" disabled <?= !isset($user_shared_info['nationalite']) || empty($user_shared_info['nationalite']) ? 'selected' : '' ?>>
                                Sélectionner votre nationalité
                            </option>
                            <?php foreach ($pays as $paysElt) : ?>
                                <option value="<?= $paysElt['code_iso_pays'] ?>" <?= isset($user_shared_info['nationalite']) && $user_shared_info['nationalite'] === $paysElt['code_iso_pays'] ? 'selected' : '' ?>>
                                    <?= $paysElt['nationalite'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <!-- ******************** -->

            <!-- Adresse permanente -->
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <fieldset class="form-group">
                        <div class="row">
                            <legend class="col-md-5 col-form-label pt-0"> <strong>Adresse permanente <i>/ Permanent address</i>: </strong>
                                <i class="fas fa-info-circle" title="En France seulement / If you have an address in France"></i>
                            </legend>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="adresse">Détail adresse <i>/ Address </i> :</label>
                                    <input type="text" class="form-control adresse" id="adresse" placeholder="Entrer votre adresse" name="adresse" value="<?= isset($user_shared_info['adresse']) ? $user_shared_info['adresse'] : '' ?>">
                                </div>
                                <div class="form-group">
                                    <label for="cpVille">Ville - Code Postal <i> /City - Postal Code</i> :</label>
                                    <input class="form-control" id="cpVille" placeholder="Entrer votre département de naissance" name="cpVille" value="<?= isset($user_shared_info['ville_cp']) ? $user_shared_info['ville_cp'] : '' ?>">
                                </div>
                                <div class="form-group">
                                    <label for="paysAdresse">Pays <i>/ Country :</i></label>
                                    <select class="form-control" id="paysAdresse" placeholder="Sélectionner un pays" name="paysAdresse" value="<?= isset($user_shared_info['pays']) ? $user_shared_info['pays'] : '' ?>">
                                        <option value="" disabled <?= !isset($user_shared_info['pays']) || empty($user_shared_info['pays']) ? 'selected' : '' ?>>
                                            Sélectionner
                                        </option>
                                        <option value="FR" <?= isset($user_shared_info['pays']) && $user_shared_info['pays'] == 'France' ? 'selected' : '' ?>>
                                            France
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <!-- ******************** -->


            <!-- Numéro du téléphone -->
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="telMobile">Téléphone mobile <i>/ Cell phone :</i> </label>
                        <input type="text" class="form-control" id="telMobile" placeholder="numéro de téléphone" name="telMobile" value="<?= isset($user_shared_info['tel_mobile']) ? $user_shared_info['tel_mobile'] : '' ?>">
                    </div>
                </div>
            </div>
            <!-- ******************** -->

            <!-- E-mail personnel -->
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="emailPers">e-mail <span class="required">*</span></label>
                        <input type="email" class="form-control" id="emailPers" placeholder="Entrer votre e-mail" name="emailPers" value="<?= esc(session()->get('email_logged_user')) ?>" readonly>
<!--                        <input type="email" class="form-control" id="emailPers" placeholder="Entrer votre e-mail" name="emailPers" value="--><?php //= session()->get('email_logged_user') ? session()->get('email_logged_user') : '' ?><!--" --><?php //= session()->get('email_logged_user') ? 'disabled' : '' ?><!-->
                    </div>
                </div>
            </div>
            <!-- ******************** -->

            <!-- Autorisation photo en interne -->
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <div class="form-group form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="authPhotoInt" id="authPhotoInt" <input type="checkbox" name="auth_photo_int" <?= isset($user_shared_info['auth_photo_int']) && $user_shared_info['auth_photo_int'] === 't' ? 'checked' : '' ?>>
                            <strong>Authorisation diffusion photo en interne
                                <i>/ Internal photo authorization</i>
                            </strong>
                            <i class="fas fa-info-circle" title="La photo sera visible sur le site intranet du labo &#10; Your photo will be visible on the lab's intranet site"></i>
                        </label>
                    </div>
                </div>
            </div>
            <!-- ******************** -->

            <!-- Autorisation photo en externe -->
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <div class="form-group form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="authPhotoExt" id="authPhotoExt" <?= isset($user_shared_info['auth_photo_ext']) && $user_shared_info['auth_photo_ext'] === 't' ? 'checked' : '' ?>>
                            <strong>Authorisation diffusion photo en externe
                                <i>/ Authorisation for external photo distribution</i>
                            </strong>
                            <i class="fas fa-info-circle" title="La photo sera visible sur le site internet du labo &#10;Your photo will be visible on the lab's website"></i>
                        </label>
                    </div>
                </div>
            </div>
            <!-- ******************** -->
            <!-- ******************** -->
            <hr>

            <!-- Information suplémentaire selon le statut -->
            <div class="row justify-content-center">
                <div class="col-sm-8 alert alert-primary text-center">
                    <h4>Informations supplémentaires selon le statut</h4>
                </div>
                <div class="col-sm-8">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="statutOptions" value="chercheurEc" <?= ($_SESSION['statut_logged_user'] === 'chercheurEc') ? 'checked' : 'disabled' ?>>
                            Chercheur ou Enseignant chercheur
                        </label>
                    </div>

                    <!-- Doctorant / PHD -->
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="statutOptions" value="phd" <?= ($_SESSION['statut_logged_user'] === 'phd') ? 'checked' : 'disabled' ?>>
                            Doctorant / <i>PHD</i>
                            <i class="fas fa-info-circle warning" title="Le laboratoire principale est G-SCOP/ The main laboratory is G-SCOP"></i>
                        </label>
                    </div>

                    <!-- Ingénieur, PostDoc / Engineer -->
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="statutOptions" value="ipostdoc" <?= ($_SESSION['statut_logged_user'] === 'ipostdoc') ? 'checked' : 'disabled' ?>>
                            Ingénieur, PostDoc / <i>Engineer</i>
                        </label>
                    </div>

                    <!-- Autres / Others -->
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="statutOptions" value="autres" <?= ($_SESSION['statut_logged_user'] === 'autres') ? 'checked' : 'disabled' ?>>
                            Autres / <i>Others</i>
                            <i class="fas fa-info-circle" title="Stagiaires, Collaborateurs benevoles, Doctorants extérieurs"></i>
                        </label>
                    </div>
                    <p style="color: red;">* Sélectionner une option / <i>Please select one option</i></p>
                    <!-- ************************************************************************************** -->
                    <!-- ************************************************************************************** -->

                    <!-- Les details des chercheurs / enseignants chercheurs -->
                    <?php if ($_SESSION['statut_logged_user'] === 'chercheurEc') : ?>
                        <div id="chercheurEcDetails" class="statut">

                            <!-- Corps et grade -->
                            <div class="form-group">
                                <label for="corpsGrade">
                                    Corps / Grade : <span class="required">*</span>
                                </label>
                                <select class="form-control" id="corpsGrade" name="corpsGrade" required>
                                    <option value="" disabled <?= !isset($user_statut_info['id_corps_grade']) || empty($user_statut_info['id_corps_grade']) ? 'selected' : '' ?>>
                                        Sélectionner votre CORPS / GRADE
                                    </option>
                                    <?php foreach ($corps_grade as $grade) : ?>
                                        <option value="<?= $grade['id_corps_grade'] ?>" <?= isset($user_statut_info['id_corps_grade']) && $user_statut_info['id_corps_grade'] == $grade['id_corps_grade'] ? 'selected' : '' ?>>
                                            <?= $grade['code_corps_grade'] ?> - <?= $grade['nom_corps_grade'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- ******************** -->

                            <!-- Type section principale -->
                            <div class="form-group">
                                <label for="typeSectionPrincipal"> Type section principale :<span class="required">*</span></label>
                                <select class="form-control" id="typeSectionPrincipal" name="typeSectionPrincipal" required>
                                    <option value="" disabled <?= !isset($user_statut_info['code_type_section']) || empty($user_statut_info['code_type_section']) ? 'selected' : '' ?>>
                                        Sélectionner le type de section principale </option>
                                    <?php foreach ($type_sections as $t_section) : ?>
                                        <option value="<?= $t_section['code_type_section'] ?>" <?= isset($user_statut_info['code_type_section']) && $user_statut_info['code_type_section'] == $t_section['code_type_section'] ? 'selected' : '' ?>>
                                            <?= $t_section['nom_type_section'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- ******************** -->

                            <!-- Section pricipale -->
                            <div class="form-group">
                                <label for="sectionPrincipale"> Section principale : <span class="required">*</span></label>
                                <select class="form-control" id="sectionPrincipale" name="sectionPrincipale" required>
                                    <option value="" disabled <?= !isset($user_statut_info['id_section']) || empty($user_statut_info['id_section']) ? 'selected' : '' ?>>
                                        Sélectionner votre section principale
                                    </option>
                                    <?php foreach ($sections as $section) : ?>
                                        <option value="<?= $section['id_section'] ?>" <?= isset($user_statut_info['id_section']) && $user_statut_info['id_section'] == $section['id_section'] ? 'selected' : '' ?>>
                                            <?= $section['nom_court_section'] ?> - <?= $section['nom_section'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- ******************** -->

                            <!-- Ecole doctorale -->
                            <div class="form-group">
                                <label for="ecoleDocEC">Ecole doctorale <i>/ Doctoral school :</i> <span class="required">*</span> </label>
                                <select class="form-control" id="ecoleDocEC" name="ecoleDocEC">
                                    <option value="" disabled <?= !isset($user_statut_info['id_ecole_doctorale']) || empty($user_statut_info['id_ecole_doctorale']) ? 'selected' : '' ?>>
                                        Sélectionner une école doctorale
                                    </option>
                                    <?php foreach ($ecole_doctorales as $ed_elt) : ?>
                                        <option value="<?= $ed_elt['id_ecole_doctorale'] ?>" <?= isset($user_statut_info['id_ecole_doctorale']) && $user_statut_info['id_ecole_doctorale'] == $ed_elt['id_ecole_doctorale'] ? 'selected' : '' ?>>
                                            <?= $ed_elt['nom_ed'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- ******************** -->

                            <!-- Discipline -->
                            <div class="form-group">
                                <label for="disciplineEC"> Discipline :</label>
                                <select class="form-control" id="disciplineEC" name="disciplineEC">
                                    <option value="" disabled <?= !isset($user_statut_info['id_discipline']) || empty($user_statut_info['id_discipline']) ? 'selected' : '' ?>>
                                        Sélectionner une discipline
                                    </option>
                                    <?php foreach ($disciplines as $discipline) : ?>
                                        <option value="<?= $discipline['id_discipline'] ?>" <?= isset($user_statut_info['id_discipline']) && $user_statut_info['id_discipline'] == $discipline['id_discipline'] ? 'selected' : '' ?>>
                                            <?= $discipline['code_discipline'] ?> - <?= $discipline['discipline'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- ******************** -->

                            <!-- Date HDR -->
                            <div class="form-group">
                                <label for="dateHDR">
                                    Date HDR :
                                </label>
                                <input type="date" class="form-control" id="dateHDR" placeholder="Entrez la date de votre HDR" name="dateHDR" value="<?= isset($user_statut_info['ec_date_hdr']) ? $user_statut_info['ec_date_hdr'] : '' ?>">
                            </div>
                            <!-- ******************** -->
                            <!-- Immatriculation et puissance fiscale -->
                            <div class="form-group">
                                <label for="immPuiFisCEC">Immatriculation et PF : <i class="fas fa-info-circle" title="L'immatriculation et la puissance fiscale de votre voiture"></i></label>
                                <input type="text" class="form-control" id="immPuiFisCEC" placeholder="Immatriculation voiture" name="immPuiFisCEC" value="<?= isset($user_statut_info['ec_imm_pui_fis']) ? $user_statut_info['ec_imm_pui_fis'] : '' ?>">
                            </div>
                            <!-- ******************** -->
                        </div>
                        <!-- ***************************** -->
                        <!-- ***************************** -->

                        <!-- Les details des doctorant -->
                    <?php elseif ($_SESSION['statut_logged_user'] === 'phd') : ?>
                        <div id="phdDetails" class="statut">
                            <!-- Ecole doctorale -->
                            <div class="form-group">
                                <label for="ecoleDoc">Ecole doctorale <i>/ Doctoral school :</i> <span class="required">*</span> </label>
                                <select class="form-control" id="ecoleDoc" name="ecoleDoc">
                                    <option value="" disabled <?= !isset($user_statut_info['id_ecole_doctorale']) || empty($user_statut_info['id_ecole_doctorale']) ? 'selected' : '' ?>>
                                        Sélectionner une école doctorale
                                    </option>
                                    <?php foreach ($ecole_doctorales as $ed_elt) : ?>
                                        <option value="<?= $ed_elt['id_ecole_doctorale'] ?>" <?= isset($user_statut_info['id_ecole_doctorale']) && $user_statut_info['id_ecole_doctorale'] == $ed_elt['id_ecole_doctorale'] ? 'selected' : '' ?>>
                                            <?= $ed_elt['sigle_ed'] . ' - ' . $ed_elt['nom_ed']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- ***************************** -->

                            <!-- Titre de thése -->
                            <div class="form-group">
                                <label for="titreThese">Titre de la thèse <i>/ Thesis title </i>:<span class="required">*</span></label>
                                <textarea class="form-control" rows="2" id="titreThese" name="titreThese" required>
                                    <?= isset($user_statut_info['titre_these']) ? $user_statut_info['titre_these'] : '' ?>
                                </textarea>
                            </div>
                            <!-- ***************************** -->

                            <!-- Dernier diplôme phd -->
                            <div class="form-group">
                                <label for="phdDerDiplome">Dernier diplôme obtenu <i>/ Last diploma obtained</i> :<span class="required">*</span></label>
                                <input type="text" class="form-control" id="phdDerDiplome" placeholder="Enter le dernier diplôme obtenu" name="phdDerDiplome" required value="<?= isset($user_statut_info['phd_der_diplome']) ? $user_statut_info['phd_der_diplome'] : '' ?>">
                            </div>
                            <!-- ***************************** -->

                            <!-- Etablissement dernier diplôme phd -->
                            <div class="form-group">
                                <label for="phdEtabDerDiplome">Etablissement du dernier diplôme <i>/ Last diploma establishment</i> :<span class="required">*</span></label>
                                <input type="text" class="form-control" id="phdEtabDerDiplome" placeholder="Enter l'etablissement du dernier diplôme obtenu" name="phdEtabDerDiplome" required value="<?= isset($user_statut_info['phd_etab_der_diplome']) ? $user_statut_info['phd_etab_der_diplome'] : '' ?>">
                            </div>
                            <!-- ***************************** -->
                        </div>
                        <!-- ***************************** -->
                        <!-- ***************************** -->

                        <!-- Les details des ingénieurs et postdoc -->
                    <?php elseif ($_SESSION['statut_logged_user'] === 'ipostdoc') : ?>
                        <div id="ipostdocDetails" class="statut">
                            <div class="form-group">
                                <label for="iPostdocDerDiplome">Dernier diplôme obtenu <i>/ Last diploma obtained</i> :</label>
                                <input type="text" class="form-control" id="iPostdocDerDiplome" name="iPostdocDerDiplome" placeholder="Enter le dernier diplôme obtenu" value="<?= isset($user_statut_info['i_postdoc_der_diplome']) ? $user_statut_info['i_postdoc_der_diplome'] : '' ?>">
                            </div>
                            <div class="form-group">
                                <label for="iPostDocEtabDerDiplomeI">Etablissement du dernier diplôme <i>/ Last diploma establishment</i> :</label>
                                <input type="text" class="form-control" id="iPostDocEtabDerDiplomeI" name="iPostDocEtabDerDiplomeI" placeholder="Enter l'établissement du dernier diplôme obtenu" value="<?= isset($user_statut_info['i_postdoc_etab_der_diplome']) ? $user_statut_info['i_postdoc_etab_der_diplome'] : '' ?>">
                            </div>
                        </div>
                        <!-- ***************************** -->
                        <!-- ***************************** -->

                        <!-- Les details des autres (stagiaires, visiteurs, ITA, ...) -->
                    <?php elseif ($_SESSION['statut_logged_user'] === 'autres') : ?>
                        <div id="autresDetails" class="statut">
                            <div class="form-group">
                                <label for="derDiplomeAutres">Dernier diplôme obtenu <i>/ Last diploma obtained</i> :</label>
                                <input type="text" class="form-control" id="derDiplomeAutres" placeholder="Enter le dernier diplôme obtenu" name="derDiplomeAutres" value="<?= isset($user_statut_info['autres_der_diplome']) ? $user_statut_info['autres_der_diplome'] : '' ?>">
                            </div>
                            <div class="form-group">
                                <label for="etabDerDiplomeAutres">Etablissement du dernier diplôme <i>/ Last diploma establishment</i> :</label>
                                <input type="text" class="form-control" id="etabDerDiplomeAutres" placeholder="Enter l'etablissement du dernier diplôme obtenu" name="etabDerDiplomeAutres" value="<?= isset($user_statut_info['autres_etab_der_diplome']) ? $user_statut_info['autres_etab_der_diplome'] : '' ?>">
                            </div>
                        </div>
                    <?php endif; ?>
                    <!-- ***************************** -->
                    <!-- ***************************** -->

                    <!-- ANNEXE pour les besoins informatiques -->
                    <div class="row" id="besoinsInf">
                        <div class="jumbotron">
                            <h3 class="text-center">
                                ANNEXE
                            </h3>
                            <h4 class="text-center">
                                <i> Fiche de Renseignements G-SCOP : Document complémentaire pour les personnels permanents
                                    <span class="text-secondary">
                                        Details Form G-SCOP / Additional document for the permanent staff
                                    </span>
                                </i>
                            </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nomInfo">Nom <i>/ Last Name</i> : <span class="required">*</span></label>
                                <input type="text" class="form-control" id="nomInfo" name="nomInfo" placeholder="Enter le nom" required value="<?= isset($user_shared_info['nom']) ? $user_shared_info['nom'] : '' ?>" disabled>
                            </div>
                        </div>
                        <div class=" col-sm-6">
                            <div class="form-group">
                                <label for="prenomInfo">Prénom <i>/ First Name</i> : <span class="required">*</span></label>
                                <input type="text" class="form-control" id="prenomInfo" name="prenomInfo" placeholder="Enter le prenom" required value="<?= isset($user_shared_info['prenom']) ? $user_shared_info['prenom'] : '' ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <div class=" card">
                        <div class="card-body">
                            <p>
                                Décrivez ci-dessous vos besoins en matériel informatique et logiciels. Pour cette question veuillez vous rapprocher de votre responsable d’équipe. <br>
                                <span class="text-secondary font-italic">
                                    Describe below your needs in hardware and software. For this question please keep in touch with your team leader
                                </span>
                            </p>
                            <p>
                                En cas d’achat de matériel ou de logiciel, votre responsable d’équipe doit vous indiquer, dans la mesure du possible, la ligne de crédits (compter 2 à 3 mois de délai pour une commande de portable par exemple). <br>
                                <span class="text-secondary font-italic">
                                    In the event of the purchase of equipment or software, your team leader has to indicate you, as possible, the credit line (2 or 3 months of deadline are necessary for a laptop order, for example).
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="card border-primary mb-3 mt-3">
                        <div class="card-header">
                            INFORMATIONS OBLIGATOIRES / <span class="text-scondary font-italic"> Required information : </span><span class="required">*</span>
                        </div>
                        <div class="card-body">
                            <p class="card-text"> Si vous n’avez pas besoin de portable, merci de préciser la raison (équipé par autre entité….). <br>
                                <span class="text-secondary font-italic">
                                    If you do not need any laptop, please specify the reason (provided by another entity…) :
                                </span>
                            </p>
                            <div class="mb-3 row">
                                <div class="col-md-12 form-group">
                                    <label for="explication"></label>
                                    <textarea name="explication" rows="3" class="form-control" id="explication">
                                    <?= isset($user_srv_info['explication']) && $user_srv_info['explication'] ? $user_srv_info['explication'] : '' ?>
                                    </textarea>
                                </div>
                            </div>

                            <h4> Sinon compléter / <span class="text-scondary font-italic">Otherwise complete </span></h4>

                            <!-- Operating System -->
                            <div class="row mb-3">
                                <p class="font-weight-bold">
                                    SYSTEME D’EXPLOITATION / <span class="font-italic">Operating System :</span>
                                </p>
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="windows" name="operationSystem" value="windows" <?= isset($user_srv_info['system_exp']) &&  $user_srv_info['system_exp'] === 'windows' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="windows">Windows</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="linux" name="operationSystem" value="linux" <?= isset($user_srv_info['system_exp']) &&  $user_srv_info['system_exp'] === 'linux' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="linux">Linux</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="macos" name="operationSystem" value="macos" <?= isset($user_srv_info['system_exp']) &&  $user_srv_info['system_exp'] === 'macos' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="macos">MacOs</label>
                                    </div>
                                </div>
                            </div>
                            <!-- *********************************************** -->


                            <!--  CONFIGURATION MATERIELLE -->
                            <div class="row mb-3">
                                <p class="font-weight-bold">
                                    CONFIGURATION MATERIELLE / <span class="font-italic">hardware configuration:</span>
                                </p>
                                <div class="col-md-12">
                                    <div class="form-check form-check ">
                                        <input class="form-check-input" type="radio" id="confStandard" name="confMateriel" value="standard" <?= isset($user_srv_info['config_materiel']) &&  $user_srv_info['config_materiel'] === 'standard' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="confStandard">
                                            STANDARD (portable pour programmation/modélisation) / <span class="text-secondary font-italic"> Upgraded (for modelization, simulation…)</span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check">
                                        <input class="form-check-input" type="radio" id="confIntesive" name="confMateriel" value="intensive" <?= isset($user_srv_info['config_materiel']) && $user_srv_info['config_materiel'] === 'intensive' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="confIntesive">
                                            INTENSIVE (portable de calculs) / <span class="font-italic"> Intensive (calculation workstation) </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- *********************************************** -->

                            <!-- Logiciels spécifiques -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group mb-3 row">
                                        <label for="specific_software">
                                            LOGICIELS SPECIFIQUES / <span class="font-italic">specific software (simulation, development…) :</span>
                                        </label>
                                        <textarea name="specific_software" id="specific_software" rows="3" class="form-control">
                                            <?= isset($user_srv_info['logiciels_spec']) && $user_srv_info['logiciels_spec'] ? $user_srv_info['logiciels_spec'] : '' ?>
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- *********************************************** -->

                            <!-- Information complémentaires -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group mb-3 row">
                                        <label for="additional_informations">
                                            Informations complémentaires / <span class="text-scondary font-italic">additional informations :</span>
                                        </label>
                                        <textarea name="additional_informations" class="form-control" id="additional_informations" rows="3">
                                        <?= isset($user_srv_info['additional_informations']) && $user_srv_info['additional_informations'] ? $user_srv_info['additional_informations'] : '' ?>
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- *********************************************** -->
                        </div>
                        <hr style="border: 1px solid lightblue;">
                        <h5 class="font-weight-bold">
                            PARTIE RESERVEE A L’ADMINISTRATION / <span class="font-italic">SECTION RESERVED TO THE ADMIN</span>
                        </h5>
                        <h4>
                            Signature du Responsable d’équipe / <span class="font-italic">Team leader signature :</span>
                        </h4>
                        <br>
                        <br>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center pt-4 mb-4">
                <!-- <button title="Save / Enregistrer" type="submit" class="btn btn-primary w-25">Enregistrer</button> -->
                <!-- Button to trigger modal -->
                <button type="button" class="btn btn-primary w-25" data-toggle="modal" data-target="#confirmModal">Enregistrer</button>

                <!-- Modal -->
                <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmModalLabel">Rappel / <i>Reminder</i> </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" class="text-danger">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Assurez-vous d'avoir saisi les informations correctes avant de soumettre. Si vous n'êtes pas sûr, vous pouvez enregistrer temporairement les données.
                                </p>
                                <p><i>Please make sure you've entered the correct information before submitting. If unsure, you can temporarily save the data.</i></p>
                            </div>
                            <div class="modal-footer">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary">Enregistrer / <i>Submit</i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ************************************************************************************************** -->
                <button name="save_draft" title="Save the draft / Enregistrer le brouillon" type="submit" class="ml-2 btn btn-secondary w-25">Enregistrer le brouillon</button>
                <button title="Cancel / Annuler" id="resetForm" class="ml-2 btn btn-info w-25">Annuler</button>
            </div>
    </div>
</div>

</form>
<div id="scrollToTop">
    <a href="#" id="scrollToTopButton" title="Scroll to Top">&#9650;</a>
</div>
</div>
</div>
<?= $this->endSection(); ?>