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
$arraysort[0] = "komponenpembayaran.ID";
$arraysort[1] = "komponenpembayaran.NAMA";
$href = "index.php?pilihan={$pilihan}&aksi=Tampilkan&";
if ( $idmahasiswa != "" )
{
    $qfield .= " AND IDMAHASISWA LIKE '%{$idmahasiswa}%'";
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
if ( $istglbayar == 1 )
{
    $qfield .= "\r\n \t\t\tAND \r\n \t\t\t(\r\n \t\t\t\tTANGGALBAYAR >= DATE_FORMAT('{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}','%Y-%m-%d')\r\n \t\t\t\tAND\r\n \t\t\t\tTANGGALBAYAR <= DATE_FORMAT('{$tglbayar2['thn']}-{$tglbayar2['bln']}-{$tglbayar2['tgl']}','%Y-%m-%d')\r\n \t\t\t)\r\n \t\t";
    $qjudul .= " Periode pembayaran antara  {$tglbayar['tgl']}-{$tglbayar['bln']}-{$tglbayar['thn']} s.d\r\n\t\t {$tglbayar2['tgl']}-{$tglbayar2['bln']}-{$tglbayar2['thn']} \r\n\t\t <br>";
    $qinput .= " \r\n\t\t\t<input type=hidden name=istglbayar value='{$istglbayar}'>\r\n\t\t\t<input type=hidden name=tglbayar[thn] value='{$tglbayar['thn']}'>\r\n\t\t\t<input type=hidden name=tglbayar[bln] value='{$tglbayar['bln']}'>\r\n\t\t\t<input type=hidden name=tglbayar[tgl] value='{$tglbayar['tgl']}'>\r\n\t\t\t<input type=hidden name=tglbayar2[thn] value='{$tglbayar2['thn']}'>\r\n\t\t\t<input type=hidden name=tglbayar2[bln] value='{$tglbayar2['bln']}'>\r\n\t\t\t<input type=hidden name=tglbayar2[tgl] value='{$tglbayar2['tgl']}'>\r\n\t\t";
    $href .= "tglbayar[tgl]={$tglbayar['tgl']}&tglbayar[bln]={$tglbayar['bln']}&tglbayar[thn]={$tglbayar['thn']}&\r\n\t\ttglbayar2[tgl]={$tglbayar2['tgl']}&tglbayar2[bln]={$tglbayar2['bln']}&tglbayar2[thn]={$tglbayar2['thn']}&istglbayar={$istglbayar}&";
}
if ( $istglentri == 1 )
{
    $qfield .= "\r\n \t\t\tAND \r\n \t\t\t(\r\n \t\t\t\tbayarkomponen.TANGGAL >= DATE_FORMAT('{$tglentri['thn']}-{$tglentri['bln']}-{$tglentri['tgl']}','%Y-%m-%d')\r\n \t\t\t\tAND\r\n \t\t\t\tbayarkomponen.TANGGAL <= DATE_FORMAT('{$tglentri2['thn']}-{$tglentri2['bln']}-{$tglentri2['tgl']}','%Y-%m-%d')\r\n \t\t\t)\r\n \t\t";
    $qjudul .= " Tanggal entri antara  {$tglentri['tgl']}-{$tglentri['bln']}-{$tglentri['thn']} s.d\r\n\t\t {$tglentri2['tgl']}-{$tglentri2['bln']}-{$tglentri2['thn']} \r\n\t\t <br>";
    $qinput .= " \r\n\t\t\t<input type=hidden name=tglentri[thn] value='{$tglentri['thn']}'>\r\n\t\t\t<input type=hidden name=tglentri[bln] value='{$tglentri['bln']}'>\r\n\t\t\t<input type=hidden name=tglentri[tgl] value='{$tglentri['tgl']}'>\r\n\t\t\t<input type=hidden name=tglentri2[thn] value='{$tglentri2['thn']}'>\r\n\t\t\t<input type=hidden name=tglentri2[bln] value='{$tglentri2['bln']}'>\r\n\t\t\t<input type=hidden name=tglentri2[tgl] value='{$tglentri2['tgl']}'>\r\n\t\t";
    $href .= "tglentri[tgl]={$tglentri['tgl']}&tglentri[bln]={$tglentri['bln']}&tglentri[thn]={$tglentri['thn']}&\r\n\t\ttglentri2[tgl]={$tglentri2['tgl']}&tglentri2[bln]={$tglentri2['bln']}&tglentri2[thn]={$tglentri2['thn']}&";
}
if ( $istahunajaran == 1 && $tahunajaran != "" )
{
    $qjudul .= " Tahun Akademik '".( $tahunajaran - 1 )."/{$tahunajaran}' <br>";
    $qinput .= " \r\n\t\t\t\t\t<input type=hidden name=istahunajaran value='{$istahunajaran}'>\r\n\t\t\t\t\t<input type=hidden name=tahunajaran value='{$tahunajaran}'>\r\n\t\t\t\t\t";
    $href .= "tahunajaran={$tahunajaran}&istahunajaran={$istahunajaran}&";
}
if ( $issemester == 1 )
{
    if ( $semesterbayar != "" )
    {
        $qjudul .= " Semester '".$arraysemester[$semesterbayar]."' <br>";
        $qinput .= " \r\n\t\t\t\t\t\t<input type=hidden name=semesterbayar value='{$semesterbayar}'>\r\n\t\t\t\t\t";
        $href .= "semesterbayar={$semesterbayar}&";
    }
    $qjudul .= " Tahun Akademik '".( $tahunajaran2 - 1 )."/{$tahunajaran2}' <br>";
    $qinput .= " \r\n\t\t\t<input type=hidden name=tahunajaran2 value='{$tahunajaran2}'>\r\n\t\t\t<input type=hidden name=issemester value='{$issemester}'>\r\n\t\t\t\r\n\t\t\t";
    $href .= "tahunajaran2={$tahunajaran2}&&issemester={$issemester}";
}
if ( $iscuti == 1 )
{
    if ( $semesterbayarc != "" )
    {
        $qjudul .= " Semester '".$arraysemester[$semesterbayarc]."' <br>";
        $qinput .= " \r\n\t\t\t\t\t\t<input type=hidden name=semesterbayarc value='{$semesterbayarc}'>\r\n\t\t\t\t\t";
        $href .= "semesterbayarc={$semesterbayarc}&";
    }
    $qjudul .= " Tahun Akademik '".( $tahunajaran2c - 1 )."/{$tahunajaran2c}' <br>";
    $qinput .= " \r\n\t\t\t<input type=hidden name=tahunajaran2c value='{$tahunajaran2c}'>\r\n\t\t\t<input type=hidden name=iscuti value='{$iscuti}'>\r\n\t\t\t\r\n\t\t\t";
    $href .= "tahunajaran2={$tahunajaran2}&&issemester={$issemester}";
}
if ( $isbulan == 1 )
{
    if ( $semesterbayar2 != "" )
    {
        $qjudul .= " Bulan '".$arraybulan[$semesterbayar2 - 1]."' <br>";
        $qinput .= " \r\n\t\t\t\t\t\t<input type=hidden name=semesterbayar2 value='{$semesterbayar2}'>\r\n\t\t\t\t\t";
        $href .= "semesterbayar2={$semesterbayar2}&";
    }
    $qjudul .= " Tahun Akademik  {$tahunajaran3} <br>";
    $qinput .= " \r\n\t\t\t<input type=hidden name=tahunajaran3 value='{$tahunajaran3}'>\r\n\t\t\t<input type=hidden name=isbulan value='{$isbulan}'>\r\n\t\t\t\r\n\t\t\t";
    $href .= "tahunajaran3={$tahunajaran3}&&isbulan={$isbulan}";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT * {$field99}\r\n\tFROM komponenpembayaran\r\n\t{$where99}\r\n\tORDER BY ".$arraysort[$sort]."";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    /*if ( $aksi != "cetak" )
    {
        #printjudulmenu( "Laporan Keuangan : Rekapitulasi Pembayaran" );
        printmesg( $qjudul );
        printmesg( $errmesg );
    }
    else
    {
        #printjudulmenucetak( "Laporan Keuangan : Rekapitulasi Pembayaran" );
        printmesgcetak( $qjudul );
    }*/
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
								printmesg("Laporan Keuangan : Rekapitulasi Pembayaran Umum");
    if ( $aksi != "cetak" )
    {
        printmesg( $qjudul );
		echo "					<div class=\"tools\">
										<form target=_blank action='cetaklaporan3.php' method=post>
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

        #echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetaklaporan3.php'>\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>\r\n  \t\t\t\t{$qinput}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    #echo "\r\n \t\t\t<table {$border} class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=0'>Kode</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=1'>Nama Komponen</td>\r\n \t\t\t\t<td>Jumlah</td>\r\n \t\t\t</tr>\r\n\t\t";
    echo "								<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=0'>Kode</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=1'>Nama Komponen</td>\r\n \t\t\t\t<td>Jumlah</td>\r\n \t\t\t</tr>\r\n\t\t";
	echo "											</thead>
													<tbody>";	
	$i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $qtahun = "";
        if ( $d[JENIS] == 2 )
        {
            if ( $istahunajaran == 1 )
            {
                $qtahun = " AND TAHUNAJARAN='{$tahunajaran}'";
            }
        }
        else if ( $d[JENIS] == 3 )
        {
            if ( $issemester == 1 )
            {
                if ( $semesterbayar != "" )
                {
                    $qtahun .= " AND SEMESTER='{$semesterbayar}'  ";
                }
                if ( $tahunajaran2 != "" )
                {
                    $qtahun .= " AND TAHUNAJARAN='{$tahunajaran2}'";
                }
            }
        }
        else if ( $d[JENIS] == 6 )
        {
            if ( $iscuti == 1 )
            {
                if ( $semesterbayarc != "" )
                {
                    $qtahun .= " AND SEMESTER='{$semesterbayarc}'  ";
                }
                if ( $tahunajaran2c != "" )
                {
                    $qtahun .= " AND TAHUNAJARAN='{$tahunajaran2c}'";
                }
            }
        }
        else if ( $d[JENIS] == 5 && $isbulan == 1 )
        {
            $qtahun = " AND SEMESTER='{$semesterbayar2}' AND TAHUNAJARAN='{$tahunajaran3}'";
        }
        $q = "SELECT SUM(JUMLAH) AS JUMLAH FROM bayarkomponen,mahasiswa\r\n\t\t\tWHERE bayarkomponen.IDMAHASISWA=mahasiswa.ID AND\r\n\t\t\tIDKOMPONEN='{$d['ID']}'\r\n\t\t\t{$qfield}\r\n\t\t\t{$qtahun}\r\n\t\t\t";
        $h2 = mysqli_query($koneksi,$q);
        $d2 = sqlfetcharray( $h2 );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi} valign=top>\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t\t<td align=left>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMAKOMPONEN']}</td>\r\n \t\t\t\t\t<td align=right>".cetakuang( $d2[JUMLAH] )."</td>\r\n \t\t\t\t\t";
        echo "\r\n \t\t\t\t\t\r\n  \t\t\t\t</tr>\r\n\t\t\t";
        $totalbayar += $d2[JUMLAH];
        ++$i;
    }
    echo "\r\n\t\t\t<tr>\r\n\t\t\t\t<td align=right colspan=3><b>Total</td>\r\n\t\t\t\t<td align=right><b>".cetakuang( $totalbayar )."</td>\r\n\t\t\t</tr>";
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
