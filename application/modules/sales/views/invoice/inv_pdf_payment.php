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
        "invoice_info" => $invoice_info,
        "model_info" => $model_info,
        "post_data" => $post_data,
        "invoice_total_summary" => $invoice_total_summary
    );
    // print_r($invoice_total_summary);exit;
    if ($invoice_style === "style_2") {
        $this->load->view('inv_parts_payments/header_style_2.php', $data);
    } else {
        $this->load->view('inv_parts_payments/header_style_1.php', $data);
    }
    ?>
</div>
<div style="color:black;">
<!-- <br/> -->
    <div style="line-height:1.5;">
        <?php
        $html = (string) $post_data->description;
        if (preg_match('/<p[^>]*>/i', $html)) {
            $html = preg_replace(
                '/<p([^>]*)style="([^"]*)"/i',
                '<p$1style="$2; text-indent:40px; margin-top:0; margin-bottom:0px;"',
                $html,
                1,
                $count
            );
            if ($count === 0) {
                $html = preg_replace(
                    '/<p([^>]*)>/i',
                    '<p$1 style="text-indent:40px; margin-top:0; margin-bottom:0px;">',                    
                    $html,
                    1
                );
            }
        } else {
            $html = '<p style="text-indent:40px; margin-top:0; margin-bottom:0px;">' . $html . '</p>';
        }
        echo $html;
        ?>
    </div>
    <?php
        // print_r($post_data);exit;
        if($post_data->invoice_type == 'normal' && $post_data->invoice_pembayaran == 'all') $this->load->view('inv_parts_payments/table_1.php', $data);
        elseif($post_data->invoice_type == 'normal' && $post_data->invoice_pembayaran == 'termin') $this->load->view('inv_parts_payments/table_2.php', $data);
        elseif($post_data->invoice_type == 'rincian') $this->load->view('inv_parts_payments/table_3.php', $data);
    ?>
    <div style="color: black; margin-bottom: 5px;">
        <span style="color: black;"><b>Terbilang : </b>
            <?php
                if ($post_data->invoice_type == 'normal' && $post_data->invoice_pembayaran == 'termin') {
                    if($invoice_info->potongan > 0){
                        if ($post_data->invoice_pph_type == 'tanpa-pph') {
                            echo to_terbilang($invoice_total_summary->payment_subtotal_termin_no_pph);
                        } else {
                            echo to_terbilang($invoice_total_summary->payment_subtotal_termin);
                        }
                    }else{
                        echo to_terbilang($invoice_total_summary->payment_subtotal_termin);
                    }
                }else{
                    if($post_data->invoice_pph_type == 'tanpa-pph'){
                        echo to_terbilang($invoice_total_summary->grand_total_no_pph);
                    }else{
                        echo to_terbilang($invoice_total_summary->grand_total);
                    }
                }
            ?> Rupiah
        </span>

        <?php if ($post_data->note) { ?>
            <div style="margin-top: 8px;"></div>
            <span style="color: black;">Notes :
                <?php echo $post_data->note ?>
            </span>
        <?php } ?>

        <div style="margin-top: 8px;"></div>

        <?php if ($post_data->invoice_rekening == 'bsi-herlina') { ?>
        <span style="color: black;">Pembayaran dapat dilakukan melalui Rekening Bank Syariah Indonesia (BSI).</span>
        <br>
        <span style="color: black;">No Rek 	: <b>7138737793</b> (An. Herlina Eka Subandriyo Putri)</span>
        <?php } elseif ($post_data->invoice_rekening == 'bjt-chaakralogi') { ?>
        <span style="color: black;">Pembayaran dapat dilakukan melalui Rekening Bank JATIM.</span>
        <br>
        <span style="color: black;">No Rek 	: <b>0011286267</b> (An. CV CHAAKRALOGI)</span>
        <?php } else { ?>
        <span style="color: black;">Pembayaran dapat dilakukan melalui Rekening Bank Central Asia (BCA).</span>
        <br>
        <span style="color: black;">No Rek 	: <b>4290737856</b> (An. Herlina Eka Subandriyo Putri)</span>
        <?php } ?>
    </div>
    <!-- <div style="height: 20px; width: 100%;"></div> -->
    <table style="background-color: #fff; padding: 10px; border-radius: 20px; margin-left: auto; margin-right: 0; max-width: 600px; width: 100%;">
        <tr>
            <td style="text-align: right;">
                <div style="display: inline-block; text-align: center;">
                    <p style="margin: 0;">Hormat Kami,</p>
                    <div style="height: 10px;"></div>
                    <!-- Jika mau pakai tanda tangan -->
                    <!--
                    <img src="https://bukukas.chaakra-consulting.com/assets/images/ttd1.png" width="240" height="100" alt="">
                    -->
                    <p style="font-weight: bold; color: black; margin: 80px 0 0 0; line-height: 1.5;">
                        <u>Herlina Eka Subandriyo Putri., M.Psi., Psikolog</u>
                    </p>
                    <p style="color: black; line-height: 1.5; margin-top: -3px">
                        Direktur
                    </p>
                </div>
            </td>
        </tr>
    </table>
</div>