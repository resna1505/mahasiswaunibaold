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
periksaroot( );
$db = mysql_connect( $hostsql, $loginsql, $passwordsql );
mysql_select_db( $basisdatasql, $db );
$punit = split_sikad( ",", $pfltr );
if ( $satu == 1 )
{
    $qf = " AND 1=2 ";
}
$sqltext = "Select mahasiswa.ID as username, mahasiswa.NAMA as nama_pengguna,IDPRODI ,ANGKATAN\r\n\t \r\n\tfrom mahasiswa  ";
$sqltext = $sqltext." where \r\n\t\t\t STATUS!='L'  {$qf} ";
if ( $tab == 1 )
{
    $sqltext = $sqltext."AND mahasiswa.NAMA like '{$pnama}%' ";
}
else
{
    if ( $idprodi != "" )
    {
        $qf2 .= " AND IDPRODI='{$idprodi}'";
    }
    if ( $angkatan != "" )
    {
        $qf2 .= " AND ANGKATAN='{$angkatan}'";
    }
    $sqltext = $sqltext."AND mahasiswa.NAMA like '%{$pnama}%' {$qf2} ";
}
if ( $porder == "U" )
{
    $sqltext = $sqltext."order by mahasiswa.NAMA";
}
else if ( $porder == "N" )
{
    $sqltext = $sqltext."order by mahasiswa.ID";
}
else if ( $porder == "P" )
{
    $sqltext = $sqltext."order by mahasiswa.IDPRODI";
}
else if ( $porder == "A" )
{
    $sqltext = $sqltext."order by mahasiswa.ANGKATAN";
}
$pengguna = mysql_query( $sqltext, $db );
echo "<html>\n";
echo "<head>\r\n<style>";
include( $root."css/list_prodi.css" );
echo "\r\n</style>\r\n<title>Daftar Mahasiswa</title>\n";
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
echo "\r\n\r\n<div id=\"wrap\">\r\n\t\r\n    <h2 id=\"title\">Daftar Mahasiswa</h2>\r\n    \r\n    <div id=\"link_alpha\">\r\n    \t<ul class=\"mainlink\">\r\n     ";
$i = 0;
while ( $i < 26 )
{
    echo "\r\n             \t<li><a href='listmhs.php?tab=1&pfld=".$pfld."&pfltr=".$pfltr."&pnama=".chr( $i + 65 )."'>".chr( $i + 65 )."\r\n         \t</a></li>";
    ++$i;
}
print_r($arrayprodidep);
echo "        </ul>\r\n    </div>\r\n    \r\n    <div id=\"forminput\">\r\n    \r\n    <form class=\"box\" name=\"caripengguna\">\r\n    \r\n     \t<label class=\"smallabel\">\r\n              ";
echo "<s";
echo "pan class=\"smallspan\">Nama :</span>\r\n              <input class=\"input_text\" name=\"katakunci\" type=\"text\">\r\n        </label>\r\n        \r\n        <label class=\"smallabel\">\r\n              ";
echo "<s";
echo "pan class=\"smallspan\">Angkatan :</span>\r\n              ";
echo "<input type=text class='input_text' name=angkatan value='{$angkatan}'>";
echo "        </label>\r\n    \r\n        <label class=\"smallabel\">\r\n             ";
echo "<s";
echo "pan class=\"smallspan\">DI PRODI :</span>\r\n         ";
echo "<s";
echo "elect name=\"idprodi\" class=\"textfield\">\r\n             <option value=\"\">Semua</option>\r\n        ";
foreach ( $arrayprodidep as $k => $v )
{
    $selected = "";
    if ( $idprodi == $k )
    {
        $selected = "selected";
    }
    echo "<option {$selected} value='{$k}'>{$v}</option>";
}
echo "             </select>\r\n        </label> \r\n                \r\n\t  ";
echo "<input type=button class=login  value='Cari!' \r\n     onClick=window.open('listmhs.php?pfld='+'{$pfld}'+'&pfltr='+'{$pfltr}'+'&pnama='+katakunci.value+'&idprodi='+idprodi.value+'&angkatan='+angkatan.value,'_self')>";
echo "    \r\n    </form>\r\n    \r\n    ";
echo "<a class='showall' href='listmhs.php?pfld=".$pfld."&pfltr=".$pfltr."'>Tampilkan Semua</a>";
echo "    \r\n    </div>\r\n    \r\n";
echo "<table width='100%' {$borderdata} class=data>\n";
echo "<thead><tr class='juduldata' align=center>\n";
echo "<td class=judul2 width='10'><a href='listmhs.php?tab={$tab}&pfld=".$pfld."&pfltr=".$pfltr."&pnama={$pnama}&idprodi={$idprodi}&angkatan={$angkatan}&porder=N'>NIM</a></td>\n";
echo "<td class=judul2 ><a href='listmhs.php?tab={$tab}&pfld=".$pfld."&pfltr=".$pfltr."&pnama={$pnama}&idprodi={$idprodi}&angkatan={$angkatan}&porder=U'>Nama</a></td>\n";
echo "<td class=judul2 ><a href='listmhs.php?tab={$tab}&pfld=".$pfld."&pfltr=".$pfltr."&pnama={$pnama}&idprodi={$idprodi}&angkatan={$angkatan}&porder=P'>Jurusan/Prodi</a></td>\n";
echo "<td class=judul2 ><a href='listmhs.php?tab={$tab}&pfld=".$pfld."&pfltr=".$pfltr."&pnama={$pnama}&idprodi={$idprodi}&angkatan={$angkatan}&porder=A'>Angkatan</a></td>\n";
echo "</tr></thead>\n";
$i = 0;
while ( $row = sqlfetcharray( $pengguna ) )
{
    $kelas = kelas( $i );
    $pval = $row['kode_pengguna'].",".$row['username'];
    echo "<tr {$kelas}>\n";
    echo "<td class=isi2 ><a href=\"javascript:pick('".$pfld."','".$pval."')\">".$row['username']."</td>\n";
    echo "<td class=isi2 >".$row['nama_pengguna']."</td>\n";
    echo "<td class=isi2 >".$arrayprodidep[$row[IDPRODI]]."</td>\n";
    echo "<td align=center class=isi2 >{$row['ANGKATAN']}</td>\n";
    echo "</tr>\n";
}
echo "</table>\n";
echo "</div>";
echo "</body>\n";
echo "</html>\n";
?>
