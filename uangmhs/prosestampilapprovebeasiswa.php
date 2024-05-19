<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi2 == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Appove Beasiswa Mahasiswa", SIMPAN_DATA );
    }
    else
    {
        foreach ( $arraydatamahasiswa as $k => $v )
        {
            if ( $pilihmahasiswa[$k] == 1 )
            {
                $q = "UPDATE mahasiswa SET APPROVEBEASISWA='1' WHERE ID='{$k}'";
            }
            else
            {
                $q = "UPDATE mahasiswa SET APPROVEBEASISWA='0' WHERE ID='{$k}'";
            }
			#echo $q.'<br>';
            mysqli_query($koneksi,$q);
        }
        $errmesg = "Data approve beasiswa sudah disimpan.";
    }
}
unset( $arraysort );
$arraysort[0] = "mahasiswa.IDPRODI";
$arraysort[1] = "mahasiswa.ANGKATAN";
$arraysort[2] = "mahasiswa.ID";
$arraysort[3] = "mahasiswa.NAMA";
$arraysort[4] = "mahasiswa.STATUS";
$arraysort[5] = "mahasiswa.IDDOSEN";
$vldts[] = cekvaliditasinteger( "Jurusan/Prodi", $idprodi, 10 );
$vldts[] = cekvaliditastahun( "Angkatan", $angkatan );
$vldts[] = cekvaliditaskode( "NIM", $id, 16 );
$vldts[] = cekvaliditasnama( "Nama", $nama, 32 );
$vldts = array_filter( $vldts, "filter_not_empty" );
if ( isset( $vldts ) && 0 < count( $vldts ) )
{
    $errmesg = "Data pencarian berikut tidak valid, silahkan cek kembali".inv_message( $vldts, 2 );
    unset( $vldts );
    $aksi = "";
}
else
{
    $href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
    if ( $idprodi != "" )
    {
        $qfield .= " AND mahasiswa.IDPRODI='{$idprodi}'";
        $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
        $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
        $href .= "idprodi={$idprodi}&";
    }
    if ( $angkatan != "" )
    {
        $qfield .= " AND mahasiswa.ANGKATAN='{$angkatan}'";
        $qjudul .= " Angkatan '{$angkatan}' <br>";
        $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
        $href .= "angkatan={$angkatan}&";
    }
    if ( $id != "" )
    {
        $qfield .= " AND mahasiswa.ID LIKE '%{$id}%'";
        $qjudul .= " NIM mengandung kata '{$id}' <br>";
        $qinput .= " <input type=hidden name=id value='{$id}'>";
        $href .= "id={$id}&";
    }
    if ( $nama != "" )
    {
        $qfield .= " AND mahasiswa.NAMA LIKE '%{$nama}%'";
        $qjudul .= " Nama mengandung kata '{$nama}' <br>";
        $qinput .= " <input type=hidden name=nama value='{$nama}'>";
        $href .= "nama={$nama}&";
    }
    $qtabel = "";
    if ( $arraysort[$sort] == "" )
    {
        $sort = 2;
    }
    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $q = "SELECT mahasiswa.ID,mahasiswa.NAMA,mahasiswa.ANGKATAN,mahasiswa.STATUS,mahasiswa.IDDOSEN,mahasiswa.IDPRODI, mahasiswa.APPROVEBEASISWA,\r\n\t  COUNT(diskonbeasiswa.IDMAHASISWA) AS JUMLAHBEASISWA\r\n  FROM  mahasiswa  LEFT JOIN diskonbeasiswa ON mahasiswa.ID=diskonbeasiswa.IDMAHASISWA \r\n\tWHERE  1=1\r\n   {$qprodidep2} {$qfield} AND mahasiswa.STATUS='A' GROUP BY mahasiswa.ID HAVING (JUMLAHBEASISWA IS NOT NULL AND JUMLAHBEASISWA > 0  )\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
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
								<div class=\"portlet-title\">";
        #printmesg( $errmesg );
		echo "						<div class=\"caption\">";
                                                printtitle("Data Approval Beasiswa");
                                                printmesg($errmesg);
		echo "						</div>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>";
        $token = md5( uniqid( rand( ), TRUE ) );
        $_SESSION['token'] = $token;
        #echo "\r\n    <form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>".createinputhidden( "sessid", $_SESSION['token'], "" )."\r\n\t\t\t<input type=hidden name=aksi value='{$aksi}'>      \r\n      {$input}\r\n      {$qinput}\r\n \t\t\t<table {$border} class=form{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n \t\t\t\t\t\t\t<td nowrap colspan=6 align=right ><input type=submit name=aksi2 value='Simpan' ></td> \r\n\t\t\t</tr>\r\n\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td><b>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'><b>Jurusan/Program Studi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'><b>Angkatan</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'><b>NIM</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'><b>Nama</td> \r\n\t\t\t\t\t\t\t<td nowrap  ><b>Pilih untuk approve</td> \r\n\t\t\t</tr>\r\n\t\t";
        echo "<form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>".createinputhidden( "sessid", $_SESSION['token'], "" )."\r\n\t\t\t<input type=hidden name=aksi value='{$aksi}'>      \r\n      {$input}\r\n      {$qinput}\r\n \t\t\t<tr class=juduldata{$aksi} align=center>\r\n \t\t\t\t\t\t\t<td nowrap colspan=6 align=right ><input type=submit name=aksi2 value='Simpan' ></td> \r\n\t\t\t</tr>\r\n\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td><b>No</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=0'><b>Jurusan/Program Studi</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=1'><b>Angkatan</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=2'><b>NIM</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."&sort=3'><b>Nama</td> \r\n\t\t\t\t\t\t\t<td nowrap  ><b>Pilih untuk approve</td> \r\n\t\t\t</tr>\r\n\t\t";
		echo "		
				</thead>
					<tbody>";
		$i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $cekapprovebeasiswa = "";
            if ( $d[APPROVEBEASISWA] == 1 )
            {
                $cekapprovebeasiswa = "checked";
            }
            echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n\t\t\t\t\t<td align=left nowrap>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n \t\t\t\t\t<td align=center>{$d['ANGKATAN']}</td>\r\n \t\t\t\t\t<td align=left> {$d['ID']}</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NAMA']} </td><td align=\"center\"> ";
            //cek ipk lebih besar sama dengan 3
            $sql_ipk="SELECT NLIPKTRAKM FROM trakm WHERE NIMHSTRAKM='".$d['ID']."' AND NLIPKTRAKM!=0 ORDER BY THSMSTRAKM DESC LIMIT 1 ";
            #echo $sql_ipk;
            $query_ipk=mysqli_query($koneksi,$sql_ipk);
            $data_ipk=sqlfetcharray($query_ipk); 
            if ( getaturan( "APPROVEBEASISWA" ) == 1 && $_SESSION['jeniss'] == 1){
                if(($_SESSION['users']=='fariz02' || $_SESSION['users']=='Mercy01') && ($data_ipk['NLIPKTRAKM']>='3.00' || $d['ANGKATAN']=='2021')){
          
                    echo "<input type=\"checkbox\" name='pilihmahasiswa[{$d['ID']}]' value=1 {$cekapprovebeasiswa} >\r\n                <input type=hidden name='arraydatamahasiswa[{$d['ID']}]' value='{$d['ID']}'>";
               
                }elseif($_SESSION['users']=='elly123' || $_SESSION['users']=='admin'){
               
                    echo "<input type=\"checkbox\" name='pilihmahasiswa[{$d['ID']}]' value=1 {$cekapprovebeasiswa} >\r\n                <input type=hidden name='arraydatamahasiswa[{$d['ID']}]' value='{$d['ID']}'>";
                }                
                else{
                    echo "";
                }    
            }
            echo "</td></tr>";
            ++$i;
        }
        echo "\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n \t\t\t\t\t\t\t<td nowrap colspan=6 align=right ><input type=submit name=aksi2 value='Simpan' ></td> \r\n\t\t\t</tr>\r\n\r\n    </table>\r\n    </form>";
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
        $errmesg = "Data Mahasiswa Tidak Ada";
        $aksi = "";
    }
}
?>
