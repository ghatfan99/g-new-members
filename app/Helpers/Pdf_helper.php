<?php
//use App\Libraries\tcpdf\TCPDF;

require_once(APPPATH . 'Libraries/tcpdf/tcpdf.php');
function generatePdfRH($data, $statut): TCPDF
{
    $iPostdocDerDiplome = null;
    $iPostDocEtabDerDiplomeI = null;
    $corpsGrade = null;
    $sectionPrincipale = null;
    $typeSectionPrincipal = null;
    $discipline = null;
    $ecoleDocEC = null;
    $dateHDR = null;
    $immPuiFisCEC = null;
    $phdTitreThese = null;
    $phdEcoleDoc = null;
    $phdDerDiplome = null;
    $phdEtabDerDiplome = null;
    $derDiplomeAutres = null;
    $etabDerDiplomeAutres = null;
    // ************************************************************************ //
    // Informations RH partagées
    // ************************************************************************ //
    $genre = $data['shared_data']["user_genre"];
    $nom = $data['shared_data']["nom"];
    $prenom = $data['shared_data']["prenom"];
    $dateNaiss = date("d/m/Y", strtotime($data['shared_data']["date_naiss"]));
    $paysNaiss = $data['shared_data']["paysVal"];
    $nationalite = $data['shared_data']["nationaliteVal"];
    $emailPers = $data['shared_data']["emailPers"];

    // *** Les données facultatives ***
    $nomPatronomique = $data['shared_data']["nom_patronomique"];
    $villeNaiss = $data['shared_data']["ville_naiss"];
    $depNaiss = $data['shared_data']["departementVal"];
    // Adresse
    $adresse = $data['shared_data']["adresse"];
    $cpVille = $data['shared_data']["ville_cp"];
    // $paysAdresse
    $paysAdresse = $data['shared_data']["pays"] || !empty($data['shared_data']["adresse"]) ? "France" : '';
    // ***
    $telMobile = $data['shared_data']["tel_mobile"];
    $authPhotoInt = !empty($data["shared_data"]["auth_photo_int"]) ? "Oui" : 'Non';
    $authPhotoExt = !empty($data["shared_data"]["auth_photo_ext"]) ? "Oui" : 'Non';
    // ************************************************************************ //

    $statutPdf = getStatusLabel($statut);
    switch ($statut) {
        // Statut ingénieur et postdoc
        case 'ipostdoc':
            # Données facultatives
            $iPostdocDerDiplome = $data["ippostdocData"]["i_postdoc_der_diplome"];
            $iPostDocEtabDerDiplomeI = $data["ippostdocData"]["i_postdoc_etab_der_diplome"];
//            $statutPdf = 'Ingénieur, PostDoc / Engineer';
            break;
        // Statut chercheurs
        case 'chercheurEc':
            # Données obligatoires
            $corpsGrade = $data["chercheurEcData"]["corps_grade"];
            $sectionPrincipale = $data["chercheurEcData"]["nom_section"];
            $typeSectionPrincipal = $data["chercheurEcData"]["nom_type_section"];
            $discipline = $data["chercheurEcData"]["discipline"];
            $ecoleDocEC = $data["chercheurEcData"]["nom_ed"];
            # Données facultatives
            $dateHDR = !empty($data["chercheurEcData"]["dateHDR"]) ? date("d/m/Y", strtotime(trim($_POST["dateHDR"]))) : 'Pas de HDR';
            $immPuiFisCEC = $data["chercheurEcData"]["ec_imm_pui_fis"];
//            $statutPdf = 'Chercheur ou Enseignant chercheur';
            break;
        // Statut doctorants dont le laboratoire pricipale est G-SCOP
        case 'phd':
            # Données obligatoires
            $phdTitreThese = $data["phdData"]["titre_these"];
            $phdEcoleDoc = $data["phdData"]["nom_ed"];
            $phdDerDiplome = $data["phdData"]["phd_der_diplome"];
            $phdEtabDerDiplome = $data["phdData"]["phd_etab_der_diplome"];
//            $statutPdf = 'Doctorant / PHD';
            break;
        // Statut Autres : stagiaire, collaborateurs benevoles, doctorant extérieurs
        case 'autres':
            # Données facultatives
            $derDiplomeAutres = $data["ippostdocData"]["autres_der_diplome"];
            $etabDerDiplomeAutres = $data["ippostdocData"]["autres_etab_der_diplome"];
            $statutPdf = ' Autres / Others (Stagiaires, Doctorants extérieurs, Benevoles, ...)';
            break;
        default:
            # code...
            break;
    }
    // ************************************************************************ //

    $pdfRH = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdfRH->SetCreator(PDF_CREATOR);
    $pdfRH->SetAuthor('Service RH, G-SCOP');
    $pdfRH->SetTitle('Formulaire nouveaux arrivants (Service RH)');
    $pdfRH->SetSubject('Formulaire nouveaux arrivants (Service RH)');
    $pdfRH->SetKeywords('nouveaux, arrivants, Service RH, G-SCOP');

    // set default header data
    $pdfRH->SetHeaderData('gscop_logo.jpg', 40, 'Laboratoire G-SCOP', 'Service RH');
    $pdfRH->setHeaderMargin(20);

    // set header and footer fonts
    $pdfRH->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdfRH->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdfRH->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdfRH->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdfRH->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdfRH->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdfRH->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdfRH->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // ---------------------------------------------------------

    // set font
    $pdfRH->SetFont('dejavusans', '', 10);
    // add a page
    $pdfRH->AddPage();

    // Your HTML content
    $html = '
        <div style="text-align:center; display:flex; justify-content: space-between; border: 1px solid #4796af; gap:5px; line-height: 0.7;">
            <div><b>' . $genre. ' Nom : </b>' . $nom . '</div>
            <div><b>Prénom : </b>' . $prenom . '</div>
            <div><b>Statut : </b>' . $statutPdf . '</div>
        </div>
        <!-- Nom patronomique -->
      <div style="display:flex; flex-direction:column; gap:5px; line-height: 0.7;">
        <p><b>Nom patronomique <i>/ Maiden name : </i></b>'  . $nomPatronomique . '</p> <br>
        <p><b>Date de naissance <i>/ Birth date : </i></b>'  . $dateNaiss . '</p> <br>
        <p><b>Ville de naissance <i>/ City of birth : </i></b>'  . $villeNaiss . '</p> <br>
        <p><b>Département : </b>'  . $depNaiss . '</p> <br>
        <p><b>Pays <i>/ Country </i>: </b>'  . $paysNaiss . '</p> <br>
        <p><b>Nationalité <i>/ Nationality : </i></b>'  . $nationalite . '</p> <br>
      </div>  
      <!-- ******************** -->
      <!-- Nom patronomique -->
      <div style="display:flex; flex-direction:column; gap:5px; line-height: 0.7;">
        <p><b>Nom patronomique <i>/ Maiden name : </i></b>'  . $nomPatronomique . '</p> <br>
        <p><b>Date de naissance <i>/ Birth date : </i></b>'  . $dateNaiss . '</p> <br>
        <p><b>Ville de naissance <i>/ City of birth : </i></b>'  . $villeNaiss . '</p> <br>
        <p><b>Département : </b>'  . $depNaiss . '</p> <br>
        <p><b>Pays <i>/ Country </i>: </b>'  . $paysNaiss . '</p> <br>
        <p><b>Nationalité <i>/ Nationality : </i></b>'  . $nationalite . '</p> <br>
      </div>  
      <!-- ******************** -->
      <!-- Adresse permanente -->
      <div style="display:flex; flex-direction:column; border: 1px solid lightblue; padding: 10px; gap:5px; line-height: 0.8;">              
        <h4> <strong>Adresse permanente <i>/ Permanent address</i> </strong> </h4>
        <p><b> Détail adresse  <i>/ Address</i> : </b>'  . $adresse . '</p> <br>
        <p><b> Ville - Code Postal <i>/ City - Postal Code</i> : </b>'  . $cpVille . '</p> <br>
        <p><b> Pays <i>/Country</i> : </b>'  . $paysAdresse . '</p> <br>
      </div>
      <!-- ******************** -->


      <!-- Numéro du téléphone -->
      <div style="display:flex; flex-direction:column; padding: 10px; gap:5px; line-height: 0.7;">
        <p><b>Téléphone mobile <i>/ Cell phone : </i></b>'  . $telMobile . '</p> <br>      
        <p><b>E-mail : </b>'  . $emailPers . '</p> <br>
      </div>
      <!-- ******************** -->

      <!-- Autorisation photo en interne and Externe -->
      <div style="display:flex; flex-direction:column; padding: 10px; gap:5px; line-height: 0.7;">
        <p><b>Authorisation diffusion photo en interne : </b>'  . $authPhotoInt . '</p> <br>
        <p><b>Authorisation diffusion photo en externe : </b>'  . $authPhotoExt . '</p> <br>
      </div>
      <!-- ******************** -->
    ';

    // Ajouter les details selon le statut de la personne
    switch ($statut) {
        // Statut ingénieur et postdoc
        case 'ipostdoc':
            # Données facultatives
            $statutPdf = 'Ingénieur, PostDoc / Engineer';
            $htmlIpostdoc = '<div style="display:flex; flex-direction:column; padding: 10px; gap:5px; line-height: 0.8;">
                           <p><b>Dernier diplôme obtenu <i>/ Last diploma obtained</i> : </b>' . $iPostdocDerDiplome . '</p>
                           <p><b>Etablissement du dernier diplôme <i>/ Last diploma establishment</i> : </b>' . $iPostDocEtabDerDiplomeI . '</p>
                           </div>';
            $html = $html . $htmlIpostdoc;
            break;
        // Statut chercheurs
        case 'chercheurEc':
            $statutPdf = 'Chercheur ou Enseignant chercheur';
            $htmlChercheurEc = '<div style="display:flex; flex-direction:column; padding: 10px; gap:5px; line-height: 0.8;">
                           <p><b>Corps / Grade : </b>' . $corpsGrade . '</p>
                           <p><b>Discipline : </b>' . $discipline . '</p>
                           <p><b>Type section principale : </b>' . $typeSectionPrincipal . '</p>
                           <p><b>Section principale : </b>' . $sectionPrincipale . '</p>
                           <p><b>Ecole doctorale : </b>' . $ecoleDocEC . '</p>
                           <p><b>Date HDR : </b>' . $dateHDR . '</p>
                           <p><b>Immatriculation et PF : </b>' . $immPuiFisCEC . '</p>
                           </div>';
            $html = $html . $htmlChercheurEc;
            break;
        // Statut doctorants dont le laboratoire pricipale est G-SCOP
        case 'phd':
            $statutPdf = 'Doctorant / PHD';
            $htmlPhd = '<div style="display:flex; flex-direction:column; padding: 10px; gap:5px; line-height: 0.8;">
                           <p><b>Titre de la thèse <i>/ Thesis title </i>:</b>' . $phdTitreThese . '</p>
                           <p><b>Ecole doctorale <i>/ Doctoral school : </b>' . $phdEcoleDoc . '</p>
                           <p><b>Dernier diplôme obtenu <i>/ Last diploma obtained</i> : </b>' . $phdDerDiplome . '</p>
                           <p><b>Etablissement du dernier diplôme <i>/ Last diploma establishment</i> : </b>' . $phdEtabDerDiplome . '</p>
                           </div>';
            $html = $html . $htmlPhd;
            break;
        // Statut Autres : stagiaire, collaborateurs benevoles, doctorant extérieurs
        case 'autres':
            $statutPdf = ' Autres / Others (Stagiaires, Doctorants extérieurs, Benevoles, ...)';
            $htmlAutres = '<div style="display:flex; flex-direction:column; padding: 10px; gap:5px; line-height: 0.8;">
                           <p><b>Dernier diplôme obtenu <i>/ Last diploma obtained</i> : </b>' . $derDiplomeAutres . '</p>
                           <p><b>Etablissement du dernier diplôme <i>/ Last diploma establishment</i> : </b>' . $etabDerDiplomeAutres . '</p>
                           </div>';
            $html = $html . $htmlAutres;
            break;
        default:
            # code...
            break;
    }
    // output the HTML content
    $pdfRH->writeHTML($html, true, false, true);

    $pdfRH->lastPage();
    $pdfRH->close();

    // ---------------------------------------------------------
         return $pdfRH;
    }

function generatePdfSI($data, $statut): TCPDF{
    $nom = $data['shared_data']["nom"];
    $prenom = $data['shared_data']["prenom"];
    $statutPdf = getStatusLabel($statut);
    // ************************************************************************ //

    // Informations service informatique
    $operationSystem = $data["srvData"]["system_exp"];
    $confMateriel = $data["srvData"]["config_materiel"];
    $specific_software = $data["srvData"]["logiciels_spec"];
    $material_need = $data["srvData"]["explication"];
    $additional_accessories = $data["srvData"]["additional_informations"];
    // ************************************************************************ //

    // create Service Informatique PDF document
    $pdfSI = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdfSI->SetCreator(PDF_CREATOR);
    $pdfSI->SetAuthor('Service Informatique, G-SCOP');
    $pdfSI->SetTitle('Formulaire nouveaux arrivants (Service Informatique)');
    $pdfSI->SetSubject('Formulaire nouveaux arrivants (Service Informatique)');
    $pdfSI->SetKeywords('nouveaux, arrivants, Service Informatique, G-SCOP');

    // set default header data
    $pdfSI->SetHeaderData('gscop_logo.jpg', 40, 'Laboratoire G-SCOP', 'Service Informatique');
    $pdfSI->setHeaderMargin(20);
    // set default footer data
    $pdfSI->SetFooterData('Page {PAGENO} / {nb} - ' . date('j/m/Y'), 0, date('j/m/Y'));


    // set header and footer fonts
    $pdfSI->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdfSI->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdfSI->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdfSI->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdfSI->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdfSI->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdfSI->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdfSI->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // ---------------------------------------------------------

    // set font
    $pdfSI->SetFont('dejavusans', '', 10);

    // add a page
    $pdfSI->AddPage();

    // Your HTML content
    $html = '
         <div style="text-align:center; display:flex; justify-content: space-between; border: 1px solid lightblue; gap:5px; line-height: 0.8;">
             <div><b>Nom : </b>' . $nom . '</div>            
             <div><b>Prénom : </b>' . $prenom . '</div>
             <div><b>Statut : </b>' . $statutPdf . '</div>
         </div>
         <div style="display:flex; flex-direction:column; padding: 10px; gap:20px; line-height: 1.1;">
           <p>
             Décrivez ci-dessous vos besoins en matériel informatique et logiciels. Pour cette question veuillez vous rapprocher de votre responsable d’équipe. <br>
             <i style="color:#808080;">
               Describe below your needs in hardware and software. For this question please keep in touch with your team leader
             </i>
           </p>
           <p>
             En cas d’achat de matériel ou de logiciel, votre responsable d’équipe doit vous indiquer, dans la mesure du possible, la ligne de crédits (compter 2 à 3 mois de délai pour une commande de portable par exemple). <br>
             <i style="color:#808080;">
               In the event of the purchase of equipment or software, your team leader has to indicate you, as possible, the credit line (2 or 3 months of deadline are necessary for a laptop order, for example).
             </i>
           </p>
         </div>
         <div style="display:flex; flex-direction:column; padding: 10px; gap:5px; line-height: 0.8;">
           <b>INFORMATIONS OBLIGATOIRES / <i style="color:#808080;"> Required information : </i> </b>
         </div>
           <p> Si vous n’avez pas besoin de portable, merci de préciser la raison (équipé par autre entité….). <br>
             <i style="color:#808080;">
               If you do not need any laptop, please specify the reason (provided by another entity…) :
             </i>
           </p>
           <p>
             ' . $material_need. '
           </p>

           <h4> Sinon compléter / <i style="color:#808080;">Otherwise complete </i></h4>

           <!-- System d\'exploitation -->
           <div>
             <p>
               <b>SYSTEME D’EXPLOITATION / <i style="color:#808080;">Operating System : </i></b> <br>' . $operationSystem . '
             </p>
           </div>
           <!-- *********************************************** -->
           <!--  CONFIGURATION MATERIELLE -->
           <div style="display:flex; flex-direction:column; padding: 10px; gap:5px; line-height: 0.8;">
             <p>
               <b>CONFIGURATION MATERIELLE / <i style="color:#808080;">hardware configuration : </i> </b> <br> <br>' . $confMateriel . '
             </p>
           </div>
           <!-- *********************************************** -->
           <!-- Logiciels spécifiques -->
           <div style="display:flex; flex-direction:column; padding: 10px; gap:5px; line-height: 0.8;">
             <p>
               <b>LOGICIELS SPECIFIQUES / <i style="color:#808080;">specific software (simulation, development…) : </i></b>
             </p> <br> <br>
               ' . $specific_software . '               
           </div>
           <!-- *********************************************** -->
           <!-- Information complémentaires -->
           <div style="display:flex; flex-direction:column; padding: 10px; gap:5px; line-height: 0.8;">
             <p>
               <b>Information complémentaires / <i style="color:#808080;">additional accessories : </i></b>
             </p> <br> <br>
               ' . $additional_accessories . '               
           </div>
           <!-- *********************************************** -->
           <div style="border-top: 1px solid lightblue;">
               <h5>
               PARTIE RESERVEE A L’ADMINISTRATION / <i style="color:#808080;">SECTION RESERVED TO THE ADMIN</i>
             </h5>
             <h4>
               Signature du Responsable d’équipe / <i style="color:#808080;">Team leader signature :</i>
             </h4>           
           </div>        
     ';
    // output the HTML content
    $pdfSI->writeHTML($html, true, false, true);
    $pdfSI->lastPage();
    $pdfSI->close();

    return $pdfSI;
}

function getStatusLabel($statut): string {
    return ($statut == 'phd') ? 'Doctorant / PHD' : (
    ($statut == 'chercheurEc') ? 'Chercheur ou Enseignant chercheur' : (
    ($statut == 'ipostdoc') ? 'Ingénieur, PostDoc / Engineer' : (
    ($statut == 'autres') ? 'Autres / Others (Stagiaires, Doctorants extérieurs, Benevoles, ...)' : 'Unknown Status'
    )
    )
    );
}
