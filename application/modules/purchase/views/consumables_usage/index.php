<div id="page-content" class="clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1>Riwayat Penggunaan ATK</h1>
            <div class="title-button-group">
                <div class="btn-group" role="group">
                </div>
                <?php
                    echo modal_anchor(get_uri("purchase/p_invoices/modal_data_usage"), "<i class='fa fa-eye'></i> " . "Lihat Stok ATK", array("class" => "btn btn-warning", "title" => "Lihat Stok ATK"));          
                ?>
                <?php
                    echo modal_anchor(get_uri("purchase/p_invoices/modal_form_consumables_usage"), "<i class='fa fa-plus-circle'></i> " . "Tambah Penggunaan ATK", array("class" => "btn btn-primary", "title" => "Tambah Penggunaan ATK"));
                
                ?>
            </div>
        </div>
          <div id="invoice-status-bar">
            <div class="panel panel-default  p5 no-border m0">
            
                <span class="ml15">
                    <form action="" method="GET" role="form" class="general-form">
                        <input type="hidden" value="<?php echo sha1(date("Y-m-d H:i:s")) ?>" name="_token">
                    <table class="table table-bordered">
                        <tr>
                            <td><label>Start Date</label></td>
                            <td><input type="text" class="form-control" name="start" id="start" value="<?php echo $start_date ?>" autocomplete="off"></td>
                            <td><label>End Date</label></td>
                            <td><input type="text" class="form-control" name="end" id="end" value="<?php echo $end_date ?>" autocomplete="off"></td>
                            <td>
                                <button type="submit" name="search" class="btn btn-default" value="2"><i class=" fa fa-search"></i> Filter</button>
                            </td>
                        </tr>
                    </table>
                    </form>
                </span>

            </div>
        </div>
        <div class="table-responsive">
            <table id="consumables-table" class="display" cellspacing="0" width="100%" style="font-size:12px">            
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {

    setDatePicker("#start");
   setDatePicker("#end");

});
</script>
<script type="text/javascript">
    $(document).ready(function () {

        $("#consumables-table").appTable({
            source: '<?php echo_uri("purchase/p_invoices/list_data_consumable_usage/$start_date/$end_date") ?>',
            order: [[0, "desc"]], // Urutkan berdasarkan kolom tanggal (Tgl) secara descending
            columns: [
                {title: "Tanggal Penggunaan", "class": "text-center"},
                {title: "Pengguna", "class": "text-center"},
                {title: "Nama", "class": "text-center"},
                {title: "Jumlah", "class": "text-center"},
                {title: "Tujuan", "class": "text-center option w150"},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w150"}
            ],
            xlsColumns: [0, 1, 2, 3, 4, 5]
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