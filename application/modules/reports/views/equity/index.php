<!-- Styler -->
<style type="text/css">
.panel * {
	font-family: "Arial","​Helvetica","​sans-serif";
}
.fa {
	font-family: "FontAwesome";
}
.datagrid-header-row * {
	font-weight: bold;
}
.messager-window * a:focus, .messager-window * span:focus {
	color: blue;
	font-weight: bold;
}
.daterangepicker * {
	font-family: "Source Sans Pro","Arial","​Helvetica","​sans-serif";
	box-sizing: border-box;
}
.glyphicon	{font-family: "Glyphicons Halflings"}

	
</style>
<?php 
$periode_default = date("Y")."-01-01";
$periode_now = date("Y-m-d");
if(!empty($_GET['start']) && !empty($_GET['end'])){
    $periode_default = $_GET['start'];
    $periode_now = $_GET['end'];
}

$month=1;
$year=date('Y');
$type=$month;
$project=false;

if(!empty($_GET['month'])){
    $month = $_GET['month'];
}
if(!empty($_GET['year'])){
    $year = $_GET['year'];
}
if(!empty($_GET['type'])){
    $type = $_GET['type'];
}

if(!empty($_GET['project'])){
    $project = $_GET['project'];
}
if($project=='')$project=false;

$type2=$type;
if($type==1){
	$type2=$month;
}else{
	$type2=($month+$type)-1;
}
$loop=$type2;
if($loop>12)$loop=12;
$ararymonth=array(
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Augustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        );

?>
<div id="page-content" class="clearfix">
    <div style="max-width: 1000px; margin: auto;">
        
        <div id="invoice-status-bar">
        	<div class="panel panel-default  p5 no-border m0">
            
            <span class="ml15">
	                <form action="" method="GET" role="form" class="general-form">
	               <table class="table table-bordered">
	                   <tr>
	                       <!--<td><label>Start Date</label></td>
	                       <td><input type="text" class="form-control" name="start" id="start" value="<?php echo $periode_default ?>" autocomplete="off">
	                       </td>
	                        <td><label>End Date</label></td>
	                       <td><input type="text" class="form-control" name="end" id="end" value="<?php echo $periode_now ?>" autocomplete="off"></td>-->
	                       <td><select class="form-control" name="month" >
			                <option value="1" <?php if ($month == 1) echo 'selected' ?>>January</option>
			                <option value="2" <?php if ($month == 2) echo 'selected' ?>>February</option>
			                <option value="3" <?php if ($month == 3) echo 'selected' ?>>March</option>
			                <option value="4" <?php if ($month == 4) echo 'selected' ?>>April</option>
			                <option value="5" <?php if ($month == 5) echo 'selected' ?>>May</option>
			                <option value="6" <?php if ($month == 6) echo 'selected' ?>>June</option>
			                <option value="7" <?php if ($month == 7) echo 'selected' ?>>July</option>
			                <option value="8" <?php if ($month == 8) echo 'selected' ?>>August</option>
			                <option value="9" <?php if ($month == 9) echo 'selected' ?>>September</option>
			                <option value="10" <?php if ($month == 10) echo 'selected' ?>>October</option>
			                <option value="11" <?php if ($month == 11) echo 'selected' ?>>November</option>
			                <option value="12" <?php if ($month == 12) echo 'selected' ?>>December</option>
			            </select></td></td>
	                        <td>
	                        	<select class="form-control" name="year">
	                        		<?php for($a=date('Y');$a>=2017;$a--){?>

	                        			<option value="<?php echo $a?>" <?php if ($year == $a) echo 'selected' ?>><?php echo $a?></option>
	                        		<?php } ?>

	                        	</select>

	                        </td>

	                        <td><select name="type" class="form-control"><option value="1" <?php if ($type == 1) echo 'selected' ?>>1 Month</option><option value="3" <?php if ($type == 3) echo 'selected' ?>>3 Month</option><option value="6" <?php if ($type == 6) echo 'selected' ?>>6 Month</option><option value="12" <?php if ($type == 12) echo 'selected' ?>>12 Month</option></select></td>
	                        <td>
	                        	<select class="form-control" name="project">
	                        		<option value="">--Semua Project--</option>
	                        		<?php foreach($data_project->result() as $r){?>

	                        			<option value="<?php echo $r->id?>" <?php if($project==$r->id)echo 'selected';?>><?php echo $r->project_name?>(<?php echo $r->company_name?>)</option>
	                        		<?php } ?>

	                        	</select>

	                        </td>
	                        <td>
	                            <button type="submit" name="search" class="btn btn-default" value="1"><i class=" fa fa-search"></i> Filter</button>
	                           <a href="#" name="print"  class="btn btn-default" onclick="tableToExcel('table-print', 'equity_change_statement')"><i class=" fa fa-file-excel-o"></i> Excel</a>

	                        </td>
	                   </tr>
	               </table>
	               </form>
                </span>

            </div>
        </div>

        

        <div class="mt15">
            <div class="panel panel-default p15 b-t">
                

                <div class="table-responsive mt15 pl15 pr15">


	
	<hr>



<table  class="table table-bordered" id="table-print" style="">
    <tr>
        <th colspan="<?php echo (($loop-$month)+3)?>"><p style="text-align:center; font-size: 15pt; font-weight: bold;"> Laporan Equity Change of Statement Periode <?php echo $ararymonth[($month-1)]." - ".$ararymonth[($loop-1)];  ?> <?php echo $year?></p>
</th>
<tr><td colspan="<?php echo (($loop-$month)+3)?>"><b>Modal Awal</b> </td></tr>
	<tr style="background: lightgrey">
		<th style="width:5%; vertical-align: middle; text-align:center" > No. </th>
		<th style="width:75%; vertical-align: middle; text-align:center">Keterangan </th>
		<?php for ($i=($month-1); $i <$loop ;$i++) { ?>
				<th style="width:20%; vertical-align: middle; text-align:center"><?php echo $ararymonth[$i]?> </th>
		<?php }	?> 

	</tr>
	
	<?php
	$no_dapat = 1;
	$jml_dapat =array(0,0,0,0,0,0,0,0,0,0,0,0,0);

	foreach ($data_ekuitas as $row) {
		echo '
				<tr>
					<td class="h_tengah"> '.$row->account_number.' </td>
		';
		if(strlen($row->account_type)==4){

			echo '<td><b>'.$row->account_name.'</b></td>';
				
		}else if(strlen($row->account_number)==4){
				echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row->account_name.'</td>';
		}
		for ($i=($month-1); $i <$loop ;$i++) {

			$jml_akun = $this->Equity_model->get_modal_akun_month($row->id,($i+1),$year,$project);
			$jumlah1 = $jml_akun->jum_kredit-$jml_akun->jum_debet;
			
				if(strlen($row->account_number)==4){
					echo '<td class="h_kanan"><b>'.number_format(nsi_round($jumlah1), 0, 0, '.').'</b></td>';
						$jml_dapat1[$i] += $jumlah1;
					}else{
						echo '<td class="h_kanan">'.number_format(nsi_round($jumlah1), 0, 0, '.').'</td>';
					}
			}
			echo '</tr>';
			$no_dapat++;
		
	}
	?>
	<!--<tr style="background: lightgrey">
		<td colspan="2" class="h_kanan"> <b>MODAL AWAL</b></td>
		<?php for ($i=($month-1); $i <$loop ;$i++) {?>
		<td class="h_kanan"><b><?php $jml_1 = $jml_dapat1[$i];
		echo number_format(nsi_round($jml_1))   ?></b></td>
	<?php } ?>
	</tr>-->

	<?php
	$no_dapat = 1;
	$jml_dapat =array(0,0,0,0,0,0,0,0,0,0,0,0,0);

	foreach ($data_dapat as $row) {
		
		for ($i=($month-1); $i <$loop ;$i++) {

			$jml_akun = $this->Equity_model->get_jml_akun_month($row->id,($i+1),$year,$project);
			$jumlah = $jml_akun->jum_debet + $jml_akun->jum_kredit;
				if(strlen($row->account_number)==4){
					echo '<input type="hidden" value="'.number_format(nsi_round($jumlah)).'">';
						$jml_dapat[$i] += $jumlah;
					}else{
						echo '<td class="h_kanan">'.number_format(nsi_round($jumlah)).'</td>';
					}
			}
			echo '</tr>';
			$no_dapat++;
		
	}
	?>

		<?php for ($i=($month-1); $i <$loop ;$i++) {?>
		<input type="hidden" value="<?php $jml_p = $jml_dapat[$i];
		echo number_format(nsi_round($jml_p))   ?>">
	<?php } ?>

	<?php 
		$no=1;
		$jml_beban_operasional =array(0,0,0,0,0,0,0,0,0,0,0,0,0);
		foreach ($data_biaya as $row) {
			

			for ($i=($month-1); $i <$loop ;$i++) {
				$jml_akun = $this->Equity_model->get_jml_akun_month($row->id,($i+1),$year,$project,$row->account_number);
				//echo $this->db->last_query();exit();
				$jumlah_beban = $jml_akun->jum_debet + $jml_akun->jum_kredit;
				if(strlen($row->account_number)==4){
					echo '<input type="hidden" value="'.number_format(nsi_round($jumlah_beban), 0, 0, '.').'">';
						$jml_beban_operasional[$i] += $jumlah_beban;
					}else{
						echo '<td class="h_kanan">'.number_format(nsi_round($jumlah_beban), 0, 0, '.').'</td>';
						//$jml_beban_operasional[$i] += $jumlah_beban;
					}
		}
		echo '</tr>';
		$no_beban++;
	}
	?>

	<?php 
		$no=1;
		$jml_beban_non =array(0,0,0,0,0,0,0,0,0,0,0,0,0);
		foreach ($data_biaya_other as $row) {
			
		for ($i=($month-1); $i <$loop ;$i++) {
				$jml_akun = $this->Equity_model->get_jml_akun_month($row->id,($i+1),$year,$project);
				$jumlah = $jml_akun->jum_debet + $jml_akun->jum_kredit;
				if(strlen($row->account_number)==4){
					//echo '<td class="h_kanan"><b>'.number_format(nsi_round($jumlah), 0, 0, '.').'</b></td>';
						$jml_beban_non[$i] += $jumlah;
				}else{
						//echo '<td class="h_kanan">'.number_format(nsi_round($jumlah), 0, 0, '.').'</td>';
				}
		}
		echo '</tr>';
		$no_beban++;
	}
	?>
	
		<?php for ($i=($month-1); $i <$loop ;$i++) {?>
		<input type="hidden" value="<?php $jml_p = $jml_beban_operasional[$i];
		echo number_format(nsi_round($jml_p))   ?>">
		<?php } ?>
	
		<tr style="background: lightgrey">
		<td colspan="2" class="h_kanan"><b>Laba/Rugi Bersih Sebelum Pajak</b></td>
		<?php for ($i=($month-1); $i <$loop ;$i++) {?>
		<td class="h_kanan"><b><?php $jml_p = $jml_dapat[$i]-$jml_beban_operasional[$i]-$jml_beban_non[$i];
		echo number_format(nsi_round($jml_p), 0, 0, '.')   ?></b></td>
	<?php } ?>

	<?php
	$no_dapat = 1;
	$jml_dapat =array(0,0,0,0,0,0,0,0,0,0,0,0,0);

	foreach ($data_prive as $row) {
		echo '
				<tr>
					<td class="h_tengah"> '.$row->account_number.' </td>
		';
		if(strlen($row->account_number)==4){

			echo '<td><b>'.$row->account_name.'</b></td>';
				
		}else if(strlen($row->account_number)==4){
				echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row->account_name.'</td>';
		}
		for ($i=($month-1); $i <$loop ;$i++) {

			$jml_akun = $this->Equity_model->get_jml_akun_month($row->id,($i+1),$year,$project);
			$jumlahPrive = $jml_akun->jum_kredit-$jml_akun->jum_debet;
				if(strlen($row->account_number)==4){
					echo '<td class="h_kanan"><b>'.number_format(nsi_round($jumlahPrive)).'</b></td>';
						$jml_prive[$i] += $jumlahPrive;
					}else{
						echo '<td class="h_kanan">'.number_format(nsi_round($jumlahPrive)).'</td>';
					}
			}
			echo '</tr>';
			$no_dapat++;
		
	}
	?>
	<!--<tr style="background: lightgrey">
		<td colspan="2" class="h_kanan"> <b>PRIVE</b></td>
		<?php for ($i=($month-1); $i <$loop ;$i++) {?>
		<td class="h_kanan"><b><?php $jml_prive = $jml_prive[$i];
		echo number_format(nsi_round($jml_prive))   ?></b></td>
	<?php } ?>
	</tr>-->


	<tr style="background: lightgrey">
		<td colspan="2" class="h_kanan"><b>MODAL AKHIR</b></td>
		<?php for ($i=($month-1); $i <$loop ;$i++) {?>
		<td class="h_kanan"><b><?php $jml_modal = $jml_dapat1[$i]+$jml_p-$jml_prive[$i];
		echo number_format(nsi_round($jml_modal), 0, 0, '.')   ?></b></td>
	<?php } ?>
	</tr>
</table>



</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {

setDatePicker("#start");
   setDatePicker("#end");

});
</script>