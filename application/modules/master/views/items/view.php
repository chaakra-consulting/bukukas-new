<?php echo form_open(get_uri("master/items/save"), array("id" => "item-form", "class" => "general-form", "role" => "form")); ?>

<div class="modal-body clearfix">

    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />



    <div class="form-group">

        <label for="title" class=" col-md-3">Nama Barang</label>

        <div class="col-md-9">

            <?php

            echo form_input(array(

                "id" => "title",

                "name" => "title",

                "value" => $model_info->title,

                "class" => "form-control",

                "autofocus" => true,"readonly" => true,

                "autocomplete" => "off",

                "data-rule-required" => true,


            ));

            ?>

        </div>
        </div>
     <div class="form-group">
        <label for="title" class=" col-md-3">Jumalah Barang</label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "unit",
                "name" => "unit",
                "value" => $model_info->unit,
                "class" => "form-control",
                "autofocus" => true,"readonly" => true,
                "autocomplete" => "off",
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="basic_price" class=" col-md-3">Harga Beli</label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "basic_price",
                "name" => "basic_price",
                "value" => $model_info->basic_price,
                "class" => "form-control",
                "autofocus" => true,"readonly" => true,
                "autocomplete" => "off",
            ));
            ?>
        </div>
        </div>
</div>


<div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>

</div>
<?php echo form_close(); ?>
