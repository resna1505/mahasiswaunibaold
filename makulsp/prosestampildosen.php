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
$arraysort[0] = "dosenpengajarsp.IDPRODI";
$arraysort[1] = "dosenpengajarsp.TAHUN";
$arraysort[2] = "dosenpengajarsp.SEMESTER";
$arraysort[3] = "dosenpengajarsp.IDMAKUL";
$arraysort[4] = "dosenpengajarsp.IDDOSEN";
$arraysort[5] = "dosenpengajarsp.KELAS";
$arraysort[6] = "dosenpengajarsp.TAHUN,dosenpengajarsp.SEMESTER,dosenpengajarsp.IDDOSEN,dosenpengajarsp.IDMAKUL";
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
$vld[] = cekvaliditaskodeprodi( "Program Studi Mata Kuliah", $prodi );
$vld[] = cekvaliditaskodeprodi( "Program Studi Dosen", $prodim );
$vld[] = cekvaliditaskode( "NIDN Dosen", $iddosen );
$vld[] = cekvaliditaskodemakul( "Kode Makul", $idmakul );
$vld[] = cekvaliditastahun( "Tahun", $tahun );
$vld[] = cekvaliditaskode( "Semester", $semester, 1 );
$vld[] = cekvaliditaskode( "Kelas", $kelas, 2 );
$vld = array_filter( $vld, "filter_not_empty" );
if ( isset( $vld ) && 0 < count( $vld ) )
{
    $errmesg = val_err_mesg( $vld, 2, CARI_DATA );
    unset( $vld );
    $aksi = "";
}
else
{
    $href = "index.php?pilihan={$pilihan}&aksi=tampilkan&sort={$sort}&";
    if ( $idprodi != "" )
    {
        $qfield .= " AND dosenpengajarsp.IDPRODI='{$idprodi}'";
        $qjudul .= " Jurusan / Program Studi '".$arrayprodidep[$idprodi]."' <br>";
        $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
        $href .= "idprodi={$idprodi}&";
    }
    if ( $idprodim != "" )
    {
        $qfield .= " AND dosen.IDDEPARTEMEN='{$idprodim}'";
        $qjudul .= " Jurusan / Program Studi Dosen '".$arrayprodidep[$idprodim]."' <br>";
        $qinput .= " <input type=hidden name=idprodim value='{$idprodim}'>";
        $href .= "idprodim={$idprodim}&";
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
        $qfield .= " AND IDMAKUL LIKE '%{$idmakul}%'";
        $qjudul .= " Kode Mata Kuliah mengandung kata '{$idmakul}' <br>";
        $qinput .= " <input type=hidden name=idmakul value='{$idmakul}'>";
        $href .= "idmakul={$idmakul}&";
    }
    if ( $tahun != "" )
    {
        $qfield .= " AND dosenpengajarsp.TAHUN = '{$tahun}'";
        $qjudul .= " Tahun Akademik '".( $tahun - 1 )."/{$tahun}' <br>";
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
        $qfield .= " AND KELAS = '{$kelas}'";
        $qjudul .= " Kelas '{$kelas}' <br>";
        $qinput .= " <input type=hidden name=kelas value='{$kelas}'>";
        $href .= "kelas={$kelas}&";
    }
    if ( $arraysort[$sort] == "" )
    {
        $sort = 6;
    }
    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $q = "SELECT COUNT(*) AS JML \r\n FROM dosenpengajarsp,makul,dosen   \r\n\tWHERE 1=1  \r\n \tAND dosen.ID=dosenpengajarsp.IDDOSEN \r\n \tAND dosen.ID=dosenpengajarsp.IDDOSEN AND makul.ID=dosenpengajarsp.IDMAKUL\r\n\t{$qfield}\r\n\t";
    $h = mysqli_query($koneksi,$q);
    echo mysqli_error($koneksi);
    $d = sqlfetcharray( $h );
    $total = $d[JML];
    include( "../paginating.php" );
    $q = "SELECT dosenpengajarsp.*,makul.NAMA AS NAMAMAKUL,dosen.NAMA AS NAMADOSEN \r\n\tFROM dosenpengajarsp,makul,dosen  \r\n\tWHERE 1=1  \r\n \tAND dosen.ID=dosenpengajarsp.IDDOSEN \r\n\tAND dosen.ID=dosenpengajarsp.IDDOSEN AND makul.ID=dosenpengajarsp.IDMAKUL\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
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
        if ( $aksi != "cetak" )
        {
            #printjudulmenu( "Data Dosen Pengajar Mata Kuliah Semester Pendek" );
            #printmesg( $qjudul );
            #printmesg( $errmesg );
			echo "						<div class=\"tools\">
										<form target=_blank action='cetakdosen.php' method=post>
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
        #else
        #{
            #printjudulmenucetak( "Data Dosen Pengajar Mata Kuliah Semester Pendek" );
        #    printmesgcetak( $qjudul );
        #}
        /*if ( $aksi != "cetak" )
        {
            echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Data Dosen Pengajar Mata Kuliah Semester </span>
                            </div>
                            <div class=\"actions\">
                                <form target=_blank action='cetakdosen.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi class=\"btn green\" value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n\t\t\t</form
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";

            #echo "\r\n\t\t\t{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakdosen.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
        }
        echo "\r\n \t\t\t<table {$border} class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Prodi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Tahun Akademik</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Semester</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Kode </td>\r\n\t\t\t\t<td>Nama Mata Kuliah</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Dosen Pengajar <br> (NIP / Nama)</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Kelas</td>\r\n\t\t\t\t";
        */
		echo "		<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
													<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Prodi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Tahun Akademik</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Semester</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Kode </td>\r\n\t\t\t\t<td>Nama Mata Kuliah</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Dosen Pengajar <br> (NIP / Nama)</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Kelas</td>\r\n\t\t\t\t";
		if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2 width=20%>Aksi</td>\r\n\t\t\t\t\t\t\t";
        }
        #echo "\r\n\t\t\t</tr>\r\n\t\t";
		echo "			</tr> 
				</thead>
					<tbody>";
        $i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $dosenlain = "";
            if ( trim( $d[DOSENLAIN] ) != "" )
            {
                $dosenlain = "<br>";
                $tmp = explode( "\n", $d[DOSENLAIN] );
                foreach ( $tmp as $k => $v )
                {
                    $tmp2 = explode( " ", $v );
                    $tmpnama = $tmp2[0];
                    unset( $tmp2[0] );
                    $tmpnama .= " / ".implode( " ", $tmp2 );
                    $dosenlain .= " {$tmpnama}<br>";
                }
            }
            $styleerror = "";
            $errornamakurikulum = "";
            $namamakulkurikulum = getnamamksp( "{$d['IDMAKUL']}", "".( $d[TAHUN] - 1 )."{$d['SEMESTER']}", $d[IDPRODI], 1 );
            if ( $namamakulkurikulum == "" )
            {
                $styleerror = "style='background-color:#ffaaaa'";
                $errornamakurikulum = "tidak ada di kurikulum";
            }
            echo "\r\n\t\t\t\t<tr valign=top align=center {$kelas}{$aksi} {$styleerror}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n \t\t\t\t\t<td align=left nowrap>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n   \t\t\t\t<td align=left>".( $d[TAHUN] - 1 )."/{$d['TAHUN']}</td>\r\n \t\t\t\t\t<td align=left>".$arraysemester[$d[SEMESTER]]."</td>\r\n \t\t\t\t\t<td align=left>{$d['IDMAKUL']}</td>\r\n \t\t\t\t\t<td align=left nowrap>{$namamakulkurikulum} {$errornamakurikulum}</td>\r\n   \t\t\t\t<td align=left nowrap>{$d['IDDOSEN']} / {$d['NAMADOSEN']} {$dosenlain}</td>\r\n \t\t\t\t\t<td >{$d['KELAS']}</td>\r\n\t\t\t\t\t\r\n \t\t\t\t\t";
            if ( $tingkataksesusers[$kodemenu] == "T" )
            {
                echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a class=\"btn green\" href='index.php?pilihan={$pilihan}&aksi=formupdate&idmakulupdate={$d['IDMAKUL']}&tahunupdate={$d['TAHUN']}&semesterupdate={$d['SEMESTER']}&kelasupdate={$d['KELAS']}&idprodiupdate={$d['IDPRODI']}&iddosenupdate={$d['IDDOSEN']}'><i class=\"fa fa-edit\"></i></td>\r\n\t\t\t\t\t\t\t\t<td   align=center ><a class=\"btn red\" onclick=\"return confirm('Hapus Data Dosen Pengajar  ?');\"\r\n\t\t\t\t\t\t\t\thref='{$href}&aksi=hapus\t&idmakulhapus={$d['IDMAKUL']}&tahunhapus={$d['TAHUN']}&semesterhapus={$d['SEMESTER']}&kelashapus={$d['KELAS']}&idprodihapus={$d['IDPRODI']}&iddosenhapus={$d['IDDOSEN']}&sessid={$token}'><i class=\"fa fa-trash\"></i></td>\r\n\t\t\t\t\t\t\t\t";
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
			<!--end::Portlet-->";
        $aksi = "tampilkan";
    }
    else
    {
        $errmesg = "Data Dosen Pengajar Tidak Ada";
        $aksi = "";
    }
}
?>
