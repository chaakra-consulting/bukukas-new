<div id="page-content" class="clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1>Data Proyek</h1>

            <div class="title-button-group">
                <div class="btn-group" role="group">
                </div>
                <?php
                echo modal_anchor(get_uri("sales/s_invoices/modal_form"), "<i class='fa fa-plus-circle'></i> " . "Tambah Proyek", array("class" => "btn btn-primary", "title" => "Tambah Proyek"));

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
                                <td><input type="text" class="form-control" name="start" id="start"
                                        value="<?php echo $start_date ?>" autocomplete="off"></td>
                                <td><label>End Date</label></td>
                                <td><input type="text" class="form-control" name="end" id="end"
                                        value="<?php echo $end_date ?>" autocomplete="off"></td>
                                <td>
                                    <button type="submit" name="search" class="btn btn-default" value="1"><i
                                            class=" fa fa-search"></i> Filter</button>
                                    <a href="#" name="print" class="btn btn-default"
                                        onclick="tableToExcel('invoices-table', 'Lap_Pembelian')"><i
                                            class=" fa fa-file-excel-o"></i> Excel</a>

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
            source: '<?php echo_uri("sales/s_invoices/list_data/$start_date/$end_date") ?>',
            // invoices: [[1, "asc"]],
            columns: [
                { title: "Project", "class": "text-center" },
                { title: "Pelaksana", "class": "text-center" },
                { title: "Tanggal SPK", "class": "text-center" },
                { title: "SPK", "class": "text-center" },
                { title: "Status", "class": "text-center" },
                { title: "Nominal", "class": "text-center" },
                { title: "PPN", "class": "text-center" },
                { title: "PPH", "class": "text-center" },
                { title: "Total Semua", "class": "text-center" },
                { title: "Dinas", "class": "text-center" },
                // {title: "BUMN","class": "text-center"},
                { title: "BUMD", "class": "text-center" },
                { title: "Swasta", "class": "text-center" },
                { title: '<i class="fa fa-bars"></i>', "class": "text-center option w140" }
            ],
            xlsColumns: [0, 1, 2, 3, 4, 5, 6, 7]

        });

    });
</script>