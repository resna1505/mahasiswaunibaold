<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$q = "\r\n\t\t\t\tSELECT IDKONVERSI,SIMBOL,NILAI,SYARAT FROM konversiumumsp\r\n\t\t\t\tORDER BY NILAI DESC\r\n\t\t\t";
$hb = mysqli_query($koneksi,$q);
unset( $arraybobotnilai );
while ( !sqlnumrows( $hb ) || !( $db = sqlfetcharray( $hb ) ) )
{
    $arraybobotnilai["{$db['SIMBOL']}"] = "{$db['NILAI']}";
}
if ( is_array( $arraybobotnilai ) )
{
    echo "\r\n          <script>\r\n            function setbobot(nilai,bobot) { ";
    foreach ( $arraybobotnilai as $k => $v )
    {
        echo "\r\n                if (nilai.value=='{$k}') {\r\n                  bobot.value='{$v}';\r\n                } else\r\n                ";
    }
    echo "\r\n               {\r\n               }\r\n            }\r\n          </script>\r\n          \r\n          ";
}
if ( $aksi2 == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Nilai SP Mahasiswa", SIMPAN_DATA );
        unset( $_SESSION['token'] );
    }
    else if ( is_array( $datamakul ) )
    {
        foreach ( $datamakul as $k => $v )
        {
            $str = "nilai_{$k}";
            $nilai[$k] = $$str;
            $str = "bobot_{$k}";
            $bobot[$k] = $$str;
            $vld[] = cekvaliditasnilaihuruf( "Nilai {$k} : {$nilai[$k]}", $nilai[$k] );
            $vld[] = cekvaliditasnilaibobot( "Bobot {$k} : {$bobot[$k]}", $bobot[$k] );
        }
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
        }
        else
        {
            foreach ( $nilai as $k => $v )
            {
                $q = "UPDATE pengambilanmksp SET \r\n      SIMBOL='{$v}',\r\n      BOBOT='".$bobot[$k]."'\r\n      WHERE IDMAHASISWA='{$id}' AND\r\n      TAHUN='".( $tahunupdate + 1 )."' AND\r\n      SEMESTER='{$semesterupdate}' AND\r\n      IDMAKUL='{$k}'\r\n      ";
                mysqli_query($koneksi,$q);
                $q = "UPDATE trnlmsp SET \r\n      NLAKHTRNLM ='{$v}',\r\n      BOBOTTRNLM ='".$bobot[$k]."'\r\n      WHERE NIMHSTRNLM ='{$id}' AND\r\n       THSMSTRNLM ='{$tahunupdate}{$semesterupdate}' AND\r\n      KDKMKTRNLM ='{$k}'\r\n      ";
                mysqli_query($koneksi,$q);
                $ketlog = "Edit Nilai SP Mahasiswa {$id}, MK={$k}, TAHUN={$tahunupdate}/".( $tahunupdate + 1 ).", SEM={$semesterupdate}, SIMBOL={$v}, BOBOT=".$bobot[$k]."";
                buatlog( 58 );
            }
            $errmesg = "Data nilai telah disimpan.";
        }
    }
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
printmesg( $errmesg );
$q = "\r\n\t\t\t\tSELECT \r\n        pengambilanmksp.BOBOT,\r\n        pengambilanmksp.SIMBOL,\r\n        pengambilanmksp.IDMAKUL,\r\n\t\t\t\tpengambilanmksp.TAHUN,\r\n\t\t\t\tmakul.NAMA NAMAMAKUL,pengambilanmksp.NAMA,pengambilanmksp.SKSMAKUL AS SKS,\r\n\t\t\t\tpengambilanmksp.SEMESTER AS SEMESTERS,\r\n\t\t\t\tpengambilanmksp.SEMESTERMAKUL AS SEMESTER \r\n\t\t\t\tFROM pengambilanmksp,makul \r\n\t\t\t\tWHERE \r\n\t\t\t\tpengambilanmksp.IDMAKUL=makul.ID\r\n\t\t\t\tAND IDMAHASISWA='{$d['ID']}'  \r\n\t\t\t\tORDER BY pengambilanmksp.TAHUN,pengambilanmksp.SEMESTER,\r\n\t\t\t\tpengambilanmksp.IDMAKUL\r\n\t\t\t";
$q = "\r\n\t\t\t\tSELECT \r\n        pengambilanmksp.BOBOT,\r\n        pengambilanmksp.SIMBOL,\r\n        pengambilanmksp.IDMAKUL,\r\n\t\t\t\tpengambilanmksp.TAHUN,\r\n  \t\t\ttbkmksp.NAKMKTBKMK AS NAMAMAKUL,\r\n        pengambilanmksp.NAMA,\r\n        pengambilanmksp.SKSMAKUL AS SKS,\r\n\t\t\t\tpengambilanmksp.SEMESTER AS SEMESTERS,\r\n\t\t\t\tpengambilanmksp.SEMESTERMAKUL AS SEMESTER \r\n\t\t\t\t\r\n\t\t\t\tFROM pengambilanmksp,tbkmksp,msmhs\r\n\t\t\t\tWHERE\r\n\t\t\t\tpengambilanmksp.IDMAHASISWA='{$idmahasiswa}'\r\n\t\t\t\tAND pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  \r\n\t\t\t\tAND pengambilanmksp.THNSM=tbkmksp.THSMSTBKMK  \r\n\t\t\t\tAND msmhs.KDPSTMSMHS=tbkmksp.KDPSTTBKMK\r\n\t\t\t\tAND msmhs.KDJENMSMHS=tbkmksp.KDJENTBKMK\r\n\t\t\t\tAND msmhs.NIMHSMSMHS=pengambilanmksp.IDMAHASISWA\r\n\t\t\t\t \r\n \t\t\t\tORDER BY \r\n\t\t\t\tpengambilanmksp.TAHUN,pengambilanmksp.SEMESTER,pengambilanmksp.IDMAKUL \r\n\t\t\t";
$hn = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $hn ) )
{
    if ( $semester != 3 )
    {
        $semesterhitung = ( $tahun - 1 - $d[ANGKATAN] ) * 2 + $semester;
    }
    else
    {
        $semesterhitung = ( $tahun - 1 - $d[ANGKATAN] ) * 2 + 0.5;
    }
    echo "\r\n\t\t\t\t\t<br>\r\n  \t\t\t\t\r\n \r\n\t\t\t\t";
    $i = 1;
    $tahunii = 0;
    $semlama = $semlast = $semesterhitungx = 0;
    while ( $d2 = sqlfetcharray( $hn ) )
    {
        unset( $kp );
        if ( $d2[SEMESTERS] != 3 )
        {
            $semesterhitungx = ( $d2[TAHUN] - 1 - $d[ANGKATAN] ) * 2 + $d2[SEMESTERS];
        }
        else
        {
            $semesterhitungx = ( $d2[TAHUN] - 1 - $d[ANGKATAN] ) * 2 + 0.5;
        }
        $kelas = kelas( $i );
        $semlama = $semesterhitungx;
        $kelas = kelas( $i );
        $nilai = "";
        $total = "";
        $bobot = "";
        $nilaiakhir = $nilaiakhirdicari = $totalmax = $totalmaxdicari = $bobotmax = $bobotmaxdicari = $simbolmax = $simbolmaxdicari = "-";
        $nilaiakhir = $nilaiakhirdicari;
        $totalmax = $totalmaxdicari;
        $bobotmax = $bobotmaxdicari;
        $simbolmax = $simbolmaxdicari;
        if ( $semesterhitungx != $semlast )
        {
            $i = 1;
            if ( 0 < $semlast )
            {
                echo "\r\n\t\t\t\t\t\t\t\t\t<tr align=center >\r\n\t\t\t\t\t\t\t\t\t<td></td>\r\n\t\t\t\t\t\t\t\t\t\t<td colspan=4 align=left>JUMLAH NILAI  </td>\r\n\t\t\t\t\t\t\t\t\t\t<td  >\r\n\t\t\t\t\t\t\t\t\t\t".number_format_sikad( $totals[$semlast], 2 )."\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t<tr align=center >\r\n\t\t\t\t\t\t\t\t\t\t<td></td>\r\n                    <td  colspan=4 align=left>JUMLAH SKS  </td>\r\n\t\t\t\t\t\t\t\t\t\t<td  >\r\n\t\t\t\t\t\t\t\t\t\t".number_format_sikad( $bobots[$semlast], 2 )."\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t<tr  align=center>\r\n\t\t\t\t\t\t\t\t\t\t<td></td>\r\n                    <td  colspan=4 align=left>IP SEMESTER</td>\r\n\t\t\t\t\t\t\t\t\t\t<td >\r\n\t\t\t\t\t\t\t\t\t\t".number_format_sikad( @$totals[$semlast] / @$bobots[$semlast], 2 )."\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t </table>\r\n                 </form>\r\n                  ";
            }
            $semesterupdate = $semesterhitungx % 2;
            if ( $semesterupdate == 0 )
            {
                $semesterupdate = 2;
            }
            else if ( 2 < $semesterhitungx )
            {
                $tahunii = floor( $semesterhitungx / 2 );
            }
            $tahunupdate = $d2[TAHUN] - 1;
            echo "\r\n  \t\t\t\t\r\n\t        <form action='index.php' method=post>\r\n          <input type=hidden name=pilihan value='{$pilihan}'> \r\n          <input type=hidden name=aksi value='{$aksi}'> \r\n\t\t  <input type=hidden name=sessid value='{$token}'> \r\n          <input type=hidden name=id value='{$id}'> \r\n          <input type=hidden name=tahunupdate value='{$tahunupdate}'> \r\n          <input type=hidden name=semesterupdate value='{$semesterupdate}'> \r\n\r\n\r\n\t\t\t\t\t<table {$border} height=100% width=95%>\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t \r\n\t\t\t\t\t\t\t<td  colspan=5><b>Semester ".( $semesterhitungx + $plus1 )."</b>,  {$tahunupdate}/".( $tahunupdate + 1 )." ".$arraysemester[$semesterupdate]."</td>\r\n\t\t\t\t\t\t\t \r\n\t\t\t\t\t  \r\n\t\t\t\t\t\t\t";
            if ( $tingkataksesusers[$kodemenu] == "T" )
            {
                echo "<input type=submit name=aksi2 value='Simpan'>";
            }
            echo "\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t \r\n\t\t\t\t\t\t\t<td  >No</td>\r\n\t\t\t\t\t\t\t<td >Kode</td>\r\n\t\t\t\t\t\t\t<td >Nama Mata Kuliah</td>\r\n\t\t\t\t\t \r\n\t\t\t\t\t\t\t<td >SKS</td>\r\n\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t<td>Lambang</td>\r\n\t\t\t\t\t\t\t<td>Mutu</td>\r\n\t\t\t\t\t\t</tr>\r\n \t\t\t\t\r\n \r\n\t\t\t\t";
            $semlast = $semesterhitungx;
        }
        $nilai = $d2[SIMBOL];
        $bobot = $d2[BOBOT];
        if ( $d2[SIMBOL] != "" && $d2[SIMBOL] != "T" )
        {
            $totalnilaiakhir += $nilaiakhir;
            $nilai = $d2[SIMBOL];
            $bobot = $d2[BOBOT];
            $total = number_format_sikad( $d2[SKS] * $d2[BOBOT], 2, ".", "," );
            $totals += $semesterhitungx;
            $totalsemua += $totalmax;
            $bobots += $semesterhitungx;
            $bobotsemua += $d2[SKS];
        }
        if ( $d2[NAMA] == "" )
        {
            $d2[NAMA] = $d2[NAMAMAKUL];
        }
        echo "\r\n\t\t\t\t\t\t\t\t<tr {$kelas}{$cetak} align=left>\r\n\t\t \r\n\t\t\t\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$d2['IDMAKUL']}  </td>\r\n\t\t\t\t\t\t\t\t\t<td>{$d2['NAMA']}  </td>\r\n\t\t\t\t\t \r\n\t\t\t\t\t\t\t\t\t<td align=center>{$d2['SKS']} </td>\r\n                  ";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "\r\n\t\t\t\t\t\t\t\t\t<td align=center> \r\n                  <input type=hidden name='datamakul[{$d2['IDMAKUL']}]' value='1'>\r\n                    <input type=text name='nilai_{$d2['IDMAKUL']}' value='{$nilai}' size=2 \r\n                    onBlur=\"setbobot(nilai_{$d2['IDMAKUL']},bobot_{$d2['IDMAKUL']});\"              >\r\n                    \r\n                    </td>\r\n  \t\t\t\t\t\t\t\t\t<td align=center> <input type=text name='bobot_{$d2['IDMAKUL']}' value='{$bobot}' size=2></td>";
        }
        else
        {
            echo "\r\n\t\t\t\t\t\t\t\t\t<td align=center> \r\n                     {$nilai} </td>\r\n  \t\t\t\t\t\t\t\t\t<td align=center>  {$bobot} </td>";
        }
        echo "\r\n \r\n\t\t\t\t\t\t \r\n\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
        $idmakul = $d2[IDMAKUL];
        ++$i;
    }
    if ( $semlama != "" && $semesterhitungx == $semlama )
    {
        echo "\r\n\t\t\t\t\t\t\t\t\t<tr align=center >\r\n\t\t\t\t\t\t\t\t\t<td></td>\r\n\t\t\t\t\t\t\t\t\t\t<td  colspan=4 align=left>JUMLAH NILAI  </td>\r\n\t\t\t\t\t\t\t\t\t\t<td  >\r\n\t\t\t\t\t\t\t\t\t\t".number_format_sikad( $totals[$semlast], 2 )."\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t<tr align=center >\r\n\t\t\t\t\t\t\t\t\t\t<td></td>\r\n                    <td colspan=4  align=left>JUMLAH SKS  </td>\r\n\t\t\t\t\t\t\t\t\t\t<td  >\r\n\t\t\t\t\t\t\t\t\t\t".number_format_sikad( $bobots[$semlast], 2 )."\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t<tr  align=center>\r\n\t\t\t\t\t\t\t\t\t\t<td></td>\r\n                    <td  colspan=4 align=left>IP SEMESTER</td>\r\n\t\t\t\t\t\t\t\t\t\t<td  >\r\n\t\t\t\t\t\t\t\t\t\t".number_format_sikad( @$totals[$semlast] / @$bobots[$semlast], 2 )."\r\n\t\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t</form>\r\n\t\t\t\t\t\t\t\t";
    }
    if ( $semlama != "" )
    {
        $arrayipkmhs = getipk( $d[ID], $tahunupdate + 1, $semesterupdate, $nilaidiambil );
        $ipkmhs = $arrayipkmhs[0];
        $sksmhs = $arrayipkmhs[1];
        echo "  \r\n\t\t\t\t\t\t<table width=90% border=1 style='border-collapse:collapse;'>\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t\t<td  align=left>TOTAL NILAI</td>\r\n\t\t\t\t\t\t\t\t<td align=center> \r\n\t\t\t\t\t\t\t\t".number_format_sikad( $sksmhs * $ipkmhs, 2 )."\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t\t<td  align=left>TOTAL SKS TELAH DITEMPUH</td>\r\n\t\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t".number_format_sikad( $sksmhs, 2 )."\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t\t\t<td  align=left>IP KUMULATIF</td>\r\n\t\t\t\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t\t\t".number_format_sikad( $ipkmhs, 2 )."\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t";
    }
}
?>
