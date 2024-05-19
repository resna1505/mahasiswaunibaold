<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "\r\n";
echo "<s";
echo "tyle type=\"text/css\">\r\n* {\r\n\tmargin:0px;\r\n\tpadding:0px;\r\n\t}\r\n</style>\r\n\r\n";
periksaroot( );
unset( $arraysort );
$arraysort[0] = "dosen.IDDEPARTEMEN";
$arraysort[1] = "dosen.ID";
$arraysort[2] = "dosen.NAMA";
$arraysort[3] = "dosen.STATUS";
$valdata[] = cekvaliditasinteger( "Jurusan", $iddepartmen, 32 );
$valdata[] = cekvaliditaskode( "ID", $id, 32 );
$valdata[] = cekvaliditasnama( "Nama", $nama );
$valdata[] = cekvaliditaskode( "Status", $status );
$valdata = array_filter( $valdata, "filter_not_empty" );
if ( isset( $valdata ) && 0 < count( $valdata ) )
{
    $errmesg = val_err_mesg( $valdata, 2, CARI_DATA );
    unset( $valdata );
    $aksi = "";
}
else
{
	#echo "kesini";exit();
    $href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
    if ( $iddepartemen != "" )
    {
        $qfield .= " AND dosen.IDDEPARTEMEN='{$iddepartemen}'";
        $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$iddepartemen]."' <br>";
        $qinput .= " <input type=hidden name=iddepartemen value='{$iddepartemen}'>";
        $href .= "iddepartemen={$iddepartemen}&";
    }
    if ( $id != "" )
    {
        $qfield .= " AND dosen.ID='{$id}'";
        $qjudul .= " NIDN '{$id}' <br>";
        $qinput .= " <input type=hidden name=id value='{$id}'>";
        $href .= "id={$id}&";
    }
    if ( $nama != "" )
    {
        $qfield .= " AND dosen.NAMA LIKE '%{$nama}%'";
        $qjudul .= " Nama mengandung kata '{$nama}' <br>";
        $qinput .= " <input type=hidden name=nama value='{$nama}'>";
        $href .= "nama={$nama}&";
    }
    if ( $status != "" )
    {
        $qfield .= " AND dosen.STATUS='{$status}'";
        $qjudul .= " Status Dosen '".$arraystatusdosen["{$status}"]."' <br>";
        $qinput .= " <input type=hidden name=status value='{$status}'>";
        $href .= "status={$status}&";
    }
    include( "../mahasiswa/prosescari2.php" );
    if ( $arraysort[$sort] == "" )
    {
        $sort = 1;
    }
    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    $q = "SELECT COUNT(*) AS JML FROM dosen LEFT JOIN dosen2 ON dosen.ID=dosen2.ID\r\n\t\tWHERE 1=1 {$qprodidep3}\r\n\t\t{$qfield}\r\n\t\t";
   # echo $q;exit();
	$h = doquery($koneksi,$q);
    $d = sqlfetcharray( $h );
    $total = $d[JML];
    include( "../paginating.php" );
    $q = "SELECT dosen.*,YEAR(NOW())-YEAR(msdos.TGLHRMSDOS) AS UMUR \r\n    FROM dosen  LEFT JOIN dosen2 ON dosen.ID=dosen2.ID,msdos\r\n\tWHERE dosen.ID=msdos.NODOSMSDOS \r\n\t{$qprodidep3}\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
    echo $q;
	$h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
		echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        ";
        if ( $aksi != "cetak" )
        {
           
            #printhelp( trim( $arrayhelp[hasildosen] ), "bantuan" );
            printmesg( $qjudul );
			echo "						<form target=_blank action='cetakdosen.php' method=post>
										
									<div class=\"tools\">
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi2 value=Cetak class=\"btn btn-success\"></input>
													</td>
												</tr>
											</table>
									</div>{$tpage} {$tpage2}";
        }
        #else
        #{
        #    printjudulmenucetak( "Data Dosen" );
        #    printmesgcetak( $qjudul );
        #}
        if ( $aksi != "cetak" )
        {
            #echo "\t{$tpage} {$tpage2}\r\n\t\t\t\t"; /* echo "<table class=form>\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td>\r\n\t\t\t\t<form target=_blank action='cetakdosen.php'>\r\n\t\t\t\t\t".IKONCETAK32."\r\n\t\t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>";*/
            if ( getaturan( "PUSAKA" ) == 1 && getaturan( "URLPUSAKA" ) != "" )
            {
                echo "\r\n   \t\t\t\t<input type=submit name=aksi2 class=tombol value='Ekspor ke Pusaka'>";
            }
            echo "\r\n\t\t\t\t\t{$qinput}\r\n\t\t\t\t\t{$input}\r\n\t\t\t\t</form>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr></table>";
        }
        #if ( $aksi != "cetak" )
        #{
            #echo "\r\n\t\t<table>\r\n\t\t<tr>\r\n\t\t<td>\r\n\t\tData dengan latar belakang kuning berarti ada field2 yang mungkin salah/tidak valid. Silakan diperiksa dengan mengupdate data dosen tersebut.\r\n\t\t</td>\r\n\t\t</tr>\r\n    </table>";
        #}
        /*echo "\r\n \t\t\t<table class='dataprint' cellpadding='0' cellspacing='0'>\r\n\t\t\t<tr class=juduldata{$aksi} align=center >\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>Jurusan/Program Studi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'>NIDN</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'>Status</td>\r\n\t\t\t ";*/

        /*echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">
									<div class=\"tools\">
										<form target=_blank action='cetakdosen.php' method=post>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi2 value=Cetak class=\"btn btn-brand\"></input>
													</td>
												</tr>
											</table>
										</form>
									</div>
									<div class=\"caption\">";
										printmesg("Data dengan latar belakang kuning berarti ada field2 yang mungkin salah/tidak valid. Silakan diperiksa dengan mengupdate data dosen tersebut.");
		echo "						</div>
									
								</div>";*/
		/*echo "					<div class=\"portlet-body\">
									<div class=\"table-scrollable\">
										<table class=\"table table-striped table-bordered table-hover\">
										<thead>
										
										<tr>
											<th scope=\"col\">No</th>
											<th scope=\"col\">Jurusan/Program Studi</th>
											<th scope=\"col\">NIDN</th>
											<th scope=\"col\">Nama</th>
											<th scope=\"col\">Status</th> ";*/
/*echo "	<div class=\"m-portlet m-portlet--mobile\">
			<div class=\"m-portlet__head\">
				<div class=\"m-portlet__head-caption\">
					<div class=\"m-portlet__head-title\">
						<h3 class=\"m-portlet__head-text\">
							Data Dosen
						</h3>
					</div>					
				</div>
			</div>";
echo "		<div class=\"m-portlet__body\">
				<!--begin: Datatable -->
				<table class=\"table table-striped- table-bordered table-hover table-checkable\" id=\"m_table_2\">
					<thead>
						<tr>
							<th>No</th>
							<th>Jurusan / Program Studi</th>
							<th>NIDN</th>
							<th>Nama</th>
							<th>Status</th>";*/
/*echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">
									<div class=\"tools\">
										<form target=_blank action='cetakdosen.php' method=post>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi2 value=Cetak class=\"btn btn-brand\"></input>
													</td>
												</tr>
											</table>
										</form>
									</div>
									<div class=\"caption\">";
										printmesg("Data dengan latar belakang kuning berarti ada field2 yang mungkin salah/tidak valid. Silakan diperiksa dengan mengupdate data dosen tersebut.");
echo "								</div>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr>
														<th>No</th>
														<th>Jurusan / Program Studi</th>
														<th>NIDN</th>
														<th>Nama</th>
														<th>Status</th>";*/
echo "						<div class=\"caption\">";
												printmesg("Data dengan latar belakang kuning berarti ada field2 yang mungkin salah/tidak valid. Silakan diperiksa dengan mengupdate data dosen tersebut.");
		echo "						</div>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr>
															<th>No</th>
														<th>Jurusan / Program Studi</th>
														<th>NIDN</th>
														<th>Nama</th>
														<th>Status</th>";															
							
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            #echo "<th scope=\"col\">Edit</th><th scope=\"col\">Hapus</th>";
			echo "<th>Edit</th><th>Hapus</th>";
        }
        #echo "\r\n\t\t\t</tr></thead>\r\n\t\t";
		echo "			</tr> 
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
            #echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}&nbsp;</td>\r\n\t\t\t\t\t<td align=left nowrap> ".$arrayprodidep[$d[IDDEPARTEMEN]]."&nbsp;</td>\r\n \t\t\t\t\t<td align=left><a class='{$cetak}' href='index.php?pilihan=lengkap&id={$d['ID']}'>{$d['ID']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NAMA']}&nbsp;</td>\r\n \t\t\t\t\t<td class='linebore' align=left nowrap>".$arraystatusid[$d[STATUS]]."&nbsp;</td>\r\n \t\t\t\t ";
           # echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}&nbsp;</td>\r\n\t\t\t\t\t<td align=left nowrap> ".$arrayprodidep[$d[IDDEPARTEMEN]]."&nbsp;</td>\r\n \t\t\t\t\t<td align=left><a class='{$cetak}' href='index.php?pilihan=lengkap&id={$d['ID']}'>{$d['ID']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NAMA']}&nbsp;</td>\r\n \t\t\t\t\t<td class='linebore' align=left nowrap>".$arraystatusid[$d[STATUS]]."&nbsp;</td>\r\n \t\t\t\t ";
			echo "<tr align=center {$kelas}{$aksi}>
					<td>{$i}</td>
					<td align=left nowrap> ".$arrayprodidep[$d[IDDEPARTEMEN]]."</td>
					<td align=left><a class='{$cetak}' href='index.php?pilihan=lengkap&id={$d['ID']}'>{$d['ID']}&nbsp;</td>
					<td align=left nowrap>{$d['NAMA']}&nbsp;</td>
					<td class='linebore' align=left nowrap>".$arraystatusid[$d[STATUS]]."&nbsp;</td>";
           	
			if ( $tingkataksesusers[$kodemenu] == "T" )
            {
                echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a class=\"btn green\" href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}&sessid={$_SESSION['token']}'>"."<i class=\"fa fa-edit\"></i>"."</td>\r\n\t\t\t\t\t\t\t\t<td   align=center ><a class=\"btn btn-secondary\" onclick=\"return confirm('Hapus Data Dosen Dengan NIDN = {$d['ID']} ? Seluruh data Pengajaran M-K yang dilakukan oleh dosen ini akan dihapus');\"\r\n\t\t\t\t\t\t\t\thref='{$href}&aksi=hapus&idhapus={$d['ID']}&sessid={$_SESSION['token']}'>"."<i class=\"fa fa-trash\"></i>"."</td>\r\n\t\t\t\t\t\t\t\t";

            }
            echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
            ++$i;
        }
        /*echo "
        </table>{$tpage} {$tpage2}
								</div>
							</div>
						</div>
					</div>
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
					<!--end::Portlet-->			
		</div>
		</form>
									
		<!--end::md-12-->	
	</div>
	<!--end::row-->	
</div>
<!--end::container-fluid-->
</div>
<!--end::page-content-->";
                                    
        if ( $aksi == "cetak" )
        {
            include( "../mahasiswa/prosestampillengkap2.php" );
        }
        $aksi = "tampilkan";
    }
    else
    {
        $errmesg = "Data Dosen Tidak Ada";
        $aksi = "";
    }
}
?>
