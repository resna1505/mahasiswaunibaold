<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$namafakultas = $namadekan = $nipdekan = "";
$q = "SELECT * FROM fakultas WHERE ID='{$d['IDFAKULTAS']}'";
$hf = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $hf ) )
{
    $df = sqlfetcharray( $hf );
    $namafakultas = "{$df['NAMA']}";
    $namadekan = "{$df['NAMAPIMPINAN']}";
    $nipdekan = "{$df['NIPPIMPINAN']}";
}
getpenandatangan( );
$q = "SELECT penandatanganumum.FILE2,FILE1 from penandatanganumum \r\n   WHERE ID=0";
$httd = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $httd ) )
{
    $dttd = sqlfetcharray( $httd );
    $gambarttd1 = $dttd[FILE1];
    $gambarttd2 = $dttd[FILE2];
    $field1 = "FILE1";
    $field2 = "FILE2";
    $idprodix = "";
}
unset( $dttd );
$footertranskrip .= "\r\n    <style type=\"text/css\">\r\n\r\ntd {\r\n\tpadding:none;\r\n\t}\r\n\r\n</style> \r\n    ";
$footertranskrip .= "<br>\r\n\t\t\t\t\t\t<table border=0 width=100%  >\r\n\t\t\t\t\t\t\t<tr valign=top >\r\n \t\t\t\t\t\t\t\t<td align=left nowrap width=20%>&nbsp;</td><td width=20%>&nbsp;</td><td align=left nowrap width=35% >\r\n \t\t\t\t\t\t\t\t<!--\r\n\t\t\t\t\t\t\t\t\t{$jabatandirektur}";
if ( $gambarttd1 == "" )
{
    $footertranskrip .= "\r\n\t\t\t\t\t\t\t\t<br><br><br><br><br>";
}
else
{
    $footertranskrip .= "\r\n\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t<img src='lihat.php?idprodi={$idprodix}&field={$field1}' height=50> \r\n\t\t\t\t\t\t\t\t ";
}
$footertranskrip .= "<br>\r\n\t\t\t\t\t\t\t\t\t<u>{$namadirektur}</u> \t\t<br>\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\tNIDN. {$nipdirektur}\t\t\t\r\n                  -->\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td  >\r\n \t\t\t\t\t\t\t\t\t".$arraylokasi[$idlokasikantor].", {$w['mday']} ".$arraybulan[$w[mon] - 1]." {$w['year']} <br>\r\n \t\t\t\t\t\t\t\t\tDEKAN  FAKULTAS {$namafakultas}\r\n \t\t\t\t\t\t\t\t\t<br><br><br><br><br>\r\n \t\t\t\t\t\t\t\t\t\r\n                    <u>{$namadekan}</u><br>\r\n                    NIDN. {$nipdekan}\r\n                \r\n                </td>\r\n\r\n\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t \r\n\t\t\t\t\t";
$footertranskrip .= "							</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>";
?>
