<div id="page-content" class="clearfix">
    <div style="max-width: 1000px; margin: auto;">
        <div class="page-title clearfix mt15">
            <h1> No Akun : <?php echo $invoice_info->code; ?>
                
            </h1>
            <div class="title-button-group">
                <span class="dropdown inline-block">
                    <button class="btn btn-info dropdown-toggle  mt0 mb0" type="button" data-toggle="dropdown" aria-expanded="true">
                        <i class='fa fa-cogs'></i> <?php echo lang('actions'); ?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        
                        <li role="presentation"><?php echo anchor(get_uri("purchase/p_invoices/download_pdf/" . $invoice_info->id), "<i class='fa fa-download'></i> " . lang('download_pdf'), array("title" => lang('download_pdf'))); ?> </li>
                        <li role="presentation"><?php echo anchor(get_uri("purchase/p_invoices/preview/" . $invoice_info->id), "<i class='fa fa-search'></i> " . 'Preview', array("title" => 'Preview'), array("target" => "_blank")); ?> </li>
                        <li role="presentation" class="divider"></li>
                        <?php if($invoice_info->status != "paid"){ ?>
                        <li role="presentation"><?php echo modal_anchor(get_uri("purchase/p_invoices/modal_form_edit"), "<i class='fa fa-edit'></i> " . 'Edit Pembelian', array("title" => 'Edit Pembelian', "data-post-id" => $invoice_info->id, "role" => "menuitem", "tabindex" => "-1")); ?> </li>

                        <?php } ?>
                    </ul>
                        </span>
                <?php if($invoice_info->paid != "paid" && $invoice_info->status != "posting" && $invoice_info->is_verified !== "1") echo modal_anchor(get_uri("purchase/p_invoices/item_modal_form"), "<i class='fa fa-plus-circle'></i> " . 'Tambah Barang', array("class" => "btn btn-default", "title" => 'Tambah Barang', "data-post-invoice_id" => $invoice_info->id)); ?>            </div>
        </div>

        <div id="invoice-status-bar">
            <?php $this->load->view("invoice/inv_status_bar"); ?>
        </div>

        

        <div class="mt15">
            <div class="panel panel-default p15 b-t">
                <div class="clearfix p20">
                    <!-- small font size is required to generate the pdf, overwrite that for screen -->
                    <style type="text/css"> .invoice-meta {font-size: 100% !important;}</style>

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
                        
                    );

                    if ($invoice_style === "style_2") {
                        $this->load->view('inv_parts/header_style_2.php', $data);
                    } else {
                        $this->load->view('inv_parts/header_style_1.php', $data);
                    }
                    ?>
                </div>

                <div class="table-responsive mt15 pl15 pr15">
                    <table id="invoice-item-table" class="display" width="100%">            
                    </table>
                </div>

                <div class="clearfix">
                    <div class="col-sm-8">

                    </div>
                    <div class="col-sm-4" id="invoice-total-section">
                        <?php $this->load->view("invoice/inv_total_section"); ?>
                    </div>
                </div>

            </div>
        </div>


        

           
    </div>
</div>



<script type="text/javascript">
    // window.onload = updateInvoiceStatusBar();
    RELOAD_VIEW_AFTER_UPDATE = true;
    $(document).ready(function () {
        $("#invoice-item-table").appTable({
            source: '<?php echo_uri("purchase/p_invoices/item_list_data/". $invoice_info->id) ?>',
            order: [[0, "asc"]],
            hideTools: true,
            columns: [
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w100"},
                {title: 'Nama Barang'},              
                {title: 'Qty.', "class": "text-right w15p"},
                {title: 'Harga beli', "class": "text-right w15p"},
                {title: 'Total', "class": "text-right w15p"}
            ],
            onDeleteSuccess: function (result) {
                $("#invoice-total-section").html(result.invoice_total_view);
                if (typeof updateInvoiceStatusBar == 'function') {
                    updateInvoiceStatusBar(result.invoice_id);
                }
            },
            onUndoSuccess: function (result) {
                $("#invoice-total-section").html(result.invoice_total_view);
                if (typeof updateInvoiceStatusBar == 'function') {
                    updateInvoiceStatusBar(result.invoice_id);
                }
            }
        });

        
    });

    updateInvoiceStatusBar = function (invoiceId) {
        $.ajax({
            url: "<?php echo get_uri("sales/s_invoices/get_invoice_status_bar"); ?>/" + invoiceId,
            success: function (result) {
                if (result) {
                    $("#invoice-status-bar").html(result);
                }
            }
        });
    };


</script>

<?php
//required to send email 

load_css(array(
    "assets/js/summernote/summernote.css",
));
load_js(array(
    "assets/js/summernote/summernote.min.js",
));
?>

