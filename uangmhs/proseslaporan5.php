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
$href = "index.php?pilihan={$pilihan}&aksi=Tampilkan&";
$qinput = "";
if ( is_array( $jeniskomponen ) )
{
    $qkomponen = " AND (  ";
    $qjudul = "Komponen pembayaran : <br>";
    foreach ( $jeniskomponen as $k => $v )
    {
        $qinput .= "<input type=hidden name='jeniskomponen[{$k}]' value=1>";
        $qkomponen .= " IDKOMPONEN='{$k}' OR";
        $qjudul .= " - {$arraykomponenpembayaran[$k]}<br>";
    }
    $qkomponen .= ")";
    $qkomponen = str_replace( "OR)", ")", $qkomponen );
}
if ( $carabayar != "" )
{
    $qfield .= " AND CARABAYAR = '{$carabayar}'";
    $qjudul .= " Cara Bayar : ".$arraycarabayar[$carabayar]." <br>";
    $qinput .= " <input type=hidden name=carabayar value='{$carabayar}'>";
    $href .= "carabayar={$carabayar}&";
}
$qinput .= " <input type=hidden name=jenistanggal value='{$jenistanggal}'>";
$href .= "jenistanggal={$jenistanggal}&";
if ( $jenistanggal == "bayar" )
{
    $ftanggal = "TANGGALBAYAR";
    $qjudul .= " Jenis Tanggal : Tanggal Bayar<br>";
}
else
{
    $ftanggal = "TANGGAL";
    $qjudul .= " Jenis Tanggal : Tanggal Entri<br>";
}
$qjudul .= "Antara tanggal {$tgl1['tgl']} ".$arraybulan[$tgl1[bln] - 1]." {$tgl1['thn']} s.d \r\n {$tgl2['tgl']} ".$arraybulan[$tgl2[bln] - 1]." {$tgl2['thn']}";
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
								printmesg("Laporan Keuangan : Rekapitulasi Pembayaran Harian");
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
                                <form target=_blank action='cetaklaporan5.php'>\r\n \t\t\t\t<input type=submit name=aksi2 class=\"btn green\" value='Cetak'>\r\n \t\t\t\t<input type=hidden name='tgl1[tgl]' value='{$tgl1['tgl']}'>\r\n  \t\t\t<input type=hidden name='tgl1[bln]' value='{$tgl1['bln']}'>\r\n  \t\t\t<input type=hidden name='tgl1[thn]' value='{$tgl1['thn']}'>\r\n  \t\t\t<input type=hidden name='tgl2[tgl]' value='{$tgl2['tgl']}'>\r\n  \t\t\t<input type=hidden name='tgl2[bln]' value='{$tgl2['bln']}'>\r\n  \t\t\t<input type=hidden name='tgl2[thn]' value='{$tgl2['thn']}'>\r\n  \t\t\t\t{$qinput}\r\n\t\t\t</form>
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
		printmesg( $qjudul );
		echo "					<div class=\"tools\">
										<form target=_blank action='cetaklaporan5.php' method=post>
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

    #echo "\r\n\t\t\t\t<table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetaklaporan5.php'>\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>\r\n \t\t\t\t<input type=hidden name='tgl1[tgl]' value='{$tgl1['tgl']}'>\r\n  \t\t\t<input type=hidden name='tgl1[bln]' value='{$tgl1['bln']}'>\r\n  \t\t\t<input type=hidden name='tgl1[thn]' value='{$tgl1['thn']}'>\r\n  \t\t\t<input type=hidden name='tgl2[tgl]' value='{$tgl2['tgl']}'>\r\n  \t\t\t<input type=hidden name='tgl2[bln]' value='{$tgl2['bln']}'>\r\n  \t\t\t<input type=hidden name='tgl2[thn]' value='{$tgl2['thn']}'>\r\n  \t\t\t\t{$qinput}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
}
$query = "SELECT (1+TO_DAYS('{$tgl2['thn']}-{$tgl2['bln']}-{$tgl2['tgl']}')-TO_DAYS('{$tgl1['thn']}-{$tgl1['bln']}-{$tgl1['tgl']}')) AS JML";
$hasil =mysqli_query($koneksi,$query);
$dt = sqlfetcharray( $hasil );
$jumlahhari = $dt[JML];
settype( $jumlahhari, "integer" );

#echo "\r\n \t\t\t<table {$border} class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t \r\n \t\t\t\t<td>Tanggal</td>\r\n\t\t\t\t<td>Jumlah Rp.</td> \r\n\t\t\t\t<td>Diskon Rp.</td> \r\n\t\t\t\t<td>Total Rp.</td> \r\n   \t\t\t</tr>\r\n\t\t";
echo "								<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t \r\n \t\t\t\t<td>Tanggal</td>\r\n\t\t\t\t<td>Jumlah Rp.</td> \r\n\t\t\t\t<td>Diskon Rp.</td> \r\n\t\t\t\t<td>Total Rp.</td> \r\n   \t\t\t</tr>\r\n\t\t";
echo "												</thead>
													<tbody>";
$i = 1;
$j = 0;
while ( $j < $jumlahhari )
{
    $kelas = kelas( $j );
    $tgl = Mktime( 0, 0, 0, $tgl1[bln], $tgl1[tgl] + $j, $tgl1[thn] );
    $strtgl = date( "d-m-Y", $tgl );
    $strtglq = date( "Y-m-d", $tgl );
    $totalbiaya = 0;
    $sisa = 0;
    $totalsisa2 = 0;
    $q = "SELECT \r\n     SUM(JUMLAH) AS JUMLAH,\r\n     SUM(DISKON) AS DISKON,\r\n     SUM(JUMLAH+DISKON) AS TOTAL \r\n     FROM bayarkomponen WHERE {$ftanggal}='{$strtglq}'\r\n     {$qkomponen}\r\n     {$qfield}";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $hasil = $d[TOTAL];
    echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi} valign=top>\r\n   \t\t\t\t\t<td align=left>{$strtgl}</td>\r\n  \t \t\t\t\t\t\t<td align=right>".cetakuang( $d[JUMLAH] )."</td> \r\n  \t \t\t\t\t\t\t<td align=right>".cetakuang( $d[DISKON] )."</td> \r\n  \t \t\t\t\t\t\t<td align=right>".cetakuang( $hasil )."</td> \r\n    \t\t\t\t</tr>\r\n\t\t\t";
    $total += $hasil;
    $jumlah += $d[JUMLAH];
    $diskon += $d[DISKON];
    ++$i;
    ++$j;
}
echo "	<tr><td align=right  ><b>Total</td>\r\n\t \t\t\t<td align=right><b>".cetakuang( $jumlah )."</td>\r\n\t \t\t\t<td align=right><b>".cetakuang( $diskon )."</td>\r\n\t \t\t\t<td align=right><b>".cetakuang( $total )."</td>\r\n \t\t\t</tr>";
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
?>
