<?php echo form_open(get_uri("employees/salary/add"), array("id" => "salary-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">

    <div class="tab-content mt15">
        <div role="tabpanel" class="tab-pane active" id="general-info-tab">
             
    <div class="form-group">
        <label for="date" class="col-md-3">Bulan Salary</label>
        <div class=" col-md-3">
			<select name="sal_bulan" class="form-control">
				<option value="">-Pilih Bulan-</option>
				<?php 
					for($i=1;$i<=12;$i++){
						if($i==date("m")){
							$seltah='selected';
						}else{
							$seltah='';
						}
						echo '<option value="'.$i.'" '.$seltah.'>'.jin_nama_bulan($i).'</option>';
					}
				?>
				
			</select> 
        </div>
		<div class=" col-md-3">
            
			<select name="sal_tahun" class="form-control">
				<option value="">-Pilih Tahun-</option>
				<?php 
				
					$thYB=date("Y")-1;
					$thYN=date("Y");
					$thYA=date("Y")+1;
					
					for($i=$thYB;$i<=$thYA;$i++){
						if($i==$thYN){
							$seltah='selected';
						}else{
							$seltah='';
						}
						echo '<option value="'.$i.'" '.$seltah.'>'.$i.'</option>';
					}
				?>
				
			</select>
        </div>
    </div> 
             <div class="form-group">
                <label for="deskripsi" class=" col-md-3">Keterangan Salary</label>
                <div class=" col-md-9">
                    <?php
                    echo form_textarea(array(
                        "id" => "Keterangan Salary",
                        "name" => "deskripsi",
                        "class" => "form-control",
                        "placeholder" =>  'Keterangan Salary',
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

        $("#salary-form .select2").select2();

         //setDatePicker("#date");
        //setDatePicker("#date2");
        $("#salary-form").appForm({
            onSuccess: function(result) {
                if (result.success) {
                    //$("#stock-table").appTable({newData: result.data, dataId: result.id});
					//location.reload();
					window.location = "<?php echo site_url('employees/salary/view'); ?>/" + result.id;
                }
            }
       });

        $("#salary-form input").keydown(function(e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                      $("#salary-form").trigger('submit');
                
            }
        });
        $("#nomor").focus();
       

        $("#form-submit").click(function() {
            $("#salary-form").trigger('submit');
        });

    });
</script>

