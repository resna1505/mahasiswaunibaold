<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "proseskosong.php" );
}
if ( $aksi == "" )
{
    printjudulmenu( "Cari Ruang Kosong" );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t\t".IKONCARI48."\r\n\t\t<table  >\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td width=150>\r\n\t\t\t\t\tSemester/Tahun Akademik\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=semester>\r\n\t\t\t\t\t ";
    foreach ( $arraysemester as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
        break;
    }
    echo "\r\n\t\t\t\t\t</select>/\r\n\t\t\t\t\t<select class=masukan name=tahun>\r\n\t\t\t\t\t\t ";
    $selected = "";
    $i = 1901;
    while ( $i <= $w[year] + 10 )
    {
        $selected = "";
        if ( $i == $w[year] )
        {
            $selected = "selected";
        }
        echo "<option {$selected} value='{$i}'>".( $i - 1 )."/{$i}</option>";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tHari\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=hari>\r\n\t\t\t\t\t\t ";
    foreach ( $arrayhari as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\tRentang Waktu\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
    if ( $jamawal == "" )
    {
        $jamawal = "07:00:00";
    }
    if ( $jamakhir == "" )
    {
        $jamakhir = "22:00:00";
    }
    echo "\r\n\t\t\t\t<input type=text size=8 name=jamawal value='{$jamawal}'>s.d\r\n\t\t\t\t<input type=text size=8 name=jamakhir value='{$jamakhir}'> (jj:mm:dd)\r\n \t\t\t\t</td>\r\n\t\t\t</tr>\t\t\t\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tampilkan' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>";
}
?>
