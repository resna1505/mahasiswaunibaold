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
// paging
	$type=$_REQUEST['type'];
	$uri=$_SERVER['QUERY_STRING'];
	$targetpage = basename(__FILE__);
	echo "<link rel=stylesheet type='text/css' href='css_paging.css'>\n";
	$query = "SELECT COUNT(*) as num FROM mahasiswa where 1=1 ";
	if($type=='tab'){
		$query.= 'and mahasiswa.nama like \''.$pnama.'%\'';
	}elseif($type=='cari'){
		if($pnama!=""){
			$query.= "and mahasiswa.nama like '%$pnama%' ";
		}
		if($idprodi!=""){
			$query.= "and idprodi='{$idprodi}' ";
		}
		if($angkatan!=""){
			$query.= "and angkatan='{$angkatan}' ";
		}
	}elseif($type=='semua'){
		$query.="";
	}
	include('pagination.php');
// end paging
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

$sqltext = $sqltext.= " limit $start, $limit ";
$pengguna = mysql_query( $sqltext, $db );
echo "<html>\n";
echo "<head>\r\n<style>";
include( $root."css/list_prodi.css" );
echo "\r\n</style>\r\n<title>Daftar Mahasiswa</title>\n";
echo "<link rel=stylesheet type='text/css' href='{$css}'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<script src='".$root."tampilan/lib/jquery-1.4.min.js' type='text/javascript' charset='utf-8'></script>";
echo "<script src='".$root."css/script.js' type='text/javascript'></script>";
//copy script
echo "<SCRIPT LANGUAGE=\"JavaScript\">\n";
echo "<!--\n";
echo "function pick(pfld,pval) {\n";
echo "    var nfld = pfld.split(',');\n\r\n\r\n";
echo "    val = pval.split(',');  var ab=nfld[2];";
echo "window.opener.$('[name='+ab+']').val(val[1]);";
echo "     window.close();\n";
echo "};\n";
echo "// -->  \n";
echo "</SCRIPT>  \n";

// echo "<SCRIPT LANGUAGE=\"JavaScript\">\n";
// echo "<!--\n";
// echo "function pick(pfld,pval) {\n";
// echo "    var nfld = pfld.split(',');\n\r\n\r\n";
// echo "    val = pval.split(','); \n
// var ab=nfld[2];";

//echo "    var wod = window.opener.document;\n\r\n\r\n";
//echo "window.opener.$('[name='+ab+']').val(val[1]);";
/*echo "    if (window.opener && !window.opener.closed) {\n\r\n\r\n\r\n";
echo "        for (var i=0; i<wod.forms.length; i++) {\n\r\n \r\n";
echo "            if (wod.forms[i].name == fld[0]) {\n\r\n\r\n\r\n";
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
echo "    } \n";*/
// echo "     window.close();\n";
// echo "};\n";
// echo "// -->  \n";
// echo "</SCRIPT>  \n";
echo "</head>\n";
echo "<body>\n";
echo "\r\n\r\n<div id=\"wrap\">\r\n\t\r\n    <h2 id=\"title\">Daftar Mahasiswa</h2>\r\n    \r\n    <div id=\"link_alpha\">\r\n    \t<ul class=\"mainlink\">\r\n     ";
$i = 0;
while ( $i < 26 )
{
    echo "\r\n             \t<li><a href='listmhs.php?tab=1&pfld=".$pfld."&pfltr=".$pfltr."&type=tab&pnama=".chr( $i + 65 )."'>".chr( $i + 65 )."\r\n         \t</a></li>";
    ++$i;
}
#print_r($arrayprodidep);
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
    #break;
}
echo "             </select>\r\n        </label> \r\n                \r\n\t  ";
echo "<input type=button class=login   value='Cari!' \r\n     onClick=\"test()\"/>";
echo "<script>
function test(){
var katakunci=$('[name=katakunci]').val();
var idprodi=$('[name=idprodi]').val();
var angkatan=$('[name=angkatan]').val();
window.location.href='$targetpage?pfld='+'{$pfld}'+'&type=cari&pfltr='+'{$pfltr}'+'&pnama='+katakunci+'&idprodi='+idprodi+'&angkatan='+angkatan;
}
</script>";

echo "    \r\n    </form>\r\n    \r\n    ";
echo "<a name='semua' class='showall' href='listmhs.php?pfld=".$pfld."&pfltr=".$pfltr."&type=semua'>Tampilkan Semua</a>";
echo "    \r\n    </div>\r\n    \r\n    \r\n    \r\n\r\n\r\n\r\n";

if($satu==1){
}else{
echo "<div style=\"float:right\">".$pagination;
if($total_pages<=5){
}else{
?>
&nbsp;&nbsp;
<select name="limit" id="limit" onchange="page()">
	<option value="5" >5</option>
	<option value="10">10</option>
	<option value="25">25</option>
	<option value="50">50</option>
</select>
<script>
$(document).ready(function(){
	$('#limit').val(<?php echo $limit_table;?>);
});
		function page(){
			var a=document.getElementById('limit').value;
			window.location.href='<?php echo $targetpage;?>?<?php echo $uri;?>&limit_table='+a;
			
		}
		</script>
<?php
}
echo "</div>";
echo "</div>";
}
echo "<table width='100%' {$borderdata} class=data>\n";
echo "<thead><tr class='juduldata' align=center>\n";
//echo "<td class=judul2 width='10'><a href='listmhs.php?tab={$tab}&pfld=".$pfld."&pfltr=".$pfltr."&pnama={$pnama}&idprodi={$idprodi}&angkatan={$angkatan}&porder=N'>NIM</a></td>\n";
echo "<td class=judul2 width='10'><a href='listmhs.php?$uri&porder=N'>NIM</a></td>\n";
echo "<td class=judul2 ><a href='listmhs.php?$uri&porder=U'>Nama</a></td>\n";
echo "<td class=judul2 ><a href='listmhs.php?$uri&porder=P'>Jurusan/Prodi</a></td>\n";
echo "<td class=judul2 ><a href='listmhs.php?$uriporder=A'>Angkatan</a></td>\n";
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
