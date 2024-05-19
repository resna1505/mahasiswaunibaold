<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
printjudulmenu( "SETTING TAMPILAN" );
if ( $aksi == "Simpan" && $pilihan == "setting" )
{
    $settingtampilan = "";
    if ( is_array( $arraysetting ) )
    {
        foreach ( $arraysetting as $k => $v )
        {
            $settingtampilan .= "{$k}={$v};";
        }
        $q = "UPDATE {$tabeluser} SET SETTINGTAMPILAN='{$settingtampilan}'\r\n    WHERE ID='{$users}'\r\n    ";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Setting tampilan berhasil disimpan. Untuk melihat hasil perubahan, silakan klik menu mana saja.";
            foreach ( $arraysetting as $k => $v )
            {
                $_SESSION['TAMPILAN'][$k] = $v;
            }
        }
        else
        {
            $errmesg = "Setting tampilan tidak disimpan.";
        }
    }
}
unset( $arraysetting );
$q = "SELECT SETTINGTAMPILAN FROM {$tabeluser} WHERE ID='{$users}'";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$tmp = explode( ";", trim( $d['SETTINGTAMPILAN'] ) );
if ( is_array( $tmp ) )
{
    foreach ( $tmp as $k => $v )
    {
        $tmp2 = explode( "=", $v );
        $arraysetting[trim( $tmp2[0] )] = trim( $tmp2[1] );
    }
}
$cekvertikal = $cekklasik = $cekhorizontal = "";
if ( $arraysetting['MENUUTAMA'] == 0 || $arraysetting['MENUUTAMA'] == "" )
{
    $cekhorizontal = "checked";
}
else
{
    $cekvertikal = "checked";
}
$cektampil = $cektidaktampil = "";
if ( $arraysetting['SUBMENU'] == 0 || $arraysetting['SUBMENU'] == "" )
{
    $cektidaktampil = "checked";
}
else if ( $arraysetting['SUBMENU'] == 1 )
{
    $cektampil = "checked";
}
printmesg( $errmesg );
echo "\r\n<form method=post  name=form action=index.php>\r\n  <input type=hidden name=pilihan value='{$pilihan}'>\r\n  <table class=form>\r\n    <tr valign=top>\r\n      <td nowrap width=150>MENU UTAMA</td>\r\n      <td nowrap>\r\n        <!-- <input type=radio name='arraysetting[MENUUTAMA]' value=0 {$cekklasik}> Klasik <br> -->\r\n        <input type=radio name='arraysetting[MENUUTAMA]' value=0 {$cekhorizontal}> Horizontal Drop Down <br>\r\n        <input type=radio name='arraysetting[MENUUTAMA]' value=1 {$cekvertikal}> Vertikal Drop Down  \r\n      </td>\r\n    </tr>\r\n    <tr valign=top>\r\n      <td nowrap width=150>SUB MENU</td>\r\n      <td nowrap>\r\n        <input type=radio name='arraysetting[SUBMENU]' value=0 {$cektidaktampil}>Tidak Tampil<br>\r\n        <input type=radio name='arraysetting[SUBMENU]' value=1 {$cektampil}>Tampil<br>\r\n       </td>\r\n    </tr>\r\n    <tr valign=top>\r\n      <td nowrap width=150> </td>\r\n      <td nowrap>\r\n        <input type=submit name=aksi value='Simpan'>  \r\n               </td>\r\n    </tr>\r\n  </table>\r\n</form>\r\n";
?>
