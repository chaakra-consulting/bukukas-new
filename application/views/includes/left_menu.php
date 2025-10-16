<div id="sidebar" class="box-content ani-width">

    <div id="sidebar-scroll">

        <br>

        <p><img style="float: left; margin: 0px 15px 15px 20px;width:50px;border:2px solid #dfdede;"
                src="<?php echo get_avatar($this->login_user->image); ?>" class="rounded-circle user-photo" />Welcome,
            <br><strong><?php echo $this->login_user->first_name . " " . $this->login_user->last_name; ?></strong><br
                style="clear: both;" /></p>

        <hr>


        <ul class="" id="sidebar-menu">
            <?php
            $user_type = $this->login_user->user_type;
            $is_admin = $this->login_user->is_admin;
            if ($is_admin || $user_type == 'manager' || $user_type == "admin_lap" || $user_type == "admin_kan" || $user_type == "verifikasi" || $user_type == "manajer_keu") {

                $al_submenu = array();
                //$ar_submenu[] = array("name" => "Penawaran Penjualan", "slug"=>"quotation","url" => "sales/quotation");
                //$ar_submenu[] = array("name" => "Form Penawaran", "slug"=>"offer","url" => "sales/offer");
                //$ar_submenu[] = array("name" => "Req Poyek", "slug"=>"order","url" => "sales/order");
                $al_submenu[] = array("name" => "Pengeluaran", "slug" => "dashboard", "url" => "dashboard");
                $al_submenu[] = array("name" => "Pendapatan", "slug" => "dashboard/index2", "url" => "dashboard/index2");
                //$ar_submenu[] = array("name" => "Surat Jalan", "slug"=>"s_suratjalan","url" => "sales/s_suratjalan");
                //$ar_submenu[] = array("name" => "Status Proyek", "slug"=>"s_pengiriman","url" => "sales/s_pengiriman");
                //$ar_submenu[] = array("name" => "Pembayaran Proyek", "slug"=>"s_payments","url" => "sales/s_payments");
                //$ar_submenu[] = array("name" => "Export Proyek", "slug"=>"s_history","url" => "sales/s_history");
            
                // $ar_submenu[] = array("name" => "Penerimaaan Barang", "slug"=>"s_penerimaan","url" => "sales/s_penerimaan");
            
                $sidebar_menu[] = array("name" => "Dasboard", "slug" => "#", "url" => "#", "class" => "fa-dashboard", "submenu" => $al_submenu);
            }
            if ($is_admin ||$user_type == "admin_lap" || $user_type == "admin_kan" || $user_type == "verifikasi" || $user_type == "manajer_keu") {

                $ar_submenu = array();
                //$ar_submenu[] = array("name" => "Penawaran Penjualan", "slug"=>"quotation","url" => "sales/quotation");
                //$ar_submenu[] = array("name" => "Form Penawaran", "slug"=>"offer","url" => "sales/offer");
                //$ar_submenu[] = array("name" => "Req Poyek", "slug"=>"order","url" => "sales/order");
                $ar_submenu[] = array("name" => "Data Proyek", "slug" => "s_invoices", "url" => "sales/s_invoices");
                $ar_submenu[] = array("name" => "Laporan Proyek", "slug" => "r_sales", "url" => "reports/r_sales");
                //$ar_submenu[] = array("name" => "Surat Jalan", "slug"=>"s_suratjalan","url" => "sales/s_suratjalan");
                //$ar_submenu[] = array("name" => "Status Proyek", "slug"=>"s_pengiriman","url" => "sales/s_pengiriman");
                //$ar_submenu[] = array("name" => "Pembayaran Proyek", "slug"=>"s_payments","url" => "sales/s_payments");
                //$ar_submenu[] = array("name" => "Export Proyek", "slug"=>"s_history","url" => "sales/s_history");
            
                // $ar_submenu[] = array("name" => "Penerimaaan Barang", "slug"=>"s_penerimaan","url" => "sales/s_penerimaan");
            
                $sidebar_menu[] = array("name" => "Data Proyek", "slug" => "#", "url" => "#", "class" => "fa-dollar", "submenu" => $ar_submenu);

                $ap_submenu = array();
                //$ap_submenu[] = array("name" => "History Penjualan","slug"=>"p_order", "url" => "purchase/p_order");
                //$ap_submenu[] = array("name" => "","slug"=>"request", "url" => "purchase/request");
                //$ap_submenu[] = array("name" => "Request Pembelian ke Holding","slug"=>"request_holding", "url" => "purchase/request_holding");
                //$ap_submenu[] = array("name" => "Order Pembelian", "slug"=>"p_order","url" => "purchase/p_order");
                $ap_submenu[] = array("name" => "Pembelian", "slug" => "p_invoices", "url" => "purchase/p_invoices");
                //$ap_submenu[] = array("name" => "Pembayaran Pembelian", "slug"=>"p_payments","url" => "purchase/p_payments");
                //$ap_submenu[] = array("name" => "History Pembelian", "slug"=>"p_history","url" => "purchase/p_history");
                $ap_submenu[] = array("name" => "Laporan Pembelian", "slug" => "r_purchase", "url" => "reports/r_purchase");
                // $ap_submenu[] = array("name" => "Pembelian ATK", "slug" => "p_invoices", "url" => "purchase/p_invoices/index_consumables");
            }
            if ($is_admin || $user_type == "staff" ||$user_type == "admin_lap" || $user_type == "admin_kan" || $user_type == "verifikasi" || $user_type == "manajer_keu") {
                $ap_submenu[] = array("name" => "Penggunaan ATK", "slug" => "p_invoices", "url" => "purchase/p_invoices/index_consumables_usage");

                $sidebar_menu[] = array("name" => "Pengeluaran Kantor", "slug" => "#", "url" => "#", "class" => "fa-shopping-cart", "submenu" => $ap_submenu);
            }
            if ($user_type == 'manager') {

                $ar_submenu = array();
                //$ar_submenu[] = array("name" => "Penawaran Penjualan", "slug"=>"quotation","url" => "sales/quotation");
                //$ar_submenu[] = array("name" => "Form Penawaran", "slug"=>"offer","url" => "sales/offer");
                //$ar_submenu[] = array("name" => "Req Poyek", "slug"=>"order","url" => "sales/order");
                $ar_submenu[] = array("name" => "Data Proyek", "slug" => "s_invoices", "url" => "sales/s_invoices");
                $ar_submenu[] = array("name" => "Laporan Proyek", "slug" => "r_sales", "url" => "reports/r_sales");
                //$ar_submenu[] = array("name" => "Surat Jalan", "slug"=>"s_suratjalan","url" => "sales/s_suratjalan");
                //$ar_submenu[] = array("name" => "Status Proyek", "slug"=>"s_pengiriman","url" => "sales/s_pengiriman");
                //$ar_submenu[] = array("name" => "Pembayaran Proyek", "slug"=>"s_payments","url" => "sales/s_payments");
                //$ar_submenu[] = array("name" => "Export Proyek", "slug"=>"s_history","url" => "sales/s_history");
            
                // $ar_submenu[] = array("name" => "Penerimaaan Barang", "slug"=>"s_penerimaan","url" => "sales/s_penerimaan");
            
                $sidebar_menu[] = array("name" => "Data Proyek", "slug" => "#", "url" => "#", "class" => "fa-dollar", "submenu" => $ar_submenu);

                $ap_submenu = array();
                //$ap_submenu[] = array("name" => "History Penjualan","slug"=>"p_order", "url" => "purchase/p_order");
                //$ap_submenu[] = array("name" => "","slug"=>"request", "url" => "purchase/request");
                //$ap_submenu[] = array("name" => "Request Pembelian ke Holding","slug"=>"request_holding", "url" => "purchase/request_holding");
                //$ap_submenu[] = array("name" => "Order Pembelian", "slug"=>"p_order","url" => "purchase/p_order");
                $ap_submenu[] = array("name" => "Pembelian", "slug" => "p_invoices", "url" => "purchase/p_invoices");
                //$ap_submenu[] = array("name" => "Pembayaran Pembelian", "slug"=>"p_payments","url" => "purchase/p_payments");
                //$ap_submenu[] = array("name" => "History Pembelian", "slug"=>"p_history","url" => "purchase/p_history");
                $ap_submenu[] = array("name" => "Laporan Pembelian", "slug" => "r_purchase", "url" => "reports/r_purchase");
                $ap_submenu[] = array("name" => "Penggajian", "slug" => "p_invoices", "url" => "purchase/p_invoices/gaji");

                $sidebar_menu[] = array("name" => "Pengeluaran Kantor", "slug" => "#", "url" => "#", "class" => "fa-shopping-cart", "submenu" => $ap_submenu);
            }
            $acc_submenu = array();

            if ($is_admin || $user_type == 'direktur_utama' || $user_type == 'manager' || $user_type == 'finance' || $user_type == "admin_kan" || $user_type == "akunting") {
                // $acc_submenu[] = array("name" => "Journal Entry", "slug"=>"journal_entry","url" => "accounting/journal_entry");
                //$acc_submenu[] = array("name" => "Expenses Entry", "slug"=>"expenses","url" => "accounting/expenses");
            }

            /* if($is_admin || $user_type == "manager" || $user_type == "super_admin" || $user_type == "sdm" ){
                 $acc_submenu[] = array("name" => "Salary Entry", "slug"=>"Salary","url" => "employees/salary");
             }*/

            //if($is_admin || $user_type == 'direktur_utama' || $user_type == 'direktur' || $user_type == 'manager' || $user_type == 'finance' || $user_type == "admin_kan" || $user_type == "akunting" || $user_type == "manajer_keu" || $user_type == "direktur"){
            //$acc_submenu[] = array("name" => "Journal Transaction", "slug"=>"journal_transaction","url" => "accounting/journal_transaction/entry");
            //$acc_submenu[] = array("name" => "Buku Besar", "slug"=>"general_ledger","url" => "accounting/general_ledger");
            //$acc_submenu[] = array("name" => "Balance Sheet","slug"=>"neraca", "url" => "accounting/neraca");
            // $acc_submenu[] = array("name" => "Neraca Saldo", "slug"=>"neraca_saldo","url" => "accounting/neraca_saldo"); 
            

            // $acc_submenu[] = array("name" => "Profit Loss Total", "slug"=>"labarugi_total","url" => "reports/labarugi_total");
            //$rpt_submenu[] = array("name" => "Profit Loss Project", "slug"=>"laba_rugi","url" => "reports/laba_rugi");
            
            // $acc_submenu[] = array("name" => "Neraca","slug"=>"neraca", "url" => "accounting/neraca");
            // $acc_submenu[] = array("name" => "Laba Rugi", "slug"=>"laba_rugi","url" => "reports/laba_rugi");
            //$acc_submenu[] = array("name" => "Perubahan Modal", "slug"=>"equity","url" => "reports/equity");
            //$acc_submenu[] = array("name" => "Laporan Penjualan", "slug"=>"r_sales","url" => "reports/r_sales");
            //$acc_submenu[] = array("name" => "Laporan Piutang Dagang", "slug"=>"aging_receivable","url" => "reports/aging_receivable");
            //$acc_submenu[] = array("name" => "Laporan Hutang Dagang", "slug"=>"aging_payable","url" => "reports/aging_payable");
            

            $acc_submenu[] = array("name" => "Laporan Pembelian", "slug" => "r_purchase", "url" => "reports/r_purchase");
            if ($is_admin || $user_type == 'manager') {
                $asset_submenu = array();
                $asset_submenu[] = array("name" => "Data Asset", "slug" => "assets", "url" => "master/assets");
            }


            if ($is_admin || $user_type == "super_admin" || $user_type == 'manager') {
                $sidebar_menu[] = array("name" => "Asset Kantor", "slug" => "", "url" => "#", "class" => "fa-search", "submenu" => $asset_submenu);

            }

            // $sidebar_menu[] = array("name" => "", "slug"=>"#","url" => "#", "class" => "fa-line-chart", "submenu" => $rpt_submenu);
            // MENU DATA MASTER INPUT
            $master_submenu = array();
            if ($is_admin || $user_type == "manager" || $user_type == "super_admin" || $user_type == "sdm" || $user_type == 'direktur') {
                $master_submenu[] = array("name" => "Karyawan", "slug" => "Karyawan", "url" => "team_members");
            }
            if ($is_admin || $user_type == "manager" || $user_type == "marketing" || $user_type == "super_admin" || $user_type == "admin_lap" || $user_type == "admin_kan" || $user_type == 'verifikasi') {
                $master_submenu[] = array("name" => "Customers", "slug" => "customers", "url" => "master/customers");
            }
            if ($is_admin || $user_type == "manager" || $user_type == "super_admin" || $user_type == "sdm" || $user_type == 'direktur') {
                $master_submenu[] = array("name" => "ATK", "slug" => "ATK", "url" => "master/consumables");
            }
            //if($is_admin || $user_type == "manager" || $user_type == "super_admin" || $user_type == "admin_lap" || $user_type == "admin_kan" || $user_type == 'verifikasi'){
            //    $master_submenu[] = array("name" => "Kode Kas", "slug"=>"kode_kas","url" => "master/kode_kas");
            //}
            //if($is_admin || $user_type == "manager" || $user_type == "super_admin" || $user_type == "admin_lap" || $user_type == "admin_kan" || $user_type == 'verifikasi'){
            //$master_submenu[] = array("name" => "Marketing", "slug"=>"marketing","url" => "master/marketing");
            //}
            //if($is_admin || $user_type == "manager" || $user_type == "super_admin" || $user_type == "admin_lap" || $user_type == "admin_kan"){
            //  $master_submenu[] = array("name" => "Vendors", "slug"=>"vendors","url" => "master/vendors");
            // }
            if ($is_admin || $user_type == "manager" || $user_type == "super_admin" || $user_type == "admin_lap" || $user_type == "admin_kan") {
                $master_submenu[] = array("name" => "Perusahaan", "slug" => "perusahaan", "url" => "master/perusahaan");
            }
            //if($is_admin || $user_type == "manager" || $user_type == "super_admin" || $user_type == "admin_lap" || $user_type == "admin_kan"){
            // $master_submenu[] = array("name" => "Kendaraan", "slug"=>"items","url" => "master/kendaraan");
            // }
            /*if($is_admin || $user_type == "manager" || $user_type == "super_admin"){
                $master_submenu[] = array("name" => "Tambang", "slug"=>"tambang","url" => "master/tambang");
            }*/
            // if($is_admin || $user_type == "manager" || $user_type == "super_admin" || $user_type == "admin_lap" || $user_type == "admin_kan"){
            // $master_submenu[] = array("name" => "Products", "slug"=>"items","url" => "master/items");
            // }
            //$master_submenu[] = array("name" => "Spareparts", "slug"=>"projects","url" => "master/sparepart");
            if ($is_admin || $user_type == "manager" || $user_type == "super_admin") {
                //$master_submenu[] = array("name" => "Projects", "slug"=>"projects","url" => "master/projects");
            
            }


            //$master_submenu_accounting = array();
            // $master_submenu_accounting[] = array("name" => "Chart Of Account", "slug"=>"coa","url" => "master/coa");
            // $master_submenu_accounting[] = array("name" => "COA Balance", "slug"=>"saldoawal","url" => "master/saldoawal");
            // $master_submenu_accounting[] = array("name" => "Fixed Assets", "slug"=>"assets","url" => "master/assets");
            

            // $master_submenu[] = array("name" => "payable", "url" => "accounting/payable");
            



            if ($is_admin || $user_type == "manager" || $user_type == "marketing" || $user_type == "super_admin" || $user_type == "sdm" || $user_type == "admin_lap" || $user_type == "admin_kan" || $user_type == 'direktur' || $user_type == 'verifikasi') {
                $sidebar_menu[] = array("name" => "General Master", "slug" => "", "url" => "#", "class" => "fa-list", "submenu" => $master_submenu);

            }


            // MENU DATA INVENTORY
            $inven_submenu = array();

            if ($is_admin || $user_type == "manager" || $user_type == "super_admin" || $user_type == "admin_lap" || $user_type == "logistik" || $user_type == "verifikasi" || $user_type == "direktur") {
                // $inven_submenu[] = array("name" => "Stock Produk", "slug"=>"material","url" => "inventory/material");
                // $inven_submenu[] = array("name" => "Laporan Stock Produk", "slug"=>"equipment_vehicle","url" => "reports/equipment_vehicle");
            }
            // $inven_submenu[] = array("name" => "Produksi", "slug"=>"material","url" => "inventory/produksi");
            //$inven_submenu[] = array("name" => "Spareparts", "slug"=>"sparepart","url" => "master/sparepart");
            //$inven_submenu[] = array("name" => "Produksi", "slug"=>"produksi","url" => "inventory/produksi");
            //$inven_submenu[] = array("name" => "Stok Opname", "slug"=>"stokopname","url" => "inventory/stokopname");
            if ($is_admin || $user_type == "manager" || $user_type == "super_admin" || $user_type == "admin_lap" || $user_type == "gudang" || $user_type == "verifikasi" || $user_type == "direktur") {
                // $inven_submenu[] = array("name" => "Vendors", "slug"=>"vendors","url" => "master/vendors");
                //$inven_submenu[] = array("name" => "Produksi Paket", "slug"=>"material","url" => "inventory/produksi");
            }
            if ($is_admin || $user_type == "manager" || $user_type == "super_admin") {
                //$inven_submenu[] = array("name" => "Tambang", "slug"=>"tambang","url" => "master/tambang");
            }
            //$inven_submenu[] = array("name" => "Products", "slug"=>"items","url" => "master/items");
            
            if ($is_admin || $user_type == "manager" || $user_type == "super_admin") {
                //$inven_submenu[] = array("name" => "Projects", "slug"=>"projects","url" => "master/projects");
            
            }
           


            // if($is_admin || $user_type == "manager" || $user_type == "super_admin" || $user_type == "gudang" || $user_type == "logistik" || $user_type == "admin_lap" || $user_type == "verifikasi" || $user_type == "direktur"){
            ///  $sidebar_menu[] = array("name" => "Stock Gudang", "slug"=>"","url" => "#", "class" => "fa-list", "submenu" => $inven_submenu);
            //     
            // }
            
            // MENU DATA PERLENGKAPAN
            //$spare_submenu = array();
            
            //if($is_admin || $user_type == "verifikasi" || $user_type == "logistik" || $user_type == "direktur" || $user_type == "manager"){
            //$spare_submenu[] = array("name" => "Perlengkapan Kantor", "slug"=>"sparepart","url" => "master/sparepart");
            //}
            if ($is_admin || $user_type == "verifikasi" || $user_type == "logistik" || $user_type == "direktur") {

                //$spare_submenu[] = array("name" => "Oli", "slug"=>"sparepart","url" => "master/sparepart/page/oli");
                //$spare_submenu[] = array("name" => "Solar", "slug"=>"sparepart","url" => "master/sparepart/page/solar");
            
            }

            if ($is_admin || $user_type == "gudang" || $user_type == "verifikasi" || $user_type == "direktur" || $user_type == "manager") {
                $spare_submenu[] = array("name" => "Pemakaian", "slug" => "sparepart", "url" => "inventory/pengeluaran");

            }

            //if($is_admin || $user_type == "manager" || $user_type == "super_admin" || $user_type == "sales" || $user_type == "gudang" || $user_type == "logistik" || $user_type == "admin_lap" || $user_type == "verifikasi" || $user_type == "direktur"){
            //   $sidebar_menu[] = array("name" => "Perlengkapan Kantor", "slug"=>"","url" => "#", "class" => "fa-list", "submenu" => $spare_submenu);
            
            //  }
            
            //$sidebar_menu[] = array("name" => "Pegawai","slug"=>"pegawai", "url" => "pegawai", "class" => "fa-user");
            
            // MENU DATA PERLENGKAPAN
            $gaji_submenu = array();

            /*if($is_admin || $user_type == "verifikasi" || $user_type == "logistik" || $user_type == "direktur"){
            $gaji_submenu[] = array("name" => "Salary", "slug"=>"sparepart","url" => "employees/gaji");
            }*/

            if ($is_admin || $user_type == "gudang" || $user_type == "verifikasi" || $user_type == "direktur") {
                $gaji_submenu[] = array("name" => "Jam Hole/Ritase", "slug" => "sparepart", "url" => "employees/jamholeritase");

            }

            //if($is_admin || $user_type == "gudang" || $user_type == "verifikasi" || $user_type == "direktur"){
            //  $gaji_submenu[] = array("name" => "UMK Setting", "slug"=>"sparepart","url" => "employees/umksetting");
            
            //}
            
            /*if($is_admin || $user_type == "manager" || $user_type == "super_admin" || $user_type == "sales" || $user_type == "gudang" || $user_type == "logistik" || $user_type == "admin_lap" || $user_type == "verifikasi" || $user_type == "direktur"){
                $sidebar_menu[] = array("name" => "Salary", "slug"=>"","url" => "#", "class" => "fa-list", "submenu" => $gaji_submenu);
            
            }*/


            // if($is_admin || $user_type == "super_admin" || $user_type == "akunting" || $user_type == "manajer_keu"){
            // $sidebar_menu[] = array("name" => "Master Account", "slug"=>"","url" => "#", "class" => "fa-list", "submenu" => $master_submenu_accounting);
            
            //}
            // ----- END MENU MASTER
            
            // MENU DATA TRACKING
            
            // ----- END MENU MASTER
            
            if ($is_admin || $user_type == "manager" || $user_type == "super_admin") {
                $sidebar_menu[] = array("name" => "Settings", "slug" => "general", "url" => "settings/general", "class" => "fa-cogs");
            }
            
            if ($is_admin || $user_type == "manager" || $user_type == "super_admin") {
                $sidebar_menu[] = array("name" => "Sync SSO Login", "slug" => "sync_sso", "url" => "SyncSso", "class" => "fa-cogs");
            }


            foreach ($sidebar_menu as $main_menu) {
                $submenu = get_array_value($main_menu, "submenu");
                $expend_class = $submenu ? " expand " : "";
                $active_class = active_menu($main_menu["slug"], $submenu);
                $submenu_open_class = "";
                if ($expend_class && $active_class) {
                    $submenu_open_class = " open ";
                }

                $devider_class = get_array_value($main_menu, "devider") ? "devider" : "";
                $badge = get_array_value($main_menu, "badge");
                $badge_class = get_array_value($main_menu, "badge_class");
                ?>
                <li
                    class="<?php echo $active_class . " " . $expend_class . " " . $submenu_open_class . " $devider_class"; ?> main">
                    <a href="<?php echo_uri($main_menu['url']); ?>">
                        <i class="fa <?php echo ($main_menu['class']); ?>"></i>
                        <span><?php echo $main_menu['name']; ?></span>
                        <?php
                        if ($badge) {
                            echo "<span class='badge $badge_class'>$badge</span>";
                        }
                        ?>
                    </a>
                    <?php
                    if ($submenu) {
                        echo "<ul>";
                        foreach ($submenu as $s_menu) {
                            ?>
                        <li>
                            <a href="<?php echo_uri($s_menu['url']); ?>">
                                <i class="dot fa fa-circle"></i>
                                <span><?php echo $s_menu['name']; ?></span>
                            </a>
                        </li>
                        <?php
                        }
                        echo "</ul>";
                    }
                    ?>
                </li>
            <?php } ?>
        </ul>

    </div>
    <?php $this->load->view('includes/footer'); ?>
</div><!-- sidebar menu end -->