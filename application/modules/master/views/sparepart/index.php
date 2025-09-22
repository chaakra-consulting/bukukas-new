<div id="page-content" class="p20 clearfix">

    <div class="panel panel-default">

        <div class="page-title clearfix">

            <h1> Master Perlengkapan</h1>

            <div class="title-button-group">

                <?php echo modal_anchor(get_uri("master/sparepart/modal_form"), "<i class='fa fa-plus-circle'></i> " . "Tambah Barang", array("class" => "btn btn-primary", "title" => "Tambah Barang")); ?>

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

            source: '<?php echo_uri("master/sparepart/list_data") ?>',

            order: [[0, 'desc']],

            columns: [

                {title: 'CODE'},

                {title: 'Nama Barang'},

                {title: 'Deskripsi'},

                {title: 'Kuantitas Pembelian'},

                {title: 'Harga'},

                {title: 'Kuantitas Pengeluaran'},

                {title: 'Sisa Barang'},

                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w100"}

            ],

            printColumns: [0, 1, 2, 3, 4, 5, 6],

            xlsColumns: [0, 1, 2, 3, 4, 5, 6]

        });

    });





</script>