<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$root = "../";
include( $root."sesiuser.php" );
include( $root."db.php" );
include( $root."header.php" );
$db = mysql_connect( $hostsql, $loginsql, $passwordsql );
mysql_select_db( $basisdatasql, $db );
$punit = split_sikad( ",", $pfltr );
$sqltext = "Select user.ID as username, user.NAMA as nama_pengguna, \n\tbidang.JUDUL as jenis \n\tfrom user,bidang ";
$sqltext = $sqltext."where \n\t\t\tbidang.ID=user.BIDANG AND ";
$sqltext = $sqltext."user.NAMA like '{$pnama}%' AND user.NAMA!='superadmin'";
if ( $porder == "U" )
{
    $sqltext = $sqltext."order by user.NAMA";
}
else if ( $porder == "J" )
{
    $sqltext = $sqltext."order by user.BIDANG";
}
else
{
    $sqltext = $sqltext."order by user.ID";
}
$pengguna = mysql_query( $sqltext, $db );
echo "<html>\n";
echo "<head>\n<style>";
include( $root."css/list_prodi.css" );
echo "\n</style><title>Pilihan Daftar Pegawai</title>\n";
echo "<link rel=stylesheet type='text/css' href='{$css}'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<script src='".$root."tampilan/lib/jquery-1.4.min.js' type='text/javascript' charset='utf-8'></script>";
echo "<script src='".$root."css/script.js' type='text/javascript'></script>";
echo "<SCRIPT LANGUAGE=\"JavaScript\">\n";
echo "<!--\n";
echo "function pick(pfld) { \n\t\tfld = pfld.split(',');\n\t\n      var wod = window.opener.document; \n     if (window.opener && !window.opener.closed) { \n         var str='tes'+data.idpilih[1].value;\n         //for (var i=0; i<data.idpilih.length; i++) {\n         //\tstr+= data.idpilih[i].value+',';\n         //}\n\t\t\t\talert(str);\n         for (var i=0; i<wod.forms.length; i++) { \n             if (wod.forms[i].name == fld[0]) { \n                 for (var j=0; j<wod.forms[i].elements.length; j++) { \n                     if (wod.forms[i].elements[j].name == fld[1]) { \n                         wod.forms[i].elements[j].value = str; \n                     } \n                     if (wod.forms[i].elements[j].name == fld[2]) { \n                         wod.forms[i].elements[j].value = str; \n                     } \n                 }  \n             } \n         } \n     }  \n     return false;\n     //window.close(); \n }; \n\n // -->  \n\n\n </SCRIPT>  \n";
echo "</head>\n";
echo "<body>\n";
echo "\n<div id=\"wrap\">\n\t\n    <h2 id=\"title\">Daftar Pegawai</h2>\n    \n    <div id=\"link_alpha\">\n    \t<ul class=\"mainlink\">\n     ";
$i = 0;
while ( $i < 26 )
{
    echo "\n             \t<li><a href='listppilih.php?pfld=".$pfld."&pfltr=".$pfltr."&pnama=".chr( $i + 65 )."'>".chr( $i + 65 )."\n         \t</a></li>";
    ++$i;
}
echo "        </ul>\n    </div>\n    \n    <div id=\"forminput\">\n    \n    <form class=\"box\" name=\"caripengguna\">\n    \n     \t<label class=\"smallabel\">\n              ";
echo "<s";
echo "pan class=\"smallspan\">Nama :</span>\n              <input class=\"input_text\" name=\"katakunci\" type=\"text\">\n        </label>\n    \n  \n                \n\t  ";
echo "<input type=button class=login  value='Cari!' onClick=window.open('listppilih.php?pfld='+'{$pfld}'+'&pfltr='+'{$pfltr}'+'&pnama='+katakunci.value,'_self')>";
echo "    \n    </form>\n    \n    ";
echo "<a class='showall' href='listppilih.php?pfld=".$pfld."&pfltr=".$pfltr."'>Tampilkan Semua</a>";
echo "    \n    </div>\n    \n    \n\n";
echo "\n     <form action=listppilih.php method=post name=data\n     <input type=hidden name=tes value='teees lagi'>\n     <table width='100%' {$borderdata} class=data>\n";
echo "<tr class='juduldata' align=center>\n";
echo "<td class=judul2 colspan=3></td>\n";
echo "<td class=judul2 ><input type=submit \n     onclick=\"return pick('{$pfld}');\"\n     class=masukan value=Pilih></td>\n";
echo "</tr>\n";
echo "<thead><tr class='juduldata' align=center>\n";
echo "<td class=judul2 width='10'><a href='listppilih.php?pfld=".$pfld."&pfltr=".$pfltr."&pnama={$pnama}&porder=N'>ID</a></td>\n";
echo "<td class=judul2 ><a href='listppilih.php?pfld=".$pfld."&pfltr=".$pfltr."&pnama={$pnama}&porder=U'>Nama</a></td>\n";
echo "<td class=judul2 ><a href='listppilih.php?pfld=".$pfld."&pfltr=".$pfltr."&pnama={$pnama}&porder=J'>Bidang</a></td>\n";
echo "<td class=judul2 >Pilih</td>\n";
echo "</tr></thead>\n";
$i = 0;
while ( $row = sqlfetcharray( $pengguna ) )
{
    $kelas = kelas( $i );
    $pval = $row['kode_pengguna'].",".$row['username'];
    echo "<tr {$kelas}>\n";
    echo "<td class=isi2 > ".$row['username']."</td>\n";
    echo "<td class=isi2 >".$row['nama_pengguna']."</td>\n";
    echo "<td class=isi2 >".$row['jenis']."</td>\n";
    echo "<td class=isi2 ><input class=masukan  type=checkbox name=idpilih[{$i}] value=".$row['username']."></td>\n";
    echo "</tr>\n";
    ++$i;
}
echo "</table>\n     </form>\n";
echo "</div>";
echo "</body>\n";
echo "</html>\n";
?>
