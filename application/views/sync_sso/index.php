<div class="panel panel-default" style="padding-top: 20px; margin-top: 20px">
    <div class="panel-heading">
        <h3 class="panel-title">Sync SSO</h3>
    </div>
    <div class="panel-body">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>
        <?php if ($sso_data->success == false): ?>
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p>
                    Silahkan sync menggunakan akun SSO yang terdaftar
                </p>
            </div>
            <form action="<?= base_url('SyncSso/sync_sso'); ?>" method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-sync"></i> Sync</button>
                </div>
            </form>
        <?php else: ?>
            <div class="mb-2 text-center">
                <img src="https://cdni.iconscout.com/illustration/premium/thumb/check-list-illustration-download-in-svg-png-gif-file-formats--business-task-daily-work-management-pack-people-illustrations-4452998.png?f=webp" alt="" srcset="" width="200">
                <div class="mt-2">
                    <h4>Sync Akun SSO Chaakra Sudah Terkait</h4>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
load_js(array(
    "assets/js/flot/jquery.flot.min.js",
    "assets/js/flot/jquery.flot.pie.min.js",
    "assets/js/flot/jquery.flot.resize.min.js",
    "assets/js/flot/curvedLines.js",
    "assets/js/flot/jquery.flot.tooltip.min.js",
    "assets/js/chart.js",
    "assets/js/gauge.js",
));
?>
<script>

</script>