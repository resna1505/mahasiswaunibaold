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
$vldts[] = cekvaliditasinteger( "Jurusan/Prodi", $idprodi, 10 );
$vldts[] = cekvaliditasinteger( "NIDN", $iddosen, 10 );
$vldts[] = cekvaliditastahun( "Angkatan", $angkatan );
$vldts[] = cekvaliditaskode( "NIM", $id, 16 );
$vldts[] = cekvaliditasnama( "Nama", $nama, 32 );
$vldts[] = cekvaliditaskode( "Status", $status, 1 );
$vldts[] = cekvaliditasthnajaran( "Semester Awal", $tahuna, $semestera );
$vldts = array_filter( $vldts, "filter_not_empty" );
if ( isset( $vldts ) && 0 < count( $vldts ) )
{
    $errmesg = "Data pencarian berikut tidak valid, silahkan cek kembali".inv_message( $vldts, 2 );
    unset( $vldts );
    $aksi = "";
}
else
{
    $href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
    if ( $idprodi != "" )
    {
        $qfield .= " AND mahasiswa.IDPRODI='{$idprodi}'";
        $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
        $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
        $href .= "idprodi={$idprodi}&";
    }
    if ( $jenisusers == 1 )
    {
        $iddosen = $users;
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
    $qtabel = "";
    if ( $status != "" )
    {
        $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
        $qinput .= " <input type=hidden name=status value='{$status}'>";
        $href .= "status={$status}&";
        if ( $iftahunakademik == 1 )
        {
            $qtabel = ", trlsm ";
            $qfield .= "\r\n        AND mahasiswa.ID=trlsm.NIMHSTRLSM\r\n        AND trlsm.THSMSTRLSM='{$tahun2}{$semester2}' AND trlsm.STMHSTRLSM='{$status}'\r\n      ";
            $qjudul .= " Periode Tahun Akademik : {$tahun2}/".( $tahun2 + 1 )." ".$arraysemester[$semester2]." <br>";
            $qinput .= " \r\n      <input type=hidden name=iftahunakademik value='{$iftahunakademik}'>\r\n      <input type=hidden name=tahun2 value='{$tahun2}'>\r\n      <input type=hidden name=semester2 value='{$semester2}'>\r\n      ";
            $href .= "iftahunakademik={$iftahunakademik}&tahun2={$tahun2}&semester2={$semester2}&";
        }
        else
        {
            $qfield .= " AND mahasiswa.STATUS='{$status}'";
        }
    }
    if ( $statusawal != "" )
    {
        $qjudul .= " Status Awal '".$arraystatusmhsbaru["{$statusawal}"]."' <br>";
        $qinput .= " <input type=hidden name=statusawal value='{$statusawal}'>";
        $href .= "statusawal={$statusawal}&";
        $qfield .= " AND msmhs.STPIDMSMHS='{$statusawal}'";
    }
    if ( $jeniskelas != "" )
    {
        $qfield .= " AND mahasiswa.JENISKELAS='{$jeniskelas}'";
        $qjudul .= " Jenis Kelas '".$arraykelasstei["{$jeniskelas}"]."' <br>";
        $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
        $href .= "jeniskelas={$jeniskelas}&";
    }
    if ( $tahuna != "" && $semestera != "" )
    {
        $qfield .= " AND msmhs.SMAWLMSMHS='".$tahuna."{$semestera}'";
        $qjudul .= " Semester Awal '".$arraysemester["{$semestera}"]."  {$tahuna}' <br>";
        $qinput .= " <input type=hidden name=tahuna value='{$tahuna}'>";
        $qinput .= " <input type=hidden name=semestera value='{$semestera}'>";
        $href .= "semestera={$semestera}&tahuna={$tahuna}&";
    }
    if ( $arraysort[$sort] == "" )
    {
        $sort = 2;
    }
    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $q = "SELECT COUNT(*) AS JML \r\n  FROM msmhs {$qtabel}  ,mahasiswa LEFT JOIN mahasiswa2 ON mahasiswa.ID=mahasiswa2.ID\r\n\tWHERE \r\n  mahasiswa.ID=msmhs.NIMHSMSMHS\r\n   {$qprodidep2}\r\n\t{$qfield}\r\n\t";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $total = $d[JML];
    include( "../paginating.php" );
    $q = "SELECT mahasiswa.ID,mahasiswa.NAMA,mahasiswa.ANGKATAN,mahasiswa.STATUS,mahasiswa.IDDOSEN,mahasiswa.IDPRODI,YEAR(NOW())-YEAR(mahasiswa.TANGGAL) AS UMUR ,IPKUAP,LAMBANGUAP\r\n  FROM msmhs {$qtabel} ,mahasiswa  LEFT JOIN mahasiswa2 ON mahasiswa.ID=mahasiswa2.ID\r\n\tWHERE \r\n   mahasiswa.ID=msmhs.NIMHSMSMHS\r\n   {$qprodidep2}\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
    #echo $q;
	$h = mysqli_query($koneksi,$q);
    echo mysqli_error($koneksi);
    if ( 0 < sqlnumrows( $h ) )
    {
		$token = md5( uniqid( rand( ), TRUE ) );
        $_SESSION['token'] = $token;
        
		echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
									printmesg( $errmesg );
									printmesg("Edit Nilai Ujian Akhir Program");
        if ( $aksi != "cetak" )
        {
            #printjudulmenu( "Edit Nilai Ujian Akhir Program" );
            printmesg( $qjudul );
            #printmesg( $errmesg );
        }
        /*else
        {
            #printjudulmenucetak( "Edit Nilai Ujian Akhir Program" );
            printmesgcetak( $qjudul );
        }
        if ( $aksi != "cetak" )
        {
            #echo " \t{$tpage} {$tpage2}\r\n      ";
        }*/
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
                                <span class=\"caption-subject bold uppercase\"> Edit Nilai Ujian Akhir Program </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/

        echo "\r\n    {$tpage} {$tpage2}<form action=index.php method=post>\r\n      <input type=hidden name=aksi value='{$aksi}'>\r\n      <input type=hidden name=pilihan value='{$pilihan}'>".createinputhidden( "sessid", $_SESSION['token'], "" )."\r\n      {$input}\r\n      {$qinput}
							<div class=\"m-portlet\">			
								<div class=\"m-section__content\">
									<div class=\"table-responsive\">
										<table class=\"table table-bordered table-hover\">
											<thead>
												<tr class=juduldata{$aksi} align=center>
													<td align=right colspan=9> <input type=submit name=aksi2 value='Update' class=\"btn btn-brand\"></td>
												</tr>
												<tr class=juduldata{$aksi} align=center>
													<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Jurusan/Program Studi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Angkatan</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>NIM</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Status</td>\r\n\t\t\t\t<td>Data Kelulusan</td> \r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Nilai/Mutu UAP</td> \r\n\t\t\t\t<td>Simbol/Lambang UAP</td>
												</tr>
											</thead>
											<tbody>";
        $i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            if ( $d[UMUR] <= 15 && $aksi != "cetak" )
            {
                $kelas = "style='background-color:#ffff00'";
            }
            echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n\t\t\t\t\t<td align=left nowrap>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n \t\t\t\t\t<td align=center>{$d['ANGKATAN']}</td>\r\n \t\t\t\t\t<td align=left>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=left>".$arraystatusmahasiswa[$d[STATUS]]."</td>\r\n \t\t\t\t\t<td align=center nowrap></td>\r\n \t\t\t\t\t<td align=center><input size=4 type=text name='nilaiuap[{$d['ID']}]' value='{$d['IPKUAP']}'></td> \r\n \t\t\t\t\t<td align=center><input size=4 type=text name='lambanguap[{$d['ID']}]' value='{$d['LAMBANGUAP']}'></td> \r\n\r\n\t\t\t\t</tr>\r\n\t\t\t";
            ++$i;
        }
        #echo "</table>\r\n    </form></div></div></div></div></div>";
		echo " 								</tbody>
										</table>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		</div>
		</div>
		</div>";
        $aksi = "tampilkan";
    }
    else
    {
        $errmesg = "Data Mahasiswa Tidak Ada";
        $aksi = "";
    }
}
?>
