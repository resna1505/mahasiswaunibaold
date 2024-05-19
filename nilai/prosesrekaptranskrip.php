<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\n.dataganjilcetak {\r\n\tborder-top:1px solid black;\r\n\tborder-left:1px solid black;\r\n\tfont-family:\"Trebuchet MS\", Arial, Helvetica, sans-serif;\r\n\tfont-size:13px;\r\n\t}\r\n\t\r\n.dataganjilcetak td {\r\n\tborder-right:1px solid black;\r\n\tborder-bottom:1px solid black;\r\n\tpadding:5px;\r\n\t}\r\n\t\r\n.datagenapcetak td {\r\n\tborder-right:1px solid black;\r\n\tborder-bottom:1px solid black;\r\n\tpadding:5px";
echo ";\r\n\t}\r\n\r\n</style>\r\n\r\n\r\n";
unset( $arraysort );
$arraysort[0] = "mahasiswa.ID";
$arraysort[1] = "mahasiswa.NAMA";
$arraysort[2] = "mahasiswa.SKS";
$arraysort[3] = "mahasiswa.BOBOT/mahasiswa.SKS";
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
    if ( $arraysort[$sort] == "" )
    {
        $sort = 0;
    }
    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $q = "SELECT COUNT(*) AS JML FROM mahasiswa,prodi \r\n\tWHERE 1=1 {$qprodidep5} AND\r\n\tmahasiswa.IDPRODI=prodi.ID\r\n\t{$qfield}  \r\n \r\n\t";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $total = $d[JML];
    $first = 0;
    $maxdata = $dataperhalaman;
    include( "../paginating.php" );
    $q = "SELECT mahasiswa.ID,mahasiswa.NAMA,prodi.SKSMIN ,prodi.JENIS,  trakm.THSMSTRAKM ,SKSTTTRAKM,NLIPKTRAKM\r\n\tFROM prodi , mahasiswa, trakm  \r\n  \r\n  JOIN \r\n  \r\n  (\r\n  SELECT NIMHSTRAKM,MAX(THSMSTRAKM) AS THSMSTRAKM  FROM trakm\r\n  GROUP BY NIMHSTRAKM\r\n  ) trakm2 \r\n  \r\n  ON\r\n\ttrakm.NIMHSTRAKM=trakm2.NIMHSTRAKM  AND trakm.THSMSTRAKM=trakm2.THSMSTRAKM\r\n\r\n\r\n\tWHERE \r\n  \r\n  trakm.NIMHSTRAKM=mahasiswa.ID \r\n  {$qprodidep5} AND\r\n\tmahasiswa.IDPRODI=prodi.ID\r\n\t{$qfield}\r\n \r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
    $q = "SELECT mahasiswa.ID,mahasiswa.NAMA,prodi.SKSMIN ,prodi.JENIS,  \r\n   \r\n   MAX(THSMSTRAKM) AS THSMSTRAKM\r\n   \r\n   \r\n\tFROM prodi , mahasiswa, trakm  \r\n \r\n\tWHERE \r\n  \r\n  trakm.NIMHSTRAKM=mahasiswa.ID \r\n  {$qprodidep5} AND\r\n\tmahasiswa.IDPRODI=prodi.ID\r\n\t{$qfield}\r\n \r\n GROUP BY NIMHSTRAKM\r\n \r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
    $h = mysqli_query($koneksi,$q);
    mysqli_error($koneksi);
    if ( 0 < sqlnumrows( $h ) )
    {
        if ( $aksi != "cetak" )
        {
            #printjudulmenu( "<center>Laporan IPK" );
            #printmesg( $qjudul );
			echo "	<div class=\"page-content\">
					<div class=\"container-fluid\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<!-- BEGIN SAMPLE FORM PORTLET-->
								";	
										
			echo "						<div class='portlet-title'>";
											printmesg("Laporan IPK");
			echo "						</div>";
									printmesg( $qjudul );
										printmesg( $errmesg );
			echo "					<form target=_blank action='cetakrekaptranskrip.php'>\r\n \t\t\t\t<input type=submit align='center' name=aksi class=\"btn btn-brand\" value='Cetak'>\r\n   \t\t\t\t".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."\r\n\t\t\t".createinputhidden( "kopsurat", "{$kopsurat}", "" )."\r\n\t\t\t\t{$qinput}\r\n\t\t\t\t{$input}\r\n\t\t\t</form>
									<br>
									<div class=\"m-portlet\">
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">";
												
        }
        else
        {
            $tmpkop = "";
            if ( $kopsurat == 1 )
            {
                include( "proseskop.php" );
            }
            echo $tmpcetakawal .= "<div style='page-break-after:always'>\r\n        ".$tmpkop;
            printjudulmenucetak( "Laporan IPK" );
            printmesgcetak( $qjudul );
        }
        #if ( $aksi != "cetak" )
        #{
            #echo "{$tpage} {$tpage2}";
            #echo "\r\n\t\t\t<center>\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakrekaptranskrip.php'>\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n   \t\t\t\t".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."\r\n\t\t\t".createinputhidden( "kopsurat", "{$kopsurat}", "" )."\r\n\t\t\t\t{$qinput}\r\n\t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
        #}
		echo "{$tpage} {$tpage2}";
		echo "									<table class=\"table table-bordered table-hover\">
													<thead>
														<tr align=center class=juduldata{$cetak} >\r\n\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>NIM</td>\r\n\t\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Nama</td>\r\n\t\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>SKS</td>\r\n\t\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>IPK</td>\r\n\t\t\t\t</tr>
													</thead>
													<tbody>";
        #echo "\r\n\t\t\r\n\t\t\t<table {$border}  width=600>\r\n\t\t\t\t<tr align=center class=juduldata{$cetak} >\r\n\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>NIM</td>\r\n\t\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Nama</td>\r\n\t\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>SKS</td>\r\n\t\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>IPK</td>\r\n\t\t\t\t</tr>\r\n\t\t";
        $i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $q = "SELECT  SKSTTTRAKM,NLIPKTRAKM FROM trakm WHERE NIMHSTRAKM='{$d['ID']}' AND THSMSTRAKM='{$d['THSMSTRAKM']}'";
            $h2 = mysqli_query($koneksi,$q);
            $d2 = sqlfetcharray( $h2 );
            $d[SKSTTTRAKM] = $d2[SKSTTTRAKM];
            $d[NLIPKTRAKM] = $d2[NLIPKTRAKM];
            echo "\r\n\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t\t\t\t\t<td align=center>{$i}&nbsp; </td>\r\n\t\t\t\t\t\t<td align=center>{$d['ID']}&nbsp; {$d['THSMSTRAKM']}</td>\r\n\t\t\t\t\t\t<td>{$d['NAMA']}&nbsp;</td>\r\n\t\t\t\t\t\t<td align=center> ".number_format_sikad( $d[SKSTTTRAKM], 2, ".", "," )."&nbsp;</td>\r\n\t\t\t\t\t\t<td align=center>".number_format_sikad( $d[NLIPKTRAKM], 2, ".", "," )."&nbsp; </td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t";
            $ipks += $d[NLIPKTRAKM];
            $totalssemua += $d[BOBOT];
            $bobotssemua += $d[SKSTTTRAKM];
            $ipk = 0;
            $bobotsemua = 0;
            $totalsemua = 0;
            ++$i;
        }
        echo "\r\n\t\t\t\t\t<tr {$kelas}{$cetak}>\r\n\t\t\t\t\t\t<td align=right colspan=3>Total</td>\r\n\t \t\t\t\t\t<td align=center> ".number_format_sikad( $bobotssemua, 2, ".", "," )."</td>\r\n\t\t\t\t\t\t<td align=center>".number_format_sikad( $ipks, 2, ".", "," )."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr {$kelas}{$cetak}>\r\n\t\t\t\t\t\t<td align=right colspan=3>Rata-rata</td>\r\n \t\t\t\t\t\t<td align=center> ".number_format_sikad( $bobotssemua / ( $i - 1 ), 2, ".", "," )."</td>\r\n\t\t\t\t\t\t<td align=center>".number_format_sikad( $ipks / ( $i - 1 ), 2, ".", "," )."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t";
        echo "</tbody></table></div></div></div></div></div></div></div>";
        include( "footertranskrip2.php" );
    }
    else
    {
        $errmesg = "Data mahasiswa tidak ada";
        $aksi = "";
    }
}
?>
