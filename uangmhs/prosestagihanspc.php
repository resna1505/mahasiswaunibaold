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
if ( $jenisfile == "HTML" || $jenisfile == "EXCEL" )
{
    $strtmp .= "\r\n                <table border=1>\r\n                \r\n                <tr align=center>\r\n                  <td><b>BILLING_NO</td>\r\n                  <td><b>PAYEE_ID</td>\r\n                  <td><b>BILL_FIRST_NAME</td>\r\n                  <td><b>ADDRESS_1</td>\r\n                  <td><b>BILL_REF_1</td>\r\n                  <td><b>BILL_REF_2</td>\r\n                  <td><b>BILL_REF_3</td>\r\n                  <td><b>BILL_REF_4</td>\r\n                  <td><b>BILL_REF_5</td>\r\n                   <td><b>AMOUNT_TOTAL</td>\r\n          \r\n                  ";
}
else if ( $jenisfile == "CSV" )
{
    if ( trim( $delimiter == "" ) )
    {
        $delimiter = ";";
    }
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
}
foreach ( $arraykolomspc as $idkomponen => $d )
{
    if ( $jenisfile == "HTML" || $jenisfile == "EXCEL" )
    {
        $strtmp .= "\r\n                <td><b>{$idkomponen}</td>\r\n               ";
    }
    else if ( $jenisfile == "CSV" )
    {
        $strtmp .= $idkomponen.$delimiter;
    }
}
if ( $jenisfile == "HTML" || $jenisfile == "EXCEL" )
{
    $strtmp .= "\r\n                  <td><b>AUTODEBET_ACC_D</td>\r\n                  <td><b>REGISTER_NO</td>\r\n                  <td><b>DUE_DATE</td>\r\n              \r\n              </tr>";
}
else if ( $jenisfile == "CSV" )
{
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
        $strtmp .= "\r\n               <tr >\r\n                  <td nowrap>{$d['IDMAHASISWA']}</td>\r\n                  <td nowrap>{$d['IDMAHASISWA']}</td>\r\n                  <td nowrap>{$d['NAMA']}</td>\r\n                  <td nowrap>".preg_replace( "/\\s+/", " ", $d[ALAMAT] )."</td>\r\n                  <td nowrap>{$d['NAMAFAKULTAS']}</td>\r\n                  <td nowrap>{$d['NAMAJURUSAN']}</td>\r\n                  <td nowrap>{$d['NAMAPRODI']} ".$arrayjenjang[$d[TINGKAT]]."</td>\r\n                  <td nowrap align=center>{$d['ANGKATAN']}</td>\r\n                  <td nowrap align=center>0</td>\r\n                   <td nowrap align=right>".intval( $arrayjumlahtagihan[$idmahasiswa] )."</td>\r\n                ";
    }
    else if ( $jenisfile == "CSV" )
    {
        $strtmp .= $d[IDMAHASISWA].$delimiter;
        $strtmp .= $d[IDMAHASISWA].$delimiter;
        $strtmp .= mysqli_real_escape_string($koneksi,$d[NAMA]).$delimiter;
        $strtmp .= mysqli_real_escape_string($koneksi,substr($d[ALAMAT],0,60)).$delimiter;
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
}
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
		header( "Content-Disposition: attachment; filename=\"datatagihan-".$tanggal.".csv\"" );
        #header( "Content-Disposition: attachment; filename=\"datatagihan.csv\"" );
        header( "Content-Length: ".strlen( $strtmp ) );
        echo $strtmp;
    }
}
?>
