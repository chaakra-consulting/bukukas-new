<?php echo form_open(get_uri("purchase/p_invoices/save_edit_consumables_usage"), array("id" => "consumable-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
    <!-- <div class="form-group">
        <label for="used_by" class="col-md-3">Pengguna Barang</label>
        <div class=" col-md-9">
            <?php
            echo form_dropdown("used_by", $users_dropdown, $auth_user_id, "class='select2 validate-hidden' id='consumable_id' data-rule-required='true', data-msg-required='" . lang('field_required') . "'");
            ?>  
        </div>
    </div> -->
    <div class="form-group">
        <label for="consumable_id" class="col-md-3">Pilihan ATK</label>
        <div class=" col-md-9">
            <?php
            echo form_dropdown("consumable_id", $consumables_dropdown, $model_info->consumable_id, "class='select2 validate-hidden' id='consumable_id' data-rule-required='true', data-msg-required='" . lang('field_required') . "'");
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="usage_date" class="col-md-3">Tanggal Penggunaan</label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "usage_date",
                "name" => "usage_date",
                "class" => "form-control",
                "placeholder" => "Y/m/d",
                "value"=> $model_info->usage_date,
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="quantity" class="col-md-3">Jumlah Barang</label>
        <div class="col-md-9 d-flex align-items-center">
            <?php 
            echo form_input(array(
                "type" => "number",
                "id" => "quantity",
                "name" => "quantity",
                "class" => "form-control validate-hidden",
                "value"=> $model_info->quantity,
                "placeholder" => "0",
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
                "style" => "width: 80%; display: inline-block; margin-right: 10px;"
            ));
            ?>
            <span style="font-weight: bold;">Pcs</span>
        </div>
        <div class="col-md-9 col-md-offset-3" style="margin-top: 5px;">
            <small id="remaining-stock" style="color: #777;"></small>
        </div>
        <div class="col-md-9 col-md-offset-3" style="margin-top: 3px;">
            <small id="stock-warning" style="color: red; display: none;">Jumlah melebihi stok tersedia!</small>
        </div>
    </div>
    <div class="form-group">
        <label for="purpose" class=" col-md-3">Tujuan</label>
        <div class="col-md-9">
            <?php
            echo form_textarea(array(
                "id" => "purpose",
                "name" => "purpose",
                "value"=> $model_info->purpose,
                "class" => "form-control",
                "placeholder" => "Masukkan Tujuan Penggunaan",
                "data-rule-required" => true,
                // "type" => 'number',
                "data-msg-required" => lang("field_required"),
            ));
            ?>
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

        $("#consumable-form .select2").select2();
        setDatePicker("#usage_date");
        const quantityInput = $("#quantity");
        const satuanLabel = $("#satuan-label");
        const remainingStock = $("#remaining-stock");
        const stockWarning = $("#stock-warning");
        const consumableSelect = $("#consumable_id");
        const submitBtn = $("#submit-button"); // pastikan id tombol submit adalah ini
        let currentStock = 0;

        // Ambil value consumable dan quantity lama dari PHP
        const defaultConsumableId = "<?php echo isset($model_info->consumable_id) ? $model_info->consumable_id : ''; ?>";
        const oldQuantity = parseFloat("<?php echo isset($model_info->quantity) ? $model_info->quantity : 0; ?>");

        // Fungsi ambil stok dari server
        function loadStock(consumableId, addOldQuantity = 0) {
            if (!consumableId) {
                satuanLabel.text("");
                remainingStock.text("");
                quantityInput.val("");
                quantityInput.removeAttr("max");
                stockWarning.hide();
                currentStock = 0;
                return;
            }

            $.ajax({
                url: "<?php echo get_uri('purchase/p_invoices/get_info_consumable_stock/'); ?>" + consumableId,
                type: "GET",
                dataType: "json",
                beforeSend: function () {
                    remainingStock.text("Memuat stok...");
                    stockWarning.hide();
                },
                success: function (response) {
                    if (response.success && response.consumable.remaining_stock !== undefined) {
                        // Tambahkan stok lama dari data edit
                        currentStock = parseFloat(response.consumable.remaining_stock) + addOldQuantity;

                        remainingStock.html("Sisa stok: <strong>" + currentStock + "</strong>");
                        quantityInput.attr("max", currentStock);

                        if (currentStock === 0) {
                            stockWarning.text("Stok kosong — Hubungi Admin!").show();
                            quantityInput.prop("disabled", true);
                            submitBtn.prop("disabled", true);
                        } else {
                            stockWarning.hide();
                            quantityInput.prop("disabled", false);
                            submitBtn.prop("disabled", false);
                        }
                    } else {
                        currentStock = 0;
                        remainingStock.text("Sisa stok: -");
                        stockWarning.text("Tidak dapat memuat stok!").show();
                        quantityInput.prop("disabled", true);
                        submitBtn.prop("disabled", true);
                    }
                },
                error: function () {
                    remainingStock.text("Gagal memuat stok");
                    currentStock = 0;
                    quantityInput.removeAttr("max");
                }
            });
        }

        // Saat dropdown berubah
        consumableSelect.on("change", function (e, fromInit = false) {
            const consumableId = $(this).val();
            loadStock(consumableId, fromInit ? oldQuantity : 0);
        });

        // Saat load pertama kali
        if (defaultConsumableId) {
            consumableSelect.val(defaultConsumableId).trigger("change", [true]);
        }

        // Validasi input quantity
        quantityInput.on("input", function () {
            const value = parseFloat($(this).val());
            if (currentStock > 0 && value > currentStock) {
                stockWarning.text("Jumlah melebihi stok tersedia!").show();
            } else {
                stockWarning.hide();
            }
        });

        $("#consumable-form").appForm({
            onSuccess: function (result) {
                location.reload();
                $("#consumables-table").appTable({
                    newData: result.data,
                    dataId: result.id
                });
            }
        });
    });
</script>