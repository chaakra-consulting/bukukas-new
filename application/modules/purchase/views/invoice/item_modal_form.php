<?php echo form_open(get_uri("purchase/p_invoices/save_item"), array("id" => "invoice-item-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
    <input type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>" />

    <div class="form-group">
        <label for="title" class=" col-md-3">Pengeluaran</label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "title",
                "name" => "title",
                "class" => "form-control validate-hidden",
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>

    <div class="form-group">
        <label for="description" class=" col-md-3">Deskripsi</label>
        <div class="col-md-9">
            <?php
            echo form_textarea(array(
                "id" => "description",
                "name" => "description",
                "value" => $model_info->description,
                "class" => "form-control",
                "placeholder" => "Deskripsi",
            ));
            ?>
        </div>
    </div>

    <div class="form-group" id="form-consumable" style="display: none;">
        <label for="consumable_id" class="col-md-3">Pilihan ATK</label>
        <div class="col-md-9">
            <?php
            echo form_dropdown(
                "consumable_id",
                $consumables_dropdown,
                "",
                "class='select2' id='consumable_id'"
            );
            ?>
        </div>
    </div>

    <input type="hidden" name="fid_item" id="fid_item" >

    <div class="form-group">
        <label for="invoice_item_quantity" class=" col-md-3">Jumlah Pembelian</label>
        <div class="col-md-9 d-flex align-items-center">
            <?php
            echo form_input(array(
                "id" => "invoice_item_quantity",
                "name" => "invoice_item_quantity",
                "value" => $model_info->quantity ? to_decimal_format($model_info->quantity) : "",
                "class" => "form-control",
                "placeholder" => lang('quantity'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
                "style" => "width: 70%; display: inline-block; margin-right: 10px;"
            ));
            ?>
            <span id="satuan-label" style="font-weight: bold;"></span>
        </div>
    </div>

    <div class="form-group" id="form-quantity">
        <label for="quantity_consumables" class="col-md-3">Jumlah Isi</label>
        <div class="col-md-9 d-flex align-items-center">
            <?php 
            echo form_input(array(
                "type" => "number",
                "id" => "quantity_consumables",
                "name" => "quantity_consumables",
                "class" => "form-control validate-hidden",
                "placeholder" => "0",
                "style" => "width: 70%; display: inline-block; margin-right: 10px;"
            ));
            ?>
        </div>
    </div>
    
     <div class="form-group">
        <label for="invoice_item_basic" class=" col-md-3">Harga Beli</label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "invoice_item_basic",
                "name" => "invoice_item_basic",
                "value" => $model_info->basic_price ? to_decimal_format($model_info->basic_price) : "",
                "class" => "form-control",
                "placeholder" => "0",
            ));
            ?>
        </div>
    </div> 
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">
        <span class="fa fa-close"></span> <?php echo lang('close'); ?>
    </button>
    <button type="submit" class="btn btn-primary">
        <span class="fa fa-check-circle"></span> <?php echo lang('save'); ?>
    </button>
</div>

<?php echo form_close(); ?>

<script type="text/javascript">
$(document).ready(function () {
    $("#invoice-item-form .select2").select2();

    $("#invoice-item-form").appForm({
        onSuccess: function (result) {
            $("#invoice-item-table").appTable({ newData: result.data, dataId: result.id });
            $("#invoice-total-section").html(result.invoice_total_view);
            if (typeof updateInvoiceStatusBar == "function") {
                updateInvoiceStatusBar(result.invoice_id);
            }
        },
    });

    const satuanLabel = $("#satuan-label");
    const formQuantity = $("#form-quantity");
    const formConsumable = $("#form-consumable");
    const consumableInput = $("#consumable_id");

    formQuantity.hide();

    // ambil kode dari PHP
    const headCode = "<?php echo isset($head_info->code) ? $head_info->code : ''; ?>";

    if (headCode === "503" || headCode === "503 - Perlengkapan Kantor") {
        // tampilkan field dan jadikan required
        formConsumable.show();
        consumableInput.attr("data-rule-required", "true");
        consumableInput.attr("data-msg-required", "<?php echo lang('field_required'); ?>");
        consumableInput.addClass("validate-hidden");
    } else {
        // sembunyikan field dan hilangkan keharusan
        formConsumable.hide();
        consumableInput.val("").trigger("change");
        consumableInput.removeAttr("data-rule-required data-msg-required");
        consumableInput.removeClass("validate-hidden");
    }

    consumableInput.on("change", function () {
        const consumableId = $(this).val();

        if (!consumableId) {
            satuanLabel.text("");
            formQuantity.hide();
            return;
        }

        $.ajax({
            url: "<?php echo get_uri('purchase/p_invoices/get_info_consumables/'); ?>" + consumableId,
            type: "GET",
            dataType: "json",
            beforeSend: function () {
                satuanLabel.text("Loading...");
                formQuantity.hide();
            },
            success: function (response) {
                if (response.success && response.cust && response.cust.satuan) {
                    const satuan = response.cust.satuan.toLowerCase();
                    satuanLabel.text(response.cust.satuan);

                    if (["pcs", "rim", "lusin"].includes(satuan)) {
                        formQuantity.hide();
                        $("#quantity").val("");
                    } else {
                        formQuantity.slideDown(200);
                    }
                } else {
                    satuanLabel.text("-");
                    formQuantity.hide();
                }
            },
            error: function () {
                satuanLabel.text("Error");
                formQuantity.hide();
            },
        });
    });
});
</script>
