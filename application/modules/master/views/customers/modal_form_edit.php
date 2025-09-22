<?php echo form_open(get_uri("master/customers/save"), array("id" => "master_customers-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />

    <div class="form-group">
        <label for="npwp" class=" col-md-3">No Npwp</label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "npwp",
                "name" => "npwp",
                "value" => $model_info->npwp,
                "class" => "form-control",
                "placeholder" => 'NPWP Number',
            ));
            ?>
        </div>
    </div>

    <div class="tab-content mt15">
        <div role="tabpanel" class="tab-pane active" id="general-info-tab">
            <div class="form-group">
                <label for="name" class=" col-md-3"> Nama Instansi</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "name",
                        "name" => "name",
                        "value" => $model_info->name,
                        "class" => "form-control",
                        "placeholder" => 'Customers Name / Company Name',
                        "autofocus" => true,
                        "data-rule-required" => true,
                        "data-msg-required" => lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="jenis" class="col-md-3">Jenis Perusahaan</label>
                <div class=" col-md-8">
                    <?php
                    echo form_dropdown(
                        "jenis",
                        array(
                            "" => "-",
                            "BUMN" => "BUMN",
                            "BUMD" => "BUMD",
                            "DINAS" => "DINAS",
                            "SWASTA" => "SWASTA"
                        ),
                        $model_info->jenis, 
                        "class='select2' id='jenis'"
                    );
                    ?>
                    <medium id="jenis-error" class="text-danger" style="display:none;">Mohon Diisi</medium>
                </div>
            </div>

            <div class="form-group">

                <label for="address" class=" col-md-3">Alamat</label>

                <div class=" col-md-9">

                    <?php

                    echo form_textarea(array(

                        "id" => "address",
                        "name" => "address",
                        "class" => "form-control",
                        "value" => $model_info->address,
                        "data-rule-required" => true,
                        "placeholder" => 'Customer Detail Address',

                    ));

                    ?>

                </div>

            </div>
            <div class="form-group">
                <label for="email" class=" col-md-3">Nama Kontak</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "email",
                        "name" => "email",
                        "value" => $model_info->email,
                        "class" => "form-control",
                        "placeholder" => 'Nama Kontak',
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="contact" class=" col-md-3">No Telepon</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "contact",
                        "name" => "contact",
                        "value" => $model_info->contact,
                        "class" => "form-control",
                        "data-rule-required" => true,
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="gender_contact" class="col-md-3">Jenis Kelamin</label>
                <div class="col-md-9">
                    <?php
                    echo form_dropdown(
                        "gender_contact", 
                        array(
                            "Laki-Laki" => "Laki-laki", 
                            "Perempuan" => "Perempuan"
                        ), 
                        isset($model_info->gender_contact) ? $model_info->gender_contact : "", 
                        "class='select2 gender-select2'"
                    );
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="memo" class=" col-md-3">Catatan</label>
                <div class=" col-md-9">
                    <?php
                    echo form_textarea(array(
                        "id" => "memo",
                        "name" => "memo",
                        "value" => $model_info->memo,
                        "class" => "form-control",
                        "placeholder" => 'Others Details'
                    ));
                    ?>
                </div>
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
        $("#master_customers-form .select2").select2();
        $("#master_customers-form").appForm({
            onSuccess: function (result) {
                if (result.success) {
                    $("#master_customers-table").appTable({ newData: result.data, dataId: result.id });
                }
            }
        });

        $("#master_customers-form input").keydown(function (e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                $("#master_customers-form").trigger('submit');

            }
        });
        $("#code").focus();

        $("#form-submit").click(function (e) {
            //$("#master_customers-form").trigger('submit');
            e.preventDefault();

            let jenis = $("#jenis").val();

            if (jenis === "") {
                $("#jenis-error").show();
            } else {
                $("#jenis-error").hide();
                $("#master_customers-form").trigger('submit');
            }
        });

    });
</script>