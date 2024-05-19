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
    include( "prosesrekap.php" );
}
if ( $aksi == "" )
{
    printjudulmenu( "Rekap Data Mahasiswa" );
    printmesg( $errmesg );
    echo "<form action=index.php  method=post>\r\n<input type=hidden name=pilihan value=\"mrekap\">\r\n<input type=hidden name=aksi value=\"tampilkan\">\r\n<input type=hidden name=sort value=\"ID\">\r\n<table class=form >\r\n\r\n\t<tr>\r\n\t\t<td width=150>\r\n\t\t\tPengelompokan Baris\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t\t";
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
    echo "\t\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td>\r\n\t\t\tGrafik Terhadap Total\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t  <input type=checkbox name=grafik value=1> Ya\r\n \t\t</td>\r\n\t</tr>\r\n\r\n\r\n\t<tr>\r\n\t\t<td colspan=2>\r\n\t\t\t<b>FILTER<hr>\r\n\t\t</td>\r\n\t</tr>\r\n";
    echo "\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tAngkatan\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\t<select name=angkatan class=masukan> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tStatus\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arraystatusmahasiswa as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr> \r\n \r\n ";
    echo "\r\n\r\n\t<tr valign=top>\r\n\t\t<td></td><td><br>\r\n\t\t\t<input class=tombol type=submit value='  OK  '>\r\n\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t</td>\r\n\t</tr>\r\n</table>\r\n</form>\r\n\r\n";
}
?>
