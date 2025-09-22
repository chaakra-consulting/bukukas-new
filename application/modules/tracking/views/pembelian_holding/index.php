<div id="page-content" class="clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1>Tracking Pembelian</h1>
            <div class="title-button-group">
                <div class="btn-group" role="group">
                </div>
                
            </div>
        </div>
        <div class="table-responsive">
            <table id="request-table" class="display" cellspacing="0" width="100%">            
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        $("#request-table").appTable({
            source: '<?php echo_uri("tracking/t_pembelian_holding/list_data") ?>',
            // order: [[1, "asc"]],
            columns: [
                {title: "REQUEST HOLDING CODE"},
                {title: "TANGGAL PENGAJUAN"},
                {title: "MATERIAL"},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w150"}
            ],
            printColumns: [0, 1, 2],
            xlsColumns: [0, 1, 2]

        });
    });
</script>    
