<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo "ambil=".$ambilnama;exit();
periksaroot( );
unset( $arraysort );
$arraysort[0] = "trnlm.THSMSTRNLM";
$arraysort[1] = "trnlm.THSMSTRNLM";
$arraysort[2] = "trnlm.NIMHSTRNLM";
$arraysort[3] = "NAMAMAHASISWA";
$arraysort[4] = "trnlm.KDKMKTRNLM";
$arraysort[5] = "tbkmk.NAKMKTBKMK";
$arraysort[6] = "tbkmk.SKSMKTBKMK";
$arraysort[7] = "trnlm.KELASTRNLM";
$arraysort[8] = "trnlm.THSMSTRNLM,trnlm.NIMHSTRNLM,trnlm.KDKMKTRNLM";
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $idprodi != "" )
{
    $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst \r\n          WHERE IDX='{$idprodi}'";
    $hx = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $hx ) )
    {
        $dx = mysqli_fetch_array( $hx );
        $kodept = $dx[KDPTIMSPST];
        $kodejenjang = $dx[KDJENMSPST];
        $kodeps = $dx[KDPSTMSPST];
    }
    $qfield .= " AND tbkmk.KDPSTTBKMK='{$kodeps}' AND tbkmk.KDJENTBKMK='{$kodejenjang}' AND tbkmk.KDPTITBKMK='{$kodept}' ";
    $qjudul .= " Jurusan / Program Studi Mata Kuliah '".$arrayprodidep[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $idprodim != "" )
{
    $qfield .= " AND mahasiswa.IDPRODI='{$idprodim}'";
    $qjudul .= " Jurusan / Program Studi Mahasiswa '".$arrayprodidep[$idprodim]."' <br>";
    $qinput .= " <input type=hidden name=idprodim value='{$idprodim}'>";
    $href .= "idprodim={$idprodim}&";
}
if ( $idmahasiswa != "" )
{
    $qfield .= " AND NIMHSTRNLM LIKE '%{$idmahasiswa}%'";
    $qjudul .= " NIM mengandung kata '{$idmahasiswa}' <br>";
    $qinput .= " <input type=hidden name=idmahasiswa value='{$idmahasiswa}'>";
    $href .= "idmahasiswa={$idmahasiswa}&";
}
if ( $jeniskelas != "" )
{
    $qfield .= " AND mahasiswa.JENISKELAS='{$jeniskelas}'";
    $qjudul .= " Jenis Kelas '".$arraykelasstei["{$jeniskelas}"]."' <br>";
    $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
    $href .= "jeniskelas={$jeniskelas}&";
}
if ( $idmakul != "" )
{
    $qfield .= " AND KDKMKTRNLM LIKE '%{$idmakul}%'";
    $qjudul .= " Kode Mata Kuliah mengandung kata '{$idmakul}' <br>";
    $qinput .= " <input type=hidden name=idmakul value='{$idmakul}'>";
    $href .= "idmakul={$idmakul}&";
}
if ( $tahun != "" )
{
    $qfield .= " AND SUBSTRING(trnlm.THSMSTRNLM,1,4) = '".( $tahun - 1 )."'";
    $qjudul .= " Tahun Akademik '".( $tahun - 1 )."/{$tahun}' <br>";
    $qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
    $href .= "tahun={$tahun}&";
}
if ( $semester != "" )
{
    $qfield .= " AND SUBSTRING(trnlm.THSMSTRNLM,5,1) = '{$semester}'";
    $qjudul .= " Semester ".$arraysemester[$semester]." <br>";
    $qinput .= " <input type=hidden name=semester value='{$semester}'>";
    $href .= "semester={$semester}&";
}
if ( $kelas != "" )
{
    $qfield .= " AND trnlm.KELASTRNLM = '{$kelas}'";
    $qjudul .= " Kelas '{$kelas}' <br>";
    $qinput .= " <input type=hidden name=kelas value='{$kelas}'>";
    $href .= "kelas={$kelas}&";
}
if ( $makul != "" )
{
    $qfield .= " AND NAKMKTBKMK LIKE '%{$makul}%'";
    $qjudul .= " Nama Mata Kuliah mengandung kata '{$makul}' <br>";
    $qinput .= " <input type=hidden name=makul value='{$makul}'>";
    $href .= "makul={$makul}&";
}

if ( $arraysort[$sort] == "" )
{
    $sort = 8;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM trnlm,mahasiswa , tbkmk\r\n\tWHERE    \r\n   mahasiswa.ID=trnlm.NIMHSTRNLM AND\r\n\t trnlm.KDKMKTRNLM=tbkmk.KDKMKTBKMK AND \r\n   tbkmk.THSMSTBKMK=trnlm.THSMSTRNLM AND\r\n   tbkmk.KDPSTTBKMK=trnlm.KDPSTTRNLM AND \r\n   tbkmk.KDJENTBKMK=trnlm.KDJENTRNLM AND\r\n   tbkmk.KDPTITBKMK=trnlm.KDPTITRNLM \r\n\t{$qfield}\r\n \r\n\t";
$h = doquery($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
$first = 0;
include( "../paginating.php" );
$q = "SELECT trnlm.*,NAKMKTBKMK AS NAMAMAKUL,mahasiswa.NAMA AS NAMAMAHASISWA,mahasiswa.ANGKATAN,mahasiswa.IDCALONMAHASISWA,mahasiswa.TEMPAT,mahasiswa.TANGGAL,
mahasiswa.ANGKATAN,mahasiswa.NAMA,mahasiswa.KELAMIN,mahasiswa.AGAMA,mahasiswa.KTP,SKSMKTBKMK SKS,KDPSTTBKMK AS IDPRODI,mahasiswa.IDPRODI AS IDP FROM trnlm,mahasiswa , tbkmk\r\n\tWHERE    \r\n   mahasiswa.ID=trnlm.NIMHSTRNLM AND\r\n\t trnlm.KDKMKTRNLM=tbkmk.KDKMKTBKMK AND \r\n   tbkmk.THSMSTBKMK=trnlm.THSMSTRNLM AND\r\n   tbkmk.KDPSTTBKMK=trnlm.KDPSTTRNLM AND \r\n   tbkmk.KDJENTBKMK=trnlm.KDJENTRNLM AND\r\n   tbkmk.KDPTITBKMK=trnlm.KDPTITRNLM \r\n\t\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
echo $q;exit();
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";    
	echo "						<div class=\"caption\">";
												printjudulmenucetak("Data Pengambilan M-K Mahasiswa (KRS)");
												printmesgcetak( $qjudul );
		echo "						</div>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr>
															 <td>No</td>\r\n \t\t\t\t<td>Nama</td>\r\n\t\t\t\t<td>NIM</td>\r\n\t\t\t\t<td>Tempat Lahir</td>\r\n\t\t\t\t<td>Tanggal Lahir</td>\r\n\t\t\t\t<td>Nama Ibu</td>\r\n\t\t\t\t<td>Jenis Kelamin</td>\r\n\t\t\t\t<td>Agama</td>\r\n\t\t\t\t<td>NIK</td>\r\n\t\t\t\t<td>Kelurahan</td>\r\n\t\t\t\t<td>Kecamatan</td>\r\n\t\t\t\t<td>SKS</td>";
    if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        #echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2  >Aksi</td>\r\n\t\t\t\t\t\t\t";
        echo "<th scope=col>Edit</th><th scope=col>Hapus</th>";
    }
    #echo "\r\n\t\t\t</tr>\r\n\t\t</thead>";
	echo "			</tr> 
				</thead>
					<tbody>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
		$sql_tabel_calon="SELECT KELURAHAN,KECAMATAN FROM calonmahasiswa WHERE ID='{$d['IDCALONMAHASISWA']}'";
		#echo $sql_tabel_calon;
		#$h_tabel_calon = mysqli_query($koneksi,$sql_tabel_calon);
		$h_tabel_calon = mysqli_query($koneksi,$sql_tabel_calon);
		$d_tabel_calon = sqlfetcharray( $h_tabel_calon );
		
		//get SKS TOTAL from trakm
		$sql_sks_total="SELECT SKSTTTRAKM AS SKSTOTAL FROM trakm WHERE NIMHSTRAKM='{$d['NIMHSTRNLM']}' AND NLIPKTRAKM!=0 order by THSMSTRAKM DESC LIMIT 1";
		#echo $sql_sks_total;
		#$h_sks_total = mysqli_query($koneksi,$sql_sks_total);
		$h_sks_total = mysqli_query($koneksi,$sql_sks_total);
		$d_sks_total = sqlfetcharray( $h_sks_total );
		
        $kelas = kelas( $i );
        $semesterx = "";
        $kurawal = "";
        $kurtutup = "";
        $styleerror = "";
        $errornamakurikulum = "";
        $namamakulkurikulum = getnamamk( "{$d['KDKMKTRNLM']}", "".( $d[TAHUN] - 1 )."{$d['SEMESTER']}", $d[IDP] );
        if ( $namamakulkurikulum == "" )
        {
            $styleerror = "style='background-color:#ffaaaa'";
            $errornamakurikulum = "tidak ada di kurikulum";
        }
        $d[TAHUN] = substr( $d[THSMSTRNLM], 0, 4 ) + 1;
        $d[SEMESTER] = substr( $d[THSMSTRNLM], 4, 1 );
         echo "\r\n\t\t\t\t<tr valign=top align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td><td nowrap align=left>{$d['NAMA']}</td><td align=left><a class='{$cetak}' href='index.php?pilihan=lengkap&id={$d['ID']}'>{$d['NIMHSTRNLM']}</td><td align=left nowrap> {$d['TEMPAT']}</td><td align=left nowrap> {$d['TANGGAL']}</td><td align=left nowrap> {$d['NAMAIBU']}</td><td>{$d['KELAMIN']}</td><td>".$arrayagama[$d[AGAMA]]."</td><td>{$d['KTP']}</td><td>{$d_tabel_calon['KELURAHAN']}</td><td>".$arraykecamatan{$d_tabel_calon['KECAMATAN']}."</td><td>{$d_sks_total['SKSTOTAL']}</td>";
		$totalsks += $d[SKS];
        if ( $tingkataksesusers[$kodemenu] == "T" && ( $statusoperatormakul == 1 && $prodis == $d[IDP] || $prodis == "" ) )
        {
            echo "\r\n\t\t\t\t\t\t\t\t<td   align=center>  <a href='index.php?pilihan={$pilihan}&aksi=formupdate&idmakulupdate={$d['KDKMKTRNLM']}&tahunupdate={$d['TAHUN']}&semesterupdate={$d['SEMESTER']}&idmahasiswaupdate={$d['NIMHSTRNLM']}'><i class=\"fa fa-edit\"></i></td>\r\n\t\t\t\t\t\t\t\t<td   align=center ><a onclick=\"return confirm('Hapus Data Pengambilan M-K Mahasiswa  ?');\"href='{$href}&aksi=hapus&idmakulhapus={$d['KDKMKTRNLM']}&tahunhapus={$d['TAHUN']}&semesterhapus={$d['SEMESTER']}&idmahasiswahapus={$d['NIMHSTRNLM']}&sessid={$token}'><i class=\"fa fa-trash\"></i></td>\r\n\t\t\t\t\t\t\t\t";
        }
        else if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "\r\n              <td colspan=2 align=center> - \r\n              </td>\r\n              ";
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
 
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
    $errmesg = "Data Pengambilan M-K Mahasiswa Tidak Ada";
    $aksi = "";
}
?>
