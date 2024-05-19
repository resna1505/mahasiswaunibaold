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
$arraysort[0] = "makul.IDPRODI";
$arraysort[1] = "makul.ID";
$arraysort[2] = "tbkmksp.NAKMKTBKMK";
$arraysort[3] = "tbkmksp.SKSTMTBKMK";
$arraysort[4] = "tbkmksp.SEMESTBKMK";
$arraysort[5] = "trakd.NODOSTRAKD";
$arraysort[6] = "trakd.KDKELTBKMK";
$vld[] = cekvaliditasthnajaran( "Semester Tahun Akademik", $tahunk, $semesterk );
$vld[] = cekvaliditaskodeprodi( "Program Studi", $idprodi );
$vld[] = cekvaliditaskodemakul( "Kode Makul", $id );
$vld[] = cekvaliditasnama( "Nama Makul", $nama );
$vld[] = cekvaliditasinteger( "Semester", $semester, 2 );
$vld[] = cekvaliditasinteger( "SKS", $sks, 2 );
$vld[] = cekvaliditaskode( "Jenis", $jenismakul, 2 );
$vld = array_filter( $vld, "filter_not_empty" );
if ( isset( $vld ) && 0 < count( $vld ) )
{
    $errmesg = val_err_mesg( $vld, 2, CARI_DATA );
    $aksi = "";
}
else
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    $href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
    $qfield = " AND THSMSTBKMK = '".( $tahunk - 1 )."{$semesterk}'";
    $qjudul .= " Semester/Tahun Akademik ".$arraysemester[$semesterk]." ".( $tahunk - 1 )."/{$tahunk} <br>";
    $qinput .= " <input type=hidden name=semesterk value='{$semesterk}'>";
    $qinput .= " <input type=hidden name=tahunk value='{$tahunk}'>";
    $href .= "semesterk={$semesterk}&tahunk={$tahunk}&";
    if ( $idprodi != "" )
    {
        $qfield .= " AND IDX='{$idprodi}'";
        $qjudul .= " Jurusan / Program Studi '".$arrayprodidep[$idprodi]."' <br>";
        $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
        $href .= "idprodi={$idprodi}&";
    }
    if ( $id != "" )
    {
        $qfield .= " AND ID LIKE '%{$id}%'";
        $qjudul .= " Kode mengandung kata '{$id}' <br>";
        $qinput .= " <input type=hidden name=id value='{$id}'>";
        $href .= "id={$id}&";
    }
    if ( $nama != "" )
    {
        $qfield .= " AND NAMA LIKE '%{$nama}%'";
        $qjudul .= " Nama mengandung kata '{$nama}' <br>";
        $qinput .= " <input type=hidden name=nama value='{$nama}'>";
        $href .= "nama={$nama}&";
    }
    if ( $semester != "" )
    {
        $qfield .= " AND tbkmksp.SEMESTBKMK+0 = '{$semester}'";
        $qjudul .= " Semester '{$semester}' <br>";
        $qinput .= " <input type=hidden name=semester value='{$semester}'>";
        $href .= "semester={$semester}&";
    }
	if ( $sks != "" )
    {
        $qfield .= " AND SKS = '{$sks}'";
        $qjudul .= " SKS '{$sks}' <br>";
        $qinput .= " <input type=hidden name=sks value='{$sks}'>";
        $href .= "sks={$sks}&";
    }
    /*$qfield .= " AND SKS = '{$sks}'";
    $qjudul .= " SKS '{$sks}' <br>";
    $qinput .= " <input type=hidden name=sks value='{$sks}'>";
    $href .= "sks={$sks}&";*/
    if ( $jenismakul != "" )
    {
        $qfield .= " AND JENIS='{$jenismakul}'";
        $qjudul .= " Jenis '".$arrayjenismakul[$jenismakul]."' <br>";
        $qinput .= " <input type=hidden name=jenismakul value='{$jenismakul}'>";
        $href .= "jenismakul={$jenismakul}&";
    }
    if ( $kelompokmakul != "" )
    {
        $qfield .= " AND KELOMPOK='{$kelompokmakul}'";
        $qjudul .= " Kelompk '".$arraykelompokmakul[$kelompokmakul]."' <br>";
        $qinput .= " <input type=hidden name=kelompokmakul value='{$kelompokmakul}'>";
        $href .= "kelompokmakul={$kelompokmakul}&";
    }
    $qfield .= " AND KELOMPOKKURIKULUM='{$kelompokkurikulum}'";
    $qjudul .= " Kelompok Kurikulum '".$arraykelompokkurikulum[$kelompokkurikulum]."' <br>";
    $qinput .= " <input type=hidden name=kelompokkurikulum value='{$kelompokkurikulum}'>";
    $href .= "kelompokkurikulum={$kelompokkurikulum}&";
    if ( $kelompok != "" )
    {
        $qfield .= " AND KDKELTBKMK='{$kelompok}'";
        $qjudul .= " Kelompok Mata Kuliah '".$arraykelompokmk[$kelompok]."' <br>";
        $qinput .= " <input type=hidden name=kelompok value='{$kelompok}'>";
        $href .= "kelompok={$kelompok}&";
    }
    if ( $arraysort[$sort] == "" )
    {
        $sort = 1;
    }
    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $q = "SELECT COUNT(*) AS JML \r\n    FROM makul,mspst,tbkmksp\r\n\tWHERE 1=1 AND\r\n  makul.ID=tbkmksp.KDKMKTBKMK AND\r\n \r\n  mspst.KDPSTMSPST=tbkmksp.KDPSTTBKMK AND\r\n  mspst.KDJENMSPST=tbkmksp.KDJENTBKMK AND\r\n  mspst.KDPTIMSPST=tbkmksp.KDPTITBKMK\r\n {$qprodideptbkmksp} \r\n\t{$qfield}\r\n\t";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $total = $d[JML];
    include( "../paginating.php" );
    $q = "SELECT tbkmksp.NAKMKTBKMK NAMA,makul.ID,\r\n      mspst.IDX AS IDPRODI,\r\n     tbkmksp.*,SKSMKTBKMK AS SKS ,     \r\n      SEMESTBKMK  +0 AS SEMESTER,\r\n      COUNT(trnlmsp.THSMSTRNLM) AS PESERTA,\r\n      dosenpengajarsp.IDDOSEN AS NODOSTRAKD,msdos.NMDOSMSDOS\r\n\r\n      \r\n      FROM makul ,mspst \r\n      LEFT JOIN tbkmksp ON\r\n       \r\n        mspst.KDPSTMSPST=tbkmksp.KDPSTTBKMK AND\r\n        mspst.KDJENMSPST=tbkmksp.KDJENTBKMK AND\r\n        mspst.KDPTIMSPST=tbkmksp.KDPTITBKMK\r\n      \r\n      LEFT join dosenpengajarsp ON\r\n        dosenpengajarsp.IDPRODI=mspst.IDX  AND\r\n         dosenpengajarsp.IDMAKUL=tbkmksp.KDKMKTBKMK AND\r\n         dosenpengajarsp.THSHM=tbkmksp.THSMSTBKMK AND\r\n         dosenpengajarsp.KELAS=tbkmksp.KDKELTBKMK\r\n         \r\n      LEFT JOIN msdos ON dosenpengajarsp.IDDOSEN=msdos.NODOSMSDOS\r\n      \r\n       LEFT JOIN trnlmsp ON\r\n        trnlmsp.KDPSTTRNLM=tbkmksp.KDPSTTBKMK AND\r\n        trnlmsp.KDJENTRNLM=tbkmksp.KDJENTBKMK AND\r\n        trnlmsp.KDPTITRNLM=tbkmksp.KDPTITBKMK AND\r\n        trnlmsp.KDKMKTRNLM=tbkmksp.KDKMKTBKMK AND\r\n         trnlmsp.THSMSTRNLM=tbkmksp.THSMSTBKMK\r\n      \r\n      \r\n\tWHERE\r\n        makul.ID=tbkmksp.KDKMKTBKMK  \r\n {$qprodideptbkmksp}\r\n\t{$qfield}\r\n\tGROUP BY tbkmksp.KDKMKTBKMK,tbkmksp.THSMSTBKMK,  tbkmksp.KDPSTTBKMK,tbkmksp.KDJENTBKMK,tbkmksp.KDPTITBKMK \r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
    #echo $q;
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
								<div class=\"portlet-title\">
									<div class=\"caption\">";
												printmesg("Data Kurikulum Mata Kuliah SP");
		echo "						</div>";
        if ( $aksi != "cetak" )
        {
           
          printmesg( $qjudul );
            printmesg( $errmesg );
			echo "						<div class=\"tools\">
										<form target=_blank action='cetakmakul2.php' method=post>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi class=\"btn btn-brand\" value='Cetak'>\r\n \t\t\t\t \r\n \t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\t
													</td>
												</tr>
											</table>
										</form>
									</div>{$tpage} {$tpage2}";
        }
        #else
        #{
           
        #}
        #if ( $aksi != "cetak" )
        #{
        /*    echo "<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <br><br><br><br>
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\">KURIKULUM MATA KULIAH SEMESTER PENDEK</span>
                            </div>
                           <div class=\"actions\"><form target=_blank action='cetakmakul2.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi class=\"btn green\" value='Cetak'>\r\n \t\t\t\t \r\n \t\t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\t</form></div>
                        </div>
                        <div class=\"portlet-body form\">
						<div class=\"table-scrollable\">";
        }*/
        #echo "<table class=\"table table-striped table-bordered table-hover\" {$border} class=form{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Jurusan / Program Studi Penyelenggara</td>";
		
		echo "						<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
		
														<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Jurusan / Program Studi Penyelenggara</td>";
        
		echo "											<td><a class='{$cetak}' href='{$href}"."&sort=1'>Kode</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Nama Mata Kuliah</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=6'>Kelompok Mata Kuliah</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>SKS</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Semester</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Dosen Pengampu</td>\r\n\t\t\t\t<td>Peserta</td>\r\n        ";
        if ( $STEIINDONESIA == 1 )
        {
            echo "\r\n\t\t\t\t    <td>Jadwal</td>\r\n\t\t\t\t  ";
        }
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2 >Aksi</td>\r\n\t\t\t\t\t\t\t";
        }
        #echo "\r\n\t\t\t</tr>\r\n\t\t";
		echo "			</tr> 
				</thead>
					<tbody>";
        $i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $datadikti = "";
            $nama2 = "";
            if ( $d[NAMA2] != "" )
            {
                $nama2 = "<br><i>({$d['NAMA2']})</i>";
            }
            echo "\r\n\t\t\t\t<tr valign=top align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n\t\t\t\t\t<td align=left nowrap>".$arrayprodidep[$d[IDPRODI]]."</td>";
            echo "\r\n  \t\t\t\t\t<td align=left>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']} {$nama2}</td>\r\n \t\t\t\t\t<td >".$arraykelompokmk[$d[KDKELTBKMK]]."</td>\r\n \t\t\t\t\t<td >{$d['SKS']}</td>\r\n \t\t\t\t\t<td >{$d['SEMESTER']}</td>\r\n \t\t\t\t\t\t<td align=left  nowrap>{$d['NODOSTBKMK']} / ".getnamafromtabel( $d[NODOSTBKMK], "dosen" )."</td>\r\n \t\t\t\t\t<td ><a href='index.php?pilihan=mhsmakul&idmakul={$d['ID']}&namamakul={$d['NAMA']}&idprodi={$d['IDPRODI']}&tahun={$tahunk}&semester={$semesterk}'>{$d['PESERTA']}</td>\r\n           \r\n           ";
            if ( $STEIINDONESIA == 1 )
            {
                echo "\r\n \t\t\t\t\t<td >".getfield( "COUNT(*)", "jadwalkuliahkurikulumsp", "WHERE IDMAKUL='{$d['ID']}' AND IDPRODI='{$d['IDPRODI']}' AND\r\n           TAHUN='{$tahunk}' AND SEMESTER='{$semesterk}'" )."</td>\r\n  \t\t\t\t\t";
            }
            if ( $tingkataksesusers[$kodemenu] == "T" )
            {
                echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a class=\"btn green\" href='index.php?pilihan=mlihat&aksi=formupdate&tab=1&idupdate={$d['ID']}&tahunsemester=".( $tahunk - 1 )."{$semesterk}&prodiupdate={$d['KDPSTTBKMK']}&jenjangupdate={$d['KDJENTBKMK']}&aksi2=formupdate'><i class=\"fa fa-edit\"></i></td>\r\n\t\t\t\t\t\t\t\t<td   align=center ><a class=\"btn red\" onclick=\"return confirm('Hapus Data Kurikulum Mata Kuliah Dengan ID = {$d['ID']} ?');\"\r\n\t\t\t\t\t\t\t\thref='{$href}&prodiupdate={$d['KDPSTTBKMK']}&jenjangupdate={$d['KDJENTBKMK']}&aksi2=hapus&idhapus={$d['ID']}&sessid={$token}'><i class=\"fa fa-trash\"></i></td>\r\n\t\t\t\t\t\t\t\t";
            }
            echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
            ++$i;
        }
        #echo "</table></div></div>{$tpage} {$tpage2}</div></div> ";
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
        $errmesg = "Data Mata Kuliah Tidak Ada";
        $aksi = "";
    }
}
?>
