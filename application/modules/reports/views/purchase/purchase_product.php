<div id="page-content" class="clearfix">
	<?php
    load_css(array(
        "assets/css/invoice.css"
    ));
    ?>
    <div style="max-width: 1000px; margin: auto;">
        
        <div id="invoice-status-bar" class="panel panel-default  p5 no-border m0">

        	<form action="" method="GET" role="form" class="general-form">
               <table class="table table-bordered">
                   <tr>
                        <td>
                        	<input type="text" class="form-control" id="start_date" name="start" autocomplete="off" placeholder="START DATE" value="<?php echo $_GET['start'] ?>">
                        </td>
						<td>
							<input type="text" class="form-control" id="end_date" name="end" autocomplete="off" placeholder="END DATE" value="<?php echo $_GET['end'] ?>">
                        </td>
                         <td><select name="paid" id="paid" class="form-control">
                            <option value="PAID">Terbayar</option>
                            <option value="Not Paid">Belum Bayar</option>
                            </select></td>
                                                    <td>
                            <select name="code" id="code" class="form-control">
                                <option value="">Nomor Akun</option>
                                <option value="501 - Operasional">501 - Operasional</option>
                                <option value="502 - Transport">502 - Transport</option>
                                <option value="503 - Perlengapan Kantor">503 - Perlengapan Kantor</option>
                                <option value="504 - Konsumsi">504 - Konsumsi</option>
                                <option value="505 - Pos dan Materai">505 - Pos dan Materai</option>
                                <option value="506 - Gaji">506 - Gaji</option>
                                <option value="507 - Beban Pajak">507 - Beban Pajak</option>
                                <option value="508 - Pulsa Handphone">508 - Pulsa Handphone</option>
                                <option value="509 - Listrik & Air">509 - Listrik & Air</option>
                                <option value="510 - Internet">510 - Internet</option>
                                <option value="511 - Maintenance Inventaris">511 - Maintenance Inventaris</option>
                                <option value="512 - Beban Kirim">512 - Beban Kirim</option>
                                <option value="513 - Promosi">513 - Promosi</option>
                            </select>
                        </td>
                        <td>
                            <button type="submit" name="search" class="btn btn-default" value="2"><i class=" fa fa-search"></i> Filter</button>
                            <a href="#" name="print"  class="btn btn-default" onclick="tableToExcel('table-print', 'Lap_Pembelian')"><i class=" fa fa-file-excel-o"></i> Excel</a>

                        </td>
                   </tr>
               </table>
               </form>
        </div>

        <div class="mt15">
            <div class="panel panel-default p15 b-t">
            	<div>
            		<table class="table table-bordered" id="table-print">
                         <tr>
                            <th colspan="5">
                              <center><h3>Laporan Pembelian Chaakra</h3>

                    <p><strong><?php echo $date_range ?></strong></p><p><strong><?php echo $paid ?></strong></p>
                            </th>

                        </tr>
            			<tr>
            				<th>Rincian</th>
            				<th style="text-align: center;">Pembelian</th>
            				<th style="text-align: center;">Nomer Akun</th>
            				<th style="text-align: center;">Jumlah</th>
            				<th style="text-align: center;">Total Rupiah</th>
            			</tr>
            			<tbody>
            			<?php $jumlah = 0; $qty = 0; foreach($purchase_report->result() as $row){ ?>
                            <tr>
                                <td><?php  echo $row->memo; ?></td>
                                <td style="text-align: center;"><?php  
                            if ($row->paid == "PAID") {
                                echo "Terbayar";
                            } else {
                                echo $row->paid;
                            }
                            ?></td>
                            <td style="text-align: center;"><?php  echo $row->code; ?></td>
            				<td style="text-align: center;"><?php  echo $row->qty; $qty += $row->qty; ?></td>
            				<td style="text-align: right;"><?php  echo to_currency($row->total,false); $jumlah += $row->total; ?></td>

            				
            			</tr>
            			<?php } ?>
            			</tbody>
            			<tfoot>
            				<tr>
            					<th colspan="3" style="text-align: right;">TOTAL :</th>
								<th style="text-align: center;"><?php echo $qty; ?></th>
								<th style="text-align: right;"><?php  echo to_currency($jumlah,false); ?></th>
            				</tr>
            			</tfoot>
            		</table>
            	</div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        setDatePicker("#start_date");
        setDatePicker("#end_date");
    });
</script>