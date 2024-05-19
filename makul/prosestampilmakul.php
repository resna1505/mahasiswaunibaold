<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo "mm";exit();
periksaroot( );
unset( $arraysort );
$arraysort[0] = "makul.IDPRODI";
$arraysort[1] = "makul.ID";
$arraysort[2] = "makul.NAMA";
$arraysort[3] = "makul.SKS";
$arraysort[4] = "makul.SEMESTER";
$vld[] = cekvaliditaskodeprodi( "Kode Prodi", $idprodi );
$vld[] = cekvaliditaskodemakul( "Kode Makul", $id );
$vld[] = cekvaliditasnama( "Nama MK", $nama );
$vld[] = cekvaliditasinteger( "Semester", $semester );
$vld[] = cekvaliditasinteger( "SKS", $sks );
$vld[] = cekvaliditaskode( "Jenis", $jenismakul );
$vld = array_filter( $vld, "filter_not_empty" );
if ( isset( $vld ) && 0 < count( $vld ) )
{
    $errmesg = val_err_mesg( $vld, 2, CARI_DATA );
    unset( $vld );
    $aksi = "";
}
else
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    $href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
    if ( $idprodi != "" )
    {
        $qfield .= " AND IDPRODI='{$idprodi}'";
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
        $qfield .= " AND SEMESTER = '{$semester}'";
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
    if ( $arraysort[$sort] == "" )
    {
        $sort = 1;
    }
    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $q = "SELECT COUNT(*) AS JML FROM makul \r\n\tWHERE 1=1  \r\n\t{$qfield}\r\n\t";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $total = $d[JML];
    include( "../paginating.php" );
    $q = "SELECT * FROM makul \r\n\tWHERE 1=1  \r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
	#echo $q;exit();
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
            #printjudulmenu( "Data Mata Kuliah", "bantuan" );
            #printhelp( trim( $arrayhelp[hasilmakul] ), "bantuan" );
            printmesg( $errmesg );
			printmesg( $qjudul );
            echo "						<div class=\"tools\">
										<form target=_blank action='cetakmakul.php' method=post>
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
            #printjudulmenucetak( "Data Mata Kuliah" );
        #    printmesgcetak( $qjudul );
        #}
        /*if ( $aksi != "cetak" )
        {

            

            #echo "\r\n\t\t\t{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakmakul.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t \r\n \t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";

            echo "<div class=\"page-content\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption\">
                                <i class=\"fa fa-cogs font-green-sharp\"></i>
                                <span class=\"caption-subject font-green-sharp bold uppercase\">Data Mata Kuliah</span>
                            </div>
                            <div class=\"tools\">
                                <form action='cetakmakul.php' target=_blank method=post>
                                    <input type=submit name=aksi value=Cetak class=\"btn green\"></input>
                                </form>
                            </div>
                        </div>
                        <div class=\"portlet-body\">
                        <div class=\"table-scrollable\">
                        <table class=\"table table-striped table-bordered table-hover\">
                            <thead>
                            <tr>
                                <th scope=col>No</th>
                                <th scope=col>Jurusan / Program Studi</th>
                                <th scope=col>Kode</th>
                                <th scope=col>Nama</th>
                                <th scope=col>SKS</th>
                                <th scope=col>Semester</th>";
                                
        }*/
		echo "						<div class=\"caption\">";
												printmesg("Data Mata Kuliah");
		echo "						</div>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr>
															<th scope=col>No</th>
															<th scope=col><a class='{$cetak}' href='{$href}"."&sort=0'>Jurusan / Program Studi</a></th>
															<th scope=col><a class='{$cetak}' href='{$href}"."&sort=1'>Kode</a></th>
															<th scope=col><a class='{$cetak}' href='{$href}"."&sort=2'>Nama</a></th>
															<th scope=col><a class='{$cetak}' href='{$href}"."&sort=3'>SKS</a></th>
															<th scope=col><a class='{$cetak}' href='{$href}"."&sort=4'>Semester</a></th>";
        #echo "\r\n \t\t\t<table {$border} class=form{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Jurusan / Program Studi</td>";
        #echo "<td><a class='{$cetak}' href='{$href}"."&sort=1'>Kode</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>SKS</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Semester</td>\r\n\t\t\t\t \r\n\t\t\t\t \r\n\t\t \r\n\t\t\t\t";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "  <th scope=col>Edit</th>
                    <th scope=col>Hapus</th>";

            #echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2 >Aksi</td>\r\n\t\t\t\t\t\t\t";
        }
        #echo "\r\n\t\t\t</tr></thead>\r\n\t\t";
		echo "			</tr> 
				</thead>
					<tbody>";
        $i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $datadikti = "";
            echo "\r\n\t\t\t\t<tr valign=top align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n\t\t\t\t\t<td align=left nowrap>".$arrayprodidepmakul[$d[IDPRODI]]."</td>";
            echo "\r\n  \t\t\t\t\t<td align=left>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td >{$d['SKS']}</td>\r\n \t\t\t\t\t<td >{$d['SEMESTER']}</td>\r\n \t\t\t\t\t \r\n \t\t\t\t \r\n \t\t\t\t\t \r\n \t\t\t\t\t";
            echo "\r\n\t\t\t\t\t\t\t\t<td  align=center><a class=\"btn green\" href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}'>"."<i class=\"fa fa-edit\"></i>"."</td>";
            if ( $tingkataksesusers[$kodemenu] == "T" && ( $statusoperatormakul == 1 && $prodis == $d[IDPRODI] || $prodis == "" ) )
            {
                echo "\r\n\t\t\t\t\t\t\t\t<td   align=center ><a class=\"btn red\" onclick=\"return confirm('Hapus Data Mata Kuliah Dengan Kode = {$d['ID']} ?');\" href='{$href}&aksi=hapus&idhapus={$d['ID']}&sessid={$token}'>"."<i class=\"fa fa-trash\"></i>"."</td>\r\n\t\t\t\t\t\t\t\t";
            }
            echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
            ++$i;
        }
        /*echo "</table>
                </div>
                    </div>{$tpage} {$tpage2}
                        </div>
                            </div>
                                </div>";*/
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
