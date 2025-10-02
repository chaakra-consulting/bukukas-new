<?php echo form_open(get_uri("sales/s_invoices/payment_save_edit"), array("id" => "invoice-item-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
   
    <!-- <div class="form-group">
        <label for="invoice_code" class=" col-md-3">No. Invoices</label>
        <div class="col-md-9">
		     <?php 
            echo form_input(array(
                "id" => "invoice_code",
                "name" => "invoice_code",
                "value" => $model_info->invoice_code,
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
                "value" => $model_info->termin,
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
                "value" =>$model_info->payment_date,
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
                
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="total" class=" col-md-3">Total Pembayaran</label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "total",
                "name" => "total",
                "value" => $model_info->total ?? "",
                "class" => "form-control",
                "placeholder" => "0",
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
                "type" => "text",
            ));
            ?>
            <small class="form-text text-muted">
                Maks : <strong><?php echo to_currency($maks_pembayaran); ?></strong>
            </small>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
        function initTotalMask(max) {
        var $total = $('#total');

        // Aktifkan maskMoney sekali saja
        $total.maskMoney({
            precision: 0,
            thousands: '.',
            decimal: ','
        });

        // Ambil nilai murni (angka saja)
        function getRawVal() {
            var v = $total.val() || '';
            v = v.replace(/[^\d]/g, '');
            return v === '' ? 0 : parseInt(v, 10);
        }

        $total.on('keydown', function (e) {
            var key = e.which || e.keyCode;
            if (e.ctrlKey || e.metaKey || key === 8 || key === 46 || key === 9 || (key >= 35 && key <= 40)) return;

            var isDigit = (key >= 48 && key <= 57) || (key >= 96 && key <= 105);
            if (!isDigit) return;

            var digit = (key >= 96) ? key - 96 : key - 48;
            var raw = getRawVal();

            var selStart = this.selectionStart, selEnd = this.selectionEnd || 0;
            var selectionLength = (selEnd - selStart) || 0;

            var next;
            if (selectionLength > 0) {
                var curStr = ($total.val() || '').replace(/[^\d]/g, '');
                var before = curStr.substring(0, selStart);
                var after  = curStr.substring(selEnd);
                var predicted = before + String(digit) + after;
                next = predicted === '' ? 0 : parseInt(predicted, 10);
            } else {
                next = parseInt(String(raw) + String(digit), 10);
            }

            if (next > max) {
                e.preventDefault();
                $total.maskMoney('mask', max);
            }
        });

        $total.on('input paste', function () {
            setTimeout(function () {
                var raw = getRawVal();
                if (raw > max) {
                    $total.maskMoney('mask', max);
                } else {
                    $total.maskMoney('mask', raw);
                }
            }, 0);
        });

        $('#invoice-item-form').on('submit', function () {
            $total.val(getRawVal());
        });
    }

   $(document).ready(function () {
    var max = <?= json_encode((int)$maks_pembayaran) ?>;
    initTotalMask(max);

    $("#invoice-item-form .select2").select2();
    var maxDate = "<?php echo !empty($invoice_info->inv_contract_date) ? date('Y-m-d', strtotime($invoice_info->inv_contract_date)) : ''; ?>";

    if (maxDate) {
        setDatePicker("#payment_date", {
            endDate: maxDate
        });
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