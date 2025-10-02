<table id="quotation-item-table" class="table display dataTable text-right strong table-responsive">     
    <?php if ($invoice_total_summary->tax > 1 || $invoice_total_summary->diskon > 0) { ?>
    <tr>
        <td><?php echo lang("sub_total"); ?></td>
        <td><?php echo to_currency($invoice_total_summary->invoice_subtotal, $invoice_total_summary->currency_symbol); ?></td>
    </tr>
    <?php } ?>
    <?php if ($invoice_total_summary->tax > 1) { ?>
        <tr>
            <td><?php echo $invoice_total_summary->tax_name; ?></td>
            <td><?php echo to_currency($invoice_total_summary->tax, $invoice_total_summary->currency_symbol); ?></td>
        </tr>
    <?php } ?>

    <?php if ($invoice_total_summary->diskon > 0) { ?>
        <!-- <tr>
            <td>Grand Total Tanpa PPH</td>
            <td><?php echo to_currency($invoice_total_summary->grand_total_no_pph, $invoice_total_summary->currency_symbol); ?></td>
        </tr> -->
        <tr>
            <td>PPH</td>
            <td><?php echo to_currency($invoice_total_summary->potongan, $invoice_total_summary->currency_symbol); ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td>Grand Total</td>
        <td><?php echo to_currency($invoice_total_summary->grand_total, $invoice_total_summary->currency_symbol); ?></td>
    </tr>
    <tr>
        <td>Total Terbayar</td>
        <td><?php echo to_currency($invoice_total_summary->payment_subtotal, $invoice_total_summary->currency_symbol); ?></td>
    </tr>
</table>