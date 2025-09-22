<div id="page-content" class="m20 clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1>Pembayaran Pembelian</h1>
            <div class="title-button-group">
                <div class="btn-group" role="group">
                    <?php
                    echo modal_anchor(get_uri("purchase/p_payments/add_receipt"), "<i class='fa fa-plus-circle'></i> " . "Add Vendor Receipt", array("class" => "btn btn-primary", "title" => "Add Vendor Receipt"));
                
                ?>
                </div>
               
            </div>
        </div>
       

        

        
        <div class="table-responsive" style="min-height: 500px">
            <table id="payments-table" class=" display dataTable no-footer" cellspacing="0" width="100%" style="font-size:12px">    
                       
            </table>
        </div>


    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        $("#payments-table").appTable({
            source: '<?php echo_uri("purchase/p_payments/list_data") ?>',
            // order: [[1, "asc"]],
            columns: [
                {title: "Tgl", "class": "text-center"},
                {title: "No Pembayaran", "class": "text-center"},
                {title: "Perusahaan", "class": "text-center"},
                {title: "Customers", "class": "text-center"},
                {title: "Vendors", "class": "text-center"},
                {title: "Status","class": "text-center"},
                {title: "Uraian", "class": "text-center"},
                {title: "Mata Uang","class": "text-center"},
                {title: "Paid", "class": "text-center"},
                {title: "Kurang Bayar", "class": "text-center"},
                {title: "Total", "class": "text-center"},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w50"}
            ],
            xlsColumns: [0, 1, 2, 3, 4,5,6,7,8]

        });

    });
</script>    
