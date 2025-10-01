<div id="page-content" class="clearfix">
    <?php load_css(array("assets/css/invoice.css")); ?>
    <div style="max-width: 1000px; margin: auto;">

        <div id="invoice-status-bar" class="panel panel-default p5 no-border m0">
            <form action="" method="GET" role="form" class="general-form">
                <table class="table table-bordered">
                    <tr>
                        <td>
                            <input type="text" class="form-control" id="start_date" name="start" autocomplete="off"
                                placeholder="START DATE"
                                value="<?php echo isset($_GET['start']) ? $_GET['start'] : ''; ?>">
                        </td>
                        <td>
                            <input type="text" class="form-control" id="end_date" name="end" autocomplete="off"
                                placeholder="END DATE" value="<?php echo isset($_GET['end']) ? $_GET['end'] : ''; ?>">
                        </td>
                        <td>
                            <button type="submit" name="search" class="btn btn-default" value="1"><i
                                    class="fa fa-search"></i> Filter</button>
                            <a href="#" name="print" class="btn btn-default"
                                onclick="tableToExcel('table-print', 'Lap_Penjualan')"><i
                                    class="fa fa-file-excel-o"></i> Excel</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <div class="mt15">
            <div class="panel panel-default p15 b-t">
                <div>
                    <table class="table table-bordered" id="table-print">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Nama Perusahaan</th>
                                <th style="text-align: center;">Nama Projek</th>
                                <th style="text-align: center; width: 150px;">DPP</th>
                                <th style="text-align: center; width: 140px;">PPN</th>
                                <th style="text-align: center; width: 150px;">Grand Total</th>
                                <th style="text-align: center;">Status</th>
                                <th style="text-align: center; width: 150px;">Total Terbayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $jumlah = 0;
                            $jumlah_total_all = 0;
                            $jumlah_terbayar = 0;
                            foreach ($sales_report as $row) { ?>
                                <tr>
                                    <td>
                                        <?php
                                        // Check if fid_cust, fid_custtt, or fid_custttt are greater than 0 and display the corresponding customer names
                                        if ($row->fid_cust > 0 && $row->customer_name1) {
                                            echo $row->customer_name1; // Display customer name for fid_cust
                                        } elseif ($row->fid_custtt > 0 && $row->customer_name2) {
                                            echo $row->customer_name2; // Display customer name for fid_custtt
                                        } elseif ($row->fid_custttt > 0 && $row->customer_name3) {
                                            echo $row->customer_name3; // Display customer name for fid_custttt
                                        } else {
                                            echo "Tidak ada pelanggan"; // Fallback if no valid customer
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $row->title; ?></td>
                                    <?php
                                    
                                    $isComplete = ($row->termin_1 == ($row->termin_all ?? 0));
                                    $isAutoLunas = ($row->inv_date < '2025-08-01' && ($row->termin_all ?? 0) == 0);
                                    $labelClass = ($isComplete || $isAutoLunas) ? 'label-success' : 'label-danger';
                                    if ($isComplete || $isAutoLunas) {
                                        $statusText = 'Lunas';
                                        $total_all = $row->total + $row->tax_amount + $row->pph_amount;
                                        $total = $total_all;
                                    }else{ 
                                        $statusText = $row->termin_1 . ' to ' . ($row->termin_all ?? 0);
                                        $total = $row->total_terbayar;
                                    }
                                    ?>
                                    <td style="text-align: right;">
                                        <?php echo to_currency($row->total, false);
                                        $jumlah += $row->total; ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <?php echo to_currency($row->tax_amount, false); ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <?php 
                                        $jumlah_total_all += $row->total_all;
                                        echo to_currency($row->total_all, false); 
                                        ?>
                                    </td>
                                    <td style="text-align:center;">
                                        <span class="label <?= $labelClass ?>">
                                            <?= $statusText ?>
                                        </span>
                                    </td>                                    
                                    <td style="text-align: right;">
                                        <?php echo to_currency($total, false); 
                                        $jumlah_terbayar += $total; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" style="text-align: right;">TOTAL :</th>
                                <th style="text-align: right;"><?php echo to_currency($jumlah, false); ?></th>
                                <th style="text-align: right;"><?php echo to_currency($total_tax, false); ?></th>
                                <th style="text-align: right;"><?php echo to_currency($jumlah_total_all, false); ?></th>
                                <th colspan="1" style="text-align: right;"></th>
                                <th style="text-align: right;"><?php echo to_currency($jumlah_terbayar, false); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        setDatePicker("#start_date");
        setDatePicker("#end_date");

        $('#table-print').DataTable({
            "order": [[2, "desc"]], // Default sorting by total amount in descending order
            "columnDefs": [
                {"targets": [0, 1, 5], "type": "string"},
                {"targets": [2, 3, 4, 6], "type": "num-fmt", "orderSequence": ["desc", "asc"]}
            ],
            "paging": false,
            "info": false, 
            "searching": true 
        });
    });
</script>