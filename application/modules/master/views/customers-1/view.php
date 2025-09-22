<?php echo form_open(get_uri("master/customers/save"), array("id" => "master_customers-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />

    <div class="tab-content mt15">
        <div role="tabpanel" class="tab-pane active" id="general-info-tab">
        <div class="form-group">
                <label for="npwp" class=" col-md-3">No NPWP</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "npwp",
                        "name" => "npwp",
                        "value" => $model_info->npwp,
                        "class" => "form-control",
                        "readonly" => true
                    ));
                    ?>
                </div>
            </div>
        <div class="form-group">
                <label for="name" class=" col-md-3">Nama Instansi</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "name",
                        "name" => "name",
                        "value" => $model_info->name,
                        "class" => "form-control",
                        "autofocus" => true,
                        "readonly" => true,
                        "data-rule-required" => true
                    ));
                    ?>
                </div>
            </div>
            
            <div class="form-group">
                <label for="address" class=" col-md-3">Alamat</label>
                <div class=" col-md-9">
                    <?php
                    echo form_textarea(array(
                        "id" => "address",
                        "name" => "address",
                        "value" => $model_info->address,
                        "class" => "form-control",
                        "data-rule-required" => true,
                        "readonly" => true
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
                        "readonly" => true
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
                        "readonly" => true
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="gender_contact" class=" col-md-3">Jenis Kelammin</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "gender_contact",
                        "name" => "gender_contact",
                        "value" => $model_info->gender_contact,
                        "class" => "form-control",
                        "data-rule-required" => true,
                        "readonly" => true
                    ));
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
                        "readonly" => true,
                        "class" => "form-control"
                    ));
                    ?>
                </div>
            </div>
            
        </div>
    </div>

</div>


<div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>

</div>
<?php echo form_close(); ?>
