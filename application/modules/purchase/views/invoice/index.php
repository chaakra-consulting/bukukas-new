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
                    <form action="" method="GET" role="form" class="general-form" style="padding: 0 12px 0 12px;">
                        <input type="hidden" value="<?php echo sha1(date("Y-m-d H:i:s")) ?>" name="_token">

                        <div style="display: flex; flex-direction: column; gap: 15px; width: 100%; margin-bottom: 0;">

                            <div style="display: flex; flex-wrap: wrap; gap: 15px; align-items: center; width: 100%;">
                                <div style="display: flex; align-items: center; gap: 5px;">
                                    <label style="margin: 0; white-space: nowrap;">Tanggal Mulai</label>
                                    <input type="text" class="form-control" name="start" id="start" value="<?php echo $start_date ?>" autocomplete="off" style="width: 120px;">
                                </div>

                                <div style="display: flex; align-items: center; gap: 5px;">
                                    <label style="margin: 0; white-space: nowrap;">Tanggal Selesai</label>
                                    <input type="text" class="form-control" name="end" id="end" value="<?php echo $end_date ?>" autocomplete="off" style="width: 120px;">
                                </div>

                                <div style="display: flex; align-items: center; gap: 5px; flex: 1 1 250px; max-width: 100%;">
                                    <label style="margin: 0; white-space: nowrap;">Nomor Akun</label>
                                    <select class="form-control" name="account_number" id="account_number" style="flex: 1; width: 100%;">
                                        <option value="">Semua Akun</option>
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
                                        <option value="512 - Beban Kirim">512 - Beban Kirim</option>
                                        <option value="513 - Promosi">513 - Promosi</option>
                                    </select>
                                </div>
                            </div>

                            <div style="display: flex; flex-wrap: wrap; gap: 15px; align-items: center; width: 100%;">

                                <div style="flex: 1 1 250px; max-width: 100%;">
                                    <input id="project_id" name="project_id" class="form-control" style="width: 100%;">
                                </div>

                                <div style="flex: 0 0 auto;">
                                    <button id="filter" type="button" name="search" class="btn btn-default" value="2" style="min-width: 120px; width: 100%;"><i class=" fa fa-search"></i> Filter</button>
                                </div>

                            </div>

                        </div>
                    </form>
                </span>

            </div>
        </div>
        <div class="table-responsive" style="padding: 10px 10px 0 10px;">
            <table id="invoices-table" class=" table table-striped table-bordered" cellspacing="0" width="100%" style="font-size:12px">
            </table>
        </div>
    </div>
</div>
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap.min.css"> -->
<script type="text/javascript">
    $(document).ready(function() {

        setDatePicker("#start");
        setDatePicker("#end");

    });
</script>
<script type="text/javascript">
    $(document).ready(function() {

        var invoicesTable = $('#invoices-table').DataTable({
            destroy: true,
            "ajax": '<?php echo_uri("purchase/p_invoices/list_data/$start_date/$end_date/$account_number") ?>',
            "order": [
                [0, "desc"]
            ],
            "columns": [{
                    "title": "Tgl",
                    "className": "text-center"
                },
                {
                    "title": "Keterangan",
                    "className": "text-center"
                },
                {
                    "title": "Proyek",
                    "className": "text-center"
                },
                {
                    "title": "Nomor Bukti",
                    "className": "text-center"
                },
                {
                    "title": "Nomor Akun",
                    "className": "text-center"
                },
                {
                    "title": "Total",
                    "className": "text-center"
                },
                {
                    "title": "Status Pembelian",
                    "className": "text-center"
                },
                {
                    "title": "Status Pembayaran",
                    "className": "text-center"
                },
                {
                    "title": '<i class="fa fa-bars"></i>',
                    "className": "text-center option w150",
                    "orderable": false
                }
            ]
        });

        $("#filter").click(function() {
            var startDate = $("#start").val();
            var endDate = $("#end").val();
            var accountNumber = $("#account_number").val();
            var projectId = $("#project_id").val();

            var newUrl = '<?php echo_uri("purchase/p_invoices/list_data") ?>' + '/' + startDate + '/' + endDate + '?account_number=' + accountNumber + '&project_id=' + projectId;
            invoicesTable.ajax.url(newUrl).load();
        });


        $('#project_id').select2({
            placeholder: 'Cari Proyek...',
            allowClear: true,
            width: '100%',
            ajax: {
                url: '<?= base_url("purchase/p_invoices/get_all_project") ?>',
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
            minimumInputLength: 1
        });

    });
</script>

<script type="text/javascript">
    // Popup window code
    function newPopup(url) {
        popupWindow = window.open(
            url, 'popUpWindow', 'height=400,width=400,left=500,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
    }
</script>