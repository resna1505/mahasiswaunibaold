<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#print_r($_SESSION);
echo "<style type=\"text/css\">\n\t.form {\n\t\tborder-top:1px solid #D5D5D5;\n\t\tborder-right:1px solid #D5D5D5;\n\t\t}\n\t\t\n\t.form td {\n\t\tborder-bottom:1px solid #D5D5D5;\n\t\tborder-left:1px solid #D5D5D5;\n\t\t}\n</style>\n\n";
periksaroot( );
unset( $arraysort );
$arraysort[0] = "jadwalkuliah.IDMAKUL";
$arraysort[1] = "jadwalkuliah.KELAS";
$arraysort[2] = "jadwalkuliah.IDRUANGAN";
#$arraysort[3] = "jadwalkuliah.HARI";
$arraysort[3] = "jadwalkuliah.TANGGAL";
$arraysort[4] = "jadwalkuliah.MULAI";
$arraysort[5] = "jadwalkuliah.SELESAI";
$arraysort[6] = "jadwalkuliah.RENCANA";
$arraysort[7] = "jadwalkuliah.TIM";
$arraysort[8] = "jadwalkuliah.IDPRODI";
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&sessid={$token}&asal={$asal}&";
if ( $jenisusers == 1 && $caridosen == 1 )
{
    $qfield .= " AND jadwalkuliah.TIM LIKE '%{$users}%'";
    $qjudul .= " NIDN Dosen  {$users} <br>";
    $qinput .= " <input type=hidden name=caridosen value='{$caridosen}'>";
    $href .= "caridosen={$caridosen}&";
}
if ( $semester != "" )
{
    $qfield .= " AND jadwalkuliah.SEMESTER='{$semester}'";
    $qjudul .= " Semester  ".$arraysemester[$semester]."  <br>";
    $qinput .= " <input type=hidden name=semester id=semester value='{$semester}'>";
    $href .= "semester={$semester}&";
}
if ( $tahun != "" )
{
	$thntrnlm=($tahun-1).$semester;
    #$qfield .= " AND jadwalkuliah.TAHUN='{$tahun}' AND trnlm.THSMSTRNLM='{$thntrnlm}'";
    $qfield .= " AND jadwalkuliah.TAHUN='{$tahun}'";	
    $qjudul .= " Tahun Akademik  ".( $tahun - 1 )."/{$tahun}  <br>";
    $qinput .= " <input type=hidden name=tahun id=tahun value='{$tahun}'>";
    $href .= "tahun={$tahun}&";
}
if ( $iddepartemen != "" )
{
    $qfield .= " AND jadwalkuliah.IDPRODI='{$iddepartemen}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$iddepartemen]."' <br>";
    $qinput .= " <input type=hidden name=iddepartemen id=iddepartemen value='{$iddepartemen}'>";
    $href .= "iddepartemen={$iddepartemen}&";
}
if ( $makul != "" )
{
    $qfield .= " AND IDMAKUL = '{$makul}'";
    $qjudul .= " ID MAKUL = {$makul} (".getnamafromtabel( $makul, "makul" ).") <br>";
    $qinput .= " <input type=hidden name=makul id=makul value='{$makul}'>";
    $href .= "makul={$makul}&";
}
if ( $kelasjadwal != "" )
{
    $qfield .= " AND KELAS = '{$kelasjadwal}'";
    $qjudul .= " Kelas = '".$arraylabelkelas[$kelasjadwal]."' <br>";
    $qinput .= " <input type=hidden name=kelasjadwal id=kelasjadwal value='{$kelasjadwal}'>";
    $href .= "kelasjadwal={$kelasjadwal}&";
}
if ( $tanggal != "" )
{
    $qfield .= " AND TANGGAL='{$tanggal}'";
    $qjudul .= " TANGGAL {$tanggal} <br>";
    $qinput .= " <input type=hidden name=tanggal id=tanggal value='{$tanggal}'>";
    $href .= "tanggal={$tanggal}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
#$q = "SELECT jadwalkuliah.* \n   FROM jadwalkuliah \n\t WHERE 1=1  \n\t {$qfield}\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
$q = "SELECT jadwalkuliah.*,COUNT( trnlm.NIMHSTRNLM) AS PESERTA FROM jadwalkuliah 
LEFT JOIN trnlm ON jadwalkuliah.IDMAKUL=trnlm.KDKMKTRNLM WHERE 1=1  \n\t {$qfield} GROUP BY IDPRODI,IDMAKUL,MULAI ORDER BY ".$arraysort[$sort]." {$qlimit}";

/*$q="SELECT jadwalkuliah.*,COUNT( trnlm.NIMHSTRNLM) AS PESERTA,msdos.NMDOSMSDOS AS NMDOSEN,tbkmk.NAKMKTBKMK AS NMMAKUL,tbkmk.SKSMKTBKMK AS SKSMAKUL
			FROM jadwalkuliah LEFT JOIN trnlm ON jadwalkuliah.IDMAKUL=trnlm.KDKMKTRNLM JOIN msdos ON msdos.NIDNNMSDOS=jadwalkuliah.TIM 
			JOIN tbkmk ON tbkmk.KDKMKTBKMK=jadwalkuliah.IDMAKUL WHERE 1=1 {$qfield} GROUP BY MULAI,TANGGAL ORDER BY jadwalkuliah.TANGGAL DESC";
*/
#echo $q;
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">";
    
    if ( $aksi != "cetak" && $_SESSION['asal'] != "depan" )
    {
		printmesg( "Data Jadwal Kuliah" );
        printmesg( $errmesg );
        printmesg( $qjudul );
		echo "						<div class=\"tools\">
										<form action=index.php method=post>".createinputhidden( "pilihan", "updatedata", "" )."
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<!--<input type=submit class=\"btn btn-brand\" value='Update to Payroll'>&nbsp;-->
														<input type='button' class=\"btn btn-brand\" value='Export ke Excel' id='exceljadwal'>
														{$qinput}\n \t\t\t\t{$input}
													</td>
												</tr>
											</table>
											</div>
										</form>
									</div>{$tpage} {$tpage2}";
        
    }
    /*echo "\n \t\t\t<table class=form{$aksi} cellpadding=0 cellspacing=0 width=80%>\n\t\t\t<tr align=center>\n\t\t\t\t<td>No</td>\n \n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=8'>Prodi</td>\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Kode MK</td>\n\t\t\t\t<td>Mata Kuliah</td>\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Kelas</td>\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Ruangan</td>\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Hari</td>\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Jam Mulai</td>\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Jam Selesai</td>\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=6'>Rencana<br>Tatap<br>Muka</td><td>Peserta</td>\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=7'>Tim<br>Pengajar</td>\n\t\t\t ";
    */
	echo "							<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr align=center><td>No</td>\n \n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=8'>Prodi</td>\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Kode MK</td>\n\t\t\t\t<td>Mata Kuliah</td>\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Kelas</td>\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Ruangan</td>\n\t\t\t\t<td>Tanggal</td>\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Jam Mulai</td>\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Jam Selesai</td>\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=6'>Rencana<br>Tatap<br>Muka</td><td><a class='{$cetak}' href='{$href}"."&sort=7'>Tim<br>Pengajar</td>\n\t\t\t ";
    
	if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\n\t\t\t\t\t\t\t<td nowrap colspan=3  >Aksi</td>\n\t\t\t\t\t\t\t";
    }
    #echo "\n\t\t\t</tr>\n\t\t";
	echo "												</tr> 
													</thead>
													<tbody>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $tmp = explode( "\n", $d['TIM'] );
        $timpengajar = "";
		$tanggalajar=explode( "-", $d['TANGGAL'] );
		$tanggalajar=$tanggalajar['2']."-".$tanggalajar['1']."-".$tanggalajar['0'];
        foreach ( $tmp as $k => $v )
        {
            $timpengajar .= "{$v} / ".getfield( "NAMA", "dosen", "WHERE ID='".trim( $v )."'" )."<br>";
        }
        
		echo "\n\t\t\t\t<tr valign=top align=center>\n\t\t\t\t\t<td>{$i}</td>\n \t\t\t\t \n  \t\t\t\t\t<td align=left> ".$arrayprodidep[$d['IDPRODI']]."</td>\n  \t\t\t\t\t<td align=left> {$d['IDMAKUL']}</td>\n \t\t\t\t\t<td align=left  >".getnamafromtabel( $d['IDMAKUL'], "makul" )."</td>\n  \t\t\t\t\t<td nowrap> ".$arraylabelkelas[$d['KELAS']]."</td>\n \t\t\t\t\t<td nowrap>".$arrayruangan[$d['IDRUANGAN']]."</td>\n \t\t\t\t\t<td nowrap>".$tanggalajar."</td>\n  \t\t\t\t\t<td > {$d['MULAI']}</td>\n  \t\t\t\t\t<td > {$d['SELESAI']}</td>\n  \t\t\t\t\t<td > {$d['RENCANA']}</td><td align=left> {$timpengajar}</td>\n \t\t\t\t ";
        
		if ( $tingkataksesusers[$kodemenu] == "T" )
        {
			if($jenisusers==2){
			
			    echo "\n\t\t\t\t\t\t\t\t<td   align=center><td   align=center><a alt='Klik di sini untuk menentukan tanggal-tanggal kuliah berdasarkan Jadwal Kuliah untuk kepentingan absensi' href='index.php?pilihan=detiljadwal&idupdate={$d['ID']}'>Detil Tanggal Jadwal</td>";
        	
			}else{
			    echo "\n\t\t\t\t\t\t\t\t<td   align=center><a href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}'>".IKONUPDATE."</td><td   align=center ><a onclick=\"return confirm('Hapus Data Jadwal Kuliah  ? ');\" href='index.php?pilihan={$pilihan}&aksi=hapus&idhapus={$d['ID']}&sessid={$_SESSION['token']}'>".IKONHAPUS."</td>\n\n\t\t\t\t\t\t\t\t<td   align=center><a alt='Klik di sini untuk menentukan tanggal-tanggal kuliah berdasarkan Jadwal Kuliah untuk kepentingan absensi' href='index.php?pilihan=detiljadwal&idupdate={$d['ID']}'>Detil Tanggal Jadwal</td><td   align=center><a href='index.php?pilihan=copyjadwal&idupdate={$d['ID']}'>Copy Jadwal</td>";
        	
			}
        }
        echo "\n\t\t\t\t</tr>\n\t\t\t";
        ++$i;
    }
    #echo "</table>";
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
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Jadwal Kuliah Tidak Ada";
    $aksi = "";
}
?>
