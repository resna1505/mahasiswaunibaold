<?php
ob_start();
periksaroot();
#$stylekhs .= "<style type=\"text/css\">\r\n\t.loseborder td{border:none;}\r\n</style>\r\n";
$vld[] = cekvaliditaskodeprodi( "Jurusan/Program Studi", $idprodi );
$vld[] = cekvaliditaskode( "Dosen Wali", $iddosen );
$vld[] = cekvaliditastahun( "Angkatan", $angkatan );
$vld[] = cekvaliditaskode( "NIM", $id );
$vld[] = cekvaliditasnama( "Nama", $nama );
$vld[] = cekvaliditaskode( "Status", $status );
$vld[] = cekvaliditasthnajaran( "Tahun/Semester", $tahun, $semester );
$vld[] = cekvaliditaskode( "Nilai M-K yang diambil", $nilaidiambil, 1 );
$vld[] = cekvaliditaskode( "Perlakuan terhadap nilai kosong", $nilaikosong, 1 );
$vld[] = cekvaliditaskode( "Penempatan Semester Mata Kuliah", $penempatansemester, 2 );
$vld[] = cekvaliditastanggal( "Tanggal Laporan", $tgllap['tgl'], $tgllap['bln'], $tgllap['thn'] );
$vld[] = cekvaliditasinteger( "Data perhalaman", $dataperhalaman, 4 );
$vld = array_filter( $vld, "filter_not_empty" );
if ( isset( $vld ) && 0 < count( $vld ) )
{
    $errmesg = val_err_mesg( $vld, 2, CARI_DATA );
    $aksi = "";
}
else
{
    include( "fungsinilai.php" );
    //include( "../libchart/libchart.php" );
    $href = "index.php?".$href."dataperhalaman={$dataperhalaman}&pilihan={$pilihan}&aksi={$aksi}&tgllap[tgl]={$tgllap['tgl']}&tgllap[bln]={$tgllap['bln']}&tgllap[thn]={$tgllap['thn']}&jenistampilan={$jenistampilan}&nilaidiambil={$nilaidiambil}&nilaikosong={$nilaikosong}&";
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
        $qfield .= " AND mahasiswa.ANGKATAN='{$angkatan}'";
        $qjudul .= " Angkatan '{$angkatan}' <br>";
        $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
        $href .= "angkatan={$angkatan}&";
    }
    if ( $id != "" )
    {
        $qfield .= " AND mahasiswa.ID LIKE '%{$id}%'";
        $qjudul .= " NIM mengandung kata '{$id}' <br>";
        $qinput .= " <input type=hidden name=id value='{$id}'>";
        $href .= "id={$id}&";
    }
    if ( ismahasiswa( ) || iswali( ) )
    {
        $idmhs = $users;
    }
    if ( $idmhs != "" )
    {
        $qfield .= " AND mahasiswa.ID = '{$idmhs}'";
        $qjudul .= " NIM = '{$idmhs}' <br>";
        $qinput .= " <input type=hidden name=idmhs value='{$idmhs}'>";
        $href .= "idmhs={$idmhs}&";
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
        $qfield .= " AND mahasiswa.STATUS='{$status}'";
        $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
        $qinput .= " <input type=hidden name=status value='{$status}'>";
        $href .= "status={$status}&";
    }
    if ( $jeniskelas != "" )
    {
        $qfield .= " AND mahasiswa.JENISKELAS='{$jeniskelas}'";
        $qjudul .= " Jenis Kelas '".$arraykelasstei["{$jeniskelas}"]."' <br>";
        $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
        $href .= "jeniskelas={$jeniskelas}&";
    }
    if ( $sort == "" )
    {
        $sort = " mahasiswa.ID";
    }
    if ( $tahun != "" )
    {
        $qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
        $href .= "tahun={$tahun}&";
    }
    $qinput .= " <input type=hidden name=semester value='{$semester}'>";
    if ( $semester == "" )
    {
        $semester = 1;
    }
    $href .= "semester={$semester}&";
    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $q = "SELECT COUNT(*) AS JML FROM mahasiswa,prodi,departemen  \r\n\tWHERE 1=1 {$qprodidep5} AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID\r\n\t{$qfieldtambahan2}\r\n\t{$qfield}\r\n \t{$qfieldx1} \r\n\t";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $total = $d[JML];
    $first = 0;
    if ( 0 + $dataperhalaman <= 0 )
    {
        $dataperhalaman = 1;
    }
    $maxdata = $dataperhalaman;
    include( "../paginating.php" );
    $q = "SELECT mahasiswa.*,prodi.SKSMIN , \r\n\tprodi.IDDEPARTEMEN, \tprodi.TINGKAT,\r\n\tdepartemen.IDFAKULTAS \r\n\tFROM mahasiswa,prodi,departemen  ,trakm\r\n\tWHERE 1=1 {$qprodidep5} \r\n  AND  trakm.THSMSTRAKM=CONCAT('".( $tahun - 1 )."','{$semester}')\r\n  AND  trakm.NIMHSTRAKM=mahasiswa.ID\r\n  AND\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID\r\n\t{$qfieldtambahan2}\r\n\t{$qfield}\r\n\t{$qfieldx1}\r\n\tORDER BY {$sort} {$qlimit}";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        if ( $aksi != "cetak" )
        {
            printmesg( "Kartu Hasil Studi Semester Pendek" );
            echo "{$tpage} {$tpage2}";
        }
        if ( $aksi != "cetak" )
        {
            echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakkhs.php' method=post>\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n  \t\t\t\t".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."\r\n\t\t\t".createinputhidden( "nilaidiambil", "{$nilaidiambil}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."\r\n \t\t\t".createinputhidden( "dataperhalaman", "{$dataperhalaman}", "" )."\r\n \t\t\t".createinputhidden( "nilaikosong", "{$nilaikosong}", "" )."\r\n \t\t\t".createinputhidden( "jenistampilan", "{$jenistampilan}", "" )."\r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
        }
        $totalsemua = 0;
        $bobotsemua = 0;
        $totals = "";
        $bobots = "";
		$headerkhs = $bodykhs = $footerkhs = "";
		$count = 0;
        if ( $d = sqlfetcharray( $h ) )
        {
			++$count;
            if ( 1 < $count && $pdf == 1 )
            {
                $hasilkhs .= "<PAGEBREAK>";
            }
			
            $totalsemua = 0;
            $bobotsemua = 0;
            $totals = "";
            $bobots = "";
            $semesterhitung = $kurawal = $kurakhir = "";
            if ( $semester != 3 )
            {
                $semesterhitung = ( $tahun - 1 - $d[ANGKATAN] ) * 2 + $semester - get_jumlah_cuti_mahasiswa( $d[ID], $tahun - 1, $semester );
                $kurawal = "(";
                $kurakhir = ")";
            }
            if ( $aksi == "cetak" )
            {
                $tmpkop = "";
                if ( $kopsurat == 1 )
                {
					#echo "lll";exit();
                    include( "proseskop.php" );
                }
                /*echo $tmpcetakawal .= "<div style='page-break-after:always'>\r\n        ".$tmpkop;
                echo "<center>\r\n\t\t\t<h3>Kartu Hasil Studi Semester Pendek</h3><br/>\r\n\t\t\t";*/
				$headerkhs .= $tmpcetakawal .= "<div style='page-break-after:always;margin:0px;padding:0px;'>".$tmpkop;
				$headerkhs .="<center>\r\n\t\t\t<h3 align='center'>Kartu Hasil Studi Semester Pendek</h3><br/>\r\n\t\t\t";
            }
            $idmahasiswa = $d[ID];
            $sem = $semester;
            $tahunlama = $tahun;
            /*echo " \r\n\t\t\t\r\n\t\t\t\t<center>\r\n\t\t\t<table  class=loseborder width=660>\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td width=50%>\r\n\t\t\t\t<table    >\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Nama</td>\r\n\t\t\t\t\t\t<td>: {$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left >\r\n\t\t\t\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Semester</td>\r\n\t\t\t\t\t\t<td>: Pendek / {$semesterhitung} {$kurawal} ".$arraysemester[$semester]." {$kurakhir}    </td>\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t</table>\r\n\t\t\t</td>\r\n\t\t\t<td  width=50%>\r\n\r\n\t\t\t\t<table    >";*/
            $headerkhs .=" \r\n\t\t\t\r\n\t\t\t\t<center>\r\n\t\t\t<table  class=loseborder width=660>\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td width=50%>\r\n\t\t\t\t<table    >\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Nama</td>\r\n\t\t\t\t\t\t<td>: {$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left >\r\n\t\t\t\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Semester</td>\r\n\t\t\t\t\t\t<td>: Pendek / {$semesterhitung} {$kurawal} ".$arraysemester[$semester]." {$kurakhir}    </td>\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t</table>\r\n\t\t\t</td>\r\n\t\t\t<td  width=50%>\r\n\r\n\t\t\t\t<table    >";
			if ( $POLTITEKNIK == 0 )
            {
                #echo "\r\n \t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Fakultas</td>\r\n\t\t\t\t\t\t<td>: ".$arrayfakultas[$d[IDFAKULTAS]]."</td>\r\n\t\t\t\t\t</tr>";
				$headerkhs .="\r\n \t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Fakultas</td>\r\n\t\t\t\t\t\t<td>: ".$arrayfakultas[$d[IDFAKULTAS]]."</td>\r\n\t\t\t\t\t</tr>";
				
			}
            #echo "\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Jurusan</td>\r\n\t\t\t\t\t\t<td>: ".$arraydepartemen[$d[IDDEPARTEMEN]]."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Program Studi</td>\r\n\t\t\t\t\t\t<td>: ".$arrayprodi[$d[IDPRODI]]." (".$arrayjenjang[$d[TINGKAT]].") </td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t</table>\t\t\t\t\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</table>\r\n\t \r\n\t\t\t";
            $headerkhs .= "\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Jurusan</td>\r\n\t\t\t\t\t\t<td>: ".$arraydepartemen[$d[IDDEPARTEMEN]]."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Program Studi</td>\r\n\t\t\t\t\t\t<td>: ".$arrayprodi[$d[IDPRODI]]." (".$arrayjenjang[$d[TINGKAT]].") </td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t</table>\t\t\t\t\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</table>\r\n\t \r\n\t\t\t";
            
			$angkatanmhs = $d[ANGKATAN];
            $idmahasiswa = $d[ID];
            include( "proseskhs.php" );
            if ( $aksi != "cetak" )
            {
                echo "<hr>";
				#$tmpcetakawal .= "<hr>";
            }
            else if ( $pdf != 1 && 1 < $count )
            {
                echo $tmpcetakawal = "</div>";
				#$tmpcetakawal .= "</div>";
            }
			#$hasilkhs .= $tmpcetakawal.$footerkhs;
			$hasilkhs .= $headerkhs.$bodykhs.$footerkhs;
            $headerkhs = $bodykhs = $footerkhs = "";
		}
		
		if ( $pdf == 1 )
        {
            cetakpdf( $hasilkhs,$stylekhs);
        }
        else
        {
            echo $stylekhs.$hasilkhs;
        }
    }
	else
	{
		$errmesg = "Data mahasiswa tidak ada";
		$aksi = "";
	}
}
?>
