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
$arraysort[2] = "makul.SEMESTER";
$arraysort[3] = "dosenpengajarsp.IDMAKUL";
$arraysort[4] = "dosenpengajarsp.IDDOSEN";
$arraysort[5] = "dosenpengajarsp.KELAS";
$arraysort[6] = "dosenpengajarsp.TAHUN,dosenpengajarsp.SEMESTER,dosenpengajarsp.IDDOSEN,dosenpengajarsp.IDMAKUL";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkanawal&";
if ( $idprodi != "" )
{
    $qfield .= " AND dosenpengajarsp.IDPRODI='{$idprodi}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $jenisusers == 1 )
{
    $qfield .= "AND IDDOSEN='{$users}'";
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
    $qfield .= " AND  dosenpengajarsp.IDMAKUL LIKE '%{$idmakul}%'";
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
$q = "SELECT count(*) AS JML\r\n\tFROM dosenpengajarsp, dosen,makul \r\n\tWHERE 1=1  \r\n\tAND dosen.ID=dosenpengajarsp.IDDOSEN \r\n \tAND makul.ID= dosenpengajarsp.IDMAKUL\r\n \t{$qfield}\r\n \tORDER BY ".$arraysort[$sort]." {$qlimit}";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
$first = 0;
include( "../paginating.php" );
$q = "SELECT  \r\n dosenpengajarsp.*,dosen.NAMA AS NAMADOSEN ,makul.NAMA AS NAMAMAKUL,dosenpengajarsp.IDPRODI AS IDX\r\n\tFROM dosenpengajarsp, dosen,makul \r\n\tWHERE 1=1  \r\n\tAND dosen.ID=dosenpengajarsp.IDDOSEN \r\n \tAND makul.ID= dosenpengajarsp.IDMAKUL\r\n \t{$qfield}\r\n \tORDER BY ".$arraysort[$sort]." {$qlimit}";
#echo $q;
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    /*if ( $aksi != "cetak" )
    {
        printjudulmenu( "Data Mata Kuliah" );
        printmesg( $qjudul );
    }
    else
    {
        printjudulmenucetak( "Data Mata Kuliah" );
        printmesgcetak( $qjudul );
    }*/
	#if ( $aksi != "cetak" )
    #{
        #printjudulmenu( "Data Mata Kuliah" );
        
    #}
    #else
    #{
        #printjudulmenucetak( "Data Mata Kuliah" );
    #    printmesgcetak( $qjudul );
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
                        <div class=\"table-scrollable\">";
     */   
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
	echo "						<div class=\"caption\">";
										printmesg( $qjudul );
												printmesg("Data Mata Kuliah");
    echo "						</div>
								{$tpage} {$tpage2}
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Prodi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>Semester/Tahun Akademik</td>\r\n \r\n<!--\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Semes<br>ter<br>M-K</td> -->\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Kode Mata Kuliah</td>\r\n\t\t\t\t<td>Nama Mata Kuliah</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>NIP</td>\r\n \t\t\t\t<td>Nama Dosen</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Kelas</td>\r\n\t\t\t\t";
    if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap  >Edit<br>Nilai</td>\r\n\t\t\t\t\t\t\t";
    }
    #echo "\r\n\t\t\t</tr>\r\n\t\t";
	echo "			</tr> 
				</thead>
					<tbody>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n \t\t\t\t\t<td  nowrap>".$arrayprodidep[$d[IDX]]."</td>\r\n   \t\t\t\t<td align=left>".$arraysemester[$d[SEMESTER]]." ".( $d[TAHUN] - 1 )."/{$d['TAHUN']}</td>\r\n \t\t\t\t\t \r\n<!-- \t\t\t\t\t<td  >{$d['SEMESTERMAKUL']}</td> -->\r\n \t\t\t\t\t<td align=left>{$d['IDMAKUL']}</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NAMAMAKUL']}</td>\r\n   \t\t\t\t<td align=left>{$d['IDDOSEN']}</td>\r\n   \t\t\t\t<td align=left nowrap>{$d['NAMADOSEN']}</td>\r\n \t\t\t\t\t<td >{$d['KELAS']}</td>\r\n\t\t\t\t\t\r\n \t\t\t\t\t";
        if ( $jenisusers == 0 && $tingkataksesusers[$kodemenu] == "T" || $jenisusers == 1 && $aturaneditnilaidosen == 1 )
        {
            echo "\r\n\t\t\t\t\t\t\t\t<td   align=center>\r\n\t\t\t\t\t\t\t\t<a href='index.php?pilihan={$pilihan}&\r\n\t\t\t\t\t\t\t\taksi=formtambah&\r\n\t\t\t\t\t\t\t\tidmakulupdate={$d['IDMAKUL']}&\r\n\t\t\t\t\t\t\t\tiddosenupdate={$d['IDDOSEN']}&\r\n\t\t\t\t\t\t\t\ttahunupdate={$d['TAHUN']}&\r\n\t\t\t\t\t\t\t\tsemesterupdate={$d['SEMESTER']}&\r\n\t\t\t\t\t\t\t\tkelasupdate={$d['KELAS']}&idprodiupdate={$d['IDX']}&pertama=1'><i class=\"fa fa-edit\"></i></td>\r\n \t\t\t\t\t\t\t\t";
        }
        else
        {
            echo "<td><a href='index.php?pilihan={$pilihan}&\r\n\t\t\t\t\t\t\t\taksi=lihatdata&\r\n\t\t\t\t\t\t\t\tidmakulupdate={$d['IDMAKUL']}&\r\n\t\t\t\t\t\t\t\tiddosenupdate={$d['IDDOSEN']}&\r\n\t\t\t\t\t\t\t\ttahunupdate={$d['TAHUN']}&\r\n\t\t\t\t\t\t\t\tsemesterupdate={$d['SEMESTER']}&\r\n\t\t\t\t\t\t\t\tkelasupdate={$d['KELAS']}&idprodiupdate={$d['IDX']}'>Lihat</td>";
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    #echo "</table>";
	echo "</table></div>
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
