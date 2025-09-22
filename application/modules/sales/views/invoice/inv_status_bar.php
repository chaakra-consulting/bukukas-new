<div class="panel panel-default  p10 no-border m0">
    <span class="ml15">Instansi : <?php 
        echo (modal_anchor(get_uri("master/customers/view/" . $client_info->id),$client_info->name, array("data-post-id" => $client_info->id,"title" => "Vendors Info")));
        ?>
    </span> 
    <span><?php echo $invoice_status_label; ?></span>  
</div>
<div class="panel panel-default  p10 no-border m0">
    <span></span>
    <span class="ml15">Nama Projek : <?php 
        //print_r($client_info);exit;
        echo $item_info->title;
        ?>
    </span>   
</div>
<div class="panel panel-default  p10 no-border m0">
    <span></span>
    <span class="ml15">Tanggal SPK : <?php 
        //print_r($client_info);exit;
        echo $invoice_info->inv_date;
        ?>
    </span>   
</div>
<div class="panel panel-default  p10 no-border m0">
    <span></span>
    <span class="ml15">Tanggal Kontrak : <?php 
        //print_r($client_info);exit;
        echo $invoice_info->inv_contract_date;
        ?>
    </span>   
</div>
<div class="panel panel-default  p10 no-border m0">
    <span></span>
    <span class="ml15">Jumlah Termin : <?php 
        //print_r($client_info);exit;
        echo $invoice_info->termin;
        ?>
    </span>   
</div>