CREATE SCHEMA IF NOT EXISTS n_arrivants;
/*** users table ***/
CREATE TABLE n_arrivants.users (
    id_user serial NOT NULL PRIMARY KEY,
    nom varchar(255),
    prenom varchar(255),
    password text,
    email varchar(255),
    role boolean DEFAULT false
);
/*** insert test data ***/
INSERT INTO n_arrivants.users
VALUES (
        1,
        'Marchal',
        'Aline',
        '12345',
        'aline@test.com',
        false
    ),
    (
        2,
        'Merkel',
        'Angela',
        '12345',
        'angela@test.com',
        false
    ),
    (
        3,
        'Le grand',
        'Vincent',
        '12345',
        'vincent@test.com',
        false
    ),
    (
        4,
        'Dupond',
        'Marine',
        '12345',
        'marine@test.com',
        true
    ),
    (
        5,
        'Smith',
        'Jhone',
        '12345',
        'jhone@test.com',
        true
    );
/********************/
CREATE TABLE n_arrivants.arrivants (
    id_arrivant serial NOT NULL,
    date_debut_sejour date,
    date_fin_sejour date,
    mail_personnel text,
    genre varchar(3) NOT NULL,
    nom_patronyme text NOT NULL,
    nom_usage text,
    prenom text NOT NULL,
    prenom2 text,
    prenom3 text,
    date_de_naissance date NOT NULL,
    tel_personnel varchar(20),
    /* Adresse permanente */
    adresse_perm text NOT NULL,
    ville_perm text,
    code_postal_perm varchar(15),
    code_pays_perm varchar(3) NOT NULL,
    /********************/
    /* Adresse locale */
    adresse_loc text,
    ville_loc text,
    code_postal_loc varchar(15),
    code_pays_loc varchar(3),
    /********************/
    ville_naissance text NOT NULL,
    num_dep_naissance varchar(3),
    code_pays_naissance varchar(3) NOT NULL,
    code_nationalite varchar(3) NOT NULL,
    code_nationalite2 varchar(3),
    /*******************/
    /* contact d'urgence */
    nom_contact_urgence text,
    prenom_contact_urgence text,
    tel_contact_urgence varchar(20),
    /*******************/
    /* Autorisation pour la photo */
    autorisation_diff_ext boolean DEFAULT false,
    autorisation_diff_int boolean DEFAULT false,
    /* Données pour les enseignants chercheurs et les chercheurs */
    /* Ce champ contient l'immatriculation et la puissance fiscale de la voiture*/
    observation text,
    date_hdr date,
    date_pedr date,
    tel_professionnel text,
    id_corps_grade integer,
    id_section_principale integer,
    code_type_section varchar(20),
    id_ecole_doctorale_ec integer,
    id_discipline integer,
    /*******************/
    /*******************/
    /* Données pour les doctorants */
    sujet_these text,
    id_ecole_doctorale_doc integer,
    etab_dernier_diplome_doc text,
    dernier_diplome_obtenu_doc text,
    /*******************/
    /*******************/
    /* Données pour les autres cas */
    etab_dernier_diplome text,
    dernier_diplome_obtenu text,
    /*******************/
    /*******************/
    created_at timestamp DEFAULT current_timestamp NOT NULL,
    updated_at timestamp DEFAULT current_timestamp NOT NULL,
    CONSTRAINT pk_initial_data PRIMARY KEY (id_arrivant),
    CONSTRAINT uq_mail_usage UNIQUE (mail_personnel),
    CONSTRAINT fk_initial_data_ref_pays FOREIGN KEY (code_pays_naissance) REFERENCES silose.ref_pays (code_iso_pays),
    CONSTRAINT fk_initial_data_ref_nationalite FOREIGN KEY (code_nationalite) REFERENCES silose.ref_pays (code_iso_pays),
    CONSTRAINT fk_initial_data_ref_nationalite2 FOREIGN KEY (code_nationalite2) REFERENCES silose.ref_pays (code_iso_pays)
);
/********************/
/*** Some data ***/
/********************/
SET client_encoding = 'UTF8';
SET search_path = n_arrivants,
    pg_catalog;
/* Delete all records from initial_data table */
TRUNCATE arrivants;
/********************/
INSERT INTO arrivants (
        mail_personnel,
        genre,
        nom_patronyme,
        nom_usage,
        prenom,
        prenom2,
        prenom3,
        date_de_naissance,
        tel_personnel,
        adresse_perm,
        ville_perm,
        code_postal_perm,
        code_pays_perm,
        adresse_loc,
        ville_loc,
        code_postal_loc,
        code_pays_loc,
        ville_naissance,
        num_dep_naissance,
        code_pays_naissance,
        code_nationalite,
        code_nationalite2,
        nom_contact_urgence,
        prenom_contact_urgence,
        tel_contact_urgence,
        autorisation_diff_ext,
        autorisation_diff_int,
        observation,
        date_hdr,
        date_pedr,
        tel_professionnel,
        id_corps_grade,
        id_section_principale,
        code_type_section,
        id_ecole_doctorale_ec,
        id_discipline,
        sujet_these,
        id_ecole_doctorale_doc,
        etab_dernier_diplome_doc,
        dernier_diplome_obtenu_doc,
        etab_dernier_diplome,
        dernier_diplome_obtenu
    )
VALUES
    /*Chercheur*/
    (
        'alain@gmail.com',
        'Mr.',
        'Jhone',
        'Smith',
        'alain',
        NULL,
        NULL,
        '1980-10-23',
        '6311223344',
        '15 Rue marchal foche',
        'Baco',
        NULL,
        'Ml',
        '15 Av victore Hugo',
        'Grenoble',
        '38000',
        'FR',
        'Paris',
        75,
        'FR',
        'FR',
        NULL,
        'Le grand',
        'Marine',
        '476123456',
        true,
        true,
        '23CHR38, 5 CV',
        '2000-01-13',
        '2010-08-28',
        NULL,
        1,
        61,
        'CNU',
        NULL,
        5,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL
    ),
    /*AUTRES*/
    (
        'maud@gmail.com',
        'Mme',
        'Smith',
        'Le grand',
        'maude',
        NULL,
        NULL,
        '1980-10-23',
        '6311223344',
        '15 Rue marchal foche',
        'Berlin',
        NULL,
        'GR',
        'Leipziger Straße 3-4',
        'Berlin',
        '10117',
        'GR',
        'Valence',
        26,
        'GR',
        'GR',
        NULL,
        'Martin',
        'Georges',
        '0476123454',
        false,
        true,
        '23CHR38, 5 CV',
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        'CNU',
        NULL,
        5,
        NULL,
        NULL,
        NULL,
        NULL,
        'GI Grenoble INP',
        'Master2 Génie industriel'
    ),
    /*PHD*/
    (
        'marine@gmail.com',
        'Mme',
        'Dupond',
        'Dupond',
        'marine',
        NULL,
        NULL,
        '1995-02-17',
        '0634122984',
        '15 Rue marchal foche',
        'Lyon',
        NULL,
        'FR',
        '9 Rue foche',
        'La tronche',
        '38700',
        'FR',
        'Lyon',
        69,
        'FR',
        'FR',
        NULL,
        'Nattaf',
        'Laure',
        '0476234561',
        false,
        true,
        '23CHR38, 5 CV',
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        'Interaction homme machine',
        17,
        'Université Claude bernanrd - Lyon1',
        'Master2 Automatique',
        NULL,
        NULL
    );