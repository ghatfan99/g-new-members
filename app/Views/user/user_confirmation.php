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

        <hr>
        <div class="jumbotron">
            <h2 class="text-center">
                Merci / <i>Thank you</i>
            </h2>
            <h3 class="text-center">
                <a href="<?= site_url('auth/logout'); ?>" class="btn btn-primary">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion / <i>Logout</i>
                </a>
            </h3>
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