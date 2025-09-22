<div id="page-content" class="clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1>Pengeluaran Perusahaan</h1>
            <div class="title-button-group">
                <div class="btn-group" role="group">
                </div>
                <?php
                    // echo modal_anchor(get_uri("purchase/p_invoices/modal_form"), "<i class='fa fa-plus-circle'></i> " . "Tambah Pengeluaran", array("class" => "btn btn-primary", "title" => "Tambah Pengeluaran"));
                
                ?>
            </div>
        </div>
          <div id="invoice-status-bar">
            <div class="panel panel-default  p5 no-border m0">
            
            <span class="ml15">
                <form action="" method="GET" role="form" class="general-form">
               <table class="table table-bordered">
               <tr>
                <td><label>Tahun</label></td>
                <td>
                    <?php 
                    $startYear = 2025;
                    $currentYear = date('Y');
                    $selectedYear = isset($year) ? $year : $currentYear;
                    ?>
                    <select name="year" id="year" class="form-control">
                        <?php 
                        for ($y = $startYear; $y <= $currentYear; $y++) {
                            $selected = ($y == $selectedYear) ? 'selected' : '';
                            echo "<option value=\"$y\" $selected>$y</option>";
                        }
                        ?>
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
// $(document).ready(function () {

//     setDatePicker("#start");
//    setDatePicker("#end");

// });
</script>
<script type="text/javascript">
    $(document).ready(function () {

        $("#invoices-table").appTable({
            source: '<?php echo_uri("purchase/p_invoices/list_data_gaji/$year") ?>',
            order: [[0, "desc"]], // Urutkan berdasarkan kolom tanggal (Tgl) secara descending
            columns: [
                {title: "Tgl", "class": "text-center"},
                {title: "Bulan", "class": "text-center"},
                {title: "Tahun", "class": "text-center"},
                {title: "Keterangan", "class": "text-center"},
                {title: "Total", "class": "text-center"},
                // {title: "Status Pembelian", "class": "text-center"},
                // {title: "Status Pembayaran", "class": "text-center"},
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