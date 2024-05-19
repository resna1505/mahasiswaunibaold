<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

unset( $arraysort );
$arraysort[0] = "dosenpengajar.TAHUN";
$arraysort[1] = "dosenpengajar.SEMESTER";
$arraysort[2] = "makul.SEMESTER";
$arraysort[3] = "dosenpengajar.IDMAKUL";
$arraysort[4] = "dosenpengajar.IDDOSEN";
$arraysort[5] = "dosenpengajar.KELAS";
$tmp = explode( "-", $tahunsemester );
$tahun = $tmp[0];
$semester = $tmp[1];
$href = "index.php?pilihan={$pilihan}&aksi=tampilkanawal&";
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
    $qjudul .= " NIP Dosen mengandung '{$iddosen}' <br>";
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
    $qjudul .= " Tahun Ajaran '".( $tahun - 1 )." / {$tahun}' <br>";
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
    $sort = 3;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM dosenpengajar, dosen \r\n\tWHERE 1=1\r\n\tAND dosen.ID=dosenpengajar.IDDOSEN  \r\n\t{$qfield}\r\n\t";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
$q = "SELECT  \r\n\t dosenpengajar.*, dosen.NAMA AS NAMADOSEN \r\n\tFROM dosenpengajar, dosen \r\n\tWHERE 1=1\r\n\tAND dosen.ID=dosenpengajar.IDDOSEN  \r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
echo $q;
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
        #printjudulmenu( "Data Mata Kuliah" );
        #echo "{$tpage} {$tpage2}";
        printmesg( $qjudul );
		printmesg( $errmesg );
		#echo "	{$tpage} {$tpage2}";
    }
    /*else
    {
        printjudulmenucetak( "Data Mata Kuliah" );
        printmesgcetak( $qjudul );
    }*/
	#echo "\r\n \t\t<br>\r\n \t\t\t<table {$border} class=form{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Tahun Ajaran</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Semester </td>\r\n\t\t\t<!-- \t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Semes<br>ter<br>M-K</td> -->\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Kode Mata Kuliah</td>\r\n\t\t\t\t<td>Nama Mata Kuliah</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>NIP</td>\r\n \t\t\t\t<td>Nama Dosen</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Kelas</td>\r\n\t\t\t\t";
    echo "						<div class=\"caption\">";
												printmesg("Data Mata Kuliah");
		echo "						</div>{$tpage} {$tpage2}
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Tahun Ajaran</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Semester </td>\r\n\t\t\t<!-- \t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Semes<br>ter<br>M-K</td> -->\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Kode Mata Kuliah</td>\r\n\t\t\t\t<td>Nama Mata Kuliah</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>NIP</td>\r\n \t\t\t\t<td>Nama Dosen</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Kelas</td>\r\n\t\t\t\t";
	if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap  >Upload<br>Bahan<br>Kuliah</td>\r\n\t\t\t\t\t\t\t";
    }
    #echo "\r\n\t\t\t</tr>\r\n\t\t";
	echo "			</tr> 
				</thead>
					<tbody>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        #echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n   \t\t\t\t<td align=left>".( $d[TAHUN] - 1 )."/{$d['TAHUN']}</td>\r\n \t\t\t\t\t<td  >".$arraysemester[$d[SEMESTER]]."</td>\r\n \t\t\t\t\t<!-- <td  >{$d['SEMESTERMK']}</td> -->\r\n \t\t\t\t\t<td align=left>{$d['IDMAKUL']}</td>\r\n \t\t\t\t\t<td align=left nowrap>".@getnamamksp( @$d[IDMAKUL], @( @$d[TAHUN] - 1 ).@"{$d['SEMESTER']}", @$d[IDPRODI] )."</td>\r\n   \t\t\t\t<td align=left>{$d['IDDOSEN']}</td>\r\n   \t\t\t\t<td align=left nowrap>{$d['NAMADOSEN']}</td>\r\n \t\t\t\t\t<td >".$arraylabelkelas[$d[KELAS]]."</td>\r\n\t\t\t\t\t\r\n \t\t\t\t\t";
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n   \t\t\t\t<td align=left>".( $d[TAHUN] - 1 )."/{$d['TAHUN']}</td>\r\n \t\t\t\t\t<td  >".$arraysemester[$d[SEMESTER]]."</td>\r\n \t\t\t\t\t<!-- <td  >{$d['SEMESTERMK']}</td> -->\r\n \t\t\t\t\t<td align=left>{$d['IDMAKUL']}</td>\r\n \t\t\t\t\t<td align=left nowrap>".@getnamamk( @$d[IDMAKUL], @( @$d[TAHUN] - 1 ).@"{$d['SEMESTER']}", @$d[IDPRODI] )."</td>\r\n   \t\t\t\t<td align=left>{$d['IDDOSEN']}</td>\r\n   \t\t\t\t<td align=left nowrap>{$d['NAMADOSEN']}</td>\r\n \t\t\t\t\t<td >".$arraylabelkelas[$d[KELAS]]."</td>\r\n\t\t\t\t\t\r\n \t\t\t\t\t";
        
		if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "\r\n\t\t\t\t\t\t\t\t<td   align=center>\r\n\t\t\t\t\t\t\t\t<a href='index.php?pilihan={$pilihan}&\r\n\t\t\t\t\t\t\t\taksi=formtambah&\r\n\t\t\t\t\t\t\t\tidmakulupdate={$d['IDMAKUL']}&\r\n\t\t\t\t\t\t\t\tiddosenupdate={$d['IDDOSEN']}&\r\n\t\t\t\t\t\t\t\ttahunupdate={$d['TAHUN']}&\r\n\t\t\t\t\t\t\t\tsemesterupdate={$d['SEMESTER']}&\r\n\t\t\t\t\t\t\t\tkelasupdate={$d['KELAS']}&idprodiupdate={$d['IDPRODI']}'>Edit</td>\r\n \t\t\t\t\t\t\t\t";
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    #echo "</table>";
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
}
else
{
    $errmesg = "Data Mata Kuliah Tidak Ada";
    $aksi = "tambahawal";
}
?>
