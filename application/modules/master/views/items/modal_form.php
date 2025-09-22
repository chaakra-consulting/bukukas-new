<?php echo form_open(get_uri("master/items/add"), array("id" => "item-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">

<div class="form-group">
                <label for="code" class=" col-md-3">Kode Barang</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "code",
                        "name" => "code",
                        "class" => "form-control",
                        "placeholder" => 'Kode Barang',
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
                "class" => "form-control validate-hidden",
                "placeholder" => 'Judul',
                "autofocus" => true,
                "data-rule-required" => true,
                "autocomplete" => "off",
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
                "class" => "form-control validate-hidden",
                "placeholder" => 'Jumlah Persedian',
                "autofocus" => true,
                "autocomplete" => "off",
                "data-msg-required" => lang("field_required"),
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
                "class" => "form-control validate-hidden",
                "placeholder" => 'Harga Barang',
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="foto" class=" col-md-3">Upload Foto</label>
        <div class="col-md-9">
        <?php
            echo form_input(array(
                "id" => "foto",
                "name" => "foto",
                "class" => "form-control",
                "type" => "file"
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