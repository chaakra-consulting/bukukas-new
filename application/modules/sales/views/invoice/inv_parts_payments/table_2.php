<table style="width: 100%; color: black; margin-bottom: 10px; border-collapse: collapse;">            
    <tr style="font-weight: bold; background-color: <?php echo $color; ?>; color: #fff;">
        <th style="width: 40%; border: 1px solid #fff; padding: 10px;">Deskripsi</th>
        <th style="text-align: center; width: 20%; border: 1px solid #fff; padding:6px;">
            Nilai Kontrak
            <?php if ($invoice_total_summary->tax && !$invoice_total_summary->diskon) { ?>
                <br>
                <small>(Sudah termasuk PPN 11%)</small>
            <?php } elseif ($invoice_total_summary->tax && $invoice_total_summary->diskon > 0) { 
                if($post_data->invoice_pph_type == 'dengan-pph') { ?>
                <br>
                <small>(Sudah termasuk PPN 11% + PPH)</small>
                <?php } else { ?>
                <br>
                <small>(Sudah termasuk PPN 11%)</small>
            <?php }
                } elseif (!$invoice_total_summary->tax && $invoice_total_summary->diskon > 0) { ?>
            <br>
            <small>(Sudah termasuk PPH)</small>
            <?php } ?>
        </th>
        <th style="text-align: center; width: 20%; border: 1px solid #fff; padding:6px;">
            Yang Sudah Dibayarkan 
            <?php if($invoice_total_summary->termin != 'Termin 1') { ?>
            <br>
            <small>
                <?php echo $invoice_total_summary->termin_terbayar; ?>
                (<?php echo $invoice_total_summary->percentage_done; ?>%)
            </small>
            <?php } ?>
        </th>
        <th style="text-align: center; width: 20%; border: 1px solid #fff; padding:6px;">
            Penagihan Saat Ini
            <br>
            <small>
                <?php echo $invoice_total_summary->termin; ?>
                (<?php echo $invoice_total_summary->percentage_now; ?>%)
            </small>
        </th>
    </tr> 

    <tr style="background-color: #f4f4f4;">
        <td style="width: 40%; border: 1px solid #fff; padding: 10px;">
            <?php echo $post_data->title; ?>
        </td>
        <?php if ($invoice_total_summary->diskon > 0 && $post_data->invoice_pph_type == 'dengan-pph') { ?> 
            <td style="text-align: right; width: 20%; border: 1px solid #fff; padding:5px;">
                <?php echo to_currency($invoice_total_summary->grand_total, $invoice_total_summary->currency_symbol); ?>
            </td>
            <td style="text-align: right; width: 20%; border: 1px solid #fff; padding:5px;">
                <?php echo to_currency($invoice_total_summary->payment_done_subtotal, $invoice_total_summary->currency_symbol); ?>
            </td>
            <td style="text-align: right; width: 20%; border: 1px solid #fff; padding:5px;">
                <?php echo to_currency($invoice_total_summary->payment_total_termin_no_ppn_with_pph, $invoice_total_summary->currency_symbol); ?>
            </td>
        <?php } else { ?>
            <td style="text-align: right; width: 20%; border: 1px solid #fff; padding:5px;">
                <?php echo to_currency($invoice_total_summary->grand_total_no_pph, $invoice_total_summary->currency_symbol); ?>
            </td> 
            <td style="text-align: right; width: 20%; border: 1px solid #fff; padding:5px;">
                <?php echo to_currency($invoice_total_summary->payment_done_subtotal_no_pph, $invoice_total_summary->currency_symbol); ?>
            </td>
            <td style="text-align: right; width: 20%; border: 1px solid #fff; padding:5px;">
                <?php echo to_currency($invoice_total_summary->payment_total_termin_no_ppn, $invoice_total_summary->currency_symbol); ?>
            </td>
        <?php } ?>
    </tr>
    <?php if ($invoice_total_summary->tax) { ?>
        <!-- <tr style="line-height: 1.2;">
            <td colspan="3" style="text-align: right; padding:4px;"><?php echo $invoice_total_summary->tax_name; ?> 11%</td>
            <td style="text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4; padding:4px;">
                <?php echo to_currency($invoice_total_summary->tax, $invoice_total_summary->currency_symbol); ?>
            </td>
        </tr> -->
    <?php } 
    if ($invoice_total_summary->diskon > 0 && $post_data->invoice_pph_type == 'dengan-pph') {
        if ($invoice_total_summary->tax) { ?>
            <tr style="line-height: 1.2;">
                <td colspan="3" style="text-align: right; padding:4px;"><?php echo $invoice_total_summary->tax_name; ?> 11%</td>
                <td style="text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4; padding:4px;">
                    <?php echo to_currency($invoice_total_summary->payment_ppn_termin_no_ppn_with_pph, $invoice_total_summary->currency_symbol); ?>
                </td>
            </tr>
        <?php } ?>
        <tr style="line-height: 1.2;">
            <td colspan="3" style="text-align: right; padding:4px;">PPH</td>
            <td style="text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4; padding:4px;">
                <?php echo to_currency($invoice_total_summary->payment_pph_termin_no_ppn_with_pph, $invoice_total_summary->currency_symbol); ?>
            </td>
        </tr>
        <tr style="line-height: 1.2;">
            <td colspan="3" style="font-weight: bold; text-align: right; padding:4px;">Total Tagihan</td>
            <td style="font-weight: bold; text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4; padding:4px;">
                <?php echo to_currency($invoice_total_summary->payment_subtotal_termin, $invoice_total_summary->currency_symbol); ?>
            </td>
        </tr> 
    <?php } else { 
        if ($invoice_total_summary->tax) { ?>
            <tr style="line-height: 1.2;">
                <td colspan="3" style="text-align: right; padding:4px;"><?php echo $invoice_total_summary->tax_name; ?> 11%</td>
                <td style="text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4; padding:4px;">
                    <?php echo to_currency($invoice_total_summary->payment_ppn_termin_no_ppn, $invoice_total_summary->currency_symbol); ?>
                </td>
            </tr>
        <?php } ?>
        <tr style="line-height: 1.2;">
            <td colspan="3" style="font-weight: bold; text-align: right; padding:4px;">Total Tagihan</td>
            <td style="font-weight: bold; text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4; padding:4px;">
                <?php echo to_currency($invoice_total_summary->payment_subtotal_termin_no_pph, $invoice_total_summary->currency_symbol); ?>
            </td>
        </tr> 
    <?php } ?>   
</table>
