<form id="invoice-item-form" 
      class="general-form" 
      action="<?= get_uri("sales/s_invoices/preview_payment"); ?>" 
      method="post" 
      target="_blank">

    <div class="modal-body clearfix">
        <input type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>" />
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="invoice_pembayaran" value="<?php echo $invoice_pembayaran; ?>" />

        <div class="form-group">
            <label for="invoice_type" class="col-md-3">Pilih Template</label>
            <div class="col-md-9">
                <select name="invoice_type" id="invoice_type" class="select2">
                    <option value="normal">Template Normal</option>
                    <option value="rincian">Template Rincian Jumlah</option>
                </select>
            </div>
        </div>
        <?php if ($invoice_info->termin > 1) { ?>
            <div class="form-group">
                <label for="invoice_termin" class="col-md-3">Pilih Termin</label>
                <div class="col-md-9">
                    <select name="invoice_termin" id="invoice_termin" class="select2">
                        <?php for ($i = 1; $i <= $invoice_info->termin; $i++) : ?>
                            <option value="<?php echo $i; ?>"> <?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
        <?php } ?>
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
        <?php } ?>
        <!-- <div id="invoice_pembayaran_group" class="form-group">
            <label for="invoice_pembayaran" class="col-md-3">Pilih Pembayaran</label>
            <div class="col-md-9">
                <select name="invoice_pembayaran" id="invoice_pembayaran" class="select2">
                    <option value="all">Semua</option>
                    <option value="termin">Termin</option>
                </select>
            </div>
        </div> -->
        <div id="satuan_group" class="form-group">
            <label for="satuan" class="col-md-3">Jumlah Satuan</label>
            <div class="col-md-9">
                <input type="text" id="satuan" name="satuan"
                       class="form-control"
                       placeholder="0"
                       data-rule-required="true"
                       data-msg-required="<?php echo lang("field_required"); ?>" />
            </div>
        </div>

        <div  id="deskripsi_group" class="form-group">
            <label for="title" class="col-md-3">Deskripsi</label>
            <div class="col-md-9">
                <textarea id="title" name="title"
                          class="form-control validate-hidden"
                          data-rule-required="true"
                          data-msg-required="<?php echo lang("field_required"); ?>"><?php echo $invoice_items_info->title; ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="col-md-3">Isi</label>
            <div class="col-md-9">
                <textarea id="description" name="description"
                          class="form-control validate-hidden summernote"
                          data-rule-required="true"
                          data-msg-required="<?php echo lang("field_required"); ?>"><?php echo $model_info->description; ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="note" class="col-md-3">Notes</label>
            <div class="col-md-9">
                <input type="text" id="note" name="note"
                       class="form-control validate-hidden"
                />
            </div>
        </div>

        <div class="form-group">
            <label for="invoice_rekening" class="col-md-3">Rekening</label>
            <div class="col-md-9">
                <select name="invoice_rekening" id="invoice_rekening" class="select2">
                    <option value="bca-herlina">BCA - 4290737856 (Herlina Eka Subandriyo Putri)</option>
                    <option value="bsi-herlina">BSI - 7138737793 (Herlina Eka Subandriyo Putri)</option>
                    <option value="bjt-chaakralogi">Bank JATIM - 0011286267 (CV CHAAKRALOGI)</option>
                </select>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <span class="fa fa-close"></span> <?php echo lang('close'); ?>
        </button>
        
        <button type="submit" 
                class="btn btn-primary" 
                data-action="<?= get_uri("sales/s_invoices/download_pdf_payment"); ?>">
            <span class="fa fa-download"></span> <?php echo lang('download_pdf'); ?>
        </button>
        
        <button type="submit" 
                class="btn btn-primary" 
                data-action="<?= get_uri("sales/s_invoices/preview_payment"); ?>">
            <span class="fa fa-search"></span> <?php echo lang('invoice_preview'); ?>
        </button>
    </div>

</form>

<script type="text/javascript">
    function toggleFields() {
        var type = $("#invoice_type").val();
        if (type === "normal") {
            $("#invoice_pembayaran_group").show();
            $("#satuan_group").hide();
            // $("#deskripsi_group").hide();
            $("#deskripsi_group").show();

            var pembayaran = $("#invoice_pembayaran").val();
            // if (pembayaran === "termin") {
            //     // $("#termin_group").show();
            //     $("#deskripsi_group").show();
            // }else{
            //     // $("#termin_group").hide();
            //     $("#deskripsi_group").hide();
            // }
        } else if (type === "rincian") {
            $("#satuan_group").show();
            $("#deskripsi_group").show();
            $("#invoice_pembayaran_group").hide();
        }
    }

    toggleFields();

    $("#invoice_type").on("change", function() {
        toggleFields();
    });

    $("#invoice_pembayaran").on("change", function () {
        toggleFields();
    });

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
        height: 200,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['color', 'strikethrough', 'superscript', 'subscript']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']]
        ],
        // fontSizes: ['8', '10', '12', '14', '18', '24', '36']               // ukuran font kustom
    });
});

    $(document).ready(function () {
        var $form = $("#invoice-item-form");

        // ketika tombol submit diklik
        $form.find("button[type=submit]").on("click", function (e) {
            var actionUrl = $(this).data("action"); 
            $form.attr("action", actionUrl);
        });

        // validasi jika model_info kosong
        $form.on("submit", function (e) {
            var id = <?= isset($id) && $id != 0 ? $id : 0 ?>;
            let paymentSubtotalMinus = parseFloat("<?= isset($invoice_total_summary->payment_subtotal_minus) ? $invoice_total_summary->payment_subtotal_minus : 0 ?>");

            if (id == 0 && paymentSubtotalMinus != 0) {
                e.preventDefault();
                alert("Silahkan Masukkan Data Invoice Terlebih Dahulu.");
                return false;
            }
          
            // if (paymentSubtotalMinus == 0) {
            //     e.preventDefault();
            //     alert("Tidak Ada Pembayaran Tersisa.");
            //     return false;
            // }
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