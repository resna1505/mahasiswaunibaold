<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n* {\r\n\tmargin:0px;\r\n\tpadding:0px;\r\n\t}\r\n</style>\r\n\r\n";
periksaroot( );
unset( $arraysort );
$arraysort[1] = "operatorbank.ID";
$arraysort[2] = "operatorbank.NAMA";
$arraysort[3] = "operatorbank.NAMABANK";
$arraysort[4] = "operatorbank.CABANG";
$arraysort[5] = "operatorbank.ALAMAT";
$arraysort[6] = "operatorbank.TELEPON";
$arraysort[7] = "operatorbank.STATUS";
$valdata[] = cekvaliditaskode( "ID", $id, 32 );
$valdata[] = cekvaliditasnama( "Nama", $nama );
$valdata[] = cekvaliditasnama( "Nama Bank", $namabank );
$valdata[] = cekvaliditaskode( "Status", $status );
$valdata = array_filter( $valdata, "filter_not_empty" );
if ( isset( $valdata ) && 0 < count( $valdata ) )
{
    $errmesg = val_err_mesg( $valdata, 2, CARI_DATA );
    unset( $valdata );
    $aksi = "";
}
else
{
    $href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
    if ( $id != "" )
    {
        $qfield .= " AND operatorbank.ID LIKE '{$id}'";
        $qjudul .= " ID '{$id}' <br>";
        $qinput .= " <input type=hidden name=id value='{$id}'>";
        $href .= "id={$id}&";
    }
    if ( $nama != "" )
    {
        $qfield .= " AND operatorbank.NAMA LIKE '%{$nama}%'";
        $qjudul .= " Nama mengandung kata '{$nama}' <br>";
        $qinput .= " <input type=hidden name=nama value='{$nama}'>";
        $href .= "nama={$nama}&";
    }
    if ( $namabank != "" )
    {
        $qfield .= " AND operatorbank.NAMABANK LIKE '%{$namabank}%'";
        $qjudul .= " Nama Bank mengandung kata '{$namabank}' <br>";
        $qinput .= " <input type=hidden name=namabank value='{$namabank}'>";
        $href .= "namabank={$namabank}&";
    }
    if ( $status != "" )
    {
        $qfield .= " AND operatorbank.STATUS='{$status}'";
        $qjudul .= " Status Operator Bank '".$arraystatusdosen["{$status}"]."' <br>";
        $qinput .= " <input type=hidden name=status value='{$status}'>";
        $href .= "status={$status}&";
    }
    if ( $arraysort[$sort] == "" )
    {
        $sort = 1;
    }
    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    $q = "SELECT COUNT(*) AS JML FROM operatorbank  \r\n\t\tWHERE 1=1  \r\n\t\t{$qfield}\r\n\t\t";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $total = $d[JML];
    include( "../paginating.php" );
    $q = "SELECT operatorbank.* \r\n    FROM operatorbank   \r\n\tWHERE 1=1\r\n \t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        if ( $aksi != "cetak" )
        {
            printjudulmenu( "Data Operator Bank", "bantuan" );
            printhelp( trim( $arrayhelp[hasildosen] ), "bantuan" );
            printmesg( $qjudul );
        }
        else
        {
            printjudulmenucetak( "Data Operator Bank" );
            printmesgcetak( $qjudul );
        }
        if ( $aksi != "cetak" )
        {
            echo "\t{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td>\r\n\t\t\t\t<form target=_blank action='cetakoperatorbank.php'>\r\n\t\t\t\t\t".IKONCETAK32."\r\n\t\t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n\t\t\t\t\t{$qinput}\r\n\t\t\t\t\t{$input}\r\n\t\t\t\t</form>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr></table>";
        }
        echo "\r\n \t\t\t<table class='dataprint' cellpadding='0' cellspacing='0'>\r\n\t\t\t<tr class=juduldata{$aksi} align=center >\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>ID</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Nama Bank</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Cabang</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Alamat</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=6'>Telepon</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=7'>Status</td>\r\n\t\t\t ";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2  >Aksi</td>\r\n\t\t\t\t\t\t\t";
        }
        echo "\r\n\t\t\t</tr>\r\n\t\t";
        $i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}&nbsp;</td>\r\n  \t\t\t\t\t<td align=left>{$d['ID']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NAMA']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NAMABANK']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['CABANG']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left nowrap>".nl2br( $d[ALAMAT] )."</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['TELEPON']}&nbsp;</td>\r\n \t\t\t\t\t<td class='linebore' align=center nowrap>".$arraystatusoperatorbank[$d[STATUS]]."&nbsp;</td>\r\n \t\t\t\t ";
            if ( $tingkataksesusers[$kodemenu] == "T" )
            {
                echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}&sessid={$_SESSION['token']}'>".IKONUPDATE."</td>\r\n\t\t\t\t\t\t\t\t<td   align=center ><a onclick=\"return confirm('Hapus Data Operator Bank Dengan ID = {$d['ID']}?');\"\r\n\t\t\t\t\t\t\t\thref='{$href}&aksi=hapus&idhapus={$d['ID']}&sessid={$_SESSION['token']}'>".IKONHAPUS."</td>\r\n\t\t\t\t\t\t\t\t";
            }
            echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
            ++$i;
        }
        echo "</table>";
        $aksi = "tampilkan";
    }
    else
    {
        $errmesg = "Data Operator Bank Tidak Ada";
        $aksi = "";
    }
}
?>
