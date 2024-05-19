<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\n\t\r\ntr.datagenapcetak td, tr.dataganjilcetak td, tr.juduldatacetak td {\r\n\tborder:none;\r\n\t}\r\n\r\ntr.juduldatacetak, td {\r\n\tborder:none;\r\n\t}\r\n\t\r\n.borderline {\r\n\tborder-top:1px solid black;\r\n\tborder-right:1px solid black;\r\n\t}\r\n\t\r\n.borderline td {\r\n\tborder-bottom:1px solid black;\r\n\tborder-left:1px solid black;\r\n\tpadding:5px;\r\n\tfont-size:13px;\r\n\t}\r\n\t\r\n.bottomcontent td{\r\n\t\tborder:";
echo "none;\r\n\t\tfont-size:12px;\r\n\t\tfont-weight:normal;\r\n\t}\r\n\r\n</style>\r\n";
periksaroot( );
if ( $jenisusers == 3 )
{
    $idmahasiswa = $users;
}
unset( $arraysort );
$arraysort[0] = "mahasiswa.ID";
$arraysort[1] = "mahasiswa.NAMA";
$arraysort[2] = "bayarkomponen.IDKOMPONEN";
$arraysort[3] = "bayarkomponen.TANGGALBAYAR";
$arraysort[4] = "bayarkomponen.JUMLAH";
$arraysort[5] = "bayarkomponen.DISKON";
$arraysort[6] = "bayarkomponen.JUMLAH-DISKON";
$arraysort[7] = "bayarkomponen.TAHUNAJARAN";
$arraysort[8] = "bayarkomponen.CARABAYAR";
$arraysort[9] = "bayarkomponen.KET";
$arraysort[10] = "mahasiswa.IDPRODI";
$arraysort[11] = "bayarkomponen.TGLUPDATE";
$arraysort[12] = "bayarkomponen.DISKON";
$href = "index.php?pilihan={$pilihan}&aksi=Tampilkan&";
if ( $idmahasiswa != "" )
{
    $qfield .= " AND mahasiswa.ID = '{$idmahasiswa}'";
    $qjudul .= " NIM  '{$idmahasiswa}' <br>";
    $qinput .= " <input type=hidden name=idmahasiswa value='{$idmahasiswa}'>";
    $href .= "idmahasiswa={$idmahasiswa}&";
}
if ( $angkatan != "" )
{
    $qfield .= " AND mahasiswa.ANGKATAN = '{$angkatan}'";
    $qjudul .= " Angkatan '{$angkatan}' <br>";
    $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
    $href .= "angkatan={$angkatan}&";
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
    $qfield .= " AND msmhs.SHIFTMSMHS = '{$kelas}'";
    $qjudul .= " Kelas '".$arraykelasmhs[$kelas]."' <br>";
    $qinput .= " <input type=hidden name=kelas value='{$kelas}'>";
    $href .= "kelas={$kelas}&";
}
$href .= "jenistanggal={$jenistanggal}&tgl1[tgl]={$tgl1['tgl']}&tgl1[bln]={$tgl1['bln']}&tgl1[thn]={$tgl1['thn']}&tgl2[tgl]={$tgl2['tgl']}&tgl2[bln]={$tgl2['bln']}&tgl2[thn]={$tgl2['thn']}&";
if ( is_array( $jeniskomponen ) )
{
    $qkomponen = " AND (  ";
    $qjudul .= "Komponen pembayaran : <br>";
    foreach ( $jeniskomponen as $k => $v )
    {
        $idkomponen = $k;
        $qinput .= "<input type=hidden name='jeniskomponen[{$idkomponen}]' value=1>";
        $qkomponen .= "  bayarkomponen.IDKOMPONEN = '{$idkomponen}'  ";
        $qjudul .= " - {$arraykomponenpembayaran[$idkomponen]}<br>";
        $href .= "jeniskomponen[{$idkomponen}]=1&";
        if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 )
        {
            if ( $tahunajaran != "" )
            {
                $qkomponen .= " AND bayarkomponen.TAHUNAJARAN = '{$tahunajaran}' ";
                $adatahunajaran = 1;
            }
        }
        else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 3 )
        {
            if ( $semesterbayar != "" )
            {
                $qkomponen .= " AND bayarkomponen.SEMESTER = '{$semesterbayar}' ";
                $adasemesterbayar = 1;
            }
            if ( $tahunbayar != "" )
            {
                $qkomponen .= " AND bayarkomponen.TAHUNAJARAN = '{$tahunbayar}' ";
                $adatahunbayar = 1;
            }
        }
        else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
        {
            if ( $semesterbayar2 != "" )
            {
                $qkomponen .= " AND bayarkomponen.SEMESTER = '{$semesterbayar2}' ";
                $adasemesterbayar2 = 1;
            }
            if ( $tahunajaran2 != "" )
            {
                $adatahunajaran2 = 1;
                $qkomponen .= " AND bayarkomponen.TAHUNAJARAN = '{$tahunajaran2}'";
            }
        }
        $qkomponen .= "  OR";
    }
    $qkomponen .= ")";
    $qkomponen = str_replace( "OR)", ")", $qkomponen );
    $qfield .= $qkomponen;
    if ( $adatahunajaran == 1 )
    {
        $qjudul .= " Tahun Akademik '".( $tahunajaran - 1 )."/{$tahunajaran}' <br>";
        $qinput .= " <input type=hidden name=tahunajaran value='{$tahunajaran}'>";
        $href .= "tahunajaran={$tahunajaran}&";
    }
    if ( $adatahunbayar == 1 || $adasemesterbayar == 1 )
    {
        $qjudul .= " Tahun Akademik dan Semester '".( $tahunbayar - 1 )."/{$tahunbayar} / ".$arraysemester[$semesterbayar]."' <br>";
        $qinput .= " <input type=hidden name=tahunbayar value='{$tahunbayar}'>";
        $href .= "tahunbayar={$tahunbayar}&";
        $qinput .= " <input type=hidden name=semesterbayar value='{$semesterbayar}'>";
        $href .= "semesterbayar={$semesterbayar}&";
    }
    if ( $adasemesterbayar2 == 1 || $adatahunajaran2 == 1 )
    {
        $qjudul .= " Bulan  ".$arraybulan[$semesterbayar2 - 1]."  ";
        $qinput .= " <input type=hidden name=semesterbayar2 value='{$semesterbayar2}'>";
        $href .= "semesterbayar2={$semesterbayar2}&";
        $qjudul .= " Tahun : {$tahunajaran2} <br>";
        $qinput .= " <input type=hidden name=tahunajaran2 value='{$tahunajaran2}'>";
        $href .= "tahunajaran2={$tahunajaran2}&";
    }
}
if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
{
    $qfieldjeniskelas = " AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS='{$jeniskelas}' ";
    $qfieldjeniskelasm = " AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS=mahasiswa.JENISKELAS  ";
}
else
{
    $qfieldjeniskelasm = " AND biayakomponen.JENISKELAS='' ";
    $qfieldjeniskelas = " AND biayakomponen.JENISKELAS='' ";
}
$q = "SELECT  biayakomponen.*,komponenpembayaran.NAMA AS NAMAK,komponenpembayaran.JENIS,\r\n\t mahasiswa.NAMA {$field99} , \r\n\t mahasiswa.IDPRODI, \r\n\t mahasiswa.ID,mahasiswa.ANGKATAN,\r\n\tprodi.TINGKAT,\r\n\tmsmhs.SHIFTMSMHS,SMAWLMSMHS,BTSTUMSMHS\r\n\t FROM komponenpembayaran,biayakomponen,  mahasiswa,msmhs,prodi\r\n\tWHERE \r\n\tmahasiswa.ID=msmhs.NIMHSMSMHS AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND \r\n\tbiayakomponen.ANGKATAN=mahasiswa.ANGKATAN AND\r\n\tbiayakomponen.IDPRODI=mahasiswa.IDPRODI AND\r\n\tbiayakomponen.GELOMBANG=mahasiswa.GELOMBANG AND\r\n  biayakomponen.IDKOMPONEN=komponenpembayaran.ID AND\r\n  ( komponenpembayaran.JENIS!=4 AND komponenpembayaran.JENIS!=5 ) AND\r\n  biayakomponen.BIAYA>0 \r\n\t {$qfield}\r\n\t {$qfieldjeniskelasm}\r\n\tORDER BY mahasiswa.ID,komponenpembayaran.JENIS,komponenpembayaran.NAMA\r\n  {$qlimit}\r\n  ";
$h = mysqli_query($koneksi,$q);
echo mysqli_error($koneksi);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Rekap Tunggakan Pembayaran Keuangan Mahasiswa" );
        printmesg( $qjudul );
        printmesg( $errmesg );
    }
    else
    {
        printjudulmenucetak( "Rekap Tunggakan  Pembayaran Keuangan Mahasiswa" );
        printmesgcetak( $qjudul );
    }
    if ( $aksi != "cetak" )
    {
        echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetaklaporan7.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>\r\n \t\t\t\t\r\n   \t\t\t\t{$qinput}\r\n   \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    echo "\r\n\t\t{$tpage} {$tpage2}\r\n \t\t\t<table class=borderline cellpadding=0 cellspacing=0>\r\n\t\t\t<tr align=center style='background:#b0e2ff;'>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td> NPM</td>\r\n\t\t\t\t<td> Nama </td>\r\n\t\t\t\t<td> Program Studi</td>\r\n\t\t\t\t<td> Angkatan</td>\r\n\t\t\t\t<td> Kelas</td>\r\n\t\t\t\t<td> Komponen</td>\r\n\t\t\t\t<td>Periode</td>\r\n\t\t\t\t<td>Wajib Bayar</td>\r\n\t\t\t\t<td>Total Bayar</td>\r\n\t\t\t\t<td>Sisa</td>\r\n  \t\t\t</tr>\r\n\t\t";
    $i = 1;
    $nimlama = "";
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $tmp = $d[SMAWLMSMHS];
        $tahunawal = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
        if ( $tahunawal < 1901 )
        {
            $tahunawal = $d[ANGKATAN];
        }
        $semesterawal = $tmp[4];
        $tmp = $d[BTSTUMSMHS];
        $tahunakhir = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
        if ( $tahunakhir < 1901 )
        {
            $tahunakhir = $tahunawal + 7 - 1;
        }
        $semesterakhir = $tmp[4];
        $tmp = explode( "-", $d[TANGGALBAYAR] );
        $tglbayar[tgl] = $tmp[2];
        $tglbayar[bln] = $tmp[1];
        $tglbayar[thn] = $tmp[0];
        $nomer = $npm = $nama = $namaprodi = $angkatan = $kelas = "";
        if ( $nimlama != $d[ID] )
        {
            $nomer = $i;
            $npm = $d[ID];
            $nama = $d[NAMA];
            $namaprodi = $arrayprodi[$d[IDPRODI]]." ".$arrayjenjang[$d[TINGKAT]];
            $angkatan = $d[ANGKATAN];
            $kelas = $arraykelasmhs[$d[SHIFTMSMHS]];
        }
        $periode = "";
        $diskonbeasiswa = 0;
        $biaya = $d[BIAYA];
        if ( $d[JENIS] == 0 || $d[JENIS] == 1 )
        {
            $q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$d['ID']}' AND IDKOMPONEN='{$d['IDKOMPONEN']}' ";
            $hdiskon = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $hdiskon ) )
            {
                $ddiskon = sqlfetcharray( $hdiskon );
                $diskonbeasiswa = $ddiskon[DISKON];
            }
            $wajibbayar = $biaya * ( 100 - $diskonbeasiswa ) / 100;
            $totalbayar = getbayarkomponen( "{$d['ID']}", "{$d['IDKOMPONEN']}", "{$d['JENIS']}", $tahun = "", $semester = "" );
        }
        else if ( $d[JENIS] == 2 )
        {
            $q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$d['ID']}' AND IDKOMPONEN='{$d['IDKOMPONEN']}' AND TAHUN='".( $tahunawal + 1 )."' ";
            $hdiskon = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $hdiskon ) )
            {
                $ddiskon = sqlfetcharray( $hdiskon );
                $diskonbeasiswa = $ddiskon[DISKON];
            }
            $wajibbayar = $biaya * ( 100 - $diskonbeasiswa ) / 100;
            $periode = "{$d['ANGKATAN']}/".( $d[ANGKATAN] + 1 );
            $totalbayar = getbayarkomponen( "{$d['ID']}", "{$d['IDKOMPONEN']}", "{$d['JENIS']}", $tahunawal + 1, $semester = "" );
        }
        else if ( $d[JENIS] == 3 )
        {
            if ( iscuti( $idmahasiswa, $tahunawal.$semesterawal ) )
            {
                $wajibbayar = 0;
            }
            else
            {
                $q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$d['ID']}' AND IDKOMPONEN='{$d['IDKOMPONEN']}' AND TAHUN='".( $tahunawal + 1 )."' AND\r\n              SEMESTER='{$semesterawal}'\r\n              ";
                $hdiskon = mysqli_query($koneksi,$q);
                if ( 0 < sqlnumrows( $hdiskon ) )
                {
                    $ddiskon = sqlfetcharray( $hdiskon );
                    $diskonbeasiswa = $ddiskon[DISKON];
                }
                $wajibbayar = $biaya * ( 100 - $diskonbeasiswa ) / 100;
                if ( $d[IDKOMPONEN] == 99 )
                {
                    $jumlahsks = getjumlahsks( $d[ID], $tahunawal + 1, $semesterawal );
                    $jumlahskswajib = getjumlahskswajib( $d[ID], $tahunawal + 1, $semesterawal );
                    $skslebih = 0;
                    if ( $jumlahskswajib < $jumlahsks )
                    {
                        $skslebih = $jumlahsks - $jumlahskswajib;
                    }
                    if ( $BIAYASKSKULIAH == 1 )
                    {
                        $biaya = $jumlahsks * $d[BIAYA];
                    }
                    else
                    {
                        $biaya = $skslebih * $d[BIAYA];
                    }
                    $wajibbayar = $biaya * ( 100 - $diskonbeasiswa ) / 100;
                }
                else if ( $d[IDKOMPONEN] == 98 )
                {
                    $jumlahsks = getjumlahskssp( $d[ID], $tahunawal + 1, $semesterawal );
                    $jumlahskswajib = 0;
                    $skslebih = 0;
                    if ( $jumlahskswajib < $jumlahsks )
                    {
                        $skslebih = $jumlahsks - $jumlahskswajib;
                    }
                    if ( $BIAYASKSKULIAH == 1 )
                    {
                        $biaya = $jumlahsks * $d[BIAYA];
                    }
                    else
                    {
                        $biaya = $skslebih * $d[BIAYA];
                    }
                    $wajibbayar = $biaya * ( 100 - $diskonbeasiswa ) / 100;
                }
                $periode = "{$tahunawal}/".( $tahunawal + 1 )." ".$arraysemester[$semesterawal];
                $totalbayar = getbayarkomponen( "{$d['ID']}", "{$d['IDKOMPONEN']}", "{$d['JENIS']}", $tahunawal + 1, $semesterawal );
            }
        }
        else if ( $d[JENIS] == 6 )
        {
            unset( $arraydatacuti );
            $arraycuti = getarraysemestercuti( $idmahasiswa );
            if ( 0 < is_array( $arraycuti ) )
            {
                $ic = 0;
                foreach ( $arraycuti as $k => $v )
                {
                    ++$ic;
                    $q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$d['ID']}' AND IDKOMPONEN='{$d['IDKOMPONEN']}' AND TAHUN='".( $v[tahun] + 1 )."' AND\r\n                      SEMESTER='{$v['semester']}'\r\n                      ";
                    $hdiskon = mysqli_query($koneksi,$q);
                    if ( 0 < sqlnumrows( $hdiskon ) )
                    {
                        $ddiskon = sqlfetcharray( $hdiskon );
                        $diskonbeasiswa = $ddiskon[DISKON];
                    }
                    $periode_tmp = "{$v['tahun']}/".( $v[tahun] + 1 )." ".$arraysemester[$v[semester]];
                    $totalbayar_tmp = getbayarkomponen( "{$d['ID']}", "{$d['IDKOMPONEN']}", "{$d['JENIS']}", $v[tahun] + 1, $v[semester] );
                    if ( $ic == 1 )
                    {
                        $periode = $periode_tmp;
                        $totalbayar = $totalbayar_tmp;
                        $wajibbayar = $biaya * ( 100 - $diskonbeasiswa ) / 100;
                    }
                    else
                    {
                        $arraydatacuti[$k][periode] = $periode_tmp;
                        $arraydatacuti[$k][totalbayar] = $totalbayar_tmp;
                        $arraydatacuti[$k][wajibbayar] = $biaya * ( 100 - $diskonbeasiswa ) / 100;
                    }
                }
            }
            else
            {
                $wajibbayar = 0;
            }
        }
        $sisa = $wajibbayar - $totalbayar;
        $totalsisa += $sisa;
        $totalwajibbayar += $wajibbayar;
        $totaltotalbayar += $totalbayar;
        if ( $npm == "" )
        {
            if ( 0 < $sisa )
            {
                echo "\r\n    \t\t\t\t<tr align=center valign=top>\r\n    \t\t\t\t\t<td>{$nomer}</td>\r\n      \t\t\t\t\t<td align=left>{$npm}</td>\r\n     \t\t\t\t\t<td align=left nowrap>{$nama}</td>\r\n     \t\t\t\t\t<td align=left nowrap>{$namaprodi}</td>\r\n     \t\t\t\t\t<td align=center nowrap>{$angkatan}</td>\r\n     \t\t\t\t\t<td align=left>".$kelas."&nbsp;</td>\r\n     \t\t\t\t\t<td align=left nowrap>{$d['NAMAK']} </td> \r\n     \t\t\t\t\t<td align=left>{$periode}</td>  \r\n     \t\t\t\t\t<td align=right nowrap>".cetakuang( $wajibbayar )."</td>\r\n     \t\t\t\t\t<td align=right nowrap>".cetakuang( $totalbayar )." </td>\r\n     \t\t\t\t\t<td align=right nowrap>".cetakuang( $sisa )." </td>\r\n     \r\n    \t\t\t\t</tr>\r\n    \t\t\t";
                echo "\r\n           \t<tr align=center valign=top>\r\n    \t\t\t\t\t<td>{$nomer}</td>\r\n      \t\t\t\t\t<td align=left>{$npm}</td>\r\n     \t\t\t\t\t<td align=left nowrap>{$nama}</td>\r\n     \t\t\t\t\t<td align=left nowrap>{$namaprodi}</td>\r\n     \t\t\t\t\t<td align=center nowrap>{$angkatan}</td>\r\n     \t\t\t\t\t<td align=left>".$kelas."&nbsp;</td>\r\n       ";
            }
        }
        else if ( 0 < $sisa )
        {
            echo "\r\n\r\n     \t\t\t\t\t<td align=left nowrap>{$d['NAMAK']} </td> \r\n     \t\t\t\t\t<td align=left>{$periode}</td>  \r\n     \t\t\t\t\t<td align=right nowrap>".cetakuang( $wajibbayar )."</td>\r\n     \t\t\t\t\t<td align=right nowrap>".cetakuang( $totalbayar )." </td>\r\n     \t\t\t\t\t<td align=right nowrap>".cetakuang( $sisa )." </td>\r\n     \r\n    \t\t\t\t</tr>\r\n    \t\t\t";
        }
        else
        {
            echo "\r\n\r\n     \t\t\t\t\t<td align=left nowrap> </td> \r\n     \t\t\t\t\t<td align=left> </td>  \r\n     \t\t\t\t\t<td align=right nowrap> </td>\r\n     \t\t\t\t\t<td align=right nowrap> </td>\r\n     \t\t\t\t\t<td align=right nowrap> </td>\r\n     \r\n    \t\t\t\t</tr>\r\n    \t\t\t";
        }
        if ( $w[year] < $tahunakhir )
        {
            $tahunakhir = $w[year];
        }
        if ( $d[JENIS] == 2 )
        {
            $ii = $tahunawal + 1;
            while ( $ii <= $tahunakhir )
            {
                $q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$d['ID']}' AND IDKOMPONEN='{$d['IDKOMPONEN']}' AND TAHUN='".( $ii + 1 )."'  \r\n            ";
                $hdiskon = mysqli_query($koneksi,$q);
                if ( 0 < sqlnumrows( $hdiskon ) )
                {
                    $ddiskon = sqlfetcharray( $hdiskon );
                    $diskonbeasiswa = $ddiskon[DISKON];
                }
                $wajibbayar = $biaya * ( 100 - $diskonbeasiswa ) / 100;
                $totalbayar = getbayarkomponen( "{$d['ID']}", "{$d['IDKOMPONEN']}", "{$d['JENIS']}", $ii + 1, $semester = "" );
                $sisa = $wajibbayar - $totalbayar;
                $totalsisa += $sisa;
                $totalwajibbayar += $wajibbayar;
                $totaltotalbayar += $totalbayar;
                if ( 0 < $sisa )
                {
                    echo "\r\n      \t\t\t\t<tr align=center valign=top>\r\n      \t\t\t\t\t<td> </td>\r\n        \t\t\t\t\t<td align=left> </td>\r\n       \t\t\t\t\t<td align=left nowrap> </td>\r\n       \t\t\t\t\t<td align=left nowrap> </td>\r\n       \t\t\t\t\t<td align=center nowrap> </td>\r\n       \t\t\t\t\t<td align=left> </td>\r\n       \t\t\t\t\t<td align=left nowrap>{$d['NAMAK']} </td>  \r\n \r\n       \t\t\t\t\t<td  align=left>{$ii}/".( $ii + 1 )." </td>  \r\n       \t\t\t\t\t<td align=right nowrap>".cetakuang( $wajibbayar )."</td>\r\n       \t\t\t\t\t<td align=right nowrap>".cetakuang( $totalbayar )." </td>\r\n       \t\t\t\t\t<td align=right nowrap>".cetakuang( $sisa )." </td>\r\n       \r\n      \t\t\t\t</tr>\r\n      \t\t\t";
                }
                ++$ii;
            }
        }
        if ( $d[JENIS] == 3 )
        {
            if ( $semesterawal == 1 )
            {
                if ( iscuti( $idmahasiswa, $tahunawal."2" ) )
                {
                    $wajibbayar = 0;
                }
                else
                {
                    $q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$d['ID']}' AND IDKOMPONEN='{$d['IDKOMPONEN']}' AND TAHUN='".( $tahunawal + 1 )."'  AND\r\n            SEMESTER='2'\r\n            ";
                    $hdiskon = mysqli_query($koneksi,$q);
                    if ( 0 < sqlnumrows( $hdiskon ) )
                    {
                        $ddiskon = sqlfetcharray( $hdiskon );
                        $diskonbeasiswa = $ddiskon[DISKON];
                    }
                    $wajibbayar = $biaya * ( 100 - $diskonbeasiswa ) / 100;
                    if ( $d[IDKOMPONEN] == 99 )
                    {
                        $jumlahsks = getjumlahsks( $d[ID], $tahunawal + 1, 2 );
                        $jumlahskswajib = getjumlahskswajib( $d[ID], $tahunawal + 1, 2 );
                        $skslebih = 0;
                        if ( $jumlahskswajib < $jumlahsks )
                        {
                            $skslebih = $jumlahsks - $jumlahskswajib;
                        }
                        if ( $BIAYASKSKULIAH == 1 )
                        {
                            $biaya = $jumlahsks * $d[BIAYA];
                        }
                        else
                        {
                            $biaya = $skslebih * $d[BIAYA];
                        }
                        $wajibbayar = $biaya * ( 100 - $diskonbeasiswa ) / 100;
                    }
                    else if ( $d[IDKOMPONEN] == 98 )
                    {
                        $jumlahsks = getjumlahskssp( $d[ID], $tahunawal + 1, 2 );
                        $jumlahskswajib = 0;
                        $skslebih = 0;
                        if ( $jumlahskswajib < $jumlahsks )
                        {
                            $skslebih = $jumlahsks - $jumlahskswajib;
                        }
                        if ( $BIAYASKSKULIAH == 1 )
                        {
                            $biaya = $jumlahsks * $d[BIAYA];
                        }
                        else
                        {
                            $biaya = $skslebih * $d[BIAYA];
                        }
                        $wajibbayar = $biaya * ( 100 - $diskonbeasiswa ) / 100;
                    }
                }
                $totalbayar = getbayarkomponen( "{$d['ID']}", "{$d['IDKOMPONEN']}", "{$d['JENIS']}", $tahunawal + 1, 2 );
                $sisa = $wajibbayar - $totalbayar;
                $totalsisa += $sisa;
                $totalwajibbayar += $wajibbayar;
                $totaltotalbayar += $totalbayar;
                if ( 0 < $sisa )
                {
                    echo "\r\n            \t\t\t\t<tr align=center valign=top>\r\n            \t\t\t\t\t<td> </td>\r\n              \t\t\t\t\t<td align=left> </td>\r\n             \t\t\t\t\t<td align=left nowrap> </td>\r\n             \t\t\t\t\t<td align=left nowrap> </td>\r\n             \t\t\t\t\t<td align=center nowrap> </td>\r\n             \t\t\t\t\t<td align=left> </td>\r\n             \t\t\t\t\t<td align=left nowrap>{$d['NAMAK']} </td>  \r\n       \r\n             \t\t\t\t\t<td  align=left>{$tahunawal}/".( $tahunawal + 1 )."  ".$arraysemester[2]."</td>  \r\n             \t\t\t\t\t<td align=right nowrap>".cetakuang( $wajibbayar )."</td>\r\n             \t\t\t\t\t<td align=right nowrap>".cetakuang( $totalbayar )." </td>\r\n             \t\t\t\t\t<td align=right nowrap>".cetakuang( $sisa )." </td>\r\n             \r\n            \t\t\t\t</tr>\r\n            \t\t\t";
                }
            }
            $ii = $tahunawal + 1;
            while ( $ii <= $tahunakhir )
            {
                $sem = 1;
                while ( $sem <= 2 )
                {
                    $statuscuti = iscuti( $idmahasiswa, "{$ii}{$sem}" );
                    if ( $statuscuti == 1 )
                    {
                        $sisa = 0;
                    }
                    else
                    {
                        $q = "SELECT * FROM  diskonbeasiswa WHERE IDMAHASISWA='{$d['ID']}' AND IDKOMPONEN='{$d['IDKOMPONEN']}' AND TAHUN='".( $ii + 1 )."'  AND\r\n                SEMESTER='{$sem}'\r\n                ";
                        $hdiskon = mysqli_query($koneksi,$q);
                        if ( 0 < sqlnumrows( $hdiskon ) )
                        {
                            $ddiskon = sqlfetcharray( $hdiskon );
                            $diskonbeasiswa = $ddiskon[DISKON];
                        }
                        $wajibbayar = $biaya * ( 100 - $diskonbeasiswa ) / 100;
                        if ( $d[IDKOMPONEN] == 99 )
                        {
                            $jumlahsks = getjumlahsks( $d[ID], $ii + 1, $sem );
                            $jumlahskswajib = getjumlahskswajib( $d[ID], $ii + 1, $sem );
                            $skslebih = 0;
                            if ( $jumlahskswajib < $jumlahsks )
                            {
                                $skslebih = $jumlahsks - $jumlahskswajib;
                            }
                            if ( $BIAYASKSKULIAH == 1 )
                            {
                                $biaya = $jumlahsks * $d[BIAYA];
                            }
                            else
                            {
                                $biaya = $skslebih * $d[BIAYA];
                            }
                            $wajibbayar = $biaya * ( 100 - $diskonbeasiswa ) / 100;
                        }
                        else if ( $d[IDKOMPONEN] == 98 )
                        {
                            $jumlahsks = getjumlahskssp( $d[ID], $ii + 1, $sem );
                            $jumlahskswajib = 0;
                            $skslebih = 0;
                            if ( $jumlahskswajib < $jumlahsks )
                            {
                                $skslebih = $jumlahsks - $jumlahskswajib;
                            }
                            if ( $BIAYASKSKULIAH == 1 )
                            {
                                $biaya = $jumlahsks * $d[BIAYA];
                            }
                            else
                            {
                                $biaya = $skslebih * $d[BIAYA];
                            }
                            $wajibbayar = $biaya * ( 100 - $diskonbeasiswa ) / 100;
                        }
                        $totalbayar = getbayarkomponen( "{$d['ID']}", "{$d['IDKOMPONEN']}", "{$d['JENIS']}", $ii + 1, $sem );
                        $sisa = $wajibbayar - $totalbayar;
                        $totalsisa += $sisa;
                        $totalwajibbayar += $wajibbayar;
                        $totaltotalbayar += $totalbayar;
                    }
                    if ( 0 < $sisa )
                    {
                        echo "\r\n        \t\t\t\t<tr align=center valign=top>\r\n        \t\t\t\t\t<td> </td>\r\n          \t\t\t\t\t<td align=left> </td>\r\n         \t\t\t\t\t<td align=left nowrap> </td>\r\n         \t\t\t\t\t<td align=left nowrap> </td>\r\n         \t\t\t\t\t<td align=center nowrap> </td>\r\n         \t\t\t\t\t<td align=left>  </td>\r\n         \t\t\t\t\t<td align=left nowrap>{$d['NAMAK']} </td>  \r\n   \r\n         \t\t\t\t\t<td align=left>{$ii}/".( $ii + 1 )." ".$arraysemester[$sem]."</td>  \r\n         \t\t\t\t\t<td align=right nowrap>".cetakuang( $wajibbayar )."</td>\r\n         \t\t\t\t\t<td align=right nowrap>".cetakuang( $totalbayar )." </td>\r\n         \t\t\t\t\t<td align=right nowrap>".cetakuang( $sisa )." </td>\r\n         \r\n        \t\t\t\t</tr>\r\n        \t\t\t";
                    }
                    ++$sem;
                }
                ++$ii;
            }
        }
        if ( $d[JENIS] == 6 && is_array( $arraydatacuti ) )
        {
            foreach ( $arraydatacuti as $k => $v )
            {
                $totalbayar = $v[totalbayar];
                $wajibbayar = $v[wajibbayar];
                $sisa = $wajibbayar - $totalbayar;
                $totalsisa += $sisa;
                $totalwajibbayar += $wajibbayar;
                $totaltotalbayar += $totalbayar;
                if ( 0 < $sisa )
                {
                    echo "\r\n        \t\t\t\t<tr align=center valign=top>\r\n        \t\t\t\t\t<td> </td>\r\n          \t\t\t\t\t<td align=left> </td>\r\n         \t\t\t\t\t<td align=left nowrap> </td>\r\n         \t\t\t\t\t<td align=left nowrap> </td>\r\n         \t\t\t\t\t<td align=center nowrap> </td>\r\n         \t\t\t\t\t<td align=left> </td>\r\n         \t\t\t\t\t<td align=left nowrap>{$d['NAMAK']} </td>  \r\n   \r\n         \t\t\t\t\t<td align=left>{$v['periode']}</td>  \r\n         \t\t\t\t\t<td align=right nowrap>".cetakuang( $wajibbayar )."</td>\r\n         \t\t\t\t\t<td align=right nowrap>".cetakuang( $totalbayar )." </td>\r\n         \t\t\t\t\t<td align=right nowrap>".cetakuang( $sisa )." </td>\r\n         \r\n        \t\t\t\t</tr>\r\n        \t\t\t";
                }
            }
        }
        if ( $nimlama != $d[ID] )
        {
            ++$i;
            $nimlama = $d[ID];
        }
    }
    echo "\r\n        \t\t\t\t<tr align=center valign=top>\r\n        \t\t\t\t\t<td colspan=8> </td>\r\n          \t\t\t\t\t<td align=right nowrap><b>".cetakuang( $totalwajibbayar )."</td>\r\n         \t\t\t\t\t<td align=right nowrap><b>".cetakuang( $totaltotalbayar )." </td>\r\n         \t\t\t\t\t<td align=right nowrap><b>".cetakuang( $totalsisa )." </td>\r\n         \r\n        \t\t\t\t</tr>\r\n        \t\t\t";
    echo "\r\n\t\t\r\n\t\t\r\n\t\t</table>\r\n ";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Rekap Tunggakan  Pembayaran Keuangan Mahasiswa Tidak Ada";
    $aksi = "";
}
?>
