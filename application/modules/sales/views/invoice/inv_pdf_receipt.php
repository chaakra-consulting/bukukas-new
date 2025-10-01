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
        "invoice_total_summary" => $invoice_total_summary,
        "receipt_code" => $receipt_code,
    );
    $this->load->view('inv_parts_receipts/component.php', $data);
    ?>
</div>
<div style="color:black;">
    <!-- <div style="height: 20px; width: 100%;"></div> -->
    <table style="background-color: #fff; padding: 20px; border-radius: 20px; margin-right: 0; max-width: 600px; width: 100%;">
        <tr>
            <td style="text-align: left;">
                <div style="display: inline-block; text-align: center;">
                    <p style="margin: 0;">Mengetahui,</p>
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