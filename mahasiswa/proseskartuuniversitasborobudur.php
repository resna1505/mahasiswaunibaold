<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\tul {\r\n\t\tmargin-left:17px;\r\n\t\t}\r\n\t\r\n\t.borderline {\r\n\t\tbackground:#ffe304;\r\n\t\t}\t\r\n\t\t\r\n\t.greybackround {\r\n\t\tbackground:#fdfbc8;\r\n\t\t}\r\n\t\t\r\n\ttd {\r\n\t\tborder:none;\r\n\t\t}\t\r\n\t\t\r\n\t.noborder td{\r\n\t\tborder:none;\r\n\t\t}\r\n\t.address {\r\n\t\tfont-size:10px;\r\n\t\tmargin: 6px 0px 0px 15px;\r\n\t\t}\r\n\t\t\r\n</style>\r\n";
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
    else
    {
        $qfield .= " AND mahasiswa.STATUS='{$status}'";
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
$q = "SELECT mahasiswa.NAMA,mahasiswa.ID ,mahasiswa.ALAMAT,DATE_FORMAT(mahasiswa.TANGGALKARTU,'%d-%m-%Y') AS TGLKARTU,\r\n\tprodi.NAMA AS NAMAP,fakultas.NAMA AS NAMAF,\r\n\tCONCAT(mahasiswa.TEMPAT,', ',DATE_FORMAT(mahasiswa.TANGGAL,'%d-%m-%Y')) AS TTL\r\n  FROM {$qtabel2} mahasiswa LEFT JOIN mahasiswa2 ON mahasiswa.ID=mahasiswa2.ID,msmhs,prodi,departemen LEFT JOIN fakultas ON   \r\n  departemen.IDFAKULTAS=fakultas.ID \r\n\r\n\tWHERE 1=1 AND\r\n  mahasiswa.IDPRODI=prodi.ID AND\r\n  prodi.IDDEPARTEMEN=departemen.ID AND\r\n  msmhs.NIMHSMSMHS=mahasiswa.ID\r\n  {$qprodidep2}\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $baris = 0;
    $kolom = 0;
    echo "\r\n  <table style='border:none;' >\r\n   ";
    do
    {
        if ( !( $d = sqlfetcharray( $h ) ) )
        {
            break;
        }
        else
        {
            ++$baris;
            echo "\r\n      <tr>\r\n        <td style='border:none;'>\r\n          <!-- DEPAN -->\r\n          <table  width=400 class=borderline height=260 cellpadding=0 cellspacing=0>\r\n            <tr valign=top>\r\n              <td style='background:#1601a4; border-bottom:2px solid red;'>\r\n                  <!--HEADER-->\r\n                    <table width=100%>\r\n                      <td class=loseborder><!--LOGO DI SINI--></td>\r\n                      <td align=center style='border:none;'>\r\n                        <font style='font-size:17pt; font-weight:bold;color:#fff;'>KARTU MAHASISWA </font><br>\r\n                        <font  style='font-size:12pt;font-weight:bold;color:#fff;'>UNIVERSITAS BOROBUDUR</font><br>\r\n                        <font  style='font-size:8pt;color:#fff;'>Jl Raya Kalimalang No.1 Jakarta Timur Telp. 021-8613868, 8613869</font>\r\n                      </td>\r\n                    </table> \r\n              </td>\r\n            </tr>\r\n            <tr valign=top>\r\n              <td style='border:none;'>\r\n                  <!--TENGAH-->\r\n                    <table width=100% >\r\n                      <tr>\r\n                      <td class=loseborder><!--FOTO DI SINI--></td>\r\n                      <td style='border:none;' align=center>\r\n                        <!-- BIODATA-->\r\n                        <table class=noborder style=position:relative;left:40px;>\r\n                          <tr >\r\n                            <td  class=loseborder  ><font  style='font-size:8pt;'>NIM</td>\r\n                            <td  class=loseborder  ><font  style='font-size:8pt;'>:</td>\r\n                            <td  class=loseborder  ><font  style='font-size:8pt;'>{$d['ID']}</td>\r\n                          </tr>\r\n                          <tr>\r\n                            <td  class=loseborder><font  style='font-size:8pt;'>Nama</td>\r\n                            <td  class=loseborder  ><font  style='font-size:8pt;'>:</td>\r\n                            <td  class=loseborder  ><font  style='font-size:8pt;'>{$d['NAMA']}</td>\r\n                          </tr>\r\n                          <tr>\r\n                            <td  class=loseborder><font  style='font-size:8pt;'>Fakultas</td>\r\n                            <td  class=loseborder  ><font  style='font-size:8pt;'>:</td>\r\n                            <td  class=loseborder  ><font  style='font-size:8pt;'>{$d['NAMAF']}</td>\r\n                          </tr>\r\n                          <tr>\r\n                             <td  class=loseborder><font  style='font-size:8pt;'>Program Studi</td>\r\n                              <td  class=loseborder  ><font  style='font-size:8pt;'>:</td>\r\n                            <td  class=loseborder  ><font  style='font-size:8pt;'>{$d['NAMAP']}</td>\r\n                        </tr>\r\n                           <tr>\r\n                            <td  class=loseborder><font  style='font-size:8pt;'>Tempat/Tanggal Lahir</td>\r\n                            <td  class=loseborder  ><font  style='font-size:8pt;'>:</td>\r\n                            <td  class=loseborder  ><font  style='font-size:8pt;'> {$d['TTL']}</td>\r\n                          </tr>\r\n                          <tr>\r\n                            <td  class=loseborder><font  style='font-size:8pt;'>Alamat</td>\r\n                            <td  class=loseborder  ><font  style='font-size:8pt;'>:</td>\r\n                            <td  class=loseborder  ><font  style='font-size:8pt;'>".nl2br( $d[ALAMAT] )."</td>\r\n                          </tr>\r\n                         </table>\r\n                       </td>\r\n                       </tr>\r\n                    </table>\r\n                  \r\n              </td>\r\n            </tr>\r\n\r\n            <tr valign=top>\r\n              <td >\r\n                  <!--FOOTER-->\r\n                    <font  style='font-size:8pt;margin-left:7px;'>Masa Berlaku s.d. {$d['TGLKARTU']}</font>\r\n               </td>\r\n            </tr>\r\n\r\n          </table>\r\n          \r\n        </td>\r\n        <td style='border:none;' valign=top>\r\n          <!-- BELAKANG -->\r\n\r\n\r\n         <table class=greybackround width=400 height=260 border=0 cellpadding=0 cellspacing=0>\r\n            <tr valign=top>\r\n              <td colspan=2>\r\n                  <ul>\r\n                    <li style='font-size:8pt;'>Kartu ini adalah kartu identitas mahasiswa Universitas Borobudur dan hanya berlaku pada tahun akademik yang tercantum pada kartu tersebut\r\n                    <li style='font-size:8pt;'>Pemegang kartu ini dengan nama dan nomor pokok yang tercantum pada kartu tersebut berhak menggunakan fasilitas pembelajaran sesuai dengan program studi yang dipelajarinya\r\n                    <li style='font-size:8pt;'>Kartu ini harus dibawa oleh mahasiswa untuk menunjukan bahwa yang bersangkutan adalah anggota civitas akademik Universitas Borobudur\r\n                    <li style='font-size:8pt;'>Apabila menemukan kartu ini harap dikembalikan ke :\r\n                  </ul>\r\n\t\t\t\t  <div class=address>\r\n\t\t\t\t  \t<strong>Universitas Borobodur</strong><br/>\r\n\t\t\t\t\tJl Raya Kalimalang No.1 Jakarta Timur<br/>\r\n\t\t\t\t\tTelp. 021-8613868, 8613869, 8613877\r\n\t\t\t\t  </div>\r\n              </td>\r\n            </tr>\r\n                   \r\n      \r\n\r\n            <tr valign=top>\r\n\t\t\t  <td>\r\n\t\t\t  </td>\r\n              <td width=200 style='font-size:8pt;' style='position:relative;left:10px;' align=center>\r\n                  <!--FOOTER-->\r\n                    Rektor<br><br><br>\r\n                    Prof. Dr.H. Basir Bartos\r\n               </td>\r\n            </tr>\r\n\r\n          </table>\r\n\r\n\r\n        </td>\r\n      </tr>\r\n    ";
        }
        if ( $baris % 5 == 0 )
        {
            echo "  \r\n  \t\t  \t\t\t\t</table>\r\n  \t\t  \t\t\t\t<br style='page-break-after:always'>\r\n  \t\t  \t\t\t\t<table>\r\n                ";
        }
    } while ( 1 );
}
?>
