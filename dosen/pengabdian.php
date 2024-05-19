<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$idprodi = getfield( "IDDEPARTEMEN", "dosen", " WHERE ID='{$idupdate}'" );
$namamakul = getfield( "NAMA", "dosen", " WHERE ID='{$idupdate}'" );
/*echo " <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n     <tr class=judulform>\r\n\t\t\t<td width=150>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$idprodi]."\r\n      </td>\r\n\t\t</tr> \r\n    <tr>\r\n      <td>NIDN Dosen</td>\r\n      <td><b>{$idupdate}</td>\r\n    </tr>\r\n    <tr>\r\n      <td>Nama Dosen</td>\r\n      <td><b>".$namamakul."</td>\r\n    </tr>\r\n    </table></div></div>\r\n";
*/
echo "		<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=\"index.php\" method=\"post\">
					<div class=\"m-portlet__body\">	";
		echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arrayprodidep[$idprodi]."</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">NIDN Dosen</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$idupdate}</label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Nama Dosen</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$namamakul."</label>
						</div>";
if ( $aksi2 == "hapus" )
{
    if ( $_SESSION['token'] == $_GET['sessid'] )
    {
        $q = "\r\n  \t\t\t\t\tDELETE FROM dosen_pengabdian\r\n  \t\t\t\t\tWHERE\r\n  \t\t\t\t\tIDDOSEN='{$idupdate}'\r\n  \t\t\t\t\tAND TAHUNSEMESTER='{$tahunsemester}' AND NAMA='{$namakegiatan}'  \r\n  \t\t\t\t";
        doquery($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data Pengabdian Dosen berhasil dihapus";
        }
        else
        {
            $errmesg = "Data Pengabdian Dosen tidak dihapus";
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Pengabdian", HAPUS_DATA );
    }
    $aksi2 = "";
}
if ( $aksi2 == "Simpan" && $REQUEST_METHOD == POST )
{
if ( $_POST['sessid'] == $_SESSION['token'] )
{
    $vldt[] = cekvaliditasthnajaran( "Tahun/Semester Pelaporan", $tahun, $semester );
    $vldt = array_filter( $vldt, "filter_not_empty" );
    if ( isset( $vldt ) && 0 < count( $vldt ) )
    {
        $errmesg = val_err_mesg( $vldt, 2, SIMPAN_DATA );
    }
    else
    {
        $q = " UPDATE dosen_pengabdian SET\r\n\t\t\t\tNAMA='{$namakegiatanbaru}',\r\n\t\t\t\tJENIS='{$jenis}',\r\n        TEMPAT='{$tempat}',\r\n\t\t\t\tTAHUNSEMESTER='{$tahun}{$semester}',\r\n        TANGGAL1='{$tgl1['thn']}-{$tgl1['bln']}-{$tgl1['tgl']}',\r\n        TANGGAL2='{$tgl2['thn']}-{$tgl2['bln']}-{$tgl2['tgl']}',\r\n\t\t\t\tSKS='{$sks}'\r\n\t\t\t\tWHERE IDDOSEN ='{$idupdate}' AND NAMA='{$namakegiatan}' \r\n\t\t\t\tAND TAHUNSEMESTER='{$tahunsemester}'\r\n           ";
        doquery($koneksi,$q);
        echo mysqli_error($koneksi);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $tahunsemester = "{$tahun}{$semester}";
            $namakegiatan = $namakegiatanbaru;
            $errmesg = "Data Pengabdian Dosen berhasil disimpan";
        }
        else
        {
            $errmesg = "Data Pengabdian Dosen tidak disimpan";
        }
    }
}
else
{
    $errmesg = token_err_mesg( "Pengabdian", SIMPAN_DATA );
}
$aksi2 = "formupdate";
}
if ( $aksi2 == "Tambah" && $REQUEST_METHOD == POST )
{
    if ( $_POST['sessid'] == $_SESSION['token'] )
    {
        $vldt[] = cekvaliditasthnajaran( "Tahun/Semester Pelaporan", $tahun, $semester );
        $vldt = array_filter( $vldt, "filter_not_empty" );
        if ( isset( $vldt ) && 0 < count( $vldt ) )
        {
            $errmesg = val_err_mesg( $vldt, 2, TAMBAH_DATA );
        }
        else
        {
            $q = " INSERT INTO dosen_pengabdian \r\n\t\t\t   (TAHUNSEMESTER,  IDDOSEN ,NAMA ,TANGGAL1,TANGGAL2,TEMPAT,JENIS,  SKS )\r\n\t\t\t   VALUES\r\n         ('{$tahun}{$semester}', '{$idupdate}','{$namakegiatanbaru}',\r\n         '{$tgl1['thn']}-{$tgl1['bln']}-{$tgl1['tgl']}', '{$tgl2['thn']}-{$tgl2['bln']}-{$tgl2['tgl']}',\r\n        '{$tempat}','{$jenis}', '{$sks}')\r\n         ";
            doquery($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Pengabdian Dosen berhasil disimpan";
                $data = "";
                $jenis = $media = $tahunp = $bulanp = $pengarang = $mandiri = $biaya = $kodenegara = "";
            }
            else
            {
                $errmesg = "Data Pengabdian Dosen tidak disimpan";
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Pengabdian", TAMBAH_DATA );
    }
    $aksi2 = "formtambah";
}
echo "\r\n<br>\r\n<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n  <tr >\r\n  <td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=formtambah&idupdate={$idupdate}'>\t\t\t\t".IKONTAMBAH." Tambah Data</td>\r\n  <td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=tampilkan&idupdate={$idupdate}'>\t\t\t\t".IKONUPDATE."\r\n Edit Data</td>\r\n  </tr>\r\n</table></div></div>";
printmesg( $errmesg );
if ( $aksi2 == "formupdate" )
{
	$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;

    /*echo "\r\n  <br>\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tahunsemester", "{$tahunsemester}", "" ).createinputhidden( "namakegiatan", "{$namakegiatan}", "" )."\r\n \r\n  ";
    */
	echo createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tahunsemester", "{$tahunsemester}", "" ).createinputhidden( "namakegiatan", "{$namakegiatan}", "" )."\r\n \r\n  ";
	include( "formpengabdian.php" );
    #echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2><input type=submit name=aksi2 value='Simpan' class=\"btn btn-brand\">\r\n\t\t\t\t\t<input type=reset value='Reset' class=\"btn btn-secondary\">\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n</div></div>  </form>\r\n  ";
	echo "					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
										<input type=\"submit\" class=\"btn btn-brand\" name=aksi2 value=Simpan></input>
										<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
								</div>
							</div>
					</div>						
				</form>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->			
		";
}
if ( $aksi2 == "formtambah" )
{
	   $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
 	
    /*echo "\r\n  <br>\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tahunsemester", "{$tahunsemester}", "" )."\r\n  ";
    */
	echo createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tahunsemester", "{$tahunsemester}", "" )."\r\n  ";
	include( "formpengabdian.php" );
    #echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2><input type=submit name=aksi2 value='Tambah' class=\"btn btn-brand\">\r\n\t\t\t\t\t<input type=reset value='Reset' class=\"btn btn-secondary\">\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table></div></div>\r\n  </form>\r\n  ";
	echo "					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
										<input type=\"submit\" class=\"btn btn-brand\" name=aksi2 value=Tambah></input>
										<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
								</div>
							</div>
					</div>						
				</form>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->			
		";
}
if ( $aksi2 == "" || $aksi2 == "tampilkan" )
{
	   $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
 
    $q = "SELECT *,\r\n    DATE_FORMAT(TANGGAL1,'%d-%m-%Y') AS TGL1,\r\n    DATE_FORMAT(TANGGAL2,'%d-%m-%Y') AS TGL2\r\n     FROM dosen_pengabdian WHERE IDDOSEN='{$idupdate}' ORDER BY TAHUNSEMESTER DESC, TANGGAL1, NAMA";
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        /*echo "\r\n\t\t\t<br>\r\n\t\t\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\" {$border} class=data >\r\n \t\t\t\t\r\n\t\t\t\t\t<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Tahun / Semester</td>\r\n\t\t\t\t\t\t<td>Periode Tanggal</td>\r\n\t\t\t\t\t\t<td>Nama Kegiatan</td>\r\n\t\t\t\t\t\t<td>Jenis Kegiatan</td>\r\n\t\t\t\t\t\t<td>Tempat</td> \r\n\t\t\t\t\t\t<td>Jumlah SKS</td> \r\n\t\t\t\t\t\t<td colspan=2>Aksi</td>\r\n\t\t\t\t\t</tr>";
        */
		echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover\">
							<thead>
								 <tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Tahun / Semester</td>\r\n\t\t\t\t\t\t<td>Periode Tanggal</td>\r\n\t\t\t\t\t\t<td>Nama Kegiatan</td>\r\n\t\t\t\t\t\t<td>Jenis Kegiatan</td>\r\n\t\t\t\t\t\t<td>Tempat</td> \r\n\t\t\t\t\t\t<td>Jumlah SKS</td> \r\n\t\t\t\t\t\t<td colspan=2>Aksi</td>\r\n\t\t\t\t\t</tr>";
		echo "				</thead>
							<tbody>";
		$i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $tmp = $d[TAHUNSEMESTER];
            $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
            $semester = $tmp[4];
            echo "\r\n\t\t\t\t\t<tr {$kelas} valign=top>\r\n\t\t\t\t\t\t<td>{$i} </td>\r\n \t\t\t\t\t\t<td align=center nowrap>\r\n             {$tahun}\r\n             ".$arraysemester[$semester]."\r\n             </td>\r\n\t\t\t\t\t\t<td nowrap>{$d['TGL1']} s.d. {$d['TGL2']}</td>\r\n\t\t\t\t\t\t<td>{$d['NAMA']}</td>\r\n\t\t\t\t\t\t<td>".$arrayjenispengabdian[$d[JENIS]]."</td>\r\n\t\t\t\t\t\t<td>{$d['TEMPAT']}</td> \r\n\t\t\t\t\t\t<td align=center>".$d[SKS]."</td> \r\n          <td><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&namakegiatan={$d['NAMA']}&tahunsemester={$d['TAHUNSEMESTER']}&aksi2=formupdate'>".IKONUPDATE."</td>              \r\n          <td><a onClick='return confirm(\"Hapus Data Pengabdian Dosen?\")' href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&namakegiatan={$d['NAMA']}&tahunsemester={$d['TAHUNSEMESTER']}&aksi2=hapus&sessid={$_SESSION['token']}'>".IKONHAPUS."</td>              \r\n\r\n\t\t\t\t\t</tr>";
            ++$i;
        }
       # echo "\r\n\t\t\t\t</table></div><div>\r\n\t\t\t";
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
    }
    else
    {
        echo "<p>";
        printmesg( "Data Pengabdian tidak ada" );
        echo "</p>";
    }
    echo "\r\n\t\t</form>\r\n\t\t\r\n\t\t";
}
?>
