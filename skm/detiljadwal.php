<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
printjudulmenu( "Detil Tanggal Jadwal Kuliah" );
$q = "SELECT jadwalkuliah.* ,makul.NAMA\r\nFROM jadwalkuliah,makul \r\nWHERE \r\njadwalkuliah.IDMAKUL=makul.ID AND\r\njadwalkuliah.ID='{$idupdate}'";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    echo "\r\n<table width=100%>\r\n  <tr valign=top>\r\n    <td width=50%>\r\n      <table class=form>\r\n        <tr valign=top>\r\n          <td width=150>Prodi</td>\r\n          <td nowrap><b>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n        </tr>\r\n        <tr valign=top >\r\n          <td>Tahun/Semester</td>\r\n          <td><b>".( $d[TAHUN] - 1 )."/{$d['TAHUN']} ".$arraysemester[$d[SEMESTER]]."</td>\r\n        </tr>\r\n        <tr valign=top >\r\n          <td>Mata Kuliah</td>\r\n          <td><b>{$d['IDMAKUL']}  - {$d['NAMA']} </td>\r\n        </tr>\r\n      </table>\r\n    </td>\r\n    <td>\r\n      <table class=form>\r\n        <tr valign=top >\r\n          <td>Ruangan / Kelas</td>\r\n          <td><b>".$arrayruangan[$d[IDRUANGAN]]."  / {$d['KELAS']} </td>\r\n        </tr>\r\n        <tr valign=top >\r\n          <td>Hari / Jam </td>\r\n          <td><b>".$arrayhari[$d[HARI]]."  / {$d['MULAI']} - {$d['SELESAI']} </td>\r\n        </tr>\r\n        <tr valign=top >\r\n          <td>Tim Pengajar </td>";
    $arraydosenjadwal = explode( "\n", $d[TIM] );
    echo "\r\n          <td><b>";
    foreach ( $arraydosenjadwal as $k => $v )
    {
        $iddosen = trim( $v );
        if ( $iddosen != "" )
        {
            echo "{$iddosen} ( ".$arraydosen[$iddosen]." ) <br>";
        }
    }
    echo "</td>\r\n        </tr>\r\n      </table>    \r\n    </td>\r\n  </tr>\r\n</table>\r\n  ";
    echo " \r\n  \r\n  \r\n  ";
	#$q = "SELECT jadwalkuliah.*,mahasiswa.NAMA,mahasiswa.ID FROM pengambilanmk,jadwalkuliah,mahasiswa WHERE jadwalkuliah.ID='{$idupdate}' AND jadwalkuliah.IDMAKUL=pengambilanmk.IDMAKUL AND pengambilanmk.IDMAHASISWA=mahasiswa.ID";
    $q = "\r\n\t\t\t\tSELECT mahasiswa.NAMA,mahasiswa.ID,mahasiswa.IDPRODI \r\n\t\t\t\tFROM mahasiswa,pengambilanmk\r\n\t\t\t\tWHERE \r\n\t\t\t\tmahasiswa.ID=pengambilanmk.IDMAHASISWA\r\n\t\t\t\tAND pengambilanmk.IDMAKUL='{$d['IDMAKUL']}'\r\n\t\t\t\tAND pengambilanmk.TAHUN='{$d['TAHUN']}'\r\n\t\t\t\tAND pengambilanmk.SEMESTER='{$d[SEMESTER]}'\r\n\t\t\t\t\r\n\t\t\t\tand mahasiswa.IDPRODI='{$d['IDPRODI']}'\r\n \t\t\t\tORDER BY mahasiswa.ID\r\n\t\t\t";

	#echo $q;
	$h = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $h ) <= 0 )
    {
        printmesg( "Data Mahasiswa belum ada" );
    }
    else
    {
        printjudulmenukecil( "Data Mahasiswa yang mengambil mata kuliah ini" );
        echo "\r\n\t\t\t\t\t<table {$border} class=form{$cetak}>\r\n\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t\t<td>NIM</td>\r\n\t\t\t\t\t\t<td>Nama</td>";
        $i = 1;
        #$semlama = "";
        while ( $d = sqlfetcharray( $h ) )
        {
            echo "\r\n\t\t\t\t\t<tr {$kelas}{$cetak}>\r\n\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t<td>{$d['ID']}</td>\r\n\t\t\t\t\t\t<td>{$d['NAMA']}</td></tr>";
			++$i;
		}   
        echo "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t<br style='page-break-after:always'>\r\n\t\t\t\t";
    }
}
else
{
    printmesg( "Data tidak ada" );
}
?>
