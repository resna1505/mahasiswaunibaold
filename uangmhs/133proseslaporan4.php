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
$arraysort[0] = "mahasiswa.ID";
$arraysort[1] = "mahasiswa.NAMA";
$href = "index.php?pilihan={$pilihan}&aksi=Tampilkan&";
if ( $angkatan != "" )
{
    $qfield .= " AND mahasiswa.ANGKATAN = '{$angkatan}'";
    $qjudul .= " Angkatan '{$angkatan}' <br>";
    $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
    $href .= "angkatan={$angkatan}&";
}
if ( $gelombang != "" )
{
    $qfield .= " AND mahasiswa.GELOMBANG = '{$gelombang}'";
    $qjudul .= " Gelombang '{$gelombang}' <br>";
    $qinput .= " <input type=hidden name=gelombang value='{$gelombang}'>";
    $href .= "gelombang={$gelombang}&";
}
if ( $idprodi != "" )
{
    $qfield .= " AND mahasiswa.IDPRODI = '{$idprodi}'";
    $qjudul .= " Prodi '".$arrayprodidep[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $kelas != "" )
{
    $qfield .= " AND mahasiswa.KELAS = '{$kelas}'";
    $qjudul .= " Kelas '{$kelas}' <br>";
    $qinput .= " <input type=hidden name=kelas value='{$kelas}'>";
    $href .= "kelas={$kelas}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT ID,NAMA,STATUS,TA FROM mahasiswa WHERE 1=1\t{$qfield} ORDER BY ".$arraysort[$sort]."";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Rekapitulasi Pembayaran Mahasiswa" );
        printmesg( $qjudul );
        printmesg( $errmesg );
    }
    else
    {
        printjudulmenucetak( "Rekapitulasi Pembayaran Mahasiswa" );
        printmesgcetak( $qjudul );
    }
    if ( $aksi != "cetak" )
    {
        echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetaklaporan4.php'>\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>\r\n  \t\t\t\t{$qinput}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    echo "\r\n \t\t\t<table {$border} class=data{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=0'>NIM</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=1'>Nama Mahasiswa</td> \r\n  \t\t\t";
    foreach ( $arraykomponenpembayaran as $k => $v )
    {
        echo "\r\n          <td class='hide' >Sisa<br>{$v}</td>\r\n          ";
    }
    echo "\r\n        \t\t\t<td>Total Sisa Rp. </td>\r\n   \t\t\t</tr>\r\n\t\t";
    $iw = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $iw );
        $totalbiaya = 0;
        $sisa = 0;
        $totalsisa2 = 0;
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi} valign=top>\r\n\t\t\t\t\t<td>{$iw}</td>\r\n  \t\t\t\t\t<td align=left>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']}</td> ";
        foreach ( $arraykomponenpembayaran2 as $k => $v )
        {
            $sisa = 0;
            $biaya = 0;
            $jml = 0;
            if ( $arrayjeniskomponenpembayaran[$k] == 0 )
            {
                $q = "SELECT BIAYA FROM biayakomponen WHERE \r\n\t\t\t\t\tIDKOMPONEN='{$k}' AND ANGKATAN='{$angkatan}' AND IDPRODI='{$idprodi}' AND GELOMBANG='{$gelombang}'";
                $h2 = mysqli_query($koneksi,$q);
                $d2 = sqlfetcharray( $h2 );
                $biaya = $d2[BIAYA] + 0;
                $q = "SELECT SUM(JUMLAH+DISKON) AS JML FROM bayarkomponen WHERE\r\n\t\t\t\t\tIDMAHASISWA='{$d['ID']}' AND IDKOMPONEN='{$k}'";
                $h2 = mysqli_query($koneksi,$q);
                $d2 = sqlfetcharray( $h2 );
                $jml = $d2[JML] + 0;
                $sisa += $biaya - $jml;
            }
            else
            {
                if ( $arrayjeniskomponenpembayaran[$k] == 1 )
                {
                    if ( trim( $dm[TA] ) != "" )
                    {
                        $q = "SELECT BIAYA FROM biayakomponen WHERE \r\n\t\t\t\t\t\t\tIDKOMPONEN='{$k}' AND ANGKATAN='{$angkatan}' AND IDPRODI='{$idprodi}' AND GELOMBANG='{$gelombang}'";
                        $h2 = mysqli_query($koneksi,$q);
                        $d2 = sqlfetcharray( $h2 );
                        $biaya = $d2[BIAYA] + 0;
                        $q = "SELECT SUM(JUMLAH+DISKON) AS JML FROM bayarkomponen WHERE\r\n\t\t\t\t\t\t\tIDMAHASISWA='{$d['ID']}' AND IDKOMPONEN='{$k}'";
                        $h2 = mysqli_query($koneksi,$q);
                        $d2 = sqlfetcharray( $h2 );
                        $jml = $d2[JML] + 0;
                        $sisa += $biaya - $jml;
                    }
                }
                else
                {
                    if ( $arrayjeniskomponenpembayaran[$k] == 2 )
                    {
                        $ii = $angkatan + 1;
                        while ( $ii <= $waktu[year] + 1 )
                        {
                            $q = "SELECT IDMAKUL FROM pengambilanmk WHERE IDMAHASISWA='{$d['ID']}' AND TAHUN='{$ii}' LIMIT 0,1";
                            $hx = mysqli_query($koneksi,$q);
                            if ( 0 < sqlnumrows( $hx ) )
                            {
                                $q = "SELECT BIAYA FROM biayakomponen WHERE \r\n\t\t\t\t\t\t\tIDKOMPONEN='{$k}' AND ANGKATAN='{$angkatan}' AND IDPRODI='{$idprodi}' AND GELOMBANG='{$gelombang}'";
                                $h2 = mysqli_query($koneksi,$q);
                                $d2 = sqlfetcharray( $h2 );
                                $biaya = $d2[BIAYA] + 0;
                                $q = "SELECT SUM(JUMLAH+DISKON) AS JML FROM bayarkomponen WHERE\r\n\t\t\t\t\t\t\tIDMAHASISWA='{$d['ID']}' AND IDKOMPONEN='{$k}' AND TAHUNAJARAN='{$ii}'";
                                $h2 = mysqli_query($koneksi,$q);
                                $d2 = sqlfetcharray( $h2 );
                                $jml = $d2[JML] + 0;
                                $sisa += $biaya - $jml;
                            }
                            ++$ii;
                        }
                    }
                    if ( $arrayjeniskomponenpembayaran[$k] == 3 )
                    {
                        $ii = $angkatan + 1;
                        while ( $ii <= $waktu[year] + 1 )
                        {
                            $isem = 1;
                            while ( $isem <= 3 )
                            {
                                $q = "SELECT IDMAKUL FROM pengambilanmk WHERE IDMAHASISWA='{$d['ID']}' AND TAHUN='{$ii}' AND\r\n\t\t\t\t\t\t\tSEMESTER='{$isem}' LIMIT 0,1";
                                $hx = mysqli_query($koneksi,$q);
                                if ( 0 < sqlnumrows( $hx ) )
                                {
                                    $jumlahsks = getjumlahsks( $d[ID], $ii, $isem );
                                    $jumlahskswajib = getjumlahskswajib( $d[ID], $ii, $isem );
                                    $skslebih = 0;
                                    if ( $jumlahskswajib < $jumlahsks )
                                    {
                                        $skslebih = $jumlahsks - $jumlahskswajib;
                                    }
                                    $q = "SELECT BIAYA AS TOTAL\r\n\t\t\t\t\t\tFROM biayakomponen,mahasiswa\r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\t  mahasiswa.IDPRODI=biayakomponen.IDPRODI AND\r\n\t\t\t\t\t\t  mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND\r\n\t\t\t\t\t\t  mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND\r\n\t\t\t\t\t\t  mahasiswa.ID='{$d['ID']}' AND\r\n\t\t\t\t\t\t  biayakomponen.IDKOMPONEN='99'\r\n\t\t\t\t\t\t\t \r\n\t\t\t\t\t\t";
                                    $ht = mysqli_query($koneksi,$q);
                                    $dt = sqlfetcharray( $ht );
                                    $biayakomponen = $dt[TOTAL] + 0;
                                    $biaya = $skslebih * $biayakomponen;
                                    $q = "SELECT BIAYA FROM biayakomponen WHERE \r\n\t\t\t\t\t\t\t\tIDKOMPONEN='{$k}' AND ANGKATAN='{$angkatan}' AND IDPRODI='{$idprodi}' AND  GELOMBANG='{$gelombang}' AND IDKOMPONEN!='99'";
                                    $h2 = mysqli_query($koneksi,$q);
                                    $d2 = sqlfetcharray( $h2 );
                                    $biaya += $d2[BIAYA] + 0;
                                    $q = "SELECT SUM(JUMLAH+DISKON) AS JML FROM bayarkomponen WHERE\r\n\t\t\t\t\t\t\t\tIDMAHASISWA='{$d['ID']}' AND IDKOMPONEN='{$k}' AND TAHUNAJARAN='{$ii}' AND\r\n\t\t\t\t\t\t\t\tSEMESTER='{$isem}'  ";
                                    $h2 = mysqli_query($koneksi,$q);
                                    $d2 = sqlfetcharray( $h2 );
                                    $jml = $d2[JML] + 0;
                                    $sisa += $biaya - $jml;
                                }
                                ++$isem;
                            }
                            ++$ii;
                        }
                    }
                    if ( $arrayjeniskomponenpembayaran[$k] == 5 )
                    {
                        $ii = $angkatan + 1;
                        while ( $ii <= $waktu[year] + 1 )
                        {
                            $isem = 1;
                            while ( $isem <= 12 )
                            {
                                $q = "SELECT IDMAKUL FROM pengambilanmk WHERE IDMAHASISWA='{$d['ID']}' AND TAHUN='{$ii}'  LIMIT 0,1";
                                $hx = mysqli_query($koneksi,$q);
                                if ( 0 < sqlnumrows( $hx ) )
                                {
                                    $q = "SELECT BIAYA FROM biayakomponen WHERE \r\n\t\t\t\t\t\t\t\tIDKOMPONEN='{$k}' AND ANGKATAN='{$angkatan}' AND IDPRODI='{$idprodi}' AND GELOMBANG='{$gelombang}'";
                                    $h2 = mysqli_query($koneksi,$q);
                                    $d2 = sqlfetcharray( $h2 );
                                    $biaya = $d2[BIAYA] + 0;
                                    $q = "SELECT SUM(JUMLAH+DISKON) AS JML FROM bayarkomponen WHERE\r\n\t\t\t\t\t\t\t\tIDMAHASISWA='{$d['ID']}' AND IDKOMPONEN='{$k}' AND TAHUNAJARAN='{$ii}' AND\r\n\t\t\t\t\t\t\t\tSEMESTER='{$isem}'";
                                    $h2 = mysqli_query($koneksi,$q);
                                    $d2 = sqlfetcharray( $h2 );
                                    $jml = $d2[JML] + 0;
                                    $sisa += $biaya - $jml;
                                }
                                ++$isem;
                            }
                            ++$ii;
                        }
                    }
                    if ( $arrayjeniskomponenpembayaran[$k] == 4 )
                    {
                        $q = "SELECT BIAYA FROM biayakomponen WHERE \r\n\t\t\t\t\tIDKOMPONEN='{$k}' AND ANGKATAN='{$angkatan}' AND IDPRODI='{$idprodi}' AND GELOMBANG='{$gelombang}'";
                        $h2 = mysqli_query($koneksi,$q);
                        $d2 = sqlfetcharray( $h2 );
                        $biaya = $d2[BIAYA] + 0;
                        $q = "SELECT SUM(JUMLAH+DISKON) AS JML FROM bayarkomponen WHERE\r\n\t\t\t\t\tIDMAHASISWA='{$d['ID']}' AND IDKOMPONEN='{$k}'";
                        $h2 = mysqli_query($koneksi,$q);
                        $d2 = sqlfetcharray( $h2 );
                        $jml = $d2[JML] + 0;
                        $sisa += $biaya - $jml;
                    }
                }
            }
            echo "<td class='hide'>".cetakuang( $sisa )."</td>";
            $totalsisa2 += $sisa;
            $totalsisa3 += $k;
        }
        if ( 0 < $totalsisa2 )
        {
            echo "<td >".cetakuang( $totalsisa2 )."</td>";
        }
        else
        {
            echo "<td align=center>LUNAS</td>";
        }
        echo "</tr>";
        $totalsisa += $totalsisa2;
        if ( 2 < $iw )
        {
            exit( );
        }
        ++$iw;
    }
    echo "</table>";
    echo "dew";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Komponen Pembayaran Tidak Ada";
    $aksi = "";
}
?>
