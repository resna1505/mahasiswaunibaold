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
$koneksi = $db;
mysql_select_db( $basisdatasql, $db );
$punit = split_sikad( ",", $pfltr );
echo "<html>\n\t\t\t<head>\n<style>";
include( $root."css/list_prodi.css" );
echo "\n</style><title>Daftar Nama Kode Akuntansi</title>\n";
echo "<link rel=stylesheet type='text/css' href='{$css}'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<script src='".$root."tampilan/lib/jquery-1.4.min.js' type='text/javascript' charset='utf-8'></script>";
echo "<script src='".$root."css/script.js' type='text/javascript'></script>";
echo "<SCRIPT LANGUAGE=\"JavaScript\">\n";
echo "<!--\n";
echo "function pick(pfld,pval) {\n";
echo "    fld = pfld.split(',');\n";
echo "    val = pval.split(','); \n";
echo "    var wod = window.opener.document;\n";
echo "    if (window.opener && !window.opener.closed) {\n";
echo "        for (var i=0; i<wod.forms.length; i++) {\n";
echo "            if (wod.forms[i].name == fld[0]) {\n";
echo "                for (var j=0; j<wod.forms[i].elements.length; j++) {\n";
echo "                    if (wod.forms[i].elements[j].name == fld[1]) {\n";
echo "                        wod.forms[i].elements[j].value = val[0];\n";
echo "                    }\n";
echo "                    if (wod.forms[i].elements[j].name == fld[2]) {\n";
echo "                        wod.forms[i].elements[j].value = val[1];\n";
echo "                    }\n";
echo "                } \n";
echo "            }\n";
echo "        }\n";
echo "    } \n";
echo "    window.close();\n";
echo "};\n";
echo "// -->  \n";
echo "</SCRIPT>  \n";
echo "</head>\n";
echo "<body>\n";
echo "\n<div id=\"wrap\">\n\t\n    <h2 id=\"title\">Daftar Nama Kode Akuntansi</h2>\n  \n    \n\n";
echo "<table width='100%' border='0' class=menu>\n";
echo "<tr>\n";
echo "<td class='judul1' align=center>Daftar Nama Kode Akuntansi</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>\n";
$akun = listakun( );
echo '<pre>';
print_r($akun );
echo '</pre>';
echo "<table width='100%' {$borderdata} class=data>\n";
$i = 0;
foreach ( $akun as $k => $row )
{
    $kelas = kelas( $i );
    $pval = $row[NAMA].",".$row[ID];
    echo "<tr {$kelas}>\n";
    if ( $row[TINGKAT] == 1 )
    {
        echo "<td class=isi2 ><a href=\"javascript:pick('".$pfld."','".$pval."')\">".$row[NAMAPANJANG]."</td>\n";
    }
    else
    {
        echo "<td class=isi2 >".$row[NAMAPANJANG]."</td>\n";
    }
    echo "</tr>\n";
}
echo "</table>\n";
echo "</div>";
echo "</body>\n";
echo "</html>\n";
?>
