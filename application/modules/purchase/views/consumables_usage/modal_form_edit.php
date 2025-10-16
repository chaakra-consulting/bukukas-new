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

        const consumableSelect = $("#consumable_id");
        const satuanLabel = $("#satuan-label");

        function loadSatuan(consumableId) {
            if (!consumableId) {
                satuanLabel.text("");
                return;
            }

            $.ajax({
                url: "<?php echo get_uri('purchase/p_invoices/get_info_consumables/') ?>" + consumableId,
                type: "GET",
                dataType: "json",
                beforeSend: function () {
                    satuanLabel.text("Loading...");
                },
                success: function (response) {
                    if (response.success && response.cust && response.cust.satuan) {
                        satuanLabel.text(response.cust.satuan);
                    } else {
                        satuanLabel.text("-");
                    }
                },
                error: function () {
                    satuanLabel.text("Error");
                }
            });
        }

        // Trigger AJAX saat dropdown berubah
        consumableSelect.on("change", function () {
            loadSatuan($(this).val());
        });

        // Jalankan sekali saat halaman pertama kali load, kalau sudah ada value
        const initialConsumableId = consumableSelect.val();
        if (initialConsumableId) {
            loadSatuan(initialConsumableId);
        }

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