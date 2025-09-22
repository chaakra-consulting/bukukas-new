<!DOCTYPE html>
<html>
<head>
    <title>Neraca Saldo </title>


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


<p style="text-align:center; font-size: 15px; font-weight: bold;"> Green Angelica  <br>Laporan Neraca Saldo <br> Periode <?php echo format_to_date($periode_default)." - ".format_to_date($periode_now);  ?> </p>
    
    <hr>


<table border="1" style="border: 1px solid #ddd;font-size:10px">
    <tr style="background: lightgrey"><!-- 
        <th style="width:10%; vertical-align: middle; text-align:center" ></th> -->
        <th style="width:55%; vertical-align: middle; text-align:center">NAMA AKUN </th>
        <th style="width:20%; vertical-align: middle; text-align:center"> DEBIT  </th>
        <th style="width:20%; vertical-align: middle; text-align:center"> KREDIT  </th>
    </tr>
    

    <?php
    $no_dapat = 1;
    $jml_debet = 0;
    $jml_credit = 0;

     $year_periode=substr($periode_default, 0,4);
    foreach ($getCoa->result() as $row) {

        $saldo_awal_debet = $this->Master_Saldoawal_model->getDebit($row->id,($year_periode));
        $saldo_awal_credit = $this->Master_Saldoawal_model->getCredit($row->id,($year_periode));

        $debet = $this->Accounting_model->getDebetKas($row->id,$periode_default,$periode_now);
        $credit = $this->Accounting_model->getCreditKas($row->id,$periode_default,$periode_now);

        // $saldo_awal_debet = $this->Master_Saldoawal_model->getDebit($row->id,$periode_now);
        // $saldo_awal_credit= $this->Master_Saldoawal_model->getCredit($row->id,$periode_now);




        // $jumlah = $jml_akun->jum_debet + $jml_akun->jum_kredit;
        $html = "<tr>";
        if($row->parent == "Head"){
            $html .= '<td class="" colspan="3"> <strong>'.$row->account_name.'</strong> </td>';
            // $html .= "<td colspan='3' ><strong>".$row->account_name."</strong><td>";
        
        }else{
            // $html .= '<td class="h_tengah"> '.$row->account_number.' </td>';
            if($row->normally == "Debet"){
                $html .= "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row->account_name."</td>";
            $html .= '<td class="h_kanan">'.number_format(($debet->debet+$saldo_awal_debet) - $credit->credit, 0, 0, '.').'</td>';
            $html .= '<td class="h_kanan">'.number_format(0).'</td>';
            }else{
                $html .= "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row->account_name."</td>";
                $html .= '<td class="h_kanan">'.number_format(0).'</td>';
                $html .= '<td class="h_kanan">'.number_format(($credit->credit+$saldo_awal_credit)-$debet->debet, 0, 0, '.').'</td>';


            }
        
        }
        // $jml_dapat += $jumlah;
        $html .= '</tr>';
        echo $html;
        $jml_debet += $debet->debet+$saldo_awal_debet;
        $jml_credit += $credit->credit+$saldo_awal_credit;
        $no_dapat++;
    }
    ?>
   <!--  <tr style="background: lightgrey">
        <td colspan="2" class="h_kanan"> Jumlah Pendapatan</td>
        <td class="h_kanan"><?php $jml_p = $jml_dapat;
        echo number_format(nsi_round($jml_p))   ?></td>
    </tr> -->
<tr style="background-color: lightgrey; font-weight: bold">
    <td  class="h_kanan" > SALDO </td>
        <td class="h_kanan"><?php echo number_format($jml_debet, 0, 0, '.'); ?></td>
        <td class="h_kanan"><?php echo number_format($jml_credit, 0, 0, '.'); ?></td>
    </tr>
</table>


</body>
</html>