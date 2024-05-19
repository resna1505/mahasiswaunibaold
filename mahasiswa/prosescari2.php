<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$q = "SHOW FULL COLUMNS FROM {$NAMATABELBEBAS}";
#echo $q;
$h = doquery($koneksi,$q);
#while ( !( 1 < sqlnumrows( $h ) ) || !( $d = sqlfetcharray( $h ) ) )
if (sqlnumrows($h)>0){ 
	while ($d = sqlfetcharray( $h ) )
	{
		$hasil = getmetadata( $d );
		if ( $hasil[cari] == 1 )
		{
			$tmp = $$d[0];
			if ( $tmp != "" )
			{
				$qfield .= " AND   ";
				if ( $hasil[tipe] == 0 || $hasil[tipe] == 1 || $hasil[tipe] == 2 || $hasil[tipe] == 3 )
				{
					$qfield .= " {$NAMATABELBEBAS}.{$d['0']} LIKE '%{$tmp}%'";
					$qjudul .= " ".ucfirst( strtolower( str_replace( "_", " ", $d[0] ) ) )."  '{$tmp}' <br>";
					$qinput .= " <input type=hidden name='{$d['0']}' value='{$tmp}'>";
					$href .= "{$d['0']}={$tmp}&";
				}
				else if ( $hasil[tipe] == 8 || $hasil[tipe] == 9 )
				{
					if ( $tmp == 1 )
					{
						$tmp1 = ${ $d[0]."1" };
						$tmp2 = ${ $d[0]."2" };
						$qfield .= " ({$NAMATABELBEBAS}.{$d['0']} >= '{$tmp1}' AND {$NAMATABELBEBAS}.{$d['0']} <= '{$tmp2}')";
						$qjudul .= "  '{$tmp1}' <= ".ucfirst( strtolower( str_replace( "_", " ", $d[0] ) ) )." <= '{$tmp2}' <br>";
						$qinput .= " \r\n                  <input type=hidden name='{$d['0']}' value='{$tmp}'>\r\n                  <input type=hidden name='{$d['0']}1' value='{$tmp1}'>\r\n                  <input type=hidden name='{$d['0']}2' value='{$tmp2}'>\r\n                  ";
						$href .= "{$d['0']}={$tmp}&{$d['0']}1={$tmp1}&{$d['0']}2={$tmp2}&";
					}
				}
				else if ( $hasil[tipe] == 4 )
				{
					if ( $tmp == 1 )
					{
						$tmp1 = ${ $d[0]."1" };
						$tgl1 = "DATE_FORMAT('{$tmp1['thn']}-{$tmp1['bln']}-{$tmp1['tgl']}','%Y-%m-%d')";
						$tmp2 = ${ $d[0]."2" };
						$tgl2 = "DATE_FORMAT('{$tmp2['thn']}-{$tmp2['bln']}-{$tmp2['tgl']}','%Y-%m-%d')";
						$qfield .= " ({$NAMATABELBEBAS}.{$d['0']} >= {$tgl1} AND {$NAMATABELBEBAS}.{$d['0']} <= {$tgl2})";
						$qjudul .= "  '{$tmp1['tgl']}-{$tmp1['bln']}-{$tmp1['thn']}' \r\n                  <= ".ucfirst( strtolower( str_replace( "_", " ", $d[0] ) ) )." \r\n                  <= '{$tmp2['tgl']}-{$tmp2['bln']}-{$tmp2['thn']}' <br>";
						$qinput .= " \r\n                  <input type=hidden name='{$d['0']}' value='{$tmp}'>\r\n                  <input type=hidden name='{$d['0']}1[tgl]' value='{$tmp1['tgl']}'>\r\n                  <input type=hidden name='{$d['0']}1[bln]' value='{$tmp1['bln']}'>\r\n                  <input type=hidden name='{$d['0']}1[thn]' value='{$tmp1['thn']}'>\r\n                  <input type=hidden name='{$d['0']}2[tgl]' value='{$tmp2['tgl']}'>\r\n                  <input type=hidden name='{$d['0']}2[bln]' value='{$tmp2['bln']}'>\r\n                  <input type=hidden name='{$d['0']}2[thn]' value='{$tmp2['thn']}'>\r\n                  ";
						$href .= "{$d['0']}={$tmp}&{$d['0']}1[tgl]={$tmp1['tgl']}&{$d['0']}1[bln]={$tmp1['bln']}&{$d['0']}1[thn]={$tmp1['thn']}&";
						$href .= "{$d['0']}2[tgl]={$tmp2['tgl']}&{$d['0']}2[bln]={$tmp2['bln']}&{$d['0']}2[thn]={$tmp2['thn']}&";
					}
				}
				else if ( !( $hasil[tipe] == 5 ) || !( $tmp == 1 ) )
				{
					$tmp1 = ${ $d[0]."1" };
					$tgl1 = " '{$tmp1['jam']}:{$tmp1['mnt']}:{$tmp1['dtk']}' ";
					$tmp2 = ${ $d[0]."2" };
					$tgl2 = " '{$tmp2['jam']}:{$tmp2['mnt']}:{$tmp2['dtk']}' ";
					$qfield .= " ({$NAMATABELBEBAS}.{$d['0']} >= {$tgl1} AND {$NAMATABELBEBAS}.{$d['0']} <= {$tgl2})";
					$qjudul .= "  '{$tmp1['jam']}:{$tmp1['mnt']}:{$tmp1['dtk']}' \r\n                  <= ".ucfirst( strtolower( str_replace( "_", " ", $d[0] ) ) )." \r\n                  <= '{$tmp2['jam']}:{$tmp2['mnt']}:{$tmp2['dtk']}' <br>";
					$qinput .= " \r\n                  <input type=hidden name='{$d['0']}' value='{$tmp}'>\r\n                  <input type=hidden name='{$d['0']}1[jam]' value='{$tmp1['jam']}'>\r\n                  <input type=hidden name='{$d['0']}1[mnt]' value='{$tmp1['mnt']}'>\r\n                  <input type=hidden name='{$d['0']}1[dtk]' value='{$tmp1['dtk']}'>\r\n                  <input type=hidden name='{$d['0']}2[jam]' value='{$tmp2['jam']}'>\r\n                  <input type=hidden name='{$d['0']}2[mnt]' value='{$tmp2['mnt']}'>\r\n                  <input type=hidden name='{$d['0']}2[dtk]' value='{$tmp2['dtk']}'>\r\n                  ";
					$href .= "{$d['0']}={$tmp}&{$d['0']}1[jam]={$tmp1['jam']}&{$d['0']}1[mnt]={$tmp1['mnt']}&{$d['0']}1[dtk]={$tmp1['dtk']}&";
					$href .= "{$d['0']}2[jam]={$tmp2['jam']}&{$d['0']}2[mnt]={$tmp2['mnt']}&{$d['0']}2[dtk]={$tmp2['dtk']}&";
				}
			}
		}
	}
}
?>
