<?php echo form_open(get_uri("inventory/material/save"), array("id" => "stock-form", "class" => "general-form", "role" => "form")); ?>

<div class="modal-body clearfix">	

    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />



    <div class="tab-content mt15">

        <div role="tabpanel" class="tab-pane active" id="general-info-tab">

    <div class="form-group">

                <label for="code" class=" col-md-3">Kode Produk</label>

                <div class=" col-md-9">

                    <?php

                    echo form_input(array(

                        "id" => "code",

                        "name" => "code",

                        "class" => "form-control",

                        "value" => $model_info->code,

                        "placeholder" =>  'Nomor Persediaan',

                        "data-msg-required" => lang("field_required"),

                    ));

                    ?>

                </div>

            </div> 

            <!--<div class="form-group">

                <label for="nomor" class=" col-md-3">Nomor Material Batu</label>

                <div class=" col-md-9">

                    <?php

                    /*echo form_input(array(

                        "id" => "nomor",

                        "name" => "nomor",

                        "class" => "form-control",

                        "value" => $model_info->pm_nomor,

                        "placeholder" =>  'Nomor Material Batu',

                        "data-msg-required" => lang("field_required"),

                    ));*/

                    ?>

                </div>

            </div> -->

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

        <label for="barang" class="col-md-3">Produk</label>

        <div class=" col-md-9">

            <select name="barang" id="barang" class="form-control">

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

                <label for="deskripsi" class=" col-md-3">Deskripsi</label>

                <div class=" col-md-9">

                    <?php

                    echo form_textarea(array(

                        "id" => "deskripsi",

                        "name" => "deskripsi",

                        "class" => "form-control",

                        "value" => $model_info->pm_deskripsi,

                        "placeholder" =>  'Deskripsi',

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

                <label for="kuantitasprod" class=" col-md-3">Kuantitas Pengeluaran</label>

                <div class=" col-md-9">

                    <?php

                    echo form_input(array(

                        "id" => "kuantitasprod",

						"type" => "number",

                        "name" => "kuantitasprod",

                        "class" => "form-control",

                        "value" => $model_info->pm_kuantitas_keluar,

                        "placeholder" => 'Kuantitas Pengeluaran'

                    ));

                    ?>

                </div>

            </div>

            <div class="form-group">

                <label for="saldo" class=" col-md-3">Jumlah Persediaan</label>

                <div class=" col-md-9">

                    <?php

                    echo form_input(array(

                        "id" => "saldo",

                        "name" => "saldo",

                        "class" => "form-control",

                        "value" => $model_info->pm_saldo_material,

                        "placeholder" => 'Jumlah Persediaan'

                    ));

                    ?>

                </div>

            </div>       

              

            

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