<?php echo form_open(get_uri("master/kode_kas/save"), array("id" => "kode-form", "class" => "general-form", "role" => "form")); ?>
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
                "class" => "form-control",
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
                "class" => "form-control",
                "value" => $model_info->area,
                "placeholder" => "area"
            ));
            ?>
        </div>
    </div>
    
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {

        $("#kode-form .select2").select2();
        setDatePicker("#exp_date");
        $("#kode-form").appForm({
            onSuccess: function (result) {
                location.reload();
            }
        });
        
    });
</script>