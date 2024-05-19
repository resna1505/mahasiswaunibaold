<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/********************/
function listsubakun2( $id, &$list, $s, $level, $jenistampilan = 0 )
{
    global $koneksi;
    global $spasi;
    global $br;
    $qx = "";
    
    $q = "SELECT ID,NAMA,TINGKAT,KONTRAID,\r\n\t{$qx} UNTUKNERACA,UNTUK,UNTUKRUGILABA\r\n\t FROM akun \r\n\t WHERE SUBID='{$id}' ORDER BY ID";
    $h = mysqli_query($koneksi,$q);
	if( 0 < sqlnumrows( $h )){
		while ($d = sqlfetcharray( $h ))
		{
			if ( $d[TINGKAT] == 0 )
			{
				$list[$d[ID]][ID] = $d[ID];
				$list[$d[ID]][NAMA] = $d[NAMA];
				$list[$d[ID]][LEVEL] = $level;
				$list[$d[ID]][KONTRAID] = $d[KONTRAID];
				$list[$d[ID]][NAMAPANJANG2] = $s."{$br}".$d[NAMA];
				$list[$d[ID]][NAMAPANJANG] = $s." ".$d[ID]."{$br}".$d[NAMA];
				$list[$d[ID]][TINGKAT] = $d[TINGKAT];
				$list[$d[ID]][UNTUKNERACA] = $d[UNTUKNERACA];
				$list[$d[ID]][UNTUK] = $d[UNTUK];
				$list[$d[ID]][UNTUKRUGILABA] = $d[UNTUKRUGILABA];
				$list[$d[ID]][SUBUNTUKNERACA] = $d[SUBUNTUKNERACA];
			
				listsubakun2( $d[ID], $list, $s.$spasi, $level + 1, $jenistampilan );
			}
		}
	}
}

function listakun2(  )
{
    global $koneksi;
    global $spasi;
    global $br;
    $qx = "";
    
    $q = "SELECT ID,NAMA,TINGKAT,KONTRAID,\r\n\t{$qx} UNTUKNERACA,UNTUK,UNTUKRUGILABA \r\n\tFROM akun WHERE SUBID=''  ORDER BY ID";
    $h = mysqli_query($koneksi,$q);
	if( 0 < sqlnumrows( $h )){
		while ($d = sqlfetcharray($h))
		{
			if ( $d[TINGKAT] == 0 )
			{
				$slistakun[$d[ID]][ID] = $d[ID];
				$slistakun[$d[ID]][LEVEL] = 0;
				$slistakun[$d[ID]][NAMA] = $d[NAMA];
				$slistakun[$d[ID]][KONTRAID] = $d[KONTRAID];
				$slistakun[$d[ID]][NAMAPANJANG2] = $br.$d[NAMA];
				$slistakun[$d[ID]][NAMAPANJANG] = $d[ID]."{$br}".$d[NAMA];
				$slistakun[$d[ID]][KONTRAID] = $d[KONTRAID];
				$slistakun[$d[ID]][SUBUNTUKNERACA] = $d[SUBUNTUKNERACA];
				$slistakun[$d[ID]][TINGKAT] = $d[TINGKAT];
				$slistakun[$d[ID]][UNTUKNERACA] = $d[UNTUKNERACA];
				$slistakun[$d[ID]][UNTUK] = $d[UNTUK];
				$slistakun[$d[ID]][UNTUKRUGILABA] = $d[UNTUKRUGILABA];
			
				listsubakun2( $d[ID], $slistakun, $spasi, 1, $jenistampilan );
				
			}
		}
	}
    return $slistakun;
}
function listsubkelompokakun( $id, $list, $s )
{
    global $db;
    $q = "SELECT ID,NAMA,TINGKAT FROM akun WHERE SUBID='{$id}'";
    $h = mysql_query( $q, $db );
	//print_r(sqlfetcharray( $h ));	
    $spasi = "------";
    $br = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    if(sqlnumrows( $h )>0){
		while ( $d = sqlfetcharray( $h ) ) 
		{
			 if ( $d[TINGKAT] == 0 )
			 {
				$list[$d[ID]][ID] = $d[ID];
				$list[$d[ID]][NAMA] = $d[NAMA];
				$list[$d[ID]][NAMAPANJANG] = $s." ".$d[ID]."{$br}".$d[NAMA];
				$list[$d[ID]][TINGKAT] = $d[TINGKAT];
				// if ( $d[TINGKAT] == 0 )
				// {
					listsubkelompokakun( $d[ID], $list, $s.$spasi );
				//}
			}
		}
	}
	
}

function listkelompokakun( )
{
    global $db;
    $q = "SELECT ID,NAMA,TINGKAT FROM akun WHERE SUBID=''";
    $h = mysql_query( $q, $db );
	print_r(sqlnumrows( $h ));
    $spasi = "------";
	
    $br = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	if(sqlnumrows( $h )>0){
		while ( $d = sqlfetcharray( $h ) )
		{
			if ( $d[TINGKAT] == 0 )
			 {
				$listkelompokakun[$d[ID]][ID] = $d[ID];
				$listkelompokakun[$d[ID]][NAMA] = $d[NAMA];
				$listkelompokakun[$d[ID]][NAMAPANJANG] = $d[ID]."{$br}".$d[NAMA];
				$q = "SELECT ID,NAMA,TINGKAT FROM akun WHERE SUBID='{$d[ID]}'";
				$h = mysql_query( $q, $db );
				//print_r(sqlfetcharray( $h ));	
				$spasi = "------";
				$br = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				if(sqlnumrows( $h )>0){
					while ( $d = sqlfetcharray( $h ) ) 
					{
						 if ( $d[TINGKAT] == 0 )
						 {
							$listkelompokakun[$d[ID]][ID] = $d[ID];
							$listkelompokakun[$d[ID]][NAMA] = $d[NAMA];
							$listkelompokakun[$d[ID]][NAMAPANJANG] = $s." ".$d[ID]."{$br}".$d[NAMA];
							$listkelompokakun[$d[ID]][TINGKAT] = $d[TINGKAT];
							// if ( $d[TINGKAT] == 0 )
							// {
								//listsubkelompokakun( $d[ID], $list, $s.$spasi );
							//}
						}
					}
				}
				//$listkelompokakun[$d[ID]][TINGKAT] = $d[TINGKAT];
				
				// if ( $d[TINGKAT] == 0 )
				// {
					//listsubkelompokakun( $d[ID], $listkelompokakun, $spasi );
				//}
			}
		}
	}
	echo '<pre>';
	print_r($listkelompokakun);
	echo '</pre>';
    return $listkelompokakun;
}

$root = "../";
include( $root."sesiuser.php" );
include( $root."db.php" );
include( $root."header.php" );
$db = mysql_connect( $hostsql, $loginsql, $passwordsql );
$koneksi = $db;
mysql_select_db( $basisdatasql, $db );
$punit = split_sikad( ",", $pfltr );
echo "<html>\n";
echo "<head>\n<style>";
include( $root."css/list_prodi.css" );
echo "\n</style><title>Daftar Nama Kelompok Akuntansi</title>\n";
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
echo "<div id='wrap'>";
echo "<table width='100%' border='0' class=menu>\n";
echo "<tr>\n";
echo "<td class='judul1' align=center>Daftar Nama Kelompok Akuntansi</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>\n";
//$klpakun = listkelompokakun( );
$klpakun = listakun2( );
echo '<pre>';
//print_r($klpakun);
echo '</pre>';
echo "<table width='100%' {$borderdata} class=data>\n";
$i = 0;
foreach ( $klpakun as $k => $row )
{
    $kelas = kelas( $i );
    $pval = $row[NAMA].",".$row[ID];
    echo "<tr {$kelas}>\n";
    echo "<td class=isi2 ><a href=\"javascript:pick('".$pfld."','".$pval."')\">".$row[NAMAPANJANG]."</td>\n";
    echo "</tr>\n";
}
echo "</table>\n";
echo "</body>";
echo "</body>\n";
echo "</html>\n";
?>
