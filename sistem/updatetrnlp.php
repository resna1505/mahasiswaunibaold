<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$root = "../";
include( $root."header.php" );
$q = "SELECT * FROM nilaikonversi  ORDER BY IDMAHASISWA,IDMAKUL  ";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $jmldata = 0;
    do
    {
        if ( !( $d = sqlfetcharray( $h ) ) )
        {
            break;
        }
        else
        {
            $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST,SMAWLMSMHS FROM mspst,mahasiswa,msmhs \r\n          WHERE mahasiswa.IDPRODI=IDX AND \r\n          mahasiswa.ID=msmhs.NIMHSMSMHS AND\r\n          mahasiswa.ID='{$d['IDMAHASISWA']}'";
            $h2 = mysqli_query($koneksi,$q);
        }
        if ( 0 < sqlnumrows( $h2 ) )
        {
            $d2 = sqlfetcharray( $h2 );
            $kodept = $d2[KDPTIMSPST];
            $kodejenjang = $d2[KDJENMSPST];
            $kodeps = $d2[KDPSTMSPST];
            $tahunsemester = $d2[SMAWLMSMHS];
            echo $q = "INSERT INTO trnlp  (THSMSTRNLP,KDPTITRNLP,KDJENTRNLP,KDPSTTRNLP,NIMHSTRNLP,KDKMKTRNLP,NLAKHTRNLP,BOBOTTRNLP,KELASTRNLP) VALUES ('{$tahunsemester}','{$kodept}','{$kodejenjang}','{$kodeps}','{$d['IDMAHASISWA']}','{$d['IDMAKUL']}','{$d['NILAI']}','{$d['BOBOT']}','01')";
            mysqli_query($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                echo "<br><b>Query OK</b><br><br>";
            }
            else
            {
                echo "<br><b>Query Gagal. Data sudah ada.</b><br><br>";
            }
        }
    } while ( 1 );
}
echo $str;
?>
