<?php echo form_open(get_uri("master/perusahaan/save"), array("id" => "master_perusahaan-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
    <div class="form-group">
        <label for="code" class="col-md-3">Code</label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "code",
                "name" => "code",
                "class" => "form-control",
                "readonly" => true,
                "value" => $model_info->code,
                "placeholder" => "kode"
            ));
            ?>
        </div>
    </div>
     <div class="form-group">
        <label for="name" class="col-md-3">Nama</label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "name",
                "name" => "name",
                "class" => "form-control","readonly" => true,
                "value" => $model_info->name,
                "placeholder" => "name"
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="area" class="col-md-3">No Area / KET</label>
        <div class=" col-md-9">
            <?php
            echo form_textarea(array(
                "id" => "area",
                "name" => "area",
                "class" => "form-control","readonly" => true,
                "value" => $model_info->area,
                "placeholder" => "area"
            ));
            ?>
        </div>
    </div>

</div>


<div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>

</div>
<?php echo form_close(); ?>
