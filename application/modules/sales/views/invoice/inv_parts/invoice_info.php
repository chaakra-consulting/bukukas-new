<span style="font-size:16px;font-weight: bold;"><u>INVOICES</u><br></span>
<span style="font-size:16px;font-weight: bold;"><?php echo $invoice_info->no_inv; ?></span>

<div style="line-height: 10px;"></div>

<span><?php // echo lang("bill_date") . ": " . format_to_date($invoice_info->created_at, false); ?></span><br />

<strong><span><?php echo "Tanggal Invoices" . ": " . format_to_date($invoice_info->inv_date, false); ?></span></strong>

