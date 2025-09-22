<?php echo form_open(get_uri("inventory/material/add"), array("id" => "material-form", "class" => "general-form", "role" => "form")); ?>

<div class="modal-body clearfix">



    <div class="tab-content mt15">

        <div role="tabpanel" class="tab-pane active" id="general-info-tab">

            

             <!--<div class="form-group">

                <label for="nomor" class=" col-md-3">Nomor Material Batu</label>

                <div class=" col-md-9">

                    <?php

                    /*echo form_input(array(

                        "id" => "nomor",

                        "name" => "nomor",

                        "class" => "form-control",

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

                "value" => date("Y-m-d"),

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

                        "placeholder" =>  'Kuantitas Pembelian', 

                    ));

                    ?>

                </div>

            </div>

            

             <div class="form-group">

               <!-- <label for="harga" class=" col-md-3">Unit Harga</label> -->

                <div class=" col-md-9">

                    <?php

                    echo form_input(array(

                        "id" => "harga",

						"type" => "number",

                        "name" => "harga",

                        "class" => "form-control",

                        "type" => hidden,

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

                        "placeholder" => 'Jumlah Persediaan'

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



        $("#material-form .select2").select2();



        setDatePicker("#date");

        //setDatePicker("#date2");

        $("#material-form").appForm({

            onSuccess: function(result) {

                if (result.success) {

                    //$("#stock-table").appTable({newData: result.data, dataId: result.id});

                    location.reload();

                }

            }

       });



        $("#material-form input").keydown(function(e) {

            if (e.keyCode === 13) {

                e.preventDefault();

                      $("#material-form").trigger('submit');

                

            }

        });

        $("#nomor").focus();

       



        $("#form-submit").click(function() {

            $("#material-form").trigger('submit');

        });



    });

</script>



