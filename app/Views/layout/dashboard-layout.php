<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= (isset($pageTitle)) ? $pageTitle : 'Document'; ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('new_arrivals.png') ?>" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url(); ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/dist/css/style.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Accueil</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <span class="brand-text font-weight-bold">
                    Nouveaux arrivants
                </span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
                    <div class="image mr-2">
                        <i class="fas fa-user white-icon"></i>
                    </div>
                    <div class="user-info">
                        <span style="color: white;">
                            <?= ucfirst(session()->get('logged_user')) ?>
                        </span>
                    </div>
                </div>


                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" id="admin_side_nav">
                        <?php if (session()->get('role') === 't') : ?>
                            <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                            <li class="nav-item menu-open">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Gérer les comptes
                                        <i class="right fas fa-users-cog"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview ml-2">
                                    <li class="nav-item">
                                        <a href="<?= base_url('comptes/createOrUpdateCompte'); ?>" class="nav-link <?= (current_url() == base_url('comptes/createOrUpdateCompte')) ? 'active' : ''; ?>" title="Ajouter un nouvel arrivant pour qu'il puisse se connecter et renseigner ces données">
                                            <i class="fa fa-plus nav-icon"></i>
                                            <p>Nouveau compte</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= route_to('comptes'); ?>" class="nav-link <?= (current_url() == base_url('comptes')) ? 'active' : ''; ?>">
                                            <i class="far fa-eye nav-icon"></i>
                                            <p>Affichier les comptes</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if (session()->get('role') === 't') : ?>
                            <li class="nav-item">
                                <a href="<?= route_to('users'); ?>" class="nav-link <?= (current_url() == base_url('users')) ? 'active' : ''; ?>" title="afficher la liste des nouveaux utilisateurs en attente de validation">
                                    <i class="fa fa-users nav-icon"></i>
                                    <p>List nouveaux arrivants</p>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">
                                <?= (isset($pageTitle)) ? $pageTitle : 'Document'; ?>
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= route_to('dashboard/'); ?>">Accueil</a></li>
                                <li class="breadcrumb-item active">
                                    <?= (isset($pageTitle)) ? $pageTitle : 'Document'; ?>
                                </li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <?= $this->renderSection('content'); ?>
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Administration</h5>
                <p> <a href="<?= site_url('auth/logout'); ?>">
                        <i class="fas fa-sign-out-alt"></i>
                        Déconnexion
                    </a>
                </p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                <img src="images/logo_gscop.JPG" alt="G-SCOP Logo" style="opacity: .8; width: 100px; height: 35px;">
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; <?= date('Y'); ?> <a href="<?= base_url(); ?>"></a>G-SCOP</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="<?= base_url(); ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url(); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- JQuery datatable -->
    <script src="<?= base_url(); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
    <!-- Bootstrap 4 datatables -->
    <script src="<?= base_url(); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url(); ?>/dist/js/adminlte.min.js"></script>
    <!-- ********** -->
    <!-- Mon script -->
    <script src="<?= base_url(); ?>/dist/js/script.js"></script>
    <!-- ********** -->
</body>

</html>