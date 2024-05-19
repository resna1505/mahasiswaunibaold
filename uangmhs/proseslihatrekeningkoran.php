<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $jenisusers == 2 || $jenisusers == 3 )
{
    $idmahasiswa = $users;
}
unset( $arraysort );
$arraysort[0] = "t_bni_ibank_paid.dates";
$arraysort[1] = "t_bni_ibank_paid.no_mahasiswa";
$arraysort[2] = "t_bni_ibank_paid.bulan";
$arraysort[3] = "t_bni_ibank_paid.tahun";
$arraysort[4] = "t_bni_ibank_paid.ket";
$arraysort[5] = "t_bni_ibank_paid.ket";
if ( $aksi2 == hapus && ( getaturan( "KEUANGAN" ) == 0 || getaturan( "KEUANGAN" ) == 1 && issupervisor( $users ) ) )
{
    $q = "DELETE FROM bayarkomponen\r\n\tWHERE \r\n\tIDMAHASISWA='{$idmahasiswahapus}' AND\r\n\tIDKOMPONEN='{$idkomponenhapus}' AND\r\n\tdates='{$tanggalhapus}'\r\n\t";
    mysqli_query($koneksi,$q);
    $ketlog = "Hapus Pembayaran dengan \r\n\t\t\t\tID Komponen={$idkomponenhapus},ID Mahasiswa={$idmahasiswahapus},\r\n\t\t\t\tTanggal bayar={$tanggalhapus}\r\n\t\t\t\t";
    buatlog( 56 );
    $errmesg = "Data Pembayaran telah dihapus";
}
$qfield="";
$href = "index.php?pilihan={$pilihan}&aksi=Tampilkan&";
if ( $idmahasiswa != "" )
{
    $qfield .= " AND no_mahasiswa LIKE '%{$idmahasiswa}%'";
    $qjudul .= " NIM  '{$idmahasiswa}' <br>";
    $qinput .= " <input type=hidden name=idmahasiswa value='{$idmahasiswa}'>";
    $href .= "idmahasiswa={$idmahasiswa}&";
}

if ( $istglbayar == 1 )
{
    $qfield .= "\r\n \t\t\tAND \r\n \t\t\t(\r\n \t\t\t\tdates >= DATE_FORMAT('{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}','%Y-%m-%d')\r\n \t\t\t\tAND\r\n \t\t\t\tdates <= DATE_FORMAT('{$tglbayar2['thn']}-{$tglbayar2['bln']}-{$tglbayar2['tgl']}','%Y-%m-%d')\r\n \t\t\t)\r\n \t\t";
    $qjudul .= " Tanggal bayar antara  {$tglbayar['tgl']}-{$tglbayar['bln']}-{$tglbayar['thn']} s.d\r\n\t\t {$tglbayar2['tgl']}-{$tglbayar2['bln']}-{$tglbayar2['thn']} \r\n\t\t <br>";
    $qinput .= " \r\n\t\t\t<input type=hidden name=istglbayar value='{$istglbayar}'>\r\n\t\t\t<input type=hidden name=tglbayar[thn] value='{$tglbayar['thn']}'>\r\n\t\t\t<input type=hidden name=tglbayar[bln] value='{$tglbayar['bln']}'>\r\n\t\t\t<input type=hidden name=tglbayar[tgl] value='{$tglbayar['tgl']}'>\r\n\t\t\t<input type=hidden name=tglbayar2[thn] value='{$tglbayar2['thn']}'>\r\n\t\t\t<input type=hidden name=tglbayar2[bln] value='{$tglbayar2['bln']}'>\r\n\t\t\t<input type=hidden name=tglbayar2[tgl] value='{$tglbayar2['tgl']}'>\r\n\t\t";
    $href .= "istglbayar={$istglbayar}&tglbayar[tgl]={$tglbayar['tgl']}&tglbayar[bln]={$tglbayar['bln']}&tglbayar[thn]={$tglbayar['thn']}&\r\n\t\ttglbayar2[tgl]={$tglbayar2['tgl']}&tglbayar2[bln]={$tglbayar2['bln']}&tglbayar2[thn]={$tglbayar2['thn']}&";
}
if ( $istglentri == 1 )
{
    $qfield .= " AND (tdates >= DATE_FORMAT('{$tglentri['thn']}-{$tglentri['bln']}-{$tglentri['tgl']}','%Y-%m-%d')\r\n \t\t\t\tAND\r\n \t\t\t\ttdates <= DATE_FORMAT('{$tglentri2['thn']}-{$tglentri2['bln']}-{$tglentri2['tgl']}','%Y-%m-%d')\r\n \t\t\t)\r\n \t\t";
    $qjudul .= " Tanggal entri antara  {$tglentri['tgl']}-{$tglentri['bln']}-{$tglentri['thn']} s.d\r\n\t\t {$tglentri2['tgl']}-{$tglentri2['bln']}-{$tglentri2['thn']} \r\n\t\t <br>";
    $qinput .= " \r\n\t\t\t<input type=hidden name=istglentri value='{$istglentri}'>\r\n\t\t\t<input type=hidden name=tglentri[thn] value='{$tglentri['thn']}'>\r\n\t\t\t<input type=hidden name=tglentri[bln] value='{$tglentri['bln']}'>\r\n\t\t\t<input type=hidden name=tglentri[tgl] value='{$tglentri['tgl']}'>\r\n\t\t\t<input type=hidden name=tglentri2[thn] value='{$tglentri2['thn']}'>\r\n\t\t\t<input type=hidden name=tglentri2[bln] value='{$tglentri2['bln']}'>\r\n\t\t\t<input type=hidden name=tglentri2[tgl] value='{$tglentri2['tgl']}'>\r\n\t\t";
    $href .= "istglentri={$istglentri}&tglentri[tgl]={$tglentri['tgl']}&tglentri[bln]={$tglentri['bln']}&tglentri[thn]={$tglentri['thn']}&\r\n\t\ttglentri2[tgl]={$tglentri2['tgl']}&tglentri2[bln]={$tglentri2['bln']}&tglentri2[thn]={$tglentri2['thn']}&";
}

if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM t_bni_ibank_paid WHERE no_id is not null {$qfield}";
#echo $q;
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
if(isset($_REQUEST['amount']) && $_REQUEST['amount']!=""){
	$qfield.= " and amount='{$_REQUEST['amount']}' ";
}
if(isset($_REQUEST['no_jurnal']) && $_REQUEST['no_jurnal']!=""){
	$qfield.= " and journal_no='{$_REQUEST['no_jurnal']}' ";
}
if(isset($_REQUEST['keterangan']) && $_REQUEST['keterangan']!=""){
	$qfield.= " and ket='{$_REQUEST['keterangan']}' ";
}
$q = "SELECT t_bni_ibank_paid.*,DATE_FORMAT(t_bni_ibank_paid.dates,'%d-%m-%Y') AS TGLBAYAR FROM t_bni_ibank_paid WHERE no_id is not null {$qfield}\r\n\tORDER BY ".$arraysort[$sort]."\r\n  {$qlimit}\r\n  ";
//var_dump($_REQUEST);
//sfsaf
//echo $q;
///exit();
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Data  Pembayaran Keuangan Rekening Koran Mahasiswa" );
        printmesg( $qjudul );
        printmesg( $errmesg );
    }
    else
    {
        printjudulmenucetak( "Data  Pembayaran Keuangan Rekening Koran Mahasiswa" );
        printmesgcetak( $qjudul );
    }
    if ( $aksi != "cetak" )
    {
        echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetaklihatrekeningkoran.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>{$qinput}\r\n  \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    echo "\r\n\t\t{$tpage} {$tpage2}\r\n \t\t\t<table {$border} class=form{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=0'>Tanggal Bayar</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=1'>NIM</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=2'>Bulan</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=3'>Tahun</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=4'>Jumlah</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=5'>Ket</td>";
    if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2  >Aksi</td>\r\n\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t</tr>\r\n\t\t";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $tmp = explode( "-", $d[dates] );
        $tglbayar[tgl] = $tmp[2];
        $tglbayar[bln] = $tmp[1];
        $tglbayar[thn] = $tmp[0];
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi} valign=top>\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t\t<td align=center>{$d['TGLBAYAR']}</td></td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['no_mahasiswa']}</td>\r\n \t\t\t\t\t\r\n \t\t\t\t\t<td align=right>{$d['bulan']}</td>\r\n \t\t\t\t\t<td align=right>{$d['tahun']}</td><td align=right>".cetakuang( $d[amount] )."</td>";
        echo "<td align=right>".nl2br( $d[ket] )."</td>";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            if ( getaturan( "KEUANGAN" ) == 0 || getaturan( "KEUANGAN" ) == 1 && issupervisor( $users ) )
            {
                echo "\r\n  \t\t\t\t\t\t\t\t<td   align=center colspan='2'><a href='index.php?pilihan=bayarrekeningkoran&aksi=Lanjut&idmahasiswa={$d['no_mahasiswa']}&tglbayar[tgl]={$tglbayar['tgl']}&tglbayar[bln]={$tglbayar['bln']}&tglbayar[thn]={$tglbayar['thn']}&aksilanjut=edit&count=1'>".IKONUPDATE."</td>";
            }
            else
            {
                echo "\r\n                  <td colspan='2'>-</td>";
            }
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        $totalbayar += $d[amount];
        ++$i;
    }
    echo "\r\n\t\t\t<tr>\r\n\t\t\t\t<td align=right colspan=5><b>Total</td>\r\n\t\t\t\t<td align=right><b>".cetakuang( $totalbayar )."</td></tr>\r\n\t\t</table>";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Pembayaran Tidak Ada";
    $aksi = "";
}
?>
