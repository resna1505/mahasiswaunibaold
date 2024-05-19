<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$headerSMS = strtoupper( trim( $dx[KODE] ) );
$url = trim( $dx[URL] );
$url = str_replace( basename( $url ), "prosessms_sikad.php", $url );
$dmail[to] = $d[HP];
$postfields = "ID_PROGRAM=".urlencode( ID_PROGRAM );
$postfields .= "&TUJUAN=".urlencode( $dmail[to] );
$postfields .= "&PESAN=".urlencode( strip_tags( $dmail[body] ) );
$ch = curl_init( );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
curl_setopt( $ch, CURLOPT_URL, $url."?".$postfields );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
$hasil = curl_exec( $ch );
if ( curl_errno( $ch ) )
{
    $errorcurl = curl_error( $ch );
    $hasilakhir = "0";
}
curl_close( $ch );
if ( $hasil == "1" )
{
    $ketemail = "Terkirim via SMS.";
}
else
{
    $ketemail = "Tidak terkirim via SMS";
}
?>
