<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$root = "../";
include( $root."sesiuser.php" );
include( $root."header.php" );
if ( isset( $_POST['queryString'] ) )
{
    $queryString = $_POST['queryString'];
    if ( 2 < strlen( $queryString ) )
    {
        $qfield = "";
        if ( $tahun != "" && $semester != "" )
        {
            $qfield .= " AND tbkmk.THSMSTBKMK='".( $tahun - 1 )."{$semester}'  ";
        }
        if ( $prodi != "" )
        {
            $q = "SELECT KDPSTMSPST, KDJENMSPST FROM mspst WHERE IDX='{$prodi}'";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $d = sqlfetcharray( $h );
                $qfield .= " AND tbkmk.KDPSTTBKMK='{$d['KDPSTMSPST']}' AND tbkmk.KDJENTBKMK='{$d['KDJENMSPST']}' ";
            }
        }
        if ( $_SESSION['prodis'] != "" )
        {
            $q = "SELECT KDPSTMSPST, KDJENMSPST FROM mspst WHERE IDX='".$_SESSION['prodis']."'";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $d = sqlfetcharray( $h );
                $qfield .= " AND tbkmk.KDPSTTBKMK='{$d['KDPSTMSPST']}' AND tbkmk.KDJENTBKMK='{$d['KDJENMSPST']}' ";
            }
        }
        $q = "SELECT tbkmk.KDKMKTBKMK\t AS ID,tbkmk.NAKMKTBKMK\t AS NAMA, tbkmk.KDPSTTBKMK,    tbkmk.KDJENTBKMK\t,tbkmk.THSMSTBKMK,IDX\r\n     FROM tbkmk  ,mspst\r\n     WHERE \r\n     tbkmk.KDPTITBKMK = mspst.KDPTIMSPST AND\r\n     tbkmk.KDJENTBKMK\t= mspst.KDJENMSPST AND\r\n     tbkmk.KDPSTTBKMK= mspst.KDPSTMSPST\t  AND\r\n     \r\n     (tbkmk.NAKMKTBKMK LIKE '%{$queryString}%' OR tbkmk.KDKMKTBKMK LIKE '{$queryString}%')\r\n     {$qfield}\r\n     ORDER BY tbkmk.KDKMKTBKMK ,tbkmk.KDPSTTBKMK,tbkmk.KDJENTBKMK\t,tbkmk.NAKMKTBKMK LIMIT 0,20";
        $h = mysqli_query($koneksi,$q);
        if (sqlnumrows($h)>0)
		{
            #if ( !( 0 < sqlnumrows( $h ) ) || !( $d = sqlfetcharray( $h ) ) )
			while ($d=sqlfetcharray($h))        
            {
				echo "<li onClick=\"fillKurikulum('".$d[ID]."');\">{$d['THSMSTBKMK']}, <b>{$d['ID']}</b> - ".$d[NAMA].",  ".$arrayprodidep[$d[IDX]]."</li>";
				
			}
        }
    }
}
?>
