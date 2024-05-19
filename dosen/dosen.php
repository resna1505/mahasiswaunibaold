<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "hapus" )
{
    if ( $_GET['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Dosen", TAMBAH_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        cekhaktulis( $kodemenu );
        $q = "DELETE FROM dosen WHERE ID='{$idhapus}'";
        doquery($koneksi,$q);
        $ketlog = "Hapus data dosen dengan ID='{$idhapus}'";
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            buatlog( 11 );
            $errmesg = "Data Dosen dengan ID = {$idhapus} berhasil dihapus";
            $q = "DELETE FROM dosenpengajar WHERE IDDOSEN='{$idhapus}'";
            doquery($koneksi,$q);
            $q = "DELETE FROM msdos WHERE NODOSMSDOS='{$idhapus}'";
            doquery($koneksi,$q);
            $q = "DELETE FROM trakd WHERE NODOSTRAKD='{$idhapus}'";
            doquery($koneksi,$q);
            $q = "DELETE FROM mspds WHERE NODOSMSPDS='{$idhapus}'";
            doquery($koneksi,$q);
            $q = "DELETE FROM trpud WHERE NODOSTRPUD='{$idhapus}'";
            doquery($koneksi,$q);
            $q = "DELETE FROM trlsd WHERE NODOSTRLSD='{$idhapus}'";
            doquery($koneksi,$q);
            $q = "DELETE FROM dosenpengajarsp WHERE IDDOSEN='{$idhapus}'";
            doquery($koneksi,$q);
            #sinkronisasi_pusaka( $jenis = "HAPUS", $idhapus, 1 );
        }
        else
        {
            $errmesg = "Data Dosen dengan ID = '{$idhapus}' tidak berhasil dihapus";
        }
    }
    $aksi = "tampilkan";
}
if ( $aksi == "update" )
{
    cekhaktulis( $kodemenu );

    if ( $tab == 0 || $tab == "" )
    {
        include( "biodata.php" );
    }
    else if ( $tab == 1 )
    {
        include( "riwayatpendidikan.php" );
    }
    else if ( $tab == 2 )
    {
        include( "kelulusan.php" );
    }
    else if ( $tab == 6 )
    {
        include( "kelulusan2.php" );
    }
    else if ( $tab == 3 )
    {
        include( "publikasi.php" );
    }
    else if ( $tab == 4 )
    {
        include( "aktivitas.php" );
    }
    else if ( $tab == 7 )
    {
        include( "aktivitaslain.php" );
    }
    else if ( $tab == 8 )
    {
        include( "pengabdian.php" );
    }
    else if ( $tab == 5 )
    {
        include( "../mahasiswa/biodata2.php" );
    }
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" )
{
    cekhaktulis( $kodemenu );
   
    $arraymenutab[0] = "Biodata";
    $arraymenutab[5] = "Biodata (2)";
    $arraymenutab[4] = "Aktivitas Mengajar*";
    $arraymenutab[7] = "Aktivitas Mengajar di PT Lain";
    $arraymenutab[2] = "Dosen Studi Lanjut";
    $arraymenutab[6] = "Dosen Keluar/Cuti/Studi Lanjut (WIN)";
    $arraymenutab[1] = "Riwayat Pendidikan";
    $arraymenutab[3] = "Publikasi";
    $arraymenutab[8] = "Pengabdian Kepada Masyarakat";   
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
<div class=\"row\">
                <div class=\"col-md-12\">
                
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">";
						printmesg( $errmesg );
                        echo "<div class=\"portlet-body form\">
								<div class='tab-pane' id='tab_1'>
									<div class='portlet box blue'>
										<div class='portlet-title'>
											<div class='caption'>";
												printmesg("Update Data Dosen");
						/*echo "				</div>
										</div>
										<div class='portlet-body form'>
											<form name=form action=index.php method=post>\r\n\t\t<div class=\"portlet-body\">
											
												<div class=\"m-portlet__body\">
													<ul class=\"nav nav-tabs\" role=\"tablist\">";*/
						echo "				</div>
										</div>
										<div class='portlet-body form'>
											<div class=\"portlet-body\">											
												<div class=\"m-portlet__body\">
													<ul class=\"nav nav-tabs\" role=\"tablist\">";
				
    if ( $tab == "" )
    {
        $tab = 0;
    }
	$notab=1;
    foreach ( $arraymenutab as $k => $v )
    {
        $bgtab = "";
        if ( $tab == $k )
        {
            $bgtab = "class='nav-link active' style='color:#004488' ";
        
		}else{
			$bgtab = "class='nav-link active' ";
		}
        #echo "\r\n\t\t\t\t\t<td align=center><a {$bgtab} href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$k}&idupdate={$idupdate}'>{$v}</td>\r\n\t\t";
		echo "<li class=\"nav-item\">
					<a {$bgtab}  href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$k}&idupdate={$idupdate}'>{$v}</a>";
		echo "</li>";
		$notab++;
    }
    #echo "\r\n\t\t\t\t</tr>\r\n\t\t\t</table></div></div>\r\n\t";
	echo "</ul>";
	echo "<div class=\"tab-content\">";
    if ( $tab == 0 || $tab == "" )
    {
		#echo "<div class=\"tab-pane active\" id=\"m_tabs_1_1\" role=\"tabpanel\">";
        include( "biodata.php" );
		#echo "</div>";
    }
    else if ( $tab == 1 )
    {
		#echo "<div class=\"tab-pane\" id=\"m_tabs_1_7\" role=\"tabpanel\">";
        include( "riwayatpendidikan.php" );
		#echo "</div>";
    }
    else if ( $tab == 2 )
    {
		#echo "<div class=\"tab-pane\" id=\"m_tabs_1_5\" role=\"tabpanel\">";
        
        include( "kelulusan.php" );
		#echo "</div>";
    }
    else if ( $tab == 6 )
    {
		#echo "<div class=\"tab-pane\" id=\"m_tabs_1_6\" role=\"tabpanel\">";
        
        include( "kelulusan2.php" );
		#echo "</div>";
    }
    else if ( $tab == 3 )
    {
		#echo "<div class=\"tab-pane\" id=\"m_tabs_1_8\" role=\"tabpanel\">";
        
        include( "publikasi.php" );
		#echo "</div>";
    }
    else if ( $tab == 4 )
    {
		#echo "<div class=\"tab-pane\" id=\"m_tabs_1_3\" role=\"tabpanel\">";
        
        include( "aktivitas.php" );
		#echo "</div>";
		
    }
    else if ( $tab == 7 )
    {
		#echo "<div class=\"tab-pane\" id=\"m_tabs_1_4\" role=\"tabpanel\">";
        
        include( "aktivitaslain.php" );
		#echo "</div>";
    }
    else if ( $tab == 8 )
    {
		#echo "<div class=\"tab-pane\" id=\"m_tabs_1_9\" role=\"tabpanel\">";
        
        include( "pengabdian.php" );
		#echo "</div>";
    }
    else if ( $tab == 5 )
    { 
		#echo "<div class=\"tab-pane\" id=\"m_tabs_1_2\" role=\"tabpanel\">";
        
		 $idprodi = getfield( "IDDEPARTEMEN", "dosen", " WHERE ID='{$idupdate}'" );
		 $namamakul = getfield( "NAMA", "dosen", " WHERE ID='{$idupdate}'" );       
		
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
		include( "../mahasiswa/biodata2.php" );
        #echo "</div>";
       
    }
	echo "</div>
	<!--end::tab-content-->";
	echo "</div>
	<!--end::m-portlet__body-->
	</div>
	<!--end::portlet-body-->	
	</div>
	<!--end::portlet-body form-->
	</div>
	<!--end::portlet box blue-->
	</div>
	<!--end::tab-pane-->
	</div>
	<!--end::portlet-body form-->
	</div>
	<!--end::portlet light-->
	</div>
		<!--end::md-12-->	
	</div>
	<!--end::row-->	
</div>
<!--end::container-fluid-->";
}
if ( $aksi == "tambah" && $REQUEST_METHOD == POST )
{
	#print_r($_SESSION);
	#echo '<br>';
	#print_r($_POST);
	#echo '<br>';
    if ( $_SESSION['token'] == $_POST['sessid'] )
    {
        unset( $_SESSION['token'] );
        cekhaktulis( $kodemenu );
        $valdata[] = cekvaliditaskode( "NIDN", $id, 32, false );
        $valdata[] = cekvaliditasnama( "Nama", $data[nama], 64, false );
        $valdata[] = cekvaliditaskode( "Status", $data[status], 2,false );
        $valdata[] = cekvaliditasinteger( "Jurusan", $data[iddepartemen]);
        $valdata[] = cekvaliditasinteger( "Instansi", $instansidosen);
        $valdata[] = cekvaliditaskode( "Akte Mengajar", $data[akte], 2);
        $valdata[] = cekvaliditaskode( "Izin Mengajar", $data[izin], 2);
        $valdata[] = cekvaliditaskode( "Status Kerja", $data[statuskerja], 2);
        $valdata[] = cekvaliditasnama( "Tempat Lahir", $data[tempat], 32);
        $valdata[] = cekvaliditastanggal( "Tanggal Lahir", $data[tgl], $data[bln], $data[thn]);
        $valdata[] = cekvaliditaskode( "Singkatan Gelar Tertinggi", $gelar );
        $valdata[] = cekvaliditaskode( "NIP", $data[nippns], 20 );
        $valdata[] = cekvaliditasinteger( "Mulai Semester", $semester2, 5 );
        $valdata[] = cekvaliditasinteger( "Semester Awal Mengajar", $semesterawal, 5 );
	#print_r($valdata);
        $valdata = array_filter( $valdata, "filter_not_empty" );
        if ( isset( $valdata ) && 0 < count( $valdata ) )
        {
            $errmesg = val_err_mesg( $valdata, 2, TAMBAH_DATA );
            unset( $valdata );
        }
        else
        {
		#echo "aaaa";exit();
            if ( trim( $data[password] ) == "" )
            {
                $data[password] = "{$id}";
            }
            $q = "INSERT INTO dosen (ID,NAMA,ALAMAT,STATUS,IDDEPARTEMEN,PASSWORD,CSS,NIPPNS,INSTANSI,AKTE,IZIN,STATUSKERJA,FLAGPASSWORD,SESUAIBIDANG,JABATAN,".
			"STATUSLOGIN,PENGINGATPASSWORD) ".
			"VALUES ('{$id}','{$data['nama']}','{$data['alamat']}','{$data['status']}','{$data['iddepartemen']}',MD5('{$data['password']}'),'style.inc',".
			"'{$data['nippns']}','{$data['instansi']}','{$data['akte']}','{$data['izin']}','{$data['statuskerja']}',1,'{$data['sesuaibidang']}',".
			"'{$data['jabatan']}','0',NOW())";
            #echo $q.'<br>';
		#exit();
			doquery($koneksi,$q);
            $ketlog = "Tambah data dosen dengan ID={$id} dan Nama={$data['nama']}";
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                buatlog( 9 );
                $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$data['iddepartemen']}'";
                $h = doquery($koneksi,$q);
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d = sqlfetcharray( $h );
                    $kodept = $d[KDPTIMSPST];
                    $kodejenjang = $d[KDJENMSPST];
                    $kodeps = $d[KDPSTMSPST];
                }
                $q = "INSERT INTO msdos (KDPTIMSDOS ,KDPSTMSDOS ,KDJENMSDOS,NOKTPMSDOS ,NODOSMSDOS ,NMDOSMSDOS ,GELARMSDOS , TPLHRMSDOS ,TGLHRMSDOS,KDJEKMSDOS,KDJANMSDOS ,KDPDAMSDOS ,KDSTAMSDOS ,STDOSMSDOS,MLSEMMSDOS , NIPNSMSDOS ,PTINDMSDOS,STKATMSDOS,SRTIJMSDOS,NIDNNMSDOS,SMAWLMSDOS ) VALUES ('{$kodept}','{$kodeps}','{$kodejenjang}','{$ktp}','{$id}','{$data['nama']}','{$gelar}','{$data['tempat']}','{$data['thn']}-{$data['bln']}-{$data['tgl']}','{$data['kelamin']}','{$jabatan}','{$pendidikan}','{$data['status']}','{$data['statuskerja']}','{$semester2}','{$data['nippns']}','{$data['instansi']}',\r\n\t\t\t\t\t'{$data['akte']}','{$data['izin']}','{$id}','{$semesterawal}' )";
                #echo $q.'<br>';
		doquery($koneksi,$q);
                #sinkronisasi_pusaka( $jenis = "TAMBAH", $id, 1 );
                $errmesg = "Data Dosen berhasil ditambah";
                $data = "";
                $id = "";
                $semester2 = $semesterawal = $ktp = $gelar = $jabatan = $pendidikan = $instansidosen = "";
            }
            else
            {
                $errmesg = "Data Dosen tidak berhasil ditambah.<br>NIDN Dosen sudah ada di basisdata, silakan gunakan NIDN yg lain.";
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Dosen", TAMBAH_DATA );
    }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    cekhaktulis( $kodemenu );
    #printjudulmenu( "Tambah Data Dosen", "bantuan" );
    printhelp( trim( $arrayhelp[tambahdosen] ), "bantuan" );
    
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
                        echo "			<div class='portlet-title'>";
												printmesg("Tambah Data Dosen");
								echo "	</div>";
	echo "  	<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=\"index.php\" method=\"post\">
					<div class=\"m-portlet__body\">	
						".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "tambah", "" )."	
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
								<label class=\"col-form-label\">
									".createinputselect( "data[iddepartemen]", $arrayprodidep, "{$key}", "", " class=form-control m-input" )."
								</label>
						</div>
						<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">NIDN Dosen *</label>\r\n    
								<div class=\"col-lg-6\">
									".createinputtext( "id", $id, " class=form-control m-input size=20 id='inputStringListDosenNidn' onkeyup=\"lookupListDosenNidn(this.value);\" placeholder=\"Ketik NIDN / Nama Dosen DIKTI...\" " )."
									<!--<a href=\"javascript:daftardos('form,wewenang,id',document.form.id.value)\" >daftar NIDN Dosen DIKTI</a>-->
									<div class=\"suggestionsBox\" id=\"suggestionsListDosenNidn\" style=\"display: none;\">
										<div class=\"suggestionsListDosenNidn\" id=\"autoSuggestionsListDosenNidn\"></div>
									</div>								
								</div>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Password *</label>\r\n    
								<label class=\"col-form-label\">
									".createinputpassword( "data[password]", "", " class=form-control m-input  size=20" )."Maksimal 16 karakter"."
									<!--[<a target=_blank href='../passwordacak.php'>buat password acak</a>]-->
								</label>
						</div>
						<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Nama Dosen *</label>\r\n    
								<div class=\"col-lg-6\">".createinputtext( "data[nama]", "", " class=form-control m-input  size=50" )." TBDOS : <b>{$dtbdos['NMDOSTBDOS']} </b>\r\n      \r\n      <br>Nama tanpa gelar, titel, tanpa titik, sebaiknya huruf Kapital</div>\r\n  
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Alamat</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtextarea( "data[alamat]", str_replace( "\\r\\n", "\n", "" ), " class=form-control m-input  cols=50 rows=4" )."
								</label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Akte Mengajar</label>\r\n    
								<label class=\"col-form-label\">
									".createinputselect( "data[akte]", $arrayya, "", "", " class=form-control m-input" )."
								</label>
						</div>
						<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Izin Mengajar</label>\r\n    
								<label class=\"col-form-label\">
									".createinputselect( "data[izin]", $arrayya, "", "", " class=form-control m-input" )."
								</label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Status Dosen </label>\r\n    
								<label class=\"col-form-label\">
									".createinputselect( "data[statuskerja]", $arraystatuskerjadosen, "", "", " class=form-control m-input" )."
								</label>
						</div>
						<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Bidang Keahlian sesuai dengan  Program Studi      </label>\r\n    
								<label class=\"col-form-label\">
									".createinputselect( "sesuaibidang", $arraysesuaibidangdosen, "", "", "class=form-control m-input", "" )."
								</label>
						</div>";
						include( "dosen2.php" );
echo "					<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
										<input type=\"submit\" class=\"btn btn-brand\" value=Tambah></input>
										<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
									</div>
						</div>
					</div>
				</form>
			</div>
			<!--end::Portlet-->			
			</div>
			<!--end::md-12-->	
		</div>
		<!--end::row-->	
	</div>
		<!--end::container-fluid-->";
}
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestampildosen.php" );
}
if ( $aksi == "" )
{

echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
                        echo "			<div class='portlet-title'>";
												printmesg("Lihat Data Dosen");
								echo "	</div>";
						echo "
			<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
						<input type=hidden name=pilihan value='{$pilihan}'>
						<input type=hidden name=aksi value='tampilkan'>
						<div class=\"m-portlet__body\">		
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
								<div class=\"col-lg-6\">
									<select class=form-control m-input name=iddepartemen>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
									foreach ( $arrayprodidep as $k => $v )
									{
										echo "<option value='{$k}'>{$v}</option>";
									}
									echo "\r\n\t\t\t\t\t</select>
								</div>
							</div>";
echo "						<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">NIDN</label>\r\n    
								<div class=\"col-lg-6\">
									".createinputtext( "id", $id, " class=form-control m-input  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,form.iddepartemen.value);\" placeholder=\"Ketik NIDN / Nama Dosen...\"" )."
									<div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">
									   <div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\"></div>
									</div>
								</div>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Nama</label>\r\n    
								<label class=\"col-form-label\">
									".createinputtext( "nama", $nama, " class=form-control m-input  size=50" )."
								</label>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Status</label>\r\n    
								<label class=\"col-form-label\">
									<select class=form-control m-input name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
										foreach ( $arraystatusdosen as $k => $v )
										{
											echo "<option value='{$k}'>{$v}</option>";
										}
	echo "							</select>
								</label>
							</div>";
include( "../mahasiswa/cari2.php" );
echo "						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
										<input type=\"submit\" class=\"btn btn-brand\" value=Tampilkan></input>
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
	</script>";
}
?>