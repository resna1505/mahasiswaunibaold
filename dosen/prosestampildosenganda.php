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
        $qfield .= " AND dosen.ID LIKE '{$id}'";
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
    $q = "SELECT dosen.ID,COUNT(*) AS JML FROM dosen,msdos  \r\n\t\tWHERE 1=1 AND \r\n    dosen.ID=msdos.NODOSMSDOS\r\n    {$qprodidep3}\r\n\t\t{$qfield}\r\n\t\tGROUP BY dosen.ID\r\n\t\tHAVING JML > 1\r\n\t\t";
    if ( 0 < sqlnumrows( $h ) )
    {
        $h = doquery($koneksi,$q);
        while ( $d = sqlfetcharray( $h ) )
        {
            $arraydosenganda[$d[ID]] = 1;
        }
    }
    $q = "SELECT dosen.ID,dosen.IDDEPARTEMEN ,dosen.NAMA,msdos.* \r\n    FROM  dosen  ,msdos\r\n\tWHERE \r\n   dosen.ID=msdos.NODOSMSDOS\r\n   \r\n\t{$qprodidep3}\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]."  ";
   # echo $q;
	$h = doquery($koneksi,$q);
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
			echo "						<div class=\"tools\">
										<form target=_blank action='cetakdosen.php' method=post>
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
            #printjudulmenu( "Periksa Data Dosen Ganda", "bantuan" );
            #printhelp( trim( $arrayhelp[hasildosen] ), "bantuan" );
            #printmesg( $qjudul );
            #printmesg( $errmesg );
        }
        #else
        #{
            #printjudulmenucetak( "Data Dosen" );
            #printmesgcetak( $qjudul );
        #}
		 /*echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">
									<div class=\"caption\">
										<i class=\"fa fa-cogs font-white-sharp\"></i>
										Data Dosen
									</div>
									<div class=\"tools\">
										<form target=_blank action='cetakdosen.php' method=post>
											<input type=submit name=aksi2 value=Cetak class=\"btn green\"></input>
										</form>
									</div>
								</div>
								<div class=\"portlet-body\">
									<table class=\"table table-striped table-bordered table-hover\">
									<thead>
									<tr>
										<th scope=\"col\">No</th>
										<th scope=\"col\">Jurusan/Program Studi</th>
										<th scope=\"col\">NIDN</th>
										<th scope=\"col\">Nama</th>
										<th scope=\"col\">Status</th> ";*/
		 /*echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">
									
									<div class=\"caption\">";
										printmesg("Periksa Data Dosen Ganda");
echo "								</div>
								</div>";
echo "	<div class=\"m-portlet m-portlet--mobile\">
			";
echo "		<div class=\"m-portlet__body\">
				<!--begin: Datatable -->
				<table class=\"table table-striped- table-bordered table-hover table-checkable\" id=\"m_table_2\">
					<thead>
						<tr>
							<th>No</th>
							<th>PRODI (DOSEN)</th>
							<th>KODE JENJANG (MSDOS)</th>
							<th>KODE PST (MSDOS)</th>
							<th>NAMA PRODI (MSDOS)</th>
							<th>NIDN</th>
							<th>Nama</th>
							<th>KTP</th>
							<th>Gelar</th>
							<th>TTL</th>";*/
		echo "						<div class=\"caption\">";
										printmesg("Periksa Data Dosen Ganda");
		echo "						</div>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr>
															<th>No</th>
															<th>PRODI (DOSEN)</th>
															<th>KODE JENJANG (MSDOS)</th>
															<th>KODE PST (MSDOS)</th>
															<th>NAMA PRODI (MSDOS)</th>
															<th>NIDN</th>
															<th>Nama</th>
															<th>KTP</th>
															<th>Gelar</th>
															<th>TTL</th>";				
        #echo "\r\n \t\t\t<table {$border} class=form{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td rowspan=2>No</td>\r\n\t\t\t\t<td rowspan=2><a class='{$cetak}' href='{$href}"."&sort=0'>PRODI (DOSEN)</td>\r\n\t\t\t\t<td colspan=3>MSDOS</td>\r\n\t\t\t\t<td rowspan=2> <a class='{$cetak}' href='{$href}"."&sort=1'>NIDN</td>\r\n\t\t\t\t<td rowspan=2><a class='{$cetak}' href='{$href}"."&sort=2'>Nama</td>\r\n\t\t\t\t<td rowspan=2>KTP</td>\r\n\t\t\t\t<td rowspan=2>GELAR</td>\r\n\t\t\t\t<td rowspan=2>TTL</td>\r\n\r\n\r\n \t\t\t ";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
           echo "<th nowrap>Aksi</th>";
        }
        #echo "\r\n\t\t\t</tr>\r\n\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>KODE JENJANG (MSDOS)</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>KODE PST (MSDOS)</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'>NAMA PRODI (MSDOS)</td>\r\n\t\t\t</tr>\r\n\r\n\r\n\t\t";
         echo "			</tr> 
				</thead>
					<tbody>";
		$i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            if ( $arraydosenganda[$d[ID]] == 1 )
            {
                $kelas = kelas( $i );
                $namaprodimspst = "";
                $q = "SELECT NMPSTTBPST\t AS NAMA FROM tbpst WHERE KDPSTTBPST\t='{$d['KDPSTMSDOS']}' AND KDJENTBPST\t= '{$d['KDJENMSDOS']}'";
                $hn = doquery($koneksi,$q);
                echo mysqli_error($koneksi);
                if ( 0 < sqlnumrows( $hn ) )
                {
                    $dn = sqlfetcharray( $hn );
                    $namaprodimspst = $dn[NAMA];
                }
                echo "\r\n    \t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n    \t\t\t\t\t<td>{$i} </td>\r\n    \t\t\t\t\t<td align=left  > ".$arrayprodidep[$d[IDDEPARTEMEN]]."</td>\r\n    \t\t\t\t\t<td align=left  > {$d['KDJENMSDOS']} / ".$arrayjenjang[$d[KDJENMSDOS]]."</td>\r\n    \t\t\t\t\t<td align=left  > ".$d[KDPSTMSDOS]."</td>\r\n    \t\t\t\t\t<td align=left  > ".$namaprodimspst."</td>\r\n     \t\t\t\t\t<td align=left> {$d['ID']}</td>\r\n     \t\t\t\t\t<td align=left  >{$d['NAMA']}</td>\r\n     \t\t\t\t\t<td align=left  >{$d['NOKTPMSDOS']}</td>\r\n     \t\t\t\t\t<td align=left  >{$d['GELARMSDOS']}</td>\r\n     \t\t\t\t\t<td align=left  >{$d['TPLHRMSDOS']} /  {$d['TGLHRMSDOS']}</td>\r\n      \t\t\t\t ";
                if ( !( $d[KDJENMSPST] != $d[KDJENMSDOS] && $d[KDPSTMSPST] != $d[KDPSTMSDOS] && $aksi != "cetak" ) || $tingkataksesusers[$kodemenu] == "T" )
                {
                   echo "\r\n     \t\t\t\t\t\t\t\t<td   align=center ><a onclick=\"return confirm('Hapus Data MSDOS Dosen Dengan NIDN = {$d['ID']} dan JENJANG = \\'".$arrayjenjang[$d[KDJENMSDOS]]."\\' serta Kode PST = \\'{$d['KDPSTMSDOS']}\\' ?');\"\r\n    \t\t\t\t\t\t\t\thref='{$href}&aksi=hapus&idhapus={$d['ID']}&jenjanghapus={$d['KDJENMSDOS']}&kodepsthapus={$d['KDPSTMSDOS']}&sessid={$_SESSION['token']}'>".IKONHAPUS."</td>\r\n    \t\t\t\t\t\t\t\t";
                }
                echo "\r\n    \t\t\t\t</tr>\r\n    \t\t\t";
                ++$i;
            }else{
				
				$errmesg = "Tidak ada Data Dosen Ganda";
				$aksi = "";
			}
        }
        #echo "</table>";
		/*echo "			</tbody>
			</table>
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
        $errmesg = "Data Dosen Tidak Ada";
        $aksi = "";
    }
}
?>
