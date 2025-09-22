<div id="page-content" class="p20 clearfix">

    <div class="panel panel-default">

        <div class="page-title clearfix">

            <h1> Tracking BBM</h1>

            <div class="title-button-group">

            </div>

        </div>

        <div class="table-responsive">

            <table id="item-table" class="display" cellspacing="0" width="100%">            

            </table>

        </div>

    </div>

</div>



<script type="text/javascript">

    $(document).ready(function () {



        $("#item-table").appTable({

            source: '<?php echo_uri("tracking/T_solar/list_data") ?>',

            order: [[0, 'desc']],

            columns: [

                {title: 'CODE'},

                {title: 'Nama BBM'},

                {title: 'Deskripsi'},

                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w100"}

            ],

            printColumns: [0, 1, 2],

            xlsColumns: [0, 1, 2]

        });

    });





</script>