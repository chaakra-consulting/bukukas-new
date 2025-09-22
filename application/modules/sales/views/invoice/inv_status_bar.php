<div class="panel panel-default  p15 no-border m0">
    <span><?php echo $invoice_status_label; ?></span>
    <span class="ml15">Dinas : <?php 
        echo (modal_anchor(get_uri("master/customers/view/" . $client_info->id),$client_info->name, array("data-post-id" => $client_info->id,"title" => "Vendors Info")));
        ?>
    </span>   

</div>