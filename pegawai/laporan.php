<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi == "tampilkan" )
{
    include( "proseslaporan.php" );
}
if ( $aksi == "" )
{
    printjudulmenu( "Laporan Jumlah Data Operator" );
    printmesg( $errmesg );
    echo "<form action=index.php?pilihan=laporan method=post>\r\n<input type=hidden name=pilihan value=\"laporan\">\r\n<input type=hidden name=aksi value=\"tampilkan\">\r\n<input type=hidden name=sort value=\"ID\">\r\n<table class=form >\r\n\r\n\t<tr>\r\n\t\t<td>\r\n\t\t\tPengelompokan Baris\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t\t";
    echo "<s";
    echo "elect name=klpb class=masukan>\r\n\t\t\t";
    foreach ( $arraynamagrup as $k => $v )
    {
        echo "<option value='{$k}'>{$v}";
    }
    echo "\t\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td>\r\n\t\t\tPengelompokan Kolom\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t\t";
    echo "<s";
    echo "elect name=klpk class=masukan>\r\n\t\t\t";
    foreach ( $arraynamagrup as $k => $v )
    {
        echo "<option value='{$k}'>{$v}";
    }
    echo "\t\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td colspan=2>\r\n\t\t\t<hr>\r\n\t\t</td>\r\n\t</tr>\r\n";
    include( "filteruser.php" );
    echo "\r\n\r\n\t<tr valign=top>\r\n\t\t<td></td><td><br>\r\n\t\t\t<input class=tombol type=submit value='  OK  '>\r\n\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t</td>\r\n\t</tr>\r\n</table>\r\n</form>\r\n\r\n";
}
?>
