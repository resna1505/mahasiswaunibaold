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
    if ( $jenis == "" )
    {
        include( "prosesrekapakademik.php" );
    }
    else if ( $jenis == "prodi" )
    {
        include( "prosesrekapakademikprodi.php" );
    }
    else if ( $jenis == "angkatan" )
    {
        include( "prosesrekapakademikangkatan.php" );
    }
    else if ( $jenis == "dosen" )
    {
        include( "prosesrekapakademikdosen.php" );
    }
    else if ( $jenis == "dpnaisi" )
    {
        include( "prosesrekapakademikdpnaisi.php" );
    }
    else if ( $jenis == "dpnakosong" )
    {
        include( "prosesrekapakademikdpnakosong.php" );
    }
}
if ( $aksi == "" )
{
    printjudulmenu( "REKAP KEGIATAN AKADEMIK PER SEMESTER" );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t\t".IKONLAPORAN48."\r\n\t\t<table  >\r\n \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td width=150>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td width=150>\r\n\t\t\t\t\tTahun Akademik\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\t<select name=tahun class=masukan> \r\n\t\t\t\t\t\t ";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( $i == $waktu[year] + 1 )
        {
            $cek = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>".( $i - 1 )."/{$i}</option>\r\n\t\t\t\t\t\t\t";
        $cek = "";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  \t\t<tr class=judulform>\r\n\t\t\t<td>Semester</td>\r\n\t\t\t<td>\r\n \r\n\t\t\t\t\t\t<select name=semester class=masukan> ";
    foreach ( $arraysemester as $k => $v )
    {
        echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t</td>\r\n\t\t</tr> \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tStatus Aktifitas\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arraystatusmahasiswa as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tStatus Awal\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=statusawal>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arraystatusmhsbaru as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr> \r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tampilkan' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\r\n\t\t</table>\r\n\t\t</form>\r\n \t";
}
?>
