<!-- <br><br> -->
<table style="color: black; width: 100%;">
    <tr>
        <td style="width: 45%; vertical-align: top;">
            <?php $this->load->view('inv_parts_payments/company_logo'); ?>
        </td>
        <td style="width: 20%;"></td>
        <td style="width: 35%;"></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td style="vertical-align: top; text-align: right ">
            <?php
            $data = array(
                "client_info" => $client_info,
                "color" => $color,
                "invoice_info" => $invoice_info,
                "invoice_total_summary" => $invoice_total_summary,
            );
            $this->load->view('inv_parts_payments/invoice_info', $data);
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="4" style="text-align:center;">
            <span style="font-size:18px;font-weight: bold;">
                <u>No : <?php echo $invoice_total_summary->invoice_code; ?></u>
            </span>
        </td>
    </tr>


    <!-- spacer -->
    <tr>
        <td style="padding: 5px;"></td>
        <td></td>
        <td></td>
    </tr>

    <!-- bill_from -->
    <tr>
        <td>
            <?php $this->load->view('inv_parts_payments/bill_from_to', $data); ?>
        </td>
        <td></td>
       
    </tr>
    <!-- <tr>

        <td><?php

            //$this->load->view('inv_parts_payments/bill_from', $data);

            ?>

        </td>

        <td></td>

        <td><?php

            //$this->load->view('inv_parts_payments/bill_to', $data);

            ?>

        </td>

    </tr> -->

</table>
