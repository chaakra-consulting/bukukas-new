<?php echo form_open(get_uri("sales/s_invoices/update"), array("id" => "invoices-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
<input type="hidden" name="id" value="<?php echo $model_info->id ?>">
<input type="hidden" name="item_id" value="<?php echo $item_info->id ?>">
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
                        "value" =>$model_info->spk_code,
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
                        "value" => $item_info->title,
                        "class" => "form-control validate-hidden",
                        "data-rule-required" => true,
                        "data-msg-required" => lang("field_required"),
                    )); ?>
                </div>
            </div>
            <!-- <div  id="invoice_item_title" class="form-group">
                <label for="invoice_item_title" class="col-md-3">Project</label>
                <div class="col-md-9">
                    <textarea id="invoice_item_title" name="invoice_item_title"
                        class="form-control validate-hidden"
                        data-rule-required="true"
                        data-msg-required="<?php echo lang("field_required"); ?>">
                        <?php echo $item_info->title; ?>
                    </textarea>
                </div>
            </div> -->
            <div class="form-group">
                <label for="invoice_item_rate" class=" col-md-3">Harga (Dpp)</label>
                <div class="col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "invoice_item_rate",
                        "name" => "invoice_item_rate",
                        "value" => $item_info->rate ? to_decimal_format($item_info->rate) : "",
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
                        "value" =>$model_info->inv_date,
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
                        "value" =>$model_info->inv_contract_date,
                        "data-rule-required" => true,
                        "data-msg-required" => lang("field_required"),
                     
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="bukpot" class=" col-md-3">Upload SPK <br> <p style="color:red;"> format pdf </p></label>
                <div class="col-md-9">
                <?php
                    echo form_input(array(
                        "id" => "bukpot",
                        "name" => "bukpot",
                        "class" => "form-control",
                        "type" => "file"
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="fid_tax" class=" col-md-3">PPN</label>
                <div class="col-md-8">
                    <?php
                    echo form_dropdown("fid_tax", $taxes_dropdown, $model_info->fid_tax, "class='select2 tax-select2'");
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
                    "value" => $model_info->termin,
                    "class" => "form-control validate-hidden",
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                )); ?>
            </div>
        </div>
        <!-- <div class="form-group">
            <label for="no_inv" class=" col-md-3">No Invoices</label>
            <div class="col-md-9">
             <?php
            echo form_input(array(
                "id" => "no_inv",
                "name" => "no_inv",
                "class" => "form-control",
                "value" => $model_info->no_inv,
            ));
            ?>
            </div>
        </div> -->
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
                    $jenis_customers ?? "",
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
                    // array($fid_cust => $name_cust),
                    $clients_dropdown,
                    $fid_cust ?? "",
                    "class='select2 validate-hidden' id='fid_cust'"
                );
                ?>
            </div>
        </div>

        <!-- <div class="form-group">
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
            </div>   -->
    
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#invoices-form .select2").select2();
        setDatePicker("#inv_date");
        setDatePicker("#end_date");
        setDatePicker("#inv_contract_date");

        $("#invoices-form").appForm({
            onSuccess: function (result) {
                location.reload();
            }
        });
        
        $("#fid_cust").select2().on("change", function () {
            var client_id = $(this).val();
            if ($(this).val()) {
                // $('#invoice_project_id').select2("destroy");
                // $("#invoice_project_id").hide();
                // appLoader.show({container: "#invoice-porject-dropdown-section"});
                $.ajax({
                    url: "<?php echo get_uri("master/customers/getId") ?>" + "/" + client_id,
                    dataType: "json",
                    // data: data,
                    type:'GET',
                    success: function (data) {

                         $.each(data, function(index, element) {
                            
                            $("#email_to").val(element.email);
                            $("#inv_address").val(element.address);
                            $("#delivery_address").val(element.address);
                         });
                    }
                });
            }
        });
        $("#fid_order").select2().on("change", function () {
            var client_id = $(this).val();
            if ($(this).val()) {
                // $('#invoice_project_id').select2("destroy");
                // $("#invoice_project_id").hide();
                // appLoader.show({container: "#invoice-porject-dropdown-section"});
                $.ajax({
                    url: "<?php echo get_uri("sales/s_invoices/getOrderId") ?>" + "/" + client_id,
                    dataType: "json",
                    // data: data,
                    type:'GET',
                    success: function (data) {

                         $.each(data, function(index, element) {
                            $("#fid_cust").val(element.id).select2();
                            $("#fid_custt").val(element.id).select2();                            
                            $("#email_to").val(element.email);
                            $("#inv_address").val(element.address);
                            $("#delivery_address").val(element.address);
                         });
                    }
                });
            }
        });

        $('#invoice_item_rate').maskMoney({
            precision: 0
        });

        $('input[name=invoice_item_rate]').change(function () {
            var value = $(this).val();
        });
    });
    // $(document).ready(function() {
    //     function loadCustomers(jenis, selected = "") {
    //         console.log("loadCustomers dipanggil dengan:", jenis, selected); // [1] cek parameter

    //         if (jenis) {
    //             $.ajax({
    //                 url: "<?= site_url('sales/s_invoices/get_clients_by_jenis') ?>",
    //                 type: "POST",
    //                 data: { jenis: jenis },
    //                 dataType: "json",
    //                 success: function(res) {
    //                     console.log("AJAX sukses, hasil dari server:", res); // [2] cek data JSON

    //                     let $fid_cust = $("#fid_cust");
    //                     $fid_cust.empty().append('<option value="">-</option>');

    //                     $.each(res, function(key, val) {
    //                         $fid_cust.append('<option value="'+key+'">'+val+'</option>');
    //                     });

    //                     if (selected) {
    //                         $fid_cust.val(selected).trigger("change.select2");
    //                         console.log("Value default setelah set:", $fid_cust.val()); // [3] cek hasil set
    //                     }
    //                 }
    //             });
    //         }
    //     }

    //     let initialJenis = "<?= $jenis_customers ?? '' ?>";
    //     let initialCust  = "<?= $fid_cust ?? '' ?>";

    //     console.log("initialJenis dari PHP:", initialJenis); // [cek awal]
    //     console.log("initialCust dari PHP:", initialCust);

    //     if (initialJenis) {
    //         loadCustomers(initialJenis, initialCust);
    //     }

    //     $("#jenis").change(function() {
    //         console.log("Dropdown Jenis berubah ke:", $(this).val()); // [cek perubahan]
    //         loadCustomers($(this).val());
    //     });
    // });
</script>