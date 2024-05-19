<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo "lll";exit();
periksaroot( );
$vld[] = cekvaliditaskodeprodi( "Jurusan/Program Studi", $idprodi );
$vld[] = cekvaliditaskode( "Dosen Wali", $iddosen );
$vld[] = cekvaliditastahun( "Angkatan", $angkatan );
$vld[] = cekvaliditaskode( "NIM", $id );
$vld[] = cekvaliditasnama( "Nama", $nama );
$vld[] = cekvaliditaskode( "Status", $status );
$vld[] = cekvaliditaskode( "Nilai M-K yang diambil", $nilaidiambil, 1 );
$vld[] = cekvaliditaskode( "Perlakuan terhadap nilai kosong", $nilaikosong, 1 );
$vld[] = cekvaliditaskode( "Penempatan Semester Mata Kuliah", $penempatansemester, 2 );
$vld[] = cekvaliditaskode( "Nilai SP", $sp );
$vld[] = cekvaliditaskode( "Cetak Diagram", $diagram );
$vld[] = cekvaliditaskode( "Jenis", $jenistampilan );
$vld[] = cekvaliditastanggal( "Tanggal", $tgllap['tgl'], $tgllap['bln'], $tgllap['thn'] );
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
    #include( "../libchart/libchart.php" );
    $href = "dataperhalaman={$dataperhalaman}&pilihan={$pilihan}&aksi={$aksi}&tgllap[tgl]={$tgllap['tgl']}&tgllap[bln]={$tgllap['bln']}&tgllap[thn]={$tgllap['thn']}&status={$status}&skpendirian={$skpendirian}&";
    if ( $idprodi != "" )
	{
		$qfield .= " AND IDPRODI='{$idprodi}'";
		$qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
		$qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
		$href .= "idprodi={$idprodi}&";
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
	if ( $status != "" )
	{
		$qfield .= " AND STATUS='{$status}'";
		$qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
		$qinput .= " <input type=hidden name=status value='{$status}'>";
		$href .= "status={$status}&";
	}
    if ( $sort == "" )
    {
        $sort = " mahasiswa.ID";
    }
    /*if ( $tahun != "" )
    {
        $qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
        $href .= "tahun={$tahun}&";
    }
	if ( $judulkopsendiri != "" )
    {
        $qinput .= " <input type=hidden name=judulkopsendiri value='{$judulkopsendiri}'>";
        $href .= "judulkopsendiri={$judulkopsendiri}&";
    }
	
    $qinput .= " <input type=hidden name=semester value='{$semester}'>";
    if ( $semester == "" )
    {
        $semester = 1;
    }
    $href .= "semester={$semester}&";*/
    $href2 = "{$href}";
    $href = "index.php?{$href}";
    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $q = "SELECT COUNT(*) AS JML FROM mahasiswa,prodi,departemen  \r\n\tWHERE 1=1 {$qprodidep5} AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID\r\n\t{$qfieldtambahan2}\r\n\t{$qfield}\r\n \t{$qfieldx1} \r\n\t";
    #echo $q.'<br>';
	$h = doquery($koneksi,$q );
    $d = sqlfetcharray( $h );
    $total = $d[JML];
    $first = 0;
    if ( 0 + $dataperhalaman <= 0 )
    {
        $dataperhalaman = 1;
    }
    $maxdata = $dataperhalaman;
    include( "../paginating.php" );
    #$q = "SELECT mahasiswa.*,msmhs.STPIDMSMHS,\r\n  prodi.SKSMIN , \r\n\tprodi.IDDEPARTEMEN, \tprodi.TINGKAT,\r\n\tdepartemen.IDFAKULTAS \r\n\tFROM mahasiswa,msmhs,prodi,departemen  \r\n\tWHERE 1=1 {$qprodidep5} AND\r\n\tmahasiswa.ID=msmhs.NIMHSMSMHS AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID\r\n\t{$qfieldtambahan2}\r\n\t{$qfield}\r\n\t{$qfieldx1}\r\n\tORDER BY {$sort} {$qlimit}";
    $q = "SELECT mahasiswa.*,\r\n prodi.NAMA as NAMAP ,\r\n  prodi.NAMA2 as NAMAP2 , \r\n prodi.GELAR,prodi.GELAR2,prodi.TINGKAT,prodi.ID AS IDX,prodi.NIPPIMPINAN,prodi.NAMAPIMPINAN,prodi.NAMAPUKET1AKADEMIK,\r\n prodi.NIPPUKET1AKADEMIK,\r\n mspst.NOMBAMSPST ,\r\n fakultas.NAMA as NAMAF,fakultas.ID as IDFAKULTAS, \r\n fakultas.NAMA2 as NAMAF2, \r\n fakultas.NAMAPIMPINAN as DEKAN, \r\n fakultas.NIPPIMPINAN as NIPDEKAN ,\r\n prodi.NAMAJENJANG2,\r\n\tCOUNT(diskonbeasiswa.IDMAHASISWA) AS JUMLAHBEASISWA\r\n FROM mahasiswa LEFT JOIN diskonbeasiswa ON mahasiswa.ID=diskonbeasiswa.IDMAHASISWA \r\n  \r\n  ,prodi,mspst,departemen LEFT JOIN fakultas ON  \r\ndepartemen.IDFAKULTAS=fakultas.ID\r\nWHERE 1=1  \r\nAND\r\nmahasiswa.IDPRODI=prodi.ID\r\nAND\r\ndepartemen.ID=prodi.IDDEPARTEMEN\r\n\r\nAND\r\nmspst.IDX=prodi.ID\r\n{$qfield}\r\n\r\nGROUP BY mahasiswa.ID\r\n\r\nORDER BY {$sort} {$qlimit}";
	#echo $q;
	$h = doquery($koneksi,$q );
    if ( 0 < sqlnumrows( $h ) )
    {
        if ( $aksi != "cetak" )
        {
			#echo "jjj";exit();
           		echo "	<div class=\"page-content\">
					<div class=\"container-fluid\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<!-- BEGIN SAMPLE FORM PORTLET-->
								";	
										printmesg( $qjudul );
										printmesg( $errmesg );
			echo "						<div class='portlet-title'>";
											printmesg("Filter / Setting");
			echo "						</div>
									<div class=\"m-portlet\">
										<!--begin::Form-->
										<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" method='post' action='prosescetakijazah2.php' target='_blank'>
											<input type='hidden' name='dataperhalaman' value='{$dataperhalaman}'>
												  <input type='hidden' name='pilihan' value='{$pilihan}'>
												  <input type='hidden' name='aksi' value='tampilsemua'>
												  <input type='hidden' name='angkatan' value='{$angkatan}'>
												  <input type='hidden' name='idprodi' value='{$idprodi}'>
												  <input type='hidden' name='status' value='{$status}'>
												  <input type='hidden' name='tgl' value='{$tgllap['tgl']}'>
												  <input type='hidden' name='bln' value='{$tgllap['bln']}'>
												  <input type='hidden' name='thn' value='{$tgllap['thn']}'>
												  <input type='hidden' name='skpendirian' value='{$skpendirian}'>
											<div class=\"m-portlet__body\">	";			
            echo "								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Tanggal Ijazah</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$tgllap['tgl']}-{$tgllap['bln']}-{$tgllap['thn']}";          
            echo "									</label>
												</div>
												<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">SK Pendirian</label>\r\n    
													<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$skpendirian}";
            
            echo "									</label>
												</div>
												";
            if ( $jenisusers != 2 )
            {
                echo "	<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Data Per Halaman</label>
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$maxdata}\r\n \t\t</label>
						</div>
                
					</div><hr>";
            }
            echo "{$tpage} {$tpage2}";
        }
        if ( $aksi != "cetak" )
        {
            #echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetaktranskrip.php'>\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'> \r\n \t\t\t\t<input type=checkbox name=pdf value=1> PDF \r\n             <a class='settingpdf' href='../lib/settingpdf.php' >Setting</a> \r\n  \t\t\t\t\t\t\r\n  \t\t\t<script>\r\n            jQuery(document).ready(function () {\r\n                jQuery('a.settingpdf').colorbox();\r\n            });\r\n        </script>\r\n    \t\t\t\t".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."\r\n\t\t\t".createinputhidden( "diagram", "{$diagram}", "" )."\r\n\t\t\t".createinputhidden( "nilaidiambil", "{$nilaidiambil}", "" )."\r\n\t\t\t".createinputhidden( "jenistampilan", "{$jenistampilan}", "" )."\r\n \t\t\t".createinputhidden( "dataperhalaman", "{$dataperhalaman}", "" )."\r\n\t\t\t".createinputhidden( "jenistampilan", "{$jenistampilan}", "" )."\r\n\t\t\t".createinputhidden( "nilaikosong", "{$nilaikosong}", "" )."\r\n \t\t\t".createinputhidden( "sp", "{$sp}", "" )."\r\n \t\t\t".createinputhidden( "penempatansemester", "{$penempatansemester}", "" )."\r\n \t\t\t".createinputhidden( "iscsv", "{$iscsv}", "" )."\r\n \t\t\t".createinputhidden( "kopsurat", "{$kopsurat}", "" )."\r\n \t\t\t".createinputhidden( "kompre", "{$kompre}", "" )."\r\n \t\t\t\t{$qinput} {$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
		    #echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetaktranskrip.php'>\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'> \r\n \t\t\t\t<input type=checkbox name=pdf value=1> PDF \r\n             <a class='settingpdf' href='../lib/settingpdf.php' >Setting</a> \r\n  \t\t\t\t\t\t\r\n  \t\t\t<script>\r\n            jQuery(document).ready(function () {\r\n                jQuery('a.settingpdf').colorbox();\r\n            });\r\n        </script>\r\n    \t\t\t\t".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."\r\n\t\t\t".createinputhidden( "diagram", "{$diagram}", "" )."\r\n\t\t\t".createinputhidden( "nilaidiambil", "{$nilaidiambil}", "" )."\r\n\t\t\t".createinputhidden( "jenistampilan", "{$jenistampilan}", "" )."\r\n \t\t\t".createinputhidden( "dataperhalaman", "{$dataperhalaman}", "" )."\r\n\t\t\t".createinputhidden( "jenistampilan", "{$jenistampilan}", "" )."\r\n\t\t\t".createinputhidden( "nilaikosong", "{$nilaikosong}", "" )."\r\n \t\t\t".createinputhidden( "sp", "{$sp}", "" )."\r\n \t\t\t".createinputhidden( "penempatansemester", "{$penempatansemester}", "" )."\r\n \t\t\t".createinputhidden( "iscsv", "{$iscsv}", "" )."\r\n \t\t\t".createinputhidden( "kopsurat", "{$kopsurat}", "" )."\r\n \t\t\t".createinputhidden( "kompre", "{$kompre}", "" )."\r\n \t\t\t\t{$qinput} {$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
       
		}
        $totalsemua = 0;
        $bobotsemua = 0;
        $totals = "";
        $bobots = "";
        #echo "<form method='post' action='cetaktranskrip2.php' target='_blank'>";
        
        #echo "<br>&nbsp;&nbsp;<input type='submit' name='printbtn' value='Cetak' class=\"btn btn-brand\"><br><br>";
        #echo "\r\n \t\t\t<table {$border} class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr class=juduldata align=center>\r\n<td><input type='checkbox' name='chkall' id='chkall'></td>        <td>ID Mahasiswa</td>\r\n        <td>Nama Mahasiswa</td>\r\n        <td>Program Studi</td>\r\n        <td>Status Mahasiswa</td>\r\n        <td>Status Pindahan</td>\r\n        <td>Cetak Transkrip</td>\r\n      </tr>\r\n    ";
       echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover\">
							<thead>
								<tr class=juduldata align=center>\r\n<td><input type='checkbox' name='chkall' id='chkall'></td>        <td>ID Mahasiswa</td>\r\n        <td>Nama Mahasiswa</td>\r\n        <td>Program Studi</td>\r\n        <td>Status Mahasiswa</td>\r\n        <td>SK Pendirian</td>\r\n        <td>Cetak Ijazah</td>\r\n      </tr>
							</thead>
							<tbody>";
		$i = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            ++$i;
            $kelas = kelas( $i );
           # echo "\r\n        <tr {$kelas}>\r\n          <td>{$d['ID']}</td>\r\n          <td>{$d['NAMA']}</td>\r\n          <td>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n          <td>".$arraystatusmahasiswa[$d[STATUS]]."</td>\r\n          <td>".$arraystatusmhsbaru[$d[STPIDMSMHS]]."</td>\r\n          <td align=center nowrap><a target=_blank href='cetaktranskrip.php?idmhs={$d['ID']}&".$href2."'>cetak</a> | <a target=_blank href='cetaktranskrip.php?idmhs={$d['ID']}&".$href2."&pdf=1'>PDF</a></td>\r\n        </tr>\r\n        ";
	    echo "\r\n        <tr {$kelas}>\r\n <td> <input type='checkbox' class='chkbox' name='id[]' value='".$d["ID"]."' ></td><td>{$d['ID']}</td>\r\n          <td>{$d['NAMA']}</td>\r\n          <td>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n          <td>".$arraystatusmahasiswa[$d[STATUS]]."</td>\r\n          <td>".$arraystatusmhsbaru[$d[STPIDMSMHS]]."</td>\r\n          <td align=center nowrap><a target=_blank href='cetakijazah2.php?id={$d['ID']}&".$href2."'>cetak</a> </td>\r\n        </tr>\r\n        ";
        
	}
        #echo "</table></div></div>{$tpage} {$tpage2}</div></div></div>";
		echo "				</tbody>
						</table>
					</div>
				</div>				
			</div>";
		if($aksi !="cetak" && $jenisusers==0){
		echo "		<div class=\"tools\">										
						<div class=\"table-scrollable\">
							<table class=\"table table-striped table-bordered table-hover\">
								<tr>
									<td width=\"1%;\">
										<!--<input type='submit' name='printbtn' value='Cetak' class=\"btn btn-brand\">-->
									</td>
								</tr>
							</table>
						</div>
					</div>";
	}	
	echo "		</form>
			</div>
		</div>
		</div>
		</div>
		</div>";
    }
    else
    {
        $errmesg = "Data mahasiswa tidak ada";
        $aksi = "";
    }
}
?>
