<?php echo form_open(get_uri("purchase/p_invoices/save_edit"), array("id" => "invoices-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">

     <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />

     <div class="form-group">
        <label for="code" class=" col-md-3">Kode Akun</label>
        <div class="col-md-9">
        <?php 
                echo form_dropdown(
                    "code", array(
                        "501 - Operasional" => "501 - Operasional",
                        "502 - Transport" => "502 - Transport",
                        "503 - Perlengkapan Kantor" => "503 - Perlengkapan Kantor",
                        "504 - Konsumsi" => "504 - Konsumsi",
                        "505 - Pos dan Materai" => "505 - Pos dan Materai",
                        "506 - Gaji" => "506 - Gaji",
                        "507 - Beban Pajak" => "507 - Beban Pajak",
                        "508 - Pulsa Handphone" => "508 - Pulsa Handphone",
                        "509 - Listrik & Air" => "509 - Listrik & Air",
                        "510 - Internet" => "510 - Internet",
                        "511 - Maintenance Inventaris" => "511 - Maintenance Inventaris",
                        "512 - Beban Kirim" => "512 - Beban Kirim",
                        "513 - Beban Iklan" => "513 - Beban Iklan",
                        "514 - Beban Tunjangan" => "514 - Beban Tunjangan",
                        ), $model_info->code, "class='select2'"
                    );
                        ?>
        </div>
    </div> 
    <!-- <div class="form-group">
        <label for="fid_vendor" class="col-md-3">Perusahaan</label>
        <div class=" col-md-9">
            <?php
            //echo form_dropdown("fid_vendor", $clients_dropdown, $model_info->fid_vendor, "class='select2 validate-hidden' id='fid_vendor' data-rule-required='true', data-msg-required='" . lang('field_required') . "'");
            ?>
        </div>
    </div> -->
    <div class="form-group">
        <label for="inv_date" class="col-md-3">Tanggal</label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "inv_date",
                "name" => "inv_date",
                "class" => "form-control",
                "placeholder" => "Y/m/d",
                "value" => $model_info->inv_date,
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="memo" class="col-md-3">Catatan</label>
        <div class=" col-md-9">
            <?php
            echo form_textarea(array(
                "id" => "memo",
                "name" => "memo",
                "class" => "form-control",
                "value" => $model_info->memo,
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="foto" class=" col-md-3">Upload Bukti</label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "foto",
                "name" => "foto",
                "class" => "form-control",
                "type" => "file",
                "accept" => "image/*"
            ));
            ?>

            <div id="preview-container" class="mt-2">
                <?php if (!empty($model_info->bukti_url)): ?>
                    <?php
                    $ext = pathinfo($model_info->bukti_url, PATHINFO_EXTENSION);
                    $is_image = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                    ?>
                    <?php if ($is_image): ?>
                        <img id="preview-image" src="<?php echo $model_info->bukti_url; ?>" alt="Bukti" style="max-width: 50%; height: auto; border:1px solid #ccc; padding:5px;">
                    <?php else: ?>
                        <a id="preview-link" href="<?php echo $model_info->bukti_url; ?>" target="_blank" class="btn btn-sm btn-info">Lihat Bukti</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
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
                    window.location = "<?php echo site_url('purchase/p_invoices/view'); ?>/" + result.id;
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
        $("#fid_cust").select2().on("change", function () {
            var clients_id = $(this).val();
            if ($(this).val()) {
                // $('#invoice_project_id').select2("destroy");
                // $("#invoice_project_id").hide();
                // appLoader.show({container: "#invoice-porject-dropdown-section"});
                $.ajax({
                    url: "<?php echo get_uri("master/vendors/getId") ?>" + "/" + client_id,
                    dataType: "json",
                    // data: data,
                    type:'GET',
                    success: function (data) {

                         $.each(data, function(index, element) {
                            $("#fid_cust").val(element.id).select2();
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
                    url: "<?php echo get_uri("purchase/p_invoices/getOrderId") ?>" + "/" + client_id,
                    dataType: "json",
                    // data: data,
                    type:'GET',
                    success: function (data) {
                         $.each(data, function(index, element) {
                            $("#fid_vendor").val(element.id).select2();
                            $("#email_to").val(element.email);
                            $("#inv_address").val(element.address);
                            $("#delivery_address").val(element.address);
                         });
                    }
                });
                $.ajax({
                    url: "<?php echo get_uri("purchase/p_invoices/getOrderIdC") ?>" + "/" + client_id,
                    dataType: "json",
                    // data: data,
                    type:'GET',
                    success: function (data) {
                         $.each(data, function(index, element) {
                            $("#fid_cust").val(element.id).select2();

                         });
                    }
                });
                $.ajax({
                    url: "<?php echo get_uri("purchase/p_invoices/getOrderIdP") ?>" + "/" + client_id,
                    dataType: "json",
                    // data: data,
                    type:'GET',
                    success: function (data) {

                         $.each(data, function(index, element) {
                            $("#fid_custt").val(element.id).select2();
                         });
                    }
                });
            }
        });
    });

    document.getElementById('foto').addEventListener('change', function (e) {
        const previewContainer = document.getElementById('preview-container');
        const file = e.target.files[0];

        if (file) {
            const fileReader = new FileReader();
            const fileType = file.type;

            fileReader.onload = function (e) {
                // Hapus konten lama
                previewContainer.innerHTML = "";

                if (fileType.startsWith("image/")) {
                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.style.maxWidth = "50%";
                    img.style.border = "1px solid #ccc";
                    img.style.padding = "5px";
                    previewContainer.appendChild(img);
                } else {
                    const link = document.createElement("a");
                    link.href = e.target.result;
                    link.target = "_blank";
                    link.textContent = "Lihat Bukti";
                    link.className = "btn btn-sm btn-info";
                    previewContainer.appendChild(link);
                }
            };

            fileReader.readAsDataURL(file);
        }
    });
</script>