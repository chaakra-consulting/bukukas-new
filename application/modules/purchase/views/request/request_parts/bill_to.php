<div><b><?php echo "REQ TO"; ?></b></div>
<div style="line-height: 2px; border-bottom: 1px solid #f2f2f2;"> </div>
<div style="line-height: 3px;"> </div>
<strong><span><?php echo $client_info->code.' - '.$client_info->name; ?></span> </strong>
<div style="line-height: 3px;"> </div>
<span class="invoice-meta" style="font-size: 90%; color: #666;">
    <?php if ($client_info->address) { ?>
        <div><?php echo nl2br($client_info->address); ?>           


        </div>
<?php } ?>
</span>