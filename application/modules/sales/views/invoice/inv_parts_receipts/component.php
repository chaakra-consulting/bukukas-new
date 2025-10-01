<table style="color: black; width: 100%; border-collapse: collapse;">
    <tr>
        <?php
        $data = array(
            "client_info" => $client_info,
            "color" => $color,
            "invoice_info" => $invoice_info
        );
        ?>
        <td style="width: 25%; vertical-align: top;">
            <?php $this->load->view('inv_parts_receipts/company_logo'); ?>
        </td>
        <td style="width: 50%; text-align: center">
            <span style="font-size:20px;font-weight: bold;">KWITANSI<br></span>
            <span style="font-size:15px;font-weight: bold;">
                <u>No : <?php echo $receipt_code; ?></u><br>
            </span>
            <span style="font-size:15px;font-weight: bold;">
                Hari / Tanggal : <?php echo format_to_date_ina($invoice_payments->payment_date, false, true); ?>            
            </span>
        </td>
        <td style="width: 25%;"></td>
    </tr>
</table>
<br>
<!-- Bagian detail kwitansi -->
<table style="color: black; width:100%; border-collapse:collapse;">
    <tr>
        <td style="width:28%;vertical-align:top;">No. SPK</td>
        <td style="width:2%;text-align:center;">:</td>
        <td style="width:70%;"><?php echo $invoice_info->spk_code; ?></td>
    </tr>
    <tr>
        <td style="width:28%;vertical-align:top;">Sudah Terima Dari</td>
        <td style="width:2%;text-align:center;">:</td>
        <td style="width:70%;"><?php echo $client_info->name; ?></td>
    </tr>
    <tr>
        <td style="white-space:nowrap; vertical-align:top;">Untuk Pembayaran</td>
        <td style="text-align:center; vertical-align:top;">:</td>
        <td>
            <?php echo $post_data->title; 
            if($invoice_info->termin > 1) {?>
            (<?php echo $invoice_total_summary->termin; ?>
            <?php echo $invoice_total_summary->percentage_now; ?>%)
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td style="white-space:nowrap; vertical-align:top;">Total Pembayaran</td>
        <td style="text-align:center; vertical-align:top;">:</td>
        <td>
            <?php   
                // print_r($invoice_total_summary);exit;             
                if($post_data->invoice_pembayaran == 'all'){
                    if($post_data->invoice_pph_type == 'tanpa-pph'){
                        $total = $invoice_total_summary->grand_total_no_pph;
                    }else{
                        $total = $invoice_total_summary->grand_total;
                    }
                } elseif($post_data->invoice_pembayaran == 'termin'){
                    if($post_data->invoice_pph_type == 'tanpa-pph'){
                        $total = $invoice_total_summary->payment_subtotal_termin_no_pph;
                    }else{
                        $total = $invoice_total_summary->payment_subtotal_termin;
                    }
                } else {
                    $total = $invoice_total_summary->grand_total;
                }  
                echo to_terbilang($total, $invoice_total_summary->currency_symbol);      
            ?>
            Rupiah
        </td>
    </tr>
    <br>
    <tr>
        <td style="border:1px solid #000;text-align:center;padding:6px;">
            <b>
            <?php echo to_currency($total, $invoice_total_summary->currency_symbol); ?>
            </b>
        </td>
        <td style="text-align:center; vertical-align:top;">
        </td>
        <td  style="font-size:13px;">
            <?php 
                if($invoice_info->fid_tax == 0){
                    if($invoice_info->potongan && $post_data->invoice_pph_type == 'dengan-pph'){
                        $text = "*Sudah termasuk PPN 11% dan PPH";
                    }else{
                        $text = "*Sudah termasuk PPN 11%";
                    }
                }else{
                    if($invoice_info->potongan && $post_data->invoice_pph_type == 'dengan-pph'){
                        $text = "*Sudah termasuk PPH";
                    }else{
                        $text = "";
                    }
                }
                echo $text;
            ?>
        </td>
    </tr>
</table>