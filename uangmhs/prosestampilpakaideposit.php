<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
unset( $arraysort );
$arraysort[1] = "pakaideposit.IDMAHASISWA";
$arraysort[2] = "mahasiswa.NAMA";
$arraysort[3] = "mahasiswa.IDPRODI";
$arraysort[4] = "pakaideposit.JUMLAH";
$arraysort[5] = "pakaideposit.TANGGAL";
$arraysort[6] = "pakaideposit.KET";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $idmahasiswa != "" )
{
    $qfield .= " AND IDMAHASISWA = '{$idmahasiswa}'";
    $qjudul .= " NIM {$idmahasiswa} <br>";
    $qinput .= " <input type=hidden name=idmahasiswa value='{$idmahasiswa}'>";
    $href .= "idmahasiswa={$idmahasiswa}&";
}
if ( $iftglbayar == 1 )
{
    $qfield .= " AND \r\n      (\r\n        pakaideposit.TANGGAL >= DATE_FORMAT('{$tglbayar1['thn']}-{$tglbayar1['bln']}-{$tglbayar1['tgl']}','%Y-%m-%d') \r\n        AND\r\n        pakaideposit.TANGGAL <= DATE_FORMAT('{$tglbayar2['thn']}-{$tglbayar2['bln']}-{$tglbayar2['tgl']}','%Y-%m-%d') \r\n      )    \r\n    ";
    $qjudul .= " Tanggal Pemakaian antara {$tglbayar1['tgl']} ".$arraybulan[$tglbayar1[bln] - 1]." {$tglbayar1['thn']} s.d {$tglbayar2['tgl']} ".$arraybulan[$tglbayar2[bln] - 1]." {$tglbayar2['thn']} <br>";
    $qinput .= " \r\n    <input type=hidden name=iftglbayar value='{$iftglbayar}'>\r\n    <input type=hidden name='tglbayar1[tgl]' value='{$tglbayar1['tgl']}'>\r\n    <input type=hidden name='tglbayar1[bln]' value='{$tglbayar1['bln']}'>\r\n    <input type=hidden name='tglbayar1[thn]' value='{$tglbayar1['thn']}'>\r\n    <input type=hidden name='tglbayar2[tgl]' value='{$tglbayar2['tgl']}'>\r\n    <input type=hidden name='tglbayar2[bln]' value='{$tglbayar2['bln']}'>\r\n    <input type=hidden name='tglbayar2[thn]' value='{$tglbayar2['thn']}'>\r\n    ";
    $href .= "iftglbayar={$iftglbayar}&tglbayar1[tgl]={$tglbayar1['tgl']}&tglbayar1[bln]={$tglbayar1['bln']}&tglbayar1[thn]={$tglbayar1['thn']}&tglbayar2[tgl]={$tglbayar2['tgl']}&tglbayar2[bln]={$tglbayar2['bln']}&tglbayar2[thn]={$tglbayar2['thn']}&";
}
if ( $iftglentri == 1 )
{
    $qfield .= " AND \r\n      (\r\n        TANGGALENTRI >= DATE_FORMAT('{$tglentri1['thn']}-{$tglentri1['bln']}-{$tglentri1['tgl']}','%Y-%m-%d') \r\n        AND\r\n        TANGGALENTRI <= DATE_FORMAT('{$tglentri2['thn']}-{$tglentri2['bln']}-{$tglentri2['tgl']}','%Y-%m-%d') \r\n      )    \r\n    ";
    $qjudul .= " Tanggal Entri antara {$tglentri1['tgl']} ".$arraybulan[$tglentri1[bln] - 1]." {$tglentri1['thn']} s.d {$tglentri2['tgl']} ".$arraybulan[$tglentri2[bln] - 1]." {$tglentri2['thn']} <br>";
    $qinput .= " \r\n    <input type=hidden name=iftglentri value='{$iftglentri}'>\r\n    <input type=hidden name='tglentri1[tgl]' value='{$tglentri1['tgl']}'>\r\n    <input type=hidden name='tglentri1[bln]' value='{$tglentri1['bln']}'>\r\n    <input type=hidden name='tglentri1[thn]' value='{$tglentri1['thn']}'>\r\n    <input type=hidden name='tglentri2[tgl]' value='{$tglentri2['tgl']}'>\r\n    <input type=hidden name='tglentri2[bln]' value='{$tglentri2['bln']}'>\r\n    <input type=hidden name='tglentri2[thn]' value='{$tglentri2['thn']}'>\r\n    ";
    $href .= "iftglentri={$iftglentri}&tglentri1[tgl]={$tglentri1['tgl']}&tglentri1[bln]={$tglentri1['bln']}&tglentri1[thn]={$tglentri1['thn']}&tglentri2[tgl]={$tglentri2['tgl']}&tglentri2[bln]={$tglentri2['bln']}&tglentri2[thn]={$tglentri2['thn']}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 1;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT pakaideposit.*,mahasiswa.NAMA,mahasiswa.IDPRODI ,\r\n\tDATE_FORMAT(pakaideposit.TANGGAL,'%d-%m-%Y') TANGGALBAYAR2\r\n   FROM pakaideposit,mahasiswa\r\n\tWHERE pakaideposit.IDMAHASISWA=mahasiswa.ID\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]."";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Data Pemakaian Deposit Mahasiswa" );
        printmesg( $qjudul );
        printmesg( $errmesg );
    }
    else
    {
        printjudulmenucetak( "Data Pemakaian Deposit Mahasiswa" );
        printmesgcetak( $qjudul );
    }
    if ( $aksi != "cetak" )
    {
        echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakpakaideposit.php'>\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>\r\n  \t\t\t\t{$qinput}\r\n  \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    echo "\r\n \t\t\t<table {$border} class=form{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=1'>NIM</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=2'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=3'>Prodi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=4'>Jumlah (Rp.)</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=5'>Tanggal</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=6'>Ket</td>\r\n\t\t\t\t ";
    echo "\r\n\t\t\t</tr>\r\n\t\t";
    $i = 1;
    $total = 0;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t<td  >{$d['IDMAHASISWA']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=left  >".$arrayprodidep[$d[IDPRODI]]." </td>\r\n \t\t\t\t\t<td align=right><b>".cetakuang( $d[JUMLAH] )."</td>\r\n  \t\t\t\t\t<td  >{$d['TANGGALBAYAR2']}</td>\r\n   \t\t\t\t\t<td  align=left>{$d['KET']}</td>\r\n \t\t\t\t\t ";
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        $total += $d[JUMLAH];
        ++$i;
    }
    echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n  \t\t\t\t<td align=right colspan=4  ><b>Total</td>\r\n \t\t\t\t\t<td align=right><b>".cetakuang( $total )."</td>\r\n          <td colspan=2></td>    \r\n    ";
    echo "</table>";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Deposit Mahasiswa Tidak Ada";
    $aksi = "";
}
echo "\r\n";
?>
