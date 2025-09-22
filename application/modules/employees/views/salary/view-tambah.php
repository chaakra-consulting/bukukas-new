<div id="page-content" class="clearfix">
    <div style="max-width: 1000px; margin: auto;">
        <div class="page-title clearfix mt15">
            <h1> <?=$judul;?>
            </h1>
            <div class="title-button-group">
                 
                <a href="#" class="btn btn-default" title="Add item" data-post-invoice_id="1" data-act="ajax-modal" data-title="Add item" data-action-url="http://localhost/akuntansi/implemen/purchase/p_order/item_modal_form"><i class="fa fa-plus-circle"></i> Add Bahan</a>                
				 
				</div>
        </div>

        <div id="invoice-status-bar">
            <div class="panel panel-default  p15 no-border m0">
     
     

    <span class="ml15">Last email sent: Never    </span>
    <span class="ml15">
        #QUOT REF : 
        <a href="http://localhost/akuntansi/implemen/purchase/request/view/1">#001/RAN/REQ/180808</a>    </span>
    

</div>        </div>

        

        <div class="mt15">
            <div class="panel panel-default p15 b-t">
               <div class="clearfix p50">
                    <div class="col-sm-12">
                        <table style="font-size:14px;">
                            <tbody><tr>
                                <td width="200">Tanggal Produksi</td>
                                <td>:</td>
                                <td> 
            <input type="text" name="title" value="" id="title" class="form-control validate-hidden" placeholder="Judul" style="">
        </td>
                            </tr>
                            <tr>
                                <td>Order Date</td>
                                <td>:</td>
                                <td> 08-08-2018</td>
                            </tr>
                            <tr>
                                <td>Expirated Date</td>
                                <td>:</td>
                                <td> 08-08-2018</td>
                            </tr>
                        </tbody></table>
                    </div>
                     
                </div>

                <div class="table-responsive mt15 pl15 pr15">
                    <div id="order-item-table_wrapper" class="dataTables_wrapper no-footer"></div><table id="order-item-table" class="display dataTable no-footer" width="100%">            
                    <thead><tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="order-item-table" rowspan="1" colspan="1" aria-label="Item : activate to sort column descending" aria-sort="ascending">Item </th><th class="text-right w15p sorting" tabindex="0" aria-controls="order-item-table" rowspan="1" colspan="1" aria-label="Quantity: activate to sort column ascending">Quantity</th><th class="text-right w15p sorting" tabindex="0" aria-controls="order-item-table" rowspan="1" colspan="1" aria-label="Rate: activate to sort column ascending">Rate</th><th class="text-right w15p sorting" tabindex="0" aria-controls="order-item-table" rowspan="1" colspan="1" aria-label="Total: activate to sort column ascending">Total</th><th class="text-center option w100 sorting" tabindex="0" aria-controls="order-item-table" rowspan="1" colspan="1" aria-label=": activate to sort column ascending"><i class="fa fa-bars"></i></th></tr></thead><tbody><tr role="row" class="odd"><td><b>Hotel International</b><br><span>hotel swiss 4 malam</span><br><span style="float:right;">Akomodasi<span></span></span></td><td class=" text-right w15p">4 Domestic</td><td class=" text-right w15p">Rp. 1,200,000.00</td><td class=" text-right w15p">Rp. 4,800,000.00</td><td class=" text-center option w100"><a href="#" class="edit" title="Edit invoice" data-post-id="1" data-act="ajax-modal" data-title="Edit invoice" data-action-url="http://localhost/akuntansi/implemen/purchase/p_order/item_modal_form"><i class="fa fa-pencil"></i></a><a href="#" title="Hapus" class="delete" data-id="1" data-action-url="http://localhost/akuntansi/implemen/purchase/p_order/delete_item" data-action="delete"><i class="fa fa-times fa-fw"></i></a></td></tr><tr role="row" class="even"><td><b>Tiket Pesawat </b><br><span>Tiket Pesawat 2 orag </span><br><span style="float:right;">Akomodasi<span></span></span></td><td class=" text-right w15p">1 Domestic</td><td class=" text-right w15p">Rp. 1,000,000.00</td><td class=" text-right w15p">Rp. 1,000,000.00</td><td class=" text-center option w100"><a href="#" class="edit" title="Edit invoice" data-post-id="2" data-act="ajax-modal" data-title="Edit invoice" data-action-url="http://localhost/akuntansi/implemen/purchase/p_order/item_modal_form"><i class="fa fa-pencil"></i></a><a href="#" title="Hapus" class="delete" data-id="2" data-action-url="http://localhost/akuntansi/implemen/purchase/p_order/delete_item" data-action="delete"><i class="fa fa-times fa-fw"></i></a></td></tr></tbody></table>
                </div>

                <div class="clearfix">
                    <div class="col-sm-8">

                    </div>
                    <div class="col-sm-4" id="order-total-section">
                        <table id="quotation-item-table" class="table display dataTable text-right strong table-responsive">     
    <tbody><tr>
        <td>Sub Total</td>
        <td>Rp. 5,800,000.00</td>
    </tr>
            <tr>
            <td>PPN (10%)</td>
            <td>Rp. 580,000.00</td>
        </tr>
        <tr>
        <td>Grand Total</td>
        <td>Rp. 6,380,000.00</td>
    </tr>
</tbody></table>                    </div>
                </div>

            </div>
        </div>


        

           
    </div>
</div>