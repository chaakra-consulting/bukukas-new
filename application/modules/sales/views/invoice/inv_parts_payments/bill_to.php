<div style="margin-top: 15px;"><b>Ditujukan Kepada :</b></div>
<div><?php echo $client_info->name ?></div>
<div style="line-height: 3px;"> </div>
<span class="invoice-meta" style="font-size: 90%; color: black;"><?php
    if ($client_info->address) {
        echo $client_info->address;
    }
    ?>
</span>