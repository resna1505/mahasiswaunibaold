<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

cekhaktulis( $kodemenu );
printjudulmenu( "Buat Jajak Pendapat" );
$ok = false;
if ( trim( $aksi ) == "Buat Jajak Pendapat" && $REQUEST_METHOD == POST )
{
    if ( is_array( $daftarjawaban ) && trim( $pertanyaan ) != "" )
    {
        $q = "DELETE FROM pooling";
        mysqli_query($koneksi,$q);
        $q = "DELETE FROM jawabanpooling";
        mysqli_query($koneksi,$q);
        $query = "INSERT INTO pooling VALUES('{$pertanyaan}','{$jenispolling}')";
        $hasil =mysqli_query($koneksi,$query);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            foreach ( $daftarjawaban as $k => $v )
            {
                $query = "INSERT INTO jawabanpooling VALUES({$k},'{$v}')";
               mysqli_query($koneksi,$query);
            }
            $errmesg = "Pembuatan Jajak Pendapat baru berhasil dilakukan. Data Jajak Pendapat yang lama telah dihapus.";
            $q = "UPDATE user SET HASILPOOLING=NULL";
            mysqli_query($koneksi,$q);
        }
        else
        {
            $errmesg = "Pembuatan Jajak Pendapat baru gagal dilakukan. Data Jajak Pendapat yang lama telah dihapus.";
        }
        unset( $daftarjawaban );
        $pertanyaan = "";
        $aksi = "";
    }
    else
    {
        $errmesg = "Pertanyaan belum ada, atau daftar jawaban belum ada.";
    }
}
else if ( trim( $aksi ) == "Update Jajak Pendapat" )
{
    if ( is_array( $daftarjawaban ) )
    {
        foreach ( $daftarjawaban as $k => $v )
        {
            if ( trim( $v ) != "" )
            {
                $daftarjawabant[] = $v;
            }
        }
    }
    $daftarjawaban = $daftarjawabant;
    if ( trim( $jawabanbaru != "" ) )
    {
        $daftarjawaban[] = $jawabanbaru;
    }
}
printmesg( $errmesg );
echo "\t\t\t\t<form action=index.php?pilihan=ptambah method=post>\r\n\t\t\t\t\t<input type=hidden name=pilihan value=ptambah>\r\n\t\t\t\t";
if ( is_array( $daftarjawaban ) )
{
    $jawab = "<p><b>Daftar Jawaban:</b> <br><br>";
    foreach ( $daftarjawaban as $k => $v )
    {
        $jawab .= ( $k + 1 ).". <input type=text class=masukan name=daftarjawaban[{$k}] value='{$v}'><br>";
    }
    $jawab .= "<br>\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t<input class=tombol name=aksi type=submit value='Update Jajak Pendapat'>\r\n\t\t\t\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t\t\t\t\t</p>";
}
$cek0 = "";
$cek1 = "";
if ( $jenispolling == 1 )
{
    $cek1 = "checked";
}
else
{
    $cek0 = "checked";
}
echo "\t\t\t\t\r\n\t\t\t\t\r\n\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td >\r\n\t\t\t\t\t\t\t\tPertanyaan\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<textarea class=masukan name=pertanyaan cols=60 rows=5>";
echo $pertanyaan;
echo "</textarea>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td >\r\n\t\t\t\t\t\t\t\tJenis\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input type=radio name=jenispolling value=0 ";
echo $cek0;
echo ">Tertutup\r\n\t\t\t\t\t\t\t\t<input type=radio name=jenispolling value=1 ";
echo $cek1;
echo ">Terbuka\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td >\r\n\t\t\t\t\t\t\t\tJawaban Baru\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t\t<input type=text class=masukan name=jawabanbaru size=55>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr valign=top>\r\n\t\t\t\t\t\t\t<td colspan=2 >\r\n\t\t\t\t\t\t\t\t<input class=tombol name=aksi type=submit value='Update Jajak Pendapat'>\r\n\t\t\t\t\t\t\t\t<input class=tombol type=reset value=Reset>\r\n\t\t\t\t\t\t\t</td>\r\n\t\t";
echo "\t\t\t\t</tr>\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t";
if ( $pertanyaan == "" )
{
    $pertanyaan = "Belum ada";
}
if ( $jawab == "" )
{
    $jawab = "<p><b>Daftar Jawaban:</b> Belum ada </p>";
}
echo "<hr size=1><p><b>Pertanyaan:</b> {$pertanyaan}</p>".$jawab;
echo "\t\t\t\t\t<hr size=1><input class=tombol name=aksi type=submit value='Buat Jajak Pendapat'>\r\n\t\t\t\t</form>\r\n\r\n\r\n";
?>
