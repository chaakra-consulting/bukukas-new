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
   
    <input type="hidden" name="fid_item" id="fid_item" >
    <div class="form-group">
        <label for="invoice_item_quantity" class=" col-md-3">Jumlah</label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "invoice_item_quantity",
                "name" => "invoice_item_quantity",
                "value" => $model_info->quantity ? to_decimal_format($model_info->quantity) : "",
                "class" => "form-control",
                "placeholder" => lang('quantity'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>
    
     <div class="form-group">
        <label for="invoice_item_basic" class=" col-md-3">Harga</label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "invoice_item_basic",
                "name" => "invoice_item_basic",
                "value" => $model_info->basic_price ? to_decimal_format($model_info->basic_price) : "",
                "class" => "form-control",
                "placeholder" => "0",
                // "type" => 'number'
            ));
            ?>
        </div>
    </div> 
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        // $('#invoice_item_basic').maskMoney(
        //     {precision:0 
        // });
        $('#invoice_item_rate').maskMoney(
            {precision:0 
        });
        
        $('input[name=invoice_item_rate]').change(function() {
            var value = $(this).val();
            
        });
        $("#invoice-item-form .select2").select2();
        $("#invoice-item-form").appForm({
            onSuccess: function (result) {
                $("#invoice-item-table").appTable({newData: result.data, dataId: result.id});
                $("#invoice-total-section").html(result.invoice_total_view);
                if (typeof updateInvoiceStatusBar == 'function') {
                    updateInvoiceStatusBar(result.invoice_id);
                }
            }
        });
    });
</script>