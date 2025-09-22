<?php echo form_open(get_uri("sales/s_invoices/save_edit"), array("id" => "invoice-item-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
   
    <div class="form-group">
        <label for="invoice_item_title" class=" col-md-3">Project</label>
        <div class="col-md-9">
		     <?php 
            echo form_input(array(
                "id" => "invoice_item_title",
                "name" => "invoice_item_title",
                "value" => $model_info->title,
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
                "value" => $model_info->rate ? to_decimal_format($model_info->rate) : "",
                "class" => "form-control",
                "placeholder" => "0",
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
    $('#invoice_item_rate').maskMoney({
        precision: 0
    });

    $('input[name=invoice_item_rate]').change(function () {
        var value = $(this).val();
        // Tambahkan logika sesuai kebutuhan
    });

    $("#invoice-item-form .select2").select2();
    $("#invoice-item-form").appForm({
        onSuccess: function (result) {
            location.reload();
            $("#invoice-item-table").appTable({
                newData: result.data,
                dataId: result.id
            });
            $("#invoice-total-section").html(result.invoice_total_view);
            if (typeof updateInvoiceStatusBar == 'function') {
                updateInvoiceStatusBar(result.invoice_id);
            }
        }
    });
});

 

</script>