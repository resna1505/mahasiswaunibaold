<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
printjudulmenu( "Pesan yang Terkirim" );
printmesg( $errmesg );
if ( $aksi == "tampilkan" )
{
    echo "\r\n\r\n";
    $q = "SELECT COUNT(ID) AS JML FROM pesant WHERE DARI='{$users}'";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $totalfile = $d[JML];
    if ( $halaman == "" )
    {
        $halaman = 1;
    }
    $perpage = 30;
    $start = ( $halaman - 1 ) * $perpage;
    $jumlahhalaman = $totalfile / $perpage;
    if ( 0 < $totalfile % $perpage )
    {
        ++$jumlahhalaman;
    }
    $jumlahhalaman = floor( $jumlahhalaman );
    if ( 1 < $jumlahhalaman )
    {
        if ( $halaman < $jumlahhalaman )
        {
            $next = "Berikutnya >>";
            $next = "<a href='index.php?aksi={$aksi}&order={$order}&pilihan=klihat&id={$id}&halaman=".( $halaman + 1 )."'>{$next}</a>";
        }
        if ( 1 < $halaman )
        {
            $prev = "<< Sebelumnya";
            $prev = "<a href='index.php?aksi={$aksi}&order={$order}&pilihan=klihat&id={$id}&halaman=".( $halaman - 1 )."'>{$prev}</a>";
        }
    }
    if ( $next != "" || $prev != "" )
    {
        $nav = "\r\n\t\t\t<table class=form>\r\n\t\t\t<tr>\r\n\t\t\t\t<td width=50% align=left>\r\n\t\t\t\t\t{$prev}\r\n\t\t\t\t</td>\r\n\t\t\t\t<td width=50% align=right>\r\n\t\t\t\t\t{$next}\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t";
    }
    unset( $arraysort );
    $arraysort[0] = "pesant.SUBJEK";
    $arraysort[1] = "pesant.DARI";
    $arraysort[2] = "pesant.TANGGAL";
    $arraysort[3] = "pesant.LOKASI";
    if ( $arraysort[$order] == "" )
    {
        $ord = "ORDER BY TANGGAL DESC";
    }
    else if ( $arraysort[$order] == "pesant.TANGGAL" )
    {
        $ord = "ORDER BY TANGGAL DESC";
    }
    else
    {
        $ord = "ORDER BY ".$arraysort[$order]."";
    }
    $q = "SELECT  pesant.ID, KE,   pesant.LOKASI,\r\n\tDATE_FORMAT(TANGGAL,'%d-%m-%Y %h:%i:%s') AS TGL, SUBJEK, DIBACA\r\n\tFROM pesant \r\n\tWHERE  DARI='{$users}'\r\n\t{$ord}\r\n\tLIMIT {$start},{$perpage}";
    $h = mysqli_query($koneksi,$q);
    $token = md5( uniqid( rand( ), true ) );
    $_SESSION['token'] = $token;
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg( "Total Pesan : {$totalfile}<br> {$judulpesan} \r\n\t\tKlik judul pesan untuk melihat isi pesan." );
        $href = "index.php?pilihan=klihat&aksi={$aksi}&halaman={$halaman}";
        echo " {$nav}\r\n\t\t\r\n\t\t\t<table class=form>\r\n\t\t\t<form action=index.php?pilihan=klihat method=post>\r\n\t\t\t\t<input type=hidden name=pilihan value=klihat>\r\n\t\t\t\t<input type=hidden name=halaman value='{$halaman}'>\r\n\t\t\t\t<input type=hidden name=order value='{$order}'>\r\n\t\t\t\t<input type=hidden name=aksilama value='{$aksi}'>\r\n\t\t\t\t<input type=hidden name=sessid value='{$token}'>\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td align=right>\r\n\t\t\t\t\t\t<input type=submit name=aksi class=tombol value=Hapus>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t<table class=data>\r\n\t\t\t\t<tr class=juduldata align=center >\r\n\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t<td><a href='{$href}"."&order=0'>Judul</a></td>\r\n\t\t\t\t\t\r\n\t\t\t\t\t<td><a href='{$href}"."&order=1'>Penerima</a></td>\r\n\t\t\t\t\t<td><a href='{$href}"."&order=2'>Tanggal</a></td>\r\n\t\t\t\t\t<td><a href='{$href}"."&order=3'>Lokasi</a></td>\r\n\t\t\t\t\t<td>Lampiran</td>\r\n\t\t\t\t\t<td >Hapus</td>\r\n\t\t\t\t</tr>\r\n\t\t";
        $i = $start + 1;
        settype( $i, integer );
        while ( $d = sqlfetcharray( $h ) )
        {
            if ( $i % 2 == 0 )
            {
                $kelas = "class=dataganjil";
            }
            else
            {
                $kelas = "class=datagenap";
            }
            if ( $d[DIBACA] == "" )
            {
                $kelas = "class=pesanbaru";
            }
            else
            {
                $kelas = "class=pesanlama";
            }
            $tdaksi = "\r\n\t\t\t\r\n\t\t\t\t<td align=center>\r\n\r\n\t\t\t\t<input type=checkbox name=idhapus[{$i}] value='{$d['ID']}'>\r\n\t\t\t\t<input type=hidden name=lokasipesanhapus[{$i}] value='{$d['LOKASI']}'>\r\n\t\t\t\t</td>\r\n\t\t\t\t";
            $urutanp = $d[ID];
            $lokasip = $d[LOKASI];
            $fileserta = "";
            if ( file_exists( "{$FOLDERFILEPESANT}/{$urutanp}"."_".$lokasip.".txt" ) )
            {
                $logo = file( "{$FOLDERFILEPESANT}/{$urutanp}"."_".$lokasip.".txt" );
                $namafilelama = htmlspecialchars( $logo[0] );
                $fileserta = "<a target=_blank href='dl.php?jenis=1&namafile=".rawurlencode( $logo[0] )."'>".IKONFILE."</a>";
            }
            $tmppenerima = explode( ",", $d[KE] );
            $penerima = "";
            foreach ( $tmppenerima as $k => $v )
            {
                $penerima .= getnama( $v ).", ";
            }
            echo "\r\n\t\t\t<tr valign=top {$kelas}>\r\n\t\t\t\t<td align=center>\r\n\t\t\t\t\t{$i}\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<a href='index.php?pilihan=klihat&aksi=isipesan&id={$d['ID']}&lokasipesan={$d['LOKASI']}' >{$d['SUBJEK']}</a>\r\n\t\t\t\t</td>\r\n\t\t\t\t<td align=center>\r\n\t\t\t\t\t{$penerima}\r\n\t\t\t\t</td>\r\n\t\t\t\t<td align=center nowrap>\r\n\t\t\t\t\t{$d['TGL']}\r\n\t\t\t\t</td>\r\n\t\t\t\t<td align=center>\r\n\t\t\t\t\t".$arraylokasi[$d[LOKASI]]."\r\n\t\t\t\t</td>\r\n\t\t\t\t<td align=center>\r\n\t\t\t\t\t{$fileserta}\r\n\t\t\t\t</td>\r\n\t\t\t\t{$tdaksi}\r\n\t\t\t</tr>\r\n\t\t\t";
            ++$i;
        }
        echo "\r\n\t\t\t</table></form>\r\n\t\t\t{$nav}";
    }
    else if ( $totalfile == 0 )
    {
        printmesg( "{$judulpesan} Daftar pesan tidak ada" );
    }
    else
    {
        printmesg( "{$judulpesan} Daftar pesan tidak ada untuk halaman ini.  Silakan klik menu '".$arraysubmenu[0][Judul]."'" );
    }
    echo "\t\t</form>";
}
else
{
    if ( $aksi == "isipesan" )
    {
        $q = "UPDATE pesant SET DIBACA='Y' WHERE ID='{$id}' AND DARI='{$users}' AND LOKASI='{$lokasipesan}'";
        $h = mysqli_query($koneksi,$q);
        $q = "SELECT  SUBJEK, ISI , KE,\r\n\tDATE_FORMAT(TANGGAL,'%d-%m-%Y %h:%i:%s') AS TGL\r\n\tFROM pesant\r\n\tWHERE pesant.ID='{$id}' AND DARI='{$users}' AND pesant.LOKASI='{$lokasipesan}'";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        $tmppenerima = explode( ",", $d[KE] );
        $penerima = "";
        foreach ( $tmppenerima as $k => $v )
        {
            $penerima .= getnama( $v ).", ";
        }
        $subjek = $d[SUBJEK];
        $isi = $d[ISI];
        $tgl = $d[TGL];
        $t = explode( "\n", $isi );
        foreach ( $t as $v )
        {
            $isit .= "<p>{$v} </p>";
        }
        $isi = $isit;
        if ( file_exists( "{$FOLDERFILEPESANT}/{$id}"."_".$lokasipesan.".txt" ) )
        {
            $logo = file( "{$FOLDERFILEPESANT}/{$id}"."_".$lokasipesan.".txt" );
            $namafilelama = htmlspecialchars( $logo[0] );
            $fileserta = "<a target=_blank href='dl.php?jenis=1&namafile=".rawurlencode( $logo[0] )."'>".$namafilelama."</a>";
            $hfileserta = "<input type=hidden name=fileserta value='{$namafilelama}'>";
        }
        echo "\r\n<form  action=index.php?pilihan=klihat method=post>\r\n<input type=hidden name=pilihan value=kirim>\r\n<input type=hidden name=id value='{$id}'>\r\n<input type=hidden name=lokasipesan value='{$lokasipesan}'>\r\n<table class=form> \r\n<tr valign=top>\r\n\t<td class=judulform>\r\n\t\t<b>Tanggal Kirim\r\n\t</td>\r\n\t<td width=5>\r\n\t\t:\r\n\t</td>\r\n\t<td>\r\n\t\t{$tgl} \r\n\t</td>\r\n</tr>\r\n<tr valign=top>\r\n\t<td>\r\n\t\t<b>Penerima\r\n\t</td>\r\n\t<td>\r\n\t\t:\r\n\t</td>\r\n\t<td>\r\n\t\t{$penerima} \r\n\t</td>\r\n</tr>\r\n<tr valign=top>\r\n\t<td>\r\n\t\t<b>Judul\r\n\t</td>\r\n\t<td>\r\n\t\t:\r\n\t</td>\r\n\t<td>\r\n\t\t{$subjek}\r\n\t</td>\r\n</tr>\r\n<tr valign=top>\r\n\t<td>\r\n\t\t<b>Isi\r\n\t</td>\r\n\t<td>\r\n\t\t:\r\n\t</td>\r\n\t<td>\r\n\t\t{$isi}\r\n\t</td>\r\n</tr>\r\n\r\n<tr valign=top>\r\n\t<td>\r\n\t\t<b>File disertakan\r\n\t</td>\r\n\t<td>\r\n\t\t:\r\n\t</td>\r\n\t<td>\r\n\t\t{$hfileserta}\r\n\t\t{$fileserta}\r\n\t</td>\r\n</tr>\r\n\r\n\r\n<tr valign=top>\r\n\t<td colspan=3>\r\n\t<br>\r\n\t\t<input class=tombol type=submit name=aksi value='Teruskan'>\r\n\r\n\t\t\r\n\t</td>\r\n</tr>\r\n</table>\r\n</form>\r\n\r\n";
    }
}
?>