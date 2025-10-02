<style>
    .info-row {
        display: flex;
        padding: 6px 10px;
        background: #fff;
    }
    .info-label {
        width: 180px;
        font-weight: 600;
        margin: 5px;
    }
    .info-colon {
        width: 20px;
        font-weight: 600;
        margin-top: 5px;
        margin-bottom: 5px;
    }
    .info-value {
        flex: 1;
        margin-top: 5px;
    }
</style>

<div class="info-row">
    <div class="info-label">Instansi</div>
    <div class="info-colon">:</div>
    <div class="info-value">
        <?php echo modal_anchor(
            get_uri("master/customers/view/" . $client_info->id),
            $client_info->name,
            ["data-post-id" => $client_info->id,"title" => "Vendors Info"]
        ); ?>
        <?php echo $invoice_status_label; ?>
    </div>
</div>

<div class="info-row">
    <div class="info-label">Nama Projek</div>
    <div class="info-colon">:</div>
    <div class="info-value"><?php echo $item_info->title; ?></div>
</div>

<div class="info-row">
    <div class="info-label">Tanggal SPK</div>
    <div class="info-colon">:</div>
    <div class="info-value"><?php echo $invoice_info->inv_date; ?></div>
</div>

<div class="info-row">
    <div class="info-label">Tanggal Kontrak Berakhir</div>
    <div class="info-colon">:</div>
    <div class="info-value"><?php echo $invoice_info->inv_contract_date; ?></div>
</div>

<div class="info-row">
    <div class="info-label">Jumlah Termin</div>
    <div class="info-colon">:</div>
    <div class="info-value"><?php echo $invoice_info->termin; ?></div>
</div>
