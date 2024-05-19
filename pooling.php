<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function printpooling( )
{
    global $root;
    global $koneksi;
    $q = "SELECT PERTANYAAN,JENIS FROM pooling";
    $hasil = mysqli_query($koneksi, $q);
    $data = mysqli_fetch_array( $hasil );
    $tanya = $data[PERTANYAAN];
    if ( $data[JENIS] == 0 )
    {
        $ketjenis = "Jajak Pendapat ini bersifat <b>Tertutup</b>";
    }
    else
    {
        $ketjenis = "Jajak Pendapat ini bersifat <b>Terbuka</b>";
    }
    $q = "SELECT ID,JAWABAN FROM jawabanpooling";
    $hasil = mysqli_query($koneksi, $q);
    while ( $data = mysqli_fetch_array( $hasil ) )
    {
        $daftarjawab[$data[ID]] = $data[JAWABAN];
    }
    echo "\r\n\r\n\r\n<form action='".$root."isipooling.php' target=_blank method=post>\r\n\r\n\r\n<table cellpadding=2 cellspacing=0\t class='relatedLinks' >\r\n\t<tr valign=top class=judulsubmenu height=19>\r\n\t\t<td class=judulsubmenu ><H3>Jajak Pendapat<H3></td>\r\n\t</tr>\r\n\t<tr><td align=center  class=submenu2>\r\n\t\t<table  class=submenudalam>\r\n\t\t\t<tr valign=top height=30 class=datasubmenudalambesar>\r\n\t\t\t\t<td align=center  >\r\n\t\t\t\t<p>\r\n\t\t\t\t{$tanya}\r\n\t\t\t\t</p>\r\n\t\t\t\t<p>\r\n\t\t\t\t{$ketjenis}\r\n\t\t\t\t</p>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t<tr valign=top>\r\n\t\t\t<td  >";
    foreach ( $daftarjawab as $k => $v )
    {
        echo "\r\n\t\t\t\t\t<input checked class=teksbox type=radio name=pilihan value={$k}> {$v}\r\n\t\t\t\t\t<br>\r\n\t\t\t\t";
    }
    echo "\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</table>\r\n\t</td></tr>\r\n\t<tr valign=top  class=submenu2>\r\n\t\t<td colspan=2 align=center  class=submenu2>\r\n\t\t\t<input style='font-size:7pt;' class=tombol type=submit name=aksi value='  OK  '>\r\n\t\t\r\n\t\t\t<input style='font-size:7pt;' class=tombol type=submit name=aksi value='  Hasil  '>\r\n\t\t</td>\r\n\t</tr>\r\n</table>\r\n</form>\r\n";
    $tanya = "";
    unset( $daftarjawab );
}

periksaroot( );
?>
