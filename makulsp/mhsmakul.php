<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$q = "\r\n\t\t\t\tSELECT mahasiswa.NAMA,mahasiswa.ID,mahasiswa.IDPRODI \r\n\t\t\t\tFROM mahasiswa,pengambilanmksp\r\n\t\t\t\tWHERE \r\n\t\t\t\tmahasiswa.ID=pengambilanmksp.IDMAHASISWA\r\n\t\t\t\tAND pengambilanmksp.IDMAKUL='{$idmakul}'\r\n\t\t\t\tAND pengambilanmksp.TAHUN='{$tahun}'\r\n\t\t\t\tAND pengambilanmksp.SEMESTER='{$semester}'\r\n\t\t\t\t\r\n\t\t\t\tand mahasiswa.IDPRODI='{$idprodi}'\r\n \t\t\t\tORDER BY mahasiswa.ID\r\n\t\t\t";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "DAFTAR MAHASISWA PENGAMBIL MATA KULIAH SP" );
        echo "\r\n\t\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t<form target=_blank action='cetakmhsmakul.php' method=post>\r\n\t\t \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "idprodi", "{$idprodi}", "" ).createinputhidden( "idmakul", "{$idmakul}", "" ).createinputhidden( "namamakul", "{$namamakul}", "" ).createinputhidden( "tahun", "{$tahun}", "" ).createinputhidden( "kelas", "{$kelas}", "" ).createinputhidden( "semester", "{$semester}", "" )."\r\n\t\t\t\t{$qinput}\r\n\t\t\t\t\t</form>\r\n\t\t\t\t\t\t</td></tr></table>";
    }
    else
    {
        printjudulmenu( "DAFTAR MAHASISWA PENGAMBIL MATA KULIAH SP" );
    }
    echo "\r\n \t\t\t<table  >\r\n  \t\t\t<tr>\t\r\n\t\t\t\t<td class=judulform>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>".$arrayprodidep[$idprodi]." \r\n\t\t\t\t</td>\r\n\t\t\t</tr> \r\n      <tr class=judulform>\r\n\t\t\t<td>Kode Mata Kuliah</td>\r\n\t\t\t<td>{$idmakul} / {$namamakul}\r\n\t\t\t</td>\r\n\t\t</tr> \r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tTahun Akademik\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>".( $tahun - 1 )."/{$tahun} ".$arraysemester[$semester]." \r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t</table>\r\n  \t";
    echo "\r\n        \r\n        <table   {$border} class=data{$cetak} width=100%>";
    echo "\r\n\t\t\t\t\t<thead  style='display: table-header-group;' >\r\n\t\t\t\t\t <tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t\t<td {$rowspan}>NO</td>\r\n\t\t\t\t\t\t<td {$rowspan}>NIM</td>\r\n\t\t\t\t\t\t<td {$rowspan}>Nama</td> \r\n<!--\t\t\t\t\t\t<td {$rowspan}>Prodi</td> -->\r\n             </tr>\r\n  \t\t\t\t \r\n        </thead>";
    $i = 1;
    $totalbobot = 0;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t\t\t<tr {$kelas}{$cetak} {$heightrow} align=center>\r\n\t\t\t\t\t\t\t \r\n\t\r\n\t\t\t\t\t\t\t<td  align=center nowrap>{$i}</td>\r\n\t\t\t\t\t\t\t<td  align=left nowrap>{$d['ID']}</td>\r\n\t\t\t\t\t\t\t<td  align=left nowrap>{$d['NAMA']}</td> \r\n<!--\t\t\t\t\t\t\t<td  align=left nowrap>".$arrayprodidep[$d[IDPRODI]]."</td> -->\r\n  \t\t\t\t\t\t\t\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
        ++$i;
    }
    echo "</table>\r\n\t\t\t\t<br><br>\r\n        \r\n        ";
}
else
{
    $errmesg = "Data mahasiswa yang mengambil mata kuliah ini belum ada";
    printmesg( $errmesg );
}
echo "\r\n\t\t\t</td></tr>\r\n     </table> \r\n      ";
?>
