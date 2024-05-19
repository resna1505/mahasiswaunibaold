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
            $qfield .= " AND tbkmksp.THSMSTBKMK='".( $tahun - 1 )."{$semester}'  ";
        }
        if ( $prodi != "" )
        {
            $q = "SELECT KDPSTMSPST, KDJENMSPST FROM mspst WHERE IDX='{$prodi}'";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $d = sqlfetcharray( $h );
                $qfield .= " AND tbkmksp.KDPSTTBKMK='{$d['KDPSTMSPST']}' AND tbkmksp.KDJENTBKMK='{$d['KDJENMSPST']}' ";
            }
        }
        if ( $_SESSION['prodis'] != "" )
        {
            $q = "SELECT KDPSTMSPST, KDJENMSPST FROM mspst WHERE IDX='".$_SESSION['prodis']."'";
            $h = mysqli_query($koneksi,$q );
            if ( 0 < mysqli_num_rows( $h ) )
            {
                $d = sqlfetcharray( $h );
                $qfield .= " AND tbkmksp.KDPSTTBKMK='{$d['KDPSTMSPST']}' AND tbkmksp.KDJENTBKMK='{$d['KDJENMSPST']}' ";
            }
        }
        $q = "SELECT tbkmksp.KDKMKTBKMK\t AS ID,tbkmksp.NAKMKTBKMK\t AS NAMA, tbkmksp.KDPSTTBKMK,    tbkmksp.KDJENTBKMK\t,tbkmksp.THSMSTBKMK,IDX\r\n     FROM tbkmksp,mspst\r\n     WHERE \r\n     tbkmksp.KDPTITBKMK = mspst.KDPTIMSPST AND\r\n     tbkmksp.KDJENTBKMK\t= mspst.KDJENMSPST AND\r\n     tbkmksp.KDPSTTBKMK= mspst.KDPSTMSPST\t  AND\r\n     \r\n     (tbkmksp.NAKMKTBKMK LIKE '%{$queryString}%' OR tbkmksp.KDKMKTBKMK LIKE '{$queryString}%')\r\n     {$qfield}\r\n     ORDER BY tbkmksp.KDKMKTBKMK ,tbkmksp.KDPSTTBKMK,tbkmksp.KDJENTBKMK\t,tbkmksp.NAKMKTBKMK LIMIT 0,20";
        #echo $q;
	$h = mysqli_query($koneksi,$q);
        if (sqlnumrows($h)>0)
		{
            #if ( !( 0 < mysqli_num_rows( $h ) ) || !( $d = mysqli_fetch_array( $h ) ) )
			while ($d=sqlfetcharray($h))        
            {
				echo "<li onClick=\"fillKurikulumSP('".$d[ID]."');\">{$d['THSMSTBKMK']}, <b>{$d['ID']}</b> - ".$d[NAMA].",  ".$arrayprodidep[$d[IDX]]."</li>";
				
			}
        }
    }
}
?>
