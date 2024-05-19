<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function getsettingkoptranskripfakultas( $id )
{
    global $koneksi;
    $q = "SELECT * FROM settingkoptranskripfakultas WHERE ID='{$id}' ";
    $h = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $h ) <= 0 )
    {
        $q = "\r\n  INSERT INTO settingkoptranskripfakultas\r\n  (ID) \r\n  VALUES \r\n  ('{$id}')\r\n  ";
        mysqli_query($koneksi,$q);
        echo mysqli_error($koneksi);
        $q = "SELECT * FROM settingkoptranskripfakultas WHERE ID='{$id}' ";
        $h = mysqli_query($koneksi,$q);
    }
    $d = sqlfetcharray( $h );
    return $d;
}

function getsettingkoptranskrip( )
{
    global $koneksi;
    $q = "SELECT * FROM settingkoptranskrip";
    $h = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $h ) <= 0 )
    {
        $q = "\r\n  INSERT INTO settingkoptranskrip \r\n  (PANJANG,LEBAR,ISFOTO,PANJANGF,LEBARF,LATAR,LATARWARNA,LATARFOTO,UPDATER,LASTUPDATE,\r\n  ISLOGOKIRI,ISLOGOKANAN,LOGOKIRI,LOGOKANAN,ALOGOKIRI,ALOGOKANAN,PLKIRI,LLKIRI,PLKANAN,LLKANAN) \r\n  VALUES \r\n  (86,54,1,30,20,0,'FFFFFF','','sistem',NOW(),\r\n  0,0,'','','','',0,0,'','')\r\n  ";
        mysqli_query($koneksi,$q);
        $q = "SELECT * FROM settingkoptranskrip";
        $h = mysqli_query($koneksi,$q);
    }
    $d = sqlfetcharray( $h );
    return $d;
}

function getsettingkop( )
{
    global $koneksi;
    $q = "SELECT * FROM settingkop";
	#echo $q;exit();
    $h = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $h ) <= 0 )
    {
        $q = "\r\n  INSERT INTO settingkop \r\n  (PANJANG,LEBAR,ISFOTO,PANJANGF,LEBARF,LATAR,LATARWARNA,LATARFOTO,UPDATER,LASTUPDATE,\r\n  ISLOGOKIRI,ISLOGOKANAN,LOGOKIRI,LOGOKANAN,ALOGOKIRI,ALOGOKANAN,PLKIRI,LLKIRI,PLKANAN,LLKANAN) \r\n  VALUES \r\n  (86,54,1,30,20,0,'FFFFFF','','sistem',NOW(),\r\n  0,0,'','','','',0,0,'','')\r\n  ";
        mysqli_query($koneksi,$q);
        $q = "SELECT * FROM settingkop";
        $h = mysqli_query($koneksi,$q);
    }
    $d = sqlfetcharray( $h );
    return $d;
}

function getsettingkopfakultas( $id )
{
    global $koneksi;
    $q = "SELECT * FROM settingkopfakultas WHERE ID='{$id}' ";
    $h = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $h ) <= 0 )
    {
        $q = "\r\n  INSERT INTO settingkopfakultas\r\n  (ID) \r\n  VALUES \r\n  ('{$id}')\r\n  ";
        mysqli_query($koneksi,$q);
        echo mysqli_error($koneksi);
        $q = "SELECT * FROM settingkopfakultas WHERE ID='{$id}' ";
        $h = mysqli_query($koneksi,$q);
    }
    $d = sqlfetcharray( $h );
    return $d;
}

?>
