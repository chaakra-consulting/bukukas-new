<div id="page-content" class="m20 clearfix">
    <div class="panel panel-default">
        
        <div class="table-responsive" style="min-height: 500px">
            <table id="payments-table" class=" display dataTable no-footer" cellspacing="0" width="100%" >    
                       
            </table>
        </div>


    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        $("#payments-table").appTable({
            source: '<?php echo_uri("purchase/p_penerimaan/list_data") ?>',
            // order: [[1, "asc"]],
            columns: [
                {title: "VOUCHER CODE #"},
                {title: "VENDORS"},
                {title: "PEMBAYARAN","class": "text-center"},
                // {title: "KAS"},
                {title: "DATE"},
                {title: "CURRENCY","class": "text-center"},
                {title: "PAID", "class": "text-right"},
                {title: "KEKURANGAN", "class": "text-right"},
                {title: "TOTAL", "class": "text-right"},
                {title: "STATUS BARANG", "class": "text-center"},
                {title: "TGL BARANG DITERIMA", "class": "text-center"},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w80"}
            ],
            printColumns: [0, 1, 2, 3, 4,5,6,7,8],
            xlsColumns: [0, 1, 2, 3, 4,5,6,7,8]

        });

    });
</script>    
