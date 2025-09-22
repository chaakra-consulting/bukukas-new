<?php echo form_open(get_uri("master/perusahaan/add_perusahaan"), array("id" => "perusahaan-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">

  
<div class="tab-content mt15">
        <div role="tabpanel" class="tab-pane active" id="general-info-tab">
            
            <div class="form-group">
                <label for="code" class=" col-md-3">Kode Perusahaan</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "code",
                        "name" => "code",
                        "class" => "form-control",
                        "placeholder" => 'Code Perusahaan',
                        "autofocus" => true,
                        "data-rule-required" => true,
                        "data-msg-required" => lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
   
            
            
            <div class="form-group">
                <label for="name" class=" col-md-3">Nama Perusahaan</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "name",
                        "name" => "name",
                        "class" => "form-control",
                        "placeholder" => 'Nama Perusahaan Rekanan',
                        "autofocus" => true,
                        "data-rule-required" => true,
                        "data-msg-required" => lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
            
            <div class="form-group">
                <label for="npwp" class=" col-md-3">No Npwp</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "npwp",
                        "name" => "npwp",
                        "class" => "form-control",
                        "placeholder" =>  'NPWP Number',
                        "data-rule-required" => true,
                        "data-msg-required" => lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class=" col-md-3">Email</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "email",
                        "name" => "email",
                        "class" => "form-control",
                        "placeholder" =>  'mail@example.com'
                        // "data-rule-required" => true,
                        // "data-msg-required" => lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="address" class=" col-md-3">Alamat</label>
                <div class=" col-md-9">
                    <?php
                    echo form_textarea(array(
                        "id" => "address",
                        "name" => "address",
                        "class" => "form-control",
                        "data-rule-required" => true,
                        "placeholder" => 'Address details'
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="termin" class=" col-md-3">Termin</label>
                <div class=" col-md-9">
                    <?php
                    echo form_dropdown(
                        "termin", array(
                             "7" => "7 Hari",
                            "14" => "14 Hari",
                            "30" => "30 Hari",
                            "120" => "> 30 Hari"
                            ), "", "class='select2 mini'"
                        );
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="contact" class=" col-md-3">No Telepon</label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "contact",
                        "name" => "contact",
                        "class" => "form-control",
                        "data-rule-required" => true,
                        "placeholder" => "Ex: 0411-XXXXXXXXXX"
                    ));
                    ?>
                </div>
            </div>
            
            <div class="form-group">
                <label for="memo" class=" col-md-3">Catatan</label>
                <div class=" col-md-9">
                    <?php
                    echo form_textarea(array(
                        "id" => "memo",
                        "name" => "memo",
                        "class" => "form-control",
                        "placeholder" => 'Memo or Description'
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
        $("#perusahaan-form .select2").select2();
        $("#perusahaan-form").appForm({
            onSuccess: function(result) {
                if (result.success) {
                    $("#perusahaan-table").appTable({newData: result.data, dataId: result.id});
                }
            }
       });

        $("#perusahaan-form input").keydown(function(e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                      $("#perusahaan-form").trigger('submit');
                
            }
        });
        $("#code").focus();
       

        $("#form-submit").click(function() {
            $("#perusahaan-form").trigger('submit');
        });

    });
</script>