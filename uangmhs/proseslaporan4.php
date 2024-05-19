<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
set_time_limit(0);
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
if ( $jeniskelas != "" )
{
    $qfield .= " AND mahasiswa.JENISKELAS = '{$jeniskelas}'";
    $qjudul .= " JenisKelas '".$arraykelasstei[$jeniskelas]."' <br>";
    $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
    $href .= "jeniskelas={$jeniskelas}&";
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
$q = "SELECT ID,NAMA,STATUS,TA FROM mahasiswa WHERE 1=1 {$qfield} ORDER BY ".$arraysort[$sort]."";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    /*if ( $aksi != "cetak" )
    {
        #printjudulmenu( "Rekapitulasi Pembayaran Mahasiswa" );
        printmesg( $qjudul );
        printmesg( $errmesg );
    }
    else
    {
        #printjudulmenucetak( "Rekapitulasi Pembayaran Mahasiswa" );
        printmesgcetak( $qjudul );
    }*/
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
								printmesg("Laporan Keuangan : Rekapitulasi Pembayaran Mahasiswa");
    if ( $aksi != "cetak" )
    {
        /*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Rekapitulasi Pembayaran Mahasiswa </span>
                            </div>
                            <div class=\"actions\">
                                <form target=_blank action='cetaklaporan4.php'>\r\n \t\t\t\t<input type=submit name=aksi2 class=\"btn blue\" value='Cetak'>\r\n  \t\t\t\t{$qinput}\r\n\t\t\t</form>
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
		printmesg( $qjudul );
		echo "					<div class=\"tools\">
										<form target=_blank action='cetaklaporan4.php' method=post>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak'>\r\n  \t\t\t\t{$qinput}\r\n\t\t\t
													</td>
												</tr>
											</table>
										</form>
									</div>{$tpage} {$tpage2}";

        #echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetaklaporan4.php'>\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>\r\n  \t\t\t\t{$qinput}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    #echo "\r\n \t\t\t<table {$border} class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=0'>NIM</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=1'>Nama Mahasiswa</td> \r\n  \t\t\t";
    echo "								<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=0'>NIM</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=1'>Nama Mahasiswa</td> \r\n  \t\t\t";
	foreach ( $arraykomponenpembayaran as $k => $v )
    {
        echo "\r\n          <td>Sisa<br>{$v}</td>\r\n          ";
    }
    echo "\r\n        \t\t\t<td>Total Sisa Rp.</td>\r\n   \t\t\t</tr>\r\n\t\t";
	echo "											</thead>
													<tbody>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $totalbiaya = 0;
        $sisa = 0;
        $totalsisa2 = 0;
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi} valign=top>\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t\t<td align=left>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']}</td> ";
        foreach ( $arraykomponenpembayaran2 as $k => $v )
        {
            $sisa = 0;
            $biaya = 0;
            $jml = 0;
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
            if ( $arrayjeniskomponenpembayaran[$k] == 0 )
            {
                $q = "SELECT BIAYA FROM biayakomponen WHERE \r\n\t\t\t\tIDKOMPONEN='{$k}' AND ANGKATAN='{$angkatan}' AND IDPRODI='{$idprodi}' AND GELOMBANG='{$gelombang}' {$qfieldjeniskelas}";
                $h2 = mysqli_query($koneksi,$q);
                $d2 = sqlfetcharray( $h2 );
                $biaya = $d2[BIAYA] + 0;
                $q = "SELECT DISKON FROM diskonbeasiswa WHERE \r\n\t\t\t\tIDKOMPONEN='{$k}' AND  IDMAHASISWA='{$d['ID']}'  ";
                $h2 = mysqli_query($koneksi,$q);
                if ( 0 < sqlnumrows( $h2 ) )
                {
                    $d2 = sqlfetcharray( $h2 );
                    $biaya = $biaya * ( 100 - $d2[DISKON] ) / 100;
                }
                $q = "SELECT SUM(JUMLAH+DISKON) AS JML FROM bayarkomponen WHERE\r\n\t\t\t\tIDMAHASISWA='{$d['ID']}' AND IDKOMPONEN='{$k}'";
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
                        $q = "SELECT BIAYA FROM biayakomponen WHERE \r\n\t\t\t\t\t\tIDKOMPONEN='{$k}' AND ANGKATAN='{$angkatan}' AND IDPRODI='{$idprodi}' AND GELOMBANG='{$gelombang}' {$qfieldjeniskelas} ";
                        $h2 = mysqli_query($koneksi,$q);
                        $d2 = sqlfetcharray( $h2 );
                        $biaya = $d2[BIAYA] + 0;
                        $q = "SELECT DISKON FROM diskonbeasiswa WHERE \r\n    \t\t\t\tIDKOMPONEN='{$k}' AND  IDMAHASISWA='{$d['ID']}'  ";
                        $h2 = mysqli_query($koneksi,$q);
                        if ( 0 < sqlnumrows( $h2 ) )
                        {
                            $d2 = sqlfetcharray( $h2 );
                            $biaya = $biaya * ( 100 - $d2[DISKON] ) / 100;
                        }
                        $q = "SELECT SUM(JUMLAH+DISKON) AS JML FROM bayarkomponen WHERE\r\n\t\t\t\t\t\tIDMAHASISWA='{$d['ID']}' AND IDKOMPONEN='{$k}'";
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
                                $q = "SELECT BIAYA FROM biayakomponen WHERE \r\n\t\t\t\t\t\tIDKOMPONEN='{$k}' AND ANGKATAN='{$angkatan}' AND IDPRODI='{$idprodi}' AND GELOMBANG='{$gelombang}' {$qfieldjeniskelas} ";
                                $h2 = mysqli_query($koneksi,$q);
                                $d2 = sqlfetcharray( $h2 );
                                $biaya = $d2[BIAYA] + 0;
                                $q = "SELECT DISKON FROM diskonbeasiswa WHERE \r\n      \t\t\t\tIDKOMPONEN='{$k}' AND  IDMAHASISWA='{$d['ID']}' AND TAHUN='{$ii}' ";
                                $h2 = mysqli_query($koneksi,$q);
                                if ( 0 < sqlnumrows( $h2 ) )
                                {
                                    $d2 = sqlfetcharray( $h2 );
                                    $biaya = $biaya * ( 100 - $d2[DISKON] ) / 100;
                                }
                                $q = "SELECT SUM(JUMLAH+DISKON) AS JML FROM bayarkomponen WHERE\r\n\t\t\t\t\t\tIDMAHASISWA='{$d['ID']}' AND IDKOMPONEN='{$k}' AND TAHUNAJARAN='{$ii}'";
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
                                $q = "SELECT IDMAKUL FROM pengambilanmk WHERE IDMAHASISWA='{$d['ID']}' AND TAHUN='{$ii}' AND\r\n\t\t\t\t\t\tSEMESTER='{$isem}' LIMIT 0,1";
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
                                    $q = "SELECT BIAYA AS TOTAL\r\n            \t\tFROM biayakomponen,mahasiswa\r\n            \t\tWHERE\r\n            \t\t  mahasiswa.IDPRODI=biayakomponen.IDPRODI AND\r\n            \t\t  mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND\r\n            \t\t  mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND\r\n              \t\t  mahasiswa.ID='{$d['ID']}' AND\r\n            \t\t  biayakomponen.IDKOMPONEN='99' AND\r\n                  biayakomponen.IDKOMPONEN='{$k}' {$qfieldjeniskelasm}\r\n            \t\t\t \r\n            \t\t";
                                    $ht = mysqli_query($koneksi,$q);
                                    $dt = sqlfetcharray( $ht );
                                    $biayakomponen = $dt[TOTAL] + 0;
                                    $biaya = $skslebih * $biayakomponen;
                                    $q = "SELECT DISKON FROM diskonbeasiswa WHERE \r\n      \t\t\t\tIDKOMPONEN='99' AND IDKOMPONEN='{$k}'  AND IDMAHASISWA='{$d['ID']}' AND TAHUN='{$ii}' AND SEMESTER='{$isem}' ";
                                    $h2 = mysqli_query($koneksi,$q);
                                    if ( 0 < sqlnumrows( $h2 ) )
                                    {
                                        $d2 = sqlfetcharray( $h2 );
                                        $biaya = $biaya * ( 100 - $d2[DISKON] ) / 100;
                                    }
                                    $jumlahsks = getjumlahskssp( $d[ID], $ii, $isem );
                                    $jumlahskswajib = 0;
                                    $skslebih = 0;
                                    if ( $jumlahskswajib < $jumlahsks )
                                    {
                                        $skslebih = $jumlahsks - $jumlahskswajib;
                                    }
                                    $q = "SELECT BIAYA AS TOTAL\r\n            \t\tFROM biayakomponen,mahasiswa\r\n            \t\tWHERE\r\n            \t\t  mahasiswa.IDPRODI=biayakomponen.IDPRODI AND\r\n            \t\t  mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND\r\n            \t\t  mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND\r\n              \t\t  mahasiswa.ID='{$d['ID']}' AND\r\n            \t\t  biayakomponen.IDKOMPONEN='98' AND \r\n                  biayakomponen.IDKOMPONEN='{$k}' {$qfieldjeniskelasm}\r\n            \t\t\t \r\n            \t\t";
                                    $ht = mysqli_query($koneksi,$q);
                                    $dt = sqlfetcharray( $ht );
                                    $biayakomponen = $dt[TOTAL] + 0;
                                    $q = "SELECT DISKON FROM diskonbeasiswa WHERE \r\n        \t\t\t\tIDKOMPONEN='{$k}' AND IDKOMPONEN='98' AND  IDMAHASISWA='{$d['ID']}' AND TAHUN='{$ii}' AND SEMESTER='{$isem}'";
                                    $h2 = mysqli_query($koneksi,$q);
                                    if ( 0 < sqlnumrows( $h2 ) )
                                    {
                                        $d2 = sqlfetcharray( $h2 );
                                        $biayakomponen = $biayakomponen * ( 100 - $d2[DISKON] ) / 100;
                                    }
                                    $biaya += $skslebih * $biayakomponen;
                                    $q = "SELECT BIAYA FROM biayakomponen WHERE \r\n\t\t\t\t\t\t\tIDKOMPONEN='{$k}' AND ANGKATAN='{$angkatan}' AND IDPRODI='{$idprodi}' AND  GELOMBANG='{$gelombang}' {$qfieldjeniskelas} AND IDKOMPONEN!='99' AND IDKOMPONEN!='98' ";
                                    $h2 = mysqli_query($koneksi,$q);
                                    $d2 = sqlfetcharray( $h2 );
                                    $biayakomponen = $d2[BIAYA];
                                    $q = "SELECT DISKON FROM diskonbeasiswa WHERE \r\n        \t\t\t\tIDKOMPONEN='{$k}'   AND  IDMAHASISWA='{$d['ID']}' AND TAHUN='{$ii}' AND SEMESTER='{$isem}'";
                                    $h2 = mysqli_query($koneksi,$q);
                                    if ( 0 < sqlnumrows( $h2 ) )
                                    {
                                        $d2 = sqlfetcharray( $h2 );
                                        $biayakomponen = $biayakomponen * ( 100 - $d2[DISKON] ) / 100;
                                    }
                                    $biaya += $biayakomponen + 0;
                                    $q = "SELECT SUM(JUMLAH+DISKON) AS JML FROM bayarkomponen WHERE\r\n\t\t\t\t\t\t\tIDMAHASISWA='{$d['ID']}' AND IDKOMPONEN='{$k}' AND TAHUNAJARAN='{$ii}' AND\r\n\t\t\t\t\t\t\tSEMESTER='{$isem}'  ";
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
                                    $q = "SELECT BIAYA FROM biayakomponen WHERE \r\n\t\t\t\t\t\t\tIDKOMPONEN='{$k}' AND ANGKATAN='{$angkatan}' AND IDPRODI='{$idprodi}' AND GELOMBANG='{$gelombang}' {$qfieldjeniskelas} ";
                                    $h2 = mysqli_query($koneksi,$q);
                                    $d2 = sqlfetcharray( $h2 );
                                    $biaya = $d2[BIAYA] + 0;
                                    $q = "SELECT DISKON FROM diskonbeasiswa WHERE \r\n        \t\t\t\tIDKOMPONEN='{$k}'   AND  IDMAHASISWA='{$d['ID']}' AND TAHUN='{$ii}' AND SEMESTER='{$isem}'";
                                    $h2 = mysqli_query($koneksi,$q);
                                    if ( 0 < sqlnumrows( $h2 ) )
                                    {
                                        $d2 = sqlfetcharray( $h2 );
                                        $biaya = $biaya * ( 100 - $d2[DISKON] ) / 100;
                                    }
                                    $q = "SELECT SUM(JUMLAH+DISKON) AS JML FROM bayarkomponen WHERE\r\n\t\t\t\t\t\t\tIDMAHASISWA='{$d['ID']}' AND IDKOMPONEN='{$k}' AND TAHUNAJARAN='{$ii}' AND\r\n\t\t\t\t\t\t\tSEMESTER='{$isem}'";
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
                        $q = "SELECT BIAYA FROM biayakomponen WHERE \r\n\t\t\t\tIDKOMPONEN='{$k}' AND ANGKATAN='{$angkatan}' AND IDPRODI='{$idprodi}' AND GELOMBANG='{$gelombang}' {$qfieldjeniskelas}";
                        $h2 = mysqli_query($koneksi,$q);
                        $d2 = sqlfetcharray( $h2 );
                        $biaya = $d2[BIAYA] + 0;
                        $q = "SELECT DISKON FROM diskonbeasiswa WHERE \r\n        \t\t\t\tIDKOMPONEN='{$k}'   AND  IDMAHASISWA='{$d['ID']}'  ";
                        $h2 = mysqli_query($koneksi,$q);
                        if ( 0 < sqlnumrows( $h2 ) )
                        {
                            $d2 = sqlfetcharray( $h2 );
                            $biaya = $biaya * ( 100 - $d2[DISKON] ) / 100;
                        }
                        $q = "SELECT SUM(JUMLAH+DISKON) AS JML FROM bayarkomponen WHERE\r\n\t\t\t\tIDMAHASISWA='{$d['ID']}' AND IDKOMPONEN='{$k}'";
                        $h2 = mysqli_query($koneksi,$q);
                        $d2 = sqlfetcharray( $h2 );
                        $jml = $d2[JML] + 0;
                        $sisa += $biaya - $jml;
                    }
                }
            }
            echo "\r\n \t \t\t\t\t\t\t<td align=right>".cetakuang( $sisa )."</td>";
            $totalsisa2 += $sisa;
            $totalsisa3 += $k;
        }
        if ( 0 < $totalsisa2 )
        {
            echo "\r\n \t \t\t\t\t\t\t<td align=right>".cetakuang( $totalsisa2 )."</td>";
        }
        else
        {
            echo "\r\n \t \t\t\t\t\t\t<td align=center>LUNAS</td>";
        }
        echo "\t\r\n    \t\t\t\t</tr>\r\n\t\t\t";
        $totalsisa += $totalsisa2;
        if ( 2 < $i )
        {
            exit( );
        }
        ++$i;
    }
    echo "\r\n\t\t\t<tr>\r\n\t\t\t\t<td align=right colspan=3><b>Total</td>\r\n\t\t\t\t";
    foreach ( $arraykomponenpembayaran as $k => $v )
    {
        echo "\r\n          <td align=right><b>".cetakuang( $totalsisa3[$k] )."</td>\r\n          ";
    }
    echo "\r\n \t \t\t\t\t\t\t<td align=right><b>".cetakuang( $totalsisa )."</td>\r\n \t\t\t</tr>";
	#echo "</table></div></div></div></div></div>";
	echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				</div>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Komponen Pembayaran Tidak Ada";
    $aksi = "";
}
?>
