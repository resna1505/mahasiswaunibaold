<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

unset( $arraysort );
$arraysort[0] = "bahankuliahsp.TAHUN";
$arraysort[1] = "bahankuliahsp.SEMESTER";
$arraysort[2] = "bahankuliahsp.IDMAKUL";
$arraysort[3] = "bahankuliahsp.KELAS";
$arraysort[4] = "dosenpengajarsp.IDDOSEN";
$arraysort[5] = "bahankuliahsp.NAMA";
$arraysort[6] = "bahankuliahsp.KET";
$arraysort[7] = "bahankuliahsp.FILE";
$tmp = explode( "-", $tahunsemester );
$tahun = $tmp[0];
$semester = $tmp[1];
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $idprodi != "" )
{
    $qfield .= " AND dosenpengajarsp.IDPRODI='{$idprodi}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $idmakul != "" )
{
    $qfield .= " AND dosenpengajarsp.IDMAKUL LIKE '%{$idmakul}%'";
    $qjudul .= " Kode Mata Kuliah mengandung kata '{$idmakul}' <br>";
    $qinput .= " <input type=hidden name=idmakul value='{$idmakul}'>";
    $href .= "idmakul={$idmakul}&";
}
if ( $tahun != "" )
{
    $qfield .= " AND dosenpengajarsp.TAHUN = '{$tahun}'";
    $qjudul .= " Tahun Ajaran '".( $tahun - 1 )."/{$tahun}' <br>";
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
    $qfield .= " AND bahankuliahsp.KELAS = '{$kelas}'";
    $qjudul .= " Kelas '".$arraylabelkelas[$kelas]."' <br>";
    $qinput .= " <input type=hidden name=kelas value='{$kelas}'>";
    $href .= "kelas={$kelas}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 5;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(DISTINCT  \r\n\t \r\n  bahankuliahsp.IDBAHAN ) AS JML FROM dosenpengajarsp, dosen,bahankuliahsp {$tabeltambahan}\r\n\tWHERE 1=1\r\n\tAND dosen.ID=dosenpengajarsp.IDDOSEN \r\n\t\r\n\tAND bahankuliahsp.IDMAKUL  = dosenpengajarsp.IDMAKUL\r\n\tAND bahankuliahsp.TAHUN=dosenpengajarsp.TAHUN\r\n\tAND bahankuliahsp.SEMESTER=dosenpengajarsp.SEMESTER\r\n\tAND bahankuliahsp.KELAS=dosenpengajarsp.KELAS\r\n  AND (bahankuliahsp.IDDOSEN=dosenpengajarsp.IDDOSEN OR bahankuliahsp.IDDOSEN='')\r\n\t{$qfieldbahankuliah}\r\n\t{$qfield}\r\n\t";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
$qgroup = $qcolumn = $qstatus = "";
if ( $jenisusers == 2 )
{
    $qcolumn = " , statusunduhbahankuliahsp.JUMLAH AS JMLUNDUH   , statusunduhbahankuliahsp.TANGGAL \r\n ";
    $qstatus = "\r\n  AND  '{$users}'=statusunduhbahankuliahsp.IDMAHASISWA  \r\n  ";
}
else
{
    $qcolumn = " ,COUNT(DISTINCT statusunduhbahankuliahsp.IDBAHAN  ) AS JMLUNDUH   \r\n ";
    $qgroup = " \tGROUP BY bahankuliahsp.IDBAHAN,bahankuliahsp.IDMAKUL,bahankuliahsp.TAHUN,bahankuliahsp.SEMESTER,bahankuliahsp.KELAS\r\n ";
}
$q = "SELECT DISTINCT dosenpengajarsp.IDDOSEN, dosen.NAMA AS NAMADOSEN,\r\n\tbahankuliahsp.IDMAKUL,bahankuliahsp.TAHUN,bahankuliahsp.SEMESTER,bahankuliahsp.KELAS,dosenpengajarsp.IDPRODI,\r\n  bahankuliahsp.IDBAHAN,bahankuliahsp.NAMA,bahankuliahsp.KET,bahankuliahsp.FILE ,bahankuliahsp.FLAGFILE \r\n\r\n{$qcolumn}  \r\n\r\n\r\n\tFROM dosenpengajarsp, dosen {$tabeltambahan} ,bahankuliahsp\r\n\r\nLEFT JOIN\r\nstatusunduhbahankuliahsp\r\nON \r\n bahankuliahsp.IDMAKUL= statusunduhbahankuliahsp.IDMAKUL AND \r\n bahankuliahsp.TAHUN=statusunduhbahankuliahsp.TAHUN AND \r\n bahankuliahsp.SEMESTER=statusunduhbahankuliahsp.SEMESTER AND \r\n bahankuliahsp.KELAS=statusunduhbahankuliahsp.KELAS AND \r\n bahankuliahsp.IDBAHAN=statusunduhbahankuliahsp.IDBAHAN  \r\n{$qstatus}\r\n\r\n\tWHERE 1=1\r\n\tAND dosen.ID=dosenpengajarsp.IDDOSEN \r\n\t \r\n\tAND bahankuliahsp.IDMAKUL= dosenpengajarsp.IDMAKUL\r\n\tAND bahankuliahsp.TAHUN=dosenpengajarsp.TAHUN\r\n\tAND bahankuliahsp.SEMESTER=dosenpengajarsp.SEMESTER\r\n\tAND bahankuliahsp.KELAS=dosenpengajarsp.KELAS \r\n  AND (bahankuliahsp.IDDOSEN=dosenpengajarsp.IDDOSEN OR bahankuliahsp.IDDOSEN='')\r\n\t{$qfieldbahankuliah}\r\n\t{$qfield}\r\n\r\n{$qgroup}\r\n\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
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
												printmesg("Data Bahan Kuliah Semester Pendek");
		echo "						</div>";	
    if ( $aksi != "cetak" && $jenisusers!=2 )
    {
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
        printjudulmenucetak( "Data File Bahan Kuliah" );
        printmesgcetak( $qjudul );
    }
    if ( $aksi != "cetak" )
    {
        echo "\r\n\t\t\t{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakbahan.php'>\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }*/
    #echo "\r\n \t\t\t<table {$border} class=form{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Tahun Ajaran</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Sem</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Kode M-K / Nama Mata Kuliah</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Kelas</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>NIP / Nama Dosen Pengajar</td> \r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Nama Bahan / Kete<br>rangan</td>\r\n \r\n \t\t\t\t<td> File Bahan</td>\r\n\t\t\t\t";
    #echo "\r\n\t\t\t</tr>\r\n\t\t";
    echo "
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Tahun Ajaran</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Sem</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Kode M-K / Nama Mata Kuliah</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Kelas</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>NIP / Nama Dosen Pengajar</td> \r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Nama Bahan / Kete<br>rangan</td>\r\n \r\n \t\t\t\t<td> File Bahan</td>\r\n\t\t\t\t";
	echo "												</tr> 
													</thead>
														<tbody>";
	$i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr align=center {$kelas} >\r\n\t\t\t\t\t<td>{$i} </td>\r\n   \t\t\t\t<td align=left>".( $d[TAHUN] - 1 )."/{$d['TAHUN']}</td>\r\n \t\t\t\t\t<td  >".$arraysemester[$d[SEMESTER]]."</td>\r\n \t\t\t\t\t<td align=left>{$d['IDMAKUL']} /  ".@getnamamk( @$d[IDMAKUL], @( @$d[TAHUN] - 1 ).@"{$d['SEMESTER']}", @$d[IDPRODI] )."</td>\r\n  \t\t\t\t\t<td >".$arraylabelkelas[$d[KELAS]]."</td>\r\n   \t\t\t\t<td align=left>{$d['IDDOSEN']} / {$d['NAMADOSEN']}</td> \r\n  \t\t\t\t\t<td align=left nowrap><b>{$d['NAMA']}</b> <br> ".htmlspecialchars_decode( $d[KET] )."</td>\r\n  \t\t\t\t\t<td align=center> ";
        if ( $d[FLAGFILE] == 0 )
        {
            echo "\r\n            <a target=_blank href='file/{$d['FILE']}'>{$d['FILE']}</a>";
        }
        else if ( $d[FLAGFILE] == 1 )
        {
            echo "\r\n            <a target=_blank href='dl.php?idmakulupdate={$d['IDMAKUL']}&iddosenupdate={$d['IDDOSEN']}&tahunupdate={$d['TAHUN']}&semesterupdate={$d['SEMESTER']}&kelasupdate={$d['KELAS']}&idbahan={$d['IDBAHAN']}\r\n' >".IKONUNDUH48."</a>";
        }
        if ( $jenisusers == 1 )
        {
            if ( 0 < $d[JMLUNDUH] )
            {
                echo "\r\n              <p>\r\n                <a href='index.php?pilihan=detilunduh&idmakulupdate={$d['IDMAKUL']}&iddosenupdate={$d['IDDOSEN']}&tahunupdate={$d['TAHUN']}&semesterupdate={$d['SEMESTER']}&kelasupdate={$d['KELAS']}&idbahan={$d['IDBAHAN']}'>Diunduh {$d['JMLUNDUH']} Mahasiswa</a>\r\n              ";
            }
            else
            {
                echo "<p>Belum pernah diunduh";
            }
        }
        else if ( $jenisusers == 2 )
        {
            if ( 0 < $d[JMLUNDUH] )
            {
                echo "\r\n              <p>\r\n                Diunduh {$d['JMLUNDUH']} x Terakhir pada {$d['TANGGAL']}</a>\r\n              ";
            }
            else
            {
                echo "<p>Belum pernah diunduh";
            }
        }
        echo "\r\n           \r\n \t\t\t\t\t\r\n\t\t\t\t</tr>\r\n\t\t\t";
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
    $errmesg = "Data File Bahan Kuliah  Tidak Ada";
    $aksi = "";
}
?>
