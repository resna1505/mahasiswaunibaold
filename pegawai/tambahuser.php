<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\n\t.dataform2ganjil {\r\n\t\tbackground:#E2F3FA;\r\n\t\t}\r\n\t\t\r\n\t.dataform2genap {\r\n\t\tbackground:#D7EAF1;\r\n\t\t}\r\n\r\n</style>\r\n";
periksaroot();
cekhaktulis($kodemenu );
$ok = true;
#echo $namausers.$iduser;exit();
#print_r($tingkatusers);
if ( !isset( $aksi ) )
{
    $aksi == "tambahuser";
}
if ( $aksi == "updateuser" )
{
	#echo $iduser;exit();
    $judul = "Update data Operator";
    if ( $aksiuser == "" )
    {
        if ( trim( $iduser ) == "" )
        {
            $ok = false;
            $err = "id kosong";
            $errmesg = "Id user harus diisi";
        }
        else if ( $iduser == "superadmin" )
        {
            $ok = false;
            $errmesg = "Data 'superadmin' tidak dapat diubah";
        }
        $query = "SELECT NAMA,TINGKAT,PASSWORD,  IDPRODI,JENIS,STATUSLOGIN,LASTAKSI,LASTLOGIN,STATUS,\r\n\t\t\tLOGINWAKTU,JAM1,JAM2\r\n\r\n\t\t\tFROM user WHERE ID='{$iduser}' AND ID!='superadmin'";
        $hasil =mysqli_query($koneksi,$query);
        if ( sqlnumrows( $hasil ) != 1 )
        {
            $ok = false;
            if ( $iduser == "superadmin" )
            {
                $errmesg = "Data 'superadmin' tidak dapat diubah";
            }
            else if ( trim( $iduser ) == "" )
            {
                $errmesg = "Id user harus diisi";
            }
            else
            {
                $errmesg = "Tidak ada user dengan ID='{$iduser}'";
            }
            $aksi = "update";
            include( "updateuser.php" );
            exit( );
        }
        else
        {
            $datauser = sqlfetcharray( $hasil );
            $nama = $datauser[NAMA];
            $tingkat = $datauser[TINGKAT];
            $tmp = explode( ",", $tingkat );
            $tingkat = $tmp;
            $pwduser = $datauser[PASSWORD];
            $idprodi = $datauser[IDPRODI];
            $jenisopr = $datauser[JENIS];
            $statuslogin = $datauser[STATUSLOGIN];
            $lastlogin = $datauser[LASTLOGIN];
            $lastaksi = $datauser[LASTAKSI];
            $status = $datauser[STATUS];
            $loginwaktu = $datauser[LOGINWAKTU];
            $jam1 = $datauser[JAM1];
            $jam2 = $datauser[JAM2];
            $cekloginwaktu = "";
            if ( $loginwaktu == 1 )
            {
                $cekloginwaktu = "checked";
            }
            $tingkatakses = explode( ",", $datauser[TINGKAT] );
            unset( $tmp );
            foreach ( $tingkatakses as $k => $v )
            {
                $tmp2 = explode( ":", $v );
                $tmp["{$tmp2['0']}"] = $tmp2[1];
            }
            $tingkatakses = $tmp;
        }
    }
}
else
{
    $judul = "Tambah data Operator";
}
if ( ( $aksiuser == "Tambah" || $aksiuser == "Update" ) && $REQUEST_METHOD == POST )
{
    if ( $iduser == "superadmin" )
    {
        $ok = false;
        $errmesg = "'superadmin' tidak boleh digunakan sebagai ID";
    }
    $iduser = trim( $iduser );
    $nama = trim( $nama );
    if ( $iduser == "" )
    {
        $ok = false;
        $errmesg = "ID User harus diisi";
    }
    else if ( $nama == "" )
    {
        $ok = false;
        $errmesg = "Nama harus diisi";
    }
    else if ( $pwd == "" )
    {
        if ( $aksiuser == "Tambah" )
        {
            $ok = false;
            $errmesg = "Password harus diisi";
        }
    }
    else if ( $pwd2 == "" )
    {
        if ( $aksiuser == "Tambah" )
        {
            $ok = false;
            $errmesg = "Konfirmasi Password harus diisi";
        }
    }
    else if ( $pwd != $pwd2 && $pwd != "" )
    {
        $ok = false;
        $errmesg = "Password dan Konfirmasi Password harus sama";
    }
    if ( is_array( $tingkataksesku ) )
    {
        $i = 0;
        $count = count( $tingkataksesku );
        $tmp = "";
        $br = "";
        foreach ( $tingkataksesku as $k => $v )
        {
            if ( $v == "N" )
            {
                continue;
            }
            if ( $i < $count - 1 )
            {
                $br = ",";
            }
            $tmp .= $k.":".$v."{$br}";
            $br = "";
            ++$i;
        }
        $tingkatu = $tingkatakses = $tmp;
    }
    if ( $aksiuser == "Tambah" )
    {
        buatlog( 14, $namausers.";NIP={$iduser}" );
        $query = "INSERT INTO user \r\n      \r\n          (\r\n          `ID` ,\r\n          `IDPRODI` ,\r\n          `NAMA` ,\r\n          `PASSWORD` ,\r\n          `TINGKAT` ,\r\n          `LASTUPDATE` ,\r\n          `UPDATER` ,\r\n          `CSS` ,\r\n          `JENIS` ,\r\n          `SETTINGTAMPILAN` ,\r\n          `STATUSLOGIN` ,\r\n          `LASTLOGIN` ,\r\n          `LASTAKSI` ,\r\n          `TOKEN` ,\r\n          `STATUS`,\r\n          FLAGPASSWORD,\r\n          LOGINWAKTU,\r\n          JAM1,JAM2\r\n          )      \r\n      \r\n      VALUES\r\n\t\t\t\t('{$iduser}','{$idprodi}', '{$nama}',PASSWORD('{$pwd}'), \r\n\t\t\t\t '{$tingkatu}',NOW(),'{$namausers}', \r\n\t\t\t\t 'style.inc','{$jenisopr}','','0',NULL,NULL,'',1,1,\r\n\t\t\t\t '{$loginwaktu}','{$jam1}','{$jam2}'\r\n\t\t\t\t)";
    }
    else if ( $aksiuser == "Update" )
    {
        if ( $pwd == $pwd2 )
        {
            if ( $pwd != "" )
            {
                $pwd = "PASSWORD('{$pwd}'),\r\n        FLAGPASSWORD=1";
            }
            else
            {
                $pwd = "'{$pwduser}'";
            }
        }
        else
        {
            $ok = false;
            $errmesg = "Passowrd dan Konfirmasi Password harus sama";
        }
        $qlogout = "";
        if ( $iflogout == 1 )
        {
            $qlogout = ", STATUSLOGIN=0 ";
        }
        $query = "UPDATE user SET\r\n\t\t\t\tNAMA='{$nama}',\r\n \t\t\t\tPASSWORD={$pwd},\r\n \t\t\t\tTINGKAT='{$tingkatu}',\r\n \t\t\t\tJENIS='{$jenisopr}',\r\n\t\t\t\tLASTUPDATE=NOW(),UPDATER='{$namausers}',\r\n        IDPRODI='{$idprodi}' ,\r\n        STATUS='{$status}',\r\n        LOGINWAKTU='{$loginwaktu}',\r\n        JAM1='{$jam1}',\r\n        JAM2='{$jam2}'\r\n        {$qlogout}\r\n\t\t\t\tWHERE ID='{$idupdate}'";
		#echo $query;exit();
	}
    if ($ok)
    {
        $hasil =mysqli_query($koneksi,$query);
        if ( sqlaffectedrows( $koneksi ) < 1 )
        {
            if ( $aksiuser == "Update" )
            {
                $errmesg = "Data Operator dengan ID = '{$idupdate}' tidak diupdate";
            }
            else
            {
                $errmesg = "Data Operator dengan ID = '{$iduser}' sudah ada, data tidak ditambah";
            }
        }
        else if ( $aksiuser == "Update" )
        {
            $tingkatakses = $tingkataksesku;
            $errmesg = "Data User dengan ID = '{$idupdate}' dan Nama = '{$nama}' berhasil diupdate";
            if ( $idupdate != $iduser )
            {
                $v = $idupdate;
            }
            $query = "SELECT NAMA,TINGKAT,PASSWORD,  IDPRODI,JENIS,STATUSLOGIN,LASTAKSI,LASTLOGIN,STATUS,LOGINWAKTU,JAM1,JAM2\r\n  \r\n  \t\t\tFROM user WHERE ID='{$iduser}' AND ID!='superadmin'";
            $hasil =mysqli_query($koneksi,$query);
            $datauser = sqlfetcharray( $hasil );
            $nama = $datauser[NAMA];
            $tingkat = $datauser[TINGKAT];
            $tmp = explode( ",", $tingkat );
            $tingkat = $tmp;
            $pwduser = $datauser[PASSWORD];
            $idprodi = $datauser[IDPRODI];
            $jenisopr = $datauser[JENIS];
            $statuslogin = $datauser[STATUSLOGIN];
            $lastlogin = $datauser[LASTLOGIN];
            $lastaksi = $datauser[LASTAKSI];
            $status = $datauser[STATUS];
            $loginwaktu = $datauser[LOGINWAKTU];
            $jam1 = $datauser[JAM1];
            $jam2 = $datauser[JAM2];
            $cekloginwaktu = "";
            if ( $loginwaktu == 1 )
            {
                $cekloginwaktu = "checked";
            }
        }
        else if ( $aksiuser == "Tambah" )
        {
            $errmesg = "Data User dengan ID = '{$iduser}' dan Nama = '{$nama}' berhasil ditambah";
        }
    }
    if ( !$ok )
    {
    }
    else if ( $aksiuser == "Tambah" )
    {
        $iduser = "";
        $nama = "";
    }
}
#printjudulmenu( $judul );
#printmesg( $errmesg );
/*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br><br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> $judul </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg($judul);
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";  
echo "						<form action=index.php?pilihan=tambah&aksi=tambahuser method=POST class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
							<input type=hidden name=idupdate value='";
if ( $idupdate != "" )
{
    echo "{$idupdate}";
}
else
{
    echo "{$iduser}";
}
echo "'>
								<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">User ID *</label>\r\n    
										<label class=\"col-form-label\">
											<input class=form-control m-input name=iduser type=text size=20 maxlength=20 value='";
echo $iduser;
echo "'>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Nama Lengkap*</label>\r\n    
										<label class=\"col-form-label\">
											<input class=form-control m-input name=nama type=text size=50 maxlength=50 value='";
echo $nama;
echo "'>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Password *</label>\r\n    
										<label class=\"col-form-label\">
											<input class=form-control m-input name=pwd  type=password size=20 >[<a target=_blank href='../passwordacak.php'>buat password acak</a>]";
if ( $aksi == "updateuser" )
{
    echo "<br>Password tidak akan diubah apabila tidak diisi";
}
echo "									</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Konfirmasi Password *</label>\r\n    
										<label class=\"col-form-label\">
											<input class=form-control m-input name=pwd2 type=password size=20 >
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\"><b>Data Hak Akses</b></label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Jenis Operator</label>\r\n    
										<label class=\"col-form-label\">";
					echo "					<select class=form-control m-input name=jenisopr>";
												foreach ( $arrayjenisoperator as $k => $v )
												{
													if ( $jenisopr == $k )
													{
														$cek = "selected";
													}
													echo "<option {$cek} value={$k} >{$v}</option>";
													$cek = "";
												}
echo "										</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Operator Program Studi</label>\r\n    
										<label class=\"col-form-label\">";
echo "										<select class=form-control m-input name=idprodi>\r\n\t\t\t<option  value='' >Semua</option>\r\n\t\t\t";
												foreach ( $arrayprodidep as $k => $v )
												{
													if ( $idprodi == $k )
													{
														$cek = "selected";
													}
													echo "<option {$cek} value={$k} >{$v}</option>";
													$cek = "";
												}
echo "										</select>
										</label>
									</div>
								</div>";
#echo "\r\n\t\t<table class=\"table table-striped table-bordered\">\r\n\t\t\t<tr align=center class=titlecontent style='color:#000;'>\r\n\t\t\t\t<td>Hak Akses</td>\r\n\t\t\t\t<td>Baca</td>\r\n\t\t\t\t<td>Tulis</td>\r\n\t\t\t\t<td>Tanpa Akses</td>\r\n\t\t\t</tr>\r\n\t\t";
echo "							<div class=\"m-portlet\">			
									<div class=\"m-section__content\">
										<div class=\"table-responsive\">
											<table class=\"table table-bordered table-hover\">
												<thead>
													<tr align=center class=titlecontent style='color:#000;'>\r\n\t\t\t\t<td>Hak Akses</td>\r\n\t\t\t\t<td>Baca</td>\r\n\t\t\t\t<td>Tulis</td>\r\n\t\t\t\t<td>Tanpa Akses</td>\r\n\t\t\t</tr>\r\n\t\t";
echo "											</thead>
												<tbody>";
$ii = 0;
foreach ( $tingkatuser as $k => $v )
{
    if ( $ii % 2 == 0 )
    {
        $kelas = "";
    }
    else
    {
        $kelas = "";
    }
    $cek = $cekb = $cekt = "";
    if ( ereg_sikad( "B", $tingkatakses[$k] ) )
    {
        $cekb = "checked";
    }
    if ( ereg_sikad( "T", $tingkatakses[$k] ) )
    {
        $cekt = "checked";
    }
    echo "\r\n\t\t\t\t\t<tr class={$kelas}>\r\n\t\t\t\t\t<td>{$v}</td> \r\n\t\t\t\t\t<td align=center><input {$cekb} type=radio name=tingkataksesku[{$k}] value='B'></td>\r\n\t\t\t\t\t<td align=center><input  {$cekt} type=radio name=tingkataksesku[{$k}] value='T'></td>\r\n\t\t\t\t\t<td align=center><input type=radio name=tingkataksesku[{$k}] value='N'></td>\r\n\t\t\t\t\t</tr>";
    ++$ii;
}
#echo "\t</table>\t\t";
#echo "\r\n\t\t</td>\r\n\t</tr>\r\n";
echo "											</tbody>
											</table>
										</div>
									</div>
								</div>
								<!--end::Section-->";
#echo "\t<tr>\r\n\t\t<td  colspan=2><hr size=1><b>Status Login<hr size=1></td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td>Status Operator</td>\r\n\t\t<td>\r\n\t\t\t<select class=form-control m-input name=status>";
echo 	"						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\"><b>Status Login</b></label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\"><b>Status Operator</b></label>\r\n    
									<label class=\"col-form-label\">
										<select class=form-control m-input name=status>";
											foreach ( $arraystatususer as $k => $v )
											{
												if ( $status == $k )
												{
													$cek = "selected";
												}
												echo "<option {$cek} value={$k} >{$v}</option>";
												$cek = "";
											}
echo "									</select> (Aktif=Bisa login, Tidak Aktif=Tidak bisa login)
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Status</label>\r\n    
									<label class=\"col-form-label\">
										".$arraystatuslogin[$statuslogin]."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Waktu Login Terakhir</label>\r\n    
									<label class=\"col-form-label\">
										{$lastlogin}
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Waktu Aktifitas Terakhir</label>\r\n    
									<label class=\"col-form-label\">
										{$lastaksi}
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Logout Paksa</label>\r\n    
									<label class=\"col-form-label\">
										<input type=checkbox value=1 name=iflogout > Ubah status login menjadi Logout/tidak login
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Hak akses berdasarkan waktu</label>\r\n    
									<label class=\"col-form-label\">
										<input type=checkbox value=1 name=loginwaktu {$cekloginwaktu} > Aktif  
									</label>
								</div>";
echo "							<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Jam Operator Login</label>\r\n    
									<label class=\"col-form-label\">
										<input type=text size=10 name=jam1 value='{$jam1}' > sampai jam <input type=text size=10 name=jam2 value='{$jam2}'>
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
									<div class=\"col-lg-6\">
										<input class=\"btn btn-brand\" type=submit value='";
											if ( $aksi == "updateuser" )
											{
												echo "Update";
											}
											else
											{
												echo "Tambah";
											}
echo "' name=aksiuser>
										<input class=\"btn btn-secondary\" type=reset value='Reset'>
										<input name=aksi type=hidden value='";
echo $aksi;
echo "'>\r\n<input name=pwduser type=hidden value='";
echo $pwduser;
echo "'>\r\n
									</div>
								</div>							
						</form>
                    </div>
                </div>
            </div>
		</div>
	</div>
	";
?>
