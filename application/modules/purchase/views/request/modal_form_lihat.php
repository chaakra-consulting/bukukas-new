<?php echo form_open(get_uri("purchase/request/simpan"), array("id" => "request_holding-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">

     <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />


    <div class="form-group">
        <label for="code" class=" col-md-3">Request Holding CODE</label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "code",
                "name" => "code",
                "value"=> $model_info->code,
                "class" => "form-control validate-hidden",
                "readonly" => true,
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="email_to" class="col-md-3">Material</label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "material",
                "name" => "material",
                "value"=> $model_info->material,
                "class" => "form-control",
                "readonly" => true,
                "placeholder" => "Material"
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="email_to" class="col-md-3">Deskripsi Material</label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "deskripsi_material",
                "name" => "deskripsi_material",
                "value"=> $model_info->deskripsi_material,
                "class" => "form-control",
                "readonly" => true,
                "placeholder" => "Deskripsi Material"
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="email_to" class="col-md-3">Kuantitas</label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "kuantitas",
                "name" => "kuantitas",
                "value"=> $model_info->kuantitas,
                "class" => "form-control",
                "readonly" => true,
                "placeholder" => "Kuantitas Material"
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="inv_address" class=" col-md-3">Memo</label>
        <div class="col-md-9">
             <?php 
                echo form_textarea(array(
                "id" => "memo",
                "name" => "memo",
                "value"=> $model_info->memo,
                "class" => "form-control",
                "readonly" => true,
                "placeholder" => "Memo"
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
          RELOAD_VIEW_AFTER_UPDATE = false; //go to invoice page
        
        $("#request_holding-form .select2").select2();
        setDatePicker("#exp_date");
        $("#request_holding-form").appForm({
             onSuccess: function (result) {
                if (typeof RELOAD_VIEW_AFTER_UPDATE !== "undefined" && RELOAD_VIEW_AFTER_UPDATE) {
                    location.reload();
                } else {
                    window.location = "<?php echo site_url('purchase/request/index'); ?>/" + result.id;
                }
            },
        });
        
        $("#fid_vendor").select2().on("change", function () {
            var vendor_id = $(this).val();
            if ($(this).val()) {
                // $('#invoice_project_id').select2("destroy");
                // $("#invoice_project_id").hide();
                // appLoader.show({container: "#invoice-porject-dropdown-section"});
                $.ajax({
                    url: "<?php echo get_uri("master/vendors/getId") ?>" + "/" + vendor_id,
                    dataType: "json",
                    // data: data,
                    type:'GET',
                    success: function (data) {

                         $.each(data, function(index, element) {

                            $("#email_to").val(element.email);
                            $("#inv_address").val(element.address);
                            $("#delivery_address").val(element.address);
                         });
                    }
                });
            }
        });
    });
</script>