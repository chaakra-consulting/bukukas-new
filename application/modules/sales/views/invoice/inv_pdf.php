<div style="margin: auto; text-align:center;">

    </div>
    <div style="margin: auto;">
   <?php
    $color = get_setting("invoice_color");
    if (!$color) {
        $color = "#2AA384";
    }
    $invoice_style = get_setting("invoice_style");
    $data = array(
        "client_info" => $client_info,
        "color" => $color,
        "invoice_info" => $invoice_info
    );

    if ($invoice_style === "style_2") {
        $this->load->view('inv_parts/header_style_2.php', $data);
    } else {
        $this->load->view('inv_parts/header_style_1.php', $data);
    }
    ?>
</div>

<br />

<table style="width: 100%; color: #444;">            
    <tr style="font-weight: bold; background-color: <?php echo $color; ?>; color: #fff;  ">
        <th colspan="2" style="width: 60%; border-right: 1px solid #eee;"> <?php echo lang("item"); ?> </th>
        <th style="text-align: right;  width: 20%; border-right: 1px solid #eee;"> <?php echo lang("rate"); ?></th>
        <th style="text-align: right;  width: 20%; "> <?php echo lang("total"); ?></th>
    </tr>
    <?php

    foreach ($invoice_items as $item) { ?>
       
        <tr style="background-color: #f4f4f4; ">
            <td colspan="2" style="width: 60%; border: 1px solid #fff; padding: 10px;"><?php echo $item->title; ?>
            </td>
            <td style="text-align: right; width: 20%; border: 1px solid #fff;"> <?php echo to_currency($item->rate ); ?></td>
            <td style="text-align: right; width: 20%; border: 1px solid #fff;"> <?php echo to_currency($item->total); ?></td>
        </tr>
   
   <?php  }  ?>
    <tr>
        <td colspan="3" style="text-align: right;"><?php echo lang("total"); ?></td>
        <td style="text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4;">
            <?php echo to_currency($invoice_total_summary->invoice_subtotal, $invoice_total_summary->currency_symbol); ?>
        </td>
    </tr>
    <?php if ($invoice_total_summary->tax) { ?>
        <tr>
            <td colspan="3" style="text-align: right;"><?php echo $invoice_total_summary->tax_name; ?></td>
            <td style="text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4;">
                <?php echo to_currency($invoice_total_summary->tax, $invoice_total_summary->currency_symbol); ?>
            </td>
        </tr>
    <?php } ?>

    <?php if ($invoice_total_summary->diskon > 0) { ?>
        <tr>
            <td colspan="3" style="text-align: right;">PPH</td>
            <td style="text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4;">
                <?php echo to_currency($invoice_total_summary->potongan, $invoice_total_summary->currency_symbol); ?>
            </td>
        </tr>
    <?php } ?>
    
        <tr>
            <td colspan="3" style="text-align: right;">Grand Total</td>
            <td style="text-align: right; width: 20%; border: 1px solid #fff; background-color: #f4f4f4;">
                <?php echo to_currency($invoice_total_summary->grand_total, $invoice_total_summary->currency_symbol); ?>
            </td>
        </tr>   
    
</table>
<div style="height: 60px; width: 100%;"></div>
<div style="font-weight: bold; color: black; margin-bottom: 40px;">
    <span style="font-weight: bold; color: black;">Catatan.</span><br>
    <span style="font-weight: bold; color: black;">Pembayaran dapat dilakukan melalui Rekening Bank Central Asia (BCA).
</span><br>

    <span style="font-weight: bold; color: black;">No Rek 	: 4290737856 (An. Herlina Eka Subandriyo Putri)</span>
</div>
<div style="height: 60px; width: 100%;"></div>
<table style="margin-top: 80px; text-align: right; background-color: #fff; padding: 20px; border-radius: 20px; margin-left: auto; margin-right: auto; max-width: 600px;">
    <tr>
        <td style="vertical-align: right;">
            <p style="font-weight: bold; margin: 10px;">Mengetahui Direktur</p>
            <div style="height: 10px;"></div>
            <a>
                <img src="https://bukukas.chaakra-consulting.com/assets/images/ttd1.png" width="240" height="100" alt="">
            </a>
            <p style="margin: 40px 10px; line-height: 1.5; color: #555;">Herlina Eka Subandriyo Putri., M.Psi.,Psikolog</p>
        </td>
    </tr>
</table>

    </table>

