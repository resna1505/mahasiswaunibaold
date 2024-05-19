<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function printheader( )
{
    global $jenisusers;
    global $namaprogram;
    global $users;
    global $namausers;
    global $arraybulan;
    global $arrayhari;
    global $alamat;
    global $judul;
    global $namakantor;
    global $namakantor2;
    global $root;
    global $HTTP_HOST;
    global $style;
    global $koneksi;
    global $dirgambar;
    global $tabellatar;
    global $borderdata;
    global $bghead;
    global $fnhead;
    global $HTTP_USER_AGENT;
    global $_SESSION;
    echo "\r\n    <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n    <html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n    <head>\r\n    <title>{$namaprogram} </title>\t\r\n    \r\n \r\n    ";
    include( $root."javascript.js" );
    echo "<script src='".$root."/tampilan/lib/jquery-1.4.min.js' type='text/javascript' charset='utf-8'></script>";
    echo "<script src='".$root."/tampilan/lib/script_luar.js' type='text/javascript'></script>";
    echo "<script src='".$root."/tampilan/lib/jquery.autocomplete.js' type='text/javascript'></script>";
    echo "<link rel=\"stylesheet\" href=\"".$root."css/style.css\" type=\"text/css\" />";
    include( $root."tampilan/jam.php" );
    echo "\r\n            </head>\r\n    \r\n    <link rel='shortcut icon' href='".$root."images/favicon.png' type='image/x-icon' />\r\n    \r\n    <body  onLoad='startclock()'  >\r\n    <div id=\"wrap\">\r\n    ";
   # include( $root."tampilan/siteheader.php" );
}

function printmesg( $errmesg )
{
    if ( $errmesg != "" )
    {
        echo "<p class=\"alert\">{$errmesg}</p>";
    }
}

function printheader_dlm( )
{
	#echo "aaaa";exit();
    global $jenisusers;
    global $namaprogram;
    global $users;
    global $namausers;
    global $arraybulan;
    global $arrayhari;
    global $alamat;
    global $judul;
    global $namakantor;
    global $namakantor2;
    global $root;
    global $HTTP_HOST;
    global $style;
    global $koneksi;
    global $dirgambar;
    global $tabellatar;
    global $borderdata;
    global $bghead;
    global $fnhead;
    global $HTTP_USER_AGENT;
    global $_SESSION;
    echo "\r\n        <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n        <html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n        <head>\r\n        <title>{$namaprogram} </title>\r\n        <link rel='shortcut icon' href='".$root."images/favicon.png' type='image/x-icon' />\t\r\n\t\t";
    include( $root."javascript.js" );
    echo "<link rel=\"stylesheet\" href=\"".$root."tampilan/lib/style_main.css\" type=\"text/css\" />";
    echo "<script type='text/javascript' src='".$root."tampilan/lib/multilevel.dropdown.js'></script>";
    echo "<script src='".$root."/tampilan/lib/jquery-1.4.min.js' type='text/javascript' charset='utf-8'></script>";
    echo "<script src='".$root."/tampilan/lib/script.js' type='text/javascript'></script>";
    echo "\r\n        </head>\r\n        <body  onLoad='startclock()'  >\r\n        <div id=\"wrap\">\r\n        ";
    include( $root."tampilan/siteheader_dlm.php" );
}

function printmenudropdown( $arraymenu )
{
    global $tingkataksesusers;
    global $tingkatakses;
    global $tingkats;
    global $arraykelompokmenu;
    global $JUDULFAKULTAS;
    global $tingkats;
    global $tingkataksesusers;
    global $users;
    global $borderdata;
    global $root;
    global $arrayikonsubmenu;
    global $jenisusers;
    include( $root."unik.php" );
    $jumlahmenu = count( $arraymenu );
    $ii = 0;
    $tmp = "\r\n        <!-- navigator -->\r\n        <div id='navigator'>\r\n        <ul class='menu' id='menu'>\t\t\t\t \r\n        ";
    foreach ( $arraykelompokmenu as $kk => $vv )
    {
        $kelas = kelasmenu( $ii );
        $tmpx = "";
        $tmpx .= "\r\n\t             <li><a href='#' class='menulink'>{$vv}</a><ul>\r\n                 ";
        $k = 0;
        foreach ( $arraymenu as $i => $v )
        {
            if ( $v[k] != $kk )
            {
                continue;
            }
            $bolehdiakses = false;
            if ( $v[t] != "" && $tingkataksesusers[$v[t]] != "" )
            {
                $bolehdiakses = true;
            }
            if ( session_is_registered_sikad( "tingkats" ) && ( $bolehdiakses || $v[t] == "" ) )
            {
                $tmpx .= " <li> <a href='../{$v['href']}'  class='sub'>{$v['Judul']} </a>";
                unset( $arraysubmenu );
                $filesubmenu = "../".str_replace( "index.php", "", $v[href] )."/submenu.php";
                $dirsubmenu = "../".str_replace( "index.php", "", $v[href] )."";
                if ( file_exists( $filesubmenu ) )
                {
                    include( "../".str_replace( "index.php", "", $v[href] )."/submenu.php" );
                    if ( is_array( $arraysubmenu ) )
                    {
                        $tmpx .= " <ul> ";
                        foreach ( $arraysubmenu as $k => $v )
                        {
                            if ( $v[t] == "T" && $tingkataksesusers[$kodemenu] != "T" )
                            {
                            }
                            else if ( $v[href] != "" )
                            {
                                $tmpx .= " <li><a href='".$dirsubmenu."{$v['href']}'>".$arrayikonsubmenu[$v[ico]]." {$v['Judul']}</a></li>";
                            }
                        }
                        $tmpx .= " </ul> ";
                    }
                }
                $tmpx .= " </li> ";
                ++$k;
                ++$j;
            }
        }
        $tmpx .= "</ul></li>";
        $tmp .= $tmpx;
        ++$ii;
    }
    $tmp .= "        \r\n        </ul>\r\n        </div>\r\n        <script type='text/javascript'>\r\n        var menu=new menu.dd('menu');\r\n        menu.init('menu','menuhover');\r\n        </script>\r\n\t   ";
    echo $tmp;
}

function createsubmenu( $judul, $kode, $arraysubmenu )
{
    global $tingkats;
    global $tingkataksesusers;
    global $users;
    global $borderdata;
    global $root;
    global $arrayikonsubmenu;
    echo "\r\n         <div class='submenu'>\r\n         <h2 class='titlebar'>{$judul}</h2>\r\n         <ul class='leftnav'>\r\n         ";
    $j = 0;
    foreach ( $arraysubmenu as $i => $v )
    {
        if ( !isangka( $i ) )
        {
            $hasil = "</ul><h2 class='titlebarbottom'>{$v['Judul']}</h2><ul class='leftnav'>";
        }
        else
        {
            $hasil = "<li> <a href='{$v['href']}' >".$arrayikonsubmenu[$v[ico]]." {$v['Judul']}</a></li>";
        }
        if ( $v[t] == "T" && $tingkataksesusers[$kode] != "T" )
        {
            continue;
        }
        if ( session_is_registered_sikad( "tingkats" ) )
        {
            echo " {$hasil}  ";
            ++$j;
        }
    }
    echo "</ul></div>";
}

function printfooter_dlm( )
{
    echo "\r\n         <!-- footer -->\r\n         <div id=\"footer\">\r\n         <p class=\"textfoot\">Sistem Informasi dan Manajemen Akademik © Suteki-Tech (<a href=\"#\"> www.suteki.co.id </a>). Saran dan kritik yang membangun, kirimkan ke info@suteki.co.id\r\n         </p>\r\n         </div>\r\n         <!-- end footer -->\r\n         ";
}

function printjudulmenu( $judul, $idbantuan = "", $ikon = "" )
{
    echo "\r\n        <div class='titlecontent'>\r\n            \r\n            <h2 class='titlepostcontent'>".strtoupper( $judul )."</h2>\r\n        </div>\r\n        <div class='postcontent'>   \r\n    ";
}

function printjudul( $judul )
{
    global $koneksi;
    global $tabellatar;
    global $namausers;
    global $users;
    global $arraykomponenpembayaran2;
    global $jenisusers;
    global $angkatanusers;
    global $prodiusers;
    global $arrayjeniskomponenpembayaran;
    global $waktu;
    global $arraysemester;
    if ( $users != "" )
    {
        $q = "SELECT COUNT(ID) AS JML FROM pesan WHERE KE = '{$users}' AND DIBACA IS NULL";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        $jumlahpesan = $d[JML];
        if ( $jumlahpesan != "" && 0 < $jumlahpesan )
        {
            $pesan = ". Anda mendapatkan <b>{$jumlahpesan} <a href='../pesan/index.php'>pesan baru</a></b>\r\n\t\t";
        }
        $q = "SELECT COUNT(ID) AS JML FROM pesan WHERE KE = '{$users}' AND ALERT ='0'";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        $jumlahpesana = $d[JML];
        if ( $jumlahpesana != "" && 0 < $jumlahpesana )
        {
            $pesan .= "\r\n\t\t<script language='Javascript' type=\"text/javascript\">\r\n\t\t\talert('Anda mendapatkan {$jumlahpesan} pesan baru. Silakan dibaca. Terima kasih');\r\n\t\t</script>\r\n\t\t";
            $q = "UPDATE pesan SET ALERT='1' WHERE KE = '{$users}' AND ALERT ='0'";
            $h = mysqli_query($koneksi,$q);
        }
        echo "\r\n        <!-- topheader --> \r\n    \t<div id='topheader'>\r\n        \t<ul class='rightlink'>\r\n            \t<li>selamat datang <strong> {$namausers} ( ".printid( $users )." ) </strong>{$pesan}</li>\r\n                <li><a href='#'>selasa, 05 November 2010</a></li>\r\n                <li><a class=\"red\" href='index.php?aksi=logout'><b>[ Logout ]</b></a></li>\r\n            </ul>\r\n        </div>\r\n        <!-- end topheader -->\r\n\t    ";
        if ( $pesanbayar != "" )
        {
            echo "\r\n\t\t\t<div id='welcome2'><center>{$pesanbayar} </div>\r\n\t\t";
        }
    }
}

function printjudulmenucetak( $judul )
{
    echo "\r\n\t<h2 class='judulmenucetak'>\r\n\t\t{$judul}\r\n\t</h2>\r\n<div class='postcontent'> \r\n\t";
}

function printjudulmenukecil( $judul )
{
    echo "\r\n\t<p>\r\n\t<table class=judulmenukecil>\r\n\t\t<tr align=left>\r\n\t\t\t<td>\r\n\t\t\t{$judul}\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</table>\r\n\t</p>\r\n   \r\n\t";
}

function cetakpimpinan( )
{
    global $koneksi;
    global $arraybulan;
    global $arraylokasi;
    global $idlokasikantor;
    global $waktu;
    global $namakantor;
    $q = "select NIP,NAMA FROM user WHERE JABATAN=0";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $nama = $d[NAMA];
        $nip = $d[NIP];
    }
    echo "\r\n<br><br>\r\n\t<table width=100%>\t\r\n\t<tr><td width=40%></td>\r\n\t<td>\r\n\t".$arraylokasi[$idlokasikantor].", {$waktu['mday']} ".$arraybulan[$waktu[mon] - 1]." {$waktu['year']}\r\n\t</td></tr>\r\n\t<tr><td></td><td>\r\n\t{$namakantor} \r\n\t</td></tr>\r\n\t<tr><td></td><td>\r\n\tKepala, \r\n\t</td></tr>\r\n\t<tr><td></td><td>\r\n\t<BR><BR><BR>\r\n\t</td></tr>\r\n\t<tr><td></td><td>\r\n\t<u>{$nama}</u><br>\r\n\tNIP. {$nip}\r\n\t</td></tr>\r\n\t</table>\r\n\t";
}

function printjudul2( $judul )
{
    global $tabeljudul;
    if ( $judul != "" )
    {
        echo "\r\n\t<table width=100% {$tabelpengumuman}>\r\n\t\t<tr valign=middle>\r\n\t\t\t<td >\r\n\t\t\t\t<font  style='font-size:10pt;font-family: Arial;'><b>{$judul}</b></font>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</table>\r\n\t";
    }
}

function printfooter( )
{
    global $root;
    global $tabelisian3;
    global $versi;
    global $namaprogram;
    include( $root."tampilan/footer.php" );
    mysql_close( );
}

function printjudulmenulama( $judul, $idbantuan = "", $ikon = "" )
{
    global $root;
    global $CSS_IKON_FOLDER;
    echo "\r\n\t<div id=\"pageName\">\r\n\t <table  >\r\n\t <tr>\r\n\t <td>\r\n    <h2 class='judulmenu'>".strtoupper( $judul )." </h2>\r\n    ";
    if ( $idbantuan != "" )
    {
        echo "\r\n      </td><td align=right>\r\n        <a href=# onclick=\"showhide('{$idbantuan}');\">\r\n        <img src='".$root."/".$CSS_IKON_FOLDER."tanya.png' height=30 border=0>\r\n        </a>\r\n      ";
    }
    echo "\r\n    </td></tr>\r\n    </table>\r\n\t\t</div>\r\n\t";
}

function printhelp( $string, $id = "bantuan", $display = "" )
{
    if ( $display == "" )
    {
        $disp = "style='display:none;'";
    }
    echo "\r\n  <div id='{$id}' {$disp}>\r\n  <table class=form cellpadding=4 cellspacing=2 width=95% border=1 style='background-color:#DDFFDD;'>\r\n    <tr>\r\n      <td>".nl2br( $string )."</td>\r\n    </tr>\r\n  </table>\r\n  <br>\r\n  </div>\r\n";
}

function printmesgcetak( $errmesg )
{
    if ( $errmesg != "" )
    {
        echo "\r\n\t<p class='printerrmesg'>\r\n\t{$errmesg}\r\n\t</p>\r\n\t";
    }
}

function printmenu( $arraymenu )
{
    global $tingkataksesusers;
    global $tingkatakses;
    global $tingkats;
    global $arraykelompokmenu;
    global $JUDULFAKULTAS;
    global $tingkats;
    global $tingkataksesusers;
    global $users;
    global $borderdata;
    global $root;
    global $arrayikonsubmenu;
    global $jenisusers;
    $jumlahmenu = count( $arraymenu );
    $ii = 0;
    $tmp = "\r\n\t\t<div id='menu' >\r\n\t";
    foreach ( $arraykelompokmenu as $kk => $vv )
    {
        $kelas = kelasmenu( $ii );
        $tmpx = "";
        $tmpx .= "\r\n\t\t\t\t\t<ul  >\r\n  \t\t\t\t\t<li>\r\n    \t\t\t\t\t <h2>{$vv}</h2> \r\n                <ul>\r\n\t\t\t\t\t";
        $k = 0;
        foreach ( $arraymenu as $i => $v )
        {
            if ( $v[k] != $kk )
            {
                continue;
            }
            $bolehdiakses = false;
            if ( $v[t] != "" && $tingkataksesusers[$v[t]] != "" )
            {
                $bolehdiakses = true;
            }
            if ( session_is_registered_sikad( "tingkats" ) && ( $bolehdiakses || $v[t] == "" ) )
            {
                $tmpx .= " <li> <a     href='../{$v['href']}'>{$v['Judul']} </a>";
                unset( $arraysubmenu );
                $filesubmenu = "../".str_replace( "index.php", "", $v[href] )."/submenu.php";
                $dirsubmenu = "../".str_replace( "index.php", "", $v[href] )."";
                if ( file_exists( $filesubmenu ) )
                {
                    include( "../".str_replace( "index.php", "", $v[href] )."/submenu.php" );
                    if ( is_array( $arraysubmenu ) )
                    {
                        $tmpx .= " <ul> ";
                        foreach ( $arraysubmenu as $k => $v )
                        {
                            if ( $v[t] == "T" && $tingkataksesusers[$kodemenu] != "T" )
                            {
                            }
                            else if ( $v[href] != "" )
                            {
                                $tmpx .= " <li><a href='".$dirsubmenu."{$v['href']}'>".$arrayikonsubmenu[$v[ico]]." {$v['Judul']}</a></li>";
                            }
                        }
                        $tmpx .= " </ul> ";
                    }
                }
                $tmpx .= " </li> ";
                ++$k;
                ++$j;
            }
        }
        $tmpx .= "\r\n      \t\t</ul>\r\n     \t\t</li>\r\n     \t\t</ul>\r\n     \t\t";
        if ( 0 < $k )
        {
            $tmp .= $tmpx;
            ++$ii;
        }
    }
    $tmp .= "\r\n </div>\r\n <!--globalnav -->\r\n\t";
    echo $tmp;
}

function printmenulama( $arraymenu )
{
    global $tingkataksesusers;
    global $tingkatakses;
    global $tingkats;
    global $arraykelompokmenu;
    $jumlahmenu = count( $arraymenu );
    $ii = 0;
    $tmp = "\r\n\t\t<div id=\"globalNav\" >\r\n\t\t\t\t\t<table width=100% cellpadding=0 cellspacing=0>\r\n\t";
    foreach ( $arraykelompokmenu as $kk => $vv )
    {
        $kelas = kelasmenu( $ii );
        $tmpx = "";
        $tmpx .= "\r\n\t\t\t\t\t<tr height=18 {$kelas} valign=middle id=globallink  >\r\n\t\t\t\t\t<td  nowrap class=\"glinktd\">\r\n\t\t\t\t\t<b>{$vv}</b>\r\n\t\t\t\t\t</td><td nowrap >\r\n\t\t\t\t\t";
        $k = 0;
        foreach ( $arraymenu as $i => $v )
        {
            if ( $v[k] != $kk )
            {
                continue;
            }
            $bolehdiakses = false;
            if ( $v[t] != "" && $tingkataksesusers[$v[t]] != "" )
            {
                $bolehdiakses = true;
            }
            if ( session_is_registered_sikad( "tingkats" ) && ( $bolehdiakses || $v[t] == "" ) )
            {
                $br = "&nbsp;";
                $tkiri = "<font style='font-size:8px'> {$br} [</font>";
                $tkanan = "<font style='font-size:8px'>]</font>";
                $reg = str_replace( "?", "\\?", $v[href] );
                if ( ereg_sikad( "({$reg})", $REQUEST_URI ) )
                {
                    $ta = "style='color:#ee2222'";
                    $b = "<b>";
                    $tb = "</b>";
                }
                $tmpx .= "<a class=glink {$ta} href='../{$v['href']}'>\r\n\t\t\t\t\t\t\t{$v['Judul']} </a>";
                $t = "";
                $ta = "";
                $td = "";
                $b = "";
                $tb = "";
                ++$k;
                ++$j;
            }
        }
        $tmpx .= "\r\n\t\t</td>\r\n \t\t</tr>\r\n \t\t";
        if ( 0 < $k )
        {
            $tmp .= $tmpx;
            ++$ii;
        }
    }
    $tmp .= "\r\n</table> \r\n</div><!--globalnav -->\r\n\t";
    echo $tmp;
}

function printhtml( )
{
    global $style;
    echo "\r\n\t<html>\r\n\t\t<head>\r\n\t\t\t{$style}\r\n\t\t</head>\r\n\t\t<body>\r\n \t";
}

function printhtmlcetak( )
{
    global $root;
    include( $root."css/style.inc" );
    echo "\r\n\t<html>\r\n\t\t<head>\r\n\t\t\t{$style}\r\n\t\t</head>\r\n\t\t<body class=cetak>\r\n \t";
}

function kelas( $i )
{
    if ( $i % 2 == 0 )
    {
        $kelas = " class=datagenap";
    }
    else
    {
        $kelas = " class=dataganjil";
    }
    return $kelas;
}

function kelasmenu( $i )
{
    if ( $i % 2 == 0 )
    {
        $kelas = " class=datagenapmenu";
    }
    else
    {
        $kelas = " class=dataganjilmenu";
    }
    return $kelas;
}

function kelassm( $i )
{
    if ( $i % 2 == 0 )
    {
        $kelas = " class=datagenapsm";
    }
    else
    {
        $kelas = " class=dataganjilsm";
    }
    return $kelas;
}

function createform( $nama, $metod, $action, $attr )
{
    $tmp = "\r\n\t\t<form method='{$metod}' name='{$nama}' action='{$action}' {$attr}>\r\n\t\t\t<--isi-->\r\n\t\t</form>\r\n\t";
    return $tmp;
}

function createinputhidden( $nama, $value, $attr )
{
    $tmp = "\r\n\t\t<input type=hidden name='{$nama}' value='{$value}' {$attr}>\r\n\t";
    return $tmp;
}

function createinputtext( $nama, $value, $attr )
{
    $tmp = "\r\n\t\t<input type=text name=\"{$nama}\" value=\"{$value}\" {$attr}>\r\n\t";
    return $tmp;
}

function createinputtextarea( $nama, $value, $attr )
{
    $tmp = "\r\n\t\t<textarea name='{$nama}'  {$attr}>{$value}</textarea>\r\n\t";
    return $tmp;
}

function createinputpassword( $nama, $value, $attr )
{
    $tmp = "\r\n\t\t<input type=password name='{$nama}' value='{$value}' {$attr}>\r\n\t";
    return $tmp;
}

function createinputcek( $nama, $value, $ket, $cek, $attr )
{
    $tmp = "\r\n\t\t<input type=checkbox name='{$nama}' {$cek} value='{$value}' {$attr}>{$ket}\r\n\t";
    return $tmp;
}

function createinputcekarray( $nama, $tabelvalue, $tabelkey, $attr )
{
    foreach ( $tabelvalue as $k => $v )
    {
        if ( @in_array( @$k, @$tabelkey ) )
        {
            $cek = "checked";
        }
        $tmp .= "\r\n\t\t\t<input name={$nama}"."[{$k}] type=checkbox value='{$k}' {$cek} {$attr}>{$v}</option><br>\r\n\t\t\t";
        $cek = "";
    }
    return $tmp;
}

function createinputradio( $nama, $value, $ket, $cek, $attr )
{
    $tmp = "\r\n\t\t<input type=radio name='{$nama}' {$cek} value='{$value}' {$attr}>{$ket}\r\n\t";
    return $tmp;
}

function createinputradioarray( $nama, $tabelvalue, $key, $attr )
{
    foreach ( $tabelvalue as $k => $v )
    {
        if ( $k == $key )
        {
            $cek = "checked";
        }
        $tmp .= "\r\n\t\t\t<input name='{$nama}' type=radio value='{$k}' {$cek} {$attr}>{$v}</option><br>\r\n\t\t\t";
        $cek = "";
    }
    return $tmp;
}

function createinputselect( $nama, $tabelvalue, $key, $multiple, $attr )
{
    $tmp = "\r\n\t\t<select name='{$nama}' {$attr} {$multiple}>";
    foreach ( $tabelvalue as $k => $v )
    {
        if ( $key == $k && trim( $multiple ) != "multiple" )
        {
            $cek = "selected";
        }
        else if ( in_array( @$k, @$key ) && trim( $multiple ) == "multiple" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t";
        $cek = "";
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    return $tmp;
}

function createinputtanggalblank( $nama, $value, $attr )
{
    global $arraybulan;
    $waktu = getdate( );
    $tmp = "\r\n\t\t<select name='".$nama."[tgl]' {$attr}>\r\n\t\t<option value='' >tgl</option>\r\n\t\t";
    $i = 1;
    while ( $i <= 31 )
    {
        if ( $value[tgl] == $i && $value[tgl] != "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    $tmp .= "\r\n\t\t<select name='".$nama."[bln]' {$attr}>\r\n\t\t<option value='' >bln</option>\r\n\t\t";
    $i = 1;
    while ( $i <= 12 )
    {
        if ( $value[bln] == $i && $value[bln] != "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>".$arraybulan[$i - 1]."</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    $tmp .= "\r\n\t\t<select name='".$nama."[thn]' {$attr}>\r\n\t\t<option value='' >thn</option>\r\n\t\t";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( $value[thn] == $i && $value[thn] != "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    return $tmp;
}

function createinputbulantahun( $nama, $value, $attr )
{
    global $arraybulan;
    $waktu = getdate( );
    $tmp = "\r\n\t\t<select name='".$nama."[bln]' {$attr}>\r\n \t\t";
    $i = 1;
    while ( $i <= 12 )
    {
        if ( $value[bln] == $i && $value[bln] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[mon] == $i && $value[bln] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>".$arraybulan[$i - 1]."</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    $tmp .= "\r\n\t\t<select name='".$nama."[thn]' {$attr}>\r\n \t\t";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( $value[thn] == $i && $value[thn] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[year] == $i && $value[thn] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    return $tmp;
}

function createinputtanggal( $nama, $value, $attr )
{
    global $arraybulan;
    $waktu = getdate( );
    $tmp = "\r\n\t\t<select name='".$nama."[tgl]' {$attr}>\r\n \t\t";
    $i = 1;
    while ( $i <= 31 )
    {
        if ( $value[tgl] == $i && $value[tgl] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[mday] == $i && $value[tgl] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    $tmp .= "\r\n\t\t<select name='".$nama."[bln]' {$attr}>\r\n \t\t";
    $i = 1;
    while ( $i <= 12 )
    {
        if ( $value[bln] == $i && $value[bln] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[mon] == $i && $value[bln] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>".$arraybulan[$i - 1]."</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    $tmp .= "\r\n\t\t<select name='".$nama."[thn]' {$attr}>\r\n \t\t";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( $value[thn] == $i && $value[thn] != "" )
        {
            $cek = "selected";
        }
        else
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    return $tmp;
}

function createinputtahun( $nama, $value, $attr )
{
    global $arraybulan;
    $waktu = getdate( );
    $tmp .= "\r\n\t\t<select name='".$nama."' {$attr}>";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( $value == $i && $value != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[year] == $i && $value == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    return $tmp;
}

function createinputtahunajaran( $nama, $value, $attr )
{
    global $arraybulan;
    $waktu = getdate( );
    $tmp .= "\r\n\t\t<select name='".$nama."' {$attr}>";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( $value == $i && $value != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[year] == $i && $value == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>".( $i - 1 )."/{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>\r\n\t";
    return $tmp;
}

function createinputjam( $nama, $value, $isdetik, $attr )
{
    global $arraybulan;
    $waktu = getdate( );
    $tmp = "\r\n\t\t<select name='".$nama."[jam]' {$attr}>";
    $i = 0;
    while ( $i <= 23 )
    {
        if ( $value[jam] == $i && $value[jam] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[hours] == $i && $value[jam] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>:\r\n\t";
    $tmp .= "\r\n\t\t<select name='".$nama."[mnt]' {$attr}>";
    $i = 0;
    while ( $i <= 59 )
    {
        if ( $value[mnt] == $i && $value[mnt] != "" )
        {
            $cek = "selected";
        }
        else if ( $waktu[minutes] == $i && $value[mnt] == "" )
        {
            $cek = "selected";
        }
        $tmp .= "\r\n\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t";
        $cek = "";
        ++$i;
    }
    $tmp .= "\r\n\t\t</select>:\r\n\t";
    if ( $isdetik != "" )
    {
        $tmp .= "\r\n\t\t\t<select name='".$nama."[dtk]' {$attr}>\r\n\t\t\t";
        $i = 0;
        while ( $i <= 59 )
        {
            if ( $value[dtk] == $i && $value[dtk] != "" )
            {
                $cek = "selected";
            }
            else if ( $waktu[seconds] == $i && $value[dtk] == "" )
            {
                $cek = "selected";
            }
            $tmp .= "\r\n\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t";
            $cek = "";
            ++$i;
        }
        $tmp .= "\r\n\t\t\t</select>\r\n\t\t";
    }
    else
    {
        $tmp .= "00\r\n\t\t\t<input type=hidden name='".$nama."[dtk]' value=0>\r\n\t\t";
    }
    return $tmp;
}

function printdemo( )
{
    echo "\r\n\t<table class=form>\r\n\t\t<tr align=center>\r\n\t\t\t<td>\r\n\t\t\t\tTerima Kasih telah menggunakan SITU versi Demo.  <br>\r\n\t\t\t\tUntuk fitur yang lebih lengkap, silakan membeli versi asli dari SITU.\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t</table>\r\n\t";
}

periksaroot( );
?>
