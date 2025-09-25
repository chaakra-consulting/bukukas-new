<div id="page-content" class="p20 clearfix">
    <?php
    load_css(array(
        "assets/css/invoice.css",
    ));
    ?>

    <div class="invoice-preview">
            <div class="panel panel-default  p15 no-border clearfix">                
                <!-- <div class="pull-right">
                    <?php
                    echo "<div class='text-center'>" . anchor("sales/s_invoices/download_pdf_payment/" . $invoice_info->id, lang("download_pdf"), array("class" => "btn btn-default round")) . "</div>"
                    ?>
                </div> -->
                <div class="pull-right">
                    <form method="post" action="<?php echo get_uri("sales/s_invoices/download_pdf_payment/" . $invoice_info->id); ?>">
                        <input type="hidden" name="invoice_id" value="<?php echo $model_info->fid_sales_invoice; ?>" />
                        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
                        <?php foreach ($post_data as $key => $value) { ?>
                            <?php if ($key === 'description'): ?>
                                <!-- Gunakan textarea agar HTML panjang/bertag tidak hilang -->
                                <textarea type="hidden" name="description" hidden><?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?></textarea>
                            <?php else: ?>
                            <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>">
                            <?php endif; ?>
                        <?php } ?>                      
                        <button type="submit" class="btn btn-default round">
                            <?php echo lang("download_pdf"); ?>
                        </button>
                    </form>
                </div>
            </div>
            <?php
        

        if ($show_close_preview)
            echo "<div class='text-center'>" . anchor("sales/s_invoices/view/" . $invoice_info->id, lang("close_preview"), array("class" => "btn btn-default round")) . "</div>"
            ?>

        <div class="bg-white mt15 p30">
            <div class="col-md-12">
                <div class="ribbon"><?php echo $invoice_status_label; ?></div>
            </div>

            <?php
            echo $invoice_preview;
            ?>
        </div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#payment-amount").change(function () {
            var value = $(this).val();
            $(".payment-amount-field").each(function () {
                $(this).val(value);
            });
        });
    });



</script>
