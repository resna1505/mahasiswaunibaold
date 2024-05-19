<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo "aaa";exit();
periksaroot( );
unset( $arraysort );
$arraysort[0] = "dosenpengajar.IDPRODI";
$arraysort[1] = "dosenpengajar.TAHUN";
$arraysort[2] = "dosenpengajar.SEMESTER";
$arraysort[3] = "makul.SEMESTER";
$arraysort[4] = "dosenpengajar.IDMAKUL";
$arraysort[5] = "dosenpengajar.IDDOSEN";
$arraysort[6] = "dosenpengajar.KELAS";
$arraysort[7] = "dosenpengajar.TAHUN,dosenpengajar.SEMESTER,IDDOSEN,dosenpengajar.IDMAKUL";
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
    $qjudul .= " NIDN Dosen mengandung '{$iddosen}' <br>";
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
$q = "SELECT COUNT(*) AS JML FROM dosenpengajar,makul,dosen \r\n\tWHERE 1=1 {$qprodidep4}\r\n\tAND dosen.ID=dosenpengajar.IDDOSEN \r\n\tAND makul.ID=dosenpengajar.IDMAKUL\r\n\t{$qfield}\r\n  {$qfieldx2}\r\n\t";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
$first = 0;
include( "../paginating.php" );
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT makul.SEMESTER AS SEMESTERMK,\r\n\t dosenpengajar.*,\r\n\t makul.NAMA AS NAMAMAKUL,dosen.NAMA AS NAMADOSEN \r\n\tFROM dosenpengajar,makul,dosen \r\n\tWHERE 1=1 {$qprodidep4}\r\n\tAND dosen.ID=dosenpengajar.IDDOSEN \r\n\tAND makul.ID=dosenpengajar.IDMAKUL\r\n\t{$qfield}\r\n {$qfieldx2}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
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
    #if ( $aksi != "cetak" )
    #{
        #printjudulmenu( "Data Mata Kuliah" );
    #    printmesg( $qjudul );
    #}
    #else
    #{
        #printjudulmenucetak( "Data Mata Kuliah" );
       # printmesgcetak( $qjudul );
    #}
    /*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Data Mata Kuliah </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
	#echo "						{$tpage} {$tpage2}";
	
	echo "						<div class=\"caption\">";
												printmesg("Data Mata Kuliah");
		echo "						</div>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Prodi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Tahun Akademik</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Semester </td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Semester M-K</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Kode Mata Kuliah</td>\r\n\t\t\t\t<td>Nama Mata Kuliah</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>NIP</td>\r\n \t\t\t\t<td>Nama Dosen</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=6'>Kelas</td>\r\n\t\t\t\t";
    if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap  >Edit Komponen Nilai</td>\r\n\t\t\t\t\t\t\t";
    }
    #echo "\r\n\t\t\t</tr>\r\n\t\t";
	echo "			</tr> 
				</thead>
					<tbody>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $styleerror = "";
        $errornamakurikulum = "";
        $namamakulkurikulum = getnamamk( "{$d['IDMAKUL']}", "".( $d[TAHUN] - 1 )."{$d['SEMESTER']}", $d[IDPRODI] );
        if ( $namamakulkurikulum == "" )
        {
            $styleerror = "style='background-color:#ffaaaa'";
            $errornamakurikulum = "".IKONWARNING." tidak ada di kurikulum";
        }
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi} {$styleerror}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n \t\t\t\t\t<td align=left nowrap>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n   \t\t\t\t<td align=center>".( $d[TAHUN] - 1 )."/{$d['TAHUN']}</td>\r\n \t\t\t\t\t<td  >".$arraysemester[$d[SEMESTER]]."</td>\r\n \t\t\t\t\t<td  >{$d['SEMESTERMK']}</td>\r\n \t\t\t\t\t<td align=left>{$d['IDMAKUL']}</td>\r\n \t\t\t\t\t<td align=left nowrap> {$namamakulkurikulum} {$errornamakurikulum}</td>\r\n   \t\t\t\t<td align=left>{$d['IDDOSEN']}</td>\r\n   \t\t\t\t<td align=left nowrap>{$d['NAMADOSEN']}</td>\r\n \t\t\t\t\t<td >".$arraylabelkelas[$d[KELAS]]."</td>\r\n\t\t\t\t\t\r\n \t\t\t\t\t";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "\r\n\t\t\t\t\t\t\t\t<td   align=center>\r\n\t\t\t\t\t\t\t\t<a class=\"btn green\" href='index.php?pilihan={$pilihan}&\r\n\t\t\t\t\t\t\t\taksi=formtambah&\r\n\t\t\t\t\t\t\t\tidmakulupdate={$d['IDMAKUL']}&\r\n\t\t\t\t\t\t\t\tiddosenupdate={$d['IDDOSEN']}&\r\n\t\t\t\t\t\t\t\ttahunupdate={$d['TAHUN']}&\r\n\t\t\t\t\t\t\t\tsemesterupdate={$d['SEMESTER']}&\r\n\t\t\t\t\t\t\t\tkelasupdate={$d['KELAS']}&idprodiupdate={$d['IDPRODI']}'><i class=\"fa fa-edit\" ></i></td>\r\n \t\t\t\t\t\t\t\t";
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    #echo "</table></div></div>{$tpage} {$tpage2}</div></div></div>";
	echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				</div>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->
		</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>";
}
else
{
    $errmesg = "Data Mata Kuliah Tidak Ada";
    $aksi = "tambahawal";
}
?>
