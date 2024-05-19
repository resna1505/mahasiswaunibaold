<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle>* {margin:0px;padding:0px;}</style>";
periksaroot( );
$maxbaris = 15;
$tinggibaris = 6.7 / $maxbaris;
getpenandatangan( );
$q = "SELECT penandatanganumum.FILE4 from penandatanganumum \r\n   WHERE ID=0";
$httd = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $httd ) )
{
    $dttd = sqlfetcharray( $httd );
    $gambarttd = $dttd[FILE4];
    $field = "FILE4";
    $idprodix = "";
}
unset( $dttd );
$q = "SELECT mahasiswa.*,dosen.NAMA AS NAMADOSEN,\r\n prodi.NAMA as NAMAP ,prodi.TINGKAT,\r\n mspst.NOMBAMSPST ,\r\n fakultas.NAMA as NAMAF, \r\n fakultas.NAMAPIMPINAN as DEKAN \r\n FROM mahasiswa LEFT JOIN dosen ON mahasiswa.IDDOSEN=dosen.ID\r\n \r\n \r\n \r\n ,prodi,mspst,departemen LEFT JOIN fakultas ON\r\n departemen.IDFAKULTAS=fakultas.ID\r\n \r\n \r\nWHERE 1=1 \r\nAND\r\nmahasiswa.IDPRODI=prodi.ID\r\nAND\r\ndepartemen.ID=prodi.IDDEPARTEMEN\r\nAND\r\nmspst.IDX=prodi.ID\r\nAND mahasiswa.ID='{$idmahasiswaupdate}'\r\n ";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    $dosenwali = $d[IDDOSEN];
}
echo "\r\n<div style='page-break-after:always;'>\r\n<table   >\r\n \r\n \r\n  <tr valign=top>\r\n    <td  style= border:none;  valign=top>\r\n    \r\n    <table  style='margin:0px;padding:0px;border-collapse:collapse;' border=0 >\r\n      <tr>\r\n        <td style='width:2.8cm;font-size:8pt;'><!-- NAMA--></td>\r\n \r\n        <td style='width:6cm;font-size:8pt;' colspan=2 >{$d['NAMA']}</td>\r\n      </tr>   \r\n      <tr>\r\n        <td style='width:2.8cm;font-size:8pt;'  nowrap><!--No. Induk / NIRM--></td>\r\n \r\n        <td style='width:6cm;font-size:8pt;' colspan=2 >{$idmahasiswaupdate}</td>\r\n      </tr>\r\n       <tr>\r\n        <td style='width:2.8cm;font-size:8pt;' nowrap><!--Tahun Akademik--></td>\r\n \r\n        <td style='width:4cm;font-size:8pt;'  > ".( $tahunupdate - 1 )."/{$tahunupdate}  </td>\r\n        <td style='width:2cm;font-size:8pt;'  > ".$arraysemester[$semesterupdate]."</td>\r\n      </tr>\r\n    </table>\r\n    \r\n    </td>\r\n    <td align=center style= border:none;  valign=top>\r\n    <table  width=100%  >\r\n       <tr>\r\n        <td style='width:1.5cm;font-size:8pt;'  ><!--Fakultas--></td>\r\n \r\n        <td style='font-size:8pt;' >{$d['NAMAF']} </td>\r\n      </tr>\r\n       <tr>\r\n        <td style='width:1.5cm;font-size:8pt;' ><!--Jurusan--></td>\r\n \r\n        <td style='font-size:8pt;' >{$d['NAMAP']} / ".$arrayjenjang[$d[TINGKAT]]."</td>\r\n      </tr>\r\n       <tr>\r\n        <td style='width:1.5cm;font-size:8pt;' ><!--P.A.--></td>\r\n \r\n        <td style='font-size:8pt;' >{$d['NAMADOSEN']} &nbsp;</td>\r\n      </tr>\r\n\r\n     </table>\r\n    \r\n    </td>\r\n\r\n\r\n  </tr>\r\n </table>\r\n    ";
$q = "\r\n    \t\t\t\tSELECT \r\n\t\t\t\tpengambilanmk.*,\r\n\t\t\t\ttbkmk.NAKMKTBKMK  AS NAMA,\r\n\t\t\t\tSKSMAKUL AS SKS  \r\n\t\t\t\tFROM msmhs,tbkmk,pengambilanmk \r\n\t\t\t\t\r\n\t\t\t\tWHERE\r\n\t\t\t\tpengambilanmk.IDMAHASISWA='{$idmahasiswaupdate}'\r\n\t\t\t\tAND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \r\n\t\t\t\tAND  pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \r\n\t\t\t\tAND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK\r\n\t\t\t\tAND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK\r\n\t\t\t\tAND msmhs.NIMHSMSMHS=pengambilanmk.IDMAHASISWA\r\n\r\n\r\n\t\t\t\tAND pengambilanmk.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmk.TAHUN='{$tahunupdate}'\r\n\t\t\t\t\r\n\t\t\t\tORDER BY \r\n\t\t\t\tpengambilanmk.IDMAKUL\r\n\r\n    ";
$h2 = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h2 ) )
{
    $semesterx = ( $tahunupdate - 1 - $d[ANGKATAN] ) * 2 + $semesterupdate;
    echo "\r\n     \r\n\t\t\t\t\t<table celpadding=0 cellspacing=0  border=0 style='border:none;'>\r\n        <tr align=center>\r\n          <!-- <td  ><b>NO</td> -->\r\n          <td style='width:2.3cm;height:1cm;border:none;'><!--<b>KODE MK --></td>\r\n          <td style='width:7.8cm;height:1cm;border:none;'><!--<b>MATA KULIAH --></td>\r\n          <td style='width:0.8cm;height:1cm;border:none;'><!--<b>SKS --></td>  \r\n          <td style='width:5.5cm;height:1cm;border:none;'><!--<b>NAMA DOSEN --></td> \r\n          <td style='width:0.5cm;height:1cm;border:none;'><!--<b>KET --></td> \r\n        </tr>\r\n      ";
    $i = 0;
    $totalsks = 0;
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        ++$i;
        $namadosenpengajar = "";
        $q = "SELECT dosen.ID,dosen.NAMA FROM dosen,dosenpengajar\r\n        WHERE\r\n        dosen.ID=dosenpengajar.IDDOSEN AND\r\n        '{$d2['IDMAKUL']}'=dosenpengajar.IDMAKUL AND\r\n\t\t\t\t'{$d2['TAHUN']}'=dosenpengajar.TAHUN AND\r\n\t\t\t\t'{$d2['SEMESTER']}'=dosenpengajar.SEMESTER AND \r\n\t\t\t\t'{$d2['KELAS']}'=dosenpengajar.KELAS AND\r\n\t\t\t\tdosenpengajar.IDPRODI='{$d['IDPRODI']}'\r\n        LIMIT 0,1";
        $h3 = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h3 ) )
        {
            $d3 = sqlfetcharray( $h3 );
            $namadosenpengajar = $d3[NAMA];
        }
        echo "\r\n        <tr  >\r\n          <!-- <td align=center>{$i}&nbsp;</td> -->\r\n          <td style='height:".$tinggibaris."cm;border:none;font-size:8pt;'>{$d2['IDMAKUL']}&nbsp;</td>\r\n          <td style='height:".$tinggibaris."cm;border:none;font-size:8pt;' nowrap>{$d2['NAMA']}&nbsp;</td>\r\n          <td style='height:".$tinggibaris."cm;border:none;font-size:8pt;' align=center>{$d2['SKS']}&nbsp;</td>       \r\n \r\n\t\t  <td style='height:".$tinggibaris."cm;border:none;font-size:8pt;' >{$namadosenpengajar}</td> \r\n\t\t  <td style='height:".$tinggibaris."cm;border:none;font-size:8pt;'>&nbsp;</td> \r\n        </tr>\r\n      ";
        $totalsks += $d2[SKS];
    }
    $sisabaris = $maxbaris - $i;
    $is = 1;
    while ( $is <= $sisabaris )
    {
        echo "\r\n\t\t\t\t\t\t\t\t<tr   align=left>\r\n\t\t \r\n\t\t\t\t\t\t\t\t\t<td style='height:".$tinggibaris."cm;border:none;font-size:8pt;' align=center> &nbsp;</td>\r\n\t\t\t\t\t\t\t\t\t<td style='height:".$tinggibaris."cm;border:none;font-size:8pt;' align=center>&nbsp; </td>\r\n\t\t\t\t\t\t\t\t\t<td style='height:".$tinggibaris."cm;border:none;font-size:8pt;'> </td>\r\n\t\t\t\t\t\t\t\t\t<td style='height:".$tinggibaris."cm;border:none;font-size:8pt;' align=center> </td>\r\n\t\t\t\t\t\t\t\t\t<td style='height:".$tinggibaris."cm;border:none;font-size:8pt;' align=center> </td>\r\n \r\n\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t";
        ++$is;
    }
    echo "\r\n        <tr valign=top>\r\n          <td  style='height:1cm;border:none;font-size:8pt;' colspan=2><!-- <b>JUMLAH SKS -->  </td>\r\n          <td  style='height:1cm;border:none;font-size:8pt;'  align=center><b>{$totalsks}&nbsp;</td>  \r\n          <td  style='height:1cm;border:none;font-size:8pt;'  >&nbsp;</td>\r\n          <td  style='height:1cm;border:none;font-size:8pt;'  >&nbsp;</td>\r\n \r\n        </tr>\r\n      ";
    echo "</table>";
}
echo "\r\n     \r\n     \r\n    <table  >\r\n      <tr valign=top>\r\n        <td  style= 'width:5cm;border:none;font-size:8pt;'  align=center> \r\n        <!-- Tanda Tangan<br>\r\n        Penasehat Akademik -->\r\n        <br><br>\r\n        <br><br><br><br><br><br><br> <br> \r\n         ";
if ( $d[NAMADOSEN] == "" )
{
    echo "Muhammad Ricky Sauqi\r\n        <!-- \r\n        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  \r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n         -->";
}
else
{
    echo "{$d['NAMADOSEN']}";
}
echo "  \r\n        </td>\r\n        <td style='width:5cm;'>&nbsp;</td>\r\n  \r\n \r\n        <td  style= 'width:5cm;border:none;font-size:8pt;'   align=center><br> \r\n        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {$waktu['mday']} ".$arraybulan[$waktu[mon] - 1]." {$waktu['year']}<br>\r\n         <!-- Mahasiswa --><br>\r\n                <br><br><br><br><br><br><br>  \r\n         \r\n        \r\n        {$d['NAMA']}\r\n          \r\n       \r\n        \r\n        </td>\r\n \r\n      </tr>\r\n \r\n    </table>";
echo "\r\n \r\n\r\n \r\n</div>\r\n";
?>
