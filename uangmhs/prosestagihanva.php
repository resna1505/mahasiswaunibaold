<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$strtmp = "";
unset( $arraykolomspc[''] );
#$jenisfile="CSV";
if ( $jenisfile == "HTML" || $jenisfile == "EXCEL" )
{
    $strtmp .= "\r\n                <table border=1>\r\n                \r\n                <tr align=center>\r\n                  <td><b>TRX_ID</td>\r\n                  <td><b>VIRTUAL_ACCOUNT</td>\r\n                  <td><b>CUSTOMER_NAME</td>\r\n                  <td><b>CUSTOMER_EMAIL</td>\r\n                  <td><b>CUSTOMER_PHONE</td>\r\n                  <td><b>TRX_AMOUNT</td>\r\n                  <td><b>EXPIRED_DATE</td>\r\n                  <td><b>EXPIRED_TIME</td>\r\n                  <td><b>DESCRIPTION</b></td>";
}
else if ( $jenisfile == "CSV" )
{
    if ( trim( $delimiter == "" ) )
    {
        $delimiter = ";";
    }
    $strtmp .= "\"trx_id\"".$delimiter;
    $strtmp .= "\"virtual_account\"".$delimiter;
    $strtmp .= "\"customer_name\"".$delimiter;
    $strtmp .= "\"customer_email\"".$delimiter;
    $strtmp .= "\"customer_phone\"".$delimiter;
    $strtmp .= "\"trx_amount\"".$delimiter;
    $strtmp .= "\"expired_date\"".$delimiter;
    $strtmp .= "\"expired_time\"".$delimiter;
    $strtmp .= "\"description\"";
	$strtmp .= "\n";
    #$strtmp .= "AMOUNT_TOTAL".$delimiter;
}
/*foreach ( $arraykolomspc as $idkomponen => $d )
{
    if ( $jenisfile == "HTML" || $jenisfile == "EXCEL" )
    {
        $strtmp .= "\r\n                <td><b>{$idkomponen}</td>\r\n               ";
    }
    else if ( $jenisfile == "CSV" )
    {
        $strtmp .= $idkomponen.$delimiter;
    }
}*/
/*if ( $jenisfile == "HTML" || $jenisfile == "EXCEL" )
{
    $strtmp .= "\r\n                  <td><b>AUTODEBET_ACC_D</td>\r\n                  <td><b>REGISTER_NO</td>\r\n                  <td><b>DUE_DATE</td>\r\n              \r\n              </tr>";
}
else if ( $jenisfile == "CSV" )
{
    $strtmp .= "AUTODEBET_ACC_D".$delimiter;
    $strtmp .= "REGISTER_NO".$delimiter;
    $strtmp .= "DUE_DATE".$delimiter;
    $strtmp .= "\n";
}*/
$i = 0;
#print_r($arraydatatagihan);exit();
foreach ($arraydatatagihan as $tagihan => $d ){
	#echo "<br>";
	#echo "ARRAYNYA=".$arraydatatagihan.",VALUE=".$d.'<br>';
	#print_r($tagihan);
	#echo "<br>";
	#echo "ARRAYNYA LAGI=";
	#print_r($d['IDKOMPONEN']);
	/*foreach ($d as $datatagihan => $d2 ){
		echo "<br>";
		
		echo "TAGIHAN=".$datatagihan;
		echo "<br>";
		echo "ARRAYNYA APA LAGI=";
		print_r($datatagihan);
	}*/
	#$strtmp.= "AAA".$tagihan;
	#echo '<br>';
	#$strtmp .= "\r\n               <tr >\r\n                  <td nowrap>{$d['TRXID']}</td>\r\n                  <td nowrap>{$d['VANUMB']}</td>\r\n                  <td nowrap>{$d['NAMA']}</td>\r\n                  <td nowrap>{$d['EMAIL']}</td>\r\n                  <td nowrap>{$d['HP']}</td><td nowrap align=right>".intval( $arrayjumlahtagihan[$d['IDMAHASISWA']][$d['IDKOMPONEN']] )."</td>\r\n                ";
   
	if ( $jenisfile == "HTML" || $jenisfile == "EXCEL" )
    {
		$strtmp .= "\r\n               <tr >\r\n                  <td nowrap>{$d['TRXID']}</td>\r\n                  <td nowrap>{$d['VANUMB']}</td>\r\n                  <td nowrap>{$d['NAMA']}</td>\r\n                  <td nowrap></td>\r\n                  <td nowrap></td><td nowrap align=right>".intval( $arrayjumlahtagihan[$d['IDMAHASISWA']][$d['IDKOMPONEN']] )."</td> <td nowrap>{$d['EXPDATE']}</td><td nowrap>{$d['EXPTIME']}</td>";
    }
    else if ( $jenisfile == "CSV" )
    {
        $strtmp .= '"'.$d['TRXID'].'"'.$delimiter;
        $strtmp .= '"'.$d['VANUMB'].'"'.$delimiter;
		$strtmp .= '"'.$d['NAMA'].'"'.$delimiter;
		$strtmp .= '""'.$delimiter;
		$strtmp .= '""'.$delimiter;
		$strtmp .= '"'.intval($arrayjumlahtagihan[$d['IDMAHASISWA']][$d['IDKOMPONEN']]).'"'.$delimiter;
		$strtmp .= '"'.$d['EXPDATE'].'"'.$delimiter;
		$strtmp .= '"'.$d['EXPTIME'].'"'.$delimiter;
		$strtmp .= '""';
		#$strtmp .= ''.$delimiter;
		$strtmp .= "\n";
        #$strtmp .= mysqli_real_escape_string($koneksi,$d[NAMA]).$delimiter;
        #$strtmp .= mysqli_real_escape_string($koneksi,$d[ALAMAT]).$delimiter;
        #$strtmp .= mysqli_real_escape_string($koneksi,$d[NAMAFAKULTAS]).$delimiter;
        #$strtmp .= mysqli_real_escape_string($koneksi,$d[NAMAJURUSAN]).$delimiter;
        #$strtmp .= $d[NAMAPRODI].$delimiter;
        #$strtmp .= $d[ANGKATAN].$delimiter;
        #$strtmp .= "0".$delimiter;
        #$strtmp .= intval($arrayjumlahtagihan[$idmahasiswa] ).$delimiter;
    }
}
/*foreach ( $arraydatamahasiswa as $idmahasiswa => $d )
{
    ++$i;
    if ( $jenisfile == "HTML" || $jenisfile == "EXCEL" )
    {
        $strtmp .= "\r\n               <tr >\r\n                  <td nowrap>{$d['IDMAHASISWA']}</td>\r\n                  <td nowrap>{$d['IDMAHASISWA']}</td>\r\n                  <td nowrap>{$d['NAMA']}</td>\r\n                  <td nowrap>".preg_replace( "/\\s+/", " ", $d[ALAMAT] )."</td>\r\n                  <td nowrap>{$d['NAMAFAKULTAS']}</td>\r\n                  <td nowrap>{$d['NAMAJURUSAN']}</td>\r\n                  <td nowrap>{$d['NAMAPRODI']} ".$arrayjenjang[$d[TINGKAT]]."</td>\r\n                  <td nowrap align=center>{$d['ANGKATAN']}</td>\r\n                  <td nowrap align=center>0</td>\r\n                   <td nowrap align=right>".intval( $arrayjumlahtagihan[$idmahasiswa] )."</td>\r\n                ";
    }
    else if ( $jenisfile == "CSV" )
    {
        $strtmp .= $d[IDMAHASISWA].$delimiter;
        $strtmp .= $d[IDMAHASISWA].$delimiter;
        $strtmp .= mysqli_real_escape_string($koneksi,$d[NAMA]).$delimiter;
        $strtmp .= mysqli_real_escape_string($koneksi,$d[ALAMAT]).$delimiter;
        $strtmp .= mysqli_real_escape_string($koneksi,$d[NAMAFAKULTAS]).$delimiter;
        $strtmp .= mysqli_real_escape_string($koneksi,$d[NAMAJURUSAN]).$delimiter;
        $strtmp .= $d[NAMAPRODI].$delimiter;
        $strtmp .= $d[ANGKATAN].$delimiter;
        $strtmp .= "0".$delimiter;
        $strtmp .= intval($arrayjumlahtagihan[$idmahasiswa] ).$delimiter;
    }
    foreach ( $arraykolomspc as $idkomponen => $d2 )
    {
        if ( $jenisfile == "HTML" || $jenisfile == "EXCEL" )
        {
            $strtmp .= "\r\n                  <td  nowrap align=right>".intval( $arraydatatagihan[$idmahasiswa][$arrayidspc[$idkomponen]][JUMLAH] )."  </td>";
        }
        else if ( $jenisfile == "CSV" )
        {
            $strtmp .= intval( $arraydatatagihan[$idmahasiswa][$arrayidspc[$idkomponen]][JUMLAH] ).$delimiter;
        }
    }
    if ( $jenisfile == "HTML" || $jenisfile == "EXCEL" )
    {
        $strtmp .= "\r\n                  <td nowrap>0</td>\r\n                  <td nowrap>0</td>\r\n                  <td nowrap>0</td>\r\n              \r\n              </tr>";
    }
    else if ( $jenisfile == "CSV" )
    {
        #$strtmp .= "0".$delimiter;
        #$strtmp .= "0".$delimiter;
        #$strtmp .= "0".$delimiter;
		$strtmp .= "".$delimiter;
        $strtmp .= "".$delimiter;
        $strtmp .= "".$delimiter;
        $strtmp .= "\n";
    }
}*/
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
		header( "Content-Disposition: attachment; filename=\"tagihan-".$arrayjenjang[$d['TINGKAT']]."-".$d['NAMAJURUSAN']."-".$d['ANGKATAN']."-".$d['GELOMBANG']."-".$d['KODEREKENING']."-".$tanggal.".csv\"" );
        #header( "Content-Disposition: attachment; filename=\"datatagihan.csv\"" );
        header( "Content-Length: ".strlen( $strtmp ) );
        echo $strtmp;
    }
}
?>
