<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "update" && $REQUEST_METHOD == POST )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        #cekhaktulis( $kodemenu );
        $q = "SHOW FULL COLUMNS FROM {$NAMATABELBEBAS}";
		echo $q.'<br>';exit();
        $h = mysqli_query($koneksi,$q);
        if ( 1 < sqlnumrows( $h ) )
        {
            $q = "UPDATE {$NAMATABELBEBAS} SET";
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
			echo $q;exit();
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
    }
}
if ( $aksi == "formupdate" )
{
    printmesg( $errmesg );
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    #cekhaktulis( $kodemenu );
    $q = "SELECT  {$NAMATABELBEBAS}.* FROM {$NAMATABEL},{$NAMATABELBEBAS}  WHERE \r\n\t{$NAMATABELBEBAS}.ID='{$idupdate}' AND {$NAMATABEL}.ID={$NAMATABELBEBAS}.ID\r\n \t";
    $h = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $h ) <= 0 )
    {
        $q = "INSERT INTO {$NAMATABELBEBAS} (ID) VALUES ('{$idupdate}')";
        mysqli_query($koneksi,$q);
        $q = "SELECT  {$NAMATABELBEBAS}.* FROM {$NAMATABEL},{$NAMATABELBEBAS}  WHERE \r\n  \t{$NAMATABELBEBAS}.ID='{$idupdate}' AND {$NAMATABEL}.ID={$NAMATABELBEBAS}.ID\r\n   \t";
        $h = mysqli_query($koneksi,$q);
    }
    $dm = sqlfetcharray( $h );
    #echo "\r\n\t\t<br>\r\n\t\t<form name=form action=index.php method=post  ENCTYPE='MULTIPART/FORM-DATA'>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tab", "{$tab}", "" );
    $q = "SHOW FULL COLUMNS FROM {$NAMATABELBEBAS}";
	#echo $q.'<br>';
    $h = mysqli_query($koneksi,$q);
    if ( 1 < sqlnumrows( $h ) )
    {
		#echo "kesini";		
        while ( $d = sqlfetcharray( $h ) )
        {
            if ( $d[0] != "ID" )
            {
                $kelas = kelas( $i );
                ++$i;
                $atribut = $contohtampilan = "";
                $hasil = getmetadata( $d );
                $tipe = $hasil[tipe];
                $hasil = getmetadata( $d, "{$d['0']}", $dm["{$d['0']}"] );
                $atribut = $hasil[atribut];
                $contohtampilan = $hasil[contohtampilan];
                if ( $hasil[tipe] != 99 )
                {
                    #echo "\r\n            <tr valign=top {$kelas} >\r\n               <td width=150> ".ucfirst( strtolower( str_replace( "_", " ", $d[0] ) ) )." </td>\r\n              <td>";
                    echo "		<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">".ucfirst( strtolower( str_replace( "_", " ", $d[0] ) ) )."</label>";
					if ( $hasil[tipe] == 6 )
                    {
                        $nilai = $dm["{$d['0']}"];
                        if ( $nilai != "" && file_exists( $FOLDERFILE."/{$nilai}" ) )
                        {
                            echo "\r\n                  <img src='lihat.php?id={$idupdate}&field={$d['0']}' width=200> \r\n                   <br>";
                        }
                    }
                    else if ( $hasil[tipe] == 7 )
                    {
                        $nilai = $dm["{$d['0']}"];
                        if ( $nilai != "" && file_exists( $FOLDERFILE."/{$nilai}" ) )
                        {
                            echo "<a target=_blank href='lihat.php?id={$idupdate}&field={$d['0']}&jenis=1'  >download</a> <br>";
                        }
                    }
                    #echo "\r\n              \r\n              {$contohtampilan}  </td>\r\n            </tr>\r\n            ";
					echo "		<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
									{$contohtampilan}
								</label>";
                }
                else
                {
                    #echo "\r\n            <tr valign=top {$kelas} >\r\n                <td colspan=2 nowrap>{$contohtampilan}</td>\r\n            </tr>\r\n            ";
					echo "		<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
									{$contohtampilan}
								</label>";
				}
				echo "</div>";
            }
        }
        #echo "\r\n    \t\t\t<tr>\r\n  \t\t\t\t<td colspan=2>\r\n\t\t\t\t".IKONUPDATE48."\r\n  \t\t\t\t\t<input type=submit value='Update' class=masukan>\r\n  \t\t\t\t\t<input type=reset value='Reset' class=masukan>\r\n  \t\t\t\t</td>\r\n  \t\t\t</tr>\r\n  \t\t\t</table>";
		echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
							<div class=\"col-lg-6\">
								<input type=submit value='Update' class=\"btn btn-brand\">\r\n  \t\t\t\t\t<input type=reset value='Reset' class=\"btn btn-secondary\">
							</div>
						</div>";
	}
    #echo "\r\n\t\t\t</form>\r\n \t\t";
}
?>
