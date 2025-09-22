<div id="page-content" class="p20 clearfix">

    <div class="panel panel-default">

        <div class="page-title clearfix">

            <h1> Master Products</h1>

            <div class="title-button-group">
  
                <?php echo modal_anchor(get_uri("master/items/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_product'), array("class" => "btn btn-primary", "title" => lang('add_product'))); ?>

            </div>

        </div>

        <div class="table-responsive">

            <table id="item-table" class="display" cellspacing="0" width="60%" >          
            
            </table>

        </div>

    </div>

</div>



<script type="text/javascript">

    $(document).ready(function () {



        $("#item-table").appTable({

            source: '<?php echo_uri("master/items/list_data") ?>',

            order: [[0, 'desc']],

            columns: [
                  
                //{title: 'Kode Barang'},
                //{title: 'Vendors'}, 
                {title: 'Nama Barang'},
                {title: 'foto'},       
                {title: 'Jumlah'},
                {title: 'Harga Beli'}, 
                //{title: 'Harga Jual'},
                //{title: 'Barcode'},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w200"}

            ],
            xlsColumns: [0, 1, 2, 3, 4,5,6,7,8,9]

        });

    });
</script>
<script type="text/javascript">
    // Popup window code
    function newPopup(url) {
      popupWindow = window.open(
        url,'popUpWindow','height=400,width=400,left=500,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
    }
    </script>