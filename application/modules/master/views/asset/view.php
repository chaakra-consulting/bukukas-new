<?php echo form_open(get_uri("master/asset/view"), array("id" => "asset-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />

    <div class="tab-content mt15">
        <div role="tabpanel" class="tab-pane active" id="general-info-tab">
        <div class="form-group">
        <label for="tgl" class="col-md-3">Tanggal</label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "tgl",
                "name" => "tgl",
                "class" => "form-control",
                "value" => $model_info->tgl,
                "readonly"=>true,
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
                "readonly"=>true,
                "value" => $model_info->ref,
                "class" => "form-control",
                "placeholder" => "101.A"
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="code_asset" class="col-md-3">Kode</label>
        <div class="col-md-8">
            <?php
            echo form_dropdown("code_asset", $kode_dropdown, $model_info->code_asset, "class='select2' id='code_asset' "); 
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
                "value" => $model_info->name_code,
                "readonly"  => true,
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
                "value" => $model_info->area_code,"readonly"  => true,
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
                "value" => $model_info->uraian,
                "name" => "uraian",
                "readonly"=>true,
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
                "readonly"=>true,
                "value" => $model_info->debet,
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
                "readonly"=>true,
                "value" => $model_info->kredit,
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
            echo form_textarea(array(
                "id" => "ket",
                "name" => "ket",
                "readonly"=>true,
                "value" => $model_info->ket,
                "class" => "form-control",
                "placeholder" => "keterangan"
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
<script type="text/javascript">
    $(document).ready(function () {

        $("#asset-form .select2").select2();
        setDatePicker("#exp_date");
        $("#asset-form").appForm({
            onSuccess: function (result) {
                location.reload();
            }
        });
    });
</script>
