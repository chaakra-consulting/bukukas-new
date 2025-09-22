<div id="page-content" class="clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1>Kode Kas</h1>
            <div class="title-button-group">
                <div class="btn-group" role="group">
                </div>
                <?php
                //if ($this->login_user->is_admin) {
                    // echo modal_anchor(get_uri("team_members/invitation_modal"), "<i class='fa fa-envelope-o'></i> " . lang('send_invitation'), array("class" => "btn btn-default", "title" => lang('send_invitation')));
                    echo modal_anchor(get_uri("master/kode_kas/modal_form"), "<i class='fa fa-plus-circle'></i> " . ('Tambah Kas'), array("class" => "btn btn-primary", "title" => lang('add_kas')));
                //}
                ?>
            </div>
        </div>
        <div class="table-responsive">
            <table id="kode-table" class="display" cellspacing="0" width="100%">            
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        $("#kode-table").appTable({
            source: '<?php echo_uri("master/kode_kas/list_data/") ?>',
            // order: [[1, "asc"]],
            columns: [
                {title: "CODE", "class": "text-center"},
                {title: "NAMA", "class": "text-center"},
                {title: "AREA/KET", "class": "text-center"},         
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w200"},
            ],
        
            xlsxColumns: [0, 1, 2, 3, 4, 6, 5, 6, 7, 8]

        });
    });
</script>    
