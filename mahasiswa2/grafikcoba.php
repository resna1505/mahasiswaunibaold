<?
$q = "SELECT NLIPSTRAKM,THSMSTRAKM FROM trakm WHERE NIMHSTRAKM='{$idmahasiswa}' ORDER BY THSMSTRAKM  ";
        $hg = doquery( $q, $koneksi );
        if ( 0 < sqlnumrows( $h ) )
        {
            delgambartemp();
            $xx1 = mt_rand();
            $q = "INSERT INTO gambartemp VALUES('gambardiagram/"."{$xx1}.png',NOW())";
            doquery( $q, $koneksi );
            $chart = new VerticalChart( );
            while ( $dg = sqlfetcharray( $hg ) )
            {
                $thnd = substr( $dg[THSMSTRAKM], 0, 4 );
                $semd = substr( $dg[THSMSTRAKM], 4, 1 );
                $semd = $arraysemester[$semd];
                $chart->addPoint( new Point( "{$semd} {$thnd}/".( $thnd + 1 )."", $dg[NLIPSTRAKM] ) );
            }
            $chart->setTitle( "Grafik IP Mahasiswa ({$idmahasiswa}) per Semester" );
            $chart->render( "gambardiagram/{$xx1}.png" );
            $bodykhs .= "<img  src='gambardiagram/{$xx1}.png' style='border: 1px solid gray;'/>";
        }
?>