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
$arraysort[0] = "fakultas.ID";
$arraysort[1] = "fakultas.NAMA";
$arraysort[2] = "fakultas.NIPPIMPINAN";
$arraysort[3] = "fakultas.NAMAPIMPINAN";
$arraysort[4] = "fakultas.ALAMAT";
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
if ( $aksi != "cetak" )
{
  
    printhelp( trim( $arrayhelp['hasilfakultas'] ), "bantuan" );
}

printmesg( $errmesg );
if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT * FROM fakultas ORDER BY ".$arraysort[$sort]."";
$h = doquery($koneksi, $q );
if ( 0 < sqlnumrows( $h ) )
{
    $href = "index.php?pilihan={$pilihan}&{$aksi}={$aksi}";
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        ";
    if ( $aksi != "cetak" )
    {
        /*echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakfakultas.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";*/
		echo "<div class=\"tools\">
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
	}
    /*echo "\r\n \t\t\t<table {$border} class=form{$aksi}>\r\n\t\t\t<thead>\r\n            <tr class=juduldata{$aksi} align=center>\r\n            \r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}&sort=0'>Kode</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}&sort=1'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}&sort=2'>NIP Pimpinan</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}&sort=3'>Nama Pimpinan</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}&sort=4'>Alamat {$JUDULFAKULTAS}</td>"; */

    /*echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
						<div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">
									<div class=\"caption\">
										<i class=\"fa fa-cogs font-white-sharp\"></i>
										<span class=\"caption-subject font-white-sharp bold uppercase\">Data {$JUDULFAKULTAS}</span>
									</div>
									<div class=\"tools\">
										<form action=cetakfakultas.php target=_blank method=post>
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
											<th scope=\"col\">Kode</th>
											<th scope=\"col\">Nama</th>
											<th scope=\"col\">NIP Pimpinan</th>
											<th scope=\"col\">Nama Pimpinan</th>
											<th scope=\"col\">Alamat Fakultas</th>
											<th scope=\"col\">Edit</th>
											<th scope=\"col\">Hapus</th>";*/
	/*echo "<div class=\"m-portlet m-portlet--mobile\">
			<div class=\"m-portlet__head\">
				<div class=\"m-portlet__head-caption\">
					<div class=\"m-portlet__head-title\">
						<h3 class=\"m-portlet__head-text\">
							Data {$JUDULFAKULTAS}
						</h3>
					</div>
				</div>
			</div>";
	echo "<div class=\"m-portlet__body\">
			<!--begin: Datatable -->
			<table class=\"table table-striped- table-bordered table-hover table-checkable\" id=\"m_table_1\">
				<thead>
					<tr>
						<th>No</th>
						<th>Kode</th>
						<th>Nama</th>
						<th>NIP Pimpinan</th>
						<th>Nama Pimpinan</th>
						<th>Alamat Fakultas</th>
						<th>Edit</th>
						<th>Hapus</th>";*/
	
									
 echo "								<div class='portlet-title'>";
										printtitle("Data {$JUDULFAKULTAS}");
								echo "	</div>";
echo "								
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover table-striped2\">
													<thead>
														<tr>
															<th>No</th>
															<th>Kode</th>
															<th>Nama</th>
															<th>NIP Pimpinan</th>
															<th>Nama Pimpinan</th>
															<th>Alamat Fakultas</th>";
    if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "<th>Edit</th><th>Hapus</th>";
    }
   echo "			</tr> 
				</thead>
					<tbody>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "
                <tr>
                    <td>{$i}</td>
                    <td>{$d['ID']}</td>
                    <td>{$d['NAMA']}<br><i>{$d['NAMA2']}</i></td>
                    <td>{$d['NIPPIMPINAN']}</td>
                    <td>{$d['NAMAPIMPINAN']}</td>
                    <td>{$d['ALAMAT']}</td>";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "<td align=center><a class=\"btn green\" href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}&sessid={$_SESSION['token']}'>"."<i class=\"fa fa-edit\"></i>"."</td>
                    <td align=center ><a class=\"btn red\" onclick=\"return confirm('Hapus Data {$JUDULFAKULTAS} Dengan Kode = {$d['ID']} ?');\" href='{$href}&aksi=hapus&idhapus={$d['ID']}&sessid={$_SESSION['token']}'>"."<i class=\"fa fa-trash\"></i>"."</td>";
        }
        echo "</tr>";
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
}
else
{
    $errmesg = "Data {$JUDULFAKULTAS} Tidak Ada";
    printmesg( $errmesg );
}
?>
