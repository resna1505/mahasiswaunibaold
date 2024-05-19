<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

#periksaroot( );
if ( $aksi == "hapus" )
{
    if ( $_GET['sessid'] == $_SESSION['token'] )
    {
        cekhaktulis( $kodemenu );
        $q = "DELETE FROM mahasiswa WHERE ID='{$idhapus}'";
        doquery($koneksi,$q);
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
            doquery($koneksi,$q);
            $q = "DELETE FROM nilai WHERE IDMAHASISWA='{$idhapus}'";
            doquery($koneksi,$q);
            $q = "DELETE FROM msmhs WHERE NIMHSMSMHS='{$idhapus}'";
            doquery($koneksi,$q);
            $q = "DELETE FROM trakm WHERE NIMHSTRAKM='{$idhapus}'";
            doquery($koneksi,$q);
            $q = "DELETE FROM trnlm WHERE NIMHSTRNLM='{$idhapus}'";
            doquery($koneksi,$q);
            $q = "DELETE FROM trnlmsp WHERE NIMHSTRNLM='{$idhapus}'";
            doquery($koneksi,$q);
            $q = "DELETE FROM trskr WHERE NIMHSTRSKR='{$idhapus}'";
            doquery($koneksi,$q);
            $q = "DELETE FROM msphs WHERE NIMHSMSPHS='{$idhapus}'";
            doquery($koneksi,$q);
            $q = "DELETE FROM trlsm WHERE NIMHSTRLSM='{$idhapus}'";
            doquery($koneksi,$q);
            $q = "DELETE FROM trnlp WHERE NIMHSTRNLP='{$idhapus}'";
            doquery($koneksi,$q);
            $q = "DELETE FROM trpid WHERE NIMHSTRPID='{$idhapus}'";
            doquery($koneksi,$q);
            $q = "DELETE FROM trmln WHERE NIMHSTRMLN='{$idhapus}'";
            doquery($koneksi,$q);
            $q = "DELETE FROM mahasiswa2 WHERE ID='{$idhapus}'";
            doquery($koneksi,$q);
            #sinkronisasi_pusaka( $jenis = "HAPUS", $idhapus, 2 );
        }
        else
        {
            $errmesg = "Data Mahasiswa dengan ID = '{$idhapus}' tidak berhasil dihapus";
        }
        $aksi = "tampilkan";
    }
    else
    {
        $errmesg = token_err_mesg( "Mahasiswa", HAPUS_DATA );
        $aksi = "tampilkan";
    }
}
if ( $aksi == "update" )
{
    #cekhaktulis( $kodemenu );
    if ( $tab == 0 || $tab == "" )
    {
		//printmesg($errmesg);
        include( "biodatapmb.php" );
    }
    
    $aksi = "formupdate";
}

if ( $aksi == "formupdate" )
{
    #cekhaktulis( $kodemenu );
    
    $arraymenutab[0] = "Data Email Pembayaran";
    /*$arraymenutab[9] = "Biodata (2)";
    $arraymenutab[5] = "Aktivitas<br>Kuliah*";
    $arraymenutab[6] = "Nilai<br>Semester*";
    $arraymenutab[8] = "Konversi<br>Nilai";
    $arraymenutab[1] = "Kelulusan/<br>Cuti/<br>Non-Aktif/DO";
    $arraymenutab[3] = "Skripsi";
    $arraymenutab[11] = "Beasiswa";
    $arraymenutab[4] = "Pindahan";
    $arraymenutab[10] = "Mhs Asing";
    $arraymenutab[2] = "Riwayat<br>Pendidikan<br> u/ S-3";
    $arraymenutab[7] = "File<br>Ijazah/<br>Transkrip";
    $arraymenutab[12] = "Reschedule<br>Tagihan";*/	
   
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
												printtitle("Update Data Mahasiswa");
								/*echo	"	</div>
										
										</div>
									<div class='portlet-body form'>
                            <form name=form action=index.php method=post>\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
							<table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr>\r\n\t";*/
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
        /*if ( $tab == $k )
        {
            $bgtab = " style='color:#004488' ";
        }*/
		if ( $tab == $k )
        {
            $bgtab = "class='nav-link active' style='color:#004488' ";
        
		}else{
			$bgtab = "class='nav-link active' ";
		}
        #echo "\r\n\t\t\t\t\t<td align=center ><a {$bgtab} href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$k}&idupdate={$idupdate}'>{$v}</td>\r\n\t\t";
		echo "<li class=\"nav-item\">
					<a {$bgtab} href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$k}&idupdate={$idupdate}'>{$v}</a>";
		echo "</li>";
		$notab++;
	}
    #echo "\r\n\t\t\t\t</tr>\r\n\t\t\t</table></div></div>\r\n\t";
	echo "</ul>";
	echo "<div class=\"tab-content\">";
    if ( $tab == "" || $tab ==0)
    {
		#echo "ll";exit();
		#$idprodi = getfield( "IDPRODI", "mahasiswa", " WHERE ID='{$idupdate}'" );
        include( "biodatapmb.php" );
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
    else if ( $tab == 8 )
    {
        include( "konversi.php" );
    }
    else if ( $tab == 10 )
    {
        include( "asing.php" );
    }
    else if ( $tab == 11 )
    {
        include( "beasiswa.php" );
    }
    else if ( $tab == 12 )
    {
        include( "rescheduletagihan.php" );
    }
    else if ( $tab == 9 )
    {
        $idprodi = getfield( "IDPRODI", "mahasiswa", " WHERE ID='{$idupdate}'" );
        $namamakul = getfield( "NAMA", "mahasiswa", " WHERE ID='{$idupdate}'" );
        /*echo "\r\n<br>\r\n  <div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n     <tr class=judulform>\r\n\t\t\t<td width=150>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$idprodi]."\r\n      </td>\r\n\t\t</tr> \r\n    <tr>\r\n      <td>NIM Mahasiswa</td>\r\n      <td><b>{$idupdate}</td>\r\n    </tr>\r\n    <tr>\r\n      <td>Nama Mahasiswa</td>\r\n      <td><b>".$namamakul."</td>\r\n    </tr>\r\n    </table></div></div>\r\n";
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
							<label class=\"col-lg-2 col-form-label\">NIM Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$idupdate}</label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Nama Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>".$namamakul."</b></label>
						</div>";
		include( "biodata2.php" );
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
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Mahasiswa", TAMBAH_DATA );
    }
    else
    {
        $vldts[] = cekvaliditasinteger( "Jurusan/Program Studi", $idprodi, 32, false );
        $vldts[] = cekvaliditastahun( "Angkatan", $tahuna, 4, false );
        $vldts[] = cekvaliditaskode( "Gelombang Masuk", $gelombang );
        $vldts[] = cekvaliditasinteger( "NIDN Dosen Wali", $iddosen );
        $vldts[] = cekvaliditaskode( "NIM", $id, 32, false );
        $vldts[] = cekvaliditasnama( "Nama", $data['nama'], 64, false );
        $vldts[] = cekvaliditasfile( "Foto", $_FILES['foto'], 0 );
        $vldts[] = cekvaliditasnama( "Tempat Lahir", $data['tempat'] );
        $vldts[] = cekvaliditastanggal( "Tanggal Lahir", $data['tgl'], $data['bln'], $data['thn'] );
        $vldts[] = cekvaliditaskode( "Kelamin", $data['kelamin'], 1 );
        $vldts[] = cekvaliditaskode( "Agama", $data['agama'], 1 );
        $vldts[] = cekvaliditastelp( "Telpon/HP", $data['telepon'] );
        $vldts[] = cekvaliditasnama( "Asal Sekolah", $data['asal'] );
        $vldts[] = cekvaliditasnama( "Nama Ayah", $namaayah );
        $vldts[] = cekvaliditastelp( "No Kontak Ayah", $noayah );
        $vldts[] = cekvaliditaskode( "Penghasilan Ayah/bulan", $penghasilanayah );
        $vldts[] = cekvaliditasnama( "Nama Ibu", $namaibu );
        $vldts[] = cekvaliditastelp( "No Kontak Ibu", $noibu );
        $vldts[] = cekvaliditaskode( "Penghasilan Ibu/bulan", $penghasilanibu );
        $vldts[] = cekvaliditaskode( "Kelas default", $data['kelas'] );
        $vldts[] = cekvaliditaskode( "Jenis Kelas default", $jeniskelas );
        $vldts[] = cekvaliditastanggal( "Tanggal Masuk", $dtm['tgl'], $dtm['bln'], $dtm['thn'] );
        $vldts[] = cekvaliditastanggal( "Tanggal Keluar/Lulus", $dtk['tgl'], $dtk['bln'], $dtk['thn'] );
        $vldts[] = cekvaliditaskode( "Status", $status, 1 );
        $vldts[] = cekvaliditaskode( "Kelas", $kodekelas, 1 );
        $vldts[] = cekvaliditasthnajaran( "Semester Awal terdaftar", $tahun, $semester );
        $vldts[] = cekvaliditasthnajaran( "Batas Studi", $tahun2, $semester2 );
        $vldts[] = cekvaliditaskode( "Kode propinsi", $kodeprop, 4 );
        $vldts[] = cekvaliditaskode( "Status Awal mahasiswa", $statusbaru, 1 );
        $vldts[] = cekvaliditasinteger( "Jumlah SKS diakui (Pindahan)", $sksbaru );
        $vldts[] = cekvaliditaskode( "NIM Asal (Pindahan)", $nimasal );
        $vldts[] = cekvaliditaskode( "Kode PT Asal (Pindahan)", $ptasal );
        $vldts[] = cekvaliditaskode( "Jenjang PT Asal(Pindahan)", $jasal, 1 );
        $vldts[] = cekvaliditaskode( "Kode Prodi Sebelumnya (Pindahan)", $psasal, 16 );
        $vldts[] = cekvaliditaskode( "Kode Biaya Studi (S3)", $kodebiaya, 1 );
        $vldts[] = cekvaliditaskode( "Kode Pekerjaan (S3)", $kodekerja, 1 );
        $vldts[] = cekvaliditasnama( "Nama Tempat Kerja (S3)", $tempatkerja );
        $vldts[] = cekvaliditasinteger( "Kode PT tempat Kerja (S3)", $ptkerja, 8 );
        $vldts[] = cekvaliditaskode( "Program Studi Tempat Kerja(S3)", $pskerja, 8 );
        $vldts[] = cekvaliditasinteger( "NIDN Promotor (S3)", $nidnpro, 10 );
        $vldts[] = cekvaliditasinteger( "NIDN Ko-Promotor #1 (S3)", $nidnpro, 10 );
        $vldts[] = cekvaliditasinteger( "NIDN Ko-Promotor #2 (S3)", $nidnpro, 10 );
        $vldts[] = cekvaliditasinteger( "NIDN Ko-Promotor #3 (S3)", $nidnpro, 10 );
        $vldts[] = cekvaliditasinteger( "NIDN Ko-Promotor #4 (S3)", $nidnpro, 10 );
        $vldts = array_filter( $vldts, "filter_not_empty" );
		#echo "kkk";exit();
        if ( isset( $vldts ) && 0 < count( $vldts ) )
        {
            $errmesg = val_err_mesg( $vldts, 2, TAMBAH_DATA );
            unset( $vldts );
        }
        else
        {
			echo "kkk";exit();
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
                    if ( $tahunlulus + 0 != 0 )
                    {
                        $tahunlulus = "'{$tahunlulus}'";
                    }
                    else
                    {
                        $tahunlulus = "NULL";
                    }
                    $q = "\r\n\t\t\tINSERT INTO mahasiswa (ID,NAMA,ALAMAT,STATUS,IDPRODI,ANGKATAN,IDDOSEN,TA,DOSENTA,\r\n\t\t\tTEMPAT,TANGGAL,KELAMIN,AGAMA,TELEPON,ASAL,TAHUNLULUS,TANGGALMASUK,TANGGALKELUAR,\r\n\t\t\tPASSWORD,CSS,KELAS,NAMAAYAH,\r\n      ALAMATAYAH,NOAYAH,PENGHASILANAYAH,NAMAIBU,ALAMATIBU,NOIBU,PENGHASILANIBU,GELOMBANG,JENISKELAS,\r\n      PASSWORD2,SISTEMKRS,KELOMPOKKURIKULUM,\r\n\r\n      KOTA ,PROVINSI ,PENDIDIKAN ,HP ,EMAIL   ,FLAGPASSWORD  ,SKPINDAHAN,TANGGALSKPINDAHAN      ,TANGGALKARTU,\r\n      NIRM\r\n      \r\n      ) \r\n\t\t\tVALUES ('{$id}','".strtoupper( $data[nama] )."','{$data['alamat']}','{$status}','{$idprodi}',\r\n\t\t\t'{$tahuna}','{$iddosen}','{$data['ta']}','{$data['dosenta']}',\r\n\t\t\t'{$data['tempat']}','{$data['thn']}-{$data['bln']}-{$data['tgl']}','{$data['kelamin']}',\r\n\t\t\t'{$data['agama']}','{$data['telepon']}','{$data['asal']}',{$tahunlulus},\r\n\t\t\t'{$dtm['thn']}-{$dtm['bln']}-{$dtm['tgl']}','{$dtk['thn']}-{$dtk['bln']}-{$dtk['tgl']}',\r\n\t\t\tMD5('{$data['password']}'),'style.inc','{$data['kelas']}','{$namaayah}',\r\n      '{$alamatayah}','{$noayah}','{$penghasilanayah}','{$namaibu}','{$alamatibu}','{$noibu}','{$penghasilanibu}','{$gelombang}','{$jeniskelas}',\r\n\t\t\tMD5('{$data['password2']}'),'{$sistemkrs}','{$kelompokkurikulum}',\r\n\t\t\t\r\n\t\t\t'{$data['kota']}','{$data['provinsi']}','{$data['pendidikan']}','{$data['hp']}','{$data['email']}' ,1,\r\n\t\t\t'{$skpindahan}','{$tanggalskpindahan['thn']}-{$tanggalskpindahan['bln']}-{$tanggalskpindahan['tgl']}',\r\n      '{$tanggalkartu['thn']}-{$tanggalkartu['bln']}-{$tanggalkartu['tgl']}',\r\n      '{$nirm}'\r\n      ) \r\n\t\t\t\r\n\t\t";
                    doquery($koneksi,$q);
                    echo mysqli_error($koneksi);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $ketlog = "Update data Mahasiswa dengan ID={$id} ({$data['nama']})";
                        buatlog( 12 );
                        if ( $foto != "none" )
                        {
                            move_uploaded_file( $foto, "foto/{$id}" );
                        }
                        $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
                        $h = doquery($koneksi,$q);
                        if ( 0 < sqlnumrows( $h ) )
                        {
                            $d = sqlfetcharray( $h );
                            $kodept = $d[KDPTIMSPST];
                            $kodejenjang = $d[KDJENMSPST];
                            $kodeps = $d[KDPSTMSPST];
                        }
                        $q = "INSERT INTO msmhs \r\n\t\t      (KDPTIMSMHS ,KDPSTMSMHS,KDJENMSMHS,NIMHSMSMHS ,NMMHSMSMHS ,TPLHRMSMHS ,\r\n\t\t      TGLHRMSMHS,KDJEKMSMHS,TAHUNMSMHS ,SMAWLMSMHS,BTSTUMSMHS,ASSMAMSMHS ,\r\n\t\t      TGMSKMSMHS ,TGLLSMSMHS,STMHSMSMHS ,STPIDMSMHS,SKSDIMSMHS,ASNIMMSMHS,\r\n\t\t      ASPTIMSMHS ,ASJENMSMHS ,ASPSTMSMHS ,BISTUMSMHS ,PEKSBMSMHS ,NMPEKMSMHS ,\r\n\t\t      PTPEKMSMHS ,PSPEKMSMHS ,NOPRMMSMHS ,NOKP1MSMHS ,NOKP2MSMHS,NOKP3MSMHS ,\r\n\t\t      NOKP4MSMHS,SHIFTMSMHS)\r\n\t\t      VALUES \r\n\t\t      ('{$kodept}','{$kodeps}','{$kodejenjang}','{$id}','".strtoupper( $data[nama] )."','{$data['tempat']}',\r\n\t\t      '{$data['thn']}-{$data['bln']}-{$data['tgl']}','{$data['kelamin']}','{$tahuna}','{$tahun}{$semester}',\r\n\t\t      '{$tahun2}{$semester2}','{$kodeprop}','{$dtm['thn']}-{$dtm['bln']}-{$dtm['tgl']}','{$dtk['thn']}-{$dtk['bln']}-{$dtk['tgl']}',\r\n\t\t      '{$status}','{$statusbaru}','{$sksbaru}','{$nimasal}','{$ptasal}','{$jasal}','{$psasal}',\r\n\t\t      '{$kodebiaya}','{$kodekerja}','{$tempatkerja}','{$ptkerja}','{$pskerja}',\r\n\t\t      '{$nidnpro}','{$nidnpro1}','{$nidnpro2}','{$nidnpro3}','{$nidnpro4}','{$kodekelas}')";
                        doquery($koneksi,$q);
                        $errmesg = "Data Mahasiswa berhasil ditambah";
                        #sinkronisasi_pusaka( $jenis = "TAMBAH", $id, 2 );
                        $data = "";
                        $tahunlulus = "";
                        $id = "";
                    }
                    else
                    {
                        $errmesg = "Data Mahasiswa tidak berhasil ditambah. ";
                        $q = "SELECT ID FROM mahasiswa WHERE ID='{$id}'";
                        $h = doquery($koneksi,$q);
                        if ( 0 < sqlnumrows( $h ) )
                        {
                            $errmesg .= "<br>NIM Mahasiswa sudah ada di dalam basis data, silakan gunakan NIM yg lain.";
                        }
                    }
                }
            }
        }
    }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    cekhaktulis( $kodemenu );
  
    #printmesg( $errmesg );
    //echo "\r\n\t\t<form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "tambah", "" )."<tr class=judulform>\r\n\t\t\t<td>Jurusan/Program Studi</td>\r\n\t\t\t<td>".createinputselect( "idprodi", $arrayprodidep, $idprodi, "", " class=masukan" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Angkatan</td>\r\n\t\t\t<td>".createinputtahun( "tahuna", $tahuna, " class=masukan " )."</td>\r\n\t\t</tr>";

   echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Tambah Data Mahasiswa");
				echo "	</div>";
		echo "			<div class=\"m-portlet\">
				
						<!--begin::Form-->
                        <form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>
						   ".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "tambah", "" )."
						<div class=\"m-portlet__body\">
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
								<div class=\"col-lg-6\">".createinputselect( "idprodi", $arrayprodidep, $idprodi, "", " class=form-control m-input" )."</div>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
								<div class=\"col-lg-6\">".createinputtahun( "tahuna", $tahuna, " class=form-control m-input " )."</div>
							</div>";
    if ( $gelombang == "" )
    {
        $gelombang = 1;
    }
    #echo "\r\n    <tr class=judulform>\r\n\t\t\t<td>Gelombang Masuk</td>\r\n\t\t\t<td>".createinputtext( "gelombang", $gelombang, " class=form-control m-input  size=2" )."\r\n       </td>\r\n\t\t</tr>    \r\n<tr class=judulform>\r\n\t\t\t<td>KELOMPOK KURIKULUM</td>\r\n\t\t\t<td>".createinputselect( "kelompokkurikulum", $arraykelompokkurikulum, "{$kelompokkurikulum}", "", " class=form-control m-input " )."</td>\r\n\t\t</tr>\t\r\n\r\n    <tr class=judulform>\r\n\t\t\t<td>NIDN Dosen Wali</td>\r\n\t\t\t<td>".createinputtext( "iddosen", $iddosen, " class=form-control m-input  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,'');\" "  )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftardosen('form,wewenang,iddosen',\r\n\t\t\tdocument.form.id.value)\" >\r\n\t\t\tdaftar dosen\r\n\t\t\t</a>\t\t\t\t \r\n     <div class=\"suggestionsBox\" id=\"suggestionsDosen\" style=\"display: none;\">\r\n               <div class=\"suggestionList\" id=\"autoSuggestionsListDosen\"> </td>\r\n\t\t</tr>\r\n    \r\n    <tr class=judulform>\r\n\t\t\t<td>NIM Mahasiswa *</td>\r\n\t\t\t<td>".createinputtext( "id", $id, " class=form-control m-input  size=20" )."</td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>NIRM </td>\r\n\t\t\t<td>".createinputtext( "nirm", $nirm, " class=form-control m-input  size=20" )."</td>\r\n\t\t</tr> \t\t\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Password *</td>\r\n\t\t\t<td>".createinputpassword( "data[password]", $data[password], " class=form-control m-input  size=20" )."\r\n      [<a target=_blank href='../passwordacak.php'>buat password acak</a>]\r\n      </td>\r\n\t\t</tr> \r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Password Orang Tua/Wali*</td>\r\n\t\t\t<td>".createinputpassword( "data[password2]", $data[password2], " class=form-control m-input  size=20" )."\r\n      [<a target=_blank href='../passwordacak.php'>buat password acak</a>]\r\n      </td>\r\n\t\t</tr> \r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Nama Mahasiswa *</td>\r\n\t\t\t<td>".createinputtext( "data[nama]", $data[nama], " class=form-control m-input  size=50" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Foto</td>\r\n\t\t\t<td>\r\n\t\t\t<input type=file name=foto class=form-control m-input>\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Alamat</td>\r\n\t\t\t<td>".createinputtextarea( "data[alamat]", $data[alamat], " class=form-control m-input  cols=50 rows=4" )."</td>\r\n\t\t</tr>\r\n\r\n    <tr class=judulform>\r\n\t\t\t<td>Kota</td>\r\n\t\t\t<td>".createinputtext( "data[kota]", $data[kota], " class=form-control m-input  size=50" )."{$wajibdiisi}</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>Provinsi</td>\r\n\t\t\t<td>".createinputtext( "data[provinsi]", $data[provinsi], " class=form-control m-input  size=50" )."{$wajibdiisi}</td>\r\n\t\t</tr>\r\n\r\n    \r\n    ";
    echo "	<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Gelombang Masuk</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "gelombang", $gelombang, " class=form-control m-input  size=2" )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">KELOMPOK KURIKULUM</label>\r\n    
				<div class=\"col-lg-6\">".createinputselect( "kelompokkurikulum", $arraykelompokkurikulum, "{$kelompokkurikulum}", "", " class=form-control m-input " )."</div>
			</div>
			<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">NIDN Dosen Wali</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "iddosen", $iddosen, " class=form-control m-input  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,'');\" ")."
					<div class=\"suggestionsBox\" id=\"suggestionsDosen\" style=\"display: none;\">
						<div class=\"suggestionList\" id=\"autoSuggestionsListDosen\"></div>
					</div>
				</div>			
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
				<label class=\"col-lg-2 col-form-label\">NIM Mahasiswa *</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "id", $id, " class=form-control m-input  maxlength=12 size=20" )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">NIRM</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "nirm", $nirm, " class=form-control m-input  size=20" )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
				<label class=\"col-lg-2 col-form-label\">Password *</label>\r\n    
				<div class=\"col-lg-6\">".createinputpassword( "data[password]", $data[password], " class=form-control m-input  size=20" )."
					<!--[<a target=_blank href='../passwordacak.php'>buat password acak</a>]-->
				</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Password Orang Tua/Wali*</label>\r\n    
				<div class=\"col-lg-6\">".createinputpassword( "data[password2]", $data[password2], " class=form-control m-input  size=20" )."
					<!--[<a target=_blank href='../passwordacak.php'>buat password acak</a>]-->
				</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
				<label class=\"col-lg-2 col-form-label\">Nama Mahasiswa *</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "data[nama]", $data[nama], " class=form-control m-input  size=50" )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Foto</label>\r\n    
				<div class=\"col-lg-6\"><input type=file name=foto class=form-control m-input></div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
				<label class=\"col-lg-2 col-form-label\">Alamat</label>\r\n    
				<div class=\"col-lg-6\">".createinputtextarea( "data[alamat]", $data[alamat], " class=form-control m-input  cols=50 rows=4" )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Kota</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "data[kota]", $data[kota], " class=form-control m-input  size=50" )."{$wajibdiisi}</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
				<label class=\"col-lg-2 col-form-label\">Provinsi</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "data[provinsi]", $data[provinsi], " class=form-control m-input  size=50" )."{$wajibdiisi}</div>
			</div>";
				$data[thn] = $arraydefaultmhs[tahun];
    echo "	<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Tempat/Tanggal Lahir</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "data[tempat]", $arraydefaultmhs[kota], " class=form-control m-input style=\"width:auto;display:inline-block;\"  size=10" )." / ".createinputtanggal( "data", $data, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
				<label class=\"col-lg-2 col-form-label\">Jenis Kelamin</label>\r\n    
				<div class=\"col-lg-6\">".createinputselect( "data[kelamin]", $arraykelamin, $data[kelamin], "", " class=form-control m-input " )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Agama</label>\r\n    
				<div class=\"col-lg-6\">".createinputselect( "data[agama]", $arrayagama, $data[agama], "", " class=form-control m-input " )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
				<label class=\"col-lg-2 col-form-label\">No Telepon</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "data[telepon]", $data[telepon], " class=form-control m-input  size=50" )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">No HP</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "data[hp]", $data[hp], " class=form-control m-input  size=50" )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
				<label class=\"col-lg-2 col-form-label\">E-mail</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "data[email]", $data[email], " class=form-control m-input  size=50" )."{$wajibdiisi}</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Asal Sekolah</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "data[asal]", $data[asal], " class=form-control m-input  size=50" )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
				<label class=\"col-lg-2 col-form-label\">Tahun Lulus</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "tahunlulus", $tahunlulus, " class=form-control m-input size=4" )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Pendidikan Terakkhir</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "data[pendidikan]", $data[pendidikan], " class=form-control m-input size=20" )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
				<label class=\"col-lg-2 col-form-label\">Nama Ayah</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "namaayah", $namaayah, " class=form-control m-input size=40" )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Alamat Ayah</label>\r\n    
				<div class=\"col-lg-6\">".createinputtextarea( "alamatayah", $alamatayah, " class=form-control m-input cols=40 rows=5" )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
				<label class=\"col-lg-2 col-form-label\">No. Kontak Ayah</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "noayah", $noayah, " class=form-control m-input size=20" )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Penghasilan Ayah per bulan</label>\r\n    
				<div class=\"col-lg-6\">".createinputselect( "penghasilanayah", $arraypenghasilan, $penghasilanayah, "", " class=form-control m-input " )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
				<label class=\"col-lg-2 col-form-label\">Nama Ibu</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "namaibu", $namaibu, " class=form-control m-input size=40" )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Alamat Ibu</label>\r\n    
				<div class=\"col-lg-6\">".createinputtextarea( "alamatibu", $alamatibu, " class=form-control m-input cols=40 rows=5" )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
				<label class=\"col-lg-2 col-form-label\">No. Kontak Ibu</label>\r\n    
				<div class=\"col-lg-6\">".createinputtext( "noibu", $noibu, " class=form-control m-input size=20" )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Penghasilan Ibu per bulan</label>\r\n    
				<div class=\"col-lg-6\">".createinputselect( "penghasilanibu", $arraypenghasilan, $penghasilanibu, "", " class=form-control m-input " )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
				<label class=\"col-lg-2 col-form-label\">Masa berlaku Kartu Mahasiswa</label>\r\n    
				<div class=\"col-lg-6\">".createinputtanggal( "tanggalkartu", $tanggalkartu, "class=form-control m-input style=\"width:auto;display:inline-block;\"" )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Kelas Default Pengambilan Mata Kuliah</label>";
					if ( $data[kelas] == "" )
					{
						$data[kelas] = $arraydefaultmhs[kelas];
					}
	echo "		<div class=\"col-lg-6\">".createinputselect( "data[kelas]", $arraylabelkelas, $data[kelas], "class=form-control m-input style=\"width:auto;display:inline-block;\"", "" )."  </div>
			</div>";
    if ( $STEIINDONESIA == 1 || $JENISKELAS == 1 )
    {
    echo "	<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
				<label class=\"col-lg-2 col-form-label\">Jenis Kelas Default</label>\r\n    
				<div class=\"col-lg-6\"><select name='jeniskelas' >\r\n      ";
        foreach ( $arraykelasstei as $k => $v )
        {
            $selected = "";
            if ( $k == $jeniskelas )
            {
                $selected = "selected";
            }
            echo "<option value='{$k}' {$selected}>{$v}</option>";
        }
        echo "\r\n      </select>\r\n      \r\n      </div>\r\n\t\t</div>\r\n    ";
    }
    echo "	<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Tanggal Masuk</label>\r\n    
				<div class=\"col-lg-6\">".createinputtanggal( "dtm", $dtm, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
				<label class=\"col-lg-2 col-form-label\">Tanggal Keluar/Lulus</label>\r\n    
				<div class=\"col-lg-6\">".createinputtanggalblank( "dtk", $dtk, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Status</label>\r\n    
				<div class=\"col-lg-6\">".createinputselect( "status", $arraystatusmahasiswa, $status, "", " class=form-control m-input " )."</div>
			</div> ";
    #if ( $UNIVERSITAS == "UNIKAL" )
    #{
    #    echo "\r\n    <tr class=judulform>\r\n\t\t\t<td>Sistem KRS</td>\r\n\t\t\t<td>".createinputselect( "sistemkrs", $arraysistemkrs, $sistemkrs, "", " class=form-control m-input " )."</td>\r\n\t\t</tr> \r\n";
    #}
    include( "mahasiswa2.php" );
    #echo "\r\n    <tr class=judulform>\r\n\t\t\t<td>Judul Tugas Akhir/Skripsi</td>\r\n\t\t\t<td>".createinputtextarea( "data[ta]", $data[ta], " class=form-control m-input  cols=50 rows=4" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>NIDN Dosen Pembimbing</td>\r\n\t\t\t<td>".createinputtextarea( "data[dosenta]", $data[dosenta], " class=form-control m-input  cols=50 rows=4" )."</td>\r\n\t\t</tr>\t\t\t\r\n    <tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tambah' class=\"btn btn-brand\">\r\n\t\t\t\t\t<input type=reset value='Reset' class=\"btn btn-secondary\">\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table></div></div></div></div></div></div></div>\r\n\t\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n \t\t";
echo "		<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Judul Tugas Akhir/Skripsi</label>\r\n    
				<div class=\"col-lg-6\">".createinputtextarea( "data[ta]", $data[ta], " class=form-control m-input  cols=50 rows=4" )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
				<label class=\"col-lg-2 col-form-label\">NIDN Dosen Pembimbing</label>\r\n    
				<div class=\"col-lg-6\">".createinputtextarea( "data[dosenta]", $data[dosenta], " class=form-control m-input  cols=50 rows=4" )."</div>
			</div>";
echo "					<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
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
    include( "prosestampilmahasiswa.php" );
}
if ( $aksi == "" )
{
	#print_r($arrayprodidep);
  
    #printmesg( $errmesg );
    //echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t\t".IKONCARI48."\r\n\t\t<table >\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td width=150>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";

   echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printtitle("Lihat Data Mahasiswa");
				echo "	</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->
							<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>
							<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>
								<div class=\"m-portlet__body\">		
									<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
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
        /*echo "						<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">NIDN Dosen Wali</label>\r\n    
										<div class=\"col-lg-6\">
											".createinputtext( "iddosen", $iddosen, " class=form-control m-input  size=20" )."
											<a href=\"javascript:daftardosen('form,wewenang,iddosen',document.form.id.value)\" >daftar dosen</a>
											</div>
									</div>";*/
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
    else if ( $jenisusers == 1 )
    {
        echo "						<input type=hidden name=iddosen value='{$users}'>";
    }
    echo "							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
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
									<div class=\"form-group m-form__group row\">
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
									<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">Nama</label>\r\n    
										<div class=\"col-lg-6\">".createinputtext( "nama", $nama, " class=form-control m-input  size=50" )."</div>
									</div>
									<div class=\"form-group m-form__group row\">
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
									<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">Status Awal</label>\r\n    
										<div class=\"col-lg-6\">
											<select class=form-control m-input name=statusawal>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												foreach ( $arraystatusmhsbaru as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
    echo "									</select>
										</div>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Periode Tahun Akademik</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=checkbox name=iftahunakademik value=1>";
											$waktu = getdate( );
											if ( $tahun2 == "" )
											{
												$tahun2 = $waktu[year];
											}
    echo "									<select name=tahun2 class=form-control m-input style=\"width:auto;display:inline-block;\">";
												$selected = "";
												$i = 1901;
												while ( $i <= $waktu[year] + 5 )
												{
													if ( $i == $tahun2 )
													{
														$selected = "selected";
													}
													echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
													$selected = "";
													++$i;
												}
    echo "									</select>/
											<select name=semester2 class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";
												unset( $arraysemester[3] );
												foreach ( $arraysemester as $k => $v )
												{
													if ( $k == $semester2 )
													{
														$selected = "selected";
													}
													echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
													$selected = "";
												}
    echo "									</select>(Khusus untuk Status Mahasiswa)
										</div>
									</div>";
    if ( $STEIINDONESIA == 1 || $UMJ == 1 || $JENISKELAS == 1 )
    {
        echo "						<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
										<label class=\"col-lg-2 col-form-label\">Jenis Kelas Default </label>\r\n    
										<div class=\"col-lg-6\">
											<select name='jeniskelas' class=form-control m-input style=\"width:auto;display:inline-block;\"><option value=''>Semua</option>\r\n      ";
												foreach ( $arraykelasstei as $k => $v )
												{
													$selected = "";
													if ( $k == $d[JENISKELAS] )
													{
														$selected = "selected";
													}
													echo "<option value='{$k}' {$selected}>{$v}</option>";
												}
        echo "								</select>
										</div>
									</div>";
    }
    #echo "\r\n\t\t</table>\r\n </div></div>  ";
    include( "cari2.php" );
	
    echo "	<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\"><b>Field Khusus Permohonan NIMAN</b> (Jurusan/Program Studi Harus dipilih)\r\n\t\t\t\t</label>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
				<label class=\"col-lg-2 col-form-label\">Semester Awal\r\n\t\t\t\t</label>
				<div class=\"col-lg-6\">
					<input type=text name=tahuna size=4 class=form-control m-input style=\"width:auto;display:inline-block;\">-<select class=form-control m-input style=\"width:auto;display:inline-block;\" name=semestera>\r\n\t\t\t\t\t\t<option value=''></option>";
						foreach ( $arraysemester as $k => $v )
						{
							echo "<option value='{$k}'>{$v}</option>";
						}
    echo "			</select>(Tahun-Semester)
				</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
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
<script>form.id.focus();\r\n\t\t\t</script>";
}
?>