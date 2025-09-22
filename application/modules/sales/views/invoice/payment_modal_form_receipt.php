<form id="invoice-item-form" 
      class="general-form" 
      action="<?= get_uri("sales/s_invoices/preview_payment"); ?>" 
      method="post" 
      target="_blank">

    <div class="modal-body clearfix">
        <input type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>" />
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="invoice_pembayaran" value="<?php echo $invoice_pembayaran; ?>" />
        <input type="hidden" name="invoice_termin" value="<?php echo $invoice_termin; ?>" />

        <!-- <div class="form-group">
            <label for="receipt_type" class="col-md-3">Jenis</label>
            <div class="col-md-9">
                <select name="receipt_type" id="receipt_type" class="select2">
                    <option value="001">001 - Penawaran</option>
                    <option value="002">002 - Keputusan</option>
                    <option value="003">003 - Undangan</option>
                    <option value="004">004 - Permohonan</option>
                    <option value="005">005 - Pemberitahuan</option>
                    <option value="006">006 - Pernyataan</option>
                    <option value="007">007 - Keterangan</option>
                    <option value="008">008 - Tugas</option>
                    <option value="009">009 - Perintah</option>
                    <option value="010">010 - Pengantar</option>
                    <option value="011">011 - Balasan</option>
                    <option value="012">012 - Rekomendasi</option>
                    <option value="013">013 - Sertifikat</option>
                    <option value="014">014 - Perjanjian Kerja</option>
                    <option value="015">015 - Laporan</option>
                    <option value="016">016 - Kwitansi</option>
                    <option value="017">017 - Invoice</option>
                </select>
            </div>
        </div> -->
        <?php if($invoice_info->potongan) { ?>
        <div class="form-group">
            <label for="invoice_pph_type" class="col-md-3">Status PPH</label>
            <div class="col-md-9">
                <select name="invoice_pph_type" id="invoice_pph_type" class="select2">
                    <option value="dengan-pph">Dengan PPH</option>
                    <option value="tanpa-pph">Tanpa PPH</option>
                </select>
            </div>
        </div>
        <?php } else { ?>
            <input type="hidden" name="invoice_pph_type" value="" />
        <?php }?>
        <div  id="deskripsi_group" class="form-group">
            <label for="title" class="col-md-3">Deskripsi</label>
            <div class="col-md-9">
                <textarea id="title" name="title"
                          class="form-control validate-hidden"
                          data-rule-required="true"
                          data-msg-required="<?php echo lang("field_required"); ?>"><?php echo $invoice_items_info->title; ?></textarea>
            </div>
        </div>
        <!-- <div class="form-group">
            <label for="description" class="col-md-3">Isi</label>
            <div class="col-md-9">
                <textarea id="description" name="description"
                          class="form-control validate-hidden summernote"
                          data-rule-required="true"
                          data-msg-required="<?php echo lang("field_required"); ?>"><?php echo $model_info->description; ?></textarea>
            </div>
        </div> -->
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <span class="fa fa-close"></span> <?php echo lang('close'); ?>
        </button>
        
        <button type="submit" 
                class="btn btn-primary" 
                data-action="<?= get_uri("sales/s_invoices/download_pdf_receipt"); ?>">
            <span class="fa fa-download"></span> <?php echo lang('download_pdf'); ?>
        </button>
        
        <button type="submit" 
                class="btn btn-primary" 
                data-action="<?= get_uri("sales/s_invoices/preview_receipt"); ?>">
            <span class="fa fa-search"></span> <?php echo lang('invoice_preview'); ?>
        </button>
    </div>

</form>

<script type="text/javascript">

   $(document).ready(function () {
    $('#total').maskMoney({
        precision: 0
    });

    $('input[name=total]').change(function () {
        var value = $(this).val();
        // Tambahkan logika sesuai kebutuhan
    });

    $("#invoice-item-form .select2").select2();
    setDatePicker("#payment_date");
});
    $(document).ready(function () {
        $('#description').summernote({
            height: 200, // tinggi editor
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                // ['view', ['fullscreen', 'codeview']]
            ]
        });
    });

    $(document).ready(function () {
        var $form = $("#invoice-item-form");

        // ketika tombol submit diklik
        $form.find("button[type=submit]").on("click", function (e) {
            var actionUrl = $(this).data("action"); 
            $form.attr("action", actionUrl);
        });
    });


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