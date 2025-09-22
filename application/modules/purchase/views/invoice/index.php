<div id="page-content" class="clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1>Pengeluaran Perusahaan</h1>
            <div class="title-button-group">
                <div class="btn-group" role="group">
                </div>
                <?php
                    echo modal_anchor(get_uri("purchase/p_invoices/modal_form"), "<i class='fa fa-plus-circle'></i> " . "Tambah Pengeluaran", array("class" => "btn btn-primary", "title" => "Tambah Pengeluaran"));
                
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
            
                    <select class="form-control" name="account_number" id="account_number">
                        <option value="">Nomor Akun</option>
                        <option value="501 - Operasional">501 - Operasional</option>
                        <option value="502 - Transport">502 - Transport</option>
                        <option value="503 - Perlengapan Kantor">503 - Perlengapan Kantor</option>
                        <option value="504 - Konsumsi">504 - Konsumsi</option>
                        <option value="505 - Pos dan Materai">505 - Pos dan Materai</option>
                        <option value="506 - Gaji">506 - Gaji</option>
                        <option value="507 - Beban Pajak">507 - Beban Pajak</option>
                        <option value="508 - Pulsa Handphone">508 - Pulsa Handphone</option>
                        <option value="509 - Listrik & Air">509 - Listrik & Air</option>
                        <option value="510 - Internet">510 - Internet</option>
                        <option value="511 - Maintenance Inventaris">511 - Maintenance Inventaris</option>
                        <option value="512 - Beban Kirim">511 - Beban Kirim</option>
                        <option value="513 - Promosi">513 - Promosi</option>
                    </select>
                    </td>
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
            <table id="invoices-table" class="display" cellspacing="0" width="100%" style="font-size:12px">            
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

        $("#invoices-table").appTable({
            source: '<?php echo_uri("purchase/p_invoices/list_data/$start_date/$end_date/$account_number") ?>',
            order: [[0, "desc"]], // Urutkan berdasarkan kolom tanggal (Tgl) secara descending
            columns: [
                {title: "Tgl", "class": "text-center"},
                {title: "Keterangan", "class": "text-center"},
                {title: "Nomor Bukti", "class": "text-center"},
                {title: "Nomor Akun", "class": "text-center"},
                {title: "Total", "class": "text-center"},
                {title: "Status Pembelian", "class": "text-center"},
                {title: "Status Pembayaran", "class": "text-center"},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w150"}
            ],
            xlsColumns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
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