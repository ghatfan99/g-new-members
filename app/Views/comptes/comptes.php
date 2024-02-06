<?= $this->extend('layout/dashboard-layout'); ?>
<?= $this->section('content'); ?>
<div class="row mx-auto my-auto" mt-3>
    <div class="col col-md-10 mx-auto">
        <h3>Tous les comptes</h3>
        <p class="lead alert alert-info">Seulement les personnes de cette list peuvent se connecter à l'application pour remplire leurs fiches.
        </p>
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
        <hr>
        <table id="comptes" class="table table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Statut</th>
                    <th>Email</th>
                    <th>Actif</th>
                    <th>Administrateur</th>
                    <th>Date de création</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($comptes) : ?>
                    <?php foreach ($comptes as $elt) : ?>
                        <tr>
                            <td><?php echo $elt['nom']; ?></td>
                            <td><?php echo $elt['prenom']; ?></td>
                            <td><?php echo $elt['na_status']; ?></td>
                            <td><?php echo $elt['email']; ?></td>
                            <td>
                                <?php echo $elt['actif'] === 't' ? '<span style="color: #568203; font-weight: bold;">Oui</span>' : '<span style="color: #dc3545; font-weight: bold;">Non</span>'; ?>
                            </td>
                            <td>
                                <?php echo $elt['role'] === 't' ? '<span style="color: #568203; font-weight: bold;">Oui</span>' : '<span style="color: #dc3545; font-weight: bold;">Non</span>'; ?>
                            </td>
                            <td><?php echo (new DateTime($elt['created_at']))->format('d/m/Y'); ?></td>
                            <td class="text-center">
                                <div class="row d-flex align-items-center justify-content-center">
                                    <a href="<?= base_url('comptes/edit_compte/' . $elt['id_user']) ?>" class="btn btn-primary btn-sm" title="mettre à jour les données de l'utilisateur">
                                        Mettre à jour
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <?php if ($elt['role'] !== 't') : ?>
                                        <a href="#" class="btn btn-danger btn-sm btn-delete ml-2" data-id="<?= $elt['id_user']; ?>" data-nom="<?= $elt['nom']; ?>" data-prenom="<?= $elt['prenom']; ?>" data-toggle="modal" data-target="#deleteCompteModal">
                                            Supprimer
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- The Modal -->
    <form action="<?= base_url('comptes/delete_compte'); ?>" method="POST">
        <div class="modal" id="deleteCompteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Supprimer le compte</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        Vous êtes sûr de vouloir supprimer le compte de <strong><span class="info"></span> </strong>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <input type="hidden" name="id_user" class="compteID">
                        <button type="submit" class="btn btn-primary btn-sm">
                            Confirmer
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                            Annuler
                        </button>
                    </div>
    </form>
</div>
</div>
</div>
</div>
<?= $this->endSection(); ?>