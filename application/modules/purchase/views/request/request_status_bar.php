<div class="panel panel-default  p15 no-border m0">
    <span><?php echo $invoice_status_label; ?></span>
    <span class="ml15">Perusahaan : <?php 
        echo (modal_anchor(get_uri("master/vendors/view/" . $client_info->id),$client_info->code." - ".$client_info->name, array("data-post-id" => $client_info->id)));
        ?>
    </span> 
</div>