<?php echo form_open(get_uri("master/consumables/add_consumables"), array("id" => "master_consumables-form", "class" => "general-form", "role" => "form")); ?>

<div class="modal-body clearfix">

    <div class="col-md-12">
        <!-- <div class="form-group">
            <label for="code" class=" col-md-3">Kode</label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "code",

                    "name" => "code",

                    "class" => "form-control",

                    "placeholder" => 'Kode',

                    "data-rule-required" => true,

                    "data-msg-required" => lang("field_required"),
                ));
                ?>
            </div>
        </div> -->
        <div class="form-group">
            <label for="name" class=" col-md-3">Nama Barang</label>
            <div class=" col-md-9">
                <?php
                echo form_input(array(
                    "id" => "name",
                    "name" => "name",
                    "class" => "form-control",
                    "placeholder" => 'Masukkan Nama',
                    "autofocus" => true,
                    "data-rule-required" => true,
                    "data-msg-required" => lang("field_required"),
                ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="satuan" class="col-md-3">Satuan</label>
            <div class="col-md-9">
                <?php 
                echo form_dropdown(
                    "satuan",
                    array(
                        "Pcs" => "Pcs",
                        "Lusin" => "Lusin",
                        "Rim" => "Rim",
                        "Pack" => "Pack",
                        "Set" => "Set",
                        "Box" => "Box",
                    ),
                    "",
                    "class='select2' id='satuan'"
                );
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="description" class=" col-md-3">Deskripsi</label>
            <div class=" col-md-9">
                <?php
                echo form_textarea(array(
                    "id" => "description",
                    "name" => "description",
                    "class" => "form-control",
                   "placeholder" => 'Masukkan Deskripsi',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">

    <button class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span>
        <?php echo lang('close'); ?>
    </button>

    <button id="form-submit" type="button" class="btn btn-primary "><span class="fa fa-check-circle"></span>
        <?php echo lang('save'); ?>
    </button>

</div>

<?php echo form_close(); ?>



<script type="text/javascript">

    $(document).ready(function () {



        $("#master_consumables-form .select2").select2();

        $("#master_consumables-form").appForm({

            onSuccess: function (result) {

                if (result.success) {

                    $("#master_consumables-table").appTable({ newData: result.data, dataId: result.id });

                }

            }

        });



        $("#master_consumables-form input").keydown(function (e) {

            if (e.keyCode === 13) {

                e.preventDefault();

                $("#master_consumables-form").trigger('submit');



            }

        });

        $("#code").focus();

        function toggleBentuk() {
            var jenis = $("#jenis").val();
            if (jenis === "BUMN" || jenis === "BUMD" || jenis === "SWASTA") {
                $("#bentuk-wrapper").show();
                $("#bentuk").attr("required", true);
            } else {
                $("#bentuk-wrapper").hide();
                $("#bentuk").removeAttr("required").val("");
            }
        }

        toggleBentuk();

        $("#jenis").change(function() {
            toggleBentuk();
        });

        $("#form-submit").click(function (e) {
            e.preventDefault();

            let isValid = true;

            let jenis = $("#jenis").val();
            if (jenis === "") {
                $("#jenis-error").show();
                isValid = false;
            } else {
                $("#jenis-error").hide();
            }

            let bentuk = $("#bentuk").val();

            if (jenis === "BUMN" || jenis === "BUMD" || jenis === "SWASTA") {
                if (bentuk === "") {
                    $("#bentuk-error").show();
                    isValid = false;
                } else {
                    $("#bentuk-error").hide();
                }
            } else {
                $("#bentuk-error").hide();
            }

            if (isValid) {
                $("#master_consumables-form").trigger('submit');
            }
        });

    });

</script>