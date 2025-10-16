<div id="page-content" class="p20 clearfix">

    <div class="panel panel-default">

        <div class="page-title clearfix">

            <h1>Master ATK</h1>

            <div class="title-button-group">

                <?php echo modal_anchor(get_uri("master/consumables/modal_form"), "<i class='fa fa-plus-circle'></i> " . "Add consumables", array("class" => "btn btn-primary", "title" => "Add consumables")); ?>

            </div>

        </div>

        <div class="table-responsive">

            <table id="master_consumables-table" class="display" cellspacing="0" width="100%">            

            </table>

        </div>

    </div>

</div>



<script type="text/javascript">

    $(document).ready(function () {

        



        $("#master_consumables-table").appTable({

            source: '<?php echo_uri("master/consumables/list_data") ?>',

            columns: [

                // {title: "No Npwp", "class": "text-center text-bold"},

                {title: "Nama"},

                {title: "Satuan"},

                {title: "Deskripsi"},

                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w150"}

            ],
            xlsColumns: [0, 1, 2, 3]

        });

    });

</script>