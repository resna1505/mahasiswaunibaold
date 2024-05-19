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
	$query = "SELECT COUNT(*) as num FROM makul where 1=1 ";
	if($type=='tab'){
		$query.= 'and makul.NAMA like \''.$pnama.'%\'';
	}elseif($type=='cari' ){
		if($pnama!=""){
		$query.= "and makul.NAMA like '%$pnama%' ";
		}
		if($idprodi!="" ){
		$query.= "and idprodi='{$idprodi}' ";
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
$sqltext = "Select makul.ID as username, makul.NAMA as nama_pengguna ,IDPRODI\r\n\t \r\n\tfrom makul  ";
$sqltext = $sqltext." where \r\n\t\t\t1=1  {$qf} ";
if ( $tab == 1 )
{
    $sqltext = $sqltext."AND makul.NAMA like '{$pnama}%' ";
}
else
{
    if ( $idprodi != "" )
    {
        $qf2 .= " AND IDPRODI='{$idprodi}'";
    }
    $sqltext = $sqltext."AND makul.NAMA like '%{$pnama}%' {$qf2}";
}
if ( $porder == "U" )
{
    $sqltext = $sqltext."order by makul.NAMA";
}
else if ( $porder == "P" )
{
    $sqltext = $sqltext."order by makul.IDPRODI";
}
else
{
    $sqltext = $sqltext."order by makul.ID";
}
$sqltext = $sqltext.= " limit $start, $limit ";


$pengguna = mysql_query( $sqltext, $db );
echo "<html>\n";
echo "<head>\r\n<style>";
include( $root."css/list_prodi.css" );
echo "\r\n</style><title>Daftar Mata Kuliah</title>\n";
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
// echo "    fld = pfld.split(',');\n";
// echo "    val = pval.split(','); \n";
// echo "    var wod = window.opener.document;\n";
// echo "    if (window.opener && !window.opener.closed) {\n";
// echo "        for (var i=0; i<wod.forms.length; i++) {\n";
// echo "            if (wod.forms[i].name == fld[0]) {\n";
// echo "                for (var j=0; j<wod.forms[i].elements.length; j++) {\n";
// echo "                    if (wod.forms[i].elements[j].name == fld[1]) {\n";
// echo "                        wod.forms[i].elements[j].value = val[0];\n";
// echo "                    }\n";
// echo "                    if (wod.forms[i].elements[j].name == fld[2]) {\n";
// echo "                        wod.forms[i].elements[j].value = val[1];\n";
// echo "                    }\n";
// echo "                } \n";
// echo "            }\n";
// echo "        }\n";
// echo "    } \n";
// echo "    window.close();\n";
// echo "};\n";
// echo "// -->  \n";
// echo "</SCRIPT>  \n";
echo "</head>\n";
echo "<body>\n";
echo "\r\n\r\n<div id=\"wrap\">\r\n\t\r\n    <h2 id=\"title\">Daftar Mata Kuliah</h2>\r\n    \r\n    <div id=\"link_alpha\">\r\n    \t<ul class=\"mainlink\">\r\n     ";
$i = 0;
while ( $i < 26 )
{
    echo "\r\n             \t<li><a href='listmakul.php?tab=1&pfld=".$pfld."&pfltr=".$pfltr."&type=tab&pnama=".chr( $i + 65 )."'>".chr( $i + 65 )."\r\n         \t</a></li>";
    ++$i;
}
echo "        </ul>\r\n    </div>\r\n    \r\n    <div id=\"forminput\">\r\n    \r\n    \r\n    \r\n    <form class=\"box\" name=\"caripengguna\">\r\n    \r\n     \t<label class=\"smallabel\">\r\n              ";
echo "<s";
echo "pan class=\"smallspan\">Nama :</span>\r\n              <input class=\"input_text\" name=\"katakunci\" type=\"text\">\r\n        </label>\r\n    \r\n        <label class=\"smallabel\">\r\n             ";
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
echo "<input type=button class=login   value='Cari!' \r\n     onClick=\"test()\"/>";
echo "<script>
function test(){
var katakunci=$('[name=katakunci]').val();
var idprodi=$('[name=idprodi]').val();

window.location.href='$targetpage?pfld='+'{$pfld}'+'&type=cari&pfltr='+'{$pfltr}'+'&pnama='+katakunci+'&idprodi='+idprodi;
}
</script>";
// echo "<input type=button class=login  value='Cari!' \r\n     onClick=window.open('listmakul.php?pfld='+'{$pfld}'+'&pfltr='+'{$pfltr}'+'&pnama='+katakunci.value+'&idprodi='+idprodi.value,'_self')>";
echo "    \r\n    </form>\r\n    \r\n    ";
echo "<a class='showall' href='listmakul.php?pfld=".$pfld."&type=semua&pfltr=".$pfltr."'>Tampilkan Semua</a>";
echo "    \r\n    </div>\r\n    \r\n    \r\n\r\n";

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
//echo "<td class=judul2 width='10'><a href='listmakul.php?tab={$tab}&pfld=".$pfld."&pfltr=".$pfltr."&pnama={$pnama}&idprodi={$idprodi}&porder=N'>ID</a></td>\n";
echo "<td class=judul2 width='10'><a href='listmakul.php?$uri&porder=N'>ID</a></td>\n";
echo "<td class=judul2 ><a href='listmakul.php?$uri&porder=U'>Nama</a></td>\n";
echo "<td class=judul2 ><a href='listmakul.php?$uri&porder=P'>Jurusan/Prodi</a></td>\n";
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
    echo "</tr>\n";
}
echo "</table>\n";
echo "</div>";
echo "</body>\n";
echo "</html>\n";
?>
