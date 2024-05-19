<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
if ( $aksi == "update" && $REQUEST_METHOD == POST )
{
	#echo "kesini ga";exit();
	#print_r($_SESSION);
	#echo '<br>';
	#print_r($_POST);
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "", SIMPAN_DATA );
    }
    else
    {
		#echo "kesini ga";exit();
        unset( $_SESSION['token'] );
        #cekhaktulis( $kodemenu );
        $q = "SHOW FULL COLUMNS FROM {$NAMATABELBEBAS}";
		#echo $q.'<br>';
        $h = mysqli_query($koneksi,$q);
        if ( 1 < sqlnumrows( $h ) )
        {
            $q = "UPDATE {$NAMATABELBEBAS} SET";
            #echo $q.'<br>';
            #exit();
			$i = 0;
            unset( $arrayfileupload );
            while ( $d = sqlfetcharray( $h ) )
            {
                if ( $d[0] != "ID" )
                {
                    ++$i;
                    $hasil = getmetadata( $d );
                    $tipe = $hasil[tipe];
                    if ( $tipe != 99 )
                    {
                        $nilai = "";
                        if ( $tipe == 0 || $tipe == 1 || $tipe == 2 || $tipe == 8 || $tipe == 9 )
                        {
                            $nilai = $$d[0];
                            if ( $vldts[] = cekvaliditaskode( $d[0], $nilai ) == "" )
                            {
                                $q .= " {$d['0']}='{$nilai}', ";
                            }
                        }
                        else if ( $tipe == 3 )
                        {
                            $tmp = $$d[0];
                            if ( is_array( $tmp ) )
                            {
                                foreach ( $tmp as $k => $v )
                                {
                                    $nilai .= "{$v},";
                                }
                            }
                            $nilai = trim( $nilai, "," );
                            if ( $vldts[] = cekvaliditaskode( $d[0], $nilai ) == "" )
                            {
                                $q .= " {$d['0']}='{$nilai}', ";
                            }
                        }
                        else if ( $tipe == "4" )
                        {
                            $tmp = $$d[0];
                            $nilai = "{$tmp['thn']}-{$tmp['bln']}-{$tmp['tgl']}";
                            if ( $vldts[] = cekvaliditaskode( $d[0], $nilai ) == "" )
                            {
                                $q .= " {$d['0']}='{$nilai}', ";
                            }
                        }
                        else if ( $tipe == "5" )
                        {
                            $tmp = $$d[0];
                            $nilai = "{$tmp['jam']}:{$tmp['mnt']}:{$tmp['dtk']}";
                            $q .= " {$d['0']}='{$nilai}', ";
                        }
                        else if ( $tipe == "6" )
                        {
                            $nilai = "hapus".$d[0];
                            $statushapus = $$nilai;
                            if ( $statushapus == 1 )
                            {
                                $qtmp = "SELECT `{$d['0']}` FROM {$NAMATABELBEBAS} WHERE ID='{$idupdate}'";
                                $htmp = mysqli_query($koneksi,$qtmp);
                                if ( 0 < sqlnumrows( $htmp ) )
                                {
                                    $dtmp = sqlfetcharray( $htmp );
                                    $namafilelama = $dtmp["{$d['0']}"];
                                    if ( $namafilelama != "" && file_exists( $FOLDERFILE."/{$namafilelama}" ) )
                                    {
                                        $arrayfileupload[$i][hapus] = $FOLDERFILE."/{$namafilelama}";
                                        $q .= " {$d['0']}='', ";
                                    }
                                }
                            }
                            $nilai = $$d[0];
                            $nilai_name = ${ $d[0]."_name" };
                            if ( $nilai != "" )
                            {
                                $ext = array_pop( explode( ".", $nilai_name ) );
                                if ( strtolower( $ext ) == "jpg" || strtolower( $ext ) == "jpeg" )
                                {
                                    $q .= " {$d['0']}='foto{$i}"."_{$idupdate}"."_{$nilai_name}', ";
                                    $qtmp = "SELECT `{$d['0']}` FROM {$NAMATABELBEBAS} WHERE ID='{$idupdate}'";
                                    $htmp = mysqli_query($koneksi,$qtmp);
                                    if ( 0 < sqlnumrows( $htmp ) )
                                    {
                                        $dtmp = sqlfetcharray( $htmp );
                                        $namafilelama = $dtmp["{$d['0']}"];
                                        if ( $namafilelama != "" && file_exists( $FOLDERFILE."/{$namafilelama}" ) )
                                        {
                                            $arrayfileupload[$i][hapus] = $FOLDERFILE."/{$namafilelama}";
                                        }
                                    }
                                    $arrayfileupload[$i][simpan] = $FOLDERFILE."/foto{$i}"."_{$idupdate}"."_{$nilai_name}";
                                    $arrayfileupload[$i][nama] = $nilai;
                                }
                            }
                        }
                        else if ( $tipe == "7" )
                        {
                            $nilai = "hapus".$d[0];
                            $statushapus = $$nilai;
                            if ( $statushapus == 1 )
                            {
                                $qtmp = "SELECT `{$d['0']}` FROM {$NAMATABELBEBAS} WHERE ID='{$idupdate}'";
                                $htmp = mysqli_query($koneksi,$qtmp);
                                if ( 0 < sqlnumrows( $htmp ) )
                                {
                                    $dtmp = sqlfetcharray( $htmp );
                                    $namafilelama = $dtmp["{$d['0']}"];
                                    if ( $namafilelama != "" && file_exists( $FOLDERFILE."/{$namafilelama}" ) )
                                    {
                                        $arrayfileupload[$i][hapus] = $FOLDERFILE."/{$namafilelama}";
                                        $q .= " {$d['0']}='', ";
                                    }
                                }
                            }
                            $nilai = $$d[0];
                            $nilai_name = ${ $d[0]."_name" };
                            if ( $nilai != "" )
                            {
                                $ext = array_pop( explode( ".", $nilai_name ) );
                                if ( strtolower( $ext ) != "php" && strtolower( $ext ) != "php3" && strtolower( $ext ) != "inc" )
                                {
                                    $q .= " {$d['0']}='file{$i}"."_{$idupdate}"."_{$nilai_name}', ";
                                    $qtmp = "SELECT `{$d['0']}` FROM {$NAMATABELBEBAS} WHERE ID='{$idupdate}'";
                                    $htmp = mysqli_query($koneksi,$qtmp);
                                    if ( 0 < sqlnumrows( $htmp ) )
                                    {
                                        $dtmp = sqlfetcharray( $htmp );
                                        $namafilelama = $dtmp["{$d['0']}"];
                                        if ( $namafilelama != "" && file_exists( $FOLDERFILE."/{$namafilelama}" ) )
                                        {
                                            $arrayfileupload[$i][hapus] = $FOLDERFILE."/{$namafilelama}";
                                        }
                                    }
                                    $arrayfileupload[$i][simpan] = $FOLDERFILE."/file{$i}"."_{$idupdate}"."_{$nilai_name}";
                                    $arrayfileupload[$i][nama] = $nilai;
                                }
                            }
                        }
                    }
                }
            }
            $q .= " ID=ID WHERE ID='{$idupdate}'";
			#echo $q;exit();
            mysqli_query($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Biodata berhasil diupdate";
                if ( is_array( $arrayfileupload ) )
                {
                    foreach ( $arrayfileupload as $k => $v )
                    {
                        if ( $v[hapus] != "" )
                        {
                            @unlink( @$v[hapus] );
                        }
                        @move_uploaded_file( @$v[nama], @$v[simpan] );
                    }
                }
                unset( $arrayfileupload );
            }
            else
            {
                $errmesg = "Biodata tidak diupdate";
            }
            if ( is_array( $vldts ) )
            {
                $vldts = array_filter( $vldts, "filter_not_empty" );
            }
            if ( isset( $vldts ) && 0 < count( $vldts ) )
            {
                $errmesg .= "<br>".str_replace( "Data tidak disimpan", "", val_err_mesg( $vldts, 2, SIMPAN_DATA ) );
                unset( $vldts );
            }
        }
		
		#$aksi="";
    }
	$aksi = "";
}

if ( $aksi == "" )
{
    #printjudulmenu( "Data Dosen" );
    $arraymenutab[0] = "Biodata";
    $arraymenutab[5] = "Biodata (2)";
    $arraymenutab[4] = "Aktivitas Mengajar*";
    $arraymenutab[2] = "Dosen Keluar/Cuti/Studi Lanjut";
    $arraymenutab[1] = "Riwayat Pendidikan";
    $arraymenutab[3] = "Publikasi";
    #echo "\t\t\t\r\n\t\t<table width=95% class=menutab>\r\n\t\t\t<tr>\r\n\t";
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
												printmesg("Data Dosen");
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
	#$aksi="formupdate";
        #echo "\r\n\t\t\t\t\t<td align=center><a {$bgtab} href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$k}&idupdate={$idupdate}'>{$v}</td>\r\n\t\t";
		#echo "\r\n\t\t\t\t\t<td align=center><a {$bgtab} href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$k}&idupdate={$idupdate}'>{$v}</td>\r\n\t\t";
		echo "	<li class=\"nav-item\">
					<a {$bgtab} href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$k}&idupdate={$idupdate}'>{$v}</a>";
		echo "</li>";
		$notab++;
    }
    #echo "\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t";
	echo "</ul>";
	echo "<div class=\"tab-content\">";
    if ( $tab == 0 || $tab == "" )
    {
        include( "biodata.php" );
    }
    else
    {
        if ( $tab == 1 )
        {
            include( "riwayatpendidikan.php" );
        }
        else
        {
            if ( $tab == 2 )
            {
                include( "kelulusan.php" );
            }
            else
            {
                if ( $tab == 3 )
                {
                    include( "publikasi.php" );
                }
                else
                {
                    if ( $tab == 4 )
                    {
                        include( "aktivitas.php" );
                    }
                    else
                    {
                        if ( $tab == 5 )
                        {
							$aksi="formupdate";
						#exit();
                            #include( "../mahasiswa/biodata2.php" );
				#include( "biodata2lengkap.php" );
				$idprodi = getfield( "IDDEPARTEMEN", "dosen", " WHERE ID='{$idupdate}'" );
        $namamakul = getfield( "NAMA", "dosen", " WHERE ID='{$idupdate}'" );
        #echo "\r\n<br>\r\n  <table class=form>\r\n     <tr class=judulform>\r\n\t\t\t<td width=150>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$idprodi]."\r\n      </td>\r\n\t\t</tr> \r\n    <tr>\r\n      <td>NIDN Dosen</td>\r\n      <td><b>{$idupdate}</td>\r\n    </tr>\r\n    <tr>\r\n      <td>Nama Dosen</td>\r\n      <td><b>".$namamakul."</td>\r\n    </tr>\r\n    </table>\r\n";
        echo "		<div class=\"m-portlet\">
						<!--begin::Form-->
							<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=\"index.php\" method=\"post\" ENCTYPE='MULTIPART/FORM-DATA'>
							".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tab", "{$tab}", "" )."	
								<div class=\"m-portlet__body\">	";
		echo "						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
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
									include( "biodata2.php" );
		echo "					</div>
							</form>
						</div>";

                        }
                    }
                }
            }
        }
    }
	echo "</div>";
}


?>
