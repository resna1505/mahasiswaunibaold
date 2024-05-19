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
if ( $jenisusers == 3 || $jenisusers == 2 )
{
    $idmahasiswa = $users;
}
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
if ( $istglbayar == 1 )
{
    $qfield .= "\r\n \t\t\tAND \r\n \t\t\t(\r\n \t\t\t\tTANGGALBAYAR >= DATE_FORMAT('{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}','%Y-%m-%d')\r\n \t\t\t\tAND\r\n \t\t\t\tTANGGALBAYAR <= DATE_FORMAT('{$tglbayar2['thn']}-{$tglbayar2['bln']}-{$tglbayar2['tgl']}','%Y-%m-%d')\r\n \t\t\t)\r\n \t\t";
    $qjudul .= " Tanggal bayar antara  {$tglbayar['tgl']}-{$tglbayar['bln']}-{$tglbayar['thn']} s.d\r\n\t\t {$tglbayar2['tgl']}-{$tglbayar2['bln']}-{$tglbayar2['thn']} \r\n\t\t <br>";
    $qinput .= " \r\n\t\t\t<input type=hidden name=tglbayar[thn] value='{$tglbayar['thn']}'>\r\n\t\t\t<input type=hidden name=tglbayar[bln] value='{$tglbayar['bln']}'>\r\n\t\t\t<input type=hidden name=tglbayar[tgl] value='{$tglbayar['tgl']}'>\r\n\t\t\t<input type=hidden name=tglbayar2[thn] value='{$tglbayar2['thn']}'>\r\n\t\t\t<input type=hidden name=tglbayar2[bln] value='{$tglbayar2['bln']}'>\r\n\t\t\t<input type=hidden name=tglbayar2[tgl] value='{$tglbayar2['tgl']}'>\r\n\t\t";
    $href .= "tglbayar[tgl]={$tglbayar['tgl']}&tglbayar[bln]={$tglbayar['bln']}&tglbayar[thn]={$tglbayar['thn']}&\r\n\t\ttglbayar2[tgl]={$tglbayar2['tgl']}&tglbayar2[bln]={$tglbayar2['bln']}&tglbayar2[thn]={$tglbayar2['thn']}&";
}
if ( $tahunajaran != "" )
{
    $qjudul .= " Tahun Akademik '".( $tahunajaran - 1 )."/{$tahunajaran}' <br>";
}
if ( $semesterbayar != "" )
{
    $qjudul .= " Semester '".$arraysemester[$semesterbayar]."' <br>";
}
/*if ( $semesterbayar2 != "" )
{
    $qjudul .= " Bulan ".$arraybulan[$semesterbayar2 - 1]." <br>";
}
if ( $tahunajaran2 != "" )
{
    $qjudul .= " Tahun {$tahunajaran2}  <br>";
}*/
$qinput .= " <input type=hidden name=idkomponen value='{$idkomponen}'>";
$href .= "idkomponen={$idkomponen}&";
$qinput .= " <input type=hidden name=tahunajaran value='{$tahunajaran}'>";
$href .= "tahunajaran={$tahunajaran}&";
$qinput .= " <input type=hidden name=semesterbayar value='{$semesterbayar}'>";
$href .= "semesterbayar={$semesterbayar}&";
$qinput .= " <input type=hidden name=semesterbayar2 value='{$semesterbayar2}'>";
$href .= "semesterbayar2={$semesterbayar2}&";
$qinput .= " <input type=hidden name=tahunajaran2 value='{$tahunajaran2}'>";
$href .= "tahunajaran2={$tahunajaran2}&";
if ( $idkomponen != "" )
{
    $qfield2 .= " \r\n\t\t\t\t\t\tAND ( bayarkomponen.IDKOMPONEN='{$idkomponen}')";
    $qjudul .= " Komponen Pembayaran : '".$arraykomponenpembayaran2[$idkomponen]."' <br>";
    if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 )
    {
        if ( $tahunajaran != "" )
        {
            $qfield2 .= " AND bayarkomponen.TAHUNAJARAN = '{$tahunajaran}' ";
        }
    }
    else
    {
        if ( $arrayjeniskomponenpembayaran[$idkomponen] == 3 )
        {
            if ( $semesterbayar != "" )
            {
                $qfield2 .= " AND (bayarkomponen.SEMESTER ='{$semesterbayar}' ) ";
            }
            if ( $tahunajaran != "" )
            {
                $qfield2 .= " AND ( bayarkomponen.TAHUNAJARAN='{$tahunajaran}')";
                $qjudul .= " Tahun Akademik '".( $tahunajaran - 1 )."/{$tahunajaran}' <br>";
            }
        }
        else
        {
            if ( $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
            {
                if ( $semesterbayar2 != "" )
                {
                    $qfield2 .= " AND ( bayarkomponen.SEMESTER ='{$semesterbayar2}') ";
                }
                if ( $tahunajaran2 != "" )
                {
                    $qfield2 .= " AND ( bayarkomponen.TAHUNAJARAN='{$tahunajaran2}' )";
                }
            }
        }
    }
}
else
{
    $qinput .= " <input type=hidden name=idkomponen value='{$idkomponen}'>";
    $href .= "idkomponen={$idkomponen}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
{
    $qfieldjeniskelasm = " AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS=mahasiswa.JENISKELAS ";
}
else
{
    $qfieldjeniskelasm = " AND biayakomponen.JENISKELAS='' ";
}
#$q = "SELECT \r\n\t \t \r\n\t \t\t   mahasiswa.NAMA,mahasiswa.ID,biayakomponen.IDKOMPONEN,biayakomponen.BIAYA AS JUMLAH\r\n\tFROM  mahasiswa,biayakomponen  ,komponenpembayaran\r\n\tWHERE \r\n\tmahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND mahasiswa.IDPRODI=biayakomponen.IDPRODI AND mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND\r\n\tbiayakomponen.IDKOMPONEN=komponenpembayaran.ID AND\r\n  komponenpembayaran.JENIS!=4 AND\r\n  komponenpembayaran.JENIS!=6\r\n \t {$qfield}\r\n \t {$qfieldjeniskelasm}\r\n \r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
#echo $q.'<br>';
$sql_get_tingkat="SELECT TINGKAT FROM prodi WHERE ID='$idprodi'";
$query_get_tingkat = mysqli_query($koneksi,$sql_get_tingkat);
$d_get_tingkat = mysqli_fetch_array($query_get_tingkat);
$tingkatprodi=$d_get_tingkat['TINGKAT'];

#$semestermahasiswa=getsemesetermahasiswa()
if($tingkatprodi=='A' || $tingkatprodi=='B'){
	#$q=""
	$q = "SELECT mahasiswa.NAMA,mahasiswa.ID,mahasiswa.STATUS,biayakomponen.IDKOMPONEN,biayakomponen.BIAYA AS JUMLAH 
	FROM  mahasiswa,biayakomponen  ,komponenpembayaran\r\n\tWHERE \r\n\tmahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND mahasiswa.IDPRODI=biayakomponen.IDPRODI 
	AND mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND biayakomponen.IDKOMPONEN=komponenpembayaran.ID AND komponenpembayaran.JENIS!=4 AND	
	komponenpembayaran.JENIS!=6 AND mahasiswa.STATUS='A' AND biayakomponen.BIAYA>0 {$qfield} {$qfieldjeniskelasm} 
	ORDER BY mahasiswa.ID,biayakomponen.ID";
}else{
	$q="(SELECT mahasiswa.NAMA,mahasiswa.ID,biayakomponen.IDKOMPONEN,biayakomponen.BIAYA AS JUMLAH FROM mahasiswa,biayakomponen ,komponenpembayaran 
	WHERE mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND mahasiswa.IDPRODI=biayakomponen.IDPRODI AND mahasiswa.GELOMBANG=biayakomponen.GELOMBANG 
	AND biayakomponen.IDKOMPONEN=komponenpembayaran.ID AND komponenpembayaran.JENIS!=4 AND komponenpembayaran.JENIS!=6 
	AND mahasiswa.STATUS='A' AND biayakomponen.BIAYA>0 AND IDKOMPONEN!='032' {$qfield} {$qfieldjeniskelasm})
	UNION
	(SELECT mahasiswa.NAMA,mahasiswa.ID,buattagihanva.IDKOMPONEN,buattagihanva.JUMLAH FROM mahasiswa JOIN buattagihanva ON mahasiswa.ID=buattagihanva.IDMAHASISWA 
	JOIN komponenpembayaran ON komponenpembayaran.ID=buattagihanva.IDKOMPONEN WHERE mahasiswa.STATUS='A'
	{$qfield} AND TANGGALTAGIHAN=(SELECT MAX(buattagihanva.TANGGALTAGIHAN) FROM buattagihanva)) ORDER BY 2";
}
#echo $q.'<br>';
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    /*if ( $aksi != "cetak" )
    {
        #printjudulmenu( "Laporan Keuangan : Mahasiswa yg Belum Membayar" );
        printmesg( $qjudul );
        printmesg( $errmesg );
    }
    else
    {
        #printjudulmenucetak( "Laporan Keuangan : Mahasiswa yg Belum Membayar" );
        printmesgcetak( $qjudul );
    }*/
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
								printmesg("Laporan Keuangan : Mahasiswa yang Belum Membayar");
    if ( $aksi != "cetak" && !isset( $_SESSION[users_mobile] ) )
    {
        printmesg( $qjudul );
		echo "					<div class=\"tools\">
										<form target=_blank action='cetaklaporan2.php' method=post>
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

        #echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetaklaporan2.php'>\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>\r\n  \t\t\t\t{$qinput}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    #echo "\r\n \t\t\t<table {$border} class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td><b>No</td>\r\n \t\t\t\t<td><b><a class='{$cetak}' href='{$href}"."sort=0'>NIM</td>\r\n\t\t\t\t<td><b><a class='{$cetak}' href='{$href}"."sort=1'>Nama<br>Mahasiswa</td>\r\n\t\t\t\t<td><b>Komponen Pembayaran</td>\r\n\t\t\t\t<td><b>Jumlah Per Periode</td>\r\n  \t\t\t</tr>\r\n\t\t";
    echo "								<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td><b>No</td>\r\n \t\t\t\t<td><b>NIM</td><td><b>Nama<br>Mahasiswa</td>\r\n\t\t\t\t<td><b>Komponen Pembayaran</td>\r\n\t\t\t\t<td><b>Jumlah Per Periode</td>\r\n  \t\t\t</tr>\r\n\t\t";
	echo "											</thead>
													<tbody>";
	$i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $tmp = explode( "-", $d[TANGGALBAYAR] );
        $tglbayar[tgl] = $tmp[2];
        $tglbayar[bln] = $tmp[1];
        $tglbayar[thn] = $tmp[0];
        $qfield2 = "";
        if ( $arrayjeniskomponenpembayaran[$d[IDKOMPONEN]] == 2 )
        {
            if ( $tahunajaran != "" )
            {
                $qfield2 .= " AND bayarkomponen.TAHUNAJARAN = '{$tahunajaran}' ";
            }
        }
        else if ( $arrayjeniskomponenpembayaran[$d[IDKOMPONEN]] == 3 )
        {
            if ( $semesterbayar != "" )
            {
                $qfield2 .= " AND (bayarkomponen.SEMESTER ='{$semesterbayar}' ) ";
            }
            if ( $tahunajaran != "" )
            {
                $qfield2 .= " AND ( bayarkomponen.TAHUNAJARAN='{$tahunajaran}')";
            }
        }
        else if ( $arrayjeniskomponenpembayaran[$d[IDKOMPONEN]] == 5 )
        {
            if ( $semesterbayar2 != "" )
            {
                $qfield2 .= " AND ( bayarkomponen.SEMESTER ='{$semesterbayar2}') ";
            }
            if ( $tahunajaran2 != "" )
            {
                $qfield2 .= " AND ( bayarkomponen.TAHUNAJARAN='{$tahunajaran2}' )";
            }
        }
        $q = "SELECT SUM(JUMLAH+DISKON) AS JML FROM bayarkomponen WHERE\r\n      IDMAHASISWA='{$d['ID']}' AND IDKOMPONEN='{$d['IDKOMPONEN']}' 
	{$qfield2} GROUP BY IDMAHASISWA";
        #echo $q.'<br>';
		$h2 = mysqli_query($koneksi,$q);
        $d2 = sqlfetcharray( $h2 );
        $totalbayar = $d2[JML];
	if ( $d[IDKOMPONEN] == "99" )
        {
            #$jumlahsks = getjumlahsks( $d[IDMAHASISWA], $d[TAHUNAJARAN], $d[SEMESTER] );
            #$jumlahskswajib = getjumlahskswajib( $d[IDMAHASISWA], $d[TAHUNAJARAN], $d[SEMESTER] );
			$jumlahsks = getjumlahsks( $d[ID], $d2[TAHUNAJARAN], $d2[SEMESTER] );
            $jumlahskswajib = getjumlahskswajib( $d[ID], $d2[TAHUNAJARAN], $d2[SEMESTER] );
			
			#echo "JUMLAHSKS=".$jumlahsks.'<br>';
            #echo "JUMLAHSKSWAJIB=".$jumlahsks.'<br>';
            
			$skslebih = 0;
            if ( $jumlahskswajib < $jumlahsks )
            {
                $skslebih = $jumlahsks - $jumlahskswajib;
            }
            $biayakomponen = $d[BIAYA] + 0;
            $biaya = $skslebih * $biayakomponen;
			#echo "BIAYA99=".$biaya.'<br>';
            
            #$d[BIAYA] = $biaya;
            #if ( $d[JUMLAH] < $d[BIAYA] )
			if ( $d[JUMLAH] < $biaya )	
            {
                if ( $jenisbayar == 1 )
                {
                    continue;
                }
				
            }
        }
        #if ( !( $jenisbayar != 1 ) || $d[IDKOMPONEN] == "98" )
		if ($d[IDKOMPONEN] == "98" )
        {
			
            $jumlahsks = getjumlahskssp( $d[ID], $d[TAHUNAJARAN], $d[SEMESTER] );
            $jumlahskswajib = 0;
            $skslebih = 0;
            if ( $jumlahskswajib < $jumlahsks )
            {
                $skslebih = $jumlahsks - $jumlahskswajib;
            }
            
			#echo "JUMLAHSKS=".$jumlahsks.'<br>';
            #echo "JUMLAHSKSWAJIB=".$jumlahsks.'<br>';
            
			$biayakomponen = $d[BIAYA] + 0;
            $biaya = $skslebih * $biayakomponen;
            #echo "BIAYA98=".$biaya.'<br>';
            
			#$d[BIAYA] = $biaya;
            #if ( $d[JUMLAH] < $d[BIAYA] )
			if ( $d[JUMLAH] < $biaya )	
            {
                if ( $jenisbayar == 1 )
                {
                    continue;
                }
            }
        }

       		 if ($d[JUMLAH]>0){
					if($d2[JML]<$d[JUMLAH] && $d[IDKOMPONEN] != "98" && $d[IDKOMPONEN] != "99" && $d[IDKOMPONEN] != "032"){
						#echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi} valign=top>\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t\t<td align=left>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=left>".$arraykomponenpembayaran[$d[IDKOMPONEN]]."</td>\r\n \t\t\t\t\t<td align=right>".cetakuang( $d[JUMLAH] )." </td>\r\n   \t\t\t\t</tr>\r\n\t\t\t";
						echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi} valign=top>\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t\t<td align=left>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=left>".$arraykomponenpembayaran[$d[IDKOMPONEN]]."</td>\r\n \t\t\t\t\t<td align=right>".cetakuang( $d[JUMLAH]-$d2[JML] )." </td>\r\n   \t\t\t\t</tr>\r\n\t\t\t";
						
						++$i;
					}elseif($d[IDKOMPONEN] == "032"){
							#echo "BAYAR=".$d2[JML].'<br>';
							#echo "BIAYA=".$d[JUMLAH].'<br>';
							
						if(($tingkatprodi=='A' || $tingkatprodi=='B')){
							#echo "kesini";
							#echo '<br>';
							if ($d2[JML]<$d[JUMLAH]){
								#echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi} valign=top>\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t\t<td align=left>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=left>".$arraykomponenpembayaran[$d[IDKOMPONEN]]."</td>\r\n \t\t\t\t\t<td align=right>".cetakuang( $d[JUMLAH] )." </td>\r\n   \t\t\t\t</tr>\r\n\t\t\t";
								echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi} valign=top>\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t\t<td align=left>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=left>".$arraykomponenpembayaran[$d[IDKOMPONEN]]."</td>\r\n \t\t\t\t\t<td align=right>".cetakuang( $d[JUMLAH]-$d2[JML] )." </td>\r\n   \t\t\t\t</tr>\r\n\t\t\t";
								++$i;	
							}
							
						}else{
							#echo "kesono";
							#echo '<br>';
							echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi} valign=top>\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t\t<td align=left>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=left>".$arraykomponenpembayaran[$d[IDKOMPONEN]]."</td>\r\n \t\t\t\t\t<td align=right>".cetakuang( $d[JUMLAH] )." </td>\r\n   \t\t\t\t</tr>\r\n\t\t\t";
							++$i;
						}
					}elseif($biaya>0){
						echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi} valign=top>\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t\t<td align=left>{$d['ID']} {$d['IDKOMPONEN']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']} {$tingkatprodi}</td>\r\n \t\t\t\t\t<td align=left>".$arraykomponenpembayaran[$d[IDKOMPONEN]]." ".$d['JUMLAH']." ".$d2['JML']." ".$biaya."</td>\r\n \t\t\t\t\t<td align=right>".cetakuang($biaya)." </td>\r\n   \t\t\t\t</tr>\r\n\t\t\t";
						++$i;
					}
			#if ($d[IDKOMPONEN] != 98 && $d[IDKOMPONEN] != 99){	
						
				#if ($biaya>0 && ($d[IDKOMPONEN] == "98" || $d[IDKOMPONEN] == "99"))	
				#{
					//cek di tabel tagihan
				#	echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi} valign=top>\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t\t<td align=left>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=left>".$arraykomponenpembayaran[$d[IDKOMPONEN]]."</td>\r\n \t\t\t\t\t<td align=right>".cetakuang( $d[JUMLAH] )." </td><td align=right>".arraystatusmahasiswa( $d[STATUS] )." </td></tr>\r\n\t\t\t";
					
				#}
				
			}
		#}
    	}    
	#echo "\r\n \t\t</table></div></div>{$tpage} {$tpage2}</div></div></div> ";
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
    if ( $i == 1 )
    {
        printmesg( "Data Laporan Keuangan Tidak Ada" );
    }
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Laporan Keuangan Tidak Ada";
    $aksi = "";
}
?>
