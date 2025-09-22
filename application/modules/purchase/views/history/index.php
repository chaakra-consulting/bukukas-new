<div id="page-content" class="m20 clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1>History Pembelian</h1>
            <div class="title-button-group">

               
            </div>
        </div>
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
                        <button type="submit" name="search" class="btn btn-default" value="1"><i class=" fa fa-search"></i> Filter</button>
                           <a href="#" name="print"  class="btn btn-default" onclick="tableToExcel('history-table', 'Lap_Penjualan')"><i class=" fa fa-file-excel-o"></i> Excel</a> 
  
                      </td>
                                        </tr>                            
               </table>
               </form>
                </span>

            </div>

        

        
        <div class="table-responsive" style="min-height: 500px">
            <table id="history-table" class=" display dataTable no-footer" cellspacing="0" width="100%" style="font-size:12px">    
                       
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

        $("#history-table").appTable({
            source: '<?php echo_uri("purchase/p_history/list_data/$start_date/$end_date") ?>',
            // order: [[1, "asc"]],
            columns: [
                {title: "Tanggal", "class": "text-center"},
                {title: "No Pembayaran", "class": "text-center"},
                {title: "Perusahaan", "class": "text-center"},
                {title: "Customers", "class": "text-center"},
                {title: "Vendors", "class": "text-center"},
                {title: "Status","class": "text-center"},
                // {title: "KAS"},
                {title: "Mata Uang","class": "text-center"},
                {title: "Paid", "class": "text-center"},
                {title: "Kurang Bayar", "class": "text-center"},
                {title: "Total", "class": "text-center"},
            ],
            xlsColumns: [0, 1, 2, 3, 4,5,6,7,8]

        });

    });
</script>    
