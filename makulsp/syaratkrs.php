<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
cekhaktulis( $kodemenu );
$q = "ALTER TABLE `sksmaksimumsp` ADD `JENISIP` SMALLINT NOT NULL ";
mysqli_query($koneksi,$q);
if ( $aksi == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Syarat KRS", TAMBAH_DATA );
        unset( $_SESSION['token'] );
    }
    else if ( is_array( $idupdate ) )
    {
        $vld[] = cekvaliditaskodeprodi( "Kode Prodi", $idprodi );
        foreach ( $idupdate as $k => $v )
        {
            $vld[] = cekvaliditasinteger( "SKS {$sks[$k]}", $sks[$k], 2 );
            $vld[] = cekvaliditasnumerik( "IP {$ips[$k]}", $ips[$k], 5 );
        }
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 1 );
        }
        else
        {
            foreach ( $idupdate as $k => $v )
            {
                $q = "UPDATE syaratkrssp SET SKS='".$sks[$k]."',IPS='".$ips[$k]."' \r\n\t\t\t\tWHERE ID='{$k}' AND IDPRODI='{$idprodi}'";
                mysqli_query($koneksi,$q);
            }
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Syarat pengambilan KRS berhasil disimpan";
            }
            else
            {
                $errmesg = "Syarat pengambilan KRS tidak berhasil disimpan";
            }
        }
    }
    $aksi = "tampilkan";
}
if ( $aksi2 == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Syarat KRS", TAMBAH_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasinteger( "Kode Prodi", $idprodi );
        $vld[] = cekvaliditasinteger( "SKS Maksimum", $sksmaksimum, 2 );
        $vld[] = cekvaliditasinteger( "SKS Maksimum", $semesteracuan, 2 );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 1 );
        }
        else
        {
            $q = "INSERT INTO sksmaksimumsp (IDPRODI,SKS,SEMESTER,JENISIP) VALUES ('{$idprodi}','{$sksmaksimum}','{$semesteracuan}','{$jenisip}')";
            mysqli_query($koneksi,$q);
            if ( sqlaffectedrows( $koneksi ) < 0 )
            {
                $q = "UPDATE sksmaksimumsp SET SKS='{$sksmaksimum}',\r\n      SEMESTER='{$semesteracuan}',\r\n      JENISIP='{$jenisip}'\r\n       WHERE IDPRODI='{$idprodi}'";
                mysqli_query($koneksi,$q);
            }
        }
    }
    $aksi = "tampilkan";
}
if ( $aksi == "Hapus" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Syarat KRS", TAMBAH_DATA );
        unset( $_SESSION['token'] );
    }
    else if ( is_array( $idupdate ) )
    {
        foreach ( $idupdate as $k => $v )
        {
            $q = "DELETE FROM syaratkrssp WHERE ID='{$k}' AND IDPRODI='{$idprodi}'";
            mysqli_query($koneksi,$q);
        }
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Syarat pengambilan KRS berhasil dihapus";
        }
        else
        {
            $errmesg = "Syarat pengambilan KRS tidak berhasil dihapus";
        }
    }
    $aksi = "tampilkan";
}
if ( $aksi == "Tambah" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Syarat KRS", TAMBAH_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditaskodeprodi( "Kode Prodi", $idprodi );
        $vld[] = cekvaliditasinteger( "SKS", $sksbaru, 2 );
        $vld[] = cekvaliditasnumerik( "IP", $ipsbaru, 5 );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 1, TAMBAH_DATA );
        }
        else if ( $idprodi != "" )
        {
            $idbaru = getnewidsyarat( "ID", "syaratkrssp", " WHERE IDPRODI='{$idprodi}'" );
            $q = "INSERT INTO syaratkrssp (ID,IDPRODI,SKS,IPS)\r\n    VALUES('{$idbaru}','{$idprodi}','{$sksbaru}','{$ipsbaru}')";
            mysqli_query($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Syarat pengambilan KRS berhasil ditambah";
                $sksbaru = $ipsbaru = "";
            }
            else
            {
                $errmesg = "Syarat pengambilan KRS tidak berhasil ditambah";
            }
        }
    }
    $aksi = "tampilkan";
}
if ( $aksi == "tampilkan" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    #printjudulmenu( "Syarat Pengambilan KRS" );
    printmesg( $errmesg );
   echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
<div class=\"row\">
                <div class=\"col-md-12\">
                
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-body form\"><div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Syarat Pengambilan KRS");
								echo	"</div>
									</div>
									<div class='portlet-body form'>";
    echo "								<form name=form action=index.php method=post>
											<input type=hidden name=pilihan value='{$pilihan}'>
											<input type=hidden name=sessid value='{$token}'>
											<input type=hidden name=idprodi value='{$idprodi}'>
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>\r\n\t\t\t\t\tJurusan / Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td><b>  ".$arrayprodidep[$idprodi]."\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>";
    $q = "SELECT * FROM syaratkrssp WHERE IDPRODI='{$idprodi}' ORDER BY SKS DESC";
    $h = mysqli_query($koneksi,$q);
    echo "\r\n      <br>\r\n        <table class=\"table table-striped table-bordered table-hover\">\r\n          <tr class=juduldata align=center>\r\n            <td>No</td>\r\n            <td>SKS yg diambil</td>\r\n            <td>IP Minimum</td>\r\n            <td >Aksi (pilih)</td>\r\n          </tr>";
    echo "\r\n            <tr align=center valign=top {$kelas}>\r\n             <td>*</td>\r\n            <td>SKS >= <input type=text size=4 name='sksbaru' value='{$sksbaru}'></td>\r\n            <td>IP >= <input type=text size=4 name='ipsbaru' value='{$ipsbaru}'></td>\r\n            <td ><input type=submit name=aksi value='Tambah' class=\"btn btn-brand\"></td>\r\n             \r\n            </tr>\r\n            ";
    if ( 0 < sqlnumrows( $h ) )
    {
        $i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            echo "\r\n            \r\n            <tr align=center valign=top {$kelas}>\r\n            <td>{$i}</td>\r\n            <td>SKS >= <input type=text size=4 name='sks[{$d['ID']}]' value='{$d['SKS']}'></td>\r\n            <td>IP >= <input type=text size=4 name='ips[{$d['ID']}]' value='{$d['IPS']}'></td>\r\n            <td><input type=checkbox name='idupdate[{$d['ID']}]' value=1></td>\r\n             \r\n            </tr>\r\n            ";
            ++$i;
        }
        echo "\r\n            <tr align=center valign=top {$kelas}>\r\n             <td colspan=3 align=right >Yg dipilih : </td>\r\n            <td nowrap><input type=submit name=aksi class=\"btn btn-brand\" value='Simpan'>\r\n            <input type=submit name=aksi value='Hapus' class=\"btn btn-secondary\"></td>\r\n             \r\n            </tr>\r\n            ";
    }
    else
    {
        printmesg( "Data syarat pengambilan KRS tidak ada" );
    }
    echo "\r\n        </table>\r\n      ";
    $q = "SELECT * FROM sksmaksimumsp WHERE IDPRODI='{$idprodi}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $sksmaksimum = $d[SKS];
        $semesteracuan = $d[SEMESTER];
    }
    $cekjenisip0 = $cekjenisip1 = "";
    if ( $d[JENISIP] + 0 == 0 )
    {
        $cekjenisip0 = "checked";
    }
    else
    {
        $cekjenisip1 = "checked";
    }
    echo "\r\n    <table class=\"table table-striped table-bordered table-hover\" >\r\n      <tr>\r\n      <td width=100>SKS Maksimum</td>\r\n      <td><input type=text size=2 name=sksmaksimum value='{$sksmaksimum}'> Kosongkan (0) untuk pengambilan SKS maksimum yang tidak dibatasi</td>\r\n      </tr>\r\n     <tr>\r\n      <td  >Semester IP Acuan</td>\r\n      <td><input type=text size=2 name=semesteracuan value='{$semesteracuan}'> semester yang lalu. \r\n      </tr>\r\n     <tr>\r\n      <td  >JENIS IP</td>\r\n      <td>\r\n      <input type=radio  name=jenisip value=0 {$cekjenisip0}> IP Semester (IPS) <br> \r\n      <input type=radio  name=jenisip value=1 {$cekjenisip1}> IP Kumulatif (IPK) <br> \r\n      </tr>\r\n\r\n      <tr>\r\n      <td></td>\r\n      <td><input type=submit name=aksi2 value='Simpan' class=\"btn btn-brand\"></td>\r\n      </tr>\r\n    </table>";
    echo "\r\n\t\t</form> </div></div></div></div></div></div></div></div>";
}
if ( $aksi == "" )
{
    #printjudulmenu( "Syarat Pengambilan KRS" );
   echo "	<div class=\"page-content\">
				<div class=\"container-fluid\">
					<div class=\"row\">
						<div class=\"col-md-12\">
							<!-- BEGIN SAMPLE FORM PORTLET-->
							";
								printmesg( $errmesg );
	echo "					<div class='portlet-title'>";
								printmesg("Syarat Pengambilan KRS");
	echo "					</div>";
	echo "					<div class=\"m-portlet\">
								<!--begin::Form-->";                    
    echo "										<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
													<input type=hidden name=pilihan value='{$pilihan}'>
													<input type=hidden name=aksi value='tampilkan'>
													<div class=\"m-portlet__body\">
														<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
															<label class=\"col-lg-2 col-form-label\">Jurusan / Program Studi</label>\r\n    
															<label class=\"col-form-label\">
																<select class=form-control m-input name=idprodi>";
																	foreach ( $arrayprodidep as $k => $v )
																	{
																		echo "<option value='{$k}'>{$v}</option>";
																	}
    echo "														</select>
															</label>
														</div>
														<div class=\"form-group m-form__group row\">
															<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
															<div class=\"col-lg-6\">
																<input type=submit value='Lanjutkan' class=\"btn btn-brand\">
															</div>
														</div>
													</div>
					 </form>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->
					</div>
		<!--end::md-12-->	
	</div>
	<!--end::row-->	
</div>
<!--end::container-fluid-->
            <script>
                form.id.focus();
            </script>
    ";  
}
?>
