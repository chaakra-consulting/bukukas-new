<?php echo form_open(get_uri("sales/s_invoices/payment_verifikasi"), array("id" => "invoice-item-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>"/>
    <input type="hidden" name="fid_sales_invoice" value="<?php echo $invoice_id; ?>"/>
    <div class="form-group">
        <label for="bukti" class=" col-md-3">Upload Bukti
             <!-- <br> <p style="color:red;"> format pdf </p> -->
        </label>
        <div class="col-md-9">
        <?php
            // print_r($invoice_id);exit;
            echo form_input(array(
                "id" => "bukti",
                "name" => "bukti",
                "class" => "form-control",
                "type" => "file"
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