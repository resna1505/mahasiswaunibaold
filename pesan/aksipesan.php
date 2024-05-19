<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( ( $aksi == "hapus" || $aksi == "Hapus" ) && $REQUEST_METHOD == POST )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Pesan", HAPUS_DATA );
        unset( $_SESSION['token'] );
    }
    else if ( is_array( $idhapus ) )
    {
        $fieldke = "KE";
        if ( $pilihan == "klihat" )
        {
            $t = "t";
            $fieldke = "DARI";
        }
        $jml = 0;
        foreach ( $idhapus as $k => $id )
        {
            $q = "DELETE FROM pesan{$t} WHERE ID='{$id}' AND {$fieldke}='{$users}' AND LOKASI='".$lokasipesanhapus[$k]."'";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                if ( file_exists( "{$FOLDERFILEPESAN}{$t}/{$id}"."_".$lokasipesanhapus[$k].".txt" ) )
                {
                    $logo = file( "{$FOLDERFILEPESAN}{$t}/{$id}"."_".$lokasipesanhapus[$k].".txt" );
                    $namafilelama = htmlspecialchars( $logo[0] );
                    @unlink( @"{$FOLDERFILEPESAN}{$t}/{$namafilelama}" );
                    @unlink( @"{$FOLDERFILEPESAN}{$t}/{$id}"."_".@$lokasipesanhapus[$k].".txt" );
                }
                ++$jml;
            }
        }
        if ( 0 < $jml )
        {
            $errmesg = "{$jml} pesan berhasil dihapus";
        }
        else
        {
            $errmesg = "Pesan tidak dihapus";
        }
    }
    else if ( $id != "" )
    {
        $q = "DELETE FROM pesan{$t} WHERE ID='{$id}' AND KE='{$users}' AND LOKASI='{$lokasipesan}'";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            if ( file_exists( "{$FOLDERFILEPESAN}{$t}/{$id}"."_".$lokasipesan.".txt" ) )
            {
                $logo = file( "{$FOLDERFILEPESAN}{$t}/{$id}"."_".$lokasipesan.".txt" );
                $namafilelama = htmlspecialchars( $logo[0] );
                @unlink( @"{$FOLDERFILEPESAN}{$t}/{$namafilelama}" );
                @unlink( @"{$FOLDERFILEPESAN}{$t}/{$id}"."_".@$lokasipesan.".txt" );
            }
            $errmesg = "Pesan berhasil dihapus";
        }
        else
        {
            $errmesg = "Pesan tidak dihapus";
        }
    }
    $aksi = tampilkan;
}
if ( $aksi == "Kirim" && $REQUEST_METHOD == POST )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Pesan", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        if ( $pilihanke == "orang" )
        {
            $vld[] = cekvaliditasnama( "ID", $ke, 64, false );
        }
        $vld[] = cekvaliditasnama( "Isi", $isi );
        $vld[] = cekvaliditasfile( "File", $_FILES['fileupload'] );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
        }
        else
        {
            $fileok = false;
            if ( trim( $ke ) == "" && $pilihanke == "orang" )
            {
                $errmesg = "ID Tujuan harus diisi";
            }
            else if ( trim( $subjek ) == "" )
            {
                $errmesg = "Judul harus diisi";
            }
            else
            {
                if ( trim( $isi ) == "" )
                {
                    $errmesg = "Isi pesan harus diisi";
                }
                else
                {
                    if ( $pilihanke == "orang" )
                    {
                        $dke = explode( ",", $ke );
                    }
                    else if ( $pilihanke == "superadmin" )
                    {
                        $dke[0] = "superadmin";
                    }
                    else if ( $pilihanke == "pimpinan" )
                    {
                        $q = "SELECT ID FROM user WHERE JABATAN=0";
                        $h = mysqli_query($koneksi,$q);
                        if ( 0 < sqlnumrows( $h ) )
                        {
                            $d = sqlfetcharray( $h );
                            $dke[] = $d[ID];
                        }
                    }
                    else if ( $pilihanke == "semuaperbidang" )
                    {
                        do
                        {
                            $where = " AND BIDANG='{$bidangpesansemua}'";
                            $q = "SELECT ID FROM user WHERE 1=1 {$where}";
                            $h = mysqli_query($koneksi,$q);
                        } while ( 0 );
                        do
                        {
                            if ( !( 0 < sqlnumrows( $h ) ) || !( $d = sqlfetcharray( $h ) ) )
                            {
                                $dke[] = $d[ID];
                                break;
                            }
                        } while ( 1 );
                    }
                    if ( is_array( $dke ) )
                    {
                        $ii = 0;
                        $i = 0;
                        foreach ( $dke as $ke )
                        {
                            ++$i;
                            $ke = htmlspecialchars( trim( $ke ) );
                            $subjek = htmlspecialchars( trim( $subjek ) );
                            $isi = htmlspecialchars( trim( $isi ) );
                            $q = "SELECT ID,NAMA FROM user WHERE ID='{$ke}'";
                            $h = mysqli_query($koneksi,$q);
                            if ( 0 < sqlnumrows( $h ) )
                            {
                                $d = sqlfetcharray( $h );
                                $namatujuan = $d[NAMA];
                                $q = "SELECT ID FROM pesan WHERE DARI='{$users}' AND KE='{$ke}' \r\n\t\t\t\t\tAND SUBJEK='{$subjek}' AND ISI='{$isi}' AND LOKASI={$idlokasikantor}";
                                $h = mysqli_query($koneksi,$q);
                                if ( 0 < sqlnumrows( $h ) )
                                {
                                    $errmesg = "Pesan sudah pernah dikirim";
                                }
                                else
                                {
                                    $q = "SELECT MAX(ID)+1 AS JML FROM pesan WHERE LOKASI='{$idlokasikantor}'";
                                    $h = mysqli_query($koneksi,$q);
                                    $d = sqlfetcharray( $h );
                                    if ( $d[JML] == "" )
                                    {
                                        $d[JML] = 0;
                                    }
                                    $q = "INSERT INTO pesan \r\n\t\t\t\t\t\tVALUES({$d['JML']},'{$users}','{$ke}','{$subjek}','{$isi}',NOW(),NULL,{$idlokasikantor},'0')";
                                    $h = mysqli_query($koneksi,$q);
                                    if ( 0 < sqlaffectedrows( $koneksi ) )
                                    {
                                        $fileok = true;
                                        if ( $simpan == 1 )
                                        {
                                            $q = "INSERT INTO pesant \r\n\t\t\t\t\t\t\t\tVALUES({$d['JML']},'{$users}','{$ke}','{$subjek}','{$isi}',NOW(),NULL,{$idlokasikantor})";
                                            $h = mysqli_query($koneksi,$q);
                                        }
                                        $urutan = $d[JML];
                                        if ( $fileok )
                                        {
                                            if ( $fileupload != "none" && $fileupload != "" )
                                            {
                                                if ( $fileupload_size <= $maxsize * 1000000 )
                                                {
                                                    if ( isset( $WINDIR ) )
                                                    {
                                                        $fileupload = str_replace( "\\\\", "\\", $fileupload );
                                                    }
                                                    $namafile = basename( $fileupload_name );
                                                    if ( ereg_sikad( ".php\$", $namafile ) || ereg_sikad( ".php3\$", $namafile ) || ereg_sikad( ".asp\$", $namafile ) || ereg_sikad( ".html\$", $namafile ) || ereg_sikad( ".htm\$", $namafile ) || ereg_sikad( ".jsp\$", $namafile ) )
                                                    {
                                                        $namafile .= ".txt";
                                                    }
                                                    if ( file_exists( "{$FOLDERFILEPESAN}/{$urutan}"."_"."{$idlokasikantor}".".txt" ) )
                                                    {
                                                        $logo = file( "{$FOLDERFILEPESAN}/{$urutan}"."_"."{$idlokasikantor}"."..txt" );
                                                        $namafilelama = $logo[0];
                                                        @unlink( @"{$FOLDERFILEPESAN}/{$namafilelama}" );
                                                    }
                                                    if ( file_exists( "{$FOLDERFILEPESAN}/{$namafile}" ) )
                                                    {
                                                        $namafile = $urutan."_".$idlokasikantor."_".$namafile;
                                                    }
                                                    $f = fopen( "{$FOLDERFILEPESAN}/{$urutan}"."_"."{$idlokasikantor}".".txt", "w" );
                                                    fwrite( $f, $namafile, strlen( $namafile ) );
                                                    fclose( $f );
                                                    if ( $simpan == 1 )
                                                    {
                                                        if ( file_exists( "{$FOLDERFILEPESANT}/{$namafile}" ) )
                                                        {
                                                            $namafile = $urutan."_".$idlokasikantor."_".$namafile;
                                                        }
                                                        $f = fopen( "{$FOLDERFILEPESANT}/{$urutan}"."_"."{$idlokasikantor}".".txt", "w" );
                                                        fwrite( $f, $namafile, strlen( $namafile ) );
                                                        fclose( $f );
                                                    }
                                                    if ( $i == 1 )
                                                    {
                                                        move_uploaded_file( $fileupload, "{$FOLDERFILEPESAN}/{$namafile}" );
                                                        $namafileasli = $namafile;
                                                    }
                                                    else
                                                    {
                                                        @copy( @"{$FOLDERFILEPESAN}/{$namafileasli}", @"{$FOLDERFILEPESAN}/{$namafile}" );
                                                    }
                                                    if ( $simpan == 1 )
                                                    {
                                                        @copy( @"{$FOLDERFILEPESAN}/{$namafile}", @"{$FOLDERFILEPESANT}/{$namafile}" );
                                                    }
                                                }
                                            }
                                            else if ( $fileserta != "" )
                                            {
                                                $namafilelama = $fileserta;
                                                $namafile = $urutan."_".$idlokasikantor."_".$namafilelama;
                                                $f = fopen( "{$FOLDERFILEPESAN}/{$urutan}"."_"."{$idlokasikantor}".".txt", "w" );
                                                fwrite( $f, $namafile, strlen( $namafile ) );
                                                fclose( $f );
                                                if ( $simpan == 1 )
                                                {
                                                    $f = fopen( "{$FOLDERFILEPESANT}/{$urutan}"."_"."{$idlokasikantor}".".txt", "w" );
                                                    fwrite( $f, $namafile, strlen( $namafile ) );
                                                    fclose( $f );
                                                }
                                                @copy( @"{$FOLDERFILEPESANT}/{$namafilelama}", @"{$FOLDERFILEPESAN}/{$namafile}" );
                                                if ( $simpan == 1 )
                                                {
                                                    @copy( @"{$FOLDERFILEPESANT}/{$namafilelama}", @"{$FOLDERFILEPESANT}/{$namafile}" );
                                                }
                                            }
                                        }
                                        $errmesg .= "Pesan Anda berhasil dikirim ke pegawai dengan ID '{$ke}' ({$namatujuan}) <br>";
                                        $ok = true;
                                    }
                                    else
                                    {
                                        $errmesg .= "Pesan Anda tidak berhasil dikirim ke pegawai dengan ID '{$ke}' <br>";
                                        $ok = false;
                                    }
                                    $fileok = false;
                                }
                            }
                            else
                            {
                                $errmesg .= "Tidak ada pegawai dengan ID = '{$ke}' <br>";
                                $ok = false;
                            }
                        }
                        if ( $ok )
                        {
                            $ke = "";
                            $subjek = "";
                            $isi = "";
                        }
                    }
                    else
                    {
                        $errmesg = "Pesan tidak berhasil dikirim";
                    }
                }
            }
        }
    }
    $fileserta = "";
    $aksi = "kirim";
}
?>
