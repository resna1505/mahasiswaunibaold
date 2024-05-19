<?php
/*print_r($arraydatakomponen).'ARRAY KOLOM SPC<br>';
print_r($arraykolomspc).'ARRAY DATA TAGIHAN<br>';
print_r($arrayjumlahtagihan).'<br>';
exit();*/
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$strtmp = "";
#unset( $arraykolomspc[''] );
if ( $jenisfile == "HTML" || $jenisfile == "EXCEL" )
{
    $strtmp .= "\r\n                <table border=1>\r\n                \r\n                <tr align=center>\r\n                  <td><b>No</td>\r\n                  <td><b>NIM</td>\r\n                  <td><b>Nama</td>\r\n                  <td><b>Angkatan</td>\r\n                  <td><b>Program Studi</td>\r\n                  <td><b>Jumlah Tagihan</td>\r\n          \r\n                  ";
}
else if ( $jenisfile == "CSV" )
{
    if ( trim( $delimiter == "" ) )
    {
        $delimiter = ";";
    }
    /*$strtmp .= "No".$delimiter;
    $strtmp .= "NIM".$delimiter;
    $strtmp .= "Nama".$delimiter;
    $strtmp .= "Angkatan".$delimiter;
    $strtmp .= "Program Studi".$delimiter;
    $strtmp .= "Jumlah Tagihan".$delimiter;*/
	$strtmp .= "BILLING_NO".$delimiter;
    $strtmp .= "PAYEE_ID".$delimiter;
    $strtmp .= "BILL_FIRST_NAME".$delimiter;
    $strtmp .= "ADDRESS_1".$delimiter;
    $strtmp .= "BILL_REF_1".$delimiter;
    $strtmp .= "BILL_REF_2".$delimiter;
    $strtmp .= "BILL_REF_3".$delimiter;
    $strtmp .= "BILL_REF_4".$delimiter;
    $strtmp .= "BILL_REF_5".$delimiter;
    $strtmp .= "AMOUNT_TOTAL".$delimiter;
	$strtmp .= "AMOUNT_1".$delimiter;
	$strtmp .= "AMOUNT_2".$delimiter;
	$strtmp .= "AMOUNT_3".$delimiter;
	$strtmp .= "AMOUNT_4".$delimiter;
	$strtmp .= "AMOUNT_5".$delimiter;
	$strtmp .= "AMOUNT_6".$delimiter;
	$strtmp .= "AMOUNT_7".$delimiter;
	$strtmp .= "AMOUNT_8".$delimiter;
	$strtmp .= "AMOUNT_9".$delimiter;
	$strtmp .= "AMOUNT_10".$delimiter;
}
#foreach ( $arraydatakomponen as $idkomponen => $d )
#foreach ( $arraykolomspc as $idkomponen => $d )
/*{
    if ( $jenisfile == "HTML" || $jenisfile == "EXCEL" )
    {
        $strtmp .= "\r\n                <td><b>".$arraykomponenpembayaran[$idkomponen]."</td>\r\n               ";
    }
    else if ( $jenisfile == "CSV" )
    {
        $strtmp .= $arraykomponenpembayaran[$idkomponen].$delimiter;
		#$strtmp .= $idkomponen.$delimiter;
    }
}*/
if ( $jenisfile == "HTML" || $jenisfile == "EXCEL" )
{
    $strtmp .= "</tr>";
}
else if ( $jenisfile == "CSV" )
{
    #$strtmp .= $delimiter."\n";
	$strtmp .= "AUTODEBET_ACC_D".$delimiter;
    $strtmp .= "REGISTER_NO".$delimiter;
    $strtmp .= "DUE_DATE".$delimiter;
    $strtmp .= "\n";
}
$i = 0;

foreach ( $arraydatamahasiswa as $idmahasiswa => $d )
{
    ++$i;
    if ( $jenisfile == "HTML" || $jenisfile == "EXCEL" )
    {
        $strtmp .= "\r\n               <tr >\r\n                  <td nowrap>{$i}</td>\r\n                  <td nowrap>{$d['IDMAHASISWA']}</td>\r\n                  <td nowrap>{$d['NAMA']}</td>\r\n                  <td nowrap align=center>{$d['ANGKATAN']}</td>\r\n                  <td nowrap>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n                  <td nowrap align=right>".intval( $arrayjumlahtagihan[$idmahasiswa] )."</td>\r\n                ";
    }
    else if ( $jenisfile == "CSV" )
    {
        /*$strtmp .= $i.$delimiter;
        $strtmp .= $d[IDMAHASISWA].$delimiter;
        $strtmp .= $d[NAMA].$delimiter;
        $strtmp .= $d[ANGKATAN].$delimiter;
        $strtmp .= $arrayprodidep[$d[IDPRODI]].$delimiter;
        $strtmp .= intval( $arrayjumlahtagihan[$idmahasiswa] ).$delimiter;*/
		$strtmp .= $d[IDMAHASISWA].$delimiter;
        $strtmp .= $d[IDMAHASISWA].$delimiter;
        $strtmp .= $d[NAMA].$delimiter;
        $strtmp .= $d[ALAMAT].$delimiter;
        $strtmp .= $d[NAMAFAKULTAS].$delimiter;
        $strtmp .= $d[NAMAJURUSAN].$delimiter;
        $strtmp .= $d[NAMAPRODI].$delimiter;
        $strtmp .= $d[ANGKATAN].$delimiter;
        $strtmp .= "0".$delimiter;
        $strtmp .= intval( $arrayjumlahtagihan[$idmahasiswa] ).$delimiter;
    }
	$total_data=0;
    foreach ( $arraydatakomponen as $idkomponen => $d2 )
	#foreach ( $arraykolomspc as $idkomponen => $d2 )
    {
        if ( $jenisfile == "HTML" || $jenisfile == "EXCEL" )
        {
            $strtmp .= "\r\n                  <td  nowrap align=right>".intval( $arraydatatagihan[$idmahasiswa][$idkomponen][JUMLAH] )."</td>";
        }
        else if ( $jenisfile == "CSV" )
        {
            $strtmp .= intval( $arraydatatagihan[$idmahasiswa][$idkomponen][JUMLAH] ).$delimiter;
			#$strtmp .= intval( $arraydatatagihan[$idmahasiswa][$arrayidspc[$idkomponen]][JUMLAH] ).$delimiter;

        }
		
		#for($i=1;)
		$total_data=$total_data+1;
		$total_data++;
    }
	
	$total_data_amount=12-$total_data;
	#echo $total_data.'aaa'.$total_data_amount;
	for($i=1;$i<=$total_data_amount;$i++){
	
		$strtmp .= "0".$delimiter;
	}
	
    if ( $jenisfile == "HTML" || $jenisfile == "EXCEL" )
    {
        $strtmp .= "</tr>";
    }
    else if ( $jenisfile == "CSV" )
    {
        #$strtmp .= $delimiter."\n";
		$strtmp .= "".$delimiter;
        $strtmp .= "".$delimiter;
        $strtmp .= "".$delimiter;
        $strtmp .= "\n";
    }
}
#exit();
if ( $jenisfile == "HTML" || $jenisfile == "EXCEL" )
{
    $strtmp .= "</table>";
    if ( $jenisfile == "HTML" )
    {
        echo $strtmp;
    }
    else
    {
        header( "Cache-Control: no-store, no-cache, must-revalidate" );
        header( "Cache-Control: post-check=0, pre-check=0", false );
        header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
        header( "Last-Modified: ".gmdate( "D, d M Y H:i:s" )." GMT" );
        header( "Pragma: no-cache" );
        header( "Content-Type: application/octet-stream" );
        header( "Content-Type: application/force-download\n" );
        header( "Content-Type: application/vnd.ms-excel\n" );
        header( "Content-Disposition: attachment; filename=\"datatagihan.xls\"" );
        header( "Content-Length: ".strlen( $strtmp ) );
        echo $strtmp;
    }
}
else
{
    if ( $jenisfile == "CSV" )
    {
		$tanggal=date('Y-m-d-H:i:s');
        header( "Cache-Control: no-store, no-cache, must-revalidate" );
        header( "Cache-Control: post-check=0, pre-check=0", false );
        header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
        header( "Last-Modified: ".gmdate( "D, d M Y H:i:s" )." GMT" );
        header( "Pragma: no-cache" );
        header( "Content-Type: application/octet-stream" );
        header( "Content-Type: application/force-download\n" );
        #header( "Content-Disposition: attachment; filename=\"datatagihan.csv\"" );
		header( "Content-Disposition: attachment; filename=\"datatagihan-".$tanggal.".csv\"" );
        header( "Content-Length: ".strlen( $strtmp ) );
        echo $strtmp;
    }
}
/*if ( $jenisfile == "HTML" )
{
    echo $strtmp;
}
else
{
	if ( $jenisfile == "EXCEL" )
    {
    header( "Cache-Control: no-store, no-cache, must-revalidate" );
    header( "Cache-Control: post-check=0, pre-check=0", false );
    header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
    header( "Last-Modified: ".gmdate( "D, d M Y H:i:s" )." GMT" );
    header( "Pragma: no-cache" );
    header( "Content-Type: application/octet-stream" );
    header( "Content-Type: application/force-download\n" );
    header( "Content-Type: application/vnd.ms-excel\n" );
    header( "Content-Disposition: attachment; filename=\"datatagihan.xls\"" );
    header( "Content-Length: ".strlen( $strtmp ) );
    echo $strtmp;
	}
    #return 1;
    elseif ( $jenisfile == "CSV" )
    {
        header( "Cache-Control: no-store, no-cache, must-revalidate" );
        header( "Cache-Control: post-check=0, pre-check=0", false );
        header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
        header( "Last-Modified: ".gmdate( "D, d M Y H:i:s" )." GMT" );
        header( "Pragma: no-cache" );
        header( "Content-Type: application/octet-stream" );
        header( "Content-Type: application/force-download\n" );
        header( "Content-Disposition: attachment; filename=\"datatagihan.csv\"" );
        header( "Content-Length: ".strlen( $strtmp ) );
        echo $strtmp;
    }
}*/
?>
