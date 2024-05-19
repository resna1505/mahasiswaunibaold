<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksitambah == "Hapus" )
{
    if ( $jenisusers == 1 && $users != $iddosenupdate )
    {
        exit( );
    }
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Konversi Nilai", HAPUS_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $jmlaf = 0;
        foreach ( $data as $k => $v )
        {
            if ( $v[hapus] == 1 )
            {
                $q = "\r\n\t\t\t\t\t\tDELETE FROM konversisp \r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\t\t\t\tAND\r\n\t\t\t\t\t\tTAHUN='{$tahunupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tSEMESTER='{$semesterupdate}'\r\n\t\t\t\t\t\tAND\r\n\t\t\t\t\t\tKELAS='{$kelasupdate}'\r\n\t\t\t\t\t\tAND\r\n\t\t\t\t\t\tIDKONVERSI='{$k}'\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t";
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $ketlog = "Hapus Konversi Nilai dengan ID Makul={$idmakulupdate}, \r\n\t\t\t\t\t\tTahun Akademik=".( $tahunupdate - 1 )."/{$tahunupdate},\r\n\t\t\t\t\t\tSemester=".$arraysemester[$semesterupdate].",\r\n\t\t\t\t\t\tKelas={$kelasupdate},\r\n\t\t\t\t\t\tID Konversi={$k} \r\n\t\t\t\t\t\t";
                    buatlog( 32 );
                    ++$jmlaf;
                }
            }
        }
        if ( 0 < $jmlaf )
        {
            $errmesg = "Data konversi nilai berhasil dihapus";
        }
        else
        {
            $errmesg = "Data konversi nilai tidak dihapus";
        }
    }
}
if ( $aksitambah == "Update" && $REQUEST_METHOD == POST )
{
    if ( $jenisusers == 1 && $users != $iddosenupdate )
    {
        exit( );
    }
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Konversi Nilai", HAPUS_DATA );
        unset( $_SESSION['token'] );
    }
    else if ( is_array( $data ) )
    {
        $vld[] = cekvaliditaskodemakul( "Kode Makul", $idmakulupdate, false );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester", $tahunupdate, $semesterupdate, false );
        $vld[] = cekvaliditasinteger( "Kode kelas", $kelasupdate, 2 );
        foreach ( $data as $k => $v )
        {
            $vld[] = cekvaliditasnilaihuruf( "Simbol ".$v['simbol'], $v['simbol'] );
            $vld[] = cekvaliditasnilaibobot( "Nilai ".$v['nilai'], $v['nilai'] );
            $vld[] = cekvaliditasnumerik( "Syarat ".$v['syarat'], $v['syarat'] );
        }
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 1, SIMPAN_DATA );
        }
        else
        {
            $jmlaf = 0;
            foreach ( $data as $k => $v )
            {
                if ( $v[update] == 1 )
                {
                    $q = "\r\n\t\t\t\t\t\tUPDATE konversisp \r\n\t\t\t\t\t\tSET \r\n\t\t\t\t\t\t\tSIMBOL='{$v['simbol']}',\r\n\t\t\t\t\t\t\tSYARAT='{$v['syarat']}',\r\n\t\t\t\t\t\t\tNILAI='{$v['nilai']}'\r\n\t\t\t\t\t\tWHERE\r\n\t\t\t\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\t\t\t\tAND\r\n\t\t\t\t\t\tTAHUN='{$tahunupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tSEMESTER='{$semesterupdate}'\r\n\t\t\t\t\t\tAND\r\n\t\t\t\t\t\tKELAS='{$kelasupdate}'\r\n\t\t\t\t\t\tAND\r\n\t\t\t\t\t\tIDKONVERSI='{$k}'\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $ketlog = "Update Konversi Nilai dengan ID Makul={$idmakulupdate}, \r\n\t\t\t\t\t\tTahun Akademik=".( $tahunupdate - 1 )."/{$tahunupdate},\r\n\t\t\t\t\t\tSemester=".$arraysemester[$semesterupdate].",\r\n\t\t\t\t\t\tKelas={$kelasupdate},\r\n\t\t\t\t\t\tID Komponen={$idbaru} ({$v['simbol']}/{$v['nilai']}/{$v['syarat']})\r\n\t\t\t\t\t\t";
                        buatlog( 31 );
                        ++$jmlaf;
                    }
                }
            }
            if ( 0 < $jmlaf )
            {
                $errmesg = "Data konversi nilai berhasil diupdate";
            }
            else
            {
                $errmesg = "Data konversi nilai tidak diupdate";
            }
        }
    }
}
if ( $aksi == "tambah" && $REQUEST_METHOD == POST )
{
    if ( $jenisusers == 1 && $users != $iddosenupdate )
    {
        exit( );
    }
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Konversi Nilai", HAPUS_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditaskodemakul( "Kode Makul", $idmakulupdate, false );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester", $tahunupdate, $semesterupdate, false );
        $vld[] = cekvaliditasinteger( "Kode kelas", $kelasupdate, 2 );
        $vld[] = cekvaliditasnilaihuruf( "Simbol ".$simbol, $simbol );
        $vld[] = cekvaliditasnilaibobot( "Nilai ".$data['nilai'], $data['nilai'] );
        $vld[] = cekvaliditasnumerik( "Syarat ".$data['syarat'], $data['syarat'] );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 1, SIMPAN_DATA );
        }
        else if ( trim( $simbol ) == "" )
        {
            $errmesg = "Simbol konversi nilai harus diisi (contoh: A)";
        }
        else if ( trim( $data[nilai] ) == "" || $data[nilai] < 0 )
        {
            $errmesg = "Nilai ekivalen harus diisi >= 0";
        }
        else if ( trim( $data[syarat] ) == "" || $data[syarat] < 0 )
        {
            $errmesg = "Syarat konversi nilai harus diisi >= 0";
        }
        else
        {
            $idbaru = getnewidsyarat( "IDKONVERSI", "konversisp", "\r\n\t\t\t\tWHERE IDMAKUL='{$idmakulupdate}' AND\r\n\t\t\t\tTAHUN='{$tahunupdate}' \r\n\t\t\t\t\tAND\r\n\t\t\t\t\tSEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND\r\n\t\t\t\tKELAS='{$kelasupdate}'\r\n\t\t\t\t" );
            $q = "\r\n\t\t\t\tINSERT INTO konversisp (IDKONVERSI,IDMAKUL,TAHUN,KELAS,SIMBOL,NILAI,SYARAT,SEMESTER) \r\n\t\t\t\tVALUES ('{$idbaru}','{$idmakulupdate}','{$tahunupdate}',\r\n\t\t\t\t'{$kelasupdate}','{$simbol}','{$data['nilai']}','{$data['syarat']}','{$semesterupdate}')\r\n\t\t\t";
            mysqli_query($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $ketlog = "Tambah Konversi Nilai dengan ID Makul={$idmakulupdate}, \r\n\t\t\t\tTahun Akademik=".( $tahunupdate - 1 )."/{$tahunupdate},\r\n\t\t\t\tSemester=".$arraysemester[$semesterupdate].",\r\n\t\t\t\tKelas={$kelasupdate},\r\n\t\t\t\tID Komponen={$idbaru} ({$simbol}/{$data['nilai']}/{$data['syarat']})\r\n\t\t\t\t";
                buatlog( 30 );
                $errmesg = "Data Konversi Nilai berhasil ditambah";
                $data = "";
                $simbol = "";
            }
            else
            {
                $errmesg = "Data Konversi Nilai  tidak berhasil ditambah";
            }
        }
    }
    $aksi = "formtambah";
}
if ( $aksi == "formtambah" )
{
    if ( $jenisusers == 1 && $users != $iddosenupdate )
    {
        exit( );
    }
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    #printjudulmenu( "Edit Data Konversi Nilai" );
    #printmesg( $errmesg );
	 echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Edit Data Konversi Nilai Khusus");
				echo "	</div>";
										
		echo "			<div class=\"m-portlet\">
							<div class=\"portlet-body form\">";
    echo "						<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
									".createinputhidden( "pilihan", $pilihan, "" ).
									createinputhidden( "tab", $tab, "" ).
									createinputhidden( "aksi", "tambah", "" ).
									createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).
									createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).
									createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).
									createinputhidden( "sessid", "{$token}", "" ).
									createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).
									createinputhidden( "kelasupdate", "{$kelasupdate}", "" )."
									<div class=\"m-portlet__body\">		
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Mata Kuliah</label>\r\n    
											<label class=\"col-form-label\">{$idmakulupdate}, ".getnamafromtabel( $idmakulupdate, "makul" )."</label>
										</div>"."
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Tahun Akademik</label>\r\n    
											<label class=\"col-form-label\">".( $tahunupdate - 1 )."/{$tahunupdate}</label>
										</div>"."
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Semester</label>\r\n    
											<label class=\"col-form-label\">".$arraysemester[$semesterupdate]."</label>
										</div>"."
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Dosen Pengajar *</label>\r\n    
											<label class=\"col-form-label\">{$iddosenupdate}, ".getnamafromtabel( $iddosenupdate, "dosen" )."</label>
										</div>"."
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Kode Kelas</label>\r\n    
											<label class=\"col-form-label\">{$kelasupdate}</label>
										</div>";
    echo "				
										<div class='portlet-title'>";
											printmesg("Data Konversi Nilai Baru");
	echo "								</div>";
	
    echo "								<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Simbol</label>\r\n    
											<label class=\"col-form-label\">".createinputtext( "simbol", "{$simbol}", "size=4 class=form-control m-input" )."</label>
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Nilai Ekivalen (SKS)</label>\r\n    
											<label class=\"col-form-label\">
												".createinputtext( "data[nilai]", "{$data['nilai']}", "size=4 class=form-control m-input" )."</label>
										</div>
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Syarat</label>\r\n    
											<label class=\"col-form-label\">
												Nilai >= ".createinputtext( "data[syarat]", "{$data['syarat']}", "size=4 class=form-control m-input" )."</label>
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
							</div>
					<script>form.simbol.focus();\r\n\t\t\t</script>\r\n\t \t\t";
    echo "				<div class=\"m-portlet\">	
							<div class=\"portlet-body form\">	
								<div class='portlet-title'>";
									printmesg("Rincian Konversi Nilai");
	echo "						</div>
	
								<form name=form action=index.php method=post>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "tab", $tab, "" ).createinputhidden( "aksi", "formtambah", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "sessid", "{$token}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" )."
								";
    $q = "\r\n\t\t\t\tSELECT IDKONVERSI,SIMBOL,NILAI,SYARAT FROM konversisp\r\n\t\t\t\tWHERE \r\n\t\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\t\t\tAND\r\n\t\t\t\t\tSEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND KELAS='{$kelasupdate}'\r\n\t\t\t\tORDER BY NILAI DESC\r\n\t\t\t";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        echo "						<div class=\"m-section__content\">		
										<div class=\"table-responsive\">		
											<table class=\"table table-bordered table-hover\">
												<thead>
													<tr class=juduldata align=center>\r\n\t\t\t\t\t\t<td colspan=4></td>\r\n\t\t\t\t\t\t<td ><input type=submit name=aksitambah value='Update' class=form-control m-input></td>\r\n\t\t\t\t\t\t<td ><input type=submit name=aksitambah value='Hapus' class=form-control m-input\r\n\t\t\t\t\t\tonClick=\"return confirm('Hapus Data Konversi? Penghapusan data konversi nilai akan mengubah nilai akhir mahasiswa yang mengambil M-K ini')\"\r\n\t\t\t\t\t\t></td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr class=juduldata align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t\t<td>Simbol</td>\r\n\t\t\t\t\t\t<td>Nilai</td>\r\n\t\t\t\t\t\t<td>Syarat</td>\r\n\t\t\t\t\t\t<td >Pilih Update</td>\r\n\t\t\t\t\t\t<td >Pilih Hapus</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
        echo "									</thead>
												<tbody>";	
		$i = 1;
        $totalbobot = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            echo "					
													<tr {$kelas}  align=center>\r\n\t\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t\t<td  >".createinputtext( "data[{$d['IDKONVERSI']}][simbol]", "{$d['SIMBOL']}", " class=form-control m-input size=4" )."</td>\r\n\t\t\t\t\t\t\t<td  >".createinputtext( "data[{$d['IDKONVERSI']}][nilai]", "{$d['NILAI']}", " class=form-control m-input size=4" )."</td>\r\n\t\t\t\t\t\t\t<td  >Nilai >=".createinputtext( "data[{$d['IDKONVERSI']}][syarat]", "{$d['SYARAT']}", " class=form-control m-input size=4" )."</td>\r\n\t\t\t\t\t\t\t<td align=center>".createinputcek( "data[{$d['IDKONVERSI']}][update]", "1", "", "", " class=form-control m-input size=4" )."</td>\r\n\t\t\t\t\t\t\t<td align=center>".createinputcek( "data[{$d['IDKONVERSI']}][hapus]", "1", "", "", " class=form-control m-input size=4" )."</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
			
			$totalbobot += $d[NILAI];
            ++$i;
        }
        #echo "</table>\r\n\t\t\t\t<br><br></div></div></div></div></div>";
		echo "							</tbody>
									</table>
								</div>
							</div>
						";
    }
    else
    {
        $errmesg = "Konversi Nilai belum ada";
        printmesg( $errmesg );
    }
	echo "			</form>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>	
	";
}
if ( $aksi == "tampilkanawal" )
{
	#echo "tampilkanawal";
    $aksi = " ";
    include( "prosestampilkonversiawal.php" );
}
if ( $aksi == "tampilkan" )
{
	#echo "tampilkan";
    $aksi = " ";
    include( "prosestampilkonversi.php" );
}
if ( $aksi == "tambahawal" )
{
    #printjudulmenu( "Edit Konversi Nilai Khusus Per Pengajar Mata Kuliah " );
   echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Edit Konversi Nilai Khusus Per Pengajar Mata Kuliah ");
				echo "	</div>";
				
				
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
    echo "          	    <div class=\"portlet-body form\">";
    echo "						<form name=form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php method=post>
								<input type=hidden name=pilihan value='{$pilihan}'>
								<input type=hidden name=tab value='{$tab}'>
								<input type=hidden name=aksi value='tampilkanawal'>
								<div class=\"m-portlet__body\">		
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
									<label class=\"col-form-label\">
										<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t\t<option value=''>Semua</option>";
											foreach ( $arrayprodidep as $k => $v )
											{
												echo "<option value='{$k}'>{$v}</option>";
											}
    echo "								</select>
									</label>
								</div>";
    if ( $jenisusers == 0 )
    {
        echo "					<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">NIDN Dosen</label>\r\n    
									<div class=\"col-lg-6\">
										".createinputtext( "iddosen", $iddosen, " class=form-control m-input  size=20 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,form.idprodi.value);\" placeholder=\"Ketik NIDN / Nama Dosen...\"" )."
										<div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">
											<div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\"></div>
										</div>
									</div>
								</div>";
    }
    echo "						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Kode Mata Kuliah</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "idmakul", $idmakul, " class=form-control m-input  size=10" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Tahun Akademik</label>\r\n    
									<label class=\"col-form-label\">";
										$waktu = getdate( );
	echo "								<select name=tahun class=form-control m-input> \r\n\t\t\t\t\t\t\t<option value=''>Semua</option>";
											$i = 1900;
											while ( $i <= $waktu[year] + 5 )
											{
												echo "\r\n\t\t\t\t\t\t\t\t<option value='{$i}' {$cek}>".( $i - 1 )."/{$i}</option>\r\n\t\t\t\t\t\t\t\t";
												++$i;
											}
    echo "								</select>
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Semester</label> 
									<label class=\"col-form-label\">
										<select name=semester class=form-control m-input><option value=''>Semua</option>";
											foreach ( $arraysemester as $k => $v )
											{
												echo "<option value='{$k}' {$cek}>{$v}</option>";
											}
    echo "								</select>
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Kelas</label>\r\n    
									<label class=\"col-form-label\">
										<select name='kelas' class=form-control m-input><option value=''>Semua</option>\r\n            ";
											$ik = 1;
											while ( $ik < 100 )
											{
												if ( $ik < 10 )
												{
													$idkelas = "0{$ik}";
												}
												else
												{
													$idkelas = "{$ik}";
												}
												$selected = "";
												if ( $idkelas == $kelas )
												{
													$selected = "selected";
												}
												echo "<option value='{$idkelas}' {$selected} >{$idkelas}</option>";
												++$ik;
											}
    echo "								</select>
									</label>
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
	</div>
	</div>";
}
?>
