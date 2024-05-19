<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$SMSOK = 0;
$q = "SELECT * FROM konfigsms LIMIT 0,1";
$hx = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $hx ) )
{
    $dx = sqlfetcharray( $hx );
    $headerSMS = strtoupper( trim( $dx[KODE] ) );
    $url = trim( $dx[URL] );
    $url = str_replace( basename( $url ), "prosessms_sikad.php", $url );
    $postfields = "ID_PROGRAM=".urlencode( ID_PROGRAM );
    $postfields .= "&TES=1";
    $ch = curl_init( );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
    curl_setopt( $ch, CURLOPT_URL, $url."?".$postfields );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    $hasil = curl_exec( $ch );
    if ( curl_errno( $ch ) )
    {
        $errorcurl = curl_error( $ch );
    }
    curl_close( $ch );
    if ( $hasil == "1" )
    {
        $SMSOK = 1;
    }
    else
    {
        $SMSOK = 0 - 1;
    }
}
else
{
    $SMSOK = 0;
}
?>
