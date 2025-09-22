<!DOCTYPE html>
<html>
<head>
    <title>Neraca</title>


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
.glyphicon  {font-family: "Glyphicons Halflings"}
td .bold{
    font-weight: bold;
}
/*#start{
    height: 30px;
    border: 1px solid #ddd
}
#end{
    height: 30px;
    border: 1px solid #ddd
}*/
td label{
    padding: 5px 10px;
    font-weight: bold;
}
</style>
</head>
<body>

<?php 
$periode_default = date("Y")."-01-01";
$periode_now = date("Y-m-d");
if(!empty($_GET['start']) && !empty($_GET['end'])){
    $periode_default = $_GET['start'];
    $periode_now = $_GET['end'];
}

?>


<p style="text-align:center; font-size: 15px; font-weight: bold;"> Green Angelica<br>Laporan Neraca <br> Periode <?php echo format_to_date($periode_default)." - ".format_to_date($periode_now);  ?> </p>
    
    <hr>


<table  class="table table-bordered" id="table-print" style="">
   
    <tr style="background: lightgrey">
        <th style="width:35%; vertical-align: middle; text-align:center">NAMA AKUN </th>
        <th style="width:15%; vertical-align: middle; text-align:center">DEBIT </th>
        <th style="width:35%; vertical-align: middle; text-align:center">NAMA AKUN </th>
        <th style="width:15%; vertical-align: middle; text-align:center">KREDIT </th>
    </tr>
    <tr>
    <td colspan=2><strong>Asset Lancar</strong></td>
    <td colspan=2><strong>Kewajiban Jangka Pendek</strong></td>
    </tr>
    
<?php
    $no_dapat = 1;
    $jml_debet = 0;
    $jml_credit = 0;

     $year_periode=substr($periode_default, 0,4);
     $Debetnya=0;
     $Kreditnya=0;
    foreach ($getCoa->result() as $row) {

        $saldo_awal_debet = $this->Master_Saldoawal_model->getDebit($row->id,($year_periode));
        $saldo_awal_credit = $this->Master_Saldoawal_model->getCredit($row->id,($year_periode));

        $debet = $this->Accounting_model->getDebetKas($row->id,$periode_default,$periode_now);
        $credit = $this->Accounting_model->getCreditKas($row->id,$periode_default,$periode_now);

        $beban= $this->Accounting_model->get_kredit_total($periode_default,$periode_now);
   
        $html = "<tr>";
    
        if($row->parent == "Head"){
        }else{
            // $html .= '<td class="h_tengah"> '.$row->account_number.' </td>';
            if($row->normally == "Debet") {
                $debetino=($debet->debet+$saldo_awal_debet) - $credit->credit;
                 
                if($debetino>0){
                  
                    $html .= "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row->account_name."</td>";
                    $html .= '<td class="h_kanan">'.number_format($debetino, 0, 0, '.').'</td>';
                      $html .= "<td></td>";
                                 $html .= '<td></td>';
                
                }
            }   
              if($row->normally == "Kredit"){
                            //$labarugi=$pendapatan->jumlah-$beban->jumlah;
                            $credito=($credit->credit+$saldo_awal_credit) - $debet->debet;

                            if($credito<0 OR $credito>0){
                                $html .= "<td></td>";
                                 $html .= '<td></td>';
                                 $html .= "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row->account_name."</td>";
                                 $html .= '<td class="h_kanan">'.number_format($credito, 0, 0, '.').'</td>';
                                 
                                  
                            }
                    }


    }
         
        // $jml_dapat += $jumlah;
        $html .= '</tr>';
        echo $html;
        $jml_asetlancar += $debetino+$saldo_awal_debet;
        $jml_kewajibanpendek += $credito+$saldo_awal_credit;
        $no_dapat++;
    }

    
    ?>
    


     <tr>
    <td colspan=2><strong></strong></td>
    <td colspan=2><strong>Kewajiban Jangka Panjang</strong></td>
    </tr>


<?php
    $no_dapat = 1;
    $jml_debet = 0;
    $jml_credit = 0;

     $year_periode=substr($periode_default, 0,4);
     $Debetnya=0;
     $Kreditnya=0;
    foreach ($getCoaJangkaPanjang->result() as $row) {

        $saldo_awal_debet = $this->Master_Saldoawal_model->getDebit($row->id,($year_periode));
        $saldo_awal_credit = $this->Master_Saldoawal_model->getCredit($row->id,($year_periode));

        $debet = $this->Accounting_model->getDebetKas($row->id,$periode_default,$periode_now);
        $credit = $this->Accounting_model->getCreditKas($row->id,$periode_default,$periode_now);

        $beban= $this->Accounting_model->get_kredit_total($periode_default,$periode_now);
   
        $html = "<tr>";
    
        if($row->parent == "Head"){
        }else{
           
              if($row->normally == "Kredit"){
                            //$labarugi=$pendapatan->jumlah-$beban->jumlah;
                            $credito=($credit->credit+$saldo_awal_credit) - $debet->debet;

                            if($credito<0 OR $credito>0){
                                $html .= "<td></td>";
                                 $html .= '<td></td>';
                                 $html .= "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row->account_name."</td>";
                                 $html .= '<td class="h_kanan">'.number_format($credito, 0, 0, '.').'</td>';
                                 
                                  
                            }
                    }


    }
         
        // $jml_dapat += $jumlah;
        $html .= '</tr>';
        echo $html;
        $jml_kewajibanpanjang+= $credito+$saldo_awal_credit;
        $no_dapat++;
    }

    
    ?>
    

     <tr>
    <td><i>Jumlah Asset Lancar</i></td>
    <td class="h_kanan"><? echo number_format($jml_asetlancar,0,0,'.') ?></td>
    <td><i>Jumlah Kewajiban</i></td>
    <td class="h_kanan"><? echo number_format($jml_kewajibanpendek+$jml_kewajibanpanjang,0,0,'.') ?></td>
    </tr>
      <tr>
    <td colspan=2><strong>Asset Tidak Lancar</strong></td>
    <td colspan=2><strong>Modal</strong></td>
    </tr>


    <?php
    $no_dapat = 1;
    $jml_debet = 0;
    $jml_credit = 0;

     $year_periode=substr($periode_default, 0,4);
     $Debetnya=0;
     $Kreditnya=0;
    foreach ($getCoaAsetTidakLancar->result() as $row) {

        $saldo_awal_debet = $this->Master_Saldoawal_model->getDebit($row->id,($year_periode));
        $saldo_awal_credit = $this->Master_Saldoawal_model->getCredit($row->id,($year_periode));

        $debet = $this->Accounting_model->getDebetKas($row->id,$periode_default,$periode_now);
        $credit = $this->Accounting_model->getCreditKas($row->id,$periode_default,$periode_now);

        $pendapatan= $this->Accounting_model->get_debet_total($periode_default,$periode_now);
        $beban= $this->Accounting_model->get_kredit_total($periode_default,$periode_now);
   
        $html = "<tr>";
    
        if($row->parent == "Head"){
        }else{
            // $html .= '<td class="h_tengah"> '.$row->account_number.' </td>';
            if($row->normally == "Debet") {
                $debetino=($debet->debet+$saldo_awal_debet) - $credit->credit;
                 
                if($debetino>0){
                  
                    $html .= "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row->account_name."</td>";
                    $html .= '<td class="h_kanan">'.number_format($debetino, 0, 0, '.').'</td>';
                      $html .= "<td></td>";
                                 $html .= '<td></td>';
                
                }
            }   
              if($row->normally == "Kredit"){
                            //$labarugi=$pendapatan->jumlah-$beban->jumlah;
                            $credito=($credit->credit+$saldo_awal_credit) - $debet->debet;

                            if($credito>0){
                                $html .= "<td></td>";
                                 $html .= '<td></td>';
                                 $html .= "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row->account_name."</td>";
                                 $html .= '<td class="h_kanan">'.number_format($credito, 0, 0, '.').'</td>';
                                 
                                  
                            }
                    }


    }
         
        // $jml_dapat += $jumlah;
        $html .= '</tr>';
        echo $html;
        $jml_asettidaklancar += $debetino+$saldo_awal_debet;
        $jml_ekuitas+= $credito+$saldo_awal_credit;
        $labarugi=$pendapatan->jumlah-$beban->jumlah;
        $no_dapat++;
    }

    
    ?>
    
   <!--  <tr style="background: lightgrey">
        <td colspan="2" class="h_kanan"> Jumlah Pendapatan</td>
        <td class="h_kanan"><?php $jml_p = $jml_dapat;
        echo number_format(nsi_round($jml_p))   ?></td>
    </tr> -->
     <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Laba Periode Berjalan</td>
     <td class="h_kanan">(<? echo number_format($labarugi,0,0,'.') ?>)</td>
    </tr>

    <tr>
    <td><i>Jumlah Asset Tidak Lancar</i></td>
    <td class="h_kanan"><? echo number_format($jml_asettidaklancar,0,0,'.') ?></td>
    <td><i>Jumlah Akhir Modal</i></td>
     <td class="h_kanan">(<? echo number_format($labarugi-$jml_ekuitas,0,0,'.') ?>)</td>
    </tr>
<tr style="background-color: lightgrey; font-weight: bold">
    <td colspan="1" class="h_kanan" > JUMLAH ASSET LANCAR & TIDAK LANCAR </td>
        <td class="h_kanan"><?php echo number_format($jml_asetlancar+$jml_asettidaklancar, 0, 0, '.'); ?></td>
        <td class="h_kanan">JUMLAH MODAL & KEWAJIBAN</td>
        <td class="h_kanan"><?php echo number_format($jml_kewajibanpendek+$jml_kewajibanpanjang+$jml_ekuitas-($labarugi), 0, 0, '.'); ?></td>
    </tr>
</table>


</body>
</html>