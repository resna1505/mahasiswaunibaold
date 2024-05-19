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
$arraysort[1] = "mahasiswa.ID";
$arraysort[2] = "mahasiswa.NAMA";
$arraysort[3] = "mahasiswa.STATUS";
$arraysort[4] = "mahasiswa.ANGKATAN";
$arraysort[5] = "mahasiswa.TAHUNLULUS";
$arraysort[6] = "mahasiswa.IDDOSEN";
$vld[] = cekvaliditaskodeprodi( "Jurusan/Program Studi", $idprodi );
$vld[] = cekvaliditastahun( "Angkatan", $angkatan );
$vld[] = cekvaliditasnim( "NIM", $id );
$vld[] = cekvaliditasnama( "Nama", $nama );
$vld = array_filter( $vld, "filter_not_empty" );
if ( isset( $vld ) && 0 < count( $vld ) )
{
    $errmesg = "Isian ".inv_message( $vld )." tidak valid";
    unset( $vld );
    $aksi = "";
}
else
{
    $href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
    if ( $idprodi != "" )
    {
        $qfield .= " AND IDPRODI='{$idprodi}'";
        $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
        $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
        $href .= "idprodi={$idprodi}&";
    }
    if ( $iddosen != "" )
    {
        $qfield .= " AND IDDOSEN='{$iddosen}'";
        $qjudul .= " Dosen Wali '".$arraydosen[$iddosen]."' <br>";
        $qinput .= " <input type=hidden name=iddosen value='{$iddosen}'>";
        $href .= "iddosen={$iddosen}&";
    }
    if ( $angkatan != "" )
    {
        $qfield .= " AND ANGKATAN='{$angkatan}'";
        $qjudul .= " Angkatan '{$angkatan}' <br>";
        $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
        $href .= "angkatan={$angkatan}&";
    }
    if ( $id != "" )
    {
        $qfield .= " AND ID LIKE '{$id}'";
        $qjudul .= " NIM '{$id}' <br>";
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
    if ( $lulus != "" )
    {
        $qfield .= " AND YEAR(TANGGALKELUAR) LIKE '%{$lulus}%'";
        $qjudul .= " Tahun Lulus '{$lulus}' <br>";
        $qinput .= " <input type=hidden name=lulus value='{$lulus}'>";
        $href .= "lulus={$lulus}&";
    }
    if ( $arraysort[$sort] == "" )
    {
        $sort = 1;
    }
    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $q = "SELECT COUNT(*) AS JML \r\nFROM mahasiswa \r\n\tWHERE STATUS='L'\r\n\t{$qfield}\t";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $total = $d[JML];
    include( "../paginating.php" );
    $q = "SELECT *,YEAR(TANGGALKELUAR) AS THNLULUS FROM mahasiswa \r\n\tWHERE STATUS='L'\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
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
            
            #printmesg( $qjudul );
			echo "
				<div class=\"tools\">
										<form target=_blank action='cetakmahasiswa.php' method=post>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak'>\r\n   \t\t\t\t{$qinput}\r\n   \t\t\t\t{$input}\r\n\t\t\t
													</td>
												</tr>
											</table>
										</form>
									</div>{$tpage} {$tpage2}";
        }
        #else
        #{
            
        #    printmesgcetak( $qjudul );
        #}
        #if ( $aksi != "cetak" )
        #{
            #echo "{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakmahasiswa.php'>\r\n      ".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>\r\n   \t\t\t\t{$qinput}\r\n   \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
        #}
        /*echo "<div class=\"page-content\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption\">
                                <i class=\"fa fa-cogs font-green-sharp\"></i>
                                <span class=\"caption-subject font-green-sharp bold uppercase\">Data Alumni</span>
                            </div>
            <div class=\"tools\">
                <form target=_blank action='cetakmahasiswa.php' method=post>
<input type=submit name=aksi2 value=Cetak class=\"btn green\">
                                </form>
                            </div>
                        </div>
                        <div class=\"portlet-body\">
                            <div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">
                            <thead>
                            <tr>
                                <th scope=col>No</th>
                                <th scope=col>Jurusan/Program Studi</th>
                                <th scope=col>NIM</th>
                                <th scope=col>Nama</th>
                                <th scope=col>Status</th>
                                <th scope=col>Angkatan</th>
                                <th scope=col>Lulus</th>
                                <th scope=col>Dosen Wali</th>";*/
		echo "						<div class=\"caption\">";
												printmesg("Data Alumni");
		echo "						</div>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr>
															<th>No</th>
															<th>Jurusan/Program Studi</th>
															<th>NIM</th>
															<th>Nama</th>
															<th>Status</th>
															<th>Angkatan</th>
															<th>Lulus</th>
															<th>Dosen Wali</th>";


        #echo "\r\n \t\t\t<table {$border} class=form{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Jurusan/Program Studi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>NIM</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Status</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=4'>Angkatan</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=5'>Lulus</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=6'>Dosen Wali</td>";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "\r\n\t\t\t\t\t\t\t<td nowrap >Aksi</td>\r\n\t\t\t\t\t\t\t";
        }
        #echo "\r\n\t\t\t</tr></thead>\r\n\t\t";
		echo "			</tr> 
				</thead>
					<tbody>";
        $i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}&nbsp;</td>\r\n\t\t\t\t\t<td align=left nowrap>".$arrayprodidep[$d[IDPRODI]]."&nbsp;</td>\r\n \t\t\t\t\t<td align=left><a class='{$cetak}' href='index.php?pilihan=lengkap&id={$d['ID']}'>{$d['ID']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left>".$arraystatusmahasiswa[$d[STATUS]]."&nbsp;</td>\r\n \t\t\t\t\t<td align=center>{$d['ANGKATAN']}&nbsp;</td>\r\n \t\t\t\t\t<td align=center>{$d['THNLULUS']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left>".$arraydosen[$d[IDDOSEN]]."&nbsp;</td>";
            if ( $tingkataksesusers[$kodemenu] == "T" )
            {
                #echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}'>".IKONUPDATE."</td>\r\n \t\t\t\t\t\t\t\t";
                echo "<td   align=center><a class=\"btn green\" href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}'>"."<i class=\"fa fa-edit\"></i>"."</td>";
            }
            echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
            ++$i;
        }
        /*echo "</table></div>{$tpage} {$tpage2}</div>
                    </div>
                        </div>
                            </div>
                                </div>
                                    ";*/
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
        $errmesg = "Data Alumni Tidak Ada";
        $aksi = "";
    }
}
?>
