<?php echo form_open(get_uri("master/sparepart/save"), array("id" => "item-form", "class" => "general-form", "role" => "form")); ?>

<div class="modal-body clearfix">

    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />  

    <div class="form-group">
                <label for="code" class=" col-md-3">Sparepart Code</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "code",
                        "name" => "code",
                        "class" => "form-control",
                        "placeholder" => 'Sparepart Code',
                        "value" => $model_info->code,
                        "readonly" => true,
                        "autofocus" => true,
                        "data-rule-required" => true,
                        "data-msg-required" => lang("field_required"),
                    ));
                    ?>
                </div>
            </div>

    <div class="form-group">

        <label for="title" class=" col-md-3">Nama Sparepart</label>

        <div class="col-md-9">

            <?php

            echo form_input(array(

                "id" => "title",

                "name" => "title",

                "value" => $model_info->title,

                "class" => "form-control validate-hidden",

                "placeholder" => lang('title'),

                "autofocus" => true,

                "autocomplete" => "off",

                "data-rule-required" => true,

                "data-msg-required" => lang("field_required"),

            ));

            ?>

        </div>

    </div>

    <div class="form-group">

        <label for="deskripsi" class=" col-md-3">Deskripsi</label>

        <div class="col-md-9">

            <?php

            echo form_input(array(

                "id" => "deskripsi",

                "name" => "deskripsi",

                "value" => $model_info->deskripsi,

                "class" => "form-control validate-hidden",

                "autofocus" => true,

                "autocomplete" => "off",

                "data-rule-required" => true,

                "data-msg-required" => lang("field_required"),

            ));

            ?>

        </div>

    </div>

    <div class="form-group">

        <label for="kuantitas_pembelian" class=" col-md-3">Kuantitas Pembelian</label>

        <div class="col-md-9">

            <?php

            echo form_input(array(

                "id" => "kuantitas_pembelian",

                "name" => "kuantitas_pembelian",

                "value" => $model_info->kuantitas_pembelian,

                "onkeyup"=>"myFunction()",

                "class" => "form-control validate-hidden",

                "autofocus" => true,

                "autocomplete" => "off",

                "data-rule-required" => true,

                "data-msg-required" => lang("field_required"),

            ));

            ?>

        </div>

    </div>

    <div class="form-group">

        <label for="harga" class=" col-md-3">Harga</label>

        <div class="col-md-9">

            <?php

            echo form_input(array(

                "id" => "harga",

                "name" => "harga",

                "value" => $model_info->price,

                "onkeyup"=>"myFunction()",

                "class" => "form-control validate-hidden",

                "autofocus" => true,

                "autocomplete" => "off",

                "data-rule-required" => true,

                "data-msg-required" => lang("field_required"),

            ));

            ?>

        </div>

    </div>

    <div class="form-group">

        <label for="kuantitas_pengeluaran" class=" col-md-3">Kuantitas Pengeluaran</label>

        <div class="col-md-9">

            <?php

            echo form_input(array(

                "id" => "kuantitas_pengeluaran",

                "name" => "kuantitas_pengeluaran",

                "value" => $model_info->kuantitas_pengeluaran,

                "onkeyup"=>"myFunction()",

                "class" => "form-control validate-hidden",

                "autofocus" => true,

                "autocomplete" => "off",

                "data-rule-required" => true,

                "data-msg-required" => lang("field_required"),

            ));

            ?>

        </div>

    </div>

    <div class="form-group">

        <label for="saldo" class=" col-md-3">Sisa Sparepart</label>

        <div class="col-md-9">

            <?php

            echo form_input(array(

                "id" => "saldo",

                "name" => "saldo",

                "value" => $model_info->saldo_perlengkapan,

                "class" => "form-control validate-hidden",

                "autofocus" => true,

                "autocomplete" => "off",

                "data-rule-required" => true,

                "data-msg-required" => lang("field_required"),

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



        $("#item-form .select2").select2();

        $("#item-form").appForm({

            onSuccess: function (result) {

                $("#item-table").appTable({newData: result.data, dataId: result.id});

            }

        });

    });

</script>

<script>
    function myFunction(e){
       
        var pass = document.getElementById('kuantitas_pembelian');
        var pass2 = document.getElementById('kuantitas_pengeluaran');
        //var pass3 = document.getElementById('sub_total');
        //document.getElementById("quantity");
        var input=parseInt(pass.value);
        var input2=parseInt(pass2.value);
        //var input3=parseInt(pass3.value);

        var result = input-input2;

            if (!isNaN(result)) {
                document.getElementById('saldo').value = result;
            }
        var result2 = document.getElementById('saldo').value = result;

            //var txtFirstNumberValue = document.getElementById('quantity').value;
           //var txtSecondNumberValue = document.getElementById('rate').value;
            
       // console.log('alert');
    }
</script>