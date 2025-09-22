<style>
    .loader {
        border: 12px solid #f3f3f3;
        /* Light grey */
        border-top: 12px solid #3498db;
        /* Blue */
        border-radius: 50%;
        width: 80px;
        height: 80px;
        animation: spin 2s linear infinite;
    }
</style>
<div id="page-content" class="clearfix">
    <!-- Button trigger modal -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Prediksi Depresiasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 id="kode"></h5>
                    <h5 id="nama-asset"></h5>
                    <h5 id="jenis"></h5>
                    <h5 id="spesifikasi"></h5>
                    <!-- <h5 id="tahun"></h5>
                    <h5 id="harga-awal"></h5>
                    <h5 id="depresiasi"></h5>
                    <h5 id="harga-akhir"></h5> -->
                    <div class="form-group">
                        <label for="prediksi_tahun">Prediksi Tahun</label>
                        <select name="prediksi_tahun" class="form-control" id="prediksi-tahun">\
                            <option selected disabled value="default">-- Pilih Prediksi Tahun --</option>
                            <?php for ($i = 0; $i < 5; $i++) : ?>
                                <option value="<?= $i + 1; ?>"><?= $i + 1; ?> Tahun</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" id="btn-prediksi">Prediksi</button>
                    <button type="button" class="btn btn-primary" id="btn-reset">Reset</button>
                    <div class="mt-3" style="margin-top: 20px;">
                        <table class="table table-bordered" id="table-depresiasi">
                            <thead>
                                <tr>
                                    <th>Tahun</th>
                                    <th>Harga Awal</th>
                                    <th>Depresiasi</th>
                                    <th>Harga Akhir</th>
                                </tr>
                            </thead>
                            <tbody class="buat-isi">
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-success" id="btnCetakExcel">Cetak Excel</button>
                        <center>
                            <div class="loader" id="loading"></div>
                        </center>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1>Asset Kantor</h1>
            <div class="title-button-group">
                <div class="btn-group" role="group">
                </div>
                <?php
                //if ($this->login_user->is_admin) {
                // echo modal_anchor(get_uri("team_members/invitation_modal"), "<i class='fa fa-envelope-o'></i> " . lang('send_invitation'), array("class" => "btn btn-default", "title" => lang('send_invitation')));
                echo modal_anchor(get_uri("master/assets/modal_form"), "<i class='fa fa-plus-circle'></i> " . 'Tambah Asset', array("class" => "btn btn-primary", "title" => 'Tambah Asset'));
                //}
                ?>

            </div>
        </div>
        <div class="table-responsive">
            <table id="assets-table" class="display" cellspacing="0" width="100%">
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery-table2excel@1.1.1/dist/jquery.table2excel.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#assets-table").appTable({
            source: '<?php echo_uri("master/assets/list_data") ?>',
            order: [
                [0, 'desc']
            ],
            columns: [{
                    title: "Kode",
                    "class": "text-center"
                },
                {
                    title: "Nama Asset",
                    "class": "text-center"
                },
                {
                    title: "Jenis",
                    "class": "text-center"
                },
                {
                    title: "Merk dan Spesifikasi",
                    "class": "text-center"
                },
                {
                    title: "Tahun",
                    "class": "text-center"
                },
                {
                    title: "Harga Awal",
                    "class": "text-center"
                },
                {
                    title: "Depresiasi",
                    "class": "text-center"
                },
                {
                    title: "Harga Akhir",
                    "class": "text-center"
                },
                {
                    title: "Cek Depresiasi",
                    "class": "text-center",
                },
                {
                    title: "Foto",
                    "class": "text-center"
                },
                {
                    title: "Penanggung Jawab",
                    "class": "text-center"
                },
                {
                    title: "Status",
                    "class": "text-center"
                },
                {
                    title: '<i class="fa fa-bars"></i>',
                    "class": "text-center option w200"
                },
            ],
            xlsxColumns: [0, 1, 2, 3, 4, 6, 5, 6, 7]
        });

        $("#btn-reset").hide();
        $("#loading").hide();
        $("#btnCetakExcel").hide();
        $(document).on("click", ".cek-depresiasi", function(e) {
            e.preventDefault();

            function bersihkanHarga(harga) {
                return parseInt(harga.replace(/Rp\./g, '').replace(/,/g, ''), 10);
            }

            function formatRupiah(angka) {
                return `Rp.${angka.toLocaleString('id-ID')}`;
            }

            $(".buat-isi").empty();
            $("#btn-reset").hide();
            $("#btn-prediksi").show();
            $("#btnCetakExcel").hide();
            $("#prediksi-tahun").attr("disabled", false);
            $("#prediksi-tahun").change().val("default");

            let code = $(this).data("code");
            let nama_asset = $(this).data("nama_asset");
            let jenis = $(this).data("jenis");
            let spesifikasi = $(this).data("spesifikasi");
            let tahun = $(this).data("tahun");
            let harga_awal = $(this).data("harga_awal");
            let depresiasi = $(this).data("depresiasi");
            let harga_akhir = $(this).data("harga_akhir");

            $("#kode").text("Kode : " + code);
            $("#nama-asset").text("Nama Asset : " + nama_asset);
            $("#jenis").text("Jenis : " + jenis);
            $("#spesifikasi").text("Spesifikasi : " + spesifikasi);
            $("#tahun").text("Tahun : " + tahun);
            $("#harga-awal").text("Harga Awal : " + harga_awal);
            $("#depresiasi").text("Depresiasi : " + depresiasi);
            $("#harga-akhir").text("Harga Akhir : " + harga_akhir);

            console.log(bersihkanHarga(harga_awal));

            if (bersihkanHarga(harga_awal) == 0) {
                alert("Harga awal data ini 0 silahkan edit terlebih dahulu sesuai dengan harga awal barang");
                $("#btn-prediksi").hide();
            } else {

                $("#btn-prediksi").attr("disabled", true);

                $("#prediksi-tahun").change(function() {
                    $("#btn-prediksi").attr("disabled", false);
                    var jumlah_tahun = $(this).val();
                    console.log(jumlah_tahun);
                    $("#btn-prediksi").click(function(e) {
                        e.preventDefault();
                        // Menampilkan animasi loading
                        $("#loading").show();
                        // Menggunakan setTimeout untuk menunggu sebelum menampilkan data
                        setTimeout(function() {
                            var ambil_jmlTahun = jumlah_tahun;
                            $("#btn-reset").show();
                            $("#btn-prediksi").hide();
                            $("#prediksi-tahun").attr("disabled", true);
                            $("#btnCetakExcel").show();

                            let hargaSekarang = bersihkanHarga(harga_awal);
                            let depresiasiTahunan = bersihkanHarga(depresiasi);
                            let no = 1;

                            $(".buat-isi").empty(); // Menghapus semua baris tabel sebelumnya

                            for (let i = 0; i < jumlah_tahun; i++) {
                                let hargaAwal = hargaSekarang;
                                hargaSekarang -= depresiasiTahunan;
                                let plusTahun = tahun + i;
                                let hargaAwalFormatted = formatRupiah(hargaAwal);
                                let depresiasiFormatted = formatRupiah(depresiasiTahunan);
                                let hargaAkhirFormatted = formatRupiah(hargaSekarang);
                                console.log(hargaAwalFormatted);
                                $(".buat-isi").append(
                                    `<tr>
                                    <td>${plusTahun}</td> 
                                    <td>${hargaAwalFormatted}</td>
                                    <td>${depresiasiFormatted}</td>
                                    <td>${hargaAkhirFormatted}</td>
                                </tr>`
                                );
                            }
                            // Menyembunyikan animasi loading setelah menampilkan data
                            $("#loading").hide();
                        }, 500); // Waktu dalam milidetik sebelum menampilkan data (misalnya, 2000 untuk 2 detik)
                    });

                    $("#btn-reset").click(function(e) {
                        e.preventDefault();
                        jumlah_tahun = 0;
                        $("#btnCetakExcel").hide();
                        $(".buat-isi").empty();
                        $("#btn-reset").hide();
                        $("#btn-prediksi").show();
                        $("#prediksi-tahun").attr("disabled", false);
                    })
                })
            }
        });


        $('#btnCetakExcel').on("click", function(e) {
            $('#table-depresiasi').table2excel({
                exclude: ".footer",
                name: 'Date',
                filename: 'Depresiasi'
            });
        });
    });
</script>

<script type="text/javascript">
    // Popup window code
    function newPopup(url) {
        popupWindow = window.open(
            url, 'popUpWindow', 'height=400,width=400,left=500,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
    }
</script>