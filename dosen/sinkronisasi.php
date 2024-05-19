<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

exit( );
periksaroot( );
$arraystatuskoreksi[0] = "NIDN Dosen tidak ada di MSDOS";
$arraystatuskoreksi[1] = "NIDN Dosen tidak ada di TBDOS";
$arraystatuskoreksi[2] = "Program Studi Dosen tidak ada di TBPST";
printjudulmenu( "SINKRONISASI DATA DOSEN dengan TBDOS DIKTI", "bantuan" );
printhelp( "{$help_sinkronisasi}", "bantuan", 1 );
if ( $aksi == "Proses" )
{
    $q = "\r\n  SELECT dosen.ID,dosen.NAMA AS NAMA,msdos.KDPSTMSDOS,msdos.KDJENMSDOS \r\n  FROM dosen \r\n  LEFT JOIN msdos\r\n  ON msdos.NODOSMSDOS=dosen.ID\r\n  ORDER BY ID\r\n  ";
    $h = doquery($koneksi,$q);
    echo mysqli_error($koneksi);
    if ( 0 < sqlnumrows( $h ) )
    {
        echo "\r\n    <table class=form>\r\n      <tr class=juduldata valign=top align=center>\r\n        <td>No</td>\r\n        <td>ID</td>\r\n        <td>Kode PST</td>\r\n        <td>Kode Jenjang</td>\r\n        <td>Nama Dosen</td>\r\n        <td>Keterangan</td>\r\n      </tr>\r\n    ";
        $i = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            ++$i;
            $kelas = kelas( $i );
            $q = "SELECT * FROM tbdos WHERE NIDNNTBDOS = '{$d['ID']}'";
            $htbdos = doquery($koneksi,$q);
            $status = "";
            if ( 0 < sqlnumrows( $htbdos ) )
            {
                $dtbdos = sqlfetcharray( $htbdos );
                $q = "SELECT IDX FROM mspst \r\n          WHERE KDPSTMSPST='{$dtbdos['KDPSTTBDOS']}' AND \r\n          KDJENMSPST='{$dtbdos['KDJENTBDOS']}'\r\n          ";
                $hprodi = doquery($koneksi,$q);
                $qprodi = "";
                if ( 0 < sqlnumrows( $hprodi ) )
                {
                    $dprodi = sqlfetcharray( $hprodi );
                    $qprodi = ",IDDEPARTEMEN ='{$dprodi['IDX']}'";
                }
                $q = "UPDATE dosen SET\r\n          NAMA ='{$dtbdos['NMDOSTBDOS']}',\r\n           STATUS ='{$dtbdos['KDSTATBDOS']}',\r\n          STATUSKERJA ='{$dtbdos['STDOSTBDOS']}',\r\n          INSTANSI ='{$dtbdos['PTINDTBDOS']}'\r\n          {$qprodi}\r\n           WHERE ID = '{$d['ID']}'";
                doquery($koneksi,$q);
                $q = "UPDATE msdos SET\r\n          NMDOSMSDOS ='{$dtbdos['NMDOSTBDOS']}',\r\n          NOKTPMSDOS = '{$dtbdos['NOKTPTBDOS']}',\r\n          TPLHRMSDOS ='{$dtbdos['TPLHRTBDOS']}',\r\n          TGLHRMSDOS ='{$dtbdos['TGLHRTBDOS']}',\r\n          KDJEKMSDOS ='{$dtbdos['KDJEKTBDOS']}',\r\n          KDJANMSDOS ='{$dtbdos['KDJANTBDOS']}',\r\n          KDPDAMSDOS ='{$dtbdos['KDPDATBDOS']}',\r\n          KDSTAMSDOS ='{$dtbdos['KDSTATBDOS']}',\r\n          PTINDMSDOS ='{$dtbdos['PTINDTBDOS']}',\r\n          KDJENMSDOS ='{$dtbdos['KDJENTBDOS']}',\r\n          KDPSTMSDOS ='{$dtbdos['KDPSTTBDOS']}',\r\n          NIPNSMSDOS ='{$dtbdos['NIPPPTBDOS']}'\r\n          WHERE NODOSMSDOS = '{$d['ID']}'";
                doquery($koneksi,$q);
                $status .= "".IKONOK." Sudah sinkron dengan TBDOS<br>";
            }
            else
            {
                $status .= "".IKONWARNING." Data tidak ditemukan di TBDOS";
                $kelas = "style='background-color:#FFFF00;'";
            }
            echo "\r\n       <tr {$kelas} valign=top align=center>\r\n        <td>{$i}</td>\r\n        <td>{$d['ID']}</td>\r\n        <td>{$d['KDPSTMSDOS']}</td>\r\n        <td>{$d['KDJENMSDOS']}-".$arrayjenjang[$d[KDJENMSDOS]]."</td>\r\n        <td align=left>{$d['NAMA']}</td>\r\n        <td nowrap> {$status} </td>\r\n      </tr>\r\n    ";
        }
        echo "\r\n    </table>\r\n    ";
    }
    else
    {
        printmesg( "Tidak ada data Dosen yang berpotensi tidak valid berdasarkan tabel referensi." );
    }
}
if ( $aksi == "" )
{
    echo "\r\n  ".IKONTOOLS48."\r\n  <form action=index.php method=post>\r\n    <input type=hidden name=pilihan value='{$pilihan}'>\r\n    Klik tombol di bawah ini untuk melakukan sinkronisasi data dosen dengan TBDOS. <br><br>\r\n    <input type=submit name=aksi value='Proses'>\r\n    \r\n  </form>\r\n  ";
}
?>
