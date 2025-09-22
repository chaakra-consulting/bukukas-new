<div id="page-content" class="clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1>Request Pembelian ke Holding</h1>
            <div class="title-button-group">
                <div class="btn-group" role="group">
                </div>
                <?php
                    echo modal_anchor(get_uri("purchase/request_holding/modal_form"), "<i class='fa fa-plus-circle'></i> " . "Add Request Holding", array("class" => "btn btn-primary", "title" => "Add Request Holding"));
                
                ?>
            </div>
        </div>
        <div class="table-responsive">
            <table id="request_holding-table" class="display" cellspacing="0" width="100%">            
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        $("#request_holding-table").appTable({
            source: '<?php echo_uri("purchase/request_holding/list_data") ?>',
            // order: [[1, "asc"]],
            columns: [
                {title: "REQUEST HOLDING CODE"},
                {title: "TGL PENGAJUAN"},
                {title: "STATUS"},
                {title: "MATERIAL"},
                {title: "DESKRIPSI"},
                {title: "KUANTITAS"},
                {title: "MEMO"},
                 {title: '<i class="fa fa-bars"></i>', "class": "text-center option w150"}
            ],
            printColumns: [0, 1, 2, 3, 4, 5, 6],
            xlsColumns: [0, 1, 2, 3, 4, 5, 6]

        });
    });
</script>    
