<div id="page-content" class="p20 clearfix">

    <div class="panel panel-default">

        <div class="page-title clearfix">

            <h1> Master <?=ucfirst($menu);?></h1>

            <div class="title-button-group">
				
				<?php 
					if($menu=="oli"){
						echo modal_anchor(get_uri("master/sparepart/modal_form_page/oli"), "<i class='fa fa-plus-circle'></i>  Tambah Oli", array("class" => "btn btn-primary", "title" => "Tambah Oli"));
					}elseif($menu=="solar"){
						echo modal_anchor(get_uri("master/sparepart/modal_form_page/solar"), "<i class='fa fa-plus-circle'></i> Tambah Solar", array("class" => "btn btn-primary", "title" => "Tambah Solar"));
					}else{
						echo modal_anchor(get_uri("master/sparepart/modal_form_page/sparepart"), "<i class='fa fa-plus-circle'></i> " . lang('add_sparepart'), array("class" => "btn btn-primary", "title" => lang('add_sparepart')));
					}
				
				?>
                <?php //echo modal_anchor(get_uri("master/sparepart/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_sparepart'), array("class" => "btn btn-primary", "title" => lang('add_sparepart'))); ?>

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

            source: '<?php echo_uri("master/sparepart/list_data_page/".$menu) ?>',

            order: [[0, 'desc']],

            columns: [

                {title: 'CODE'},

                {title: 'Nama <?=ucfirst($menu);?>'},

                {title: 'Deskripsi'},

                {title: 'Kuantitas Pembelian'},

                {title: 'Harga'},

                {title: 'Kuantitas Pengeluaran'},

                {title: 'Sisa <?=ucfirst($menu);?>'},

                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w100"}

            ],

            printColumns: [0, 1, 2, 3, 4, 5, 6],

            xlsColumns: [0, 1, 2, 3, 4, 5, 6]

        });

    });





</script>