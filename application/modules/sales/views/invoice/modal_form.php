<?php echo form_open(get_uri("sales/s_invoices/add"), array("id" => "invoices-form", "class" => "general-form", "role" => "form")); ?>
    <div class="modal-body clearfix">

            <div class="form-group">
                <label for="fid_custt" class="col-md-3">Nama Perusahaan</label>
                <div class=" col-md-9">
                    <?php
                    echo form_dropdown("fid_custt", $pers_dropdown, $model_info->fid_custt, "class='select2 validate-hidden' id='fid_custt' data-rule-required='true', data-msg-required='" . lang('field_required') . "'");
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="spk_code" class=" col-md-3">No. SPK</label>
                <div class="col-md-9">
                    <?php 
                    echo form_input(array(
                        "id" => "spk_code",
                        "name" => "spk_code",
                        "class" => "form-control validate-hidden",
                        // "data-rule-required" => true,
                        "data-msg-required" => lang("field_required"),
                    )); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="invoice_item_title" class=" col-md-3">Project</label>
                <div class="col-md-9">
                    <?php 
                    echo form_input(array(
                        "id" => "invoice_item_title",
                        "name" => "invoice_item_title",
                        // "value" => $model_info->title,
                        "class" => "form-control validate-hidden",
                        "data-rule-required" => true,
                        "data-msg-required" => lang("field_required"),
                    )); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="invoice_item_rate" class=" col-md-3">Harga (Dpp)</label>
                <div class="col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "invoice_item_rate",
                        "name" => "invoice_item_rate",
                        // "value" => $model_info->rate ? to_decimal_format($model_info->rate) : "",
                        "class" => "form-control",
                        "placeholder" => "0",
                        "data-rule-required" => true,
                        // "type" => 'number',
                        "data-msg-required" => lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inv_date" class="col-md-3">Tanggal SPK</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "inv_date",
                        "name" => "inv_date",
                        "class" => "form-control",
                        "autocomplete" => "off",
                        "value" => date("Y-m-d"),
                        "data-rule-required" => true,
                        "data-msg-required" => lang("field_required"),
                     
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inv_contract_date" class="col-md-3">Tanggal Kontrak Berakhir</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "inv_contract_date",
                        "name" => "inv_contract_date",
                        "class" => "form-control",
                        "autocomplete" => "off",
                        "value" => date("Y-m-d"),
                        "data-rule-required" => true,
                        "data-msg-required" => lang("field_required"),
                     
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="fid_tax" class=" col-md-3">PPN</label>
                <div class="col-md-9">
                    <?php
                    echo form_dropdown("fid_tax", $taxes_dropdown, array($model_info->fid_tax), "class='select2 tax-select2'");
                    ?>
                </div>
            </div>
        <div class="form-group">
            <label for="potongan" class=" col-md-3">PPH %</label>
            <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "potongan",
                "name" => "potongan",
                "class" => "form-control",
                "type" => "number",
                "placeholder" => "2.5",
                "value" => $model_info->potongan,
            ));
            ?>
            </div>
        </div>
        <div class="form-group">
            <label for="termin" class=" col-md-3">Jumlah Termin</label>
            <div class="col-md-9">
                <?php 
                echo form_input(array(
                    "type" => "number",
                    "id" => "termin",
                    "name" => "termin",
                    // "value" => $model_info->termin,
                    "class" => "form-control validate-hidden",
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                )); ?>
            </div>
        </div>
        <!-- <div class="form-group">
            <label for="jenis" class="col-md-3">Jenis Perusahaan</label>
            <div class="col-md-9">
                <?php
                echo form_dropdown(
                    "jenis",
                    array(
                        "" => "-",
                        "BUMN" => "BUMN",
                        "BUMD" => "BUMD",
                        "DINAS" => "DINAS",
                        "SWASTA" => "SWASTA"
                    ),
                    "",
                    "class='select2' id='jenis' required"
                );
                ?>
            </div>
        </div> -->

        <div class="form-group">
            <label for="fid_cust" class="col-md-3">Nama Instansi</label>
            <div class="col-md-9">
                <?php
                echo form_dropdown(
                    "fid_cust",
                    $clients_dropdown,
                    "",
                    "class='select2 validate-hidden' id='fid_cust' required"
                );
                ?>
            </div>
        </div>

        <!-- 
        <div class="form-group">
            <label for="fid_cust" class="col-md-3">Dinas</label>
            <div class=" col-md-9">
                <?php
                echo form_dropdown("fid_cust", $clients_dropdown, $model_info->fid_cust, "class='select2 validate-hidden' id='fid_cust'");
                ?>
            </div>
        </div>   
        <div class="form-group">
            <label for="fid_custtt" class="col-md-3">BUMD</label>
            <div class=" col-md-9">
                <?php
                echo form_dropdown("fid_custtt", $clients_dropdown, $model_info->fid_custtt, "class='select2 validate-hidden' id='fid_custtt'");
                ?>
            </div>
        </div>     
        <div class="form-group">
            <label for="fid_custttt" class="col-md-3">Swasta</label>
            <div class=" col-md-9">
                <?php
                echo form_dropdown("fid_custttt", $clients_dropdown, $model_info->fid_custttt, "class='select2 validate-hidden' id='fid_custttt'");
                ?>
            </div>
        </div>      -->
       
    
    </div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#invoice_item_rate').maskMoney({
            precision: 0
        });

        $('input[name=invoice_item_rate]').change(function () {
            var value = $(this).val();
            // Tambahkan logika sesuai kebutuhan
        });

        $("#invoices-form .select2").select2();
        setDatePicker("#inv_date");
        setDatePicker("#inv_contract_date");
        // $("#invoices-form").appForm({
        //     onSuccess: function (result) {
        //         $("#invoices-table").appTable({newData: result.data, dataId: result.id});
        //     }
        // });
            RELOAD_VIEW_AFTER_UPDATE = false; //go to invoice page
        
       $("#invoices-form").appForm({
            onSuccess: function (result) {
                if (typeof RELOAD_VIEW_AFTER_UPDATE !== "undefined" && RELOAD_VIEW_AFTER_UPDATE) {
                    location.reload();
                } else {
                    window.location = "<?php echo site_url('sales/s_invoices/view'); ?>/" + result.id;
                }
            },
            onAjaxSuccess: function (result) {
                if (!result.success && result.next_recurring_date_error) {
                    $("#next_recurring_date").val(result.next_recurring_date_value);
                    $("#next_recurring_date_container").removeClass("hide");

                    $("#invoice-form").data("validator").showErrors({
                        "next_recurring_date": result.next_recurring_date_error
                    });
                }
            }
        });
    });
    // $(document).ready(function () {
    //     $('#jenis').change(function () {
    //         var jenis = $(this).val();

    //         // kosongkan dulu dropdown fid_cust
    //         $('#fid_cust').html('<option value="">-</option>');

    //         if (jenis !== "") {
    //             $.ajax({
    //                 url: "<?= site_url('sales/s_invoices/get_clients_by_jenis'); ?>",
    //                 type: "POST",
    //                 data: {jenis: jenis},
    //                 dataType: "json",
    //                 success: function (res) {
    //                     $.each(res, function (key, value) {
    //                         $('#fid_cust').append('<option value="' + key + '">' + value + '</option>');
    //                     });
    //                     $('#fid_cust').trigger('change'); // refresh select2
    //                 }
    //             });
    //         }
    //     });
    // });

</script>