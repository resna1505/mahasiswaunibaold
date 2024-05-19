<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
printjudulmenukecil( "<b>Validasi AKM-NLM-KRS-LSM" );
$q = "SELECT COUNT(NIMHSMSMHS) AS JML FROM msmhs  LEFT JOIN trakm\r\n   ON\r\n   KDPSTMSMHS =KDPSTTRAKM\r\n   AND KDJENMSMHS=KDJENTRAKM\r\n   AND KDPTIMSMHS=KDPTITRAKM\r\n   AND NIMHSMSMHS=NIMHSTRAKM\r\n   AND THSMSTRAKM='{$tahun}{$semester}'\r\n   \r\n   WHERE \r\n   KDPSTMSMHS ='{$kodeps}'\r\n   AND KDJENMSMHS='{$kodejenjang}'\r\n   AND KDPTIMSMHS='{$kodept}'\r\n\r\n   ";
$qf = "\r\n   AND KDPSTMSMHS ='{$kodeps}'\r\n   AND KDJENMSMHS='{$kodejenjang}'\r\n   AND KDPTIMSMHS='{$kodept}'\r\n    \r\n    ";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$jmlrec = $d[JML];
$norec = 1;
$norecw = $jmlrecw = $warnatidakvalid;
$nim = $nama = $tempat = $tgl = $tgl2 = $angkatan = $batas = $batas2 = $prop = $prop2 = $angkatan2 = $status = $tgllulus = $status2 = $status4 = $status5 = $status6 = $pindahanpt = $pindahanps = $pindahanpt2 = $pindahanps2 = 0;
$nimw = $namaw = $tempatw = $tglw = $tgl2w = $angkatanw = $batasw = $batas2w = $propw = $prop2w = $angkatan2w = $statusw = $tgllulusw = $status2w = $status4w = $status5w = $status6w = $pindahanptw = $pindahanpsw = $pindahanpt2w = $pindahanps2w = "";
$tmpdata = "";
if ( 0 < $jmlrec )
{
    $norec = 0;
    $norecw = $jmlrecw = "";
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS,SMAWLMSMHS,STMHSTRLSM,\r\n        trakm.SKSEMTRAKM+0 AS SKSEMTRAKM ,\r\n        SUM(tbkmk.SKSMKTBKMK) AS SKSKRS \r\n        FROM msmhs  \r\n        LEFT JOIN trakm \r\n           ON\r\n           KDPSTMSMHS =KDPSTTRAKM\r\n           AND KDJENMSMHS=KDJENTRAKM\r\n           AND KDPTIMSMHS=KDPTITRAKM\r\n           AND NIMHSMSMHS=NIMHSTRAKM\r\n           AND THSMSTRAKM='{$tahun2}{$semester2}'\r\n\r\n           LEFT JOIN trnlm\r\n           ON\r\n           KDPSTMSMHS =trnlm.KDPSTTRNLM\r\n           AND KDJENMSMHS=trnlm.KDJENTRNLM\r\n           AND KDPTIMSMHS=trnlm.KDPTITRNLM\r\n           AND NIMHSMSMHS=trnlm.NIMHSTRNLM\r\n           AND trnlm.THSMSTRNLM='{$tahun2}{$semester2}'\r\n            \r\n           LEFT JOIN tbkmk\r\n           ON\r\n\r\n           KDPSTMSMHS =tbkmk.KDPSTTBKMK\r\n           AND KDJENMSMHS=tbkmk.KDJENTBKMK\r\n           AND KDPTIMSMHS=tbkmk.KDPTITBKMK\r\n           AND trnlm.KDKMKTRNLM=tbkmk.KDKMKTBKMK\r\n           AND tbkmk.THSMSTBKMK='{$tahun2}{$semester2}'\r\n\r\n\r\n        LEFT JOIN trlsm \r\n           ON\r\n           KDPSTMSMHS =KDPSTTRLSM\r\n           AND KDJENMSMHS=KDJENTRLSM\r\n           AND KDPTIMSMHS=KDPTITRLSM\r\n           AND NIMHSMSMHS=NIMHSTRLSM\r\n           AND THSMSTRLSM='{$tahun2}{$semester2}'\r\n\r\n            WHERE \r\n           KDPSTMSMHS ='{$kodeps}'\r\n           AND KDJENMSMHS='{$kodejenjang}'\r\n           AND KDPTIMSMHS='{$kodept}'\r\n           AND SMAWLMSMHS<'".( $tahun + 1 )."{$semester}'\r\n           \r\n           \r\n           GROUP BY NIMHSMSMHS\r\n           ORDER BY NIMHSMSMHS\r\n \r\n          ";
    $h2 = mysqli_query($koneksi,$q);
    echo mysql_error( );
    while ( !( 0 < sqlnumrows( $h2 ) ) || !( $d2 = sqlfetcharray( $h2 ) ) )
    {
        $arraykrs[$d2[NIMHSMSMHS]] = $d2[SKSKRS];
        $arraykrsstatus[$d2[NIMHSMSMHS]] = $d2[STMHSTRLSM];
    }
    $q = "SELECT NIMHSMSMHS,NMMHSMSMHS,SMAWLMSMHS,STMHSTRLSM,STMHSMSMHS,\r\n        trakm.SKSEMTRAKM+0 AS SKSEMTRAKM ,\r\n        SUM(tbkmk.SKSMKTBKMK) AS SKSNLM \r\n        FROM msmhs  \r\n        LEFT JOIN trakm \r\n           ON\r\n           KDPSTMSMHS =KDPSTTRAKM\r\n           AND KDJENMSMHS=KDJENTRAKM\r\n           AND KDPTIMSMHS=KDPTITRAKM\r\n           AND NIMHSMSMHS=NIMHSTRAKM\r\n           AND THSMSTRAKM='{$tahun}{$semester}'\r\n\r\n           LEFT JOIN trnlm\r\n           ON\r\n           KDPSTMSMHS =trnlm.KDPSTTRNLM\r\n           AND KDJENMSMHS=trnlm.KDJENTRNLM\r\n           AND KDPTIMSMHS=trnlm.KDPTITRNLM\r\n           AND NIMHSMSMHS=trnlm.NIMHSTRNLM\r\n           AND trnlm.THSMSTRNLM='{$tahun}{$semester}'\r\n            \r\n           LEFT JOIN tbkmk\r\n           ON\r\n\r\n           KDPSTMSMHS =tbkmk.KDPSTTBKMK\r\n           AND KDJENMSMHS=tbkmk.KDJENTBKMK\r\n           AND KDPTIMSMHS=tbkmk.KDPTITBKMK\r\n           AND trnlm.KDKMKTRNLM=tbkmk.KDKMKTBKMK\r\n           AND tbkmk.THSMSTBKMK='{$tahun}{$semester}'\r\n\r\n\r\n        LEFT JOIN trlsm \r\n           ON\r\n           KDPSTMSMHS =KDPSTTRLSM\r\n           AND KDJENMSMHS=KDJENTRLSM\r\n           AND KDPTIMSMHS=KDPTITRLSM\r\n           AND NIMHSMSMHS=NIMHSTRLSM\r\n           AND THSMSTRLSM='{$tahun}{$semester}'\r\n            \r\n           \r\n           WHERE \r\n           KDPSTMSMHS ='{$kodeps}'\r\n           AND KDJENMSMHS='{$kodejenjang}'\r\n           AND KDPTIMSMHS='{$kodept}'\r\n           AND SMAWLMSMHS<'".( $tahun + 1 )."{$semester}'\r\n            \r\n           GROUP BY NIMHSMSMHS\r\n           ORDER BY NIMHSMSMHS\r\n \r\n          ";
    $h2 = mysqli_query($koneksi,$q);
    echo mysql_error( );
    $nim = sqlnumrows( $h2 );
    if ( 0 < $nim )
    {
        $i = 0;
        do
        {
            if ( !( $d2 = sqlfetcharray( $h2 ) ) )
            {
                break;
            }
            else
            {
                $statusok = 1;
            }
            if ( $d2[SKSEMTRAKM] == 0 && $d2[SKSNLM] == 0 && $arraykrs[$d2[NIMHSMSMHS]] == 0 && ( $d2[STMHSMSMHS] == "K" || $d2[STMHSMSMHS] == "L" || $d2[STMHSMSMHS] == "D" ) )
            {
                $statusok = 0;
            }
            if ( $statusok == 1 )
            {
                ++$i;
                $status = "";
                $stylestatus = "style='background-color:#FFFF00;' ";
                if ( 0 < $d2[SKSEMTRAKM] && 0 < $d2[SKSNLM] && 0 < $arraykrs[$d2[NIMHSMSMHS]] && ( $d2[STMHSTRLSM] == "A" || $d2[STMHSTRLSM] == "" ) )
                {
                    $status = "";
                    $stylestatus = "";
                }
                else if ( $d2[SKSEMTRAKM] == 0 && $d2[SKSNLM] == 0 && $arraykrs[$d2[NIMHSMSMHS]] == 0 && $d2[STMHSTRLSM] == "K" )
                {
                    $status = "{$d2['STMHSTRLSM']}-{$tahun}{$semester} ";
                    $stylestatus = "";
                }
                else if ( $d2[SKSEMTRAKM] == 0 && $d2[SKSNLM] == 0 && $arraykrs[$d2[NIMHSMSMHS]] == 0 && ( ( $d2[STMHSTRLSM] == "C" || $d2[STMHSTRLSM] == "N" ) && ( $arraykrsstatus[$d2[NIMHSMSMHS]] == "C" || $arraykrsstatus[$d2[NIMHSMSMHS]] == "N" ) ) )
                {
                    $status = "{$d2['STMHSTRLSM']}-{$tahun}{$semester} / ".$arraykrsstatus[$d2[NIMHSMSMHS]]."-{$tahun2}{$semester2}";
                    $stylestatus = "";
                }
                else if ( ( $d2[SKSEMTRAKM] == 0 || $d2[SKSNLM] == 0 || $arraykrs[$d2[NIMHSMSMHS]] == 0 ) && $d2[STMHSTRLSM] == "L" )
                {
                    $status = "{$d2['STMHSTRLSM']}-{$tahun}{$semester} ";
                    $stylestatus = "";
                }
                else if ( 0 < $d2[SKSEMTRAKM] && 0 < $d2[SKSNLM] && $arraykrs[$d2[NIMHSMSMHS]] == 0 && $arraykrsstatus[$d2[NIMHSMSMHS]] == "N" )
                {
                    $status = $arraykrsstatus[$d2[NIMHSMSMHS]]."-{$tahun2}{$semester2} ";
                    $stylestatus = "";
                }
                else if ( $d2[SKSEMTRAKM] == 0 && $d2[SKSNLM] == 0 && $d2[STMHSTRLSM] == "N" && ( $arraykrs[$d2[NIMHSMSMHS]] == 0 && $arraykrsstatus[$d2[NIMHSMSMHS]] == "" ) )
                {
                    $status = "{$d2['STMHSTRLSM']}-{$tahun}{$semester} / ??-{$tahun2}{$semester2} ";
                }
                else if ( $d2[SKSEMTRAKM] == 0 && 0 < $d2[SKSNLM] && ( $arraykrs[$d2[NIMHSMSMHS]] == 0 && $arraykrsstatus[$d2[NIMHSMSMHS]] == "" ) )
                {
                    $status = "0,00  / ??-{$tahun2}{$semester2} ";
                }
                else if ( 0 < $d2[SKSEMTRAKM] && 0 < $d2[SKSNLM] && ( $arraykrs[$d2[NIMHSMSMHS]] == 0 && $arraykrsstatus[$d2[NIMHSMSMHS]] == "" ) )
                {
                    $status = "0,00  / ??-{$tahun2}{$semester2} ";
                }
                else if ( ( 0 < $d2[SKSEMTRAKM] || 0 < $d2[SKSNLM] ) && $d2[STMHSTRLSM] == "C" )
                {
                    $status = "{$d2['STMHSTRLSM']}-{$tahun}{$semester}.. ?? ";
                }
                else if ( $d2[SKSEMTRAKM] == 0 && $d2[SKSNLM] == 0 && $d2[STMHSTRLSM] == "" && ( $arraykrs[$d2[NIMHSMSMHS]] == 0 && $arraykrsstatus[$d2[NIMHSMSMHS]] == "" ) )
                {
                    $status = "{$d2['STMHSTRLSM']}-{$tahun}{$semester}.. ??  ";
                }
                else if ( $d2[SKSEMTRAKM] == 0 && $d2[SKSNLM] == 0 && 0 < $arraykrs[$d2[NIMHSMSMHS]] && $d2[SMAWLMSMHS] == "{$tahun2}{$semester2}" )
                {
                    $status = "";
                    $stylestatus = "";
                }
                else if ( $tahun.$semester < $d2[SMAWLMSMHS] && ( $d2[SKSEMTRAKM] == 0 && $d2[SKSNLM] == 0 ) && ( $arraykrs[$d2[NIMHSMSMHS]] == 0 && $arraykrsstatus[$d2[NIMHSMSMHS]] == "" ) )
                {
                    $status = " ??  ";
                }
                $tmpdata .= "\r\n           <tr {$stylestatus}>\r\n            <td align=center>{$i}</td>\r\n            <td align=center> {$d2['NIMHSMSMHS']}</td>\r\n            <td>  {$d2['NMMHSMSMHS']} </td>\r\n            <td align=center>  {$d2['SMAWLMSMHS']} </td>\r\n            <td align=center>  ".( $d2[SKSEMTRAKM] + 0 )." </td>\r\n            <td align=center>  ".( $d2[SKSNLM] + 0 )." </td>\r\n            <td align=center>  ".( $arraykrs[$d2[NIMHSMSMHS]] + 0 )." </td>\r\n            <td align=center>  {$d2['STMHSMSMHS']} </td>\r\n            <td align=center>  {$d2['STMHSTRLSM']} </td>\r\n            <td align=center>  ".$arraykrsstatus[$d2[NIMHSMSMHS]]." </td>\r\n            <td align=center> \r\n            {$status}  </td>\r\n            \r\n            \t\r\n            </tr>\r\n           ";
            }
        } while ( 1 );
    }
    echo "\r\n  <table width=95% class=form>\r\n   <tr  align=center class=juduldata>\r\n    <td rowspan=2> NO</td>\r\n    <td rowspan=2>  NIM </td>\r\n    <td rowspan=2>  NAMA </td>\r\n    <td rowspan=2>  SEM AWAL </td>\r\n    <td colspan=3>  SKS </td>\r\n    <td rowspan=2>  Status di MSMHS </td>\r\n    <td rowspan=2>  Status {$tahun}{$semester} </td>\r\n    <td rowspan=2>  Status {$tahun2}{$semester2} </td>\r\n    <td rowspan=2>  STATUS <br> (C/N/D/K)</td>\r\n  </tr>\r\n  <tr  align=center class=juduldata>\r\n     <td>  AKM </td>\r\n    <td>  NLM</td>\r\n    <td>  KRS </td>\r\n    </tr>\r\n   {$tmpdata}\r\n \r\n  </table>\r\n  \r\n  ";
}
echo " \r\n";
?>
