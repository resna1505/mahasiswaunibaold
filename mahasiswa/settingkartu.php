<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
cekhaktulis( $kodemenu );
echo "\r\n<script language='Javascript' type=\"text/javascript\">\r\n function daftarfont(pfld,pfltr) {\r\n\t\t\t\t if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {\r\n\t\t\t\t \t\twindow.PsnList.close();\r\n\t\t\t\t }\r\n\t\t\t\t PsnList = window.open('font.php?pfld='+pfld+'&pfltr='+pfltr+'&pnama=A', 'List', 'width=500,height=600,scrollbars=yes');\r\n}\r\n</script>\r\n";
$d = getsettingkartu( );
if ( $aksi == "simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Setting Kartu", SIMPAN_DATA );
    }
    else
    {
        $vldts[] = cekvaliditasinteger( "Panjang Kartu", $panjang, 8, false );
        $vldts[] = cekvaliditasinteger( "Lebar Kartu", $lebar, 8, false );
        $vldts[] = cekvaliditasinteger( "Panjang Foto", $panjangf, 8, false );
        $vldts[] = cekvaliditasinteger( "Lebar Foto", $lebarf, 8, false );
        $vldts[] = cekvaliditasinteger( "Latar Kartu", $latar, 12, false );
        $vldts[] = cekvaliditaskode( "Latar Warna", $latarwarna, 26, false );
        $vldts[] = cekvaliditasfile( "Latar Belakang Kartu, Gambar", $_FILES['latarfoto'], 0 );
        $vldts[] = cekvaliditasfile( "File Gambar Logo Kiri", $_FILES['filelogokiri'], 0 );
        $vldts[] = cekvaliditasfile( "File Gambar Logo Kanan", $_FILES['filelogokanan'], 0 );
        $vldts = array_filter( $vldts, "filter_not_empty" );
        if ( isset( $vldts ) && 0 < count( $vldts ) )
        {
            $errmesg = val_err_mesg( $vldts, 2, SIMPAN_DATA );
            unset( $vldts );
        }
        else
        {
            if ( $latarfoto != "" )
            {
                $ext = array_pop( explode( ".", $latarfoto_name ) );
                if ( strtolower( $ext ) == "jpeg" || strtolower( $ext ) == "jpg" || strtolower( $ext ) == "gif" || strtolower( $ext ) == "png" || strtolower( $ext ) == "bmp" )
                {
                    $qlatarfoto = ", LATARFOTO='latarfoto.{$ext}' ";
                    if ( $d[LATARFOTO] != "" )
                    {
                        @unlink( @"kartu/{$d['LATARFOTO']}" );
                    }
                    move_uploaded_file( $latarfoto, "kartu/latarfoto.{$ext}" );
                }
            }
            if ( $filelogokiri != "" )
            {
                $ext = array_pop( explode( ".", $filelogokiri_name ) );
                if ( strtolower( $ext ) == "jpeg" || strtolower( $ext ) == "jpg" || strtolower( $ext ) == "gif" || strtolower( $ext ) == "png" || strtolower( $ext ) == "bmp" )
                {
                    $qlogokiri = ", LOGOKIRI='logokiri.{$ext}' ";
                    if ( $d[LOGOKIRI] != "" )
                    {
                        @unlink( @"kartu/{$d['LOGOKIRI']}" );
                    }
                    move_uploaded_file( $filelogokiri, "kartu/logokiri.{$ext}" );
                }
            }
            if ( $filelogokanan != "" )
            {
                $ext = array_pop( explode( ".", $filelogokanan_name ) );
                if ( strtolower( $ext ) == "jpeg" || strtolower( $ext ) == "jpg" || strtolower( $ext ) == "gif" || strtolower( $ext ) == "png" || strtolower( $ext ) == "bmp" )
                {
                    $qlogokanan = ", LOGOKANAN='logokanan.{$ext}' ";
                    if ( $d[LOGOKANAN] != "" )
                    {
                        @unlink( @"kartu/{$d['LOGOKANAN']}" );
                    }
                    move_uploaded_file( $filelogokanan, "kartu/logokanan.{$ext}" );
                }
            }
            $qdata = "";
            if ( is_array( $datakartu ) )
            {
                $qdata = ", Data='";
                foreach ( $datakartu as $k => $v )
                {
                    $qdata .= "{$v} ";
                }
                $qdata .= "'";
            }
            else
            {
                $qdata = ", DATA=''  ";
            }
            $q = "UPDATE settingkartu SET\r\n     PANJANG='{$panjang}',LEBAR='{$lebar}',PANJANGF='{$panjangf}',LEBARF='{$lebarf}',ISFOTO='{$isfoto}',\r\n     LATAR='{$latar}',LATARWARNA='{$latarwarna}',\r\n     ISLOGOKIRI='{$islogokiri}',ISLOGOKANAN='{$islogokanan}',\r\n     PLKIRI='{$plkiri}',LLKIRI='{$llkiri}',\r\n     PLKANAN='{$plkanan}',LLKANAN='{$llkanan}',\r\n     HEADER1='{$header1}',HEADER2='{$header2}',HEADER3='{$header3}',\r\n     FHEADER1='{$fheader1}',FHEADER2='{$fheader2}',FHEADER3='{$fheader3}',\r\n     UHEADER1='{$uheader1}',UHEADER2='{$uheader2}',UHEADER3='{$uheader3}',\r\n     WHEADER1='{$wheader1}',WHEADER2='{$wheader2}',WHEADER3='{$wheader3}',\r\n     ISBARCODE='{$isbarcode}',\r\n     FDATA='{$fdata}',UDATA='{$udata}',WDATA='{$wdata}'\r\n\r\n     \r\n     {$qlatarfoto}\r\n     {$qlogokiri}\r\n     {$qlogokanan}\r\n     {$qdata}\r\n     \r\n     ";
            doquery($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Setting Kartu berhasil disimpan.";
            }
        }
    }
}

printmesg( $errmesg );
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
$d = getsettingkartu( );
/*echo "<div class=\"page-content\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Setting Kartu Mahasiswa</span>
                            </div>";*/
 echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printtitle("Setting Kartu Mahasiswa");
				echo "	</div>";
		echo "			<div class=\"m-portlet\">
				
						<!--begin::Form-->";
echo "\r\n<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>
".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "simpan", "" )."
			<div class=\"m-portlet__body\">
				<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
					<label class=\"col-lg-2 col-form-label\">Ukuran Kartu</label>\r\n    
					<div class=\"col-lg-6\">Panjang <input type=text name=panjang value='{$d['PANJANG']}' size=2> mm x Lebar <input type=text name=lebar value='{$d['LEBAR']}' size=2> mm\r\n\t\t\t</div>
				</div>";

$cekfoto = "";
if ( $d[ISFOTO] == 1 )
{
    $cekfoto = "checked";
}
$cekbarcode = "";
if ( $d[ISBARCODE] == 1 )
{
    $cekbarcode = "checked";
}
echo "			<div class=\"form-group m-form__group row\">
					<label class=\"col-lg-2 col-form-label\">Foto Mahasiswa</label>\r\n    
					<div class=\"col-lg-6\"><input type=checkbox name=isfoto value=1 {$cekfoto}> Pasang foto mahasiswa,Panjang <input type=text name=panjangf value='{$d['PANJANGF']}' size=2> mm x\r\n\t\t\tLebar <input type=text name=lebarf value='{$d['LEBARF']}' size=2> mm\r\n\t\t\t\r\n \t\t\t</div>
				</div>
				<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
					<label class=\"col-lg-2 col-form-label\">Barcode</label>\r\n    
					<div class=\"col-lg-6\"><input type=checkbox name=isbarcode value=1 {$cekbarcode}> Pasang Barcode\r\n \t\t\t</div>
				</div>";
$ceklatar0 = $ceklatar1 = "";
if ( $d[LATAR] == 0 )
{
    $ceklatar0 = "checked";
}
else
{
    $ceklatar1 = "checked";
}
echo "    <div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Latar Belakang Kartu</label>\r\n    
				<div class=\"col-lg-6\"> <input type=radio name=latar value=0 {$ceklatar0} > Warna, Pilihan: \r\n          <select name=latarwarna>";
foreach ( $arraywarna as $k1 => $v1 )
{
    foreach ( $arraywarna as $k2 => $v2 )
    {
        foreach ( $arraywarna as $k3 => $v3 )
        {
            $selected = "";
            if ( "{$v1}{$v1}{$v2}{$v2}{$v3}{$v3}" == "{$d['LATARWARNA']}" )
            {
                $selected = "selected";
            }
            echo "<option {$selected} value='{$v1}{$v1}{$v2}{$v2}{$v3}{$v3}' style='background-color:#{$v1}{$v1}{$v2}{$v2}{$v3}{$v3}'>\r\n                         {$v1}{$v1}{$v2}{$v2}{$v3}{$v3}\r\n                         </option>";
        }
    }
}
echo "\r\n          </select>\r\n           <br>\r\n          <input type=radio name=latar value=1 {$ceklatar1} > Gambar,\r\n    \t\t\tFile: <input type=file name=latarfoto class=masukan>\r\n    \t\t\t";
if ( $d[LATARFOTO] != "" && file_exists( "kartu/{$d['LATARFOTO']}" ) )
{
    echo "<br><img src='kartu/{$d['LATARFOTO']}' class=\"rounded\" style='width:{$d['PANJANG']}mm;height:{$d['LEBAR']}mm'>";
}
echo "\r\n          <br>\r\n      </div>
			</div> 
			<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
					<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
					<div class=\"col-lg-6\"><input type=submit  value=Simpan>\r\n\t\t\t</div>
			</div>
			<div class='portlet-title'>";
								printtitle("Header");
echo "		</div>";
$ceklogokiri = "";
if ( $d[ISLOGOKIRI] == 1 )
{
    $ceklogokiri = "checked";
}
$ceklogokanan = "";
if ( $d[ISLOGOKANAN] == 1 )
{
    $ceklogokanan = "checked";
}
echo "		<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
				<label class=\"col-lg-2 col-form-label\">Logo Kiri</label>\r\n    
				<div class=\"col-lg-6\"><input type=checkbox name=islogokiri value=1 {$ceklogokiri}> Tampilkan , File Gambar <input type=file name=filelogokiri class=masukan> \r\n      PxL=<input type=text name=plkiri value='{$d['PLKIRI']}' size=2>mm x <input type=text name=llkiri value='{$d['LLKIRI']}' size=2>mm";
if ( $d[LOGOKIRI] != "" && file_exists( "kartu/{$d['LOGOKIRI']}" ) )
{
    echo "<br><img src='kartu/{$d['LOGOKIRI']}' style='width:{$d['PLKIRI']}mm;height:{$d['LLKIRI']}mm'>";
}
echo "			</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Logo Kanan</label>\r\n    
				<div class=\"col-lg-6\">
					<input type=checkbox name=islogokanan value=1 {$ceklogokanan}> Tampilkan , File Gambar
					<input type=file name=filelogokanan class=masukan>PxL=
					<input type=text name=plkanan value='{$d['PLKANAN']}' size=2>mm x 
					<input type=text name=llkanan value='{$d['LLKANAN']}' size=2>mm";
if ( $d[LOGOKANAN] != "" && file_exists( "kartu/{$d['LOGOKANAN']}" ) )
{
    echo "<br><img src='kartu/{$d['LOGOKANAN']}' style='width:{$d['PLKANAN']}mm;height:{$d['LLKANAN']}mm'>";
}
echo "			</div>
			</div>
			<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
				<label class=\"col-lg-2 col-form-label\">Tulisan Header</label>\r\n    
				<div class=\"col-lg-6\">Baris 1 <input type=text size=40 name=header1 value='{$d['HEADER1']}'> Font <input type=text size=15 name=fheader1 value='{$d['FHEADER1']}' style='font-family:{$d['FHEADER1']};font-size:12pt;'>\r\n \t\t\t     \t\t\t<a \r\n\t\t\thref=\"javascript:daftarfont('form,wewenang,fheader1',\r\n\t\t\tdocument.form.fheader1.value)\" >\r\n\t\t\tdaftar font,\r\n\t\t\t</a>\r\n           Ukuran<input type=text size=2 name=uheader1 value='{$d['UHEADER1']}'>pt, \r\n           Warna           <select name=wheader1>";
foreach ( $arraywarna as $k1 => $v1 )
{
    foreach ( $arraywarna as $k2 => $v2 )
    {
        foreach ( $arraywarna as $k3 => $v3 )
        {
            $selected = "";
            if ( "{$v1}{$v1}{$v2}{$v2}{$v3}{$v3}" == "{$d['WHEADER1']}" )
            {
                $selected = "selected";
            }
            echo "<option {$selected} value='{$v1}{$v1}{$v2}{$v2}{$v3}{$v3}' style='background-color:#{$v1}{$v1}{$v2}{$v2}{$v3}{$v3}'>\r\n                         {$v1}{$v1}{$v2}{$v2}{$v3}{$v3}\r\n                         </option>";
        }
    }
}
echo "\r\n          </select>\r\n        <br>\r\n          Baris 2 <input type=text size=40 name=header2 value='{$d['HEADER2']}'>\r\n\t\t\t     Font \r\n \t\t\t     <input type=text size=15 name=fheader2 value='{$d['FHEADER2']}' style='font-family:{$d['FHEADER2']};font-size:12pt;'>\r\n \t\t\t     \t\t\t<a \r\n\t\t\thref=\"javascript:daftarfont('form,wewenang,fheader2',\r\n\t\t\tdocument.form.fheader2.value)\" >\r\n\t\t\tdaftar font,\r\n\t\t\t</a>\r\n \r\n\t\t\t     Ukuran<input type=text size=2 name=uheader2 value='{$d['UHEADER2']}'>pt, \r\n           Warna           <select name=wheader2>";
foreach ( $arraywarna as $k1 => $v1 )
{
    foreach ( $arraywarna as $k2 => $v2 )
    {
        foreach ( $arraywarna as $k3 => $v3 )
        {
            $selected = "";
            if ( "{$v1}{$v1}{$v2}{$v2}{$v3}{$v3}" == "{$d['WHEADER2']}" )
            {
                $selected = "selected";
            }
            echo "<option {$selected} value='{$v1}{$v1}{$v2}{$v2}{$v3}{$v3}' style='background-color:#{$v1}{$v1}{$v2}{$v2}{$v3}{$v3}'>\r\n                         {$v1}{$v1}{$v2}{$v2}{$v3}{$v3}\r\n                         </option>";
        }
    }
}
echo "\r\n          </select>\r\n           \r\n           <br>\r\n          Baris 3 <input type=text size=40 name=header3 value='{$d['HEADER3']}'>\r\n\t\t\t     Font  \r\n \t\t\t     <input type=text size=15 name=fheader3 value='{$d['FHEADER3']}' style='font-family:{$d['FHEADER3']};font-size:12pt;'>\r\n \t\t\t     \t\t\t<a \r\n\t\t\thref=\"javascript:daftarfont('form,wewenang,fheader3',\r\n\t\t\tdocument.form.fheader3.value)\" >\r\n\t\t\tdaftar font,\r\n\t\t\t</a>\r\n \t\t\t     Ukuran<input type=text size=2 name=uheader3 value='{$d['UHEADER3']}'>pt, \r\n           Warna           <select name=wheader3>";
foreach ( $arraywarna as $k1 => $v1 )
{
    foreach ( $arraywarna as $k2 => $v2 )
    {
        foreach ( $arraywarna as $k3 => $v3 )
        {
            $selected = "";
            if ( "{$v1}{$v1}{$v2}{$v2}{$v3}{$v3}" == "{$d['WHEADER3']}" )
            {
                $selected = "selected";
            }
            echo "<option {$selected} value='{$v1}{$v1}{$v2}{$v2}{$v3}{$v3}' style='background-color:#{$v1}{$v1}{$v2}{$v2}{$v3}{$v3}'>\r\n                         {$v1}{$v1}{$v2}{$v2}{$v3}{$v3}\r\n                         </option>";
        }
    }
}
echo "\r\n          </select>
				</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
				<div class=\"col-lg-6\"><input type=submit  value=Simpan>\r\n\t\t\t</div>
			</div>
			<div class='portlet-title'>";
								printtitle("Data");
echo "		</div>"; 
echo "		<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
				<label class=\"col-lg-2 col-form-label\">Pilihan Field</label>\r\n    
				<div class=\"col-lg-6\">";
$arraydatakartupilih = explode( " ", $d[DATA] );
foreach ( $arraydatakartu as $k => $v )
{
    $cekdata = "";
    if ( in_array( $k, $arraydatakartupilih ) )
    {
        $cekdata = "checked";
    }
    echo "\r\n          <input {$cekdata} type=checkbox name='datakartu[{$k}]' value='{$k}'>{$v['J']}<br>\r\n        ";
}
echo "			</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Atribut</label>\r\n    
				<div class=\"col-lg-6\"> Font <input type=text size=15 name=fdata value='{$d['FDATA']}' style='font-family:{$d['FDATA']};font-size:12pt;'><a \r\n\t\t\thref=\"javascript:daftarfont('form,wewenang,fdata',\r\n\t\t\tdocument.form.fdata.value)\" >\r\n\t\t\tdaftar font,\r\n\t\t\t</a>\r\n\r\n \t\t\t     Ukuran<input type=text size=2 name=udata value='{$d['UDATA']}'>pt, \r\n           Warna           <select name=wdata>";
foreach ( $arraywarna as $k1 => $v1 )
{
    foreach ( $arraywarna as $k2 => $v2 )
    {
        foreach ( $arraywarna as $k3 => $v3 )
        {
            $selected = "";
            if ( "{$v1}{$v1}{$v2}{$v2}{$v3}{$v3}" == "{$d['WDATA']}" )
            {
                $selected = "selected";
            }
            echo "<option {$selected} value='{$v1}{$v1}{$v2}{$v2}{$v3}{$v3}' style='background-color:#{$v1}{$v1}{$v2}{$v2}{$v3}{$v3}'>\r\n                         {$v1}{$v1}{$v2}{$v2}{$v3}{$v3}\r\n                         </option>";
        }
    }
}
echo "				</select>
				</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
				<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
				<div class=\"col-lg-6\"><input type=submit  value=Simpan>\r\n\t\t\t</div>
			</div>
		</div>
	</form>";
$q = "SELECT ID FROM mahasiswa WHERE RAND() LIMIT 0,1";
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $dd = sqlfetcharray( $h );
    $id = $dd[ID];
    echo "\r\n  <br><br>\r\n  <b><i>RANDOM PREVIEW</i></b>\r\n  <table class='reset'>\r\n  <tr><td  >\r\n  \r\n  ";
    if ( $STEIINDONESIA == 1 )
    {
        include( "proseskartustei.php" );
    }
    else
    {
        include( "proseskartu.php" );
    }
    echo "</td></tr></table></div>";
    echo "</div>
			<!--end::Portlet-->			
			</div>
			<!--end::md-12-->	
		</div>
		<!--end::row-->	
	</div>
		<!--end::container-fluid-->";
}
?>
