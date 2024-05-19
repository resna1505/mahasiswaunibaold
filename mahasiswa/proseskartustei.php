<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "\r\n\r\n";
periksaroot( );
unset( $arraysort );
$arraysort[0] = "mahasiswa.IDPRODI";
$arraysort[1] = "mahasiswa.ANGKATAN";
$arraysort[2] = "mahasiswa.ID";
$arraysort[3] = "mahasiswa.NAMA";
$arraysort[4] = "mahasiswa.STATUS";
$arraysort[5] = "mahasiswa.IDDOSEN";
$konfigkartu = getsettingkartu( );
$gambarbackground = "";
include( "../fungsibarcode128.php" );
$logo = file( "{$dirgambar}/logo.txt" );
$size = imgsizeproph( "{$dirgambar}/{$logo['0']}", 80 );
$stylecetak = " style='font-family:Arial;font-size:7pt;' ";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $idprodi != "" )
{
    $qfield .= " AND mahasiswa.IDPRODI='{$idprodi}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodi[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $jenisusers == 1 )
{
    $iddosen = $users;
}
if ( $iddosen != "" )
{
    $qfield .= " AND mahasiswa.IDDOSEN='{$iddosen}'";
    $qjudul .= " Dosen Wali '".$arraydosen[$iddosen]."' <br>";
    $qinput .= " <input type=hidden name=iddosen value='{$iddosen}'>";
    $href .= "iddosen={$iddosen}&";
}
if ( $angkatan != "" )
{
    $qfield .= " AND mahasiswa.ANGKATAN='{$angkatan}'";
    $qjudul .= " Angkatan '{$angkatan}' <br>";
    $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
    $href .= "angkatan={$angkatan}&";
}
if ( $id != "" )
{
    $qfield .= " AND mahasiswa.ID LIKE '%{$id}%'";
    $qjudul .= " NIM mengandung kata '{$id}' <br>";
    $qinput .= " <input type=hidden name=id value='{$id}'>";
    $href .= "id={$id}&";
}
if ( $nama != "" )
{
    $qfield .= " AND mahasiswa.NAMA LIKE '%{$nama}%'";
    $qjudul .= " Nama mengandung kata '{$nama}' <br>";
    $qinput .= " <input type=hidden name=nama value='{$nama}'>";
    $href .= "nama={$nama}&";
}
if ( $statusawal != "" )
{
    $qjudul .= " Status Awal '".$arraystatusmhsbaru["{$statusawal}"]."' <br>";
    $qinput .= " <input type=hidden name=statusawal value='{$statusawal}'>";
    $href .= "statusawal={$statusawal}&";
    $qfield .= " AND msmhs.STPIDMSMHS='{$statusawal}'";
}
if ( $status != "" )
{
    $qfield .= " AND mahasiswa.STATUS='{$status}'";
    $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
    $qinput .= " <input type=hidden name=status value='{$status}'>";
    $href .= "status={$status}&";
    if ( $iftahunakademik == 1 )
    {
        $qtabel = ", trlsm ";
        $qtabel2 = " trlsm, ";
        $qfield .= "\r\n        AND mahasiswa.ID=trlsm.NIMHSTRLSM\r\n        AND trlsm.THSMSTRLSM='{$tahun2}{$semester2}' AND trlsm.STMHSTRLSM='{$status}'\r\n      ";
        $qjudul .= " Periode Tahun Akademik : {$tahun2}/".( $tahun2 + 1 )." ".$arraysemester[$semester2]." <br>";
        $qinput .= " \r\n      <input type=hidden name=iftahunakademik value='{$iftahunakademik}'>\r\n      <input type=hidden name=tahun2 value='{$tahun2}'>\r\n      <input type=hidden name=semester2 value='{$semester2}'>\r\n      ";
    }
}
if ( $jeniskelas != "" )
{
    $qfield .= " AND mahasiswa.JENISKELAS='{$jeniskelas}'";
    $qjudul .= " Jenis Kelas '".$arraykelasstei["{$jeniskelas}"]."' <br>";
    $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
    $href .= "jeniskelas={$jeniskelas}&";
}
if ( $tahuna != "" && $semestera != "" )
{
    $qfield .= " AND msmhs.SMAWLMSMHS='".$tahuna."{$semestera}'";
    $qjudul .= " Semester Awal '".$arraysemester["{$semestera}"]."  {$tahuna}' <br>";
    $qinput .= " <input type=hidden name=tahuna value='{$tahuna}'>";
    $qinput .= " <input type=hidden name=semestera value='{$semestera}'>";
    $href .= "semestera={$semestera}&tahuna={$tahuna}&";
}
include( "prosescari2.php" );
if ( $arraysort[$sort] == "" )
{
    $sort = 2;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM {$qtabel2} mahasiswa LEFT JOIN mahasiswa2 ON mahasiswa.ID=mahasiswa2.ID,msmhs \r\n\tWHERE \r\n  mahasiswa.ID=msmhs.NIMHSMSMHS\r\n   {$qprodidep2}\r\n\t{$qfield}\r\n\t";
$h = doquery($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
unset( $arraydatakartupilih );
$arraydatakartupilih = explode( " ", $konfigkartu[DATA] );
$q = "SELECT mahasiswa.NAMA,mahasiswa.ID ,\r\n\tprodi.NAMA AS NAMAP,fakultas.NAMA AS NAMAF,\r\n\tCONCAT(mahasiswa.TEMPAT,', ',DATE_FORMAT(mahasiswa.TANGGAL,'%d-%m-%Y')) AS TTL\r\n  FROM {$qtabel2} mahasiswa LEFT JOIN mahasiswa2 ON mahasiswa.ID=mahasiswa2.ID,msmhs,prodi,departemen LEFT JOIN fakultas ON   \r\n  departemen.IDFAKULTAS=fakultas.ID \r\n\r\n\tWHERE 1=1 AND\r\n  mahasiswa.IDPRODI=prodi.ID AND\r\n  prodi.IDDEPARTEMEN=departemen.ID AND\r\n  msmhs.NIMHSMSMHS=mahasiswa.ID\r\n  {$qprodidep2}\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $baris = 0;
    $kolom = 0;
    if ( $konfigkartu[LATAR] == 0 )
    {
        $bgkartu = "background:#{$konfigkartu['LATARWARNA']};";
    }
    else
    {
        $bgkartu = "background:url(kartu/{$konfigkartu['LATARFOTO']});background-repeat:no-repeat;background-position: center;";
    }
    do
    {
        if ( !( $d = sqlfetcharray( $h ) ) )
        {
            break;
        }
        else
        {
            ++$baris;
            $l = 1;
            createbarcode128( "{$d['ID']}", "barcode/{$d['ID']}", "B", 0 );
            echo "\t\t<table  border=1 cellspacing=0 cellpadding=0\r\n    style='";
            echo $bgkartu;
            echo "    width:";
            echo $konfigkartu[PANJANG];
            echo "mm;height:";
            echo $konfigkartu[LEBAR];
            echo "mm;'>\r\n\t\t<tr valign=top><td>\r\n\t\t<table  border=0 cellspacing=4 cellpadding=0 \r\n\t\tstyle='border:yes;border-width:1;border-collapse:collapse;'\r\n\t\t style='";
            echo $bgkartu;
            echo " border:yes;border-width:1;border-collapse:collapse;width:";
            echo $konfigkartu[PANJANG];
            echo "mm;height:";
            echo $konfigkartu[LEBAR];
            echo "mm;'>\r\n\t\t<tr valign=top >\r\n\t\t<td colspan=3  align=center valign=top\r\n    >\r\n\t \r\n\t\t\r\n\t\t";
            echo "\r\n\t\t<table width=100% cellpadding=1 cellspacing=1>\r\n\t\t  <tr>";
        }
        if ( $konfigkartu[ISLOGOKIRI] == 1 && $konfigkartu[LOGOKIRI] != "" && file_exists( "kartu/{$konfigkartu['LOGOKIRI']}" ) )
        {
            echo "\r\n        <td align=left valign=top>\r\n      \t\t<img  src='kartu/{$konfigkartu['LOGOKIRI']}' style='width:{$konfigkartu['PLKIRI']}mm;height:{$konfigkartu['LLKIRI']}mm;' > \r\n        </td>\r\n        ";
        }
        echo "\r\n        <td align=center width=* nowrap valign=top>\r\n        <b>";
        if ( trim( $konfigkartu[HEADER1] ) != "" )
        {
            echo "\r\n\t\t<font style='font-size:{$konfigkartu['UHEADER1']}pt;font-family:{$konfigkartu['FHEADER1']};color:#{$konfigkartu['WHEADER1']};'>\r\n\t\t{$konfigkartu['HEADER1']}<br></font> \r\n          ";
        }
        if ( trim( $konfigkartu[HEADER2] ) != "" )
        {
            echo "\r\n\t\t<font style='font-size:{$konfigkartu['UHEADER2']}pt;font-family:{$konfigkartu['FHEADER2']};color:#{$konfigkartu['WHEADER2']};'>\r\n\t\t{$konfigkartu['HEADER2']}<br></font> \r\n          ";
        }
        if ( trim( $konfigkartu[HEADER3] ) != "" )
        {
            echo "\r\n\t\t<font style='font-size:{$konfigkartu['UHEADER3']}pt;font-family:{$konfigkartu['FHEADER3']};color:#{$konfigkartu['WHEADER3']};'>\r\n\t\t{$konfigkartu['HEADER3']}</font> \r\n          ";
        }
        echo "\r\n         </td>";
        if ( $konfigkartu[ISLOGOKANAN] == 1 && $konfigkartu[LOGOKANAN] != "" && file_exists( "kartu/{$konfigkartu['LOGOKANAN']}" ) )
        {
            echo "\r\n        <td align=right valign=top>\r\n      \t\t<img  src='kartu/{$konfigkartu['LOGOKANAN']}' style='width:{$konfigkartu['PLKANAN']}mm;height:{$konfigkartu['LLKANAN']}mm;' > \r\n        </td>\r\n        ";
        }
        echo "\r\n      </tr>\r\n\t\t</table>\r\n<!--\r\n\t\t<img valign=middle align=left src='{$dirgambar}/{$logo['0']}' style='font-size:6pt;'  height=60 border=0> \r\n \r\n\t\t<b>\r\n\t\t<font style='font-size:6pt;'>\r\n\t\t<br></font>\r\n\t\t\r\n\t\t<font style='font-size:10pt;'>\r\n\t\t{$namakantor}</b></font> \r\n\t\t<font style='font-size:6pt;'><br>{$alamat}</font>\r\n-->\t\t \r\n\t\t</td><td>\r\n\t\t </td>\r\n\t\t</tr>\r\n\t\t<tr valign=top>\r\n \t\t\t<td valign=top >";
        $stylecetaktmp = "style='font-size:{$konfigkartu['UDATA']}pt;font-family:{$konfigkartu['FDATA']};color:#{$konfigkartu['WDATA']};'";
        if ( is_array( $arraydatakartupilih ) )
        {
            echo "\r\n      \t\t<table    border=0 cellpadding=0>";
            foreach ( $arraydatakartupilih as $v )
            {
                if ( $v != "" )
                {
                    echo "\r\n      \t\t  <tr  valign=top>\r\n      \t\t   <td nowrap {$stylecetaktmp}\r\n      \t\t     valign=top  >".$arraydatakartu[$v][J]." </td>\r\n      \t\t   <td    {$stylecetaktmp}> : </td>\r\n      \t\t   <td {$stylecetaktmp}> ".$d[$arraydatakartu[$v][F]]."</td>\r\n      \t\t  </tr>\r\n            ";
                }
            }
            echo "\r\n      \t\t</table>\r\n        ";
        }
        echo "\r\n       </td><td rowspan=2 valign=top align=right>\r\n \t\t ";
        if ( $konfigkartu[ISFOTO] == 1 && file_exists( "foto/{$d['ID']}" ) )
        {
            echo "\r\n\t\t\t  \r\n\t\t\t   <img src='foto/{$d['ID']}' style='height:{$konfigkartu['LEBARF']}mm; width:{$konfigkartu['PANJANGF']}mm;' >";
        }
        else
        {
            echo " ";
        }
        echo "\r\n \r\n  \r\n\t\t </td>\r\n\t\t </tr>\r\n <tr>\r\n <td  >\r\n";
        if ( $konfigkartu[ISBARCODE] == 1 && file_exists( "barcode/{$d['ID']}.png" ) )
        {
            echo "\r\n\t\t\t  \r\n\t\t\t   <img src='barcode/{$d['ID']}.png'  >";
        }
        else
        {
            echo " ";
        }
        echo " \r\n </td>\r\n </tr>\r\n\t\t \r\n\t\t </table>\r\n\t\t  </td>\r\n \t\t \r\n\t\t </tr>\r\n\t\t \r\n\t\t </table>\t\t  \r\n\t\t  \r\n\t\t  </td>\r\n\t\t </tr>\r\n\t\t \r\n\t\t </table>\r\n\t\t <br style='font-size:4pt;'>\r\n\t\t \r\n\t\t ";
        if ( $baris % 5 == 0 )
        {
            echo "  \r\n\t\t  \t\t\t\t<br style='page-break-after:always'>";
        }
    } while ( 1 );
}
?>
