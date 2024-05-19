<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksitambah == "Hapus" )
{
    if ( $_SESSION['token'] == $_POST['sessid'] )
    {
        unset( $_SESSION['token'] );
        cekhaktulis( $kodemenu );
        if ( is_array( $data ) )
        {
            $jmlaf = 0;
            foreach ( $data as $k => $v )
            {
                if ( $v[hapus] == 1 )
                {
                    $q = "SELECT FILE FROM tugaskuliahsp\r\n\t\t\t\t\tWHERE\r\n\t\t\t\t\tIDMAKUL='{$idmakulupdate}'\tAND\r\n\t\t\t\t\tTAHUN='{$tahunupdate}'\t\tAND\r\n\t\t\t\t\tSEMESTER='{$semesterupdate}'\t\tAND\r\n\t\t\t\t\tKELAS='{$kelasupdate}'\tAND\r\n\t\t\t\t\tIDBAHAN='{$k}'\r\n\t\t\t\t";
                    $hd = mysqli_query($koneksi,$q);
                    $dh = sqlfetcharray( $hd );
                    $q = "\r\n\t\t\t\t\tDELETE FROM tugaskuliahsp \r\n\t\t\t\t\tWHERE\r\n\t\t\t\t\tIDMAKUL='{$idmakulupdate}'\tAND\r\n\t\t\t\t\tTAHUN='{$tahunupdate}'\tAND\r\n\t\t\t\t\tSEMESTER='{$semesterupdate}'\tAND\r\n\t\t\t\t\tKELAS='{$kelasupdate}'\tAND\r\n\t\t\t\t\tIDBAHAN='{$k}'\r\n\t\t\t\t\t\r\n\t\t\t\t";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        @unlink( @"{$FOLDERFILE}/".@md5( @$dh[FILE] ) );
                        ++$jmlaf;
                        $q = "\r\n  \t\t\t\t\tDELETE FROM hasiltugaskuliahsp \r\n  \t\t\t\t\tWHERE\r\n  \t\t\t\t\tIDMAKUL='{$idmakulupdate}'\tAND\r\n  \t\t\t\t\tTAHUN='{$tahunupdate}'\tAND\r\n  \t\t\t\t\tSEMESTER='{$semesterupdate}'\tAND\r\n  \t\t\t\t\tKELAS='{$kelasupdate}'\tAND\r\n  \t\t\t\t\tIDBAHAN='{$k}'\r\n  \t\t\t\t\t\r\n  \t\t\t\t";
                        mysqli_query($koneksi,$q);
                    }
                }
            }
            if ( 0 < $jmlaf )
            {
                $errmesg = "Data Tugas Kuliah nilai berhasil dihapus";
            }
            else
            {
                $errmesg = "Data Tugas Kuliah nilai tidak dihapus";
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Tugas Kuliah", HAPUS_DATA );
    }
}
if ( $aksi == "tambah" && $REQUEST_METHOD == POST )
{
    if ( $_SESSION['token'] == $_POST['sessid'] )
    {
        unset( $_SESSION['token'] );
        cekhaktulis( $kodemenu );
        if ( trim( $nama ) == "" )
        {
            $errmesg = "Nama tugas kuliah harus diisi";
        }
        else
        {
            if ( trim( $ket ) == "" )
            {
                $errmesg = "Keterangan tugas kuliah nilai harus diisi ";
            }
            else
            {
                $nama = htmlspecialchars( $nama );
                $idbaru = getnewidsyarat( "IDBAHAN", "tugaskuliahsp", "\r\n\t\t\tWHERE IDMAKUL='{$idmakulupdate}' AND\r\n\t\t\tTAHUN='{$tahunupdate}' AND\r\n\t\t\tSEMESTER='{$semesterupdate}' AND\r\n\t\t\tKELAS='{$kelasupdate}'\r\n\t\t\t" );
                if ( $filebahan != "" )
                {
                    $namafilebaru = $filebahan_name;
                    if ( file_exists( "{$FOLDERFILE}/".md5( $filebahan_name )."" ) )
                    {
                        $namafilebaru = "{$idmakulupdate}{$tahunupdate}{$semesterupdate}{$kelasupdate}{$idbaru}".$filebahan_name;
                    }
                }
                $ket = html_entity_decode( $ket );
                $ket = preg_replace( "/<script[^>]*>.*?< *script[^>]*>/i", "", $ket );
                $q = "\r\n\t\t\tINSERT INTO tugaskuliahsp (IDBAHAN,IDMAKUL,TAHUN,KELAS,NAMA,KET,SEMESTER,FILE,TANGGAL,\r\n      MULAI,SELESAI,JENIS,UKURAN,KIRIMULANG,FLAGFILE,IDDOSEN) \r\n\t\t\tVALUES ('{$idbaru}','{$idmakulupdate}','{$tahunupdate}',\r\n\t\t\t'{$kelasupdate}','{$nama}','{$ket}','{$semesterupdate}','{$namafilebaru}',NOW(),\r\n      '{$mulai['thn']}-{$mulai['bln']}-{$mulai['tgl']} {$mulai['jam']}:{$mulai['mnt']}:00',\r\n      '{$selesai['thn']}-{$selesai['bln']}-{$selesai['tgl']} {$selesai['jam']}:{$selesai['mnt']}:00',\r\n      '{$jenistugas}','{$ukuran}','{$kirimulang}',1,'{$users}')\r\n\t\t";
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $ketlog = "Tambah Data Tugas Kuliah dengan \r\n\t\t\t\t\tID Makul={$idmakulupdate}, \r\n\t\t\t\t\tTahun Ajaran=".( $tahunupdate - 1 )."/{$tahunupdate},\r\n\t\t\t\t\tSemester=".$arraysemester[$semesterupdate].",\r\n\t\t\t\t\tKelas={$kelasupdate},\r\n\t\t\t\t\tID Tugas={$idbaru} ({$nama})\r\n\t\t\t\t\t";
                    buatlog( 39 );
                    $errmesg = "Tugas Kuliah berhasil ditambah";
                    if ( $filebahan != "" )
                    {
                        @move_uploaded_file( @$filebahan, @"{$FOLDERFILE}/".@md5( @$namafilebaru ) );
                    }
                    $ket = "";
                    $nama = "";
                }
                else
                {
                    $errmesg = "Tugas Kuliah  tidak berhasil ditambah";
                }
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Tugas Kuliah", TAMBAH_DATA );
    }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    cekhaktulis( $kodemenu );
    /*printjudulmenu( "Upload Tugas Kuliah" );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "idprodiupdate", "{$idprodiupdate}", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" )."<tr class=judulform>\r\n\t\t\t<td width=150>Mata Kuliah</td>\r\n\t\t\t<td>{$idmakulupdate} /   ".@getnamamk( @$idmakulupdate, @( @$tahunupdate - 1 ).@$semesterupdate, @$idprodiupdate )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Tahun Ajaran</td>\r\n\t\t\t<td>".( $tahunupdate - 1 )."/{$tahunupdate}\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n\t\t<tr>\r\n\t\t\t<td class=judulform>Semester</td>\r\n\t\t\t<td >  ".$arraysemester[$semesterupdate]."  </td>\r\n\t\t</tr>\r\n  \t\t<tr class=judulform>\r\n\t\t\t<td class=judulform>Dosen Pengajar </td>\r\n\t\t\t<td>{$iddosenupdate}, ".getnamafromtabel( $iddosenupdate, "dosen" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Kode Kelas</td>\r\n\t\t\t<td>".$arraylabelkelas[$kelasupdate]."</td>\r\n\t\t</tr>"."\r\n\t\t</table>\r\n\t\t<br>\r\n\t\t";
    printjudulmenukecil( "Tugas Kuliah Baru" );*/
    echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
                        echo "			<div class='portlet-title'>";
												printmesg("Upload Tugas Kuliah Semester Pendek");
								echo "	</div>";
	echo "  	<div class=\"m-portlet\">				
					<!--begin::Form-->";
	#echo "\r\n\t\t<table class=form>\r\n \t\t <tr valign=top class=judulform>\r\n\t\t\t<td class=judulform><b>Nama Tugas</td>\r\n\t\t\t<td>".createinputtext( "nama", "{$nama}", "size=50 class=masukan" )."</td>\r\n\t\t</tr> \r\n    <tr valign=top  class=judulform>\r\n\t\t\t<td><b>Keterangan</td>\r\n\t\t\t<td>";
    echo "				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>"
						.createinputhidden( "pilihan", $pilihan, "" )
						.createinputhidden( "aksi", "tambah", "" )
						.createinputhidden( "idprodiupdate", "{$idprodiupdate}", "" )
						.createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" )
						.createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" )
						.createinputhidden( "tahunupdate", "{$tahunupdate}", "" )
						.createinputhidden( "semesterupdate", "{$semesterupdate}", "" )
						.createinputhidden( "kelasupdate", "{$kelasupdate}", "" )
						.createinputhidden( "sessid", $_SESSION['token'], "" )."
							<div class=\"m-portlet__body\">		
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Mata Kuliah</label>\r\n    
							<div class=\"col-lg-6\">
								{$idmakulupdate} /   ".@getnamamk( @$idmakulupdate, @( @$tahunupdate - 1 ).@$semesterupdate, @$idprodiupdate )."
							</div>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Tahun Ajaran</label>\r\n    
							<div class=\"col-lg-6\">
								".( $tahunupdate - 1 )."/{$tahunupdate}
							</div>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Semester</label>\r\n    
							<div class=\"col-lg-6\">
								".$arraysemester[$semesterupdate]."
							</div>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Dosen Pengajar</label>\r\n    
							<div class=\"col-lg-6\">
								{$iddosenupdate}, ".getnamafromtabel( $iddosenupdate, "dosen" )."
							</div>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Kode Kelas</label>\r\n    
							<div class=\"col-lg-6\">
								".$arraylabelkelas[$kelasupdate]."
							</div>
						</div>";
	echo "				<div class='portlet-title'>";
								printmesg("Tugas Kuliah Semester Pendek Baru");
	echo "				</div>
    
	<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Nama Tugas</label>\r\n    
							<div class=\"col-lg-6\">
								".createinputtext( "nama", "{$nama}", "size=50 class=form-control m-input" )."
							</div>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Keterangan</label>\r\n  
							<div class=\"col-lg-6\">".
								createinputtextarea( "ket", "{$ket}", "cols=60  rows=20 class=form-control m-input" );
    echo "					</div>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">File Tugas</label>\r\n    
							<div class=\"col-lg-6\">
								<input type=file name=filebahan class=form-control m-input>
							</div>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Tersedia Mulai (Tanggal - Jam)</label>\r\n    
							<div class=\"col-lg-6\">
								".createinputtanggal( "mulai", "{$mulai}", " class=form-control m-input style=\"width:auto;display:inline-block;\"" )." -  \r\n      ".createinputjam( "mulai", "{$mulai}", "", "class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
							</div>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Tanggal Penyelesaian (Tanggal - Jam)</label>\r\n    
							<div class=\"col-lg-6\">
								".createinputtanggal( "selesai", "{$selesai}", "class=form-control m-input style=\"width:auto;display:inline-block;\"" )." -  \r\n      ".createinputjam( "selesai", "{$selesai}", "", "class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
							</div>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Jenis Tugas</label>\r\n    
							<div class=\"col-lg-6\">
								".createinputselect( "jenistugas", $arrayjenistugas, $jenistugas, "class=form-control m-input", "" )."
							</div>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Ukuran File Maksimum</label>\r\n    
							<div class=\"col-lg-6\">";
								if ( $ukuran == 0 )
								{
									$ukuran = 1;
								}
    echo "						".createinputtext( "ukuran", $ukuran, " size=2 class=form-control m-input style=\"width:auto;display:inline-block;\"" )." MB
							</div>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Bolehkah pengiriman ulang?</label>\r\n    
							<div class=\"col-lg-6\">";
    echo "						".createinputselect( "kirimulang", $arrayya, $kirimulang, "class=form-control m-input", "" )."
							</div>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
							<div class=\"col-lg-6\">
								<input type=submit value='Tambah' class=\"btn btn-brand\">
								<input type=reset value='Reset' class=\"btn btn-secondary\">
							</div>
						</div>
					</div>
				</form>
				<script>\r\n\t\t\tform.nama.focus();\r\n\t\t</script>\r\n \t\t";
    echo "				<div class='portlet-title'>";
							printmesg("Rincian Tugas Kuliah Semester Pendek");
	echo "				</div>";
    $q = "\r\n\t\t\tSELECT tugaskuliahsp.* FROM tugaskuliahsp\r\n\t\t\tWHERE IDMAKUL='{$idmakulupdate}'\r\n\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\tAND SEMESTER='{$semesterupdate}'\r\n\t\t\tAND KELAS='{$kelasupdate}'\r\n\t\t\tORDER BY NAMA\r\n\t\t";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        echo "			<form name=form action=index.php method=post>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "formtambah", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" )."";
		echo "					<div class=\"m-section__content\">		
									<div class=\"table-responsive\">		
										<table class=\"table table-bordered table-hover\">
											<thead>
												<tr class=juduldata align=center>\r\n\t\t\t\t\t<td colspan=10></td>\r\n \t\t\t\t\t<td ><input type=submit name=aksitambah value='Hapus' class=\"btn btn-brand\" onClick=\"return confirm('Hapus Data Tugas Kuliah?')\"\r\n\t\t\t\t\t></td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr class=juduldata align=center>\r\n\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t<td>Nama Tugas</td>\r\n\t\t\t\t\t<td>Keterangan</td>\r\n\t\t\t\t\t<td>Mulai</td>\r\n\t\t\t\t\t<td>Selesai</td>\r\n\t\t\t\t\t<td>Jenis<br>Tugas</td>\r\n\t\t\t\t\t<td>Ukuran<br>Max<br>(MB)</td>\r\n\t\t\t\t\t<td>Boleh<br>Kirim<br>Ulang</td>\r\n\t\t\t\t\t<td>Tanggal<br>Update</td>\r\n\t\t\t\t\t<td >File</td>\r\n\t\t\t\t\t<td >Pilih Hapus</td>\r\n\t\t\t\t</tr>\r\n\t\t\t";
        echo "								</thead>
											<tbody>";
		$i = 1;
        $totalbobot = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            echo "\r\n\t\t\t\t\t<tr {$kelas} valign=top align=center>\r\n\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t<td align=left >{$d['NAMA']}</td>\r\n\t\t\t\t\t\t<td align=left >{$d['KET']}</td>\r\n  \t\t\t\t\t<td>{$d['MULAI']}</td>\r\n  \t\t\t\t\t<td>{$d['SELESAI']}</td>\r\n  \t\t\t\t\t<td>".$arrayjenistugas[$d[JENIS]]."</td>\r\n  \t\t\t\t\t<td align=center>{$d['UKURAN']}</td>\r\n  \t\t\t\t\t<td align=center>".$arrayya[$d[KIRIMULANG]]."</td>\r\n\t\t\t\t\t\t<td align=center >{$d['TANGGAL']}</td>\r\n\t\t\t\t\t\t<td align=center >";
            if ( $d[FLAGFILE] == 0 )
            {
                echo "\r\n            <a target=_blank href='file/{$d['FILE']}'>{$d['FILE']}</a>";
            }
            else if ( $d[FLAGFILE] == 1 )
            {
                echo "\r\n            <a target=_blank href='dl.php?idmakulupdate={$idmakulupdate}&iddosenupdate={$iddosenupdate}&tahunupdate={$tahunupdate}&semesterupdate={$semesterupdate}&kelasupdate={$kelasupdate}&idbahan={$d['IDBAHAN']}\r\n' >".IKONUNDUH48."</a>";
            }
            echo "\r\n            </td>";
            if ( $d[IDDOSEN] == $users || $d[IDDOSEN] == "" )
            {
                echo "\r\n     \t\t\t<td align=center>".createinputcek( "data[{$d['IDBAHAN']}][hapus]", "1", "", "", " class=masukan size=4" )."</td>";
            }
            else
            {
                echo "\r\n     \t\t\t<td align=center>-</td>";
            }
            echo "\r\n \t\t\t\t\t\t \r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
            ++$i;
        }
        #echo "</table>\r\n\t\t\t ";
		echo "							</tbody>
									</table>
								</div>
							</div>
						";
    }
    else
    {
        $errmesg = "Tugas Kuliah Semester Pendek belum ada";
        printmesg( $errmesg );
    }
}
if ( $aksi == "tampilkanawal" )
{
    cekhaktulis( $kodemenu );
    $aksi = " ";
    include( "prosestampilbahanawal.php" );
}
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "prosestampilbahan.php" );
}
if ( $aksi == "tambahawal" )
{
    cekhaktulis( $kodemenu );
    /*printjudulmenu( "Buat Tugas Mata Kuliah " );
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkanawal'>\r\n\t\t\t<table class=form>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td class=judulform>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
    if ( $jenisusers == 0 )
    {
        echo "\r\n  \t\t<tr >\r\n\t\t\t<td class=judulform>NIP Dosen</td>\r\n\t\t\t<td>".createinputtext( "iddosen", $iddosen, " class=masukan  size=20" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftardosen('form,wewenang,iddosen',\r\n\t\t\tdocument.form.iddosen.value)\" >\r\n\t\t\tdaftar dosen\r\n\t\t\t</a>\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>";
    }
    echo "<tr class=judulform>\r\n\t\t\t<td>Kode Mata Kuliah</td>\r\n\t\t\t<td>".createinputtext( "idmakul", $idmakul, " class=masukan  size=10" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmakul('form,wewenang,idmakul',\r\n\t\t\tdocument.form.idmakul.value)\" >\r\n\t\t\tdaftar mata kuliah\r\n\t\t\t</a>\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n   \t\t<tr  >\r\n\t\t\t<td>Tahun Akademik/Semester</td>\r\n\t\t\t<td>\r\n \r\n\t\t\t\t\t\t<select name=tahunsemester class=masukan> \r\n            <option value='' {$cek}>Semua</option>";
    if ( is_array( $arraytahunsem ) )
    {
        foreach ( $arraytahunsem as $k => $v )
        {
            echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
        }
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t</td>\r\n\t\t</tr>    ";
    $arraylabelkelas[''] = "Semua";
    echo "\r\n\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Kelas</td>\r\n\t\t\t<td>\r\n  ".createinputselect( "kelas", $arraylabelkelas, $kelas, "", "" )."      \r\n      \r\n </td>\r\n\t\t</tr> \r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Lanjut' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n \t";
	*/
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
                        echo "			<div class='portlet-title'>";
												printmesg("Buat Tugas Kuliah Semester Pendek");
								echo "	</div>";
	echo "  	<div class=\"m-portlet\">				
					<!--begin::Form-->";
	echo "			<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
						<input type=hidden name=pilihan value='{$pilihan}'>
						<input type=hidden name=aksi value='tampilkanawal'>
						<div class=\"m-portlet__body\">
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
								<label class=\"col-form-label\">
									<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
										foreach ( $arrayprodidep as $k => $v )
										{
											echo "<option value='{$k}'>{$v}</option>";
										}
    echo "							</select>
								</label>
							</div>";
    if ( $jenisusers == 0 )
    {
        echo "				<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">NIP Dosen</label>\r\n    
								<div class=\"col-lg-6\">
									".createinputtext( "iddosen", $iddosen, " class=form-control m-input  size=20 id='inputStringListDosenNidn' onkeyup=\"lookupListDosenNidn(this.value);\" placeholder=\"Ketik NIDN / Nama Dosen...\" " )."
									<a href=\"javascript:daftardosen('form,wewenang,iddosen',document.form.iddosen.value)\" >daftar dosen</a>
									<div class=\"suggestionsBox\" id=\"suggestionsListDosenNidn\" style=\"display: none;\">
										<div class=\"suggestionsListDosenNidn\" id=\"autoSuggestionsListDosenNidn\"></div>
									</div>								
								</div>
							</div>";
    }
	echo "					<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Tahun Akademik/Semester</label>\r\n    
								<div class=\"col-lg-6\">
									<select name=tahunsemester class=form-control m-input>
										<option value='' {$cek}>Semua</option>";
											if ( is_array( $arraytahunsem ) )
											{
												foreach ( $arraytahunsem as $k => $v )
												{
													echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
												}
											}
    echo "							</select>
								</div>
							</div>";
    echo "					<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Kode Mata Kuliah</label>\r\n    
								<div class=\"col-lg-6\">
									".createinputtext( "idmakul", $idmakul, " class=form-control m-input  size=10 id='inputStringMakul' onkeyup=\"lookupMakul(this.value,form.idprodi.value );\" placeholder=\"Ketik Kode / Nama Makul...\"" )."
									<!--<a href=\"javascript:daftarmakul('form,wewenang,idmakul',document.form.idmakul.value)\" >daftar mata kuliah</a>-->
									<div class=\"suggestionsBoxMakul\" id=\"suggestionsMakul\" style=\"display: none;\">
										<div class=\"suggestionListMakul\" id=\"autoSuggestionsListMakul\"></div>
									</div>
								</div>
							</div>";
							
    $arraylabelkelas[''] = "Semua";
    echo "   				<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Kelas</label>\r\n    
								<div class=\"col-lg-6\">
									".createinputselect( "kelas", $arraylabelkelas, $kelas, "", "" )." 
								</div>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
									<input type=submit value='Lanjut' class=\"btn btn-brand\">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	</div>";
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
												printmesg("Lihat Tugas Kuliah Semester Pendek");
								echo "	</div>";
						echo "
					<div class=\"m-portlet\">						
						<!--begin::Form-->
						<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
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
    echo "							</select>
								</div>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Tahun Akademik/Semester</label>\r\n    
								<div class=\"col-lg-6\">
									<select name=tahunsemester class=form-control m-input>
										<option value='' {$cek}>Semua</option>";
											if ( is_array( $arraytahunsem ) )
											{
												foreach ( $arraytahunsem as $k => $v )
												{
													echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
												}
											}
    echo "							</select>
								</div>
							</div>";
	echo "					<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Kode Mata Kuliah</label>\r\n    
								<div class=\"col-lg-6\">
									".createinputtext( "idmakul", $idmakul, " class=form-control m-input  size=10 id='inputStringMakul' onkeyup=\"lookupMakul(this.value,form.idprodi.value );\" placeholder=\"Ketik Kode / Nama Makul...\"" )."
									<!--<a href=\"javascript:daftarmakul('form,wewenang,idmakul',document.form.idmakul.value)\" >daftar mata kuliah</a>-->
									<div class=\"suggestionsBoxMakul\" id=\"suggestionsMakul\" style=\"display: none;\">
										<div class=\"suggestionListMakul\" id=\"autoSuggestionsListMakul\"></div>
									</div>
								</div>
							</div>";							
    $arraylabelkelas[''] = "Semua";
    echo "					<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Kelas</label>\r\n    
								<div class=\"col-lg-6\">
									".createinputselect( "kelas", $arraylabelkelas, $kelas, "", "" )."
								</div>
							</div>
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
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
	<script>\r\n\t\t\tform.idmakul.focus();\r\n\t\t</script>\r\n\t";
}
?>
