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
$arraysort[0] = "mahasiswa.IDPRODI";
$arraysort[1] = "mahasiswa.ANGKATAN";
$arraysort[2] = "mahasiswa.ID";
$arraysort[3] = "mahasiswa.NAMA";
$arraysort[4] = "mahasiswa.STATUS";
$arraysort[5] = "mahasiswa.IDDOSEN";
$arraysort[6] = "SKS";
if ( $_SESSION['token'] != $_POST['sessid'] )
{
    echo $errmesg = token_err_mesg( "Transfer Nilai SP", SIMPAN_DATA );
    $aksi = "";
}
else
{
    unset( $_SESSION['token'] );
    $vld[] = cekvaliditasthnajaran( "Tahun Akademik", $thn, $semester );
    $vld[] = cekvaliditaskode( "Dosen", $iddosen );
    $vld[] = cekvaliditastahun( "Angkatan", $angkatan );
    $vld[] = cekvaliditaskode( "NIM", $id );
    $vld[] = cekvaliditasnama( "Nama", $nama );
    $vld[] = cekvaliditaskode( "Status", $status );
    $vld = array_filter( $vld, "filter_not_empty" );
    if ( isset( $vld ) && 0 < count( $vld ) )
    {
        $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
        unset( $vld );
        $aksi = "";
    }
    else
    {
        $href = "index.php?pilihan={$pilihan}&aksi=tampilkan&tahun={$tahun}&semester={$semester}&";
        if ( $idprodi != "" )
        {
            $qfield .= " AND mahasiswa.IDPRODI='{$idprodi}'";
            $qjudul .= " Jurusan/Program Studi '".$arrayprodi[$idprodi]."' <br>";
            $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
            $href .= "idprodi={$idprodi}&";
        }
        if ( $iddosen != "" )
        {
            $qfield .= " AND mahasiswa.IDDOSEN='{$iddosen}'";
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
        if ( $arraysort[$sort] == "" )
        {
            $sort = 2;
        }
        $qinput .= " <input type=hidden name=sort value='{$sort}'>";
        $q = "SELECT SUM(pengambilanmksp.SKSMAKUL) AS SKS,\r\n  mahasiswa.ID,mahasiswa.NAMA,IDPRODI,ANGKATAN,STATUS,IDDOSEN \r\n  FROM mahasiswa , pengambilanmksp\r\n\tWHERE 1=1 \r\n  AND\r\n  mahasiswa.ID=pengambilanmksp.IDMAHASISWA AND\r\n  pengambilanmksp.TAHUN='{$tahun}' AND\r\n  pengambilanmksp.SEMESTER='{$semester}'\r\n  \r\n  {$qprodidep2}\r\n\t{$qfield}\r\n\tGROUP BY mahasiswa.ID\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            /*if ( $aksi != "cetak" )
            {
                printjudulmenu( "Proses Transfer Nilai SP" );
                printmesg( "Semester/Tahun Akademik SP: ".$arraysemester[$semester]." ".( $tahun - 1 )."/{$tahun} <br>".$qjudul );
            }
            else
            {
                printjudulmenucetak( "Proses Transfer Nilai SP" );
                printmesgcetak( "Semester/Tahun Akademik: ".$arraysemester[$semester]." ".( $tahun - 1 )."/{$tahun} <br>".$qjudul );
            }*/
			echo "			<div class=\"page-content\">
								<div class=\"container-fluid\">
									<div class=\"row\">
										<div class=\"col-md-12\">
											<div class=\"portlet light\">
												<div class='portlet box blue'>
													<div class=\"portlet-title\">";
			echo "										<div class=\"caption\">";
															printmesg("Proses Transfer Nilai SP");
															printmesg("Semester/Tahun Akademik: ".$arraysemester[$semester]." ".( $tahun - 1 )."/{$tahun} <br>".$qjudul);
			echo "										</div>";
            #echo "\r\n \t\t\t<table {$border} class=form{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Jurusan/Program Studi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Angkatan</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>NIM</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Status</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Dosen Wali</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=6'>Total SKS</td>\r\n\t\t\t\t<td> Status Transfer</td>\r\n        \r\n \t\t\t</tr>\r\n\t\t";
			echo "										<div class=\"m-portlet\">			
															<div class=\"m-section__content\">
																<div class=\"table-responsive\">
																	<table class=\"table table-bordered table-hover\">
																		<thead>";
			echo "															<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Jurusan/Program Studi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Angkatan</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>NIM</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Status</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Dosen Wali</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=6'>Total SKS</td>\r\n\t\t\t\t<td> Status Transfer</td>\r\n        \r\n \t\t\t</tr>\r\n\t\t";
			echo "														</thead>
																		<tbody>";
			$i = 1;
            while ( $d = sqlfetcharray( $h ) )
            {
                $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$d['IDPRODI']}'";
                $hx = mysqli_query($koneksi,$q);
                if ( 0 < sqlnumrows( $hx ) )
                {
                    $dx = sqlfetcharray( $hx );
                    $kodept = $dx[KDPTIMSPST];
                    $kodejenjang = $dx[KDJENMSPST];
                    $kodeps = $dx[KDPSTMSPST];
                }
                $tmpstr = "";
                $kelas = kelas( $i );
                $q = "SELECT * FROM pengambilanmksp \r\n      WHERE IDMAHASISWA='{$d['ID']}' AND\r\n      TAHUN='{$tahun}' AND SEMESTER='{$semester}'\r\n      ";
                $h2 = mysqli_query($koneksi,$q);
				if ( 0 < sqlnumrows($h2)){
					while ($d2 = sqlfetcharray($h2)) 
					{
						$q = "SELECT * FROM pengambilanmk \r\n          WHERE IDMAHASISWA='{$d['ID']}' AND IDMAKUL='{$d2['IDMAKUL']}' \r\n          ORDER BY TAHUN DESC,SEMESTER LIMIT 0,1\r\n          ";
						$h3 = mysqli_query($koneksi,$q);
						if ( 0 < sqlnumrows( $h3 ) )
						{
							$d3 = sqlfetcharray( $h3 );
							$q = "UPDATE pengambilanmk \r\n             SET NILAI='{$d2['NILAI']}',BOBOT='{$d2['BOBOT']}',SIMBOL='{$d2['SIMBOL']}'\r\n             WHERE\r\n             IDMAHASISWA='{$d['ID']}' AND IDMAKUL='{$d2['IDMAKUL']}' AND\r\n             TAHUN='{$d3['TAHUN']}' AND SEMESTER='{$d3['SEMESTER']}' ";
							mysqli_query($koneksi,$q);
							$q = "UPDATE trnlm \r\n             SET  BOBOTTRNLM='{$d2['BOBOT']}',NLAKHTRNLM='{$d2['SIMBOL']}'\r\n             WHERE\r\n             NIMHSTRNLM='{$d['ID']}' AND KDKMKTRNLM='{$d2['IDMAKUL']}' AND\r\n             THSMSTRNLM='".( $d3[TAHUN] - 1 )."{$d3['SEMESTER']}'  ";
							mysqli_query($koneksi,$q);
							mysqli_query($koneksi,$q);
							$ketlog = "Transfer Nilai SP ke Reguler, Mahasiswa {$d['ID']}, MK={$d2['IDMAKUL']}, TAHUN=".( $d3[TAHUN] - 1 )."/{$d3['TAHUN']} , SEM={$d3['SEMESTER']}, BOBOT={$d2['BOBOT']}, SIMBOL={$d2['SIMBOL']},NILAI={$d2['NILAI']}";
							buatlog( 60 );
							$tmpstr .= "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>-</td>\r\n\t\t\t\t\t<td align=left nowrap colspan=8> \r\n            {$d2['IDMAKUL']} =>  ".$arraysemester[$d3[SEMESTER]]." ".( $d3[TAHUN] - 1 )."/{$d3['TAHUN']}, Perbaikan Nilai (OK), Nilai Lama {$d3['SIMBOL']}, Bobot Lama {$d3['BOBOT']}, Nilai Baru {$d2['SIMBOL']}, Bobot Baru {$d2['BOBOT']}\r\n          </td>\r\n \r\n  \t\t\t\t</tr>             \r\n          ";
						}
						else
						{
							$q = "INSERT INTO pengambilanmk \r\n            (IDMAHASISWA,IDMAKUL,TAHUN,KELAS,SEMESTER,BOBOT,NILAI,SIMBOL,SEMESTERMAKUL,SKSMAKUL)\r\n            VALUES\r\n            ('{$d['ID']}','{$d2['IDMAKUL']}','{$tahun}','01','{$semester}','{$d2['BOBOT']}','{$d2['NILAI']}','{$d2['SIMBOL']}','{$d2['SEMESTERMAKUL']}','{$d2['SKSMAKUL']}')";
							mysqli_query($koneksi,$q);
							$q = "INSERT INTO trnlm \r\n            (NIMHSTRNLM,KDKMKTRNLM,THSMSTRNLM, BOBOTTRNLM, NLAKHTRNLM,KDPTITRNLM,KDJENTRNLM,KDPSTTRNLM,KELASTRNLM)\r\n            VALUES\r\n            ('{$d['ID']}','{$d2['IDMAKUL']}','".( $tahun - 1 )."{$semester}','{$d2['BOBOT']}', '{$d2['SIMBOL']}', '{$kodept}','{$kodejenjang}','{$kodeps}','01')";
							mysqli_query($koneksi,$q);
							mysqli_query($koneksi,$q);
							$ketlog = "Transfer Nilai SP ke Reguler, Mahasiswa {$d['ID']}, MK={$d2['IDMAKUL']}, TAHUN=".( $tahun - 1 )."/{$tahun} , SEM={$semester}, BOBOT={$d2['BOBOT']}, SIMBOL={$d2['SIMBOL']},NILAI={$d2['NILAI']}";
							buatlog( 60 );
							$tmpstr .= "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>-</td>\r\n\t\t\t\t\t<td align=left nowrap colspan=8> \r\n            {$d2['IDMAKUL']} => ".$arraysemester[$semester]." ".( $tahun - 1 )."/{$tahun}, Pengambilan MK baru (OK), Nilai {$d2['SIMBOL']}, Bobot {$d2['BOBOT']}\r\n          </td>\r\n \r\n  \t\t\t\t</tr>             \r\n          ";
						}
					}
				}
                echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n\t\t\t\t\t<td align=left nowrap>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n \t\t\t\t\t<td align=center>{$d['ANGKATAN']}</td>\r\n \t\t\t\t\t<td align=left nowrap><b>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left nowrap><b>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=left nowrap>".$arraystatusmahasiswa[$d[STATUS]]."</td>\r\n \t\t\t\t\t<td align=left nowrap>".$arraydosen[$d[IDDOSEN]]."</td>\r\n           <td align=center>{$d['SKS']}</td>\r\n            <td align=center>OK</td>\r\n  \t\t\t\t</tr>\r\n  \t\t\t\t{$tmpstr}\r\n\t\t\t";
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
            $aksi = "tampilkan";
        }
        else
        {
            $errmesg = "Data Mahasiswa Tidak Ada";
            $aksi = "";
        }
    }
}
?>
