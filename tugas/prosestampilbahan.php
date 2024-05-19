<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

unset( $arraysort );
$arraysort[0] = "tugaskuliah.TAHUN";
$arraysort[1] = "tugaskuliah.SEMESTER";
$arraysort[2] = "tugaskuliah.IDMAKUL";
$arraysort[3] = "tugaskuliah.KELAS";
$arraysort[4] = "dosenpengajar.IDDOSEN";
$arraysort[5] = "tugaskuliah.NAMA";
$arraysort[6] = "tugaskuliah.KET";
$tmp = explode( "-", $tahunsemester );
$tahun = $tmp[0];
$semester = $tmp[1];
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $idprodi != "" )
{
    $qfield .= " AND dosenpengajar.IDPRODI='{$idprodi}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $idmakul != "" )
{
    $qfield .= " AND dosenpengajar.IDMAKUL LIKE '%{$idmakul}%'";
    $qjudul .= " Kode Mata Kuliah mengandung kata '{$idmakul}' <br>";
    $qinput .= " <input type=hidden name=idmakul value='{$idmakul}'>";
    $href .= "idmakul={$idmakul}&";
}
if ( $tahun != "" )
{
    $qfield .= " AND tugaskuliah.TAHUN = '{$tahun}'";
    $qjudul .= " Tahun Ajaran '".( $tahun - 1 )."/{$tahun}' <br>";
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
    $qfield .= " AND tugaskuliah.KELAS = '{$kelas}'";
    $qjudul .= " Kelas '".$arraylabelkelas[$kelas]."' <br>";
    $qinput .= " <input type=hidden name=kelas value='{$kelas}'>";
    $href .= "kelas={$kelas}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 5;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(DISTINCT  \r\n\t \r\n  tugaskuliah.IDBAHAN ) AS JML FROM dosenpengajar  ,dosen,tugaskuliah {$tabeltambahan}\r\n\tWHERE 1=1\r\n\tAND dosen.ID=dosenpengajar.IDDOSEN \r\n \r\n\tAND tugaskuliah.IDMAKUL=dosenpengajar.IDMAKUL\r\n\tAND tugaskuliah.TAHUN=dosenpengajar.TAHUN\r\n\tAND tugaskuliah.SEMESTER=dosenpengajar.SEMESTER\r\n\tAND tugaskuliah.KELAS=dosenpengajar.KELAS\r\n\t{$qfieldbahankuliah}\r\n\t{$qfield}\r\n\t";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
$qgroup = $qcolumn = $qstatus = "";
if ( $jenisusers == 2 )
{
    $qcolumn = "   ,hasiltugaskuliah.NILAI,IF(hasiltugaskuliah.NILAI IS NOT NULL,'Sudah diserahkan','Belum diserahkan') AS STATUSHASIL\r\n ";
    $qstatus = "\r\nLEFT JOIN\r\nhasiltugaskuliah\r\nON \r\n tugaskuliah.IDMAKUL= hasiltugaskuliah.IDMAKUL AND \r\n tugaskuliah.TAHUN=hasiltugaskuliah.TAHUN AND \r\n tugaskuliah.SEMESTER=hasiltugaskuliah.SEMESTER AND \r\n tugaskuliah.KELAS=hasiltugaskuliah.KELAS AND \r\n tugaskuliah.IDBAHAN=hasiltugaskuliah.IDBAHAN AND \r\n '{$users}'=hasiltugaskuliah.IDMAHASISWA   ";
}
$q = "SELECT DISTINCT dosenpengajar.IDDOSEN, dosen.NAMA AS NAMADOSEN,\r\n\ttugaskuliah.IDMAKUL,tugaskuliah.TAHUN,tugaskuliah.SEMESTER,tugaskuliah.KELAS,dosenpengajar.IDPRODI,\r\n  tugaskuliah.IDBAHAN,tugaskuliah.NAMA,tugaskuliah.KET,tugaskuliah.FILE ,tugaskuliah.FLAGFILE \r\n\r\n{$qcolumn}\r\n\r\n\tFROM dosenpengajar, dosen {$tabeltambahan} ,tugaskuliah\r\n\r\n \r\n {$qstatus}  \r\n\r\n\tWHERE 1=1\r\n\tAND dosen.ID=dosenpengajar.IDDOSEN \r\n \tAND tugaskuliah.IDMAKUL=dosenpengajar.IDMAKUL\r\n\tAND tugaskuliah.TAHUN=dosenpengajar.TAHUN\r\n\tAND tugaskuliah.SEMESTER=dosenpengajar.SEMESTER\r\n\tAND tugaskuliah.KELAS=dosenpengajar.KELAS\r\n\tAND (tugaskuliah.IDDOSEN=dosenpengajar.IDDOSEN OR tugaskuliah.IDDOSEN='')\r\n\t{$qfieldbahankuliah}\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
$h = mysqli_query($koneksi,$q);
echo mysqli_error($koneksi);
if ( 0 < sqlnumrows( $h ) )
{
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
	echo "							<div class=\"caption\">";
												printmesg("Data Tugas Kuliah");
		echo "						</div>";
    if ( $aksi != "cetak" && $jenisusers!=2)
    {
        #printjudulmenu( "Data  Tugas Kuliah " );
        printmesg( $qjudul );
		echo "						<div class=\"tools\">
										<form target=_blank action='cetakbahan.php' method=post>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi class=\"btn btn-brand\" value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n\t\t\t
													</td>
												</tr>
											</table>
										</form>
									</div>{$tpage} {$tpage2}";
    }
    /*else
    {
        printjudulmenucetak( "Data  Tugas Kuliah" );
        printmesgcetak( $qjudul );
    }
    if ( $aksi != "cetak" )
    {
        echo "\r\n\t\t\t{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakbahan.php'>\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }*/
    #echo "\r\n \t\t\t<table {$border} class=form{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Tahun Ajaran</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Sem</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Kode M-K</td>\r\n\t\t\t\t<td>Nama Mata Kuliah</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Kelas</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>NIDN Dosen</td>\r\n \t\t\t\t<td>Nama Dosen</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Nama Tugas</td>\r\n \r\n\t\t\t\t";
    echo "
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Tahun Ajaran</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Sem</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Kode M-K</td>\r\n\t\t\t\t<td>Nama Mata Kuliah</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Kelas</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>NIDN Dosen</td>\r\n \t\t\t\t<td>Nama Dosen</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Nama Tugas</td>\r\n \r\n\t\t\t\t";
	
	if ( $jenisusers == 2 )
    {
        echo "\r\n            <td>Status</td>\r\n            <td>Nilai</td>\r\n            <td>Lihat Tugas</td>\r\n          ";
    }
    if ( $jenisusers == 1 )
    {
        echo "\r\n            <td>Jml terkumpul</td>\r\n            <td>Hasil Tugas</td>\r\n          ";
    }
    #echo "\r\n\t\t\t</tr>\r\n\t\t";
	echo "												</tr> 
													</thead>
														<tbody>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n   \t\t\t\t<td align=left>".( $d[TAHUN] - 1 )."/{$d['TAHUN']}</td>\r\n \t\t\t\t\t<td  >".$arraysemester[$d[SEMESTER]]."</td>\r\n \t\t\t\t\t<td align=left>{$d['IDMAKUL']}</td>\r\n \t\t\t\t\t<td align=left nowrap>".@getnamamk( @$d[IDMAKUL], @( @$d[TAHUN] - 1 ).@"{$d['SEMESTER']}", @$d[IDPRODI] )."</td>\r\n \t\t\t\t\t<td >".$arraylabelkelas[$d[KELAS]]."</td>\r\n   \t\t\t\t<td align=left>{$d['IDDOSEN']}</td>\r\n   \t\t\t\t<td align=left nowrap>{$d['NAMADOSEN']}</td>\r\n \t\t\t\t\t<td align=left nowrap><b>{$d['NAMA']}</td>\r\n           ";
        if ( $jenisusers == 2 )
        {
            echo "\r\n   \t\t\t\t\t<td align=center nowrap><b>{$d['STATUSHASIL']}</td>\r\n   \t\t\t\t\t<td align=center nowrap><b>{$d['NILAI']}</td>\r\n            <td><a href='index.php?pilihan=kirim&idupdate={$d['IDBAHAN']}&idmakulupdate={$d['IDMAKUL']}&tahunupdate={$d['TAHUN']}&semesterupdate={$d['SEMESTER']}&kelasupdate={$d['KELAS']}&iddosenupdate={$d['IDDOSEN']}'>lihat</a></td>\r\n          ";
        }
        if ( $jenisusers == 1 )
        {
            $q = "SELECT COUNT(*) AS JML \r\n            FROM hasiltugaskuliah WHERE \r\n            IDBAHAN='{$d['IDBAHAN']}' AND\r\n            IDMAKUL='{$d['IDMAKUL']}' AND\r\n            TAHUN='{$d['TAHUN']}' AND\r\n            SEMESTER='{$d['SEMESTER']}' AND\r\n            KELAS='{$d['KELAS']}'\r\n            ";
            $hx = mysqli_query($koneksi,$q);
            $dx = sqlfetcharray( $hx );
            echo "\r\n            <td>{$dx['JML']}</td>\r\n            <td><a href='index.php?pilihan=hasil&idupdate={$d['IDBAHAN']}&idmakulupdate={$d['IDMAKUL']}&tahunupdate={$d['TAHUN']}&semesterupdate={$d['SEMESTER']}&kelasupdate={$d['KELAS']}&iddosenupdate={$d['IDDOSEN']}'>lihat</a></td>\r\n          ";
        }
        echo "\r\n\t\t\t\t\t\r\n\t\t\t\t</tr>\r\n\t\t\t";
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
    $errmesg = "Data File Tugas Kuliah  Tidak Ada";
    $aksi = "";
}
?>
