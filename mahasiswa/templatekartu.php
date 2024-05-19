<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot();
cekhaktulis( $kodemenu );
#printjudulmenu( "TEMPLATE KARTU" );
$logo = file( "{$dirgambar}/logo.txt" );
$size = imgsizeproph( "{$dirgambar}/{$logo['0']}", 80 );
include( "../fungsibarcode128.php" );
if ( $aksi == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Template", SIMPAN_DATA );
    }
    else
    {
        $q = "SELECT FOTOKARTU FROM sistem LIMIT 0,1";
        $h = doquery($koneksi,$q);
        $d = sqlfetcharray( $h );
        $fotolama = $d[FOTOKARTU];
        $qfoto = "";
        if ( $hapusfoto == 1 )
        {
            if ( $fotolama != "" )
            {
                @unlink( @"kartu/{$fotolama}" );
            }
            $qfoto .= ", FOTOKARTU='' ";
        }
        if ( $foto != "" )
        {
            if ( $fotolama != "" )
            {
                @unlink( @"kartu/{$fotolama}" );
            }
            move_uploaded_file( $foto, "kartu/{$foto_name}" );
            $qfoto .= ",\r\n  FOTOKARTU='{$foto_name}' ";
        }
        $q = "UPDATE sistem SET \r\n  KARTUMAHASISWA='{$kartumahasiswa}',\r\n  JABATANKARTU='{$jabatankartu}',\r\n  NAMAKARTU='{$namakartu}' \r\n  {$qfoto}\r\n  \r\n   ";
        $h = doquery($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Pilihan template kartu mahasiswa berhasil disimpan.";
        }
        else
        {
            $errmesg = "Pilihan template kartu mahasiswa tidak disimpan.";
        }
    }
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
printmesg( $errmesg );
$q = "SELECT JABATANKARTU,NAMAKARTU,KARTUMAHASISWA,FOTOKARTU FROM sistem LIMIT 0,1";
$h = doquery($koneksi,$q);
$d = sqlfetcharray( $h );
$kartumahasiswa = $d[KARTUMAHASISWA];
 echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Template Kartu Mahasiswa");
				echo "	</div>";
		echo "			<div class=\"m-portlet\">
				
						<!--begin::Form-->";
#echo " \r\n<form method=post action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA' >\r\n<input type=hidden name='pilihan' value='{$pilihan}'>".createinputhidden( "sessid", $_SESSION['token'], "" )."\r\n <br><br>\r\n <table>\r\n  <tr>\r\n    <td width=200>Jabatan</td>\r\n    <td><input type=text name=jabatankartu value='{$d['JABATANKARTU']}' size=20></td>\r\n  </tr>\r\n  <tr>\r\n    <td>Nama</td>\r\n    <td><input type=text name=namakartu value='{$d['NAMAKARTU']}' size=20></td>\r\n  </tr>\r\n<tr class=judulform>\r\n\t\t\t<td>File Gambar Tanda Tangan</td>\r\n\t\t\t<td>\r\n\t\t\t<input type=file name=foto class=masukan>";
echo "					<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form method=post action=index.php  ENCTYPE='MULTIPART/FORM-DATA' >\r\n
						<input type=hidden name='pilihan' value='{$pilihan}'>".createinputhidden( "sessid", $_SESSION['token'], "" )."";
echo "						<div class=\"m-portlet__body\">";
#echo "<table>\r\n  <tr>\r\n    <td width=200>Jabatan</td>\r\n    <td><input type=text name=jabatankartu value='{$d['JABATANKARTU']}' size=20></td>\r\n  </tr>\r\n  <tr>\r\n    <td>Nama</td>\r\n    <td><input type=text name=namakartu value='{$d['NAMAKARTU']}' size=20></td>\r\n  </tr>\r\n<tr class=judulform>\r\n\t\t\t<td>File Gambar Tanda Tangan</td>\r\n\t\t\t<td>\r\n\t\t\t<input type=file name=foto class=masukan>";
echo "							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Jabatan</label>\r\n    
									<div class=\"col-lg-6\"><input type=text name=jabatankartu value='{$d['JABATANKARTU']}' size=20></div>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Nama</label>\r\n    
									<div class=\"col-lg-6\"><input type=text name=namakartu value='{$d['NAMAKARTU']}' size=20></div>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">File Gambar Tanda Tangan</label>\r\n    
									<div class=\"col-lg-6\">
										<input type=file name=foto class=masukan>";
if ( $d[FOTOKARTU] != "" && file_exists( "kartu/{$d['FOTOKARTU']}" ) )
{
    echo "<br><img src='kartu/{$d['FOTOKARTU']}'  height=100>\r\n    <input type=checkbox name=hapusfoto value=1 class=\"btn btn-brand\"> Hapus Gambar\r\n    ";
}
echo "								</div>
								</div>
								<div class=\"form-group m-form__group row\">
									
									<div class=\"col-lg-6\"><input type=submit name=aksi value='Simpan' class=\"btn btn-brand\"> \r\n    \r\n    </div>
								</div>";
foreach ( $arraytemplatekartu as $k => $v )
{
    $cek = "";
    $bold = "";
    if ( $k == $kartumahasiswa )
    {
        $cek = "checked";
        $bold = "style='border:solid;'";
    }
    $template = file_get_contents( "{$k}.html" );
    $q = "SELECT mahasiswa.ID,mahasiswa.NAMA,mahasiswa.IDPRODI,mahasiswa.TEMPAT,\r\n  DATE_FORMAT(mahasiswa.TANGGAL,'%d-%m-%Y') TANGGALLAHIR,prodi.TINGKAT, \r\n  mahasiswa.KELAMIN FROM mahasiswa,prodi \r\n  WHERE\r\n  mahasiswa.IDPRODI=prodi.ID\r\n  ORDER BY Rand() LIMIT 1";
	#echo $q;exit();
    $h2 = doquery($koneksi,$q);
    $d2 = sqlfetcharray( $h2 );
    $l = 1;
    createbarcode128( "{$d2['ID']}", "barcode/{$d2['ID']}", "B", 0 );
    $template = str_replace( "<!--JABATANTTD-->", "{$d['JABATANKARTU']}", $template );
    $template = str_replace( "<!--NAMATTD-->", "{$d['NAMAKARTU']}", $template );
    $template = str_replace( "<!--LOGOKANTOR-->", "{$dirgambar}/{$logo['0']}", $template );
    $template = str_replace( "<!--NAMAKANTOR-->", "{$namakantor}", $template );
    $template = str_replace( "<!--ALAMATKANTOR-->", "{$alamat}", $template );
    $template = str_replace( "<!--NAMAMAHASISWA-->", $d2[NAMA], $template );
    $template = str_replace( "<!--NIMMAHASISWA-->", $d2[ID], $template );
    $template = str_replace( "<!--PRODIMAHASISWA-->", $arrayjenjang[$d2[TINGKAT]]." ".$arrayprodi[$d2[IDPRODI]], $template );
    $template = str_replace( "<!--TTLMAHASISWA-->", $d2[TEMPAT]."/".$d2[TANGGALLAHIR], $template );
    $template = str_replace( "<!--KELAMINMAHASISWA-->", $arraykelamin[$d2[KELAMIN]], $template );
    $template = str_replace( "<!--FOTOMAHASISWA-->", "foldertemplate1/130130001mou.jpg  ", $template );
    $template = str_replace( "<!--BARCODEMAHASISWA-->", "barcode/{$d2['ID']}.png", $template );
    if ( $d[FOTOKARTU] != "" && !file_exists( "kartu/{$d['FOTOKARTU']}" ) )
    {
        $template = preg_replace( "/<!--TTD-->.*<!--ENDTTD-->/", "", $template );
    }
    else
    {
        $template = str_replace( "<!--FOTOTTD-->", "kartu/{$d['FOTOKARTU']}", $template );
    }
    echo "<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">
				<input type=radio name=kartumahasiswa value='{$k}' {$cek} > <b>{$v}</b>
				{$template} \r\n          </label>\r\n        </div>";
}
echo "<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
			  
				<div class=\"col-lg-6\"><input type=submit name=aksi value='Simpan' class=\"btn btn-brand\"></div>
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
?>
