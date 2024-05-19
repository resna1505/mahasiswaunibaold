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
$arraysort[0] = "departemen.IDFAKULTAS";
$arraysort[1] = "departemen.ID";
$arraysort[2] = "departemen.NAMA";
$arraysort[3] = "departemen.NIPPIMPINAN";
$arraysort[4] = "departemen.NAMAPIMPINAN";
$arraysort[5] = "departemen.ALAMAT";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $idfakultas != "" )
{
    $qfield .= " AND IDFAKULTAS='{$idfakultas}'";
    $qjudul .= "  {$JUDULFAKULTAS} '".$arrayfakultas[$idfakultas]."'";
    $qinput .= " <input type=hidden name=idfakultas value='{$idfakultas}'>";
    $href .= "idfakultas={$idfakultas}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT * FROM departemen \r\n\tWHERE 1=1\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]."";
$h = doquery($koneksi, $q );
if ( 0 < sqlnumrows( $h ) )
{
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        ";
									
									
    if ( $aksi != "cetak" )
    {
		echo "						<div class=\"tools\">
										<form target=_blank action='cetakfakultas.php' method=post>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi2 value=Cetak class=\"btn btn-success\"></input>
													</td>
												</tr>
											</table>
										</form>
									</div>";
        #printhelp( trim( $arrayhelp[hasiljurusan] ), "bantuan" );
        #printmesg( $qjudul );
        #printmesg( $errmesg );
    }
	
		
		echo "						<div class='portlet-title'>";
										printmesg($errmesg);
										printtitle("Data Jurusan");
		echo "						</div>";
		echo "						<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover table-striped2\">
													<thead>
														<tr>
															<th>No</th>
															<th>{$JUDULFAKULTAS}</th>
															<th>Kode</th>
															<th>Nama</th>
															<th>NIP Ketua</th>
															<th>Nama Ketua</th>
															<th>Alamat Jurusan</th>";
    #else
    #{
        #printjudulmenucetak( "Data Jurusan" );
        #printmesgcetak( $qjudul );
    #}
    #if ( $aksi != "cetak" )
    #{
        /*echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakdepartemen.php'>\r\n \t\t\t\t".IKONCETAK32." <input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";*/
    #}
    /*echo "\r\n \t\t\t<table class=form width=900 cellpadding=0 cellspacing=0>\r\n            <thead>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=0'>{$JUDULFAKULTAS}</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=1'>Kode</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=2'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=3'>NIP Ketua</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=4'>Nama Ketua</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=5'>Alamat Jurusan</td>";*/

    /*echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">";
						printmesg( $errmesg );
						echo "
						<div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">
									<!--<div class=\"caption\">
										<i class=\"fa fa-cogs font-white-sharp\"></i>
										<span class=\"caption-subject font-white-sharp bold uppercase\">Data Jurusan</span>
									</div>-->
									
									<div class=\"tools\">
										<form target=_blank action='cetakdepartemen.php' method=post>
											<input type=submit name=aksi value=Cetak class=\"btn green\"></input>
										</form>
									</div>
								</div>
								<div class=\"portlet-body\">
									<div class=\"table-scrollable\">
										<table class=\"table table-striped table-bordered table-hover\">
										<thead>
										<tr>
											<th scope=\"col\">No</th>
											<th scope=\"col\">{$JUDULFAKULTAS}</th>
											<th scope=\"col\">Kode</th>
											<th scope=\"col\">Nama</th>
											<th scope=\"col\">NIP Ketua</th>
											<th scope=\"col\">Nama Ketua</th>
											<th scope=\"col\">Alamat Jurusan</th>
											<th scope=\"col\">Edit</th>
											<th scope=\"col\">Hapus</th> ";*/
	/*echo "<div class=\"m-portlet m-portlet--mobile\">
			<div class=\"m-portlet__head\">
				<div class=\"m-portlet__head-caption\">
					<div class=\"m-portlet__head-title\">
						<h3 class=\"m-portlet__head-text\">
							Data Jurusan
						</h3>
					</div>
				</div>
			</div>";
	echo "<div class=\"m-portlet__body\">
			<!--begin: Datatable -->
			<table class=\"table table-striped- table-bordered table-hover table-checkable\" id=\"m_table_2\">
				<thead>
					<tr>
						<th>No</th>
						<th>{$JUDULFAKULTAS}</th>
						<th>Kode</th>
						<th>Nama</th>
						<th>NIP Ketua</th>
						<th>Nama Ketua</th>
						<th>Alamat Jurusan</th>
						<th>Edit</th>
						<th>Hapus</th>";*/
    if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "<th>Edit</th>
						<th>Hapus</th>";
    }
    echo "			</tr> 
				</thead>
					<tbody>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        /*echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td width=5>{$i}</td>\r\n\t\t\t\t\t<td width=160 align=left nowrap>{$d['IDFAKULTAS']} - ".$arrayfakultas[$d['IDFAKULTAS']]."&nbsp;</td>\r\n\t\t\t\t\t<td width=5>{$d['ID']}&nbsp;</td>\r\n\t\t\t\t\t<td width=140 align=left nowrap>{$d['NAMA']}&nbsp;</td>\r\n\t\t\t\t\t<td width=20 align=left>{$d['NIPPIMPINAN']}&nbsp;</td>\r\n\t\t\t\t\t<td width=90 align=left>{$d['NAMAPIMPINAN']}&nbsp;</td>\r\n\t\t\t\t\t<td width=180 align=left>{$d['ALAMAT']}&nbsp;</td>";*/

        echo "
                <tr {$kelas}{$aksi}>
                    <td>{$i}</td>
                    <td>{$d['IDFAKULTAS']}-".$arrayfakultas[$d['IDFAKULTAS']]."</td>
                    <td>{$d['ID']}</td>
                    <td>{$d['NAMA']}<br><i>{$d['NAMA2']}</i></td>
                    <td>{$d['NIPPIMPINAN']}</td>
                    <td>{$d['NAMAPIMPINAN']}</td>
                    <td>{$d['ALAMAT']}</td>";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            /*echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}&{$_SESSION['token']}'>\r\n                ".IKONUPDATE."\r\n                </td>\r\n\t\t\t\t\t\t\t\t<td   align=center ><a onclick=\"return confirm('Hapus Data Jurusan Dengan Kode = {$d['ID']} ?');\"\r\n\t\t\t\t\t\t\t\thref='{$href}&aksi=hapus&idhapus={$d['ID']}&sessid={$_SESSION['token']}'>\r\n                ".IKONHAPUS."\r\n                </td>\r\n\t\t\t\t\t\t\t\t";*/

            echo "<td align=center><a class=\"btn green\" href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}&sessid={$_SESSION['token']}'>"."<i class=\"fa fa-edit\"></i>"."</td>
                    <td align=center ><a class=\"btn red\" onclick=\"return confirm('Hapus Data {$JUDULFAKULTAS} Dengan Kode = {$d['ID']} ?');\"\r\n\t\t\t\t\t\t\t\t href='{$href}&aksi=hapus&idhapus={$d['ID']}&sessid={$_SESSION['token']}'>"."<i class=\"fa fa-trash\"></i>"."</td>";
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Portlet-->			
		</div>
		<!--end::md-12-->	
	</div>
	<!--end::row-->	
</div>
<!--end::container-fluid-->";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Jurusan Tidak Ada";
    $aksi = "";
}
?>
