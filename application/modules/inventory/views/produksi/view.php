<div id="page-content" class="clearfix">
    <div style="max-width: 1000px; margin: auto;">
        <div class="page-title clearfix mt15">
            <h1> Produksi <?php echo get_order_id($data_info->code); ?>
                
            </h1>
            <div class="title-button-group">
 
                 <?php echo modal_anchor(get_uri("inventory/produksi/item_modal_form/".$data_info->id), "<i class='fa fa-plus-circle'></i> Tambah Bahan Material", array("class" => "btn btn-default", "title" => 'Tambah Bahan Material', "data-post-invoice_id" => $data_info->id)); ?>
                 <?php echo modal_anchor(get_uri("inventory/produksi/jadi_modal_form/".$data_info->id), "<i class='fa fa-plus-circle'></i> Tambah Barang Jadi", array("class" => "btn btn-default", "title" => 'Tambah Barang Jadi', "data-post-invoice_id" => $data_info->id)); ?>
				<?php /*
				  <span class="dropdown inline-block">
                    <button class="btn btn-info dropdown-toggle  mt0 mb0" type="button" data-toggle="dropdown" aria-expanded="true">
                        <i class='fa fa-cogs'></i> <?php echo lang('actions'); ?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        
                        <li role="presentation"><?php echo anchor(get_uri("purchase/p_order/download_pdf/" . $data_info->id), "<i class='fa fa-download'></i> " . lang('download_pdf'), array("title" => lang('download_pdf'))); ?> </li>
                        <li role="presentation"><?php echo anchor(get_uri("purchase/p_order/preview/" . $data_info->id ), "<i class='fa fa-search'></i> " . lang('invoice_preview'), array("title" => lang('invoice_preview')), array("target" => "_blank")); ?> </li>
                        <li role="presentation" class="divider"></li>
                        <li role="presentation"><?php echo modal_anchor(get_uri("purchase/p_order/modal_form_edit"), "<i class='fa fa-edit'></i> " . lang('edit_invoice'), array("title" => lang('edit_invoice'), "data-post-id" => $data_info->id, "role" => "menuitem", "tabindex" => "-1")); ?> </li>

                        
                    </ul>
                </span> 
				*/ ?>
            </div>
			
        </div>

        <div id="invoice-status-bar">
            
        </div>

        

        <div class="mt15">
            <div class="panel panel-default p15 b-t">
               <div class="clearfix p20">
                    <div class="col-sm-12">
                        <table style="font-size:14px;width:100%;">
                             
                            <tr>
                                <td style="width:20%;"><b>Tanggal Produksi</b></td>
                                <td><b>:</b></td>
                                <td> <?php echo format_to_date($data_info->pr_tanggal,true) ?></td>
                            </tr>
                            <tr>
                                <td><b>Keterangan</b></td>
                                <td><b>:</b></td>
                                <td> <?php echo $data_info->pr_keterangan;?></td>
                            </tr>
                        </table>
                    </div> 
                </div>
				<br/>
				<b><h4>Bahan Material</h4></b><br/>
				 
                <div class="table-responsive mt15 pl15 pr15">
                    <table id="bahan-item-table" class="display" width="100%">            
                    </table>
                </div>
				<br/>
				<b><h4>Barang Jadi</h4></b><br/>
                <div class="table-responsive mt15 pl15 pr15">
                    <table id="jadi-item-table" class="display" width="100%">            
                    </table>
                </div>

                <div class="clearfix">
                    <div class="col-sm-8">

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
        $("#bahan-item-table").appTable({
            source: '<?php echo_uri("inventory/produksi/item_list_data_bahan/". $data_info->id) ?>',
            order: [[0, "asc"]],
            hideTools: true,
            columns: [
                {title: '<?php echo lang("item") ?> '},
                {title: '<?php echo lang("quantity") ?>', "class": "text-right w15p"}, 
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w100"}
            ],
            onDeleteSuccess: function (result) {
                $("#order-total-section").html(result.invoice_total_view);
                if (typeof updateInvoiceStatusBar == 'function') {
                    updateInvoiceStatusBar(result.invoice_id);
                }
            },
            onUndoSuccess: function (result) {
                $("#order-total-section").html(result.invoice_total_view);
                if (typeof updateInvoiceStatusBar == 'function') {
                    updateInvoiceStatusBar(result.invoice_id);
                }
            }
        });

        
        $("#jadi-item-table").appTable({
            source: '<?php echo_uri("inventory/produksi/item_list_data_barangjadi/". $data_info->id) ?>',
            order: [[0, "asc"]],
            hideTools: true,
            columns: [
                {title: '<?php echo lang("item") ?> '},
                {title: '<?php echo lang("quantity") ?>', "class": "text-right w15p"},
                {title: '<?php echo "Harga" ?>', "class": "text-right w15p"},
                {title: '<?php echo "Gudang" ?>', "class": "text-right w15p"},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w100"}
            ],
            onDeleteSuccess: function (result) {
                $("#order-total-section").html(result.invoice_total_view);
                if (typeof updateInvoiceStatusBar == 'function') {
                    updateInvoiceStatusBar(result.invoice_id);
                }
            },
            onUndoSuccess: function (result) {
                $("#order-total-section").html(result.invoice_total_view);
                if (typeof updateInvoiceStatusBar == 'function') {
                    updateInvoiceStatusBar(result.invoice_id);
                }
            }
        });

        
    });

    updateInvoiceStatusBar = function (invoiceId) {
        $.ajax({
            url: "<?php echo get_uri("purchase/p_order/get_invoice_status_bar"); ?>/" + invoiceId,
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

