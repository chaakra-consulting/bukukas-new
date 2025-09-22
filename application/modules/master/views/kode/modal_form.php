<?php echo form_open(get_uri("master/kode_kas/add"), array("id" => "kode-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="form-group">
        <label for="code" class="col-md-3">Code</label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "code",
                "name" => "code",
                "class" => "form-control",
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
        $("#kode-form").appForm({
            onSuccess: function (result) {
            if (typeof RELOAD_VIEW_AFTER_UPDATE !== "undefined" && RELOAD_VIEW_AFTER_UPDATE) {
                    location.reload();
                }else {
                    window.location = "<?php echo site_url('master/kode_kas/index'); ?>/" + result.id;
                }
            }
       });

        $("#kode-form input").keydown(function(e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                      $("#kode-form").trigger('submit');
                
            }
        });
        $("#code").focus();
       

        $("#form-submit").click(function() {
            $("#kode-form").trigger('submit');
        });
    });
</script>