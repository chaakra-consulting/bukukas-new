<?php echo form_open(get_uri("purchase/request_holding/add"), array("id" => "request_holding-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">

    

    <div class="form-group">
        <label for="code" class=" col-md-3">Request Holding CODE</label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "code",
                "name" => "code",
                "class" => "form-control validate-hidden",
                "autofocus" => true,
                "value" => getMaxIdHolding('purchase_request',"REQ"),
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
                "class" => "form-control",
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
                "class" => "form-control",
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
                "class" => "form-control",
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
                "class" => "form-control",
                "placeholder" => "Memo",
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

        $("#request_holding-form .select2").select2();
        setDatePicker("#exp_date");
        // $("#quotation-form").appForm({
        //     onSuccess: function (result) {
        //         $("#quotation-table").appTable({newData: result.data, dataId: result.id});
        //     }
        // });
            RELOAD_VIEW_AFTER_UPDATE = false; //go to invoice page
        
        $("#request_holding-form").appForm({
            onSuccess: function (result) {
                if (typeof RELOAD_VIEW_AFTER_UPDATE !== "undefined" && RELOAD_VIEW_AFTER_UPDATE) {
                    location.reload();
                } else {
                    window.location = "<?php echo site_url('purchase/request_holding/index'); ?>/" + result.id;
                }
            },
            onAjaxSuccess: function (result) {
                if (!result.success && result.next_recurring_date_error) {
                    $("#next_recurring_date").val(result.next_recurring_date_value);
                    $("#next_recurring_date_container").removeClass("hide");

                    $("#invoice-form").data("validator").showErrors({
                        "next_recurring_date": result.next_recurring_date_error
                    });
                }
            }
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