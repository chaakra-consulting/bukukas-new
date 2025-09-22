<?php echo form_open(get_uri("master/kendaraan/save"), array("id" => "master_customers-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />

    <div class="tab-content mt15">
        <div role="tabpanel" class="tab-pane active" id="general-info-tab">
             <div class="form-group">
                <label for="name" class=" col-md-3"> Nama Kendaraan</label>
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
                <label for="npwp" class=" col-md-3">No. Polisi</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "nopol",
                        "name" => "nopol",
                        "value" => $model_info->nopol,
                        "class" => "form-control",
                        "readonly" => true
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
