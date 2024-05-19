<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
include( "../libchart/libchart.php" );
if ( $idprodi != "" )
{
    $qfield .= " AND IDDEPARTEMEN='{$idprodi}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $status != "" )
{
    $qfield .= " AND STATUSKERJA='{$status}'";
    $qjudul .= " Status Aktifitas Dosen : '".$arraystatuskerjadosen["{$status}"]."' <br>";
    $qinput .= " <input type=hidden name=status value='{$status}'>";
    $href .= "status={$status}&";
}
if ( $statuskerja != "" )
{
    $qfield .= " AND STATUS='{$statuskerja}'";
    $qjudul .= " Status Ikatan Kerja : '".$arraystatusdosen["{$statuskerja}"]."' <br>";
    $qinput .= " <input type=hidden name=statuskerja value='{$statuskerja}'>";
    $href .= "statuskerja={$statuskerja}&";
}
if ( $sort == "" )
{
    $sort = "NAMA";
    $qsort = "ORDER BY {$sort}";
}
else if ( $sort == "usia" )
{
    $qsort = "ORDER BY TO_DAYS(NOW())-TO_DAYS(TGLHRMSDOS)";
}
else
{
    $qsort = "ORDER BY {$sort},NAMA";
}
if ( $klpb == 0 )
{
    $arraygrupbaris = $arrayprodidep;
}
else if ( $klpb == 2 )
{
    $arraygrupbaris = $arraykelamin;
}
else if ( $klpb == 3 )
{
    $arraygrupbaris = $arraystatusdosen;
}
else if ( $klpb == 4 )
{
    $arraygrupbaris = $arraystatuskerjadosen;
}
else if ( $klpb == 5 )
{
    foreach ( $arraykelompokusia as $k => $v )
    {
        $arraygrupbaris[$k] = "{$v['a']} s.d {$v['b']}";
    }
}
if ( $klpk == 0 )
{
    $arraygrupkolom = $arrayprodidep;
}
else if ( $klpk == 2 )
{
    $arraygrupkolom = $arraykelamin;
}
else if ( $klpk == 3 )
{
    $arraygrupkolom = $arraystatusdosen;
}
else if ( $klpk == 4 )
{
    $arraygrupkolom = $arraystatuskerjadosen;
}
else if ( $klpk == 5 )
{
    foreach ( $arraykelompokusia as $k => $v )
    {
        $arraygrupkolom[$k] = "{$v['a']} s.d {$v['b']}";
    }
}
if ( is_array( $arraygrupbaris ) && is_array( $arraygrupkolom ) )
{
	echo "\r\n\t\t\t<div class=\"page-content\">
        <div class=\"container-fluid\">
            <div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
						<div class='tab-pane' id='tab_1'>
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
    if ( $aksi != "cetak" )
    {
  
        #printmesg( $qjudul );
		echo "						<div class=\"tools\">
										<form target=_blank action='cetakrekap.php' method=post>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi value=Cetak class=\"btn btn-success\"></input>
														<input type=hidden name=sort value='{$sort}'>\r\n \t\t\t\t\t\t
														<input type=hidden name=klpb value='{$klpb}'>\r\n \t\t\t\t\t\t
														<input type=hidden name=klpk value='{$klpk}'>\r\n \t\t\t\t\t\t
														<input type=hidden name=grafik value='{$grafik}'>\r\n\t\t\t\t\t\t{$inputfilteruser}\r\n\t\t\t\t\t\t{$qinput}
													</td>
												</tr>
											</table>
										</form>
									</div>";
    }
    #else
    #{
    #    printjudulmenucetak( "Rekap Data Dosen" );
    #    printmesgcetak( $qjudul );
    #}
    /*if ( $aksi != "cetak" )
    {
        
									<div class=\"caption\">";
										printmesg("Rekap Data Dosen");
		echo "						</div>
								</div>
								<div class=\"portlet-body form\">
									<form action=cetakrekap.php target=_blank method=post>
										<div class=\"portlet-body\">
											<div class=\"table-scrollable\">
												<table class=\"table table-striped table-bordered table-hover\">\n\t\t\t\t<tr>\r\n\t\t\t\t<td ><input class=\"btn btn-brand\" tombol  name=aksi type=submit value='Cetak'>\r\n \t\t\t\t\t\t<input type=hidden name=sort value='{$sort}'>\r\n \t\t\t\t\t\t<input type=hidden name=klpb value='{$klpb}'>\r\n \t\t\t\t\t\t<input type=hidden name=klpk value='{$klpk}'>\r\n \t\t\t\t\t\t<input type=hidden name=grafik value='{$grafik}'>\r\n\t\t\t\t\t\t{$inputfilteruser}\r\n\t\t\t\t\t\t{$qinput}\r\n\t\t\t\t</td>\r\n\t\t\t\t</tr>";
		echo "									</table>
											</div>
										</div>";
    }*/
	echo "						<div class=\"caption\">";
										printmesg("Rekap Data Dosen");
		echo "						</div>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr>
															<th rowspan=2>No</th>
															<th rowspan=2> ".$arraynamagrup[$klpb]."&nbsp;</th>
															<th align=\"center\" colspan=".count( $arraygrupkolom )."> ".$arraynamagrup[$klpk]."&nbsp;</th>
															<th rowspan=2>Total&nbsp;</th>
														</tr>
														<tr align=center class=juduldata{$cetak}>";
															
    
    /*echo "									 <div class=\"portlet-body\">
												<div class=\"table-scrollable\">
													<table class=\"table table-striped table-bordered table-hover\"{$border} class=form{$cetak}>
														<tr align=center class=juduldata{$cetak}>
															<td rowspan=2>No</td>
															<td rowspan=2> ".$arraynamagrup[$klpb]."&nbsp;</td>
															<td colspan=".count( $arraygrupkolom )."> ".$arraynamagrup[$klpk]."&nbsp;</td>
															<td rowspan=2>Total&nbsp;</td>
														</tr>
														<tr align=center class=juduldata{$cetak}>";*/
/*echo "		<div class=\"m-portlet m-portlet--mobile\">
				";
echo "			<div class=\"m-portlet__body\">
					<!--begin: Datatable -->
					<table class=\"table table-striped- table-bordered table-hover table-checkable\" id=\"m_table_3\">
						<thead>
							<tr>
								<th>No</th>
								<th>".$arraynamagrup[$klpb]."&nbsp;</th>
								<!--<th colspan=".count( $arraygrupkolom )."> ".$arraynamagrup[$klpk]."&nbsp;</th>-->";
								foreach ( $arraygrupkolom as $kx => $vx )
								{
	echo "							<th>".$arraynamagrup[$klpk]."</th>";
								}
	echo "							<th>Total</th>
						</tr> 
						</thead>
						<tbody>
							<tr align=center>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							";*/
								
    foreach ( $arraygrupkolom as $kx => $vx )
    {
        echo "<td>{$vx}</td>";
    }
    #echo "<td>&nbsp;</td></tr>";
	echo "\r\n\t\t </tr>\r\n\t\t";
    $ii = 0;
    foreach ( $arraygrupbaris as $kk => $vv )
    {
        $kelas = kelas( $ii );
        ++$ii;
        if ( $klpb != 5 && $klpk != 5 )
        {
            $q = "\r\n\t\t\t\t\t\tSELECT COUNT(ID) AS JML,".$arraygrup[$klpk]." AS XX \r\n            FROM dosen,msdos \r\n            WHERE  dosen.ID=msdos.NODOSMSDOS  \r\n            AND ".$arraygrup[$klpb]."='{$kk}'\r\n\t\t\t\t\t\t{$qfield}\r\n\t\t\t\t\t\tGROUP BY ".$arraygrup[$klpk]."\r\n\t\t\t\t\t";
            $h = doquery($koneksi,$q);
            unset( $data );
            while ( $d = sqlfetcharray( $h ) )
            {
                $data[$d[XX]] = $d[JML];
            }
        }
        echo "\r\n\t\t\t \t<tr valign=top {$kelas}{$cetak}>\r\n\t\t\t \t\t<td align=center >{$ii}&nbsp;</td>\r\n\t\t\t \t\t<td  nowrap>".$arraygrupbaris[$kk]."&nbsp;</td>";
        $totalkolom = 0;
        foreach ( $arraygrupkolom as $kx => $vx )
        {
            if ( $klpb == 5 && $klpk == 5 )
            {
                $q = "SELECT COUNT(ID) AS XX \r\n                  FROM dosen,msdos \r\n                  WHERE  dosen.ID=msdos.NODOSMSDOS  AND\r\n\t\t\t\t\t\t\t\t( $  >= ".$arraykelompokusia[$kk][a]." \r\n\t\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\t\t {$USIA} <= ".$arraykelompokusia[$kk][b]."\r\n\t\t\t\t\t\t\t\t) \r\n\t\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\t\t(\r\n\t\t\t\t\t\t\t\t {$USIA} >= ".$arraykelompokusia[$kx][a]." \r\n\t\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\t\t {$USIA} <= ".$arraykelompokusia[$kx][b]." \r\n\t\t\t\t\t\t\t\t)\r\n\t\t\t\t\t\t\t\t{$qfield}\r\n\t\t\t\t\t\t\t\t";
                $hx = doquery($koneksi,$q);
                unset( $data );
                $d = sqlfetcharray( $hx );
                $data[$kx] = $d[XX];
            }
            else if ( $klpb == 5 )
            {
                $q = "SELECT COUNT(ID) AS XX \r\n                  FROM dosen,msdos \r\n                  WHERE  dosen.ID=msdos.NODOSMSDOS  AND\r\n                ".$arraygrup[$klpk]."='{$kx}' AND \r\n\t\t\t\t\t\t\t\t {$USIA} >= ".$arraykelompokusia[$kk][a]." \r\n\t\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\t\t {$USIA} <= ".$arraykelompokusia[$kk][b]." \r\n\t\t\t\t\t\t\t\t {$qfield}\r\n\t\t\t\t\t\t\t\t";
                $hx = doquery($koneksi,$q);
                unset( $data );
                $d = sqlfetcharray( $hx );
                $data[$kx] = $d[XX];
            }
            else if ( $klpk == 5 )
            {
                $q = "SELECT COUNT(ID) AS XX \r\n                   \r\n                  FROM dosen,msdos \r\n                  WHERE  dosen.ID=msdos.NODOSMSDOS  AND\r\n                \r\n                ".$arraygrup[$klpb]."='{$kk}' AND \r\n\t\t\t\t\t\t\t\t {$USIA} >= ".$arraykelompokusia[$kx][a]." \r\n\t\t\t\t\t\t\t\tAND\r\n\t\t\t\t\t\t\t\t {$USIA} <= ".$arraykelompokusia[$kx][b]." \r\n\t\t\t\t\t\t\t\t {$qfield}\r\n\t\t\t\t\t\t\t\t";
                $hx = doquery($koneksi,$q);
                unset( $data );
                $d = sqlfetcharray( $hx );
                $data[$kx] = $d[XX];
            }
            $data[$kx]." {$kx}<br>";
            $totalpegawai += $kx;
            $totalsemua += $data[$kx];
            $totalkolom += $data[$kx];
            echo "<td align=center>".$data[$kx]."&nbsp;</td>";
        }
        $arraytotalbaris[$kk] = $totalkolom;
        if ( $totalkolom == 0 )
        {
            $totalkolom = "";
        }
        echo "\r\n\t\t \t\t\t\t<td  align=center>{$totalkolom}&nbsp;</td>\r\n\t\t \t\t</tr>";
    }
    echo "\r\n\t\t <tr align=center class=juduldata{$cetak}>\r\n\t\t \t<td>&nbsp;</td>\r\n\t\t \t<td align=right> Total </td>";
    foreach ( $arraygrupkolom as $kx => $vx )
    {
        if ( $totalpegawai[$kx] == 0 )
       
        echo "<td>{$totalpegawai[$kx]}&nbsp;</td>";
    }
    echo "\r\n\t\t \t<td>{$totalsemua}&nbsp;</td>\r\n\t\t\r\n\t\t</tr>";
	echo "			</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</form>";
	#echo "</table></div></div></div></div></div>\t</form> </br>";
    if ( $grafik == 1 )
    {
        delgambartemp( );
        $seed = mt_srand( make_seed( ) );
        $xx1 = mt_rand( );
        $xx2 = mt_rand( );
        $q = "INSERT INTO gambartemp VALUES('grafik/"."{$xx1}.png',NOW())";
        doquery($koneksi,$q);
        $q = "INSERT INTO gambartemp VALUES('grafik/"."{$xx2}.png',NOW())";
        doquery($koneksi,$q);
        $chart = new VerticalChart( );
        foreach ( $arraygrupbaris as $k => $v )
        {
            $chart->addPoint( new Point( "{$v}", $arraytotalbaris[$k] ) );
        }
        $chart->setTitle( "Grafik Rekap Dosen per ".$arraynamagrup[$klpb]."" );
        $chart->render( "grafik/{$xx1}.png" );
        echo "<img  src='grafik/{$xx1}.png' style='border: 1px solid gray;'/>";
        $chart2 = new VerticalChart( );
        foreach ( $arraygrupkolom as $k => $v )
        {
            $chart2->addPoint( new Point( "{$v}", $totalpegawai[$k] ) );
        }
        $chart2->setTitle( "Grafik  Rekap Dosen per ".$arraynamagrup[$klpk]."" );
        $chart2->render( "grafik/{$xx2}.png" );
        echo "<img  src='grafik/{$xx2}.png' style='border: 1px solid gray;'/>";
    }
}
else
{
    $errmesg = "Data Pengelompokan Baris / Kolom Tidak Ada ".$judulfilteruser;
    $aksi = "";
}
?>
