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
periksaroot( );
include( "array.php" );
printhtmlcetak( );
$cetak = $aksi = "cetak";
$border = " border=1 width=600 style='border-collapse:collapse;'";
if ( trim( $idmahasiswa ) == "" )
{
    $errmesg = "NIM harus diisi";
    $aksi = "";
}
else
{
    printmesg( $errmesg );
    $q = "SELECT NAMA,ANGKATAN,IDPRODI FROM mahasiswa WHERE ID='{$idmahasiswa}'";
    $h = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $h ) <= 0 )
    {
        $errmesg = "Tidak ada mahasiswa dengan NIM '{$idmahasiswa}'";
        $aksi = "";
    }
    else
    {
        $data = sqlfetcharray( $h );
        echo "\r\n\t\t \t\t<table class=form>\r\n\t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td width=150>NIM</td>\r\n\t\t\t\t\t\t<td><b>{$idmahasiswa}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td >Nama</td>\r\n\t\t\t\t\t\t<td><b>{$data['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td>Angkatan</td>\r\n\t\t\t\t\t\t<td><b>{$data['ANGKATAN']}</td>\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td>Prodi</td>\r\n\t\t\t\t\t\t<td><b>".$arrayprodidep[$data[IDPRODI]]."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Tanggal Pembayaran</td>\r\n\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t<b>{$lokasikantor}, {$tglbayar['tgl']} ".$arraybulan[$tglbayar[bln] - 1]." {$tglbayar['thn']}\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[tgl] value='{$tglbayar['tgl']}'>\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[bln] value='{$tglbayar['bln']}'>\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[thn] value='{$tglbayar['thn']}'>\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\t\r\n \t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td>Cara bayar</td>\r\n\t\t\t\t\t\t<td><b>".$arraycarabayar[$carabayar]."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table>";
        if ( is_array( $jeniskomponen ) )
        {
            $qkomponen = " AND (  ";
            foreach ( $jeniskomponen as $k => $v )
            {
                echo "<input type=hidden name='jeniskomponen[{$k}]' value=1>";
                $qkomponen .= " IDKOMPONEN='{$k}' OR";
            }
            $qkomponen .= ")";
            $qkomponen = str_replace( "OR)", ")", $qkomponen );
        }
        $q = "SELECT bayarkomponen.*,biayakomponen.BIAYA BIAYA2 ,\r\n\t\t\t IF(TANGGALBAYAR=DATE_FORMAT('{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}','%Y-%m-%d'),1,0) AS STATUSTANGGAL\r\n       FROM bayarkomponen,biayakomponen ,mahasiswa\r\n       WHERE \r\n       mahasiswa.ID=bayarkomponen.IDMAHASISWA AND\r\n       mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND\r\n       mahasiswa.IDPRODI=biayakomponen.IDPRODI AND\r\n       mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND\r\n       bayarkomponen.IDKOMPONEN=biayakomponen.IDKOMPONEN AND\r\n        \r\n      IDMAHASISWA='{$idmahasiswa}'  AND\r\n      TANGGALBAYAR=DATE_FORMAT('{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}','%Y-%m-%d')      \r\n      ORDER BY bayarkomponen.JENIS,bayarkomponen.IDKOMPONEN,bayarkomponen.TAHUNAJARAN,bayarkomponen.SEMESTER,TANGGALBAYAR";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            echo "\r\n\t\t\t   <br>\r\n\t\t\t   <b>Rincian Transaksi Keuangan Mahasiswa</b>\r\n          <table {$border} class=form  width=95%>\r\n            <tr class=juduldata{$cetak} align=center>\r\n              <td>Nama</td>\r\n              <td>Jenis</td>\r\n               <td>Waktu</td>\r\n               <td>Biaya</td>\r\n              <td>Bayar</td>\r\n              <td>Diskon</td>\r\n              <td>Sisa</td>\r\n              <td>Ket</td>\r\n             </tr>";
            $idkomponenlama = $tahunlama = $semlama = 0 - 1;
            $sisa = 0;
            while ( $d = sqlfetcharray( $h ) )
            {
                if ( $d[BIAYA] == 0 )
                {
                    $d[BIAYA] = $d[BIAYA2];
                }
                $waktu = "-";
                if ( $d[JENIS] == 2 )
                {
                    $waktu = ( $d[TAHUNAJARAN] - 1 )."/{$d['TAHUNAJARAN']}";
                }
                else if ( $d[JENIS] == 3 )
                {
                    $waktu = "".$arraysemester[$d[SEMESTER]]." ".( $d[TAHUNAJARAN] - 1 )."/{$d['TAHUNAJARAN']}";
                }
                else if ( $d[JENIS] == 5 )
                {
                    $waktu = "".$arraybulan[$d[SEMESTER] - 1]." {$d['TAHUNAJARAN']}";
                }
                if ( $idkomponenlama != $d[IDKOMPONEN] || $tahunlama != $d[TAHUNAJARAN] || $semlama != $d[SEMESTER] )
                {
                    $totalbiaya += $d[BIAYA];
                    $totalsisa += $sisa;
                    $sisa = $d[BIAYA];
                    $idkomponenlama = $d[IDKOMPONEN];
                    $tahunlama = $d[TAHUNAJARAN];
                    $semlama = $d[SEMESTER];
                }
                $sisa -= $d[JUMLAH] + $d[DISKON];
                $trtgl = "";
                if ( $d[STATUSTANGGAL] == 1 )
                {
                    $trtgl = "style='background-color:#ffff00;'";
                }
                echo "\r\n            <tr valign=top >\r\n              <td> ".$arraykomponenpembayaran2[$d[IDKOMPONEN]]." </td>\r\n              <td> ".$arrayjenispembayaran[$d[JENIS]]." </td>\r\n               <td align=center>{$waktu}</td>\r\n               <td align=right>".cetakuang( $d[BIAYA] )."</td>\r\n              <td align=right>".cetakuang( $d[JUMLAH] )."</td>\r\n              <td align=right>".cetakuang( $d[DISKON] )."</td>\r\n              <td align=right> ".cetakuang( $sisa )."</td>\r\n              <td align=left>{$d['KET']}</td>\r\n             </tr>";
                $totaljumlah += $d[JUMLAH];
                $totaldiskon += $d[DISKON];
            }
            $totalsisa += $sisa;
            $totalbiaya += $d[BIAYA];
            echo "\r\n            <tr valign=top >\r\n              <td colspan=3 align=right> <b>Total </td>\r\n                <td align=right><b>".cetakuang( $totalbiaya )."</td>\r\n              <td align=right><b>".cetakuang( $totaljumlah )."</td>\r\n              <td align=right><b>".cetakuang( $totaldiskon )."</td>\r\n              <td align=right><b> ".cetakuang( $totalsisa )."</td>\r\n              </tr>";
            echo "\r\n          </table>\r\n         ";
            echo "\r\n         <br>\r\n         <table width=95%>\r\n          <tr>\r\n            <td width=60%>&nbsp;</td>\r\n            <td nowrap align=center>\r\n               \r\n              <br><br><br>\r\n              ____________________<br>\r\n              ( ".getnama( $users )." )\r\n            </td>\r\n          </tr>\r\n         </table>\r\n         ";
        }
    }
}
?>
