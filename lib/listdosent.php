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
// paging
	$type=$_REQUEST['type'];
	$uri=$_SERVER['QUERY_STRING'];
	$adjacents = 3;
	echo "<link rel=stylesheet type='text/css' href='css_paging.css'>\n";

	$query = "SELECT COUNT(*) as num FROM dosen where 1=1 ";
	if($type=='tab'){
		$query.= 'and dosen.nama like \''.$pnama.'%\'';
	}elseif($type=='cari' ){
		if($pnama!=""){ 
			$query.= 'and dosen.nama like \'%'.$pnama.'%\'';
		}
		if($idprodi!=""){
			$query.='and IDDEPARTEMEN=\''.$idprodi.'\'';
		}
	}elseif($type=='semua'){
		$query.="";
	}
	$total_pages = sqlfetcharray(mysql_query($query));
	$total_pages = $total_pages[num];
	$targetpage = "listdosen.php"; 	
	if($_REQUEST['limit_table']){
		$limit=$_REQUEST['limit_table'];
	}else{
		$limit=5;
	}
	$page = $_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit; 			
	else
		$start = 0;								
	
	if ($page == 0) $page = 1;					
	$prev = $page - 1;							
	$next = $page + 1;							
	$lastpage = ceil($total_pages/$limit);	
	$lpm1 = $lastpage - 1;
	$pagination = "";
	
	
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?$uri&limit=$limit&page=$prev\">previous</a>";
		else
			$pagination.= "<span class=\"disabled\">previous</span>";	
		if ($lastpage < 7 + ($adjacents * 2))	
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?$uri&limit_table=$limit&page=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	
		{
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?$uri&limit_table=$limit&page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?limit_table=$limit&page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?limit_table=$limit&page=$lastpage\">$lastpage</a>";		
			}
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?$uri&limit_table=$limit&page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?$uri&limit_table=$limit&page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?$uri&limit_table=$limit&page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?$uri&limit_table=$limit&page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?$uri&page=$lastpage\">$lastpage</a>";		
				//$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			else
			{
				$pagination.= "<a href=\"$targetpage?$uri&limit_table=$limit&page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?$uri&limit_table=$limit&page=2\">2</a>";

				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?$uri&limit_table=$limit&page=$counter\">$counter</a>";
				
				}
			}
		}
		if ($page < $counter - 1) 
		$pagination.= "<a href=\"$targetpage?$uri&limit_table=$limit&page=$next\">next</a>";
		
			//$pagination.= "<a href=\"$targetpage?page=$next\">next</a>";
		else
			$pagination.= "<span class=\"disabled\">next</span>";
		//$pagination.= "</div>";		
	}
// end paging
if ( $satu == 1 )
{
    $qf = " AND 1=2 ";
}
$sqltext = "Select dosen.ID as username, dosen.NAMA as nama_pengguna,IDDEPARTEMEN AS IDPRODI \r\n\t \r\n\tfrom dosen  ";
$sqltext = $sqltext." where \r\n\t\t\t 1=1 {$qf}  ";
if ( $tab == 1 )
{
    $sqltext = $sqltext."AND dosen.NAMA like '{$pnama}%' ";
}
else
{
    if ( $idprodi != "" )
    {
        $qf2 .= " AND IDDEPARTEMEN='{$idprodi}'";
    }
    $sqltext = $sqltext."AND dosen.NAMA like '%{$pnama}%' {$qf2} ";
}
if ( $porder == "U" )
{
    $sqltext = $sqltext."order by dosen.NAMA";
}
else if ( $porder == "P" )
{
    $sqltext = $sqltext."order by dosen.IDDEPARTEMEN";
}
else
{
    $sqltext = $sqltext."order by dosen.ID";
}
$sqltext = $sqltext.= " limit $start, $limit ";
$pengguna = mysql_query( $sqltext, $db );
echo "<html>\n";
echo "<head>\r\n<style>";
include( $root."css/list_prodi.css" );
echo "\r\n</style><title>Daftar Dosen</title>\n";
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
// echo "                        wod.forms[i].elements[j].value += val[0]+'\\n';\n";
// echo "                    }\n";
// echo "                    if (wod.forms[i].elements[j].name == fld[2]) {\n";
// echo "                        wod.forms[i].elements[j].value += val[1]+'\\n';\n";
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
echo "\r\n\r\n<div id=\"wrap\">\r\n\t\r\n    <h2 id=\"title\">Daftar Dosen</h2>\r\n    \r\n    <div id=\"link_alpha\">\r\n    \t<ul class=\"mainlink\">\r\n     ";
$i = 0;
while ( $i < 26 )
{
    echo "\r\n             \t<li><a href='listdosent.php?tab=1&pfld=".$pfld."&pfltr=".$pfltr."&type=tab&pnama=".chr( $i + 65 )."'>".chr( $i + 65 )."\r\n         \t</a></li>";
    ++$i;
}
echo "        </ul>\r\n    </div>\r\n    \r\n    <div id=\"forminput\">\r\n    \r\n    <form class=\"box\" name=\"caripengguna\">\r\n    \r\n     \t<label class=\"smallabel\">\r\n              ";
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
window.location.href='listdosen.php?pfld='+'{$pfld}'+'&type=cari&pfltr='+'{$pfltr}'+'&pnama='+katakunci+'&idprodi='+idprodi;
}
</script>";
//echo "<input type=button class=login  value='Cari!' \r\n     onClick=window.open('listdosent.php?pfld='+'{$pfld}'+'&pfltr='+'{$pfltr}'+'&pnama='+katakunci.value+'&idprodi='+idprodi.value,'_self')>";
echo "    \r\n    </form>\r\n    \r\n    ";
echo "<a class='showall' href='listdosent.php?pfld=".$pfld."&pfltr=".$pfltr."&type=semua'>Tampilkan Semua</a>";
echo "    \r\n    </div>\r\n    \r\n\r\n";

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
//echo "<td class=judul2  ><a href='listdosent.php?tab={$tab}&pfld=".$pfld."&pfltr=".$pfltr."&pnama={$pnama}&porder=N'>ID /  NIDN</a></td>\n";
echo "<td class=judul2  ><a href='listdosent.php?$uri&porder=N'>ID /  NIDN</a></td>\n";
echo "<td class=judul2 ><a href='listdosent.php?$uri&porder=U'>Nama</a></td>\n";
echo "<td class=judul2 ><a href='listdosent.php?$uri&porder=P'>Jurusan/Prodi</a></td>\n";
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
