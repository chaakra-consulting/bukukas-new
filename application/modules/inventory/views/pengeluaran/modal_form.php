<?php echo form_open(get_uri("inventory/pengeluaran/add"), array("id" => "produksi-form", "class" => "general-form", "role" => "form")); ?>

<div class="modal-body clearfix">



    <div class="tab-content mt15">

        <div role="tabpanel" class="tab-pane active" id="general-info-tab">



    <div class="form-group">



        <label for="invoice_item_title" class=" col-md-3">Barang</label>



        <div class="col-md-9">



            <?php



            echo form_input(array(



                "id" => "invoice_item_title",



                "name" => "invoice_item_title",



                "value" => '',



                "class" => "form-control validate-hidden",



                "placeholder" => lang('select_or_create_new_item'),



                "data-rule-required" => true,



                "data-msg-required" => lang("field_required"),



            ));



            ?>



            <a id="invoice_item_title_dropdwon_icon" tabindex="-1" href="javascript:void(0);" style="color: #B3B3B3;float: right; padding: 5px 7px; margin-top: -35px; font-size: 18px;"><span>×</span></a>



        </div>



    </div>



    <div class="form-group">

        <!--<label for="description" class=" col-md-3">ID Kendaraan</label>-->

        <div class="col-md-9">

            <?php

            echo form_input(array(

                "id" => "id_kendaraan",

                "name" => "id_kendaraan",

                "type" => "hidden",

                "value" => $model_info->id,

                "class" => "form-control",

                "data-rule-required" => true,

                "data-msg-required" => lang("field_required"),

            ));

            ?>

        </div>

    </div>

             

    <div class="form-group">

        <label for="date" class="col-md-3">Tanggal Pengeluaran</label>

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

                <label for="deskripsi" class=" col-md-3">Keterangan Pengeluaran</label>

                <div class=" col-md-9">

                    <?php

                    echo form_textarea(array(

                        "id" => "deskripsi",

                        "name" => "deskripsi",

                        "class" => "form-control",

                        "placeholder" =>  'Keterangan Pengeluaran',

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



        $("#produksi-form .select2").select2();



        setDatePicker("#date");

        //setDatePicker("#date2");

        $("#produksi-form").appForm({

            onSuccess: function(result) {

                if (result.success) {

                    //$("#stock-table").appTable({newData: result.data, dataId: result.id});

					//location.reload();

					window.location = "<?php echo site_url('inventory/pengeluaran/view'); ?>/" + result.id;

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

</script>







<script type="text/javascript">



    $(document).ready(function () {



        // $('#invoice_item_basic').maskMoney(



        //     {precision:0 



        // });



        //$('#invoice_item_rate').maskMoney(



          //  {precision:0 



        //});



        



        //$('input[name=invoice_item_rate]').change(function() {



          //  var value = $(this).val();



            



        //});



        $("#invoice-item-form .select2").select2();



        $("#invoice-item-form").appForm({



            onSuccess: function (result) {



                //window.location = "<?php echo site_url('inventory/pengeluaran/view'); ?>/" + result.id;



                window.location.reload();



                //$("#invoice-item-table").appTable({newData: result.data, dataId: result.id});



                //$("#invoice-total-section").html(result.invoice_total_view);



                //if (typeof updateInvoiceStatusBar == 'function') {



                  //  updateInvoiceStatusBar(result.invoice_id);



                //}



            }



        });







        //show item suggestion dropdown when adding new item



        var isUpdate = "<?php echo $model_info->id; ?>";



        if (!isUpdate) {



            applySelect2OnItemTitle();



        }







        //re-initialize item suggestion dropdown on request



        $("#invoice_item_title_dropdwon_icon").click(function () {



            applySelect2OnItemTitle();



        })







    });







    function applySelect2OnItemTitle() {



        $("#invoice_item_title").select2({



            showSearchBox: true,



            ajax: {



                url: "<?php echo get_uri("inventory/pengeluaran/get_item_suggestion_kendaraan"); ?>",



                dataType: 'json',



                quietMillis: 250,



                data: function (term, page) {



                    return {



                        q: term // search term



                    };



                },



                results: function (data, page) {



                    return {results: data};



                }



            }



        }).change(function (e) {



            if (e.val === "+") {



                //show simple textbox to input the new item



                $("#invoice_item_title").select2("destroy").val("").focus();



                $("#add_new_item_to_library").val(1); //set the flag to add new item in library



            } else if (e.val) {



                //get existing item info



                $("#add_new_item_to_library").val(""); //reset the flag to add new item in library



                $.ajax({



                    url: "<?php echo get_uri("inventory/pengeluaran/get_item_info_suggestion_kendaraan"); ?>",



                    data: {item_name: e.val},



                    cache: false,



                    type: 'POST',



                    dataType: "json",



                    success: function (response) {







                        //auto fill the description, unit type and rate fields.



                        if (response && response.success) {





                                $("#id_kendaraan").val(response.item_info.id);



                        }



                    }



                });



            }







        });



    }



















</script>

