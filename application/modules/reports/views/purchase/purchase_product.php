<style>
    /* Removes the default 15px gap between Bootstrap columns */
    .row.no-gutters {
        margin-right: 0;
        margin-left: 0;
    }

    .row.no-gutters>[class^="col-"],
    .row.no-gutters>[class*=" col-"] {
        padding-right: 0;
        padding-left: 0;
    }
</style>
<div id="page-content" class="clearfix">
    <?php
    load_css(array(
        "assets/css/invoice.css"
    ));
    ?>
    <div style="max-width: 1000px; margin: auto;">

        <div id="invoice-status-bar" class="panel panel-default  p5 no-border m0">

            <form action="" method="GET" role="form" class="general-form">

                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="text" class="form-control" id="start_date" name="start" autocomplete="off" placeholder="YYYY-MM-DD" value="<?php echo isset($_GET['start']) ? htmlspecialchars($_GET['start']) : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="text" class="form-control" id="end_date" name="end" autocomplete="off" placeholder="YYYY-MM-DD" value="<?php echo isset($_GET['end']) ? htmlspecialchars($_GET['end']) : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="paid">Status</label>
                            <select name="paid" id="paid" class="form-control">
                                <option value="PAID">Terbayar</option>
                                <option value="Not Paid">Belum Bayar</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="code">Nomor Akun</label>
                            <select name="code" id="code" class="form-control">
                                <option value="">Semua Akun</option>
                                <option value="501 - Operasional">501 - Operasional</option>
                                <option value="502 - Transport">502 - Transport</option>
                                <option value="503 - Perlengkapan Kantor">503 - Perlengkapan Kantor</option>
                                <option value="504 - Konsumsi">504 - Konsumsi</option>
                                <option value="505 - Pos dan Materai">505 - Pos dan Materai</option>
                                <option value="506 - Gaji">506 - Gaji</option>
                                <option value="507 - Beban Pajak">507 - Beban Pajak</option>
                                <option value="508 - Pulsa Handphone">508 - Pulsa Handphone</option>
                                <option value="509 - Listrik & Air">509 - Listrik & Air</option>
                                <option value="510 - Internet">510 - Internet</option>
                                <option value="511 - Maintenance Inventaris">511 - Maintenance Inventaris</option>
                                <option value="512 - Beban Kirim">512 - Beban Kirim</option>
                                <option value="513 - Promosi">513 - Promosi</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="customer">Nama Instansi</label>
                            <input type="text" id="customer" class="form-control" style="width: 100%;">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="project_id">Proyek</label>
                            <input type="text" id="project_id" name="project_id" disabled placeholder="Pilih nama instansi terlebih dahulu.." class="form-control select2" style="width: 100%;">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="hidden-xs" style="display: block;">&nbsp;</label>
                            <div class="btn-group" style="display: block;">
                                <button type="submit" name="search" class="btn btn-default" value="2">
                                    <i class="fa fa-search"></i> Filter
                                </button>
                                <a href="#" name="print" class="btn btn-default" onclick="tableToExcel('table-print', 'Lap_Pembelian')">
                                    <i class="fa fa-file-excel-o"></i> Excel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>

        <div class="mt15">
            <div class="panel panel-default p15 b-t">
                <div>
                    <table class="table table-bordered" id="table-print">
                        <tr>
                            <th colspan="5">
                                <center>
                                    <h3>Laporan Pembelian Chaakra</h3>
                                    <p><?= $project  ?></p>

                                    <p><strong><?php echo $date_range ?></strong></p>
                                    <p><strong><?php echo $paid ?></strong></p>
                            </th>

                        </tr>
                        <tr>
                            <th>Rincian</th>
                            <th style="text-align: center;">Pembelian</th>
                            <th style="text-align: center;">Nomer Akun</th>
                            <th style="text-align: center;">Jumlah</th>
                            <th style="text-align: center;">Total Rupiah</th>
                        </tr>
                        <tbody>
                            <?php $jumlah = 0;
                            $qty = 0;
                            foreach ($purchase_report->result() as $row) { ?>
                                <tr>
                                    <td><?php echo $row->memo; ?></td>
                                    <td style="text-align: center;"><?php
                                                                    if ($row->paid == "PAID") {
                                                                        echo "Terbayar";
                                                                    } else {
                                                                        echo $row->paid;
                                                                    }
                                                                    ?></td>
                                    <td style="text-align: center;"><?php echo $row->code; ?></td>
                                    <td style="text-align: center;"><?php echo $row->qty;
                                                                    $qty += $row->qty; ?></td>
                                    <td style="text-align: right;"><?php echo to_currency($row->total, false);
                                                                    $jumlah += $row->total; ?></td>


                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" style="text-align: right;">TOTAL :</th>
                                <th style="text-align: center;"><?php echo $qty; ?></th>
                                <th style="text-align: right;"><?php echo to_currency($jumlah, false); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        setDatePicker("#start_date");
        setDatePicker("#end_date");

        var customer_select = $('#customer').select2({
            placeholder: 'Cari Nama Instansi...',
            allowClear: true,
            theme: 'bootstrap-3',
            width: '100%',
            ajax: {
                url: '<?= base_url("master/customers/get_list_data") ?>',
                type: "POST",
                dataType: 'json',
                delay: 250,
                data: function(term, page) {
                    return {
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                        search: term // Only send the search keyword
                    };
                    console.log(term);

                },
                results: function(data) {

                    return {
                        results: data.data.map(function(item) {
                            return {
                                id: item.master_customers_id, // Use the master_customers_id as the option value
                                text: item.name // Use the name as the option text
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1
        });

        
        $(document.body).on("change", "#customer", function() {
            $('#project_id').val(null).trigger('change'); // Clear the project_id select2 value
            $('#project_id').prop('disabled', !$(this).val());
            $('#project_id').select2({
            placeholder: 'Cari Proyek...',
            allowClear: true,
            theme: 'bootstrap-3',
            width: '100%',
            ajax: {
                url: '<?= base_url("purchase/p_invoices/get_all_project") ?>/' + $(this).val(),
                type: "POST",
                dataType: 'json',
                delay: 250,
                data: function(term, page) {
                    return {
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                        search: term // Only send the search keyword
                    };
                    console.log(term);

                },
                results: function(data) {
                    return {
                        results: data.data.map(function(item) {
                            return {
                                id: item.sales_invoices_id, // Use the sales_invoices_id as the option value
                                text: item.title // Use the title as the option text
                            };
                        })
                    };
                },
                cache: true
            },
        });
        });

    });
</script>