<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$idprodi = getfield( "IDPRODI", "mahasiswa", " WHERE ID='{$idupdate}'" );
$namamakul = getfield( "NAMA", "mahasiswa", " WHERE ID='{$idupdate}'" );
/*echo "\r\n<br>\r\n  <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n     <tr class=judulform>\r\n\t\t\t<td width=150>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$idprodi]."\r\n      </td>\r\n\t\t</tr> \r\n    <tr>\r\n      <td>NIM Mahasiswa</td>\r\n      <td><b>{$idupdate}</td>\r\n    </tr>\r\n    <tr>\r\n      <td>Nama Mahasiswa</td>\r\n      <td><b>".$namamakul."</td>\r\n    </tr>\r\n    </table></div></div></div></div></div>\r\n";
*/
echo "		<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=\"index.php\" method=\"post\">
					<div class=\"m-portlet__body\">	";
echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
							<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arrayprodidep[$idprodi]."</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">NIM Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$idupdate}</b></label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
							<label class=\"col-lg-2 col-form-label\">Nama Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>".$namamakul."</b></label>
						</div>";
if ( $aksi2 == "hapus" )
{
    if ( $_GET['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Riwayat Pendidikan Mahasiswa", HAPUS_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $q = "\r\n\t\t\t\t\tDELETE FROM msphs\r\n\t\t\t\t\tWHERE\r\n\t\t\t\t\tNIMHSMSPHS='{$idupdate}'\r\n\t\t\t\t\tAND NORUTMSPHS='{$urutan}'\r\n\t\t\t\t";
        doquery($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data Riwayat Pendidikan Mahasiswa berhasil dihapus";
        }
        else
        {
            $errmesg = "Data Riwayat Pendidikan Mahasiswa tidak dihapus";
        }
    }
    $aksi2 = "";
}
if ( $aksi2 == "Simpan" && $REQUEST_METHOD == POST )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Riwayat Pendidikan Mahasiswa", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditaskode( "Strata", $strata, 2, false );
        $vld[] = cekvaliditaskode( "Gelar", $gelar, 10 );
        $vld[] = cekvaliditaskode( "Kode PT", $kodept );
        $vld[] = cekvaliditasnama( "Nama PT", $namapt );
        $vld[] = cekvaliditasnama( "Bidang ilmu", $bidangilmu );
        $vld[] = cekvaliditasnama( "Kota Asal", $kotaasal );
        $vld[] = cekvaliditaskode( "Kode Negara", $kodenegara );
        $vld[] = cekvaliditastanggal( "Tanggal Ijazah", $data['tgl'], $data['bln'], $data['thn'] );
        $vld[] = cekvaliditasinteger( "Total SKS lulus", $sks );
        $vld[] = cekvaliditasnumerik( "IPK Lulus", $ipk );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
        }
        else
        {
            $q = "SELECT IDPRODI FROM mahasiswa WHERE ID='{$idupdate}'";
            $h = doquery($koneksi,$q);
            $d = sqlfetcharray( $h );
            $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$d['IDPRODI']}'";
            $h = doquery($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $d = sqlfetcharray( $h );
                $idpt = $d[KDPTIMSPST];
                $kodejenjang = $d[KDJENMSPST];
                $kodeps = $d[KDPSTMSPST];
            }
            $q = "UPDATE msphs SET\r\n\t\t\tKDPTIMSPHS='{$idpt}',\r\n\t\t\tKDPSTMSPHS='{$kodeps}',\r\n\t\t\tKDJENMSPHS ='{$kodejenjang}', \r\n\t\t\tJENJAMSPHS ='{$strata}',\r\n\t\t\tGELARMSPHS='{$gelar}' ,\r\n\t\t\tASPTIMSPHS='{$kodept}' ,\r\n\t\t\tNMPTIMSPHS='{$namapt}' ,\r\n\t\t\tBIDILMSPHS='{$bidangilmu}' ,\r\n\t\t\tKOTAAMSPHS='{$kotaasal}' ,\r\n\t\t\tKDNEGMSPHS='{$kodenegara}' ,\r\n\t\t\tTGIJAMSPHS='{$data['thn']}-{$data['bln']}-{$data['tgl']}' ,\r\n\t\t\tSKSTTMSPHS='{$sks}',\r\n\t\t\tNLIPKMSPHS='{$ipk}'\r\n\t\t\tWHERE NIMHSMSPHS ='{$idupdate}' AND NORUTMSPHS='{$urutan}'\r\n\t\t\t";
            doquery($koneksi,$q);
            $errmesg = "Data Riwayat Pendidikan Mahasiswa berhasil disimpan";
        }
    }
    $aksi2 = "formupdate";
}
if ( $aksi2 == "Tambah" && $REQUEST_METHOD == POST )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Riwayat Pendidikan Mahasiswa", TAMBAH_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditaskode( "Strata", $strata, 2, false );
        $vld[] = cekvaliditaskode( "Gelar", $gelar, 10, false );
        $vld[] = cekvaliditaskode( "Kode PT", $kodept );
        $vld[] = cekvaliditasnama( "Nama PT", $namapt );
        $vld[] = cekvaliditasnama( "Bidang ilmu", $bidangilmu, 32, false );
        $vld[] = cekvaliditasnama( "Kota Asal", $kotaasal );
        $vld[] = cekvaliditaskode( "Kode Negara", $kodenegara );
        $vld[] = cekvaliditastanggal( "Tanggal Ijazah", $data['tgl'], $data['bln'], $data['thn'] );
        $vld[] = cekvaliditasinteger( "Total SKS lulus", $sks );
        $vld[] = cekvaliditasnumerik( "IPK Lulus", $ipk );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, TAMBAH_DATA );
        }
        else
        {
            $idbaru = getnewidsyarat( "NORUTMSPHS", "msphs", " WHERE NIMHSMSPHS='{$idupdate}'       " );
            $q = "SELECT IDPRODI FROM mahasiswa WHERE ID='{$idupdate}'";
            $h = doquery($koneksi,$q);
            $d = sqlfetcharray( $h );
            $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$d['IDPRODI']}'";
            $h = doquery($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $d = sqlfetcharray( $h );
                $idpt = $d[KDPTIMSPST];
                $kodejenjang = $d[KDJENMSPST];
                $kodeps = $d[KDPSTMSPST];
            }
            $q = " INSERT INTO msphs \r\n\t\t\t\t\t(KDPTIMSPHS,KDPSTMSPHS,KDJENMSPHS ,NIMHSMSPHS ,NORUTMSPHS ,JENJAMSPHS ,\r\n\t\t\t\t\tGELARMSPHS ,ASPTIMSPHS ,NMPTIMSPHS ,BIDILMSPHS ,KOTAAMSPHS ,KDNEGMSPHS ,\r\n\t\t\t\t\tTGIJAMSPHS,SKSTTMSPHS,NLIPKMSPHS )\r\n\t\t\t\t\tVALUES\r\n\t\t\t\t\t('{$idpt}','{$kodeps}','{$kodejenjang}','{$idupdate}','{$idbaru}','{$strata}',\r\n\t\t\t\t\t'{$gelar}','{$kodept}','{$namapt}','{$bidangilmu}','{$kotaasal}','{$kodenegara}',\r\n\t\t\t\t\t'{$data['thn']}-{$data['bln']}-{$data['tgl']}','{$sks}','{$ipk}')\r\n\t\t\t\t\t";
            doquery($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Riwayat Pendidikan Mahasiswa berhasil disimpan";
                $data = "";
                $strata = $gelar = $bidangilmu = $kodept = $namapt = $kotaasal = $kodenegara = "";
            }
            else
            {
                $errmesg = "Data Riwayat Pendidikan Mahasiswa tidak disimpan";
            }
        }
    }
    $aksi2 = "formtambah";
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
echo "\r\n<br>\r\n<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n <tr >\r\n  <td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=formtambah&idupdate={$idupdate}'> ".IKONTAMBAH." Tambah Data Baru </td>\r\n  <td width=50% align=center><a href='index.php?aksi={$aksi}&pilihan={$pilihan}&tab={$tab}&aksi2=tampilkan&idupdate={$idupdate}'> ".IKONUPDATE." Edit Data Lama</td>\r\n  </tr></table></div></div>\r\n";
printmesg( $errmesg );
if ( $aksi2 == "formupdate" )
{
    /*echo "\r\n  <br>\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<div class='portlet-body form'><div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "urutan", "{$urutan}", "" )."\r\n \r\n  ";
    */
	echo createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "urutan", "{$urutan}", "" )."\r\n \r\n  ";
	include( "formpendidikan.php" );
    #echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Simpan' class=\"btn blue\">\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n  </div></div></form>\r\n  ";
	echo "					<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
									<input type=submit name=aksi2 value='Simpan' class=\"btn btn-brand\">
									<input type=reset value='Reset' class=\"btn btn-secondary\">
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
    /*echo "\r\n  <br>\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<div class='portlet-body form'><div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."\r\n \r\n  ";
    */
	echo createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "{$aksi}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "tab", "{$tab}", "" ).createinputhidden( "idupdate", "{$idupdate}", "" )."\r\n \r\n  ";
	include( "formpendidikan.php" );
    #echo "\r\n \t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n\t\t\t\t\t<input type=submit name=aksi2 value='Tambah' class=\"btn blue\">\r\n\t\t\t\t\t<input type=reset value='Reset' class=\"btn red\">\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n </div></div> </form>\r\n  ";
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
    $q = "SELECT * FROM msphs WHERE NIMHSMSPHS='{$idupdate}' ORDER BY NORUTMSPHS";
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        #echo "\r\n\t\t\t<br>\r\n\t\t\t\t<table {$border} class=data >\r\n \r\n\t\t\t\t\t<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Jenjang Studi</td>\r\n\t\t\t\t\t\t<td>Gelar</td>\r\n\t\t\t\t\t\t<td>Kode PT</td>\r\n\t\t\t\t\t\t<td>Nama PT</td>\r\n\t\t\t\t\t\t<td>Bidang Ilmu</td>\r\n\t\t\t\t\t\t<td>Kota Asal</td>\r\n\t\t\t\t\t\t<td>Kode Negara</td>\r\n\t\t\t\t\t\t<td>Tanggal<br>Ijazah</td>\r\n\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t<td>IPK</td>\r\n\t\t\t\t\t\t<td colspan=2>Pilih</td>\r\n\t\t\t\t\t</tr>";
        echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover\">
							<thead>
								<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Jenjang Studi</td>\r\n\t\t\t\t\t\t<td>Gelar</td>\r\n\t\t\t\t\t\t<td>Kode PT</td>\r\n\t\t\t\t\t\t<td>Nama PT</td>\r\n\t\t\t\t\t\t<td>Bidang Ilmu</td>\r\n\t\t\t\t\t\t<td>Kota Asal</td>\r\n\t\t\t\t\t\t<td>Kode Negara</td>\r\n\t\t\t\t\t\t<td>Tanggal<br>Ijazah</td>\r\n\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t<td>IPK</td>\r\n\t\t\t\t\t\t<td colspan=2>Pilih</td>\r\n\t\t\t\t\t</tr>";
		echo "				</thead>
							<tbody>";
		$i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $tmp = explode( "-", $d[TGIJAMSPHS] );
            $tmp2[tgl] = $tmp[2];
            $tmp2[bln] = $tmp[1];
            $tmp2[thn] = $tmp[0];
            echo "\r\n\t\t\t\t\t<tr {$kelas} >\r\n\t\t\t\t\t\t<td>{$i} </td>\r\n \t\t\t\t\t\t<td align=center>".$arraypendidikantertinggi[$d[JENJAMSPHS]]."</td>\r\n\t\t\t\t\t\t<td>{$d['GELARMSPHS']}</td>\r\n\t\t\t\t\t\t<td>{$d['ASPTIMSPHS']}</td>\r\n\t\t\t\t\t\t<td>{$d['NMPTIMSPHS']}</td>\r\n \r\n\t\t\t\t\t\t<td>{$d['BIDILMSPHS']}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['KOTAAMSPHS']}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['KDNEGMSPHS']}</td>\r\n\t\t\t\t\t\t<td align=center nowrap>{$tmp2['tgl']}-{$tmp2['bln']}-{$tmp2['thn']}</td>\r\n          <td align=center>{$d['SKSTTMSPHS']}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['NLIPKMSPHS']}</td>\r\n\t\t\t\t\t\t\r\n          <td><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&urutan={$d['NORUTMSPHS']}&aksi2=formupdate'>".IKONUPDATE."</td>              \r\n          <td><a onClick='return confirm(\"Hapus Data Riwayat Pendidikan Mahasiswa?\")' href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&idupdate={$idupdate}&urutan={$d['NORUTMSPHS']}&aksi2=hapus&sessid={$_SESSION['token']}'>".IKONHAPUS."</td>              \r\n\t\t\t\t\t</tr>";
            ++$i;
        }
        #echo "\r\n\t\t\t\t</table>\r\n\t\t\t";
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
        printmesg( "Data Riwayat Pendidikan tidak ada" );
        echo "</p>";
    }
    echo "\r\n\t\t</form>\r\n\t\t\r\n\t\t";
}
?>
