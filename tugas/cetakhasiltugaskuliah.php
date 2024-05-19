<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$root = "../";
include( $root."sesiuser.php" );
include( $root."header.php" );
printhtmlcetak( );
include( "init.php" );
$cetak = $aksi = "cetak";
$border = " border=1 width=600 style='border-collapse:collapse'";
printjudulmenu( "Hasil Tugas Kuliah" );
printmesg( $errmesg );
$q = "SELECT tugaskuliah.* FROM tugaskuliah WHERE \r\n    IDBAHAN='{$idupdate}' AND\r\n    IDMAKUL='{$idmakulupdate}' AND\r\n    TAHUN='{$tahunupdate}' AND\r\n    SEMESTER='{$semesterupdate}' AND\r\n    KELAS='{$kelasupdate}'\r\n    ";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
echo "\r\n\t\t \r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" )."<tr class=judulform>\r\n\t\t\t<td>Mata Kuliah</td>\r\n\t\t\t<td>{$idmakulupdate}, ".getnamafromtabel( $idmakulupdate, "makul" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Tahun Ajaran</td>\r\n\t\t\t<td>".( $tahunupdate - 1 )."/{$tahunupdate}\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n\t\t<tr>\r\n\t\t\t<td class=judulform>Semester</td>\r\n\t\t\t<td >  ".$arraysemester[$semesterupdate]."  </td>\r\n\t\t</tr>\r\n  \t\t<tr class=judulform>\r\n\t\t\t<td class=judulform>Dosen Pengajar </td>\r\n\t\t\t<td>{$iddosenupdate}, ".getnamafromtabel( $iddosenupdate, "dosen" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Kode Kelas</td>\r\n\t\t\t<td>{$kelasupdate}</td>\r\n\t\t</tr>"."\r\n\t\t</table>\r\n \r\n\t\t";
echo "\r\n\t\t<table class=form>\r\n \t\t <tr valign=top class=judulform>\r\n\t\t\t<td class=judulform><b>Nama Tugas</td>\r\n\t\t\t<td>{$d['NAMA']}</td>\r\n\t\t</tr> \r\n  \r\n\t\t\t</table>\r\n\t\t\t \r\n <br>\r\n \r\n \t\t";
printjudulmenucetak( "Daftar Nilai" );
$q = "\r\n\t\t\tSELECT hasiltugaskuliah.*,mahasiswa.NAMA \r\n      FROM hasiltugaskuliah,mahasiswa\r\n\t\t\tWHERE IDMAKUL='{$idmakulupdate}'\r\n\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\tAND SEMESTER='{$semesterupdate}'\r\n\t\t\tAND hasiltugaskuliah.KELAS='{$kelasupdate}'\r\n\t\t\tAND mahasiswa.ID=hasiltugaskuliah.IDMAHASISWA\r\n\t\t\tORDER BY IDMAHASISWA\r\n\t\t";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    echo "\r\n \t\t <table {$border} class=formcetak width=90%>\r\n \r\n\t\t\t\t<tr class=juduldatacetak align=center>\r\n\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t<td>NIM Mahasiswa</td>\r\n\t\t\t\t\t<td>Nama</td>\r\n \r\n\t\t\t\t\t<td>Nilai</td>\r\n \r\n\t\t\t\t</tr>\r\n\t\t\t";
    $i = 1;
    $totalbobot = 0;
    $rata2 = 0;
    $total = 0;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $total += $d[NILAI];
        echo "\r\n\t\t\t\t\t<tr {$kelas}"."cetak valign=top align=center>\r\n\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t<td align=left >{$d['IDMAHASISWA']}</td>\r\n\t\t\t\t\t\t<td align=left >{$d['NAMA']}</td>\r\n  \t\t\t\t\t\t<td align=center> {$d['NILAI']} </td>\r\n \r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
        ++$i;
    }
    $rata2 = number_format_sikad( $total / ( $i - 1 ), 2 );
    echo "\r\n          <tr>\r\n            <td align=right colspan=3><b>Rata-rata nilai</td>\r\n            <td align=center><b>{$rata2}</td>\r\n          </tr>\r\n       </table>\r\n\t\t\t</form>\r\n       \r\n      ";
}
else
{
    $errmesg = "Data Hasil Tugas Kuliah belum ada";
    printmesg( $errmesg );
}
?>
