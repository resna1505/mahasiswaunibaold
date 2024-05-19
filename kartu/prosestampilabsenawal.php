<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo "ksini";exit();
periksaroot( );
unset( $arraysort );
$arraysort[0] = "dosenpengajar.IDPRODI";
$arraysort[1] = "dosenpengajar.TAHUN";
$arraysort[2] = "dosenpengajar.SEMESTER";
$arraysort[3] = "makul.SEMESTER";
$arraysort[4] = "dosenpengajar.IDMAKUL";
$arraysort[5] = "dosenpengajar.IDDOSEN";
$arraysort[6] = "dosenpengajar.KELAS";
$arraysort[7] = "dosenpengajar.TAHUN,dosenpengajar.SEMESTER,dosenpengajar.IDDOSEN,dosenpengajar.IDMAKUL";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkanawal&datakuliah={$datakuliah}&jenis={$jenis}&kopsurat={$kopsurat}&";
if ( $jeniskelas != "" )
{
    $qjudul .= " Jenis Kelas '".$arraykelasstei["{$jeniskelas}"]."' <br>";
    $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
    $href .= "jeniskelas={$jeniskelas}&";
}
if ( $idprodi != "" )
{
    $qfield .= " AND dosenpengajar.IDPRODI='{$idprodi}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $iddosen != "" )
{
    $qfield .= " AND IDDOSEN LIKE '%{$iddosen}%'";
    $qjudul .= " NIDN Dosen mengandung kata '{$iddosen}' <br>";
    $qinput .= " <input type=hidden name=iddosen value='{$iddosen}'>";
    $href .= "iddosen={$iddosen}&";
}
if ( $idmakul != "" )
{
    $qfield .= " AND  dosenpengajar.IDMAKUL LIKE '%{$idmakul}%'";
    $qjudul .= " Kode Mata Kuliah mengandung kata '{$idmakul}' <br>";
    $qinput .= " <input type=hidden name=idmakul value='{$idmakul}'>";
    $href .= "idmakul={$idmakul}&";
}
if ( $tahun != "" )
{
    $qfield .= " AND dosenpengajar.TAHUN = '{$tahun}'";
    $qjudul .= " Tahun Akademik '".( $tahun - 1 )."/{$tahun}' <br>";
    $qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
    $href .= "tahun={$tahun}&";
}
if ( $semester != "" )
{
    $qfield .= " AND dosenpengajar.SEMESTER = '{$semester}'";
    $qjudul .= " Semester ".$arraysemester[$semester]." <br>";
    $qinput .= " <input type=hidden name=semester value='{$semester}'>";
    $href .= "semester={$semester}&";
}
if ( $kelas != "" )
{
    $qfield .= " AND dosenpengajar.KELAS = '{$kelas}'";
    $qjudul .= " Kelas '".$arraylabelkelas[$kelas]."' <br>";
    $qinput .= " <input type=hidden name=kelas value='{$kelas}'>";
    $href .= "kelas={$kelas}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 7;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML  \r\n\tFROM dosenpengajar,makul,dosen,tbkmk,mspst \r\n\tWHERE 1=1 {$qprodideptbkmk}\r\n\tAND tbkmk.KDKMKTBKMK=makul.ID\r\n\tAND tbkmk.KDKMKTBKMK=dosenpengajar.IDMAKUL\r\n  AND dosenpengajar.THSHM = tbkmk.THSMSTBKMK\r\n\tAND dosen.ID=dosenpengajar.IDDOSEN \r\n\tAND dosenpengajar.IDPRODI=mspst.IDX\r\n\tAND makul.IDPRODI=mspst.IDX\r\n\tAND mspst.KDPSTMSPST=tbkmk.KDPSTTBKMK\r\n\tAND mspst.KDJENMSPST=tbkmk.KDJENTBKMK\r\n\t{$qfield}\r\n \r\n\t";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d['JML'];
$first = 0;
include( "../paginating.php" );
$q = "SELECT tbkmk.SEMESTBKMK AS SEMESTERMAKUL,\r\n dosenpengajar.*,tbkmk.NAKMKTBKMK AS NAMAMAKUL,dosen.NAMA AS NAMADOSEN \r\n\tFROM dosenpengajar,makul,dosen,tbkmk,mspst \r\n\tWHERE 1=1 {$qprodideptbkmk}\r\n\tAND tbkmk.KDKMKTBKMK=makul.ID\r\n\tAND tbkmk.KDKMKTBKMK=dosenpengajar.IDMAKUL\r\n  AND dosenpengajar.THSHM = tbkmk.THSMSTBKMK\r\n\tAND dosen.ID=dosenpengajar.IDDOSEN \r\n\tAND dosenpengajar.IDPRODI=mspst.IDX\r\n \tAND mspst.KDPSTMSPST=tbkmk.KDPSTTBKMK\r\n\tAND mspst.KDJENMSPST=tbkmk.KDJENTBKMK\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
									
	if ( $aksi != "cetak" )
        {
		printmesg( $errmesg );
		printtitle("Data Mata Kuliah");
		printtitle( $qjudul );
		echo " {$tpage} {$tpage2}";
			echo "	<form target=_blank action='cetakmatakuliah.php'>
						<div class=\"table-scrollable\">
							<table class=\"table table-striped table-bordered table-hover\">
								<tr>
									<td>
										<input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak'>";

		echo "\r\n \t\t\t\t{$qinput} \t\t\t\t{$input}</td></tr></table></div></form>";

	}else{
	
		printjudulmenucetak( "Data Mata Kuliah" );
        	printmesgcetak( $qjudul );

	}

	echo "							<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
	
													<tr class=juduldata{$aksi} align=center>
														<td>No</td>
														<td><a class='{$cetak}' href='{$href}"."&sort=0'>Prodi</td>
														<td><a class='{$cetak}' href='{$href}"."&sort=1'>Tahun Akademik  </td>
														<td><a class='{$cetak}' href='{$href}"."&sort=2'>Se<br>mes<br>ter</td>
														<td><a class='{$cetak}' href='{$href}"."&sort=3'>Semes<br>ter<br>M-K</td>
														<td><a class='{$cetak}' href='{$href}"."&sort=4'>Kode Mata Kuliah</td>
														<td>Nama Mata Kuliah</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>NIP</td>
														<td>Dosen Pengajar</td>
														<td><a class='{$cetak}' href='{$href}"."&sort=6'>Kelas</td>";
														if ( $aksi != "cetak" )
        													{
														echo "\r\n\t\t\t\t\t\t\t<td nowrap  >Cetak</td>";
														}
	
    if ( $jenis == "UTS" || $jenis == "UAS" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap  >Cetak Berita Acara</td>\t\t\t\t\t\t\t";
    }
    echo "												</tr> 
													</thead>
													<tbody>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}><td>{$i}</td><td align=left nowrap>".$arrayprodidep[$d[IDPRODI]]." {$d['IDPRODI']} </td><td align=left>".( $d[TAHUN] - 1 )."/{$d['TAHUN']}</td>\r\n \t\t\t\t\t<td  >".$arraysemester[$d[SEMESTER]]."</td>\r\n \t\t\t\t\t<td  >{$d['SEMESTERMAKUL']}</td>\r\n \t\t\t\t\t<td align=left>{$d['IDMAKUL']}</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NAMAMAKUL']}</td><td align=left>{$d['IDDOSEN']}</td><td align=left nowrap>{$d['NAMADOSEN']}</td><td nowrap >".$arraylabelkelas[$d[KELAS]]."</td>\r\n\t\t\t\t\t\r\n \t\t\t\t\t";
        if ( $aksi != "cetak" )
        {
	echo "<td align=center><a href='index.php?pilihan={$pilihan}&aksi=formtambah&idprodiupdate={$d['IDPRODI']}&idmakulupdate={$d['IDMAKUL']}&iddosenupdate={$d['IDDOSEN']}&tahunupdate={$d['TAHUN']}&semesterupdate={$d['SEMESTER']}&kelasupdate={$d['KELAS']}&jenis={$jenis}&datakuliah={$datakuliah}&kopsurat={$kopsurat}&jeniskelas={$jeniskelas}'>Cetak</td>";
        	if ( $jenis == "UTS" || $jenis == "UAS" )
        	{
            	echo "<td   align=center><a href='index.php?pilihan={$pilihan}&aksi=beritaacara&idprodiupdate={$d['IDPRODI']}&idmakulupdate={$d['IDMAKUL']}&iddosenupdate={$d['IDDOSEN']}&tahunupdate={$d['TAHUN']}&semesterupdate={$d['SEMESTER']}&kelasupdate={$d['KELAS']}&jenis={$jenis}&datakuliah={$datakuliah}&kopsurat={$kopsurat}&jeniskelas={$jeniskelas}'>Cetak Berita Acara</td>\r\n \t\t\t\t\t\t\t\t";
        	}
	}
        echo "</tr>";
        ++$i;
    }
    #echo "</table></div></div>{$tpage} {$tpage2}</div></div></div>";
	echo "								</tbody>
									</table>
								</div>
						</div>
					</div>
					<!--end::Portlet-->			
		</div>
		<!--end::md-12-->	
	</div>
	<!--end::row-->	
</div>
<!--end::container-fluid-->";
}
else
{
    $errmesg = "Data Mata Kuliah Tidak Ada";
    $aksi = "";
}
?>
