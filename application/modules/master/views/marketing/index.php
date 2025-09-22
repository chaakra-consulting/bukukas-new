<div id="page-content" class="p20 clearfix">

    <div class="panel panel-default">

        <div class="page-title clearfix">

            <h1>Master Marketing</h1>

            <div class="title-button-group">

                <?php echo modal_anchor(get_uri("master/marketing/modal_form"), "<i class='fa fa-plus-circle'></i> " . "Add Marketing", array("class" => "btn btn-primary", "title" => "Add Marketing")); ?>

            </div>

        </div>

        <div class="table-responsive">

            <table id="master_marketing-table" class="display" cellspacing="0" width="100%">            

            </table>

        </div>

    </div>

</div>



<script type="text/javascript">

    $(document).ready(function () {

        



        $("#master_marketing-table").appTable({

            source: '<?php echo_uri("master/marketing/list_data") ?>',

            columns: [


                {title: "Nama"},

                {title: "Email", "class": "text-center"},

                {title: "No Telepon", "class": "text-center"},

                      {title: '<i class="fa fa-bars"></i>', "class": "text-center option w150"}

            ],
            xlsColumns: [0, 1, 2, 3, 4, 5,6]

        });

    });

</script>