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
                    $q = "SELECT FILE FROM bahankuliahsp\r\n\t\t\t\t\tWHERE\r\n\t\t\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tTAHUN='{$tahunupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tSEMESTER='{$semesterupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tKELAS='{$kelasupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tIDBAHAN='{$k}'\r\n\t\t\t\t";
                    $hd = mysqli_query($koneksi,$q);
                    $dh = sqlfetcharray( $hd );
                    $q = "\r\n\t\t\t\t\tDELETE FROM bahankuliahsp \r\n\t\t\t\t\tWHERE\r\n\t\t\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tTAHUN='{$tahunupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tSEMESTER='{$semesterupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tKELAS='{$kelasupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tIDBAHAN='{$k}'\r\n\t\t\t\t\tAND (IDDOSEN='{$users}' OR IDDOSEN='')\r\n\t\t\t\t";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $ketlog = "Hapus Data Bahan Kuliah dengan \r\n\t\t\t\t\tID Makul={$idmakulupdate}, \r\n\t\t\t\t\tTahun Ajaran=".( $tahunupdate - 1 )."/{$tahunupdate},\r\n\t\t\t\t\tSemester=".$arraysemester[$semesterupdate].",\r\n\t\t\t\t\tKelas={$kelasupdate},\r\n\t\t\t\t\tID Bahan={$k}\r\n\t\t\t\t\t";
                        buatlog( 41 );
                        @unlink( @"{$FOLDERFILE}/".@md5( @$dh[FILE] ) );
                        ++$jmlaf;
                    }
                }
            }
            if ( 0 < $jmlaf )
            {
                $errmesg = "Data Bahan Kuliah nilai berhasil dihapus";
            }
            else
            {
                $errmesg = "Data Bahan Kuliah nilai tidak dihapus";
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Bahan Kuliah", HAPUS_DATA );
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
            $errmesg = "Nama Bahan kuliah harus diisi";
        }
        else
        {
            if ( trim( $ket ) == "" )
            {
                $errmesg = "Deskripsi Bahan kuliah nilai harus diisi ";
            }
            else
            {
                if ( $filebahan == "none" )
                {
                    $errmesg = "File Bahan kuliah nilai harus diisi ";
                }
                else
                {
                    $idbaru = getnewidsyarat( "IDBAHAN", "bahankuliahsp", "\r\n\t\t\tWHERE IDMAKUL='{$idmakulupdate}' AND\r\n\t\t\tTAHUN='{$tahunupdate}' AND\r\n\t\t\tSEMESTER='{$semesterupdate}' AND\r\n\t\t\tKELAS='{$kelasupdate}'\r\n\t\t\t" );
                    $namafilebaru = $filebahan_name;
                    if ( file_exists( "{$FOLDERFILE}/".md5( $filebahan_name )."" ) )
                    {
                        $namafilebaru = "{$idmakulupdate}{$tahunupdate}{$semesterupdate}{$kelasupdate}{$idbaru}".$filebahan_name;
                    }
                    $ket = html_entity_decode( $ket );
                    $ket = preg_replace( "/<script[^>]*>.*?< *script[^>]*>/i", "", $ket );
                    $q = "\r\n\t\t\tINSERT INTO bahankuliahsp (IDBAHAN,IDMAKUL,TAHUN,KELAS,NAMA,KET,SEMESTER,FILE,TANGGAL,FLAGFILE,IDDOSEN) \r\n\t\t\tVALUES ('{$idbaru}','{$idmakulupdate}','{$tahunupdate}',\r\n\t\t\t'{$kelasupdate}','{$nama}','{$ket}','{$semesterupdate}','{$namafilebaru}',NOW(),1,'{$users}')\r\n\t\t";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $ketlog = "Tambah Data Bahan Kuliah dengan \r\n\t\t\t\t\tID Makul={$idmakulupdate}, \r\n\t\t\t\t\tTahun Ajaran=".( $tahunupdate - 1 )."/{$tahunupdate},\r\n\t\t\t\t\tSemester=".$arraysemester[$semesterupdate].",\r\n\t\t\t\t\tKelas={$kelasupdate},\r\n\t\t\t\t\tID Bahan={$idbaru} ({$nama})\r\n\t\t\t\t\t";
                        buatlog( 39 );
                        $errmesg = "File Bahan Kuliah berhasil ditambah";
                        @move_uploaded_file( @$filebahan, @"{$FOLDERFILE}/".@md5( @$namafilebaru ) );
                        $ket = "";
                        $nama = "";
                    }
                    else
                    {
                        $errmesg = "File Bahan Kuliah  tidak berhasil ditambah";
                    }
                }
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "Bahan Kuliah", TAMBAH_DATA );
    }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    cekhaktulis( $kodemenu );
    #printjudulmenu( "Upload File Bahan Kuliah" );
    #printmesg( $errmesg );
    #echo "\r\n\t\t<form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "idprodiupdate", "{$idprodiupdate}", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" )."<tr class=judulform>\r\n\t\t\t<td width=150>Mata Kuliah</td>\r\n\t\t\t<td>{$idmakulupdate} /   ".@getnamamk( @$idmakulupdate, @( @$tahunupdate - 1 ).@$semesterupdate, @$idprodiupdate )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Tahun Ajaran</td>\r\n\t\t\t<td>".( $tahunupdate - 1 )."/{$tahunupdate}\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n\t\t<tr>\r\n\t\t\t<td class=judulform>Semester</td>\r\n\t\t\t<td >  ".$arraysemester[$semesterupdate]."  </td>\r\n\t\t</tr>\r\n  \t\t<tr class=judulform>\r\n\t\t\t<td class=judulform>Dosen Pengajar </td>\r\n\t\t\t<td>{$iddosenupdate}, ".getnamafromtabel( $iddosenupdate, "dosen" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Kode Kelas</td>\r\n\t\t\t<td>".$arraylabelbahan[$kelasupdate]."</td>\r\n\t\t</tr>"."\r\n\t\t</table>\r\n\t\t\r\n\t\t";
    #printjudulmenukecil( "File Bahan Kuliah Baru" );
    #echo "\r\n\t\t<table class=form>\r\n \t\t <tr class=judulform>\r\n\t\t\t<td class=judulform>Nama Bahan</td>\r\n\t\t\t<td>".createinputtext( "nama", "{$nama}", "size=40 class=masukan" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Deskripsi Singkat</td>\r\n\t\t\t<td>";
    echo "  <div class=\"container-fluid\">
				<div class=\"row\">
					<div class=\"col-md-12\">
						<!-- BEGIN SAMPLE FORM PORTLET-->
						";
							printmesg( $errmesg );
							echo "			<div class='portlet-title'>";
													printmesg("Upload File Bahan Kuliah Semester Pendek");
									echo "	</div>";
	echo " 		 	<div class=\"m-portlet\">				
						<!--begin::Form-->";
	echo "					<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>"
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
    
												printmesg("File Bahan Kuliah Baru");
	echo "				</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Nama Bahan</label>\r\n  
							<div class=\"col-lg-6\">
								".createinputtext( "nama", "{$nama}", "size=40 class=form-control m-input" )."
							</div>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Deskripsi</label>\r\n  
							<div class=\"col-lg-6\">".
								createinputtextarea( "ket", "{$ket}", "cols=80  rows=20 class=form-control m-input" )."
							</div>
						</div>";
    
	#print createinputtextarea( "ket", "{$ket}", "cols=80  rows=20 class=form-control m-input" );
    echo "				<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">File Bahan</label>\r\n  
							<div class=\"col-lg-6\">
								<input type=file name=filebahan class=form-control m-input>
							</div>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
							<div class=\"col-lg-6\">
								<input type=submit value='Tambah' class=\"btn btn-brand\">
								<input type=reset value='Reset' class=\"btn btn-secondary\">
							</div>
						</div>
					</div>
				</form>
				<script>\r\n\t\t\tform.nama.focus();\r\n\t\t</script>\r\n \t\t";
    #printjudulmenukecil( "Rincian Bahan Kuliah" );
	echo "				<div class='portlet-title'>";
							printmesg("Rincian Bahan Kuliah Semester Pendek");
	echo "				</div>";
    $q = "\r\n\t\t\tSELECT IDBAHAN,NAMA,KET,FILE,TANGGAL,FLAGFILE,IDDOSEN FROM bahankuliahsp\r\n\t\t\tWHERE IDMAKUL='{$idmakulupdate}'\r\n\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\tAND SEMESTER='{$semesterupdate}'\r\n\t\t\tAND KELAS='{$kelasupdate}' \r\n\t\t\tORDER BY NAMA\r\n\t\t";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        #echo "\r\n\t\t<form name=form action=index.php method=post>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "formtambah", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" )."<table class=form>\r\n\t\t\t\t<tr class=juduldata align=center>\r\n\t\t\t\t\t<td colspan=6></td>\r\n \t\t\t\t\t<td ><input type=submit name=aksitambah value='Hapus' class=masukan\r\n\t\t\t\t\tonClick=\"return confirm('Hapus Data Bahan Kuliah?')\"\r\n\t\t\t\t\t></td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr class=juduldata align=center>\r\n\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t<td>Nama Bahan</td>\r\n\t\t\t\t\t<td>Keterangan</td>\r\n\t\t\t\t\t<td>Tanggal<br>Upload</td>\r\n\t\t\t\t\t<td >Dosen Pengupload</td>\r\n\t\t\t\t\t<td >File</td>\r\n\t\t\t\t\t<td >Pilih Hapus</td>\r\n\t\t\t\t</tr>\r\n\t\t\t";
        echo "\r\n\t\t		<form name=form action=index.php method=post>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "formtambah", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" )."";
		echo "					<div class=\"m-section__content\">		
									<div class=\"table-responsive\">		
										<table class=\"table table-bordered table-hover\">
											<thead>
												<tr class=juduldata align=center>\r\n\t\t\t\t\t<td colspan=6></td>\r\n \t\t\t\t\t<td ><input type=submit name=aksitambah value='Hapus' class=\"btn btn-brand\" onClick=\"return confirm('Hapus Data Bahan Kuliah?')\"\r\n\t\t\t\t\t></td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr class=juduldata align=center>\r\n\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t<td>Nama Bahan</td>\r\n\t\t\t\t\t<td>Keterangan</td>\r\n\t\t\t\t\t<td>Tanggal<br>Upload</td>\r\n\t\t\t\t\t<td >Dosen Pengupload</td>\r\n\t\t\t\t\t<td >File</td>\r\n\t\t\t\t\t<td >Pilih Hapus</td>\r\n\t\t\t\t</tr>\r\n\t\t\t";
		echo "								</thead>
											<tbody>";
		$i = 1;
        $totalbobot = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            echo "\r\n\t\t\t\t\t<tr {$kelas} valign=top align=center>\r\n\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t<td align=left >{$d['NAMA']}</td>\r\n\t\t\t\t\t\t<td align=left >".htmlspecialchars_decode( $d[KET] )."</td>\r\n\t\t\t\t\t\t<td align=center >{$d['TANGGAL']}</td>\r\n            <td>\r\n              {$d['IDDOSEN']} / ".getfieldfromtabel( "{$d['IDDOSEN']}", "NAMA", "dosen" )."            \r\n            \r\n            </td>\r\n\t\t\t\t\t\t<td align=center >";
            if ( $d[FLAGFILE] == 0 )
            {
                echo "\r\n            <a target=_blank href='file/{$d['FILE']}'>{$d['FILE']}</a>";
            }
            else if ( $d[FLAGFILE] == 1 )
            {
                echo "\r\n            <a target=_blank href='dl.php?idmakulupdate={$idmakulupdate}&iddosenupdate={$iddosenupdate}&tahunupdate={$tahunupdate}&semesterupdate={$semesterupdate}&kelasupdate={$kelasupdate}&idbahan={$d['IDBAHAN']}' >".IKONUNDUH48."</a>";
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
            echo "\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
            ++$i;
        }
        #echo "</table>\r\n\t\t\t<br><br>";
		echo "							</tbody>
									</table>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		</div>";
    }
    else
    {
        $errmesg = "File Bahan Kuliah belum ada";
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
    #printjudulmenu( "Upload Bahan Mata Kuliah " );
    #printmesg( $errmesg );
    echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
                        echo "			<div class='portlet-title'>";
												printmesg("Upload Bahan Mata Kuliah Semester Pendek");
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
    #printjudulmenu( "Lihat File Bahan Kuliah Mata Kuliah " );
    #printmesg( $errmesg );
    #echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n\t\t\t<table class=form>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
                        echo "			<div class='portlet-title'>";
												printmesg("Lihat File Bahan Kuliah Semester Pendek");
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
