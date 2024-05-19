<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function getsettingkartu( )
{
    global $koneksi;
    $q = "SELECT * FROM settingkartu";
    $h = doquery($koneksi,$q);
    if ( sqlnumrows( $h ) <= 0 )
    {
        $q = "\r\n  INSERT INTO settingkartu \r\n  (PANJANG,LEBAR,ISFOTO,PANJANGF,LEBARF,LATAR,LATARWARNA,LATARFOTO,UPDATER,LASTUPDATE,\r\n  ISLOGOKIRI,ISLOGOKANAN,LOGOKIRI,LOGOKANAN,ALOGOKIRI,ALOGOKANAN,PLKIRI,LLKIRI,PLKANAN,LLKANAN) \r\n  VALUES \r\n  (86,54,1,30,20,0,'FFFFFF','','sistem',NOW(),\r\n  0,0,'','','','',0,0)\r\n  ";
        doquery($koneksi,$q);
        $q = "SELECT * FROM settingkartu";
        $h = doquery($koneksi,$q);
    }
    $d = sqlfetcharray( $h );
    return $d;
}

periksaroot( );
$arraytemplatekartu['template1'] = "Template 1";
$arraytemplatekartu['template2'] = "Template 2";
$arraytemplatekartu['template3'] = "Template 3";
$arrayfont['Antiqua'] = "Antiqua";
$arrayfont['Blackletter'] = "Blackletter";
$arrayfont['Calibri'] = "Calibri";
$arrayfont['Comic Sans'] = "Comic Sans";
$arrayfont['Courier'] = "Courier";
$arrayfont['Fraktur'] = "Fraktur";
$arrayfont['Garamond'] = "Garamond";
$arrayfont['Helvetica'] = "Helvetica";
$arrayfont['Palatino'] = "Palatino";
$arrayfont['Times'] = "Times";
$arraydatakartu[0][J] = "Nama Lengkap";
$arraydatakartu[0][F] = "NAMA";
$arraydatakartu[1][J] = "NPM";
$arraydatakartu[1][F] = "ID";
$arraydatakartu[2][J] = "Fakultas";
$arraydatakartu[2][F] = "NAMAF";
$arraydatakartu[3][J] = "Prodi";
$arraydatakartu[3][F] = "NAMAP";
$arraydatakartu[4][J] = "TTL";
$arraydatakartu[4][F] = "TTL";
$arraywarna[0] = "0";
$arraywarna[3] = "3";
$arraywarna[6] = "6";
$arraywarna[9] = "9";
$arraywarna[C] = "C";
$arraywarna[F] = "F";
?>
