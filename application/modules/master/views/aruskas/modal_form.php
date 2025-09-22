<?php echo form_open(get_uri("master/aruskas/add_kas"), array("id" => "kas-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">

<div class="form-group">
        <label for="tgl" class="col-md-3">Tanggal</label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "tgl",
                "name" => "tgl",
                "class" => "form-control",
                "placeholder" => "Y/m/d",
                "value" => date("Y-m-d"),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="ref" class=" col-md-3">Ref</label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "ref",
                "name" => "ref",
                "class" => "form-control"
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="code_kas" class="col-md-3">Kode</label>
        <div class="col-md-8">
            <?php
            echo form_dropdown("code_kas", $kode_dropdown, "", "class='select2 validate-hidden' id='code_kas' data-rule-required='true' data-msg-required='" . lang('field_required') . "'");
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="name_code" class="col-md-3">Nama</label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "name_code",
                "name" => "name_code",
                "class" => "form-control",
                "placeholder" => "name"
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="area_code" class="col-md-3">No Area</label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "area_code",
                "name" => "area_code",
                "class" => "form-control",
                "placeholder" => "area"
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="uraian" class="col-md-3">Uraian</label>
        <div class=" col-md-9">
            <?php
            echo form_textarea(array(
                "id" => "uraian",
                "name" => "uraian",
                "class" => "form-control",
                "placeholder" => "uraian"
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="debet" class=" col-md-3">Debet</label>
        <div class="col-md-9">
             <?php 
               echo form_input(array(
                "id" => "debet",
                "name" => "debet",
            
                "class" => "form-control",
                "placeholder" => "0",
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="kredit" class=" col-md-3">Kredit</label>
        <div class="col-md-9">
             <?php 
               echo form_input(array(
                "id" => "kredit",
                "name" => "kredit",
              
                "class" => "form-control",
                "placeholder" => "0",
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="ket" class="col-md-3">Keterangan</label>
        <div class=" col-md-9">
           <?php 
                echo form_dropdown(
                    "ket", array(
                        "TF" => "TF",
                        "TN" => "TN"
                        ), "", "class='select2 mini'"
                    );
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
        
        
        $("#kas-form .select2").select2();
        setDatePicker("#tgl");
        $("#kas-form").appForm({
            onSuccess: function(result) {
                if (result.success) {
                    $("#aruskas-table").appTable({newData: result.data, dataId: result.id});
                }
            }
       });

        $("#kas-form input").keydown(function(e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                      $("#kas-form").trigger('submit');
                
            }
        });
     
       

        $("#form-submit").click(function() {
            $("#kas-form").trigger('submit');
        });

        $("#code_kas").select2().on("change", function () {
            var client_id = $(this).val();
            if ($(this).val()) {
                // $('#invoice_project_id').select2("destroy");
                // $("#invoice_project_id").hide();
                // appLoader.show({container: "#invoice-porject-dropdown-section"});
                $.ajax({
                    url: "<?php echo get_uri("master/aruskas/getId") ?>" + "/" + client_id,
                    dataType: "json",
                    // data: data,
                    type:'GET',
                    success: function (data) {
                    
                         $.each(data, function(index, element) {
                            $("#name_code").val(element.name);
                            $("#area_code").val(element.area);
                        });
                    }
            
                     
                });
            
            }
        });
    });
</script>