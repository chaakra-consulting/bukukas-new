<?php echo form_open(get_uri("sales/s_invoices/payment_add"), array("id" => "invoice-item-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="fid_sales_invoice" value="<?php echo $invoice_id; ?>" />
   
    <!-- <div class="form-group">
        <label for="invoice_code" class=" col-md-3">No. Invoices</label>
        <div class="col-md-9">
		    <?php 
            echo form_input(array(
                "id" => "invoice_code",
                "name" => "invoice_code",
                // "value" => $model_info->invoice_code,
                "class" => "form-control validate-hidden",
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            )); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="termin" class=" col-md-3">Termin</label>
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
    </div> -->
    <div class="form-group">
        <label for="payment_date" class="col-md-3">Tanggal Pembayaran</label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "payment_date",
                "name" => "payment_date",
                "class" => "form-control",
                "autocomplete" => "off",
                // "value" =>$model_info->payment_date,
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
                
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="total" class="col-md-3">Total Pembayaran</label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "total",
                "name" => "total",
                "class" => "form-control",
                "placeholder" => "0",
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
                "type" => "text",
            ));
            ?>
            <small class="form-text text-muted">
                Sisa pembayaran: <strong><?php echo to_currency($invoice_total_summary->payment_sisa); ?></strong>
            </small>
            <!-- <?php if($invoice_info->potongan > 0) { ?>
            <br>
            <small class="form-text text-muted">
                Sisa pembayaran Tanpa PPH: <strong><?php echo to_currency($invoice_total_summary->payment_sisa_no_pph); ?></strong>
            </small>
            <?php } ?> -->
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
    // 1. Ensure max is a float
    var max = parseFloat(<?= json_encode((float)$invoice_total_summary->payment_sisa) ?>) || 0;
    var $total = $('#total');

    // 2. Initialize maskMoney
    $total.maskMoney({
        precision: 3,
        thousands: '.',
        decimal: ',',
        allowZero: true
    });

    // 3. Helper to get pure math value
    function getRawVal() {
        var v = $total.val() || '';
        v = v.split('.').join(''); // Remove thousand separators
        v = v.replace(',', '.');   // Swap comma for dot for JS math
        var parsed = parseFloat(v);
        return isNaN(parsed) ? 0 : parsed;
    }

    // 4. Set Initial Value
    var initialRaw = getRawVal();
    if (initialRaw > 0) {
        $total.maskMoney('mask', initialRaw);
    }

    // 5. Clamp logic (Removed 'input' to prevent wiping the comma mid-typing)
    $total.on('keyup blur', function () {
        var raw = getRawVal();
        if (raw > max) {
            $total.maskMoney('mask', max);
        }
    });

    // 6. Strip formatting before sending to the server
    $('#invoice-item-form').on('submit', function () {
        var raw = getRawVal();
        $total.val(raw); 
    });

    // --- Rest of your UI initialization ---
    $("#invoice-item-form .select2").select2();
    var maxDate = "<?php echo !empty($invoice_info->inv_contract_date) ? date('Y-m-d', strtotime($invoice_info->inv_contract_date)) : ''; ?>";

    if (maxDate) {
        setDatePicker("#payment_date", { endDate: maxDate });
    } else {
        setDatePicker("#payment_date");
    }

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