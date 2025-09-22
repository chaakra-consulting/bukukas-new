<?php echo form_open(get_uri("master/assets/add_asset"), array("id" => "asset-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">

<div class="form-group">
        <label for="tahun" class="col-md-3">Tahun</label>
        <div class="col-md-9">
            <select name="tahun" id="tahun" class="form-control">
                <?php for ($i = 20; $i < 40; $i++) : ?>
                    <option <?= (date("Y") == "20" . $i ? "selected" : ""); ?> value="20<?= $i; ?>">20<?= $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="code" class="col-md-3">Kode</label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "code",
                "name" => "code",
                "class" => "form-control",
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="name_asset" class=" col-md-3">Nama Asset</label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "name_asset",
                "name" => "name_asset",
                "class" => "form-control",
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="jenis" class="col-md-3">Jenis Asset</label>
        <div class=" col-md-9">
            <select name="jenis" id="jenis-asset" class="form-control jenis-assets" required>
                <option selected>-- Pilih Jenis Asset --</option>
                <option value="Elektronik">Elektronik (30%)</option>
                <option value="Laptop">Laptop (20%)</option>
                <option value="Surat">Surat (30%)</option>
                <option value="Furnitur">Furnitur (20%)</option>
                <option value="Alat Kantor">Alat Kantor (50%)</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="spesifikasi" class="col-md-3">Merk dan Spesifikasi</label>
        <div class=" col-md-9">
            <?php
            echo form_textarea(array(
                "id" => "spesifikasi",
                "name" => "spesifikasi",
                "class" => "form-control",
                "placeholder" => "Lenovo - Intel i5",
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="harga_jual" class="col-md-3">Hagra Awal</label>
        <div class="col-md-9">
            <input type="number" class="form-control harga-awals" name="harga_awal" id="harga-awal">
        </div>
    </div>
    <div class="form-group">
        <label for="depresiasi" class="col-md-3">Depresiasi <small class="text-danger">(Otomatis akan di hasilkan)</small></label>
        <div class="col-md-9">
            <input type="text" class="form-control depresiasis" id="depresiasi" name="depresiasi" data-rule-required="true" data-msg-required="<?= lang("field_required"); ?>" readonly required>
        </div>
    </div>
    <div class="form-group">
        <label for="harga_akhir" class="col-md-3">Harga Akhir <small class="text-danger">(Harga akhir akan di hasilkan otomatis)</small></label>
        <div class="col-md-9">
            <input type="text" class="form-control harga-akhirs" name="harga_akhir" id="harga-akhir" data-rule-required="true" data-msg-required="<?= lang("field_required"); ?>" readonly required>
        </div>
    </div>
    <div class="form-group">
        <label for="foto" class=" col-md-3">Upload Foto</label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "foto",
                "name" => "foto",
                "class" => "form-control",
                "type" => "file",
            ));
            ?>
        </div>
    </div>

    <div class="form-group">
        <label for="pj" class=" col-md-3">Penanggung Jawab</label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "pj",
                "name" => "pj",
                "class" => "form-control",
                "placeholder" => "Nama PJ",
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="status" class=" col-md-3">Status</label>
        <div class="col-md-9">
            <select name="status" id="" class="form-control" required>
                <option selected disabled>-- Pilih Status --</option>
                <option value="Pinjam">Pinjam</option>
                <option value="Dikembalikan">Dikembalikan</option>
            </select>
        </div>
    </div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        
        
        $("#asset-form .select2").select2();
        $("#asset-form").appForm({
            onSuccess: function(result) {
                if (result.success) {
                    $("#asset-table").appTable({newData: result.data, dataId: result.id});
                    location.reload();
                }
            }
       });

        $("#asset-form input").keydown(function(e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                      $("#asset-form").trigger('submit');
                
            }
        });
     
       

        $("#form-submit").click(function() {
            $("#asset-form").trigger('submit');
        });
        
        $(".harga-awals").attr("readonly", true);

        $(".jenis-assets").change(function() {
            var selectedValue = $(this).val();
            var persen = 0;
            var inputValue = 0;
            var hasilPerhitungan = 0;
            var hargaAkhir = 0;

            $(".harga-awal").val("");
            $(".depresiasis").val(0);
            $(".harga-akhirs").val(0);

            if (selectedValue != "") {
                console.log(selectedValue);
                $(".harga-awals").attr("readonly", false);
                if (selectedValue == "Elektronik") {
                    persen = 0.30;
                } else if (selectedValue == "Laptop") {
                    persen = 0.20;
                } else if (selectedValue == "Surat") {
                    persen = 0.30;
                } else if (selectedValue == "Furnitur") {
                    persen = 0.20;
                } else if (selectedValue == "Alat Kantor") {
                    persen = 0.50;
                }
                console.log(persen);
                $(".harga-awals").val("");
                $(".harga-awals").keyup(function() {
                    inputValue = $(this).val();
                    console.log(inputValue);
                    hasilPerhitungan = inputValue * persen;
                    hargaAkhir = inputValue - hasilPerhitungan;
                    console.log("Hasil Perhitungan " + hasilPerhitungan);
                    $(".depresiasis").val(hasilPerhitungan);
                    $(".harga-akhirs").val(hargaAkhir);
                })
            } else {
                persen = 0;
            }
        })

    });
</script>