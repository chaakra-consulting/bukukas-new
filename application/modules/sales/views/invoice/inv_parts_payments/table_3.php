<table style="width: 100%; color: black; margin-bottom: 10px; border-collapse: collapse;">            
    <tr style="font-weight: bold; background-color: <?php echo $color; ?>; color: #fff; line-height: 1.3;">
        <th style="width: 55%; border: 1px solid #fff; padding:6px;">Deskripsi</th>
        <th style="text-align: right; width: 20%; border: 1px solid #fff; padding:6px;">Satuan</th>
        <th style="text-align: right; width: 20%; border: 1px solid #fff; padding:6px;">Jumlah</th>
    </tr> 

    <tr style="background-color: #f4f4f4; line-height: 1.3;">
        <td style="width: 55%; border: 1px solid #fff; padding:5px;">
            <?php echo $post_data->title; ?>
        </td>
        <td style="text-align: right; width: 20%; border: 1px solid #fff; padding:5px;">
            <?php 
                $total_satuan = $post_data->satuan ? $invoice_total_summary->invoice_subtotal / $post_data->satuan : 0;
                echo to_currency($total_satuan, $invoice_total_summary->currency_symbol); 
            ?>
        </td>
        <td style="text-align: right; width: 20%; border: 1px solid #fff; padding:5px;">
            <?php echo to_currency($invoice_total_summary->invoice_subtotal, $invoice_total_summary->currency_symbol); ?>
        </td>
    </tr>
    
    <?php if ($invoice_total_summary->tax) { ?>
        <tr style="line-height: 1.3;">
            <td colspan="2" style="text-align: right; padding:5px;"><?php echo $invoice_total_summary->tax_name; ?> 11%</td>
            <td style="text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4; padding:5px;">
                <?php echo to_currency($invoice_total_summary->tax, $invoice_total_summary->currency_symbol); ?>
            </td>
        </tr>
    <?php } ?>
    <?php if ($invoice_total_summary->diskon > 0 && $post_data->invoice_pph_type == 'dengan-pph') { ?>
        <tr style="line-height: 1.3;">
            <td colspan="2" style="text-align: right; padding:5px;">PPH</td>
            <td style="text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4; padding:5px;">
                <?php echo to_currency($invoice_total_summary->potongan, $invoice_total_summary->currency_symbol); ?>
            </td>
        </tr>    
    <tr style="line-height: 1.3;">
        <td colspan="2" style="font-weight: bold; text-align: right; padding:5px;">Grand Total</td>
        <td style="font-weight: bold; text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4; padding:5px;">
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
