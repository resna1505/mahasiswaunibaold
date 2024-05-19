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
include( "init.php" );
printhtmlcetak( );
$cetak = $aksi = "cetak";
$border = " border=1 width=95% style='border-collapse:collapse;'";
printjudulmenucetak( "KONVERSI NILAI MAHASISWA PINDAHAN" );
$q = "SELECT ID,NAMA,IDPRODI FROM mahasiswa WHERE ID='{$idupdate}'";
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    printmesg( $errmesg );
    $d = sqlfetcharray( $h );
    $q = "SELECT STPIDMSMHS FROM msmhs WHERE NIMHSMSMHS='{$idupdate}'";
    $h2 = doquery($koneksi,$q);
    $d2 = sqlfetcharray( $h2 );
    $statuspindahan = $d2[STPIDMSMHS];
    echo "\r\n \t\t<table class=form>\r\n     <tr class=judulform>\r\n\t\t\t<td width=200><b>Jurusan/Program Studi</td>\r\n\t\t\t<td><b>".$arrayprodidep[$d[IDPRODI]]."\r\n      </td>\r\n\t\t</tr> \r\n     <tr class=judulform>\r\n\t\t\t<td  ><b>NIM Mahasiswa </td>\r\n\t\t\t<td><b>{$d['ID']}</td>\r\n\t\t</tr> \r\n \t\t<tr class=judulform>\r\n\t\t\t<td><b>Nama Mahasiswa </td>\r\n\t\t\t<td><b>{$d['NAMA']}</td>\r\n\t\t\t</tr> \r\n\t\t</table>";
    $q = "SELECT * FROM nilaikonversi WHERE IDMAHASISWA='{$idupdate}' \r\n        ORDER BY SEMESTERMAKUL,IDMAKUL";
    $q = "SELECT nilaikonversi.* ,trnlp.THSMSTRNLP,BOBOTTRNLP AS BOBOT ,NLAKHTRNLP AS NILAI\r\n        FROM nilaikonversi LEFT JOIN trnlp ON \r\n        nilaikonversi.IDMAHASISWA=trnlp.NIMHSTRNLP AND  \r\n        nilaikonversi.IDMAKUL=trnlp.KDKMKTRNLP \r\n        WHERE IDMAHASISWA='{$idupdate}' \r\n        ORDER BY SEMESTERMAKUL,IDMAKUL";
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        echo "\r\n\t\t\t<br>\r\n\t\t\t\t<table {$border} class=form{$cetak} >\r\n \t\t\t\t\t<tr class=juduldata{$cetak}  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Semester Makul</td>\r\n\t\t\t\t\t\t<td>Kode Makul</td>\r\n\t\t\t\t\t\t<td>Nama Makul</td>\r\n\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t<td>Bobot</td>\r\n\t\t\t\t\t\t<td>Nilai</td>\r\n \r\n \t\t\t\t\t</tr>";
        $i = 1;
        $totalsks = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            echo "\r\n\t\t\t\t\t<tr {$kelas}{$cetak} >\r\n\t\t\t\t\t\t<td>{$i} </td>\r\n \t\t\t\t\t\t<td align=center>{$d['SEMESTERMAKUL']} </td>\r\n \t\t\t\t\t\t<td align=center>{$d['IDMAKUL']} </td>\r\n \t\t\t\t\t\t<td  >{$d['NAMAMAKUL']}</td>\r\n \t\t\t\t\t\t<td align=center>{$d['SKS']}</td>\r\n \t\t\t\t\t\t<td align=center>{$d['BOBOT']}</td>\r\n \t\t\t\t\t\t<td align=center>{$d['NILAI']}</td> \r\n\t\t\t\t\t</tr>";
            $totalsks += $d[SKS];
            $totalbobot += $d[SKS] * $d[BOBOT];
            ++$i;
        }
        $ipkkonversi = number_format_sikad( @$totalbobot / @$totalsks, 2 );
        echo "\r\n      <tr>\r\n        <td colspan=4 align=right>Total SKS diakui</td>\r\n        <td align=center><b>{$totalsks}</b></td>\r\n        <td colspan=2 align=center>IPK Konversi : <b>{$ipkkonversi}</b></td>\r\n      </tr>\r\n      ";
        echo "\r\n\t\t\t\t</table>\r\n \r\n \t\t\t";
    }
    else
    {
        echo "<p>";
        printmesg( "Data Konversi Nilai tidak ada" );
        echo "</p>";
    }
}
else
{
    $errmesg = "Data Mahasiswa dengan ID = '{$idupdate}' tidak ada";
    $aksi = "";
}
?>
