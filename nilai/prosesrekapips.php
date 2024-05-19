<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\n* {\r\n\tmargin:0px;\r\n\tpadding:0px;\r\n\t}\r\n\r\n.borderline {\r\n\tborder-bottom:1px solid black;\r\n\tborder-left:1px solid black;\r\n\twidth:600px;\r\n\t}\r\n\t\r\n.borderline td {\r\n\tborder-right:1px solid black;\r\n\tborder-top:1px solid black;\r\n\tpadding:5px;\r\n\t}\r\n\r\n</style>\r\n\r\n";
unset( $arraysort );
$arraysort[0] = "mahasiswa.ID";
$arraysort[1] = "mahasiswa.NAMA";
$arraysort[2] = "trakm.SKSTTTRAKM";
$arraysort[3] = "trakm.NLIPSTRAKM DESC";
$vld[] = cekvaliditasthnajaran( "Tahun/Semester", $tahun, $semester );
$vld[] = cekvaliditaskodeprodi( "Jurusan/Program Studi", $idprodi );
$vld[] = cekvaliditaskode( "Dosen Wali", $iddosen );
$vld[] = cekvaliditastahun( "Angkatan", $angkatan );
$vld[] = cekvaliditaskode( "NIM", $id );
$vld[] = cekvaliditasnama( "Nama", $nama );
$vld[] = cekvaliditaskode( "Status", $status );
$vld[] = cekvaliditastanggal( "Tanggal Laporan", $tgllap['tgl'], $tgllap['bln'], $tgllap['thn'] );
$vld = array_filter( $vld, "filter_not_empty" );
if ( isset( $vld ) && 0 < count( $vld ) )
{
    $errmesg = val_err_mesg( $vld, 2, CARI_DATA );
    $aksi = "";
}
else
{
    $href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
    $href .= "tgllap[tgl]={$tgllap['tgl']}&tgllap[bln]={$tgllap['bln']}&tgllap[thn]={$tgllap['thn']}&";
    if ( $idprodi != "" )
    {
        $qfield .= " AND IDPRODI='{$idprodi}'";
        $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
        $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
        $href .= "idprodi={$idprodi}&";
    }
    if ( $iddosen != "" )
    {
        $qfield .= " AND IDDOSEN='{$iddosen}'";
        $qjudul .= " Dosen Wali '".$arraydosen[$iddosen]."' <br>";
        $qinput .= " <input type=hidden name=iddosen value='{$iddosen}'>";
        $href .= "iddosen={$iddosen}&";
    }
    if ( $angkatan != "" )
    {
        $qfield .= " AND ANGKATAN='{$angkatan}'";
        $qjudul .= " Angkatan '{$angkatan}' <br>";
        $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
        $href .= "angkatan={$angkatan}&";
    }
    if ( $id != "" )
    {
        $qfield .= " AND mahasiswa.ID LIKE '%{$id}%'";
        $qjudul .= " NIM = '{$id}' <br>";
        $qinput .= " <input type=hidden name=id value='{$id}'>";
        $href .= "id={$id}&";
    }
    if ( $nama != "" )
    {
        $qfield .= " AND mahasiswa.NAMA LIKE '%{$nama}%'";
        $qjudul .= " Nama mengandung kata '{$nama}' <br>";
        $qinput .= " <input type=hidden name=nama value='{$nama}'>";
        $href .= "nama={$nama}&";
    }
    if ( $status != "" )
    {
        $qfield .= " AND STATUS='{$status}'";
        $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
        $qinput .= " <input type=hidden name=status value='{$status}'>";
        $href .= "status={$status}&";
    }
    $qjudul .= " Tahun/Semester : ".( $tahun - 1 )."/{$tahun} ".$arraysemester[$semester]." <br>";
    if ( $arraysort[$sort] == "" )
    {
        $sort = 0;
    }
    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $href .= "tahun={$tahun}&semester={$semester}&";
    $tahundikti = $tahun - 1;
    $q = "SELECT mahasiswa.ID,mahasiswa.NAMA,SKSEMTRAKM  AS SKS,NLIPSTRAKM  AS IPK\r\n\tFROM mahasiswa,prodi ,trakm\r\n\tWHERE 1=1 {$qprodidep5} AND\r\n\tmahasiswa.IDPRODI=prodi.ID \r\n  AND mahasiswa.ID=trakm.NIMHSTRAKM \r\n  AND trakm.THSMSTRAKM ='{$tahundikti}{$semester}' \r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
    $h = mysqli_query($koneksi,$q);
    mysqli_error($koneksi);
    if ( 0 < sqlnumrows( $h ) )
    {
        if ( $aksi != "cetak" )
        {
            #printjudulmenu( "<center>Laporan IPS" );
            #printmesg( $qjudul );
			echo "	<div class=\"page-content\">
					<div class=\"container-fluid\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<!-- BEGIN SAMPLE FORM PORTLET-->
								";	
										
			echo "						<div class='portlet-title'>";
											printmesg("Laporan IPS");
			echo "						</div>";
										printmesg( $qjudul );
										printmesg( $errmesg );
        }
        else
        {
            $tmpkop = "";
            if ( $kopsurat == 1 )
            {
                include( "proseskop.php" );
            }
            echo $tmpcetakawal .= "<div style='page-break-after:always'>\r\n        ".$tmpkop;
            printjudulmenucetak( "Laporan IPS" );
            printmesgcetak( $qjudul );
        }
        if ( $aksi != "cetak" )
        {
            #echo "{$tpage} {$tpage2}";
            #echo "\r\n\t\t\t<center>\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakrekapips.php'>\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n   \t\t\t\t".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."\r\n\t\t\t".createinputhidden( "kopsurat", "{$kopsurat}", "" )."\r\n\t\t\t\t{$qinput}\r\n\t\t\t\t<input type=hidden name='tahun' value='{$tahun}'>\r\n\t\t\t\t<input type=hidden name='semester' value='{$semester}'>\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
			#echo "	<form target=_blank action='cetakrekapipk.php'>\r\n \t\t\t\t<input type=submit name=aksi class=\"btn btn-brand\" value='Cetak'>\r\n   \t\t\t\t".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."\r\n\t\t\t".createinputhidden( "kopsurat", "{$kopsurat}", "" )."\r\n\t\t\t\t{$qinput}\r\n\t\t\t\t<input type=hidden name='tahun' value='{$tahun}'>\r\n\t\t\t\t<input type=hidden name='semester' value='{$semester}'></form>";
			echo "	<form target=_blank action='cetakrekapips.php'>\r\n \t\t\t\t<input type=submit name=aksi class=\"btn btn-brand\" value='Cetak'>\r\n   \t\t\t\t".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."\r\n\t\t\t".createinputhidden( "kopsurat", "{$kopsurat}", "" )."\r\n\t\t\t\t{$qinput}\r\n\t\t\t\t<input type=hidden name='tahun' value='{$tahun}'>\r\n\t\t\t\t<input type=hidden name='semester' value='{$semester}'></form>";
			
		}
        #echo "\r\n\t\t\r\n\t\t\t<table class=borderline cellpadding=0 cellspacing=0>\r\n\t\t\t\t<tr align=center class=juduldata{$cetak} >\r\n\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>NIM</td>\r\n\t\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Nama</td>\r\n\t\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>SKS</td>\r\n\t\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3 DESC'>IPS</td>\r\n\t\t\t\t</tr>\r\n\t\t";
        echo "						<br>
									<div class=\"m-portlet\">
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">";
		echo "{$tpage} {$tpage2}";
		echo "									<table class=\"table table-bordered table-hover\">
													<thead>
														<tr align=center class=juduldata{$cetak} >\r\n\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>NIM</td>\r\n\t\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Nama</td>\r\n\t\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>SKS</td>\r\n\t\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3 DESC'>IPS</td>\r\n\t\t\t\t</tr>\r\n\t\t
													</thead>
													<tbody>";
		$i = 1;
        $ipkmin = 5;
        $ipkmax = 0 - 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $ipk = @$d[IPK];
            echo "\r\n\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['ID']}</td>\r\n\t\t\t\t\t\t<td>{$d['NAMA']}</td>\r\n\t\t\t\t\t\t<td align=center> ".number_format_sikad( $d[SKS], 2, ".", "," )."</td>\r\n\t\t\t\t\t\t<td align=center>".number_format_sikad( $ipk, 2, ".", "," )."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t";
            $ipks += $ipk;
            $totalssemua += $d[BOBOT];
            $bobotssemua += $d[SKS];
            $bobotsemua = 0;
            $totalsemua = 0;
            if ( $ipkmax <= $ipk )
            {
                if ( $ipkmax < $ipk )
                {
                    unset( $nimipkmax );
                    unset( $namaipkmax );
                    $nimipkmax["{$d['ID']}"] = $ipkmax;
                    $namaipkmax["{$d['ID']}"] = $d[NAMA];
                }
                else
                {
                    $nimipkmax["{$d['ID']}"] = $ipkmax;
                    $namaipkmax["{$d['ID']}"] = $d[NAMA];
                }
                $ipkmax = $ipk;
            }
            if ( $ipk <= $ipkmin )
            {
                if ( $ipk < $ipkmin )
                {
                    unset( $nimipkmin );
                    unset( $namaipkmin );
                    $nimipkmin["{$d['ID']}"] = $ipkmin;
                    $namaipkmin["{$d['ID']}"] = $d[NAMA];
                }
                else
                {
                    $nimipkmin["{$d['ID']}"] = $ipkmin;
                    $namaipkmin["{$d['ID']}"] = $d[NAMA];
                }
                $ipkmin = $ipk;
            }
            $ipk = 0;
            ++$i;
        }
        echo "\r\n\t\t\t\t\t<tr {$kelas}{$cetak}>\r\n\t\t\t\t\t\t<td align=right colspan=3>Total</td>\r\n\t \t\t\t\t\t<td align=center> ".number_format_sikad( $bobotssemua, 2, ".", "," )."</td>\r\n\t\t\t\t\t\t<td align=center>".number_format_sikad( $ipks, 2, ".", "," )."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr {$kelas}{$cetak}>\r\n\t\t\t\t\t\t<td align=right colspan=3>Rata-rata</td>\r\n \t\t\t\t\t\t<td align=center> ".number_format_sikad( $bobotssemua / ( $i - 1 ), 2, ".", "," )."</td>\r\n\t\t\t\t\t\t<td align=center>".number_format_sikad( $ipks / ( $i - 1 ), 2, ".", "," )."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr {$kelas}{$cetak}>\r\n\t\t\t\t\t\t<td align=right colspan=3>IPS Tertinggi</td>\r\n \t\t\t\t\t\t<td align=center>&nbsp;</td>\r\n\t\t\t\t\t\t<td align=center> \r\n            ".number_format_sikad( $ipkmax, 2, ".", "," )."\r\n             </td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr {$kelas}{$cetak}>\r\n\t\t\t\t\t\t<td align=right colspan=3>NIM IPS Tertinggi</td>\r\n \t\t\t\t\t\t\r\n\t\t\t\t\t\t<td align=left> \r\n            ";
        foreach ( $nimipkmax as $k => $v )
        {
            echo "<b>{$k}  / ".$namaipkmax[$k]."<br>";
        }
        echo "\r\n             </td>\r\n\t\t\t \t<td>&nbsp;</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr {$kelas}{$cetak}>\r\n\t\t\t\t\t\t<td align=right colspan=3>IPS Terendah</td>\r\n \t\t\t\t\t\t<td align=center>&nbsp;</td>\r\n\t\t\t\t\t\t<td align=center>".number_format_sikad( $ipkmin, 2, ".", "," )."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr {$kelas}{$cetak}>\r\n\t\t\t\t\t\t<td align=right colspan=3>NIM IPS Terendah</td>\r\n \t\t\t\t\t\t\r\n\t\t\t\t\t\t<td colspan=2 align=left> \r\n            ";
        foreach ( $nimipkmin as $k => $v )
        {
            echo "<b>{$k}  / ".$namaipkmin[$k]."<br>";
        }
        echo "\r\n             </td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t";
        #echo "\r\n \t\t</table>";
		echo "</tbody></table></div></div></div>";
		echo "</div></div></div></div>";
    }
    else
    {
        $errmesg = "Data mahasiswa tidak ada";
        $aksi = "";
    }
}
?>
