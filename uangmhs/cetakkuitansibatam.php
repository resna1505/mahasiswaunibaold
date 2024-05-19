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
        echo "\r\n\t\t\t\r\n\t\t \t\t<table class=form>\r\n\t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td width=150>NIM</td>\r\n\t\t\t\t\t\t<td><b>{$idmahasiswa}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td >Nama</td>\r\n\t\t\t\t\t\t<td><b>{$data['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td>Angkatan</td>\r\n\t\t\t\t\t\t<td><b>{$data['ANGKATAN']}</td>\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td>Prodi</td>\r\n\t\t\t\t\t\t<td><b>".$arrayprodidep[$data[IDPRODI]]."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Tanggal Pembayaran</td>\r\n\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t<b>{$lokasikantor}, {$tglbayar['tgl']} ".$arraybulan[$tglbayar[bln] - 1]." {$tglbayar['thn']}\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[tgl] value='{$tglbayar['tgl']}'>\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[bln] value='{$tglbayar['bln']}'>\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[thn] value='{$tglbayar['thn']}'>\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\t\r\n \t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td>Cara bayar</td>\r\n\t\t\t\t\t\t<td><b>".$arraycarabayar[$carabayar]."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table>";
        $q = "SELECT bayarkomponen.* ,komponenpembayaran.NAMA , \r\n            biayakomponen.BIAYA AS BIAYAK,biayakomponen.TANGGAL,biayakomponen.DENDA AS DENDAD,\r\n            biayakomponen.JENISDENDA\r\n          FROM bayarkomponen,komponenpembayaran,biayakomponen\r\n          WHERE   \r\n          biayakomponen.IDKOMPONEN=bayarkomponen.IDKOMPONEN\r\n          AND biayakomponen.IDPRODI='{$data['IDPRODI']}'\r\n          AND biayakomponen.ANGKATAN='{$data['ANGKATAN']}'\r\n          AND bayarkomponen.IDKOMPONEN=komponenpembayaran.ID \r\n          AND  bayarkomponen.TANGGALBAYAR='{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}'\r\n          AND bayarkomponen.IDMAHASISWA='{$idmahasiswa}' \r\n          ORDER BY IDKOMPONEN";
        $h = mysqli_query($koneksi,$q);
        echo mysqli_error($koneksi);
        if ( 0 < sqlnumrows( $h ) )
        {
            echo "\r\n        <br>\r\n        <table {$border} class=form >\r\n\t\t\t\t\t<tr class=juduldata{$cetak}  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Nama Komponen</td>\r\n \t\t\t\t\t\t<td>Bulan/Semester/Tahun</td>\r\n\t\t\t\t\t\t<td>Biaya<br>Rp.</td>\r\n\t\t\t\t\t\t<td>Denda<br>Rp.</td>\r\n\t\t\t\t\t\t<td>Sudah<br>Dibayar<br>Rp.</td>\r\n\t\t\t\t\t\t<td>Dibayar<br>Saat Ini<br>Rp.</td>\r\n\t\t\t\t\t\t \r\n\t\t\t\t\t\t<td>Sisa<br>Rp.</td>\r\n\t\t\t\t\t\t<td>Ket</td>\r\n\t\t\t \r\n\t\t \t\t\t</tr>\r\n\r\n        ";
            $i = 0;
            while ( $d = sqlfetcharray( $h ) )
            {
                ++$i;
                $waktu = "-";
                $biaya = $totaldenda = 0;
                $qdibayar = "";
                if ( $d[JENIS] == 2 )
                {
                    $waktu = "{$d['TAHUNAJARAN']}";
                    $qdibayar = " AND TAHUNAJARAN='{$d['TAHUNAJARAN']}'";
                }
                else if ( $d[JENIS] == 3 )
                {
                    $waktu = "".$arraysemester[$d[SEMESTER]]." ".( $d[TAHUNAJARAN] - 1 )."/{$d['TAHUNAJARAN']}";
                    $qdibayar = " AND TAHUNAJARAN='{$d['TAHUNAJARAN']}' AND\r\n                  SEMESTER='{$d['SEMESTER']}' ";
                }
                else if ( $d[JENIS] == 5 )
                {
                    $waktu = "".$arraybulan[$d[SEMESTER] - 1]."  {$d['TAHUNAJARAN']}";
                    $qdibayar = " AND TAHUNAJARAN='{$d['TAHUNAJARAN']}' AND\r\n                  SEMESTER='{$d['SEMESTER']}' ";
                    $totaldenda = 0;
                    $kettambahan = "";
                    $q = "SELECT TO_DAYS('{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}')-TO_DAYS('{$d['TAHUNAJARAN']}-{$d['SEMESTER']}-{$d['TANGGAL']}') AS HARI ";
                    $hx = mysqli_query($koneksi,$q);
                    $dx = sqlfetcharray( $hx );
                    $jumlahhari = $dx[HARI] + 0;
                    if ( 0 < $jumlahhari )
                    {
                        if ( $d[JENISDENDA] == 0 )
                        {
                            $totaldenda = $d[DENDAD];
                        }
                        else
                        {
                            $totaldenda = $d[DENDAD] * $jumlahhari;
                        }
                        $kettambahan = "Denda terlambat Rp. ".cetakuang( $totaldenda );
                    }
                }
                $kelas = kelas( $i );
                $q = "SELECT SUM(JUMLAH) AS TOTAL,SUM(DENDA) AS TOTALDENDA\r\n                 FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}'\r\n\t\t\t\t\tAND TANGGALBAYAR != DATE_FORMAT('{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}','%Y-%m-%d') AND\r\n\t\t\t\t\tIDKOMPONEN='{$d['IDKOMPONEN']}'\r\n          {$qdibayar}\r\n          ";
                $h3 = mysqli_query($koneksi,$q);
                if ( 0 < sqlnumrows( $h3 ) )
                {
                    $d3 = sqlfetcharray( $h3 );
                    $dibayar = $d3[TOTAL];
                }
                if ( $d[IDKOMPONEN] != "99" )
                {
                    $biaya = $d[BIAYAK];
                }
                else
                {
                    $jumlahsks = getjumlahsks( $idmahasiswa, $d[TAHUNAJARAN], $d[SEMESTER] );
                    $jumlahskswajib = getjumlahskswajib( $idmahasiswa, $d[TAHUNAJARAN], $d[SEMESTER] );
                    $skslebih = 0;
                    if ( $jumlahskswajib < $jumlahsks )
                    {
                        $skslebih = $jumlahsks - $jumlahskswajib;
                    }
                    $q = "SELECT BIAYA AS TOTAL\r\n            \t\tFROM biayakomponen,mahasiswa\r\n            \t\tWHERE\r\n            \t\t  mahasiswa.IDPRODI=biayakomponen.IDPRODI AND\r\n            \t\t  mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND\r\n              \t\t  mahasiswa.ID='{$idmahasiswa}' AND\r\n            \t\t  biayakomponen.IDKOMPONEN='99'\r\n            \t\t\t \r\n            \t\t";
                    $ht = mysqli_query($koneksi,$q);
                    $dt = sqlfetcharray( $ht );
                    echo mysqli_error($koneksi);
                    $biayakomponen = $dt[TOTAL] + 0;
                    $biaya = $skslebih * $biayakomponen;
                }
                $biaya += $totaldenda;
                if ( $d[JUMLAH] == 0 )
                {
                    $d[JUMLAH] = $biaya;
                }
                $sisa = 0;
                $sisa = $biaya - $dibayar - $d[JUMLAH] - $dibayarsebelumnya[$d[IDKOMPONEN]]["{$d['TAHUNAJARAN']}{$d['SEMESTER']}"] - $d[DISKON];
                echo "\r\n\t\t\t\t\t\t<tr  {$kelas}{$cetak} valign=top>\r\n\t\t\t\t\t\t<td align=center nowrap>{$i}</td>\r\n \t\t\t\t\t\t<td  nowrap>{$d['NAMA']}</td>\r\n \r\n\t\t\t\t\t\t<td  nowrap align=center>{$waktu}</td>\r\n\t\t\t\t\t\t<td  nowrap align=right>".cetakuang( $biaya )."</td>\r\n\t\t\t\t\t\t<td  nowrap align=right>".cetakuang( $d[DENDA] )."   </td>\r\n\t\t\t\t\t\t<td  nowrap align=right>".cetakuang( $dibayar )."</td>\r\n\t\t\t\t\t\t<td  nowrap align=right>".cetakuang( $d[JUMLAH] )." </td>\r\n\t\t\t\t\t\t<td  nowrap align=right>".cetakuang( $sisa )."</td>\r\n\t\t\t\t\t\t<td  nowrap>{$d['KET']} </td>\r\n\t\t\t\t\t\t \r\n\t\t \t\t\t</tr>          \r\n          ";
                $dibayarsebelumnya[$d[IDKOMPONEN]] += "{$d['TAHUNAJARAN']}{$d['SEMESTER']}";
                $totaldenda2 += $d[DENDA];
                $totaljumlah += $d[JUMLAH];
            }
            echo "\r\n\t\t\t\t\t\t<tr  {$kelas}{$cetak} valign=top>\r\n\t\t\t\t\t\t<td align=center nowrap  colspan=4 style='border-left:0pt;border-right:0pt;border-bottom:0pt;border-top:0pt;'> </td>\r\n \t\t\t \t\t\t<td  nowrap align=right style='border-left:0pt;border-right:0pt;border-bottom:0pt;border-top:0pt;'><b>".cetakuang( $totaldenda2 )."   </td>\r\n\t\t\t\t\t\t<td  nowrap align=right style='border-left:0pt;border-right:0pt;border-bottom:0pt;border-top:0pt;'> </td>\r\n\t\t\t\t\t\t<td  nowrap align=right style='border-left:0pt;border-right:0pt;border-bottom:0pt;border-top:0pt;'><b>".cetakuang( $totaljumlah )." </td>\r\n\t\t\t\t\t\t<td  nowrap align=right style='border-left:0pt;border-right:0pt;border-bottom:0pt;border-top:0pt;' > </td>\r\n\t\t\t\t\t\t<td  nowrap style='border-left:0pt;border-right:0pt;border-bottom:0pt;border-top:0pt;'>  </td>\r\n\t\t\t\t\t\t \r\n\t\t \t\t\t</tr>          \r\n\t\t\t\t\t<tr  {$kelas}{$cetak} valign=top  >\r\n\t\t\t\t\t\t<td align=center nowrap colspan=3 style='border-left:0pt;border-right:0pt;border-bottom:0pt;border-top:0pt;'>  </td>\r\n\t\t\t\t\t\t<td  nowrap align=right  style='border-left:0pt;border-right:0pt;border-bottom:0pt;border-top:0pt;'><b>Total Pembayaran </td>\r\n \r\n\t\t\t\t\t\t<td  nowrap align=right colspan=3  style='border-left:0pt;border-right:0pt;border-bottom:0pt; '><b>".cetakuang( $totaljumlah + $totaldenda2 )." </td>\r\n\t\t\t\t\t\t<td  nowrap align=right  style='border-left:0pt;border-right:0pt;border-bottom:0pt;border-top:0pt;'> </td>\r\n\t\t\t\t\t\t<td  nowrap  style='border-left:0pt;border-right:0pt;border-bottom:0pt;border-top:0pt;'>  </td>\r\n\t\t\t\t\t\t \r\n\t\t \t\t\t</tr>          \r\n        \r\n        </table>\r\n        <br>\r\n        <table width=95%>\r\n        <tr>\r\n        <td align=left>\r\n        Operator: {$users}\r\n        </td>\r\n        <td align=right>  \r\n          {$w['mday']}-{$w['mon']}-{$w['year']}\r\n        </td>\r\n        </tr>\r\n        </table>\r\n        ";
        }
    }
}
?>
