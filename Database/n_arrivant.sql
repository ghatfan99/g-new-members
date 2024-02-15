/* Création de schema */
drop schema if exists n_arrivants cascade;
/* Les types */
DROP TYPE IF EXISTS status cascade;
DROP TYPE IF EXISTS genre cascade;
DROP TYPE IF EXISTS sys_exp cascade;
DROP TYPE IF EXISTS config_mat cascade;
/*************************************/
CREATE SCHEMA IF NOT EXISTS n_arrivants;
/* Les genres */
CREATE TYPE genre AS enum ('Mme', 'Mr');
/* Les statuts */
CREATE TYPE status AS enum (
    'gestionrh',
    'phd',
    'ipostdoc',
    'autres',
    'chercheurEc'
);
/* Le systeme d'exploitation */
CREATE TYPE sys_exp AS enum ('windows', 'linux', 'macos');
/* ************************* */
/* Configuration materiel */
CREATE TYPE config_mat AS enum ('standard', 'intensive');
/* ************************* */
/* Création de la table utilisateurs
 * Les utilsateurs présents dans cette table peuvent se connecter pour créer un compte
 * et remplir leurs profiles
 * */
CREATE TABLE n_arrivants.users (
    id_user serial not null,
    nom varchar(255),
    prenom varchar(255),
    password text,
    email varchar(255) UNIQUE,
    date_debut Date,
    date_fin Date,
    na_status status default null,
    actif boolean DEFAULT true,
    role boolean DEFAULT false,
    token varchar(255) default null,
    verified boolean default false,
    created_at timestamp DEFAULT current_timestamp,
    CONSTRAINT pk_users_id_user PRIMARY KEY (id_user)
);
/**
 * La table pour le service informatique
 */
CREATE TABLE n_arrivants.srv_info (
    id_srv_info SERIAL not null,
    system_exp sys_exp default null,
    config_materiel config_mat default null,
    logiciels_spec VARCHAR(300) default null,
    explication text default null,
    additional_informations text default null,
    created_at TIMESTAMP DEFAULT current_timestamp,
    id_user INT unique,
    CONSTRAINT pk_srv_info_id_srv_inf PRIMARY KEY (id_srv_info),
    CONSTRAINT fk_srv_info_id_user FOREIGN KEY (id_user) REFERENCES n_arrivants.users(id_user) on delete CASCADE
);
/**
 * La table all users contient les informations qui concernet tout le monde
 * (nom, prenom, genre, adresse, ....)
 */
CREATE TABLE n_arrivants.all_users (
    all_users_id SERIAL not null,
    user_genre genre,
    nom varchar(255),
    prenom varchar(255),
    nom_patronomique VARCHAR(300),
    date_naiss Date,
    ville_naiss VARCHAR(300),
    num_departement VARCHAR(3),
    pays_naiss VARCHAR(3),
    nationalite VARCHAR(3),
    /* adresse*/
    adresse VARCHAR(300),
    ville_cp VARCHAR(300),
    pays VARCHAR(10),
    /************************/
    tel_mobile VARCHAR(300),
    auth_photo_int boolean default null,
    auth_photo_ext boolean default null,
    created_at TIMESTAMP DEFAULT current_timestamp,
    id_user INT unique,
    CONSTRAINT pk_all_users_all_users_id PRIMARY KEY (all_users_id),
    CONSTRAINT fk_all_users_id_user FOREIGN KEY (id_user) REFERENCES n_arrivants.users(id_user) on delete CASCADE
);
/************************************************************/
/**
 * La table Doctorants / PHD contient les informations qui concernet les 
 * doctorants seuelemnt
 */
CREATE TABLE n_arrivants.phd_users (
    phd_id_user SERIAL not null,
    id_ecole_doctorale int,
    titre_these TEXT,
    phd_der_diplome VARCHAR(300),
    phd_etab_der_diplome VARCHAR(300),
    created_at TIMESTAMP DEFAULT current_timestamp,
    id_user INT unique,
    CONSTRAINT pk_phd_users_phd_id_user PRIMARY KEY (phd_id_user),
    CONSTRAINT fk_phd_users_id_user FOREIGN KEY (id_user) REFERENCES n_arrivants.users(id_user) on delete CASCADE
);
/************************************************************/
/**
 * La table Chercheur ou Enseignant chercheur contient les informations qui concernet les 
 * chercheurs et les enseignant chercheurs
 */
CREATE TABLE n_arrivants.ch_ec_users (
    ch_ec_id_user SERIAL not null,
    id_corps_grade int,
    code_type_section varchar(15),
    id_section int,
    id_ecole_doctorale int,
    id_discipline int,
    ec_date_hdr Date,
    ec_imm_pui_fis varchar(255),
    created_at timestamp DEFAULT current_timestamp,
    id_user INT unique,
    CONSTRAINT pk_ch_ec_users_ch_ec_id_user PRIMARY KEY (ch_ec_id_user),
    CONSTRAINT fk_ch_ec_users_id_user FOREIGN KEY (id_user) REFERENCES n_arrivants.users(id_user) on delete CASCADE
);
/************************************************************/
/**
 * La table Ingénieur, PostDoc cette table contient les informations qui concernet les 
 * ingénieurs et les postdoc
 */
CREATE TABLE n_arrivants.ipostdoc_users (
    ipostdoc_id_user SERIAL not null,
    i_postdoc_der_diplome varchar(300),
    i_postdoc_etab_der_diplome varchar(300),
    created_at timestamp DEFAULT current_timestamp,
    id_user INT unique,
    CONSTRAINT pk_ipostdoc_users_ipostdoc_id_user PRIMARY KEY (ipostdoc_id_user),
    CONSTRAINT fk_ipostdoc_users_id_user FOREIGN KEY (id_user) REFERENCES n_arrivants.users(id_user) on delete CASCADE
);
/************************************************************/
/**
 * La table Autre (stagiaire, visiteur, invité, ...) contient les informations qui concernet
 * tous les status qui ne sont pas inclus dans les autres cas
 */
CREATE TABLE n_arrivants.autres_users (
    autres_id_user SERIAL not null,
    autres_der_diplome varchar(300),
    autres_etab_der_diplome varchar(300),
    created_at timestamp DEFAULT current_timestamp,
    id_user INT unique,
    CONSTRAINT pk_autres_users_autres_id_user PRIMARY KEY (autres_id_user),
    CONSTRAINT fk_autres_users_id_user FOREIGN KEY (id_user) REFERENCES n_arrivants.users(id_user) on delete CASCADE
);
/************************************************************/
/*** insert users test data ***/
INSERT INTO n_arrivants.users (
        id_user,
        nom,
        prenom,
        password,
        email,
        date_debut,
        date_fin,
        na_status,
        role,
        token,
        verified
    )
VALUES (
        1,
        'Marchal',
        'Aline',
        NULL,
        'aline@test.com',
        '2022-12-01',
        '2023-12-31',
        'phd',
        false,
        '6e205a6ec92b798da533745298d81493c887b4fd8da236c2c7af603dadf67085',
        false
    ),
    (
        2,
        'Merkel',
        'Angela',
        NULL,
        'angela@test.com',
        '2022-10-01',
        '2023-09-15',
        'ipostdoc',
        false,
        '0f3c58768a2fac6591ada74defadb83564d80b7ca256a471b3bb166937ed8aaa',
        false
    ),
    (
        3,
        'Le grand',
        'Vincent',
        NULL,
        'vincent@test.com',
        '2021-12-01',
        '2024-12-31',
        'chercheurEc',
        false,
        'e326c5e9b5d2c5ad1a154612ec70da5ab004e568ea9c8c7c5187e17091685eaf',
        false
    ),
    (
        4,
        'Dupond',
        'Marine',
        NULL,
        'marine@test.com',
        '2024-06-17',
        '2024-12-31',
        'phd',
        false,
        'd3d1ed8e8b037369f234ae61868ecd0b16038fdeea15e14b1b61a9b790c14d24',
        false
    ),
    (
        5,
        'Smith',
        'Jhone',
        NULL,
        'jhone@test.com',
        '2024-02-01',
        '2024-10-30',
        'autres',
        false,
        '3c8567fa7aa3022cdb293777f3cb3f7036bafc5c75ea1b938cac3db786308119',
        false
    ),
    (
        100,
        'admin',
        'admin',
        '$2y$10$8/MpDY./clpuV3L4wbDOwetieq0OU56u7DJ.oEVp7AA3oh7HFPvxK',
        'admin@test.com',
        null,
        null,
        'gestionrh',
        true,
        null,
        true
    );
SELECT setval('n_arrivants.users_id_user_seq', 6);
/********************/
insert into n_arrivants.all_users (
        user_genre,
        nom,
        prenom,
        nom_patronomique,
        date_naiss,
        ville_naiss,
        num_departement,
        pays_naiss,
        nationalite,
        adresse,
        ville_cp,
        pays,
        tel_mobile,
        auth_photo_int,
        auth_photo_ext,
        id_user
    )
values (
        'Mme',
        'Marchal',
        'Aline',
        'Escobar',
        '2000-12-23',
        'Paris',
        '75',
        'CH',
        'CH',
        '14 Rue Larroche',
        'Valence 26000',
        'France',
        '0789535241',
        true,
        false,
        2
    ),
    (
        'Mme',
        'Merkel',
        'Angela',
        'Dupond',
        '1998-10-19',
        'Rome',
        '38',
        'FR',
        'FR',
        '14 Rue Félix Viallet',
        'Paris 75000',
        'France',
        '0636378451',
        true,
        false,
        3
    ),
    (
        'Mr',
        'Le grand',
        'Vincent',
        'Marteniez',
        '2001-09-15',
        'Londre',
        '26',
        'DE',
        'DE',
        '14 Av Alsace lorraine',
        'Annecy 74000',
        'France',
        '+337858585',
        true,
        true,
        4
    ),
    (
        'Mr',
        'Smith',
        'Jhone',
        'Marteniez',
        '2001-09-15',
        'Londre',
        '26',
        'FR',
        'FR',
        '10 Rue Foche',
        'Lyon 96000',
        'France',
        '+3362457896',
        true,
        true,
        5
    ),
    (
        'Mr',
        'Smith',
        'Jhone',
        'Laravel',
        '2003-07-28',
        'Bogota',
        '99',
        'GR',
        'GR',
        '14 Rue lafayatte',
        'Grenoble 38000',
        'France',
        '063635241',
        true,
        false,
        1
    );
/********************/
/*** insert phd, autres, chercheurs, ipostdoc test data ***/
/*phd*/
insert into n_arrivants.phd_users (
        id_ecole_doctorale,
        titre_these,
        phd_der_diplome,
        phd_etab_der_diplome,
        id_user
    )
values (
        2,
        'Modèles linéaires dans l\espace',
        'M2 Génie industriel',
        'GINP',
        1
    ),
    (
        2,
        'GROG Modélisation',
        'M2 MOIS',
        'ENSA Lyon',
        4
    );
/*postdoc*/
insert into n_arrivants.ipostdoc_users (
        i_postdoc_der_diplome,
        i_postdoc_etab_der_diplome,
        id_user
    )
values(
        'M2 statistique appliquée BigData',
        'Paris Saclay',
        2
    );
/*Chercheurs EC*/
INSERT INTO n_arrivants.ch_ec_users (
        ch_ec_id_user,
        id_corps_grade,
        code_type_section,
        id_section,
        id_ecole_doctorale,
        id_discipline,
        ec_date_hdr,
        ec_imm_pui_fis,
        created_at,
        id_user
    )
VALUES(
        nextval(
            'n_arrivants.ch_ec_users_ch_ec_id_user_seq'::regclass
        ),
        1,
        'CNRS',
        3,
        3,
        6,
        '2022-12-27',
        'PHWQA34',
        CURRENT_TIMESTAMP,
        3
    );
/*autres*/
INSERT INTO n_arrivants.autres_users (
        autres_der_diplome,
        autres_etab_der_diplome,
        id_user
    )
VALUES('Phd MIT', 'MIT USA', 5);
/********************/
/*** insert service inforamtique test data ***/
insert into n_arrivants.srv_info (
        system_exp,
        config_materiel,
        logiciels_spec,
        explication,
        additional_informations,
        id_user
    )
VALUES (
        'windows',
        'standard',
        'Matlab, Maple, Latex',
        '',
        '',
        1
    ),
    ('linux', 'standard', 'Python Jupiter', '', '', 2),
    (
        null,
        null,
        null,
        'I dont need a computer, it will be given by my company ...!',
        'I will be here for two days every week only',
        3
    ),
    (
        'macos',
        'intensive',
        'Matlab, Maple, Latex',
        '',
        '',
        4
    ),
    ('linux', 'standard', 'Microsoft 365', '', '', 5);
/********************/