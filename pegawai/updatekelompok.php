<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

@cekuser( "AD" );
if ( $aksitambahan == "Update Data" )
{
    $i = 0;
    if ( is_array( $idupdate ) )
    {
        foreach ( $idupdate as $k => $v )
        {
            if ( $plgaji == "0" )
            {
                $tt = "NAMA";
            }
            else if ( $plgaji == "19" )
            {
                $tt = "NIP";
            }
            else if ( $plgaji == "20" )
            {
                $tt = "KARPEG";
            }
            else if ( $plgaji == "28" )
            {
                $tt = "TEMPATLAHIR";
            }
            else if ( $plgaji == "21" )
            {
                $tt = "AGAMA";
                $arr = "arrayagama";
            }
            else if ( $plgaji == "29" )
            {
                $tt = "SHIFT";
            }
            else if ( $plgaji == "30" )
            {
                $tt = "STATUSLOGIN";
            }
            else if ( $plgaji == "22" )
            {
                $tt = "PENDIDIKAN";
                $arr = "arraypendidikan";
            }
            else if ( $plgaji == "1" )
            {
                $tt = "BIDANG";
                $arr = "bidanguser";
            }
            else if ( $plgaji == "2" )
            {
                $tt = "STATUSPEGAWAI";
            }
            else if ( $plgaji == "13" )
            {
                $tt = "STATUSPEGAWAI2";
            }
            else if ( $plgaji == "14" )
            {
                $tt = "STATUSKERJA";
                $arr = "arraystatuskerja";
            }
            else if ( $plgaji == "3" )
            {
                $tt = "JABATAN";
            }
            else if ( $plgaji == "4" )
            {
                $tt = "JABATANS";
            }
            else if ( $plgaji == "5" )
            {
                $tt = "STATUSNIKAH";
            }
            else if ( $plgaji == "6" )
            {
                $tt = "JMLANAK";
            }
            else if ( $plgaji == "7" )
            {
                $tt = "ALAMAT";
            }
            else if ( $plgaji == "23" )
            {
                $tt = "KETPENDIDIKAN";
            }
            else if ( $plgaji == "8" )
            {
                $tt = "TELPON";
            }
            else if ( $plgaji == "9" )
            {
                $tt = "LOKASI";
            }
            else if ( $plgaji == "15" )
            {
                $tt = "LOKASIGAJI";
            }
            else if ( $plgaji == "10" )
            {
                $tt = "TINGKAT";
            }
            else if ( $plgaji == "11" )
            {
                $tt = "TGLLAHIR";
            }
            else if ( $plgaji == "16" )
            {
                $tt = "TMTJ";
            }
            else if ( $plgaji == "17" )
            {
                $tt = "TMTJS";
            }
            else if ( $plgaji == "18" )
            {
                $tt = "TMTG";
            }
            else if ( $plgaji == "24" )
            {
                $tt = "TMTP";
            }
            else if ( $plgaji == "12" )
            {
                $tt = "GOLONGAN";
                $tt2 = "SUBGOLONGAN";
            }
            else if ( $plgaji == "25" )
            {
                $tt = "TMTCPNS";
            }
            else if ( $plgaji == "26" )
            {
                $tt = "TMTPNS";
            }
            else if ( $plgaji == "27" )
            {
                $tt = "MTAHUN";
                $tt2 = "MBULAN";
            }
            else if ( $plgaji == "31" )
            {
                $tt = "GOLCPNS";
                $arr = "arraygolongan";
            }
            if ( $plgaji == "11" || $plgaji == "16" || $plgaji == "17" || $plgaji == "18" || $plgaji == "24" || $plgaji == "25" || $plgaji == "26" )
            {
                $gajiuser[$k] = "{$thndari[$k]}-{$blndari[$k]}-{$tgldari[$k]}";
            }
            if ( $tt2 != "" )
            {
                $tt2 = ", {$tt2} = '{$gajiuser2[$k]}' ";
            }
            $query = "UPDATE user SET \r\n\t\t\t{$tt}='{$gajiuser[$k]}' {$tt2}  WHERE \r\n\t\t\tID='{$v}' AND '{$v}'!='superadmin'";
            mysqli_query($koneksi,$query);
            $i += sqlaffectedrows( $koneksi );
        }
        if ( $i <= 0 )
        {
            $errmesg = "Tidak ada data  Operator yang diupdate";
        }
        else
        {
            $errmesg = angkatoteks( $i )." ( {$i} ) data   Operator telah diupdate";
        }
    }
    else
    {
        $errmesg = "Tidak ada data  Operator yang diupdate";
    }
    $aksi = "tampilkan";
}
if ( $aksi == "tampilkan" )
{
    if ( $plgaji == "0" )
    {
        $diupdate = ", NAMA AS NM";
        $j = "Nama";
        $tt = "NM";
    }
    else if ( $plgaji == "19" )
    {
        $diupdate = ", NIP";
        $j = "NIP";
        $tt = "NIP";
    }
    else if ( $plgaji == "20" )
    {
        $diupdate = ", KARPEG";
        $j = "Kartu Operator";
        $tt = "KARPEG";
    }
    else if ( $plgaji == "28" )
    {
        $diupdate = ", TEMPATLAHIR";
        $j = "Tempat Lahir";
        $tt = "TEMPATLAHIR";
    }
    else if ( $plgaji == "21" )
    {
        $diupdate = ", AGAMA";
        $j = "Agama";
        $tt = "AGAMA";
        $arr = "arrayagama";
    }
    else if ( $plgaji == "22" )
    {
        $diupdate = ", PENDIDIKAN";
        $j = "Pendidikan Terakhir";
        $tt = "PENDIDIKAN";
        $arr = "arraypendidikan";
    }
    else if ( $plgaji == "1" )
    {
        $diupdate = ", BIDANG";
        $j = "Bidang";
        $tt = "BIDANG";
        $arr = "bidanguser";
    }
    else if ( $plgaji == "2" )
    {
        $diupdate = ", STATUSPEGAWAI";
        $j = "Status Operator";
        $tt = "STATUSPEGAWAI";
        $arr = "arraystatuspegawai";
    }
    else if ( $plgaji == "13" )
    {
        $diupdate = ", STATUSPEGAWAI2";
        $j = "Status PNS";
        $tt = "STATUSPEGAWAI2";
        $arr = "arraystatuspegawai2";
    }
    else if ( $plgaji == "14" )
    {
        $diupdate = ", STATUSKERJA";
        $j = "Status Kerja";
        $tt = "STATUSKERJA";
        $arr = "arraystatuskerja";
    }
    else if ( $plgaji == "3" )
    {
        $diupdate = ", JABATAN";
        $j = "Jabatan Struktural";
        $tt = "JABATAN";
        $arr = "arrayjabatan";
    }
    else if ( $plgaji == "4" )
    {
        $diupdate = ", JABATANS";
        $j = "Jabatan Fungsional";
        $tt = "JABATANS";
        $arr = "arrayjabatans";
    }
    else if ( $plgaji == "5" )
    {
        $diupdate = ", STATUSNIKAH";
        $j = "Status Nikah";
        $tt = "STATUSNIKAH";
        $arr = "arraystatusnikah";
    }
    else if ( $plgaji == "6" )
    {
        $diupdate = ", JMLANAK";
        $j = "Jumlah Anak";
        $tt = "JMLANAK";
    }
    else if ( $plgaji == "7" )
    {
        $diupdate = ", ALAMAT";
        $j = "Alamat";
        $tt = "ALAMAT";
    }
    else if ( $plgaji == "23" )
    {
        $diupdate = ", KETPENDIDIKAN";
        $j = "Keterangan Pendidikan";
        $tt = "KETPENDIDIKAN";
    }
    else if ( $plgaji == "8" )
    {
        $diupdate = ", TELPON";
        $j = "Telepon";
        $tt = "TELPON";
    }
    else if ( $plgaji == "9" )
    {
        $diupdate = ", LOKASI";
        $j = "Lokasi";
        $tt = "LOKASI";
        $arr = "arraylokasi";
    }
    else if ( $plgaji == "15" )
    {
        $diupdate = ", LOKASIGAJI";
        $j = "Lokasi Gaji";
        $tt = "LOKASIGAJI";
        $arr = "arraylokasi";
    }
    else if ( $plgaji == "10" )
    {
        $diupdate = ", TINGKAT";
        $j = "Tingkat Akses";
        $tt = "TINGKAT";
        $arr = "tingkatuser";
    }
    else if ( $plgaji == "29" )
    {
        $diupdate = ", SHIFT";
        $j = "Shift Kehadiran";
        $tt = "SHIFT";
        $arr = "arrayshift";
    }
    else if ( $plgaji == "30" )
    {
        $diupdate = ", STATUSLOGIN";
        $j = "Status Login";
        $tt = "STATUSLOGIN";
        $arraystatuslogin[N] = "Tidak Login";
        $arraystatuslogin[L] = "Sedang Login";
        $arr = "arraystatuslogin";
    }
    else if ( $plgaji == "11" )
    {
        $diupdate = ", DAYOFMONTH(TGLLAHIR) AS TGL, MONTH(TGLLAHIR) AS BLN, YEAR(TGLLAHIR) AS THN";
        $j = "Tanggal Lahir";
        $tt = "TGLLAHIR";
    }
    else if ( $plgaji == "16" )
    {
        $diupdate = ", DAYOFMONTH(TMTJ) AS TGL, MONTH(TMTJ) AS BLN, YEAR(TMTJ) AS THN";
        $j = "TMT Jabatan Struktural";
        $tt = "TMTJ";
    }
    else if ( $plgaji == "17" )
    {
        $diupdate = ", DAYOFMONTH(TMTJS) AS TGL, MONTH(TMTJS) AS BLN, YEAR(TMTJS) AS THN";
        $j = "TMT Jabatan Fungsional";
        $tt = "TMTJ";
    }
    else if ( $plgaji == "18" )
    {
        $diupdate = ", DAYOFMONTH(TMTG) AS TGL, MONTH(TMTG) AS BLN, YEAR(TMTG) AS THN";
        $j = "TMT Pangkat / Golongan Ruang";
        $tt = "TMTG";
    }
    else if ( $plgaji == "24" )
    {
        $diupdate = ", DAYOFMONTH(TMTP) AS TGL, MONTH(TMTP) AS BLN, YEAR(TMTP) AS THN";
        $j = "TMT Pendidikan Terakhir";
        $tt = "TMTP";
    }
    else if ( $plgaji == "25" )
    {
        $diupdate = ", DAYOFMONTH(TMTCPNS) AS TGL, MONTH(TMTCPNS) AS BLN, YEAR(TMTCPNS) AS THN";
        $j = "TMT CPNS";
        $tt = "TMTCPNS";
    }
    else if ( $plgaji == "26" )
    {
        $diupdate = ", DAYOFMONTH(TMTPNS) AS TGL, MONTH(TMTPNS) AS BLN, YEAR(TMTPNS) AS THN";
        $j = "TMT PNS";
        $tt = "TMTPNS";
    }
    else if ( $plgaji == "27" )
    {
        $diupdate = ", MTAHUN, MBULAN";
        $j = "Masa Kerja Tambahan";
        $tt = "MTAHUN";
        $tt2 = "MBULAN";
        $x = 0;
        while ( $x <= 50 )
        {
            $arrth[$x] = $x;
            ++$x;
        }
        $x = 0;
        while ( $x <= 11 )
        {
            $arrbl[$x] = $x;
            ++$x;
        }
        $jth = "tahun";
        $jbl = "bulan";
    }
    else if ( $plgaji == "12" )
    {
        $diupdate = ", GOLONGAN, SUBGOLONGAN";
        $j = "Golongan Ruang";
        $tt = "GOLONGAN";
        $tt2 = "SUBGOLONGAN";
    }
    else if ( $plgaji == "31" )
    {
        $diupdate = ", GOLCPNS";
        $j = "Golongan CPNS";
        $tt = "GOLCPNS";
        $arr = "arraygolongan";
    }
    else
    {
        $aksi = "";
    }
}
if ( $aksi == "tampilkan" )
{
    if ( $tingkats == "A" )
    {
        $menulihat = "\t\t\t<table width=100%>\r\n\t\t\t\t<tr>\r\n\r\n\t\t\t\t\t<td align=right>\r\n\t\t\t\t\t\t<input class=tombol type=submit value='Update Data' name=aksitambahan>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>";
    }
    printmesg( $errmesg );
    $namadicari2 = trim( $namadicari );
    if ( $namadicari2 !== "" )
    {
        $qnama = " AND NAMA LIKE '%{$namadicari2}%'";
        $namadicari2 = htmlspecialchars( $namadicari2 );
        $jnama = ". Nama mengandung kata '{$namadicari2}'";
    }
    if ( $sort == "" )
    {
        $sort = "NAMA";
        $qsort = "ORDER BY {$sort}";
    }
    else
    {
        $qsort = "ORDER BY {$sort},NAMA";
    }
    if ( $bidang != "semua" )
    {
        $qbidang = " AND BIDANG = {$bidang} ";
        $jbidang = ". Bidang: ".$bidanguser[$bidang]."";
    }
    if ( $jabatan != "semua" )
    {
        $qjabatan = " AND JABATAN = {$jabatan} ";
        $jjabatan = ". Jabatan Struktural: ".$arrayjabatan[$jabatan]."";
    }
    if ( $jabatan2 != "semua" )
    {
        $qjabatan2 = " AND JABATANS = {$jabatan2} ";
        $jjabatan2 = ". Jabatan Fungsional: ".$arrayjabatans[$jabatan2]."";
    }
    if ( $lokasi != "semua" )
    {
        $qlokasi = " AND LOKASI = {$lokasi} ";
        $jlokasi = ". Lokasi Kerja: ".$arraylokasi[$lokasi]."";
    }
    if ( $lokasigaji != "semua" )
    {
        $qlokasigaji = " AND LOKASIGAJI = {$lokasigaji} ";
        $jlokasigaji = ". Lokasi Gaji: ".$arraylokasi[$lokasigaji]."";
    }
    if ( $gol != "semua" )
    {
        $qgol = " AND GOLONGAN = {$gol} ";
        $jgol = ". Golongan: ".$arraygolongan[$gol]."";
    }
    if ( $subgol != "semua" )
    {
        $qsubgol = " AND SUBGOLONGAN = '{$subgol}' ";
        $jsubgol = ". Ruang: ".$arraysubgolongan[$subgol]."";
    }
    if ( $statuspegawai != "semua" )
    {
        $qstatuspegawai = " AND STATUSPEGAWAI = {$statuspegawai} ";
        $jstatuspegawai = ". Status Operator: ".$arraystatuspegawai[$statuspegawai]."";
    }
    if ( $statuspegawai2 != "semua" )
    {
        $qstatuspegawai2 = " AND STATUSPEGAWAI2 = {$statuspegawai2} ";
        $jstatuspegawai2 = ". Status PNS: ".$arraystatuspegawai2[$statuspegawai2]."";
    }
    $qstatuskerja = " AND STATUSKERJA = {$statuskerja} ";
    $jstatuskerja = ". Status Kerja: ".$arraystatuskerja[$statuskerja]."";
    $query = "SELECT ID, NAMA {$diupdate}\r\n\t\tFROM user WHERE ID!='superadmin' \r\n\t\t{$qjabatan} {$qjabatan2} {$qgol} {$qsubgol} {$qbidang} {$qlokasi} \r\n\t\t{$qlokasigaji}\r\n\t\t{$qstatuspegawai} \r\n\t\t{$qstatuspegawai2} \r\n\t\t{$qstatuskerja} \r\n\t\t{$qshift} {$qstatusl}\r\n\t\t{$qnama} \r\n\t\t{$qsort} ";
    $hasil =mysqli_query($koneksi,$query);
    if ( 0 < sqlnumrows( $hasil ) )
    {
        $i = 1;
        settype( $i, "integer" );
        $href = "index.php?pilihan=kupdate&aksi=tampilkan&bidang={$bidang}&statuspegawai={$statuspegawai}&statuspegawai2={$statuspegawai2}&statuskerja={$statuskerja}&lokasi={$lokasi}&lokasigaji={$lokasigaji}&namadicari={$namadicari2}&shift={$shift}&statuslogin={$statuslogin}&jabatan={$jabatan}&jabatan2={$jabatan2}&plgaji={$plgaji}&gol={$gol}&subgol={$subgol}&";
        printmesg( "Data Operator".$jnama.$jjabatan.$jjabatan2.$jgol.$jsubgol.$jbidang.$jstatuspegawai.$jstatuspegawai2.$jstatuskerja.$jlokasi.$jlokasigaji.$jshift.$jstatusl );
        echo "<CENTER>\r\n<table width=100% {$tabellatar}>\r\n<tr\tvalign=top>\r\n<td align=center>\t\r\n\t\t<form action=index.php?pilihan=kupdate&aksi=tampilkan method=post>\r\n\t\t<input type=hidden name=sort value='{$sort}'>\r\n\t\t<input type=hidden name=namadicari value='{$namadicari}'>\r\n\t\t<input type=hidden name=bidang value='{$bidang}'>\r\n\t\t<input type=hidden name=lokasi value='{$lokasi}'>\r\n\t\t<input type=hidden name=lokasigaji value='{$lokasigaji}'>\r\n\t\t<input type=hidden name=plgaji value='{$plgaji}'>\r\n\t\t<input type=hidden name=gol value='{$gol}'>\r\n\t\t<input type=hidden name=subgol value='{$subgol}'>\r\n\t\t<input type=hidden name=jabatan value='{$jabatan}'>\r\n\t\t<input type=hidden name=jabatan2 value='{$jabatan2}'>\r\n\t\t<input type=hidden name=statuspegawai value='{$statuspegawai}'>\r\n\t\t<input type=hidden name=statuspegawai2 value='{$statuspegawai2}'>\r\n\t\t<input type=hidden name=statuskerja value='{$statuskerja}'>\r\n\t\t\t{$menulihat}\t\r\n\t\t\t<table width=100%  {$tabelisian}\t>\r\n\t\t\t<tr class=judulkolom>\r\n\t\t\t\t<td align=center>No</td>\r\n\t\t\t\t<td align=center><a href='{$href}"."sort=ID"."'>ID</a></td>\r\n\t\t\t\t<td align=center><a href='{$href}"."sort=NAMA"."'>Nama</a></td>\r\n\t\t\t\r\n\t\t\t\t<td align=center>{$j}</td>\r\n\t\t\t\t\r\n\r\n\t\t\t</tr>";
        while ( $data = sqlfetcharray( $hasil ) )
        {
            if ( $i % 2 == 0 )
            {
                $kelas = "class=datagenap";
            }
            else
            {
                $kelas = "class=dataganjil";
            }
            echo "\r\n\t\t\t\t<tr {$kelas} valign=top>\r\n\t\t\t\t\t<td align=center>{$i}\r\n\t\t\t\t\t\t<input type=hidden name=idupdate[{$i}] value='{$data['ID']}'>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td align=center>".printid( $data[ID] )."</td>\r\n\t\t\t\t\t<td >{$data['NAMA']}</td>\r\n\t\t\t\t\t<td align=center>";
            if ( $plgaji == "0" || $plgaji == "6" || $plgaji == "8" || $plgaji == "19" || $plgaji == "20" || $plgaji == "28" )
            {
                echo "<input type=text size=20 class=teksbox name=gajiuser[{$i}] value='".$data[$tt]."'>";
            }
            else if ( $plgaji == "7" || $plgaji == "23" )
            {
                echo "<textarea name=gajiuser[{$i}] cols=55 rows=3 class=teksbox>".$data[$tt]."</textarea>";
            }
            else if ( $plgaji == "1" || $plgaji == "2" || $plgaji == "3" || $plgaji == "4" || $plgaji == "5" || $plgaji == "9" || $plgaji == "10" || $plgaji == "14" || $plgaji == "13" || $plgaji == "15" || $plgaji == "21" || $plgaji == "22" || $plgaji == "29" || $plgaji == "30" || $plgaji == "31" )
            {
                $c = $data[$tt];
                echo "\r\n\t\t\t\t\t\t<select name=gajiuser[{$i}] class=teksbox>";
                foreach ( $$arr as $k => $v )
                {
                    if ( $c == $k )
                    {
                        $cek = "selected";
                    }
                    echo "<option value='{$k}' {$cek}>{$v}</option>";
                    $cek = "";
                }
                echo "\t\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t\t\t";
            }
            else if ( $plgaji == "12" || $plgaji == "27" )
            {
                if ( $plgaji == "12" )
                {
                    $arr = "arraygolongan";
                    $arr2 = "arraysubgolongan";
                }
                if ( $plgaji == "27" )
                {
                    $arr = "arrth";
                    $arr2 = "arrbl";
                }
                $c1 = $data[$tt];
                $c2 = $data[$tt2];
                echo "\r\n\t\t\t\t\t\t<select name=gajiuser[{$i}] class=teksbox>";
                foreach ( $$arr as $k => $v )
                {
                    if ( $c1 == $k )
                    {
                        $cek = "selected";
                    }
                    echo "<option value='{$k}'  {$cek}>{$v}</option>";
                    $cek = "";
                }
                echo "\t\r\n\t\t\t\t\t\t</select> {$jth}\r\n\t\t\t\t\t\t";
                echo "\r\n\t\t\t\t\t\t<select name=gajiuser2[{$i}] class=teksbox>";
                foreach ( $$arr2 as $k => $v )
                {
                    if ( $c2 == $k )
                    {
                        $cek = "selected";
                    }
                    echo "<option value='{$k}'  {$cek}>{$v}</option>";
                    $cek = "";
                }
                echo "\t\r\n\t\t\t\t\t\t</select> {$jbl}\r\n\t\t\t\t\t\t";
            }
            else if ( $plgaji == "11" || $plgaji == "16" || $plgaji == "17" || $plgaji == "18" || $plgaji == "24" || $plgaji == "25" || $plgaji == "26" )
            {
                echo "\r\n\t\t\t\t\t\t\t<select class=teksbox name=tgldari[{$i}]>";
                $j = 1;
                while ( $j <= 31 )
                {
                    if ( $data[TGL] == $j )
                    {
                        $cek = "selected";
                    }
                    echo "<option value={$j} {$cek}>{$j}</option>";
                    $cek = "";
                    ++$j;
                }
                echo "\t\r\n\t\t\t\t\t\t\t</select>-\t\t\t\r\n\t\t\t\t\t\t\t<select class=teksbox name=blndari[{$i}]>";
                $j = 1;
                while ( $j <= 12 )
                {
                    if ( $data[BLN] == $j )
                    {
                        $cek = "selected";
                    }
                    echo "<option value={$j} {$cek}>".$arraybulan[$j - 1]."</option>";
                    $cek = "";
                    ++$j;
                }
                echo "\r\n\t\t\t\t\t\t\t</select>-\r\n\t\t\t\t\t\t\t<select class=teksbox name=thndari[{$i}]>";
                $j = 1900;
                while ( $j <= $waktu[year] )
                {
                    if ( $data[THN] == $j )
                    {
                        $cek = "selected";
                    }
                    echo "<option value={$j} {$cek}>{$j}</option>";
                    $cek = "";
                    ++$j;
                }
                echo "\r\n\t\t\t\t\t\t\t</select>";
            }
            echo "\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>";
            ++$i;
        }
        echo "</table>{$menulihat}\r\n\t\t</td>\r\n</tr>\r\n</table>\r\n\t\t";
    }
    else
    {
        printmesg( "Data Operator tidak ada" );
        $aksi = "";
    }
}
if ( $aksi == "" )
{
    echo "<CENTER>\r\n<table width=100% ";
    echo $tabellatar;
    echo ">\r\n<tr\tvalign=top>\r\n<td >\r\n";
    printman( $manupdatekupdate );
    echo "<form action=index.php?pilihan=kupdate method=post>\r\n<input type=hidden name=pilihan value=\"kupdate\">\r\n<input type=hidden name=aksi value=\"tampilkan\">\r\n<input type=hidden name=sort value=\"ID\">\r\n<table ";
    echo $tabelpengumuman;
    echo " width=700>\r\n\r\n\r\n\t<tr valign=top>\r\n\t\t<td width=200>Nama</td>\r\n\t\t<td>\r\n\t\t\t<input type=text name=namadicari class=teksbox value='";
    echo $namadicari;
    echo "'>\r\n\t\t\t<br>Kosongkan isian Nama untuk menampilkan seluruh data atau isi untuk \r\n\t\t\tmenampilkan seluruh Operator dengan nama yang mengandung kata yang dimasukkan\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td >Jabatan Struktural</td>\r\n\t\t<td>\r\n\t\t\t";
    echo "<s";
    echo "elect class=teksbox name=jabatan>\r\n\t\t\t\t<option value='semua'>Semua Jabatan</option>\r\n\t\t\t";
    foreach ( $arrayjabatan as $k => $v )
    {
        echo "<option {$cek} value={$k} >{$v}</option>";
    }
    echo "\t\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td >Jabatan Fungsional</td>\r\n\t\t<td>\r\n\t\t\t";
    echo "<s";
    echo "elect class=teksbox name=jabatan2>\r\n\t\t\t\t<option value='semua'>Semua Jabatan</option>\r\n\t\t\t";
    foreach ( $arrayjabatans as $k => $v )
    {
        echo "<option {$cek} value={$k} >{$v}</option>";
    }
    echo "\t\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Golongan Ruang</td>\r\n\t\t<td>\r\n\t\t\t";
    echo "<s";
    echo "elect class=teksbox name=gol>\r\n\t\t\t\t<option value='semua' >Semua Gol</option>\r\n\t\t\t";
    foreach ( $arraygolongan as $k => $v )
    {
        echo "<option {$cek} value={$k} >{$v}</option>";
    }
    echo "\t\t\t</select>\r\n\t\t\t";
    echo "<s";
    echo "elect class=teksbox name=subgol>\r\n\t\t\t\t<option value='semua' >Semua Sub. Gol</option>\r\n\t\t\t";
    foreach ( $arraysubgolongan as $k => $v )
    {
        echo "<option {$cek} value={$k} >{$v}</option>";
    }
    echo "\t\t\t</select>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td >Bidang</td>\r\n\t\t<td>\r\n\t\t\t";
    echo "<s";
    echo "elect class=teksbox name=bidang>\r\n\t\t\t\t<option value=semua >Semua Bidang</option>\r\n\t\t\t";
    foreach ( $bidanguser as $k => $v )
    {
        echo "<option {$cek} value={$k} >{$v}</option>";
    }
    echo "\t\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td >Status Operator</td>\r\n\t\t<td>\r\n\t\t\t";
    echo "<s";
    echo "elect class=teksbox name=statuspegawai>\r\n\t\t\t\t<option value=semua >Semua Status</option>\r\n\t\t\t";
    foreach ( $arraystatuspegawai as $k => $v )
    {
        echo "<option {$cek} value={$k} >{$v}</option>";
    }
    echo "\t\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td >Status PNS</td>\r\n\t\t<td>\r\n\t\t\t";
    echo "<s";
    echo "elect class=teksbox name=statuspegawai2>\r\n\t\t\t\t<option value=semua >Semua Status</option>\r\n\t\t\t";
    foreach ( $arraystatuspegawai2 as $k => $v )
    {
        echo "<option {$cek} value={$k} >{$v}</option>";
    }
    echo "\t\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td >Status Kerja</td>\r\n\t\t<td>\r\n\t\t\t";
    echo "<s";
    echo "elect class=teksbox name=statuskerja>\r\n\t\t\t\t<option value=semua >Semua Status</option>\r\n\t\t\t";
    foreach ( $arraystatuskerja as $k => $v )
    {
        echo "<option {$cek} value={$k} >{$v}</option>";
    }
    echo "\t\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\r\n\t<tr>\t\t\t\t\t\r\n\t<td >\tLokasi Kerja</td>\r\n\t<td>\r\n\t\t\t\t\t\r\n\t\t";
    echo "<s";
    echo "elect class=teksbox name=lokasi>\r\n\t\t\t<option value=semua >Semua Lokasi</option>\r\n\t\t\t";
    foreach ( $arraylokasi as $k => $v )
    {
        echo "<option {$cek} value={$k} >{$v}</option>";
    }
    echo "\t\t</select>\r\n\t</td>\r\n\t</tr>\r\n\r\n\t<tr>\t\t\t\t\t\r\n\t<td >\tLokasi Gaji</td>\r\n\t<td>\r\n\t\t\t\t\t\r\n\t\t";
    echo "<s";
    echo "elect class=teksbox name=lokasigaji>\r\n\t\t\t<option value=semua >Semua Lokasi</option>\r\n\t\t\t";
    foreach ( $arraylokasi as $k => $v )
    {
        echo "<option {$cek} value={$k} >{$v}</option>";
    }
    echo "\t\t</select>\r\n\t</td>\r\n\t</tr>\r\n\r\n\r\n\t<tr>\t\t\t\t\t\r\n\t<td >\tData yang hendak diupdate</td>\r\n\t<td>\r\n\t\t\t\t\t\r\n\t\t";
    echo "<s";
    echo "elect class=teksbox name=plgaji>\r\n\t\t\t<option value='-' >-------Pilih Salah Satu -----</option>\r\n\t\t\t<option value='19' >NIP</option>\r\n\t\t\t<option value='20' >Karpeg</option>\r\n\t\t\t<option value='-' > ------------------------------------ </option>\r\n\t\t\t<option value='0' >Nama</option>\r\n\t\t\t<option value='7' >Alamat</option>\r\n\t\t\t<option value='28' >Tempat Lahir</option>\r\n\t\t\t<option value='11' >Tanggal Lahir</option>\r\n\t\t\t";
    echo "<option value='8' >Telepon</option>\r\n\t\t\t<option value='21' >Agama</option>\r\n\t\t\t<option value='-' > ------------------------------------ </option>\r\n\t\t\t<option value='1' >Bidang</option>\r\n\t\t\t<option value='2' >Status Operator</option>\r\n\t\t\t<option value='13' >Status PNS</option>\r\n\t\t\t<option value='14' >Status Kerja</option>\r\n\t\t\t<option value='-' > ------------------------------------ </option>\r\n\t\t\t<option value='31' ";
    echo ">Golongan CPNS</option>\r\n\t\t\t<option value='25' >TMT CPNS</option>\r\n\t\t\t<option value='26' >TMT PNS</option>\r\n\t\t\t<option value='27' >Masa Kerja Tambahan</option>\r\n\t\t\t<option value='-' > ------------------------------------ </option>\r\n\t\t\t<option value='3' >Jabatan Struktural</option>\r\n\t\t\t<option value='16' >TMT Jabatan Struktural</option>\r\n\t\t\t<option value='4' >Jabatan Fungsional</option>\r\n\t\t\t<option value='17' >TMT";
    echo " Jabatan Fungsional</option>\r\n\t\t\t<option value='12' >Golongan Ruang</option>\r\n\t\t\t<option value='18' >TMT Golongan Ruang</option>\r\n\t\t\t<option value='-' > ------------------------------------ </option>\r\n\t\t\t<option value='5' >Status Nikah</option>\r\n\t\t\t<option value='6' >Jumlah Anak</option>\r\n\t\t\t<option value='-' > ------------------------------------ </option>\r\n\t\t\t<option value='22' >Pendidikan Terakhir</option>\r\n\t";
    echo "\t\t<option value='23' >Keterangan Pendidikan</option>\r\n\t\t\t<option value='24' >TMT Pendidikan Terakhir</option>\r\n\t\t\t<option value='-' > ------------------------------------ </option>\r\n\t\t\t<option value='9' >Lokasi Kerja</option>\r\n\t\t\t<option value='15' >Lokasi Gaji</option>\r\n\t\t\t<option value='-' > ------------------------------------ </option>\r\n\t\t\t<option value='10' >Tingkat Akses</option>\r\n\t\t\t<option value='29' >Sh";
    echo "ift Kehadiran</option>\r\n\t\t\t<option value='30' >Status Login</option>\r\n\t\t</select>\r\n\t</td>\r\n\t</tr>\r\n\r\n\r\n\t<tr valign=top>\r\n\t\t<td colspan=2><br>\r\n\t\t\t<input class=tombol type=submit value='  OK  '>\r\n\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t</td>\r\n\t</tr>\r\n</table>\r\n</form>\r\n\r\n</td>\r\n</tr>\r\n</table>\r\n</CENTER>\r\n\r\n";
}
?>
