<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi == "hapus" )
{
    cekhaktulis( $kodemenu );
    $q = "DELETE FROM mahasiswa WHERE ID='{$idhapus}'";
    mysqli_query($koneksi,$q);
    $ketlog = "Hapus data Mahasiswa dengan ID={$idhapus}";
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        if ( file_exists( "foto/{$d['ID']}" ) )
        {
            @unlink( @"foto/{$d['ID']}" );
        }
        buatlog( 14 );
        $errmesg = "Data Mahasiswa dengan ID = '{$idhapus}' berhasil dihapus";
        $q = "DELETE FROM pengambilanmk WHERE IDMAHASISWA='{$idhapus}'";
        mysqli_query($koneksi,$q);
        $q = "DELETE FROM nilai WHERE IDMAHASISWA='{$idhapus}'";
        mysqli_query($koneksi,$q);
        $q = "DELETE FROM msmhs WHERE NIMHSMSMHS='{$idhapus}'";
        mysqli_query($koneksi,$q);
    }
    else
    {
        $errmesg = "Data Mahasiswa dengan ID = '{$idhapus}' tidak berhasil dihapus";
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
        include( "kelulusan.php" );
    }
    else if ( $tab == 2 )
    {
        include( "riwayatpendidikan.php" );
    }
    else if ( $tab == 3 )
    {
        include( "skripsi.php" );
    }
    else if ( $tab == 4 )
    {
        include( "pindahan.php" );
    }
    else if ( $tab == 5 )
    {
        include( "aktivitas.php" );
    }
    else if ( $tab == 6 )
    {
        include( "semester.php" );
    }
    else if ( $tab == 7 )
    {
        include( "fileijazah.php" );
    }
    $aksi = "formupdate";
}
if ( $aksi == "formupdate" )
{
    cekhaktulis( $kodemenu );
    printjudulmenu( "Update Data Mahasiswa" );
    $arraymenutab[0] = "Biodata";
    $arraymenutab[5] = "Aktivitas<br>Kuliah*";
    $arraymenutab[6] = "Nilai<br>Semester*";
    $arraymenutab[1] = "Kelulusan/Cuti/<br>Non-Aktif/DO";
    $arraymenutab[3] = "Skripsi";
    $arraymenutab[4] = "Pindahan";
    $arraymenutab[2] = "Riwayat<br>Pendidikan<br> u/ S-3";
    $arraymenutab[7] = "File<br>Ijazah/<br>Transkrip";
    echo "\t\t\t\r\n\t\t<table width=95% class=menutab>\r\n\t\t\t<tr>\r\n\t";
    if ( $tab == "" )
    {
        $tab = 0;
    }
    foreach ( $arraymenutab as $k => $v )
    {
        $bgtab = "";
        if ( $tab == $k )
        {
            $bgtab = " style='color:#004488' ";
        }
        echo "\r\n\t\t\t\t\t<td align=center ><a {$bgtab} href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$k}&idupdate={$idupdate}'>{$v}</td>\r\n\t\t";
    }
    echo "\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t";
    if ( $tab == 0 || $tab == "" )
    {
        include( "biodata.php" );
    }
    else if ( $tab == 1 )
    {
        include( "kelulusan.php" );
    }
    else if ( $tab == 2 )
    {
        include( "riwayatpendidikan.php" );
    }
    else if ( $tab == 3 )
    {
        include( "skripsi.php" );
    }
    else if ( $tab == 4 )
    {
        include( "pindahan.php" );
    }
    else if ( $tab == 5 )
    {
        include( "aktivitas.php" );
    }
    else if ( $tab == 6 )
    {
        include( "semester.php" );
    }
    else if ( $tab == 7 )
    {
        include( "fileijazah.php" );
    }
}
if ( $aksi == "tambah" && $REQUEST_METHOD == POST )
{
    cekhaktulis( $kodemenu );
    if ( trim( $id ) == "" )
    {
        $errmesg = "NIM Mahasiswa harus diisi";
    }
    else
    {
        if ( trim( $data[nama] ) == "" )
        {
            $errmesg = "Nama Mahasiswa harus diisi";
        }
        else
        {
            if ( trim( $data[password] ) == "" )
            {
                $data[password] = "{$id}";
            }
            if ( $tahunlulus + 0 == 0 )
            {
                $tahunlulus = "'{$tahunlulus}'";
            }
            else
            {
                $tahunlulus = "NULL";
            }
            $q = "\r\n\t\t\tINSERT INTO mahasiswa (ID,NAMA,ALAMAT,STATUS,IDPRODI,ANGKATAN,IDDOSEN,TA,DOSENTA,\r\n\t\t\tTEMPAT,TANGGAL,KELAMIN,AGAMA,TELEPON,ASAL,TAHUNLULUS,TANGGALMASUK,TANGGALKELUAR,\r\n\t\t\tPASSWORD,CSS,KELAS) \r\n\t\t\tVALUES ('{$id}','{$data['nama']}','{$data['alamat']}','{$status}','{$idprodi}',\r\n\t\t\t'{$tahuna}','{$iddosen}','{$data['ta']}','{$data['dosenta']}',\r\n\t\t\t'{$data['tempat']}','{$data['thn']}-{$data['bln']}-{$data['tgl']}','{$data['kelamin']}',\r\n\t\t\t'{$data['agama']}','{$data['telepon']}','{$data['asal']}','{$tahunlulus}',\r\n\t\t\t'{$dtm['thn']}-{$dtm['bln']}-{$dtm['tgl']}','{$dtk['thn']}-{$dtk['bln']}-{$dtk['tgl']}',\r\n\t\t\tPASSWORD('{$data['password']}'),'style.inc','{$data['kelas']}')\r\n\t\t";
            mysqli_query($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $ketlog = "Update data Mahasiswa dengan ID={$id} ({$data['nama']})";
                buatlog( 12 );
                if ( $foto != "none" )
                {
                    move_uploaded_file( $foto, "foto/{$id}" );
                }
                $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
                $h = mysqli_query($koneksi,$q);
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d = sqlfetcharray( $h );
                    $kodept = $d[KDPTIMSPST];
                    $kodejenjang = $d[KDJENMSPST];
                    $kodeps = $d[KDPSTMSPST];
                }
                $q = "INSERT INTO msmhs \r\n      (KDPTIMSMHS ,KDPSTMSMHS,KDJENMSMHS,NIMHSMSMHS ,NMMHSMSMHS ,TPLHRMSMHS ,\r\n      TGLHRMSMHS,KDJEKMSMHS,TAHUNMSMHS ,SMAWLMSMHS,BTSTUMSMHS,ASSMAMSMHS ,\r\n      TGMSKMSMHS ,TGLLSMSMHS,STMHSMSMHS ,STPIDMSMHS,SKSDIMSMHS,ASNIMMSMHS,\r\n      ASPTIMSMHS ,ASJENMSMHS ,ASPSTMSMHS ,BISTUMSMHS ,PEKSBMSMHS ,NMPEKMSMHS ,\r\n      PTPEKMSMHS ,PSPEKMSMHS ,NOPRMMSMHS ,NOKP1MSMHS ,NOKP2MSMHS,NOKP3MSMHS ,\r\n      NOKP4MSMHS,SHIFTMSMHS)\r\n      VALUES \r\n      ('{$kodept}','{$kodeps}','{$kodejenjang}','{$id}','{$data['nama']}','{$data['tempat']}',\r\n      '{$data['thn']}-{$data['bln']}-{$data['tgl']}','{$data['kelamin']}','{$tahuna}','{$tahun}{$semester}',\r\n      '{$tahun2}{$semester2}','{$kodeprop}','{$dtm['thn']}-{$dtm['bln']}-{$dtm['tgl']}','{$dtk['thn']}-{$dtk['bln']}-{$dtk['tgl']}',\r\n      '{$status}','{$statusbaru}','{$sksbaru}','{$nimasal}','{$ptasal}','{$jasal}','{$psasal}',\r\n      '{$kodebiaya}','{$kodekerja}','{$tempatkerja}','{$ptkerja}','{$pskerja}',\r\n      '{$nidnpro}','{$nidnpro1}','{$nidnpro2}','{$nidnpro3}','{$nidnpro4}','{$kodekelas}')";
                mysqli_query($koneksi,$q);
                $errmesg = "Data Mahasiswa berhasil ditambah";
                $data = "";
                $id = "";
            }
            else
            {
                $errmesg = "Data Mahasiswa tidak berhasil ditambah";
            }
        }
    }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
    cekhaktulis( $kodemenu );
    printjudulmenu( "Tambah Data Mahasiswa" );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" )."<tr class=judulform>\r\n\t\t\t<td>Jurusan/Program Studi</td>\r\n\t\t\t<td>".createinputselect( "idprodi", $arrayprodidep, $idprodi, "", " class=masukan" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Angkatan</td>\r\n\t\t\t<td>".createinputtahun( "tahuna", $tahuna, " class=masukan " )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>NIDN Dosen Wali</td>\r\n\t\t\t<td>".createinputtext( "iddosen", $iddosen, " class=masukan  size=20" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftardosen('form,wewenang,iddosen',\r\n\t\t\tdocument.form.id.value)\" >\r\n\t\t\tdaftar dosen\r\n\t\t\t</a>\t\t\t\t \r\n      </td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>NIM Mahasiswa *</td>\r\n\t\t\t<td>".createinputtext( "id", $id, " class=masukan  size=20" )."</td>\r\n\t\t</tr> \r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Password *</td>\r\n\t\t\t<td>".createinputpassword( "data[password]", $data[password], " class=masukan  size=20" )."</td>\r\n\t\t</tr> \r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Nama Mahasiswa *</td>\r\n\t\t\t<td>".createinputtext( "data[nama]", $data[nama], " class=masukan  size=50" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Foto</td>\r\n\t\t\t<td>\r\n\t\t\t<input type=file name=foto class=masukan>\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Alamat</td>\r\n\t\t\t<td>".createinputtextarea( "data[alamat]", $data[alamat], " class=masukan  cols=50 rows=4" )."</td>\r\n\t\t</tr>"."<tr >\r\n\t\t\t<td>Tempat/Tanggal Lahir</td>\r\n\t\t\t<td>".createinputtext( "data[tempat]", "Bandung", " class=masukan  size=10" )." / ".createinputtanggal( "data", $data, " class=masukan" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Jenis Kelamin</td>\r\n\t\t\t<td>".createinputselect( "data[kelamin]", $arraykelamin, $data[kelamin], "", " class=masukan " )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Agama</td>\r\n\t\t\t<td>".createinputselect( "data[agama]", $arrayagama, $data[agama], "", " class=masukan " )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>No Telepon/HP</td>\r\n\t\t\t<td>".createinputtext( "data[telepon]", $data[telepon], " class=masukan  size=50" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Asal Sekolah</td>\r\n\t\t\t<td>".createinputtext( "data[asal]", $data[asal], " class=masukan  size=50" )."</td>\r\n\t\t</tr> \r\n \t\t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n\t\t</tr>\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Kelas Default Pengambilan Mata Kuliah</td>";
    if ( $data[kelas] == "" )
    {
        $data[kelas] = "1";
    }
    echo "\r\n\t\t\t<td>".createinputtext( "data[kelas]", $data[kelas], " class=masukan  size=2" )."</td>\r\n\t\t</tr> \r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Tahun Lulus</td>\r\n\t\t\t<td>".createinputtext( "tahunlulus", $tahunlulus, " class=masukan size=4" )."</td>\r\n\t\t</tr>"."<tr >\r\n\t\t\t<td>Tanggal Masuk</td>\r\n\t\t\t<td>".createinputtanggal( "dtm", $dtm, " class=masukan" )."</td>\r\n\t\t</tr>"."<tr >\r\n\t\t\t<td>Tanggal Keluar/Lulus</td>\r\n\t\t\t<td>".createinputtanggalblank( "dtk", $dtk, " class=masukan" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Status</td>\r\n\t\t\t<td>".createinputselect( "status", $arraystatusmahasiswa, $status, "", " class=masukan " )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Judul Tugas Akhir/Skripsi</td>\r\n\t\t\t<td>".createinputtextarea( "data[ta]", $data[ta], " class=masukan  cols=50 rows=4" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Dosen Pembimbing</td>\r\n\t\t\t<td>".createinputtextarea( "data[dosenta]", $data[dosenta], " class=masukan  cols=50 rows=4" )."</td>\r\n\t\t</tr>";
    include( "mahasiswa2.php" );
    echo "\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tambah' class=masukan>\r\n\t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n \t\t";
}
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestampilmahasiswa.php" );
}
if ( $aksi == "" )
{
    #printjudulmenu( "Lihat Data Mahasiswa " );
    #printmesg( $errmesg );
	 echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Lihat Data Mahasiswa");
				echo "	</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
    echo "					<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								<input type=hidden name=pilihan value='{$pilihan}'>
								<input type=hidden name=aksi value='tampilkan'>
								<div class=\"m-portlet__body\">		
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
										<div class=\"col-lg-6\">
											<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												foreach ( $arrayprodidep as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
		echo "								</select>
										</div>
									</div>";
    if ( $jenisusers == 0 )
    {
        #echo "\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tNIDN Dosen Wali\r\n\t\t\t\t</td>\r\n\t\t\t\t<td> ".createinputtext( "iddosen", $iddosen, " class=masukan  size=20" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftardosen('form,wewenang,iddosen',\r\n\t\t\tdocument.form.id.value)\" >\r\n\t\t\tdaftar dosen\r\n\t\t\t</a>\t\t\t\t\r\n \t\t\t\t</td>\r\n\t\t\t</tr>";
		echo "				<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">NIDN Dosen Wali</label>\r\n    
								<div class=\"col-lg-6\">
									".createinputtext( "iddosen", $iddosen, " class=form-control m-input  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,form.idprodi.value);\" placeholder=\"Ketik NIDN / Nama Dosen...\" " )."
									<div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">
									   <div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\"></div>
									</div>
								</div>
							</div>";
	}
     echo "							<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
										<div class=\"col-lg-6\">";
											$waktu = getdate();
	echo "									<select name=angkatan class=form-control m-input><option value=''>Semua</option>";
												$arrayangkatan = getarrayangkatan( );
												foreach ( $arrayangkatan as $k => $v )
												{
													echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
												}
	echo "									</select>
										</div>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
										<div class=\"col-lg-6\">
											".createinputtext( "id", $id, " class=form-control m-input  size=20 id='inputString' onkeyup=\"lookup(this.value,form.angkatan.value,form.idprodi.value);\" placeholder=\"Ketik NIM / Nama Mahasiswa...\" " )."
											<!--<a href=\"javascript:daftarmhs('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >daftar mahasiswa
											</a>-->
											<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
												<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
											</div>
										</div>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Nama</label>\r\n    
										<div class=\"col-lg-6\">".createinputtext( "nama", $nama, " class=form-control m-input  size=50" )."</div>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Status Aktifitas</label>\r\n    
										<div class=\"col-lg-6\">
											<select class=form-control m-input name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												foreach ( $arraystatusmahasiswa as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
    echo "									</select>
										</div>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit value='Tampilkan' class=\"btn btn-brand\">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t";
}
?>
