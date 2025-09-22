<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div id="page-content" class="m20 clearfix">

<canvas id="myChart" width="400" height="400"></canvas>

    </div>
    <?php
$year = $_GET["search"];
if (empty($year) || !is_numeric($year)) {
    $year = date('Y');
}
?>

<form action="">
    <div class="form-group">
        <label for="search">Tahun</label>
        <select name="search" id="" class="form-control">
            <option selected disabled>-- Pilih Tahun --</option>
            <?php for ($i = 20; $i < 30; $i++) : ?>
                <option <?= ($year == "20" . $i ? "selected" : ""); ?> value="20<?= $i; ?>">20<?= $i; ?></option>
            <?php endfor ?>
        </select>
    </div>
    <div class="mt-2">
        <button type="submit" class="btn btn-primary">Cari</button>
        <a href="<?= base_url("Dashboard"); ?>" class="btn btn-success">Reload</a>
    </div>
</form>
<?php
// load_js(array(
//     "assets/js/flot/jquery.flot.min.js",
//     "assets/js/flot/jquery.flot.pie.min.js",
//     "assets/js/flot/jquery.flot.resize.min.js",
//     "assets/js/flot/curvedLines.js",
//     "assets/js/flot/jquery.flot.tooltip.min.js",
//     "assets/js/chart.js",
//     "assets/js/gauge.js",
// ));
?>
<script>
   // Data untuk grafik
    var dataFromPhp = <?= json_encode($data) ?>;

    var labels = [];
    var datasetData = [];

    console.log(datasetData);

    dataFromPhp.forEach(function(item) {
        labels.push(item.month);
        datasetData.push(item.total);
    });

    var data = {
        labels: labels,
        datasets: [{
            label: "Total Pengeluaran",
            backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#4CAF50", "#FF9800", "#9C27B0", "#795548", "#2196F3", "#FF5722", "#607D8B", "#E91E63", "#FFEB3B"],
            data: datasetData
        }]
    };

    // Pengaturan grafik
    var options = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function (context) {
                        var value = context.raw || 0;
                        var formattedValue = new Intl.NumberFormat('id-ID').format(value);
                        return "Total Pengeluaran: Rp." + formattedValue;
                    }
                }
            }
        }
    };

    // Ambil elemen canvas
    var ctx = document.getElementById("myChart").getContext("2d");

    // Buat grafik
    var myChart = new Chart(ctx, {
        type: 'bar', // Jenis grafik (bisa diganti dengan jenis lainnya)
        data: data,
        options: options
    });
</script>



