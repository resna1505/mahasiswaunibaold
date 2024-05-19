<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$idprodi = getfield( "IDDEPARTEMEN", "dosen", " WHERE ID='{$idupdate}'" );
$namamakul = getfield( "NAMA", "dosen", " WHERE ID='{$idupdate}'" );
#echo "\r\n<br>\r\n  <table class=form>\r\n     <tr class=judulform>\r\n\t\t\t<td width=150>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$idprodi]."\r\n      </td>\r\n\t\t</tr> \r\n    <tr>\r\n      <td>NIDN Dosen</td>\r\n      <td><b>{$idupdate}</td>\r\n    </tr>\r\n    <tr>\r\n      <td>Nama Dosen</td>\r\n      <td><b>".$namamakul."</td>\r\n    </tr>\r\n    </table>\r\n";
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
    if ( $_GET['sessid'] == $_SESSION['token'] )
    {
        $q = "\r\n\t\t\t\t\tDELETE FROM riwayatpendidikandosen\r\n\t\t\t\t\tWHERE\r\n\t\t\t\t\tIDDOSEN='{$idupdate}'\r\n\t\t\t\t\tAND ID='{$urutan}'\r\n\t\t\t\t";
        $ketlog = "Hapus data riwayat pendidikan dosen dengan ID Dosen={$idupdate} dan ID={$k}";
        buatlog( 17 );
        mysqli_query($koneksi,$q);
        $q = "\r\n\t\t\t\t\tDELETE FROM mspds\r\n\t\t\t\t\tWHERE\r\n\t\t\t\t\tNODOSMSPDS='{$idupdate}'\r\n\t\t\t\t\tAND NORUTMSPDS='{$urutan}'\r\n\t\t\t\t";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data Riwayat Pendidikan Dosen berhasil dihapus";
        }
        else
        {
            $errmesg = "Data Riwayat Pendidikan Dosen tidak dihapus";
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Riwayat Pendidikan Dosen", HAPUS_DATA );
    }
    $aksi2 = "";
}
if ( $aksi2 == "Simpan" && $REQUEST_METHOD == POST )
{
    if ( $_POST['sessid'] == $_SESSION['token'] )
    {
        $valdata[] = cekvaliditaskode( "Strata", $strata );
        $valdata[] = cekvaliditaskode( "Gelar", $gelar );
        $valdata[] = cekvaliditaskode( "Kode PT", $kodept );
        $valdata[] = cekvaliditasnama( "Nama PT", $namapt );
        $valdata[] = cekvaliditasnama( "Nama PT", $namapt );
        $valdata[] = cekvaliditasnama( "Bidang Ilmu", $bidangilmu );
        $valdata[] = cekvaliditasnama( "Kota Asal", $kotaasal );
        $valdata[] = cekvaliditasinteger( "Kode Negara", $kodenegara );
        $valdata[] = cekvaliditastanggal( "Tanggal Ijazah", $data['tgl'], $data['bln'], $data['thn'] );
        $valdata = array_filter( $valdata, "filter_not_empty" );
        if ( isset( $valdata ) && 0 < count( $valdata ) )
        {
            $errmesg = val_err_mesg( $valdata, 2, SIMPAN_DATA );
            unset( $valdata );
        }
        else
        {
            $q = "SELECT IDDEPARTEMEN FROM dosen WHERE ID='{$idupdate}'";
            $h = mysqli_query($koneksi,$q);
            $d = sqlfetcharray( $h );
            $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$d['IDDEPARTEMEN']}'";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $d = sqlfetcharray( $h );
                $idpt = $d[KDPTIMSPST];
                $kodejenjang = $d[KDJENMSPST];
                $kodeps = $d[KDPSTMSPST];
            }
            $q = "UPDATE mspds SET\r\n\t\t\t\tJENJAMSPDS='{$strata}',\r\n\t\t\t\tGELARMSPDS='{$gelar}' ,\r\n\t\t\t\tASPTIMSPDS='{$kodept}' ,\r\n\t\t\t\tNMPTIMSPDS='{$namapt}' ,\r\n\t\t\t\tBIDILMSPDS='{$bidangilmu}' ,\r\n\t\t\t\tKOTAAMSPDS='{$kotaasal}' ,\r\n\t\t\t\tKDNEGMSPDS='{$kodenegara}' ,\r\n\t\t\t\tTGIJAMSPDS='{$data['thn']}-{$data['bln']}-{$data['tgl']}' \r\n\t\t\t   \r\n          WHERE NODOSMSPDS ='{$idupdate}' AND NORUTMSPDS='{$urutan}'\r\n         ";
            mysqli_query($koneksi,$q);
            echo mysqli_error($koneksi);
            $q = "\r\n\t\t\t\t\tUPDATE riwayatpendidikandosen\r\n\t\t\t\t\tSET \r\n\t\t\t\t\tSTRATA='{$strata}',\r\n\t\t\t\t\tGELAR='{$gelar}',\r\n\t\t\t\t\tBIDANG='{$bidangilmu}',\r\n\t\t\t\t\tKODEPT='{$kodept}',\r\n\t\t\t\t\tTANGGALLULUS='{$data['thn']}-{$data['bln']}-{$data['tgl']}',\r\n\t\t\t\t\tNAMAPT='{$namapt}'\r\n\t\t\t\t\tWHERE\r\n\t\t\t\t\tIDDOSEN='{$idupdate}'\r\n\t\t\t\t\tAND ID='{$urutan}'\r\n\t\t\t\t";
            mysqli_query($koneksi,$q);
            echo mysql_error($koneksi);
            $ketlog = "Update data riwayat pendidikan dosen dengan ID Dosen={$idupdate} dan ID={$urutan} ({$strata})";
            buatlog( 16 );
            $errmesg = "Data Riwayat Pendidikan Dosen berhasil disimpan";
			if ( $ijazah != "" )
							{
								#echo "ada".'<br>';	
								if ( file_exists( "../dosen/ijazah/{$idupdate}{$urutan}" ) )
								{
									#echo "hapus dulu".'<br>';
									unlink( "../dosen/ijazah/{$idupdate}{$urutan}" );
								}	
								move_uploaded_file( $ijazah, "../dosen/ijazah/{$idupdate}{$urutan}" );
								
							}
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Riwayat Pendidikan Dosen", SIMPAN_DATA );
    }
    $aksi2 = "formupdate";
}
if ( $aksi2 == "Tambah" && $REQUEST_METHOD == POST )
{
    if ( $_POST['sessid'] == $_SESSION['token'] )
    {
        $valdata[] = cekvaliditaskode( "Strata", $strata, 3, false );
        $valdata[] = cekvaliditaskode( "Gelar", $gelar, 7, false );
        $valdata[] = cekvaliditaskode( "Kode PT", $kodept );
        $valdata[] = cekvaliditasnama( "Nama PT", $namapt );
        $valdata[] = cekvaliditasnama( "Bidang Ilmu", $bidangilmu, 32, false );
        $valdata[] = cekvaliditasnama( "Kota Asal", $kotaasal );
        $valdata[] = cekvaliditasinteger( "Kode Negara", $kodenegara );
        $valdata[] = cekvaliditastanggal( "Tanggal Ijazah", $data['tgl'], $data['bln'], $data['thn'] );
        $valdata = array_filter( $valdata, "filter_not_empty" );
        if ( isset( $valdata ) && 0 < count( $valdata ) )
        {
            $errmesg = val_err_mesg( $valdata, 2, TAMBAH_DATA );
            unset( $valdata );
        }
        else
        {
            if ( trim( $strata ) == "" )
            {
                $errmesg = "Strata harus diisi";
            }
            else
            {
                if ( trim( $gelar ) == "" )
                {
                    $errmesg = "Gelar harus diisi";
                }
                else
                {
                    if ( trim( $bidangilmu ) == "" )
                    {
                        $errmesg = "Bidang Ilmu harus diisi";
                    }
                    else
                    {
                        $idbaru = getnewidsyarat( "ID", "riwayatpendidikandosen", "WHERE IDDOSEN='{$idupdate}'" );
                        $q = "\r\n\t\t\t\tINSERT INTO riwayatpendidikandosen\r\n\t\t\t\t(ID,IDDOSEN,STRATA,TANGGALLULUS,GELAR,BIDANG,KODEPT,NAMAPT)\r\n\t\t\t\tVALUES\r\n\t\t\t\t('{$idbaru}','{$idupdate}','{$strata}','{$data['thn']}-{$data['bln']}-{$data['tgl']}','{$gelar}',\r\n\t\t\t\t'{$bidangilmu}','{$kodept}','{$namapt}')\r\n\t\t\t";
                        #echo $q;exit();
						mysqli_query($koneksi,$q);
						#$last_id = mysql_insert_id();
                        $ketlog = "Update data riwayat pendidikan dosen dengan ID Dosen={$idupdate} dan ID={$idbaru} ({$strata})";
                        buatlog( 15 );
                        if ( 0 < sqlaffectedrows( $koneksi ) )
                        {
                            $q = "SELECT IDDEPARTEMEN FROM dosen WHERE ID='{$idupdate}'";
                            $h = mysqli_query($koneksi,$q);
                            $d = sqlfetcharray( $h );
                            $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$d['IDDEPARTEMEN']}'";
                            $h = mysqli_query($koneksi,$q);
                            if ( 0 < sqlnumrows( $h ) )
                            {
                                $d = sqlfetcharray( $h );
                                $idpt = $d[KDPTIMSPST];
                                $kodejenjang = $d[KDJENMSPST];
                                $kodeps = $d[KDPSTMSPST];
                            }
                            $q = " INSERT INTO mspds \r\n\t\t\t   (KDPTIMSPDS,KDPSTMSPDS,KDJENMSPDS ,NODOSMSPDS ,NORUTMSPDS ,JENJAMSPDS ,\r\n\t\t\t   GELARMSPDS ,ASPTIMSPDS ,NMPTIMSPDS ,BIDILMSPDS ,KOTAAMSPDS ,KDNEGMSPDS ,\r\n\t\t\t   TGIJAMSPDS )\r\n\t\t\t   VALUES\r\n         ('{$idpt}','{$kodeps}','{$kodejenjang}','{$idupdate}','{$idbaru}','{$strata}',\r\n         '{$gelar}','{$kodept}','{$namapt}','{$bidangilmu}','{$kotaasal}','{$kodenegara}',\r\n         '{$data['thn']}-{$data['bln']}-{$data['tgl']}')\r\n         ";
                            mysqli_query($koneksi,$q);
							if ( $ijazah != "" )
							{
								if ( file_exists( "../dosen/ijazah/{$idupdate}{$idbaru}" ) )
								{
									unlink( "../dosen/ijazah/{$idupdate}{$idbaru}" );
								}	
								move_uploaded_file( $ijazah, "../dosen/ijazah/{$idupdate}{$idbaru}" );
								
							}
                            $errmesg = "Data Riwayat Pendidikan Dosen berhasil disimpan";
                            $data = "";
                            $strata = $gelar = $bidangilmu = $kodept = $namapt = $kotaasal = $kodenegara = "";
                        }
                        else
                        {
                            $errmesg = "Data Riwayat Pendidikan Dosen tidak disimpan";
                        }
                    }
                }
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Riwayat Pendidikan Dosen", TAMBAH_DATA );
    }
    $aksi2 = "formtambah";
}
#echo "\r\n<br>\r\n<table width=95% class=from>\r\n  <tr >\r\n  <td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=formtambah&idupdate={$idupdate}'>\t\t\t\t".IKONTAMBAH." Tambah Data Baru </td>\r\n  <td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=tampilkan&idupdate={$idupdate}'>\t\t\t\t".IKONUPDATE." Edit Data Lama</td>\r\n  </tr>\r\n</table>\r\n";
#printmesg( $errmesg );
echo "<br><div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\"><tr><td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=formtambah&idupdate={$idupdate}'>Tambah Data Baru </td><td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=tampilkan&idupdate={$idupdate}'>Edit Data Lama</td></tr>\r\n</table></div></div>";
printmesg( $errmesg );

if ( $aksi2 == "formupdate" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    #echo "\r\n  <br>\r\n\t\t<form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "idriwayat", "{$ID}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "urutan", "{$urutan}", "" )."\r\n \r\n  ";
    echo createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "idriwayat", "{$ID}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "urutan", "{$urutan}", "" )."";
	include( "formpendidikan.php" );
    #echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Simpan' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n  </form>\r\n  ";
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
    #echo "\r\n  <br>\r\n\t\t<form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."\r\n \r\n  ";
    echo createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."\r\n \r\n  ";
	include( "formpendidikan.php" );
    #echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Tambah' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n  </form>\r\n  ";
	echo "					<div class=\"form-group m-form__group row\">
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
    $q = "SELECT riwayatpendidikandosen.*,DATE_FORMAT(TANGGALLULUS,'%d-%m-%Y') AS TGL \r\n\t\t  FROM riwayatpendidikandosen\r\n\t\t  WHERE IDDOSEN='{$idupdate}'\r\n\t\t  \t\t  ORDER BY TANGGALLULUS";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        #echo "\r\n\t\t\t<br>\r\n\t\t\t\t<table {$border} class=data >\r\n \r\n\t\t\t\t\t<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Jenjang Studi</td>\r\n\t\t\t\t\t\t<td>Gelar</td>\r\n\t\t\t\t\t\t<td>Kode PT</td>\r\n\t\t\t\t\t\t<td>Nama PT</td>\r\n\t\t\t\t\t\t<td>Bidang Ilmu</td>\r\n\t\t\t\t\t\t<td>Kota Asal</td>\r\n\t\t\t\t\t\t<td>Kode Negara</td>\r\n\t\t\t\t\t\t<td>Tanggal<br>Ijazah</td><td>Pilih</td>\r\n\t\t\t\t\t</tr>";
        echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover\">
							<thead>
								<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Jenjang Studi</td>\r\n\t\t\t\t\t\t<td>Gelar</td>\r\n\t\t\t\t\t\t<td>Kode PT</td>\r\n\t\t\t\t\t\t<td>Nama PT</td>\r\n\t\t\t\t\t\t<td>Bidang Ilmu</td>\r\n\t\t\t\t\t\t<td>Kota Asal</td>\r\n\t\t\t\t\t\t<td>Kode Negara</td>\r\n\t\t\t\t\t\t<td>Tanggal<br>Ijazah</td><td>Pilih</td>\r\n\t\t\t\t\t</tr>";
		echo "				</thead>
							<tbody>";
		$i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $q = "SELECT * FROM mspds WHERE NODOSMSPDS='{$d['IDDOSEN']}' AND NORUTMSPDS='{$d['ID']}'";
            $h2 = mysqli_query($koneksi,$q);
            if ( sqlnumrows( $h2 ) <= 0 )
            {
                $q = "INSERT INTO mspds (NODOSMSPDS,NORUTMSPDS) VALUES ('{$d['IDDOSEN']}','{$d['ID']}')";
                mysqli_query($koneksi,$q);
                $q = "SELECT * FROM mspds WHERE NODOSMSPDS='{$d['IDDOSEN']}' AND NORUTMSPDS='{$d['ID']}'";
                $h2 = mysqli_query($koneksi,$q);
            }
            $d2 = sqlfetcharray( $h2 );
            $tmp = explode( "-", $d[TANGGALLULUS] );
            $tmp2[tgl] = $tmp[2];
            $tmp2[bln] = $tmp[1];
            $tmp2[thn] = $tmp[0];
            echo "\r\n\t\t\t\t\t<tr {$kelas} >\r\n\t\t\t\t\t\t<td>{$i} </td>\r\n \t\t\t\t\t\t<td align=center>".$arraypendidikantertinggi[$d2[JENJAMSPDS]]."</td>\r\n\t\t\t\t\t\t<td>{$d['GELAR']}</td>\r\n\t\t\t\t\t\t<td>{$d['KODEPT']}</td>\r\n\t\t\t\t\t\t<td>{$d2['NMPTIMSPDS']}</td>\r\n \r\n\t\t\t\t\t\t<td>{$d['BIDANG']}</td>\r\n\t\t\t\t\t\t<td align=center>{$d2['KOTAAMSPDS']}</td>\r\n\t\t\t\t\t\t<td align=center>{$d2['KDNEGMSPDS']}</td>\r\n\t\t\t\t\t\t<td align=center nowrap>{$tmp2['tgl']}-{$tmp2['bln']}-{$tmp2['thn']}</td><td><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&urutan={$d['ID']}&aksi2=formupdate'>".IKONUPDATE."</td>   </tr>";
            ++$i;
        }
        #echo "\r\n\t\t\t\t</table>\r\n\t\t\t";
		echo "								</tbody>
								</table>
							
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
        printmesg( "Data Riwayat Pendidikan tidak ada" );
        echo "</p>";
    }
    echo "\r\n\t\t</form>\r\n\t\t\r\n\t\t";
}
?>
