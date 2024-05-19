<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$namafakultas = "";
$q = "SELECT NAMA FROM fakultas WHERE ID='{$d['IDFAKULTAS']}'";
$hf = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $hf ) )
{
    $df = sqlfetcharray( $hf );
    $namafakultas = "{$df['NAMA']}";
}

$headerkhs .= "<center>
                    <h3 align=center>".strtoupper($namafakultas)."<br>KARTU HASIL STUDI</h3><br>
                    <table width=100%>
                        <tr valign=top>
			    <td width=50%   valign=top >
                                <table>
                                    <tr align=left class='loseborder' >
                                        <td class='loseborder' valign=top>NPM</td>
                                        <td class='loseborder' valign=top>: {$d['ID']}&nbsp;</td>
                                    </tr>
                                    <tr align=left>
                                        <td class='loseborder' valign=top>Nama </td>
                                        <td class='loseborder' valign=top>: {$d['NAMA']}&nbsp;</td>
                                    </tr>
                                    <tr align=left>
                                        <td class='loseborder' valign=top>Semester</td>
                                        <td class='loseborder' valign=top>: ".$semesterhitung." (".$arraysemester[$semester].")&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                            <td width=50%  valign=top>
                                <table    > 
                                    <tr align=left>
                                        <td class='loseborder' valign=top> Prog/Jen. Studi</td>
                                        <td class='loseborder' valign=top nowrap>: ".$arrayprodi[$d['IDPRODI']]." - ".$arrayjenjang[$d['TINGKAT']]."&nbsp;</td>
                                    </tr>
                                    <tr align=left>
                                        <td class='loseborder' valign=top nowrap>Tahun Akademik</td>
                                        <td class='loseborder' valign=top>: ".( $tahun - 1 )."/{$tahun} &nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </table>";
?>
