<div id="page-content" class="clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1>Laporan Pengeluaran</h1>
            <div class="title-button-group">
                <div class="btn-group" role="group">
                </div>
                <?php
                //if ($this->login_user->is_admin) {
                    // echo modal_anchor(get_uri("team_members/invitation_modal"), "<i class='fa fa-envelope-o'></i> " . lang('send_invitation'), array("class" => "btn btn-default", "title" => lang('send_invitation')));
                    echo modal_anchor(get_uri("master/aruskas/modal_form"), "<i class='fa fa-plus-circle'></i> " . 'Tambah Kas', array("class" => "btn btn-primary", "title" => 'Tambah Kas'));
                //}
                ?>
            </div>
        </div>
        <div class="table-responsive">
            <table id="aruskas-table" class="display" cellspacing="0" width="100%">            
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        $("#aruskas-table").appTable({
            source: '<?php echo_uri("master/aruskas/list_data/") ?>',
            // order: [[1, "asc"]],
            columns: [
                {title: "TGL", "class": "text-center"},
                {title: "REF", "class": "text-center"},
                {title: "KODE AKUN","class": "text-center"},
                {title: "NAMA AKUN", "class": "text-center"},
                {title: "NO AREA", "class": "text-center"},
                {title: "URAIAN", "class": "text-center"},
                {title: "DEBIT", "class": "text-center"},
                {title: "KREDIT", "class": "text-center"},
                {title: "KETERANGAN", "class": "text-center"},

                // {title: "Credit Limit"},
            
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w200"},
            ],
        
            xlsxColumns: [0, 1, 2, 3, 4, 6, 5, 6, 7, 8]

        });
    });
</script>    
