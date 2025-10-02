<table style="width: 100%; color: black; margin-bottom: 10px; border-collapse: collapse;">            
    <tr style="font-weight: bold; background-color: <?php echo $color; ?>; color: #fff; line-height: 1.2;">
        <!-- <th style="width: 5%; border: 1px solid #fff; text-align:center; padding:5px;"> <?php echo 'No.' ?> </th> -->
        <th style="width: 55%; border: 1px solid #fff; padding:5px;"> <?php echo 'Deskripsi' ?> </th>
        <th style="text-align: right; width: 20%; border: 1px solid #fff; padding:5px;"> <?php echo 'Nilai' ?></th>
        <th style="text-align: right; width: 20%; border: 1px solid #fff; padding:5px;"> <?php echo 'Jumlah' ?></th>
    </tr> 
    <?php 
        $no = 1; 
        foreach ($invoice_items as $item) { ?>           
            <tr style="background-color: #f4f4f4; line-height: 1.2;">
                <!-- <td style="width: 5%; border: 1px solid #fff; text-align:center; padding:4px;">
                    <?php echo $no++; ?>
                </td> -->
                <td style="width: 55%; border: 1px solid #fff; padding:4px;">
                    <?php echo $item->title; ?>
                </td>
                <td style="text-align: right; width: 20%; border: 1px solid #fff; padding:4px;">
                    <?php echo to_currency($item->rate ); ?>
                </td>
                <td style="text-align: right; width: 20%; border: 1px solid #fff; padding:4px;">
                    <?php echo to_currency($item->total); ?>
                </td>
            </tr>       
    <?php } ?>
    <!-- <?php if ($invoice_total_summary->tax || $invoice_total_summary->diskon > 0) { ?>
        <tr style="line-height: 1.2;">
            <td colspan="3" style="text-align: right; padding:4px;"><?php echo lang("total"); ?></td>
            <td style="text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4; padding:4px;">
                <?php echo to_currency($invoice_total_summary->invoice_subtotal, $invoice_total_summary->currency_symbol); ?>
            </td>
        </tr>
    <?php } ?> -->
    <?php if ($invoice_total_summary->tax) { ?>
        <tr style="line-height: 1.2;">
            <td colspan="2" style="text-align: right; padding:4px;"><?php echo $invoice_total_summary->tax_name; ?> 11%</td>
            <td style="text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4; padding:4px;">
                <?php echo to_currency($invoice_total_summary->tax, $invoice_total_summary->currency_symbol); ?>
            </td>
        </tr>
    <?php } 
        if ($invoice_total_summary->diskon > 0 && $post_data->invoice_pph_type == 'dengan-pph') { ?>  
        <tr style="line-height: 1.2;">
            <td colspan="2" style="text-align: right; padding:4px;">PPH</td>
            <td style="text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4; padding:4px;">
                <?php echo to_currency($invoice_total_summary->potongan, $invoice_total_summary->currency_symbol); ?>
            </td>
        </tr>
        <tr style="line-height: 1.2;">
            <td colspan="2" style="font-weight: bold; text-align: right; padding:4px;">Grand Total</td>
            <td style="font-weight: bold; text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4; padding:4px;">
                <?php echo to_currency($invoice_total_summary->grand_total, $invoice_total_summary->currency_symbol); ?>
            </td>
        </tr>   
    <?php } else { ?>
        <tr style="line-height: 1.2;">
            <td colspan="2" style="font-weight: bold; text-align: right; padding:4px;">Grand Total</td>
            <td style="font-weight: bold; text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4; padding:4px;">
                <?php echo to_currency($invoice_total_summary->grand_total_no_pph, $invoice_total_summary->currency_symbol); ?>
            </td>
        </tr>   
    <?php } ?>
</table>
