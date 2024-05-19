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
if ( $aksi == "update" && $REQUEST_METHOD == POST )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Instansi", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasnama( "Judul Program", $judulupdate );
        $vld[] = cekvaliditasfile( "File Gambar Logo", $_FILES['filelogo'], 0 );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
            unset( $vld );
        }
        else
        {
            buatlog( 19, $admin );
            if ( $filelogo != "" )
            {
                if ( isset( $WINDIR ) )
                {
                    $filelogo = str_replace( "\\\\", "\\", $filelogo );
                }
                if ( ( eregi_sikad( "\\.jpg\$", $filelogo_name ) || eregi_sikad( "\\.png\$", $filelogo_name ) || eregi_sikad( "\\.jpeg\$", $filelogo_name ) ) && 0 < $filelogo_size )
                {
                    $namafile = basename( $filelogo_name );
                    $f = fopen( $root."gambar/logo.txt", "w" );
                    fwrite( $f, $namafile, strlen( $namafile ) );
                    fclose( $f );
                    move_uploaded_file( $filelogo, $root."gambar/{$namafile}" );
                }
            }
            if ( trim( $judulupdate ) == "" )
            {
                $errmesg = "Judul Program Harus Diisi";
            }
            else if ( trim( $namakantorupdate ) == "" )
            {
                $errmesg = "Nama Kantor Harus Diisi";
            }
            else
            {
                $query = "UPDATE sistem\r\n\t\t\t\t\t\t\tSET \r\n\t\t\t\t\t\t\tJUDUL='{$judulupdate}', \r\n\t\t\t\t\t\t\tALAMAT='{$alamatupdate}', \r\n\t\t\t\t\t\t\tNAMA='{$namakantorupdate}', \r\n\t\t\t\t\t\t\tNAMA2='{$namakantorupdate2}', \r\n\t\t\t\t\t\t\tLOKASI={$lokasisistem},\r\n\t\t\t\t\t\t\tCSS='{$csssistem}',\r\n\t\t\t\t\t\t\t LASTUPDATE=NOW(),UPDATER='{$users}'";
               mysqli_query($koneksi,$query);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $errmesg = "Data sistem berhasil diupdate";
                }
                else
                {
                    $errmesg = "Data sistem tidak diupdate";
                }
            }
        }
    }
}
$query = "SELECT JUDUL,NAMA,NAMA2,ALAMAT,LOKASI,CSS,\r\n DATE_FORMAT(LASTUPDATE,'Tanggal %d-%m-%Y Jam %H:%i:%s') AS LASTUP, \r\n UPDATER\r\n\tFROM sistem";
$hasil =mysqli_query($koneksi,$query);
$datasistem = sqlfetcharray( $hasil );
$query = "SELECT ID, NAMA FROM user WHERE ID='".$datasistem[UPDATER]."'";
$hasil =mysqli_query($koneksi,$query);
$dataupdater = sqlfetcharray( $hasil );
$judulupdate = $datasistem[JUDUL];
$alamatupdate = $datasistem[ALAMAT];
$namakantorupdate = $datasistem[NAMA];
$namakantorupdate2 = $datasistem[NAMA2];
$lokasisistem = $datasistem[LOKASI];
$css = $datasistem[CSS];
printjudulmenu( "Data Instansi" );
printmesg( $errmesg );
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
echo "<form ENCTYPE=\"MULTIPART/FORM-DATA\" action=index.php?pilihan=update method=post>\r\n<input type=hidden name=aksi value=update>\r\n<input type=hidden name=sessid value=";
echo $token;
echo ">\r\n<input type=hidden name=pilihan value=update>\r\n<table class=form>\r\n\r\n\t<tr>\r\n\t\t<td class=judulform>Judul Program\r\n\t\t</td>\r\n\t\t<td><input type=text class=masukan size=60 name=judulupdate value='";
echo $judulupdate;
echo "'>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td width=200>Nama Kantor\r\n\t\t</td>\r\n\t\t<td><input type=text class=masukan size=60 name=namakantorupdate value='";
echo $namakantorupdate;
echo "'>\r\n\t\t<br><input type=text class=masukan size=60 name=namakantorupdate2 value='";
echo $namakantorupdate2;
echo "'>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td>Alamat\r\n\t\t</td>\r\n\t\t<td><input type=text class=masukan size=50 name=alamatupdate value='";
echo $alamatupdate;
echo "'>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td>Lokasi\r\n\t\t</td>\r\n\t\t<td>\r\n \r\n\t\t";
echo "<s";
echo "elect name=lokasisistem class=masukan>\r\n\t\t";
foreach ( $arraylokasi as $k => $v )
{
    if ( $k == $lokasisistem )
    {
        $selected = "selected";
    }
    echo "<option value={$k} {$selected}>{$v}</option>";
    $selected = "";
}
echo "\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr  valign=top>\r\n\t\t<td>File Gambar Logo\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t(Khusus file jpeg/jpg/png)<br><input type=file class=masukan size=45 name=filelogo>\r\n\t\t<br>\r\n\t\t<br>\r\n\t\t";
if ( file_exists( $root."gambar/logo.txt" ) )
{
    $logo = file( $root."gambar/logo.txt" );
    echo "Logo saat ini:  <img width=150 src='".$root."gambar/{$logo['0']}'  align=center border=1> ";
}
else
{
    echo "File logo belum ada.";
}
echo "\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td>Tampilan Depan\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t";
echo "<s";
echo "elect name=csssistem class=masukan>\r\n\t\t";
foreach ( $arraycss as $k => $v )
{
    if ( $k == $css )
    {
        $selected = "selected";
    }
    echo "<option value={$k} {$selected}>{$v}</option>";
    $selected = "";
}
echo "\t\t</select>\r\n\t\t</td>\r\n\t</tr>\r\n\r\n\t<tr>\r\n\t\t<td class=judulform>VERSI\r\n\t\t</td>\r\n\t\t<td>";
echo VERSI_SIKAD;
echo "\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td colspan=2>\r\n\t\t";
echo IKONUPDATE48;
echo "\t\t\t<input class=tombol type=submit value=\"Simpan\">\r\n\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t</td>\r\n\t</tr>\r\n</table>\r\n</form>\r\n\r\n<table class=form>\r\n<tr><td align=center>\r\nUpdate terakhir:  ";
echo $datasistem[LASTUP];
echo " oleh ";
echo printid( $dataupdater[ID] );
echo " ( ";
echo $dataupdater[NAMA];
echo " )\r\n</td></tr></table>\r\n";
?>
