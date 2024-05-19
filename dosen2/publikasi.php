<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$idprodi = getfield( "IDDEPARTEMEN", "dosen", " WHERE ID='{$idupdate}'" );
$namamakul = getfield( "NAMA", "dosen", " WHERE ID='{$idupdate}'" );
#echo "\r\n<br>\r\n  <table class=form>\r\n     <tr class=judulform>\r\n\t\t\t<td width=150>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$idprodi]."\r\n      </td>\r\n\t\t</tr> \r\n    <tr>\r\n      <td>NIDN Dosen</td>\r\n      <td><b>{$idupdate}</td>\r\n    </tr>\r\n    <tr>\r\n      <td>Nama Dosen</td>\r\n      <td><b>".$namamakul."</td>\r\n    </tr>\r\n    </table>\r\n";
echo "		<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=\"index.php\" method=\"post\">
					<div class=\"m-portlet__body\">	";
		echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arrayprodidep[$idprodi]."</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">NIDN Dosen</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$idupdate}</label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Nama Dosen</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$namamakul."</label>
						</div>";
if ( $aksi2 == "" || $aksi2 == "tampilkan" )
{
    $q = "SELECT * FROM trpud WHERE NODOSTRPUD='{$idupdate}' ORDER BY THSMSTRPUD DESC, NORUTTRPUD";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        #echo "\r\n\t\t\t<br>\r\n\t\t\t\t<table {$border} class=data >\r\n \t\t\t\t\r\n\t\t\t\t\t<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Tahun / Semester</td>\r\n\t\t\t\t\t\t<td>Jenis<br>Penelitian</td>\r\n\t\t\t\t\t\t<td>Media<br>Publikasi</td>\r\n\t\t\t\t\t\t<td>Jenis<br>Pengarang</td>\r\n\t\t\t\t\t\t<td>Mandiri/<br>Kelompok</td>\r\n\t\t\t\t\t\t<td>Tahun / Bulan<br>Publikasi</td>\r\n\t\t\t\t\t\t<td>Pembiayaan</td>\r\n\t\t\t\t\t\t<td>Biaya (Rp.)</td>\r\n\t\t\t\t\t\t<td>Judul</td>\r\n \r\n\t\t\t\t\t</tr>";
        echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover\">
							<thead>
								<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Tahun / Semester</td>\r\n\t\t\t\t\t\t<td>Jenis<br>Penelitian</td>\r\n\t\t\t\t\t\t<td>Media<br>Publikasi</td>\r\n\t\t\t\t\t\t<td>Jenis<br>Pengarang</td>\r\n\t\t\t\t\t\t<td>Mandiri/<br>Kelompok</td>\r\n\t\t\t\t\t\t<td>Tahun / Bulan<br>Publikasi</td>\r\n\t\t\t\t\t\t<td>Pembiayaan</td>\r\n\t\t\t\t\t\t<td>Biaya (Rp.)</td>\r\n\t\t\t\t\t\t<td>Judul</td>\r\n \r\n\t\t\t\t\t</tr>";
		echo "				</thead>
							<tbody>";
		$i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $tmp = $d[THSMSTRPUD];
            $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
            $semester = $tmp[4];
            $tmp = $d[THNBLTRPUD];
            $tp[thn] = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
            $tp[bln] = $tmp[4].$tmp[5];
            $judulp = $d[JUDU1TRPUD].$d[JUDU2TRPUD].$d[JUDU3TRPUD].$d[JUDU4TRPUD].$d[JUDU5TRPUD];
            echo "\r\n\t\t\t\t\t<tr {$kelas} valign=top>\r\n\t\t\t\t\t\t<td>{$i} </td>\r\n \t\t\t\t\t\t<td align=center nowrap>".$arraysemester[$semester]."\r\n             {$tahun}\r\n             </td>\r\n\t\t\t\t\t\t<td>".$arrayjenispenelitian[$d[KDLITTRPUD]]."</td>\r\n\t\t\t\t\t\t<td>".$arraymediapublikasi[$d[KDPUBTRPUD]]."</td>\r\n\t\t\t\t\t\t<td>".$arrayperanpenulisan[$d[KDATHTRPUD]]."</td>\r\n\t\t\t\t\t\t<td>".$arraykegiatanmandiri[$d[KDKELTRPUD]]."</td>\r\n\t\t\t\t\t\t<td nowrap align=center>{$tp['bln']}-{$tp['thn']}</td>\r\n\t\t\t\t\t\t<td>".$arraypembiayaan[$d[KDBIYTRPUD]]."</td>\r\n\t\t\t\t\t\t<td align=right>".cetakuang( $d[KDBIYTRPUD] )."</td>\r\n\t\t\t\t\t\t<td>".nl2br( $judulp )."</td>\r\n \r\n\t\t\t\t\t</tr>";
            ++$i;
        }
        #echo "\r\n\t\t\t\t</table>\r\n\t\t\t";
		echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				</div>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->";
    }
    else
    {
        echo "<p>";
        printmesg( "Data Publikasi tidak ada" );
        echo "</p>";
    }
    echo "\r\n\t\t</form>\r\n\t\t\r\n\t\t";
}
?>
