<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$root = "";
include( "sesiuser.php" );
include( "header.php" );
printhtml( );
echo "<center>Yth {$namausers}, ";
if ( trim( $aksi ) == "OK" || trim( $aksi ) == "Pilih" )
{
    if ( $namausers == "superadmin" )
    {
        echo "<center> Anda tidak boleh ikut jajak pendapat.<br><br>";
    }
    else
    {
        $q = "SELECT HASILPOOLING FROM user WHERE ID='{$users}'";
        $hasil = mysqli_query($koneksi, $q);
        $data = mysqli_fetch_array( $hasil );
        $jawabanuser = $data[HASILPOOLING];
        if ( $jawabanuser == "" )
        {
            $q = "UPDATE user SET HASILPOOLING={$pilihan} WHERE ID='{$users}'";
            $hasil = mysqli_query($koneksi, $q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                printmesg( "Jawaban Anda telah disimpan di dalam basis data.  Terima kasih atas partisipasi Anda dengan meluangkan waktu untuk mengisi jajak pendapat ini." );
            }
            else
            {
                printmesg( "Jajak pendapat gagal diisi. Ada kesalahan pada basis data." );
            }
        }
        else
        {
            printmesg( "Maaf, Anda sudah pernah mengisi jajak pendapat ini. Terima kasih atas partisipasi Anda." );
        }
    }
    $aksi = "Hasil";
}
if ( trim( $aksi ) == "Hasil" || trim( $aksi ) == "Lihat Hasil" )
{
    $q = "SELECT COUNT(ID) AS HASIL FROM user WHERE ID!='superadmin' AND HASILPOOLING IS NOT NULL";
    $hasil = mysqli_query($koneksi, $q);
    $data = mysqli_fetch_array( $hasil );
    $total = $data[HASIL];
    if ( $total <= 0 )
    {
        printmesg( "Belum ada yang melakukan pemilihan terhadap jajak pendapat" );
    }
    else
    {
        $q = "SELECT PERTANYAAN,JENIS FROM pooling";
        $hasil = mysqli_query($koneksi, $q);
        $data = mysqli_fetch_array( $hasil );
        $pertanyaan = $data[PERTANYAAN];
        $jenispolling = $data[JENIS];
        $q = "SELECT ID,JAWABAN FROM jawabanpooling";
        $hasil = mysqli_query($koneksi, $q);
        while ( $data = mysqli_fetch_array( $hasil ) )
        {
            $q = "SELECT COUNT(HASILPOOLING) AS HASIL FROM user WHERE HASILPOOLING={$data['ID']} AND ID!='superadmin'";
            $h = mysqli_query($koneksi, $q);
            $d = mysqli_fetch_array( $h );
            $hasiljawaban[$data[ID]] = $d[HASIL];
            $daftarjawaban[$data[ID]] = $data[JAWABAN];
        }
        printmesg( "Berikut ini adalah hasil sementara dari jajak pendapat dengan pertanyaan:" );
        printmesg( "<b>{$pertanyaan}</b>" );
        echo "<br>\r\n\t\t\t<table bgcolor=#eeeeff width=400 border=1 \r\n\t\t\t\tstyle='border-collapse:collapse;'>\r\n\t\t\t<tr valign=middle>\r\n\t\t\t<td align=center>\r\n\t\t\t\r\n\t\t\t<table >\r\n\t\t\t<tr height=250 valign=bottom align=center>";
        $h = 0;
        settype( $h, "integer" );
        $c = "A";
        $ii = 0;
        $cc[$ii] = $c;
        foreach ( $daftarjawaban as $k => $v )
        {
            $hasil = $hasiljawaban[$k];
            $h = 250 * $hasiljawaban[$k] / $total;
            $persen = number_format_sikad( 100 * $hasil / $total, 1, 15, "." );
            settype( $h, "integer" );
            echo "\r\n\t\t\t\t<td width=50>\r\n\t\t\t\t\t<font style='font-size:8pt'><b>{$hasil}<br>({$persen}%)<b></font><br>\r\n\t\t\t\t\t";
            if ( 0 < $hasil )
            {
                echo "\r\n\t\t\t\t\t<table border=1 \r\n\t\t\t\t\t\tstyle='border-collapse:collapse;'\r\n\t\t\t\t\t\tbgcolor=#000ff width=100%\r\n\t\t\t\t\t>\r\n\t\t\t\t\t\t<tr height={$h}>\r\n\t\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t\t  &nbsp;\r\n\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table>";
            }
            echo "\r\n\t\t\t\t\t<font style='font-size:11pt'><b> {$c}</b></font>\r\n\t\t\t\t</td>";
            $h = 0;
            $cc[$k] = $c;
            ++$c;
            ++$ii;
        }
        echo "\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\tTotal Responden: {$total}\r\n\t\t\t<br><br>\r\n\t\t\t\r\n\t\t\tKeterangan:<br>\r\n\t\t\t<table><tr>\r\n\t\t\t";
        $c = "A";
        foreach ( $daftarjawaban as $k => $v )
        {
            echo "\r\n\t\t\t\t\r\n\t\t\t\t<td align=left>\r\n\t\t\t\t<b>{$c}</b>: {$v} \r\n\t\t\t\t</td>";
            ++$c;
        }
        echo "</tr></table>";
        if ( $jenispolling == 1 )
        {
            $q = "SELECT ID,NAMA,HASILPOOLING FROM user \r\n\t\t\t\tWHERE ID!='superadmin' \r\n\t\t\t\tAND HASILPOOLING IS NOT NULL\r\n\t\t\t\tORDER BY ID";
            $hasil = mysqli_query($koneksi, $q);
            if ( 0 < mysqli_num_rows( $hasil ) )
            {
                echo "\r\n\t\t\t\t\t<p><table class=data>\r\n\t\t\t\t\t<tr class=juduldata align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t\t<td>ID</td>\r\n\t\t\t\t\t\t<td>Nama</td>\r\n\t\t\t\t\t\t<td>Pilihan</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
                $i = 0;
                while ( $data = mysqli_fetch_array( $hasil ) )
                {
                    ++$i;
                    $kelas = kelas( $i );
                    echo "\r\n\t\t\t\t\t\t\t<tr  {$kelas}>\r\n\t\t\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t\t\t<td>{$data['ID']}</td>\r\n\t\t\t\t\t\t\t\t<td>{$data['NAMA']}</td>\r\n\t\t\t\t\t\t\t\t<td align=center>".$cc[$data[HASILPOOLING]]."</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
                }
            }
        }
        echo "\r\n\r\n\t\t\t</td></tr></table>\r\n";
    }
}
echo "<form action=isipooling.php method=post>\r\n<input class=tombol type=button value='Tutup halaman ini' onClick='window.close();'>\r\n\r\n";
if ( trim( $aksi ) == "OK" || trim( $aksi ) == "Pilih" )
{
    echo "\r\n<input class=tombol name=aksi type=submit value='Lihat Hasil'>\r\n";
}
echo "\r\n</form>\r\n</center>\r\n";
?>
