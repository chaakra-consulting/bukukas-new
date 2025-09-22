<?php echo form_open(get_uri("purchase/p_pengiriman/save_kirim"), array("id" => "order-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">

     <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />


    <div class="form-group">
        <label for="code" class=" col-md-3">PAYMENTS CODE</label>
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
        <label for="dikirim" class="col-md-3">Status Barang</label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "dikirim",
                "name" => "dikirim",
                "value" => "barang dikirim",
                "class" => "form-control",
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="tgl_dikirim" class="col-md-3">Tanggal Dikirim</label>
        <div class=" col-md-9">
             <?php
            echo form_input(array(
                "id" => "tgl_dikirim",
                "name" => "tgl_dikirim",
                "class" => "form-control",
                "value" => $model_info->tgl_dikirim,
                "placeholder" => "Y/m/d",
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="keterangan" class=" col-md-3">Keterangan</label>
        <div class="col-md-9">
             <?php 
                echo form_textarea(array(
                "id" => "keterangan",
                "name" => "keterangan",
                "value" => $model_info->keterangan,
                "class" => "form-control",
                "placeholder" => "Keterangan",
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

        $("#order-form .select2").select2();
        setDatePicker("#tgl_dikirim");
        $("#order-form").appForm({
            onSuccess: function (result) {
                $("#order-table").appTable({newData: result.data, dataId: result.id});
            }
        });
        
        $("#fid_cust").select2().on("change", function () {
            var client_id = $(this).val();
            if ($(this).val()) {
                // $('#invoice_project_id').select2("destroy");
                // $("#invoice_project_id").hide();
                // appLoader.show({container: "#invoice-porject-dropdown-section"});
                $.ajax({
                    url: "<?php echo get_uri("master/customers/getId") ?>" + "/" + client_id,
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