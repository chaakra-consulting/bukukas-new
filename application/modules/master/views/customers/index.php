<div id="page-content" class="p20 clearfix">

    <div class="panel panel-default">

        <div class="page-title clearfix">

            <h1>Master Customers</h1>

            <div class="title-button-group">

                <?php echo modal_anchor(get_uri("master/customers/modal_form"), "<i class='fa fa-plus-circle'></i> " . "Add Customers", array("class" => "btn btn-primary", "title" => "Add Customers")); ?>

            </div>

        </div>

        <div class="table-responsive">

            <table id="master_customers-table" class="display" cellspacing="0" width="100%">            

            </table>

        </div>

    </div>

</div>



<script type="text/javascript">

    $(document).ready(function () {

        



        $("#master_customers-table").appTable({

            source: '<?php echo_uri("master/customers/list_data") ?>',

            columns: [

                // {title: "No Npwp", "class": "text-center text-bold"},

                {title: "Nama"},

                {title: "Kode", "class": "text-center"},

                {title: "Jenis"},

                {title: "Alamat"},

                {title: "Nama PJ", "class": "text-center"},

                {title: "No Telepon", "class": "text-center"},

                {title: "Catatan", "class": "text-center"},


                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w150"}

            ],
            xlsColumns: [0, 1, 2, 3, 4, 5,6]

        });

    });

</script>