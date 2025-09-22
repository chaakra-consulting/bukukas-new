<?php echo form_open(get_uri("master/items/save"), array("id" => "item-form", "class" => "general-form", "role" => "form")); ?>

<div class="modal-body clearfix">

    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />

    <div class="form-group">
                <label for="code" class=" col-md-3">Kode Barang</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "code",
                        "name" => "code",
                        "value" => $model_info->code,
                        "class" => "form-control",
                        "placeholder" => 'Code Barang',
                        "autofocus" => true,
                        "data-rule-required" => true,
                        "data-msg-required" => lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
    <div class="form-group">

        <label for="title" class=" col-md-3">Nama Barang</label>

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
        <label for="title" class=" col-md-3">Jumlah Barang</label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "unit",
                "name" => "unit",
                "value" => $model_info->unit,
                "class" => "form-control validate-hidden",
                "placeholder" => 'unit',
                "autofocus" => true,
                "autocomplete" => "off",
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="basic_price" class=" col-md-3">Harga Beli Barang</label>
        <div class="col-md-9">
            <?php
            echo form_input(array(
                "id" => "basic_price",
                "name" => "basic_price",
                "value" => $model_info->basic_price,
                "class" => "form-control validate-hidden",
                "placeholder" => '',
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
        $('#price').maskMoney(
            {precision:0 
        });
        $('#basic_price').maskMoney(
            {precision:0 
        });
    });

</script>