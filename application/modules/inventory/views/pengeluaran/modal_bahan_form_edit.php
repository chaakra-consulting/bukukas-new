<?php echo form_open(get_uri("inventory/produksi/updatebahan"), array("id" => "produksi-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
	<input type="hidden" name="id" value="<?=$id;?>">
    <div class="tab-content mt15">
        <div role="tabpanel" class="tab-pane active" id="general-info-tab">
      
	  <div class="form-group">
        <label for="bahan" class="col-md-3">Bahan Material <?=$id;?></label>
        <div class=" col-md-9"><?=$model_info->pm_deskripsi;?></div>
    </div>
	<div class="form-group">
        <label for="jumlah" class="col-md-3">Quantity Bahan</label>
         <div class=" col-md-9">
			 <input type="number" id="jumlah" name="jumlah" class="form-control" placeholder="Quantity" value="<?=$model_info->pb_qty;?>">
        </div> 
    </div>
		<input type="hidden" value="<?=$id;?>" name="id" id="id">
               
        </div>
    </div>
<?php /*
<?php echo form_open(get_uri("inventory/material/save"), array("id" => "stock-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">	
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />

    <div class="tab-content mt15">
        <div role="tabpanel" class="tab-pane active" id="general-info-tab">
    <div class="form-group">
                <label for="code" class=" col-md-3">Material Code</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "code",
                        "name" => "code",
                        "class" => "form-control",
                        "value" => $model_info->code,
                        "placeholder" =>  'Nomor Material Batu',
                        "data-msg-required" => lang("field_required"),
                    ));
                    ?>
                </div>
            </div> 
            <div class="form-group">
                <label for="nomor" class=" col-md-3">Nomor Material Batu</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "nomor",
                        "name" => "nomor",
                        "class" => "form-control",
                        "value" => $model_info->pm_nomor,
                        "placeholder" =>  'Nomor Material Batu',
                        "data-msg-required" => lang("field_required"),
                    ));
                    ?>
                </div>
            </div> 
            <div class="form-group">
        <label for="date" class="col-md-3">Tanggal Barang Masuk</label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "date",
                "name" => "tanggal", 
                "value" => $model_info->pm_tanggal_masuk,
                "class" => "form-control",
                "placeholder" => "Y-m-d"
            ));
            ?>
        </div>
    </div>
             <div class="form-group">
                <label for="deskripsi" class=" col-md-3">Deskripsi Material</label>
                <div class=" col-md-9">
                    <?php
                    echo form_textarea(array(
                        "id" => "deskripsi",
                        "name" => "deskripsi",
                        "class" => "form-control",
                        "value" => $model_info->pm_deskripsi,
                        "placeholder" =>  'Deskripsi Material',
                        "data-msg-required" => lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
            
             <div class="form-group">
                <label for="kuantitasbeli" class=" col-md-3">Kuantitas Pembelian</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "kuantitasbeli",
                        "type" => "number",
                        "name" => "kuantitasbeli",
                        "class" => "form-control",
                        "value" => $model_info->pm_kuantitas_pembelian,
                        "placeholder" =>  'Kuantitas Pembelian', 
                    ));
                    ?>
                </div>
            </div>
            
             <div class="form-group">
                <label for="harga" class=" col-md-3">Unit Harga</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "harga",
						"type" => "number",
                        "name" => "harga",
                        "value" => $model_info->pm_unit_harga,
                        "class" => "form-control",
                        "placeholder" =>  'Unit Harga', 
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="kuantitasprod" class=" col-md-3">Kuantitas Pengeluaran (Produksi)</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "kuantitasprod",
						"type" => "number",
                        "name" => "kuantitasprod",
                        "class" => "form-control",
                        "value" => $model_info->pm_kuantitas_keluar,
                        "placeholder" => 'Kuantitas Pengeluaran (Produksi)'
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="saldo" class=" col-md-3">Saldo Material</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "saldo",
                        "name" => "saldo",
                        "class" => "form-control",
                        "value" => $model_info->pm_saldo_material,
                        "placeholder" => 'Saldo Material'
                    ));
                    ?>
                </div>
            </div>       
              
            
        </div>


    </div>
*/ ?>
</div>


<div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button id="form-submit" type="button" class="btn btn-primary "><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#stock-form .select2").select2();
        setDatePicker("#date");
        $("#stock-form").appForm({
            onSuccess: function(result) {
                if (result.success) {
                    $("#stock-table").appTable({newData: result.data, dataId: result.id});
                }
            }
       });

        $("#stock-form input").keydown(function(e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                      $("#stock-form").trigger('submit');
                
            }
        });
        $("#name").focus();
       

        $("#form-submit").click(function() {
            $("#stock-form").trigger('submit');
        });

    });
</script>