<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\nbody {\r\n\tfont-family:\"Trebuchet MS\", Arial, Helvetica, sans-serif;\r\n\t}\r\n\r\n.lineborder {\r\n\twidth:100%;\r\n\tborder-bottom:1px solid #000f80;\r\n\tborder-left:1px solid #000f80;\r\n\t}\r\n\r\n.lineborder td {\r\n\tborder-top:1px solid #000f80;\r\n\tborder-right:1px solid #000f80;\r\n\tpadding:5px;\r\n\t}\r\n\r\n</style>\r\n\r\n";
periksaroot( );
unset( $arraysort );
$arraysort[0] = "mahasiswa.ID";
$arraysort[1] = "mahasiswa.NAMA";
$arraysort[2] = "mahasiswa.IDPRODI";
$arraysort[3] = "deposit.JUMLAH";
$arraysort[4] = "deposit.TANGGALBAYAR";
$arraysort[5] = "deposit.TANGGALENTRI";
$arraysort[6] = "deposit.KET";
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
    $qfield .= " AND \r\n      (\r\n        TANGGALBAYAR >= DATE_FORMAT('{$tglbayar1['thn']}-{$tglbayar1['bln']}-{$tglbayar1['tgl']}','%Y-%m-%d') \r\n        AND\r\n        TANGGALBAYAR <= DATE_FORMAT('{$tglbayar2['thn']}-{$tglbayar2['bln']}-{$tglbayar2['tgl']}','%Y-%m-%d') \r\n      )    \r\n    ";
    $qjudul .= " Tanggal Bayar antara {$tglbayar1['tgl']} ".$arraybulan[$tglbayar1[bln] - 1]." {$tglbayar1['thn']} s.d {$tglbayar2['tgl']} ".$arraybulan[$tglbayar2[bln] - 1]." {$tglbayar2['thn']} <br>";
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
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT deposit.*,mahasiswa.NAMA,mahasiswa.IDPRODI ,\r\n\tDATE_FORMAT(deposit.TANGGALBAYAR,'%d-%m-%Y') TANGGALBAYAR2,\r\n\tDATE_FORMAT(deposit.TANGGALENTRI,'%d-%m-%Y') TANGGALENTRI2\r\n  FROM deposit,mahasiswa\r\n\tWHERE deposit.IDMAHASISWA=mahasiswa.ID\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]."";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Data Deposit Mahasiswa" );
        printmesg( $qjudul );
        printmesg( $errmesg );
    }
    else
    {
        printjudulmenucetak( "Data Deposit Mahasiswa" );
        printmesgcetak( $qjudul );
    }
    if ( $aksi != "cetak" )
    {
        echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakdeposit.php'>\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>\r\n  \t\t\t\t{$qinput}\r\n  \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    echo "\r\n \t\t\t<table class=lineborder cellpadding=0 cellspacing=0>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=0'>NIM</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=1'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=2'>Prodi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=3'>Jumlah (Rp.)</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=4'>Tanggal Bayar</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=5'>Tanggal Entri</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=6'>Ket</td>\r\n\t\t\t\t ";
    if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2 width=20%>Aksi</td>\r\n\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t</tr>\r\n\t\t";
    $i = 1;
    $total = 0;
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}&nbsp;</td>\r\n  \t\t\t\t<td  >{$d['IDMAHASISWA']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left  >".$arrayprodidep[$d[IDPRODI]]." &nbsp;</td>\r\n \t\t\t\t\t<td align=right><b>".cetakuang( $d[JUMLAH] )."&nbsp;</td>\r\n  \t\t\t\t\t<td  >{$d['TANGGALBAYAR2']}&nbsp;</td>\r\n  \t\t\t\t\t<td  >{$d['TANGGALENTRI2']}&nbsp;</td>\r\n  \t\t\t\t\t<td  align=left>{$d['KET']}&nbsp;</td>\r\n \t\t\t\t\t ";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}'>Update&nbsp;</td>\r\n\t\t\t\t\t\t\t\t<td   align=center ><a \r\n\t\t\t\t\t\t\t\tonclick=\"return confirm('Hapus Data Deposit Mahasiswa ? ');\"\r\n\t\t\t\t\t\t\t\thref='{$href}&aksi=hapus&idhapus={$d['ID']}&sessid={$token}'>Hapus</td>\r\n\t\t\t\t\t\t\t\t";
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        $total += $d[JUMLAH];
        ++$i;
    }
    echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n  \t\t\t\t\t<td align=right colspan=4  ><b>Total&nbsp;</td>\r\n \t\t\t\t\t<td align=right><b>".cetakuang( $total )."&nbsp;</td>\r\n  \t\t\t\t\t<td  colspan=5>&nbsp;</td>\r\n  \t\t\t\t\t ";
    echo "</table>";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Deposit Mahasiswa Tidak Ada";
    $aksi = "";
}
?>
