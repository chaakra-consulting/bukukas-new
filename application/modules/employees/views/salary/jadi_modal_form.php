<?php echo form_open(get_uri("inventory/produksi/addjadi"), array("id" => "produksi-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">

    <div class="tab-content mt15">
        <div role="tabpanel" class="tab-pane active" id="general-info-tab">
      
	  <div class="form-group">
        <label for="bahan" class="col-md-3">Jenis Barang Jadi</label>
        <div class=" col-md-9">
			<select name="bahan" id="bahan" class="form-control">
					<option value="0">- Belum Dipilih -</option>
				<?php 
					$bahan=$data_item_jadi->result();
					foreach($bahan as $bhn){
						echo '<option value="'.$bhn->id.'">'.$bhn->title.'</option>';
					}
				?>
			</select> 
        </div>
    </div>
	<div class="form-group">
        <label for="jumlah" class="col-md-3">Hasil Produksi (m3)</label>
         <div class=" col-md-9">
			 <input type="number" id="jumlah" name="jumlah" class="form-control" placeholder="Jumlah (m3)">
        </div> 
    </div>
	<div class="form-group">
        <label for="jumlah" class="col-md-3">Harga Produksi</label>
         <div class=" col-md-9">
			 <input type="number" id="harga" name="harga" class="form-control" placeholder="Harga">
        </div> 
    </div>
	<div class="form-group">
        <label for="jumlah" class="col-md-3">Gudang</label>
         <div class=" col-md-9">
			 <input type="text" id="gudang" name="gudang" class="form-control" placeholder="Gudang">
        </div> 
    </div>
		<input type="hidden" value="<?=$id;?>" name="id" id="id">
               
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

        //setDatePicker("#date");
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
	
	 $(function() {
        $("#bahan").change(function(){
            //var element = $(this);
            //var myTag = element.attr("tersedia");
			var mytag = $('option:selected', this).attr('tersedia');
			$("input[type='number']").prop('min',0);
			$("input[type='number']").prop('max',mytag);
			//alert(mytag);
            //$('#setMyTag').val(myTag);
        });
    });
</script>

