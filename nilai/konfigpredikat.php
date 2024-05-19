<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

cekhaktulis( $kodemenu );
if ( $aksitambah == "Hapus" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Predikat Lulus", HAPUS_DATA );
        unset( $_SESSION['token'] );
    }
    else if ( is_array( $data ) )
    {
        $jmlaf = 0;
        foreach ( $data as $k => $v )
        {
            if ( $v[hapus] == 1 )
            {
                $q = "\r\n\t\t\t\t\t\tDELETE FROM konversipredikat \r\n\t\t\t\t\t\tWHERE\r\n \t\t\t\t\t\tID='{$k}'\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t";
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    ++$jmlaf;
                }
            }
        }
        if ( 0 < $jmlaf )
        {
            $errmesg = "Data Predikat Kelulusan berhasil dihapus";
        }
        else
        {
            $errmesg = "Data Predikat Kelulusan tidak dihapus";
        }
    }
}
if ( $aksitambah == "Update" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Predikat Lulus", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        if ( is_array( $data ) )
        {
            foreach ( $data as $k => $v )
            {
                $vld[] = cekvaliditasnama( "Nama \"".$v['nama']."\"", $v['nama'], 32, false );
                $vld[] = cekvaliditasnumerik( "Syarat IPK \"".$v['syarat']."\"", $data['syarat'], 5, false );
                $vld[] = cekvaliditasnumerik( "Syarat Masa Belajar  \"".$v['syaratw']."\"", $data['syaratw'], 5, false );
            }
        }
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
        }
        else if ( is_array( $data ) )
        {
            $jmlaf = 0;
            foreach ( $data as $k => $v )
            {
                if ( $v[update] == 1 )
                {
                    $q = "\r\n\t\t\t\t\t\tUPDATE konversipredikat \r\n\t\t\t\t\t\tSET \r\n\t\t\t\t\t\t\tNAMA='{$v['nama']}',\r\n\t\t\t\t\t\t\tNAMA2='{$v['nama2']}',\r\n\t\t\t\t\t\t\tSYARAT='{$v['syarat']}',\r\n\t\t\t\t\t\t\tSYARATW='{$v['syaratw']}'\r\n \t\t\t\t\t\tWHERE\r\n \t\t\t\t\t\tID='{$k}'\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        ++$jmlaf;
                    }
                }
            }
            if ( 0 < $jmlaf )
            {
                $errmesg = "Data Predikat Kelulusan berhasil diupdate";
            }
            else
            {
                $errmesg = "Data Predikat Kelulusan tidak diupdate";
            }
        }
    }
}
if ( $aksi == "tambah" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Predikat Lulus", TAMBAH_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasnama( "Nama \"".$nama."\"", $nama, 32, false );
        $vld[] = cekvaliditasnumerik( "Syarat IPK ", $data['syarat'], 5, false );
        $vld[] = cekvaliditasnumerik( "Syarat Masa Belajar", $data['syaratw'], 5, false );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, TAMBAH_DATA );
        }
        else if ( trim( $nama ) == "" )
        {
            $errmesg = "Nama Predikat Kelulusan harus diisi (contoh: Cum Laude)";
        }
        else if ( trim( $data[syarat] ) == "" || $data[syarat] < 0 )
        {
            $errmesg = "Syarat Predikat Kelulusan harus diisi >= 0";
        }
        else
        {
            $idbaru = getnewidsyarat( "ID", "konversipredikat", "" );
            $q = "\r\n\t\t\t\tINSERT INTO konversipredikat (ID,NAMA,SYARAT,SYARATW,NAMA2) \r\n\t\t\t\tVALUES ('{$idbaru}','{$nama}','{$data['syarat']}','{$data['syaratw']}','{$nama2}')\r\n\t\t\t";
            mysqli_query($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Predikat Kelulusan berhasil ditambah";
                $data = "";
                $nama = "";
            }
            else
            {
                $errmesg = "Data Predikat Kelulusan  tidak berhasil ditambah";
            }
        }
    }
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
#printjudulmenu( "Edit Predikat Kelulusan" );
#printmesg( $errmesg );
#echo "\r\n\t\t\t<form name=form action=index.php method=post>".createinputhidden( "aksi", "tambah", "" ).createinputhidden( "sessid", $token, "" ).createinputhidden( "pilihan", $pilihan, "" );
#printjudulmenukecil( "Data Predikat Kelulusan Baru" );
	echo "		<div class=\"page-content\">
					<div class=\"container-fluid\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<!-- BEGIN SAMPLE FORM PORTLET-->
								";	
										
	echo "						<div class='portlet-title'>";
									printmesg("Edit Predikat Kelulusan");
									printmesg( $errmesg );
	echo "						</div>
								<div class=\"m-portlet\">
									<!--begin::Form-->";
	echo "							<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
									".createinputhidden( "aksi", "tambah", "" ).createinputhidden( "sessid", $token, "" ).createinputhidden( "pilihan", $pilihan, "" );
	echo "							<div class='portlet-title'>";
										printmesg("Data Predikat Kelulusan Baru");
	echo "							</div>								
									<div class=\"m-portlet__body\">
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Nama</label>\r\n    
											<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
												".createinputtext( "nama", "{$nama}", "size=40 class=form-control m-input" )."
											</label>
										</div>
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Nama Dalam Bahasa Inggris</label>\r\n    
											<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
												".createinputtext( "nama2", "{$nama2}", "size=40 class=form-control m-input" )."
											</label>
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Syarat</label>\r\n    
											<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
												IPK >= ".createinputtext( "data[syarat]", "{$data['syarat']}", "size=4 class=form-control m-input" )."dan Masa Belajar <= ".createinputtext( "data[syaratw]", "{$data['syaratw']}", "size=4 class=form-control m-input" )." tahun
											</label>
										</div>"."
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
											<div class=\"col-lg-6\">
												<input type=submit value='Tambah' class=\"btn btn-brand\">
												<input type=reset value='Reset' class=\"btn btn-secondary\">
											</div>
										</div>
									</div>
								</form>
							</div>
						
			<script>
				form.nama.focus();
			</script>";
#printjudulmenukecil( "Rincian Predikat Kelulusan" );
echo "						<div class='portlet-title'>";
								printmesg("Rincian Predikat Kelulusan");
								printmesg( $errmesg );
	echo "					</div>";
$q = "\r\n\t\t\t\tSELECT ID,NAMA,SYARAT,SYARATW,NAMA2 FROM konversipredikat\r\n\t\t\t\tORDER BY SYARAT DESC,SYARATW ASC\r\n\t\t\t";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    echo "					<form name=form action=index.php method=post>
							".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $token, "" )."
							<div class=\"m-portlet\">
								<div class=\"m-section__content\">
									<div class=\"table-responsive\">
										<table class=\"table table-bordered table-hover\">
											<thead>
												<tr class=juduldata align=center>
													<td colspan=3></td>
													<td><input type=submit name=aksitambah value='Update' class=\"btn btn-brand\"></td>
													<td><input type=submit name=aksitambah value='Hapus' class=\"btn btn-secondary\" onClick=\"return confirm('Hapus Data Predikat Kelulusan?')\"></td>
												</tr>
												<tr class=juduldata align=center>\r\n\t\t\t\t\t\t<td>No</td><td>Nama</td><td>Syarat</td><td >Pilih Update</td><td>Pilih Hapus</td></tr>
											</thead>
											<tbody>";
	$i = 1;
    $totalbobot = 0;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t\t\t<tr {$kelas}  align=center>\r\n\t\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t\t<td align=left >".createinputtext( "data[{$d['ID']}][nama]", "{$d['NAMA']}", " class=form-control m-input size=30" )."<br>\r\n              <i>Bahasa Inggris</i><br>\r\n              ".createinputtext( "data[{$d['ID']}][nama2]", "{$d['NAMA2']}", " class=form-control m-input size=30" )."\r\n              </td>\r\n \t\t\t\t\t\t\t<td  nowrap>\r\n \t\t\t\t\t\t\tIPK >= ".createinputtext( "data[{$d['ID']}][syarat]", "{$d['SYARAT']}", " class=form-control m-input size=4" )."\r\n \t\t\t\t\t\t\tdan\r\n \t\t\t\t\t\t\tMasa Belajar <= ".createinputtext( "data[{$d['ID']}][syaratw]", "{$d['SYARATW']}", " class=form-control m-input size=4" )."\r\n \t\t\t\t\t\t\ttahun\r\n \t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td align=center>".createinputcek( "data[{$d['ID']}][update]", "1", "", "", " class=form-control m-input size=4" )."</td>\r\n\t\t\t\t\t\t\t<td align=center>".createinputcek( "data[{$d['ID']}][hapus]", "1", "", "", " class=form-control m-input size=4" )."</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
        $totalbobot += $d[SYARAT];
        ++$i;
    }
    echo "									</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>";
}
else
{
    $errmesg = "Predikat Kelulusan belum ada";
    printmesg( $errmesg );
}
?>
