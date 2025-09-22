<?php echo form_open(get_uri("inventory/produksi/add"), array("id" => "produksi-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">

    <div class="tab-content mt15">
        <div role="tabpanel" class="tab-pane active" id="general-info-tab">
             
    <div class="form-group">
        <label for="date" class="col-md-3">Tanggal Produksi</label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "date",
                "name" => "tanggal",
                "value" => date("Y-m-d"),
                "class" => "form-control",
                "placeholder" => "Y-m-d"
            ));
            ?>
        </div>
    </div>
             <div class="form-group">
                <label for="deskripsi" class=" col-md-3">Keterangan Produksi</label>
                <div class=" col-md-9">
                    <?php
                    echo form_textarea(array(
                        "id" => "deskripsi",
                        "name" => "deskripsi",
                        "class" => "form-control",
                        "placeholder" =>  'Keterangan Produksi',
                        "data-msg-required" => lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
          
		  
           <!--<div class="form-group">
        <label for="date" class="col-md-3">Date Adjusment</label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "date",
                "name" => "date_adjusment",
                "value" => date("Y-m-d"),
                "class" => "form-control",
                "placeholder" => "Y-m-d"
            ));
            ?>
        </div>
    </div>-->
            
      
            
        </div>
    </div>

</div>

<div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button id="form-submit" type="button" class="btn btn-primary "><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {

        $("#produksi-form .select2").select2();

        setDatePicker("#date");
        //setDatePicker("#date2");
        $("#produksi-form").appForm({
            onSuccess: function(result) {
                if (result.success) {
                    //$("#stock-table").appTable({newData: result.data, dataId: result.id});
					//location.reload();
					window.location = "<?php echo site_url('inventory/produksi/view'); ?>/" + result.id;
                }
            }
       });

        $("#produksi-form input").keydown(function(e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                      $("#produksi-form").trigger('submit');
                
            }
        });
        $("#nomor").focus();
       

        $("#form-submit").click(function() {
            $("#produksi-form").trigger('submit');
        });

    });
</script>

