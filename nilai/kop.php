<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot();
cekhaktulis($kodemenu);
echo "	<script language='Javascript' type=\"text/javascript\">
			function daftarfont(pfld,pfltr) {\r\n\t\t\t\t if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {\r\n\t\t\t\t \t\twindow.PsnList.close();\r\n\t\t\t\t }\r\n\t\t\t\t PsnList = window.open('../mahasiswa/font.php?pfld='+pfld+'&pfltr='+pfltr+'&pnama=A', 'List', 'width=500,height=600,scrollbars=yes');\r\n}\r\n</script>\r\n";
$d = getsettingkop();
if ( $aksi == "simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Setting Kop", SIMPAN_DATA );
    }
    else
    {
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
            if ( !file_exists( "kartu" ) )
            {
                mkdir( "kartu", 493 );
            }
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
                    break;
                }
                $qdata .= "'";
            }
            else
            {
                $qdata = ", DATA=''  ";
            }
            $q = "UPDATE settingkop SET\r\n     PANJANG='{$panjang}',LEBAR='{$lebar}',PANJANGF='{$panjangf}',LEBARF='{$lebarf}',ISFOTO='{$isfoto}',\r\n     LATAR='{$latar}',LATARWARNA='{$latarwarna}',\r\n     ISLOGOKIRI='{$islogokiri}',ISLOGOKANAN='{$islogokanan}',\r\n     PLKIRI='{$plkiri}',LLKIRI='{$llkiri}',\r\n     PLKANAN='{$plkanan}',LLKANAN='{$llkanan}',\r\n     HEADER1='{$header1}',HEADER2='{$header2}',HEADER3='{$header3}',HEADER4='{$header4}',\r\n     FHEADER1='{$fheader1}',FHEADER2='{$fheader2}',FHEADER3='{$fheader3}',FHEADER4='{$fheader4}',\r\n     UHEADER1='{$uheader1}',UHEADER2='{$uheader2}',UHEADER3='{$uheader3}',UHEADER4='{$uheader4}',\r\n     WHEADER1='{$wheader1}',WHEADER2='{$wheader2}',WHEADER3='{$wheader3}',WHEADER4='{$wheader4}',\r\n     ISBARCODE='{$isbarcode}',\r\n     FDATA='{$fdata}',UDATA='{$udata}',WDATA='{$wdata}',\r\n     RATA='{$rata}'\r\n\r\n     \r\n     {$qlatarfoto}\r\n     {$qlogokiri}\r\n     {$qlogokanan}\r\n     {$qdata}\r\n     \r\n     ";
            mysqli_query($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Setting Kop berhasil disimpan.";
            }
        }
    }
}
#printjudulmenu( "Setting Kop Surat Umum" );
#printmesg( $errmesg );
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
$d = getsettingkop();
#echo "\r\n<form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<table class=form border=1>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "simpan", "" )."\r\n\r\n\r\n \r\n\r\n    <tr class=judulform valign=top>\r\n\t\t\t<td colspan=2><B>KOP di bawah ini akan muncul pada laporan2 yg dibuat, apabila pilihan Kop Surat Umum dipilih saat pembuatan laporan2 tersebut.</td>\r\n \t\t</tr>";
echo "	<div class=\"page-content\">
					<div class=\"container-fluid\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<!-- BEGIN SAMPLE FORM PORTLET-->
								";	
										
	echo "						<div class='portlet-title'>";
											printmesg("Setting Kop Surat Umum");
											printmesg( $errmesg );
	echo "						</div>";								
	echo "							<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>
										".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "aksi", "simpan", "" )."
									<div class=\"m-portlet\">
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>							
														<tr class=judulform valign=top>\r\n\t\t\t<td colspan=2><B>KOP di bawah ini akan muncul pada laporan2 yg dibuat, apabila pilihan Kop Surat Umum dipilih saat pembuatan laporan2 tersebut.</td>\r\n \t\t</tr>
													</thead>	
													<tbody>";
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
														echo "\r\n    <tr class=judulform valign=top>\r\n\t\t\t<td  >Logo Kiri</td>\r\n\t\t\t<td> <input type=checkbox name=islogokiri value=1 {$ceklogokiri}> Tampilkan , File Gambar\r\n\t\t\t<input type=file name=filelogokiri class=masukan> \r\n      PxL=<input type=text name=plkiri value='{$d['PLKIRI']}' size=2>mm x <input type=text name=llkiri value='{$d['LLKIRI']}' size=2>mm";
														if ( $d[LOGOKIRI] != "" && file_exists( "kartu/{$d['LOGOKIRI']}" ) )
														{
															echo "<br><img src='kartu/{$d['LOGOKIRI']}' style='width:{$d['PLKIRI']}mm;height:{$d['LLKIRI']}mm'>";
														}
														echo "\r\n \t\t\t</td>\r\n\t\t</tr>\r\n    <tr class=judulform valign=top>\r\n\t\t\t<td  >Logo Kanan</td>\r\n\t\t\t<td> <input type=checkbox name=islogokanan value=1 {$ceklogokanan}> Tampilkan , File Gambar\r\n\t\t\t<input type=file name=filelogokanan class=masukan> \r\n      PxL=<input type=text name=plkanan value='{$d['PLKANAN']}' size=2>mm x <input type=text name=llkanan value='{$d['LLKANAN']}' size=2>mm";
														if ( $d[LOGOKANAN] != "" && file_exists( "kartu/{$d['LOGOKANAN']}" ) )
														{
															echo "<br><img src='kartu/{$d['LOGOKANAN']}' style='width:{$d['PLKANAN']}mm;height:{$d['LLKANAN']}mm'>";
														}
														echo "\r\n \t\t\t</td>\r\n\t\t</tr>\r\n    <tr class=judulform valign=top>\r\n\t\t\t<td  >Tulisan Header</td>\r\n\t\t\t<td nowrap>  \r\n          Baris 1 <input type=text size=50 name=header1 value='{$d['HEADER1']}'>\r\n\t\t\t     Font \r\n \t\t\t     <input type=text size=10 name=fheader1 value='{$d['FHEADER1']}' style='font-family:{$d['FHEADER1']};font-size:12pt;'>\r\n \t\t\t     \t\t\t<a \r\n\t\t\thref=\"javascript:daftarfont('form,wewenang,fheader1',\r\n\t\t\tdocument.form.fheader1.value)\" >\r\n\t\t\tdaftar font,\r\n\t\t\t</a>\r\n           Ukuran<input type=text size=2 name=uheader1 value='{$d['UHEADER1']}'>pt, \r\n           Warna           <select name=wheader1>";
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
														echo "\r\n          </select>\r\n        <br>\r\n          Baris 2 <input type=text size=50 name=header2 value='{$d['HEADER2']}'>\r\n\t\t\t     Font \r\n \t\t\t     <input type=text size=10 name=fheader2 value='{$d['FHEADER2']}' style='font-family:{$d['FHEADER2']};font-size:12pt;'>\r\n \t\t\t     \t\t\t<a \r\n\t\t\thref=\"javascript:daftarfont('form,wewenang,fheader2',\r\n\t\t\tdocument.form.fheader2.value)\" >\r\n\t\t\tdaftar font,\r\n\t\t\t</a>\r\n \r\n\t\t\t     Ukuran<input type=text size=2 name=uheader2 value='{$d['UHEADER2']}'>pt, \r\n           Warna           <select name=wheader2>";
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
														echo "\r\n          </select>\r\n           \r\n           <br>\r\n          Baris 3 <input type=text size=50 name=header3 value='{$d['HEADER3']}'>\r\n\t\t\t     Font  \r\n \t\t\t     <input type=text size=10 name=fheader3 value='{$d['FHEADER3']}' style='font-family:{$d['FHEADER3']};font-size:12pt;'>\r\n \t\t\t     \t\t\t<a \r\n\t\t\thref=\"javascript:daftarfont('form,wewenang,fheader3',\r\n\t\t\tdocument.form.fheader3.value)\" >\r\n\t\t\tdaftar font,\r\n\t\t\t</a>\r\n \t\t\t     Ukuran<input type=text size=2 name=uheader3 value='{$d['UHEADER3']}'>pt, \r\n           Warna           <select name=wheader3>";
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
														echo "\r\n          </select>\r\n\r\n\r\n           <br>\r\n          Baris 4 <input type=text size=50 name=header4 value='{$d['HEADER4']}'>\r\n\t\t\t     Font  \r\n \t\t\t     <input type=text size=10 name=fheader4 value='{$d['FHEADER4']}' style='font-family:{$d['FHEADER4']};font-size:12pt;'>\r\n \t\t\t     \t\t\t<a \r\n\t\t\thref=\"javascript:daftarfont('form,wewenang,fheader4',\r\n\t\t\tdocument.form.fheader4.value)\" >\r\n\t\t\tdaftar font,\r\n\t\t\t</a>\r\n \t\t\t     Ukuran<input type=text size=2 name=uheader4 value='{$d['UHEADER4']}'>pt, \r\n           Warna           <select name=wheader4>";
														foreach ( $arraywarna as $k1 => $v1 )
														{
															foreach ( $arraywarna as $k2 => $v2 )
															{
																foreach ( $arraywarna as $k3 => $v3 )
																{
																	$selected = "";
																	if ( "{$v1}{$v1}{$v2}{$v2}{$v3}{$v3}" == "{$d['WHEADER4']}" )
																	{
																		$selected = "selected";
																	}
																	echo "<option {$selected} value='{$v1}{$v1}{$v2}{$v2}{$v3}{$v3}' style='background-color:#{$v1}{$v1}{$v2}{$v2}{$v3}{$v3}'>\r\n                         {$v1}{$v1}{$v2}{$v2}{$v3}{$v3}\r\n                         </option>";
																}
															}
														}
														echo "\r\n          </select>\r\n        <br><br>";
														$cekkiri = $cekkanan = $cektengah = "";
														if ( $d[RATA] == "center" )
														{
															$cektengah = "checked";
														}
														else if ( $d[RATA] == "left" )
														{
															$cekkiri = "checked";
														}
														else if ( $d[RATA] == "right" )
														{
															$cekkanan = "checked";
														}
														echo "\r\n        \r\n        Perataan : \r\n        <input type=radio name=rata value='left' {$cekkiri} > KIri \r\n\t\t\t  <input type=radio name=rata value='center' {$cektengah} > teNGah\r\n        <input type=radio name=rata value='right' {$cekkanan} > kanAN\r\n        <br><br> \r\n  \t\t\t</td>\r\n\t\t</tr>\r\n     <tr class=judulform>\r\n\t\t\t<td></td>\r\n\t\t\t<td>\r\n\t\t\t<input type=submit  value=Simpan>\r\n\t\t\t</td>\r\n\t\t</tr>";
	echo "											</tbody>
												</table>
											</div>
										</div>
									</div>
								</form>";
$q = "SELECT ID FROM mahasiswa WHERE RAND() LIMIT 0,1";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $dd = sqlfetcharray( $h );
    $id = $dd[ID];
	
    /*echo "\r\n  <br><br>\r\n  <b><i>PREVIEW</i></b>\r\n  <table  width=100%>\r\n  <tr><td  >\r\n  \r\n  ";
    include( "proseskop.php" );
    echo "{$tmpkop}</td></tr></table>";*/
	echo "						<div class='portlet-title'>";
									printmesg("PREVIEW");
									
	echo "						</div>";	
	echo "						<div class=\"m-portlet\">
									<div class=\"m-section__content\">
										<div class=\"table-responsive\">
											<table class=\"table table-bordered table-hover\">
												<thead></thead>
												<tbody>";
													include( "proseskop.php" );
	echo "											{$tmpkop}
												</tbody>
											</table>
										</div>
									</div>
								</div>";
}
echo "				</div>
				</div>
			</div>
		</div>";
?>
