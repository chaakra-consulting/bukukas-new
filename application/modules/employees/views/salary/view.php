<style>
td{padding:2px;}
</style>

  <script
    type="text/javascript"
    src="//code.jquery.com/jquery-1.9.1.js"
    
  ></script>

 <script type="text/javascript">


    $(window).load(function(){
      
    $(function () {
        var tbl = $('#tbl_a');
        tbl.find('tr').each(function () {
            // $this = this;
            $(this).find('input[type=text]').bind("keyup", function () {
                calculateSum();
            });
        });

        function calculateSum() {
            var tbl = $('#tbl_a');
            tbl.find('tr').each(function () {
                var sum = 0;
                var pengurang = 0;
                $(this).find('.gaji').each(function () {
                    if (!isNaN(this.value) && this.value.length != 0) {
                        sum += parseFloat(this.value);
                    }
                });
                $(this).find('.pengurang').each(function () {
                    if (!isNaN(this.value) && this.value.length != 0) {
                        sum -= parseFloat(this.value);
                    }
                });

                $(this).find('.penambah').each(function () {
                    if (!isNaN(this.value) && this.value.length != 0) {
                        sum += parseFloat(this.value);
                    }
                });

                $(this).find('.total').val(sum.toFixed(2));
            });
        }
    });

    });

</script>

<div id="page-content" class="clearfix">
    <div style="max-width: 1000px; margin: auto;">
        <div class="page-title clearfix mt15">
            <h1> Salary <?php echo get_order_id($data_info->code); ?>
                
            </h1>
            <div class="title-button-group">
				
				<?php 
					if($ada==1&&$data_info->sa_status==1){
						echo anchor(get_uri("employees/salary/postingjurnal/".$data_info->id), "<i class='fa fa-plus-circle'></i> Posting ke Jurnal", array("class" => "btn btn-default", "title" => 'Posting ke Jurnal')); 
					}
						
						
				?>
                 <?php //echo modal_anchor(get_uri("inventory/pengeluaran/item_modal_form/".$data_info->id), "<i class='fa fa-plus-circle'></i> Tambah Item", array("class" => "btn btn-default", "title" => 'Tambah Item', "data-post-invoice_id" => $data_info->id)); ?>
                 <?php //echo modal_anchor(get_uri("inventory/pengeluaran/jadi_modal_form/".$data_info->id), "<i class='fa fa-plus-circle'></i> Tambah Barang Jadi", array("class" => "btn btn-default", "title" => 'Tambah Barang Jadi', "data-post-invoice_id" => $data_info->id)); ?>
				<?php /*
				  <span class="dropdown inline-block">
                    <button class="btn btn-info dropdown-toggle  mt0 mb0" type="button" data-toggle="dropdown" aria-expanded="true">
                        <i class='fa fa-cogs'></i> <?php echo lang('actions'); ?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        
                        <li role="presentation"><?php echo anchor(get_uri("purchase/p_order/download_pdf/" . $data_info->id), "<i class='fa fa-download'></i> " . lang('download_pdf'), array("title" => lang('download_pdf'))); ?> </li>
                        <li role="presentation"><?php echo anchor(get_uri("purchase/p_order/preview/" . $data_info->id ), "<i class='fa fa-search'></i> " . lang('invoice_preview'), array("title" => lang('invoice_preview')), array("target" => "_blank")); ?> </li>
                        <li role="presentation" class="divider"></li>
                        <li role="presentation"><?php echo modal_anchor(get_uri("purchase/p_order/modal_form_edit"), "<i class='fa fa-edit'></i> " . lang('edit_invoice'), array("title" => lang('edit_invoice'), "data-post-id" => $data_info->id, "role" => "menuitem", "tabindex" => "-1")); ?> </li>

                        
                    </ul>
                </span> 
				*/ ?>
            </div>
			
        </div>

        <div id="invoice-status-bar">
            
        </div>

        

        <div class="mt15">
            <div class="panel panel-default p15 b-t" >
               <div class="clearfix p20">
                    <div class="col-sm-12">
                        <table style="font-size:14px;width:100%;">
                             
                            <tr>
                                <td style="width:20%;"><b>Periode Salary</b></td>
                                <td><b>:</b></td>
                                <td> <?php echo jin_nama_bulan($data_info->sa_bulan) ?> - <?=$data_info->sa_tahun;?></td>
								
							<?php 
								if($ada==1){
									?>
                                <td><b>Informasi Posting</b></td>
                                <td><b>:</b></td>
                                <td> <?php if($data_info->sa_status==2){echo "Sudah Posting";}else{echo "Belum Posting";}?></td>
								<?php } ?>
                            </tr>
                            <tr>
                                <td><b>Keterangan</b></td>
                                <td><b>:</b></td>
                                <td> <?php echo $data_info->sa_keterangan;?></td>
								
							<?php 
								if($ada==1){
									?>
                                <td><b>Total Nominal Gaji</b></td>
                                <td><b>:</b></td>
                                <td> <?php echo $data_info->sa_total;?></td>
								<?php } ?>
                            </tr>
							 
                        </table>
                    </div> 
                </div>
				<br/>
				<b><h4>Data Salary Karyawan</h4></b><br/>
				 
                <div class="table-responsive">
					 <form action="<?=base_url();?>employees/salary/gajiupdate" method="post" enctype="multipart/form-data">
					 <div id="oke" style="overflow-y:scroll;height:300px;">
					<table  name="tbl_a" id="tbl_a" class="display" width="100%">            
						<tr><td style="width:180px;"><b>Nama </b></td><td><b>Gaji Pokok</b></td><td><b>Penambah</b></td><td><b>Keterangan Penambah</b></td><td><b>Pengurang</b></td><td><b>Keterangan Pengurang</b></td><td><b>Gaji Diterima</b></td></tr>
						<?php
							foreach($gaji as $peri){
								
								if($ada==0){
									$penambah=0;
									$ket_penambah='-';
									$pengurang=0;
									$ket_pengurang='-';
									$diterima=($peri->gaji)+$penambah-$pengurang;
									
								}else{ 
									$penambah=$peri->nominal_penambah;
									$ket_penambah=$peri->deskripsi_penambah;
									$pengurang=$peri->nominal_pengurang;
									$ket_pengurang=$peri->deskripsi_pengurang;
									$diterima=($peri->gaji)+$penambah-$pengurang;
								}
								echo '<tr><td>'.$peri->first_name.' '.$peri->last_name.'</td>
										<td><input type="text" class="form-control gaji" name="gaji[]"  value="'.$peri->gaji.'" /></td>
										<td><input type="text" class="form-control penambah" name="penambah[]" value="'.$penambah.'" /></td>
										<td><input type="text" class="form-control" name="ket_penambah[]" value="'.$ket_penambah.'" /></td>
										<td><input type="text" class="form-control pengurang" name="pengurang[]" value="'.$pengurang.'" /></td>	
										<td><input type="text" class="form-control" name="ket_pengurang[]" value="'.$ket_pengurang.'" /></td>	
										<td><input type="text" class="form-control total" name="total[]" value="'.$diterima.'" placeholder="total" /></td></tr>';
								echo '<input type="hidden" class="form-control" name="pegawai[]" value="'.$peri->pegawai_id.'" />';
								if($ada==1){
									echo '<input type="hidden" class="form-control" name="id_salary[]" value="'.$peri->salary_id.'" />';
								}
							}
						?>
						
                    </table>
					</div>
					<br>
					<br>
					<input type="hidden" name="id" value="<?=$data_info->id;?>">
					<input type="hidden" name="ada" value="<?=$ada;?>">
					<input type="hidden" name="bulan" value="<?=$data_info->sa_bulan;?>">
					<input type="hidden" name="tahun" value="<?=$data_info->sa_tahun;?>">
						<center><button id="form-submit" type="submit" class="btn btn-primary "><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></center>
					</form>
					
                <div style="clear:both;">&nbsp;<br /></div> 
                </div>
				&nbsp; 
				<br/>
				  
                <div class="clearfix">
					<div class="col-sm-8">
						&nbsp;
                    </div>
                     
                </div>

            </div>
        </div>&nbsp;
        

           
    </div>
</div>
