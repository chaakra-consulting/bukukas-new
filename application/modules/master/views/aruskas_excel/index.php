<div id="page-content" class="clearfix">
    <div class="panel panel-default">
        <div id="kas-status-bar">
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
                            <button type="submit" name="search" class="btn btn-default" value="<?php echo $end_date ?>" autocomplete="off"><i class=" fa fa-search"></i> Filter</button>
                           <a href="" name="print" class="btn btn-default" onclick="tableToExcel('aruskas-table', 'Lap_Pengeluaran')"><i class=" fa fa-file-excel-o"></i> Excel</a> 
  
                      </td>
                                        </tr>
               </table>
               </form>
                </span>

            </div>
        </div>
        <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="aruskas-table" width="100%" cellspacing="0">
              
                <thead> 
                <center><h3 class="m-0 font-weight-bold-center text-black">Laporan Pengeluaran</h3> 
                </thead>
                <tbody>
                </body>         
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

        $("#aruskas-table").appTable({
            source: '<?php echo_uri("master/aruskas_excel/list_data/$start_date/$end_date") ?>',
            // order: [[1, "asc"]],
            columns: [
                {title: "TGL", "class": "text-center"},
                {title: "REF", "class": "text-center"},
                {title: "NO KODE", "class": "text-center"},
                {title: "NAMA KODE", "class": "text-center"},
                {title: "NO AREA", "class": "text-center"},
                {title: "URAIAN", "class": "text-center"},
                {title: "DEBIT", "class": "text-center"},
                {title: "KREDIT", "class": "text-center"},
                {title: "KETERANGAN", "class": "text-center"},

                // {title: "Credit Limit"},
            ],
            xlsxColumns: [0, 1, 2, 3, 4, 6, 5, 6, 7, 8]

        });
    });
</script>    
<script>
        // Fetch records
        function fetch(start_date, end_date) {
            $.ajax({
                url: "aruskas.php",
                type: "POST",
                data: {
                    start_date: start_date,
                    end_date: end_date
                },
                dataType: "json",
                success: function(data) {
                    // Datatables
                    var i = "1";
                    $('#records').DataTable({
                        "data": data,
                        // buttons
                        "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        "buttons": [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ],
                        // responsive
                        "responsive": true,
                        "columns": [{
                                "data": "id",
                                "render": function(data, type, row, meta) {
                                    return i++;
                                }
                            },
                            {
                                "data": "msisdn"
                            },
                            {
                                "data": "alias"
                            },
                            {
                                "data": "siteid"
                            },
                            {
                                "data": "tgl",
                                "render": function(data, type, row, meta) {
                                    return moment(row.tgl).format('DD-MM-YYYY');
                                }
                            },
                            {
                                "data": "jamm"
                            },
                            {
                                "data": "jamk"
                            },
                            {
                                "data": "aktivitas"
                            },
                            {
                                "data": "status"
                            },
                            {
                                "data": "wsms"
                            },
                            {
                                "data": "timestamp"
                            },
                        ]
                    });
                }
            });
        }
        fetch();
        // Filter
        $(document).on("click", "#filter", function(e) {
            e.preventDefault();
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            if (start_date == "" || end_date == "") {
                alert("both date required");
            } else {
                $('#records').DataTable().destroy();
                fetch(start_date, end_date);
            }
        });
        // Reset
        $(document).on("click", "#reset", function(e) {
            e.preventDefault();
            $("#start_date").val(''); // empty value
            $("#end_date").val('');
            $('#records').DataTable().destroy();
            fetch();
        });
    </script>