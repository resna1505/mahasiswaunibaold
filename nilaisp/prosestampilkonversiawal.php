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
$arraysort[0] = "dosenpengajarsp.TAHUN";
$arraysort[1] = "dosenpengajarsp.SEMESTER";
$arraysort[2] = "makul.SEMESTER";
$arraysort[3] = "dosenpengajarsp.IDMAKUL";
$arraysort[4] = "dosenpengajarsp.IDDOSEN";
$arraysort[5] = "dosenpengajarsp.KELAS";
$arraysort[6] = "dosenpengajarsp.TAHUN,dosenpengajarsp.IDDOSEN,dosenpengajarsp.IDMAKUL";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkanawal&";
if ( $iddosen != "" )
{
    $qfield .= " AND IDDOSEN LIKE '%{$iddosen}%'";
    $qjudul .= " NIDN Dosen mengandung '{$iddosen}' <br>";
    $qinput .= " <input type=hidden name=iddosen value='{$iddosen}'>";
    $href .= "iddosen={$iddosen}&";
}
if ( $idmakul != "" )
{
    $qfield .= " AND  dosenpengajarsp.IDMAKUL LIKE '%{$idmakul}%'";
    $qjudul .= " Kode Mata Kuliah mengandung kata '{$idmakul}' <br>";
    $qinput .= " <input type=hidden name=idmakul value='{$idmakul}'>";
    $href .= "idmakul={$idmakul}&";
}
if ( $tahun != "" )
{
    $qfield .= " AND dosenpengajarsp.TAHUN = '{$tahun}'";
    $qjudul .= " Tahun Akademik '{$tahun}' <br>";
    $qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
    $href .= "tahun={$tahun}&";
}
if ( $semester != "" )
{
    $qfield .= " AND dosenpengajarsp.SEMESTER = '{$semester}'";
    $qjudul .= " Semester ".$arraysemester[$semester]." <br>";
    $qinput .= " <input type=hidden name=semester value='{$semester}'>";
    $href .= "semester={$semester}&";
}
if ( $kelas != "" )
{
    $qfield .= " AND dosenpengajarsp.KELAS = '{$kelas}'";
    $qjudul .= " Kelas '{$kelas}' <br>";
    $qinput .= " <input type=hidden name=kelas value='{$kelas}'>";
    $href .= "kelas={$kelas}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 6;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
if ( $jenisusers == 1 )
{
    $qfield .= "AND dosenpengajar.IDDOSEN='{$users}' ";
}
$q = "SELECT makul.SEMESTER AS SEMESTERMAKUL,\r\n\t dosenpengajarsp.*,makul.NAMA AS NAMAMAKUL,dosen.NAMA AS NAMADOSEN \r\n\tFROM dosenpengajarsp,makul,dosen \r\n\tWHERE 1=1\r\n\tAND dosen.ID=dosenpengajarsp.IDDOSEN \r\n\tAND makul.ID=dosenpengajarsp.IDMAKUL\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]."";
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
        #printmesg( $qjudul );
    }
    else
    {
        #printjudulmenucetak( "Data Mata Kuliah" );
        #printmesgcetak( $qjudul );
    }
    echo "						<div class=\"caption\">";
												printmesg($qjudul);
	echo "						</div>
								<div class=\"caption\">";
										printmesg("Data Mata Kuliah");
	echo "						</div>
								<div class=\"m-portlet\">			
									<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>";
    echo "												<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=0'>Tahun Akademik</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=1'>Se<br>mes<br>ter</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=2'>Semes<br>ter<br>M-K</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=3'>Kode Mata Kuliah</td>\r\n\t\t\t\t<td>Nama Mata Kuliah</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=4'>NIP</td>\r\n \t\t\t\t<td>Nama Dosen</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=5'>Kelas</td>\r\n\t\t\t\t";
    if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap  >Edit<br>Kon<br>versi<br>Nilai</td>\r\n\t\t\t\t\t\t\t";
    }
    #echo "\r\n\t\t\t</tr>\r\n\t\t";
	echo "			</tr> 
				</thead>
					<tbody>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n   \t\t\t\t<td align=left>".( $d[TAHUN] - 1 )."/{$d['TAHUN']}</td>\r\n \t\t\t\t\t<td  >".$arraysemester[$d[SEMESTER]]."</td>\r\n \t\t\t\t\t<td  >{$d['SEMESTERMAKUL']}</td>\r\n \t\t\t\t\t<td align=left>{$d['IDMAKUL']}</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NAMAMAKUL']}</td>\r\n   \t\t\t\t<td align=left>{$d['IDDOSEN']}</td>\r\n   \t\t\t\t<td align=left nowrap>{$d['NAMADOSEN']}</td>\r\n \t\t\t\t\t<td >{$d['KELAS']}</td>\r\n\t\t\t\t\t\r\n \t\t\t\t\t";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "\r\n\t\t\t\t\t\t\t\t<td   align=center>\r\n\t\t\t\t\t\t\t\t<a class=\"btn green\" href='index.php?pilihan={$pilihan}&\r\n\t\t\t\t\t\t\t\taksi=formtambah&&tab={$tab}&idmakulupdate={$d['IDMAKUL']}&\r\n\t\t\t\t\t\t\t\tiddosenupdate={$d['IDDOSEN']}&\r\n\t\t\t\t\t\t\t\ttahunupdate={$d['TAHUN']}&\r\n\t\t\t\t\t\t\t\tsemesterupdate={$d['SEMESTER']}&\r\n\t\t\t\t\t\t\t\tkelasupdate={$d['KELAS']}'><i class=\"fa fa-edit\"></i></td>\r\n \t\t\t\t\t\t\t\t";
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    #echo "</table></div></div></div></div></div>";
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
			</div>";
}
else
{
    $errmesg = "Data Mata Kuliah Tidak Ada";
    $aksi = "tambahawal";
}
?>
