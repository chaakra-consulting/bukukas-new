<div id="page-content" class="clearfix">
    <div class="panel panel-default">
        <div class="table-responsive">
            <table id="stock-table" class="display" cellspacing="0" width="100%" style="font-size:12px">            
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        $("#stock-table").appTable({
            source: '<?php echo_uri("purchase/p_invoices/list_data_consumable_stock") ?>',
            order: [[0, "desc"]],
            columns: [
                {title: "Nama ATK", "class": "text-center"},
                {title: "Stok", "class": "text-center"},
            ],
            xlsColumns: [0, 1]
        });

    });
</script>