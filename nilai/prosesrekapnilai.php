<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

unset( $arraysort );
$arraysort[0] = "mahasiswa.ID";
$arraysort[1] = "mahasiswa.NAMA";
$vld[] = cekvaliditaskodeprodi( "Jurusan/Program Studi", $idprodi );
$vld[] = cekvaliditaskode( "Dosen Wali", $iddosen );
$vld[] = cekvaliditastahun( "Angkatan", $angkatan );
$vld[] = cekvaliditaskode( "NIM", $id );
$vld[] = cekvaliditasnama( "Nama", $nama );
$vld[] = cekvaliditaskode( "Status", $status );
$vld[] = cekvaliditasthnajaran( "Tahun/Semester", $tahun, $semester );
$vld[] = cekvaliditaskode( "Nilai M-K yang diambil", $nilaidiambil, 1 );
$vld[] = cekvaliditastanggal( "Tanggal Laporan", $tgllap['tgl'], $tgllap['bln'], $tgllap['thn'] );
$vld = array_filter( $vld, "filter_not_empty" );
if ( isset( $vld ) && 0 < count( $vld ) )
{
    $errmesg = val_err_mesg( $vld, 2, CARI_DATA );
    $aksi = "";
}
else
{
    $href = "index.php?pilihan={$pilihan}&aksi2=Tampilkan&";
    foreach ( $datamk as $k => $v )
    {
        $qinput .= "\r\n\t\t\t\t\t<input type=hidden name=datamk[{$k}] value='{$v}'>\r\n\t\t\t\t\t";
        $href .= "datamk[{$k}]={$v}&";
    }
    $href .= "tgllap[tgl]={$tgllap['tgl']}&tgllap[bln]={$tgllap['bln']}&tgllap[thn]={$tgllap['thn']}&";
    if ( $idprodi2 != "" )
    {
        $qfield .= " AND IDPRODI='{$idprodi2}'";
        $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi2]."' <br>";
        $qinput .= " <input type=hidden name=idprodi2 value='{$idprodi2}'>";
        $href .= "idprodi2={$idprodi2}&";
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
        $qfield .= " AND ID LIKE '%{$id}%'";
        $qjudul .= " NIM = '{$id}' <br>";
        $qinput .= " <input type=hidden name=id value='{$id}'>";
        $href .= "id={$id}&";
    }
    if ( $nama != "" )
    {
        $qfield .= " AND NAMA LIKE '%{$nama}%'";
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
    $q = "SELECT COUNT(*) AS JML FROM mahasiswa \r\n\tWHERE 1=1 {$qprodidep5}\r\n\t{$qfield}\r\n \r\n\t";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $total = $d[JML];
    $first = 0;
    $maxdata = $dataperhalaman;
    include( "../paginating.php" );
    $q = "SELECT * FROM mahasiswa \r\n\tWHERE 1=1 {$qprodidep5}\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        if ( $aksi != "cetak" )
        {
            #printjudulmenu( "Laporan Nilai Mata Kuliah" );
            #printmesg( $qjudul );
			echo "	<div class=\"page-content\">
					<div class=\"container-fluid\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<!-- BEGIN SAMPLE FORM PORTLET-->
								";	
										
			echo "						<div class='portlet-title'>";
											printmesg("Laporan Nilai Mata Kuliah");
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
            printjudulmenucetak( "Laporan Nilai Mata Kuliah" );
            printmesgcetak( $qjudul );
        }
        if ( $aksi != "cetak" )
        {
            #echo "{$tpage} {$tpage2}";
            #echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakrekapnilai.php'>\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>\r\n  \t\t\t\t".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."\r\n\t\t\t".createinputhidden( "nilaidiambil", "{$nilaidiambil}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."\r\n\t\t\t".createinputhidden( "kopsurat", "{$kopsurat}", "" )."\r\n\t\t\t{$qinput}\r\n\t\t\t{$input}\r\n\t\t\t";
            echo "					<form target=_blank action='cetakrekapnilai.php'>\r\n \t\t\t\t<input type=submit align='center' name=aksi2 class=\"btn btn-brand\" value='Cetak'>\r\n  \t\t\t\t".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."\r\n\t\t\t".createinputhidden( "nilaidiambil", "{$nilaidiambil}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."\r\n\t\t\t".createinputhidden( "kopsurat", "{$kopsurat}", "" )."\r\n\t\t\t{$qinput}\r\n\t\t\t{$input}\r\n\t\t\t
									";
			foreach ( $datamk as $k => $v )
            {
                echo createinputhidden( "datamk[{$k}]", "{$v}", "" );
            }
            echo "					</form>";
        }
		echo "						<br>
									<div class=\"m-portlet\">
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">";
		echo "{$tpage} {$tpage2}";
		echo "									<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t<td rowspan=3>No</td>\r\n \t\t\t\t<td rowspan=3><a class='{$cetak}' href='{$href}"."&sort=0'>NIM</td>\r\n\t\t\t\t<td rowspan=3><a class='{$cetak}' href='{$href}"."&sort=1'>Nama</td>  \r\n\t\t\t\t<td colspan=".( 3 * count( $datamk ) ).">Mata Kuliah</td>  \r\n\t\t\t\t<td rowspan=3>Jml Nilai</td>  \r\n\t\t\t\t<td rowspan=3>IP</td>  \r\n\t\t\t</tr>\t\t\t\t\r\n\t\t\t<tr class=juduldata{$cetak} align=center>
													";
        #echo "\r\n \t\t\t<table {$border} class=data{$cetak}>\r\n\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t<td rowspan=3>No</td>\r\n \t\t\t\t<td rowspan=3><a class='{$cetak}' href='{$href}"."&sort=0'>NIM</td>\r\n\t\t\t\t<td rowspan=3><a class='{$cetak}' href='{$href}"."&sort=1'>Nama</td>  \r\n\t\t\t\t<td colspan=".( 3 * count( $datamk ) ).">Mata Kuliah</td>  \r\n\t\t\t\t<td rowspan=3>Jml Nilai</td>  \r\n\t\t\t\t<td rowspan=3>IP</td>  \r\n\t\t\t</tr>\t\t\t\t\r\n\t\t\t<tr class=juduldata{$cetak} align=center>";
        foreach ( $datamk as $k => $v )
        {
            echo "\r\n\t\t \t\t\t\t<td colspan=3  >".getnamafromtabel( "{$k}", "makul" )."</td>\r\n\t\t\t\t\t";
        }
        echo "\r\n\t\t\t</tr>\r\n\t\t\t<tr class=juduldata{$cetak} align=center>";
		
        foreach ( $datamk as $k => $v )
        {
            $datasks[$k] = getfieldfromtabel( "{$k}", "SKS", "makul" );
            echo "\r\n\t\t \t\t\t\t<td nowrap>M</td>\r\n\t\t \t\t\t\t<td nowrap>".$datasks[$k]." SKS</td>\r\n\t\t \t\t\t\t<td nowrap>L </td>\r\n\t\t\t\t\t";
        }
        echo "\r\n\t\t\t</tr>\r\n\t\t";
		echo "								</thead>
												<tbody>	";
        $i = 1;
        $nilaidiambil = 0;
        if ( $nilaidiambil == 1 )
        {
            $order = "ORDER BY TAHUN DESC LIMIT 0,1";
        }
        else
        {
            $order = "ORDER BY BOBOT DESC";
        }
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            echo "\r\n\t\t\t\t<tr align=center {$kelas}{$cetak}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t\t<td align=left nowrap><a class='{$cetak}' href='../mahasiswa/index.php?pilihan=lengkap&id={$d['ID']}'>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NAMA']}</td>";
            $jmlnilai = 0;
            $jmlsks = 0;
            foreach ( $datamk as $k => $v )
            {
                $datanilai = getrowfromtabelsyarat( "WHERE IDMAKUL='{$k}' AND IDMAHASISWA='{$d['ID']}' {$order}", "BOBOT,NILAI,SIMBOL", "pengambilanmk" );
                echo "\r\n\t\t \t\t\t\t<td>".number_format_sikad( $datanilai[BOBOT], 2, ".", "," )."</td>\r\n\t\t \t\t\t\t<td>".number_format_sikad( $datanilai[BOBOT] * $datasks[$k], 2, ".", "," )."</td>\r\n\t\t \t\t\t\t<td>{$datanilai['SIMBOL']}</td>\r\n\t\t\t\t\t";
                if ( $datanilai != "" )
                {
                    $jmlnilai += $datanilai[BOBOT] * $datasks[$k];
                    $jmlsks += $datasks[$k];
                }
            }
            echo "\r\n\t\t \t\t\t\t<td>".number_format_sikad( $jmlnilai, 2, ".", "," )."</td>\r\n\t\t \t\t\t\t<td>".number_format_sikad( @$jmlnilai / @$jmlsks, 2, ".", "," )."</td>\r\n\t\t\t\t\t";
            echo "\r\n \t\t\t\t</tr>\r\n\t\t\t";
            ++$i;
        }
        echo "</tbody></table></div></div></div></div></div></div></div>";
        include( "footertranskrip2.php" );
        $aksi = "tampilkan";
    }
    else
    {
        $errmesg = "Data Mahasiswa Tidak Ada";
        $aksi = "";
    }
}
?>
