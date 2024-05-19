<style type="text/css">

* {
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
	}

.bordertop {
	border-right:1px solid black;
	border-top:1px solid black;
	width:600px;
	}

.bordertop td {
	border-left:1px solid black;
	border-bottom:1px solid black;
	font-size:12px;
	padding:5px;
	}
	
.makeborder td {
	border:none;
	}
	
</style>


<? 

periksaroot();
if (!file_exists("../nilai/ttd.cfg")) {
	@touch("../nilai/ttd.cfg");
}
$arrayttd=file("../nilai/ttd.cfg");
$nipdirektur=trim($arrayttd[0]);
$namadirektur=trim($arrayttd[1]);
$nipkabag=trim($arrayttd[2]);
$namakabag=trim($arrayttd[3]);
$jabatandirektur=trim($arrayttd[4]);
$jabatankabag=trim($arrayttd[5]);

$namabaak=trim($arrayttd[6]);
$jabatanbaak=trim($arrayttd[7]);
$nipbaak=trim($arrayttd[8]);

   $q="SELECT penandatanganumum.FILE4 from penandatanganumum 
   WHERE ID=0";
  $httd=mysqli_query($koneksi,$q);
   if (sqlnumrows($httd)>0) {
      $dttd=sqlfetcharray($httd);
      $gambarttd=$dttd[FILE4];
      $field="FILE4";
      $idprodix="";

    }
    unset($dttd);




 $q="SELECT mahasiswa.*,
 prodi.NAMA as NAMAP ,prodi.TINGKAT,
 mspst.NOMBAMSPST ,
 fakultas.NAMA as NAMAF, 
 fakultas.NAMAPIMPINAN as DEKAN 
 FROM mahasiswa,prodi,mspst,departemen LEFT JOIN fakultas ON
 departemen.IDFAKULTAS=fakultas.ID
 
 
WHERE 1=1 
AND
mahasiswa.IDPRODI=prodi.ID
AND
departemen.ID=prodi.IDDEPARTEMEN
AND
mspst.IDX=prodi.ID
AND mahasiswa.ID='$idmahasiswaupdate'
 ";

$h=mysqli_query($koneksi,$q);
if (sqlnumrows($h)>0) {
  $d=sqlfetcharray($h);
  $dosenwali=$d[IDDOSEN]; 
}
 
echo "
<table width=100% style='page-break-after:always;'>
 <!-- <tr>
    <td align=center colspan=2 style= border:none;><b>$namakantor</td>
  </tr>
 -->
  <tr>
    <td align=center colspan=2 style= border:none;><br><b>KARTU RENCANA STUDI <br><br></td>
  </tr>
  <tr valign=top>
    <td align=center style= border:none;>
    
    <table width=100% class= makeborder>
 
      <tr>
        <td>JURUSAN</td>
        <td>:</td>
        <td>$d[NAMAP]</td>
      </tr>
      <tr>
        <td>JENJANG</td>
        <td>:</td>
        <td>".$arrayjenjang[$d[TINGKAT]]."</td>
      </tr>
      <tr>
        <td>TA</td>
        <td>:</td>
        <td>".$arraysemester[$semesterupdate]." ".($tahunupdate-1)."/$tahunupdate</td>
      </tr>
    </table>
    
    </td>
    <td align=center style= border:none;>
    <table  width=100% class= makeborder>
      <tr>
        <td width=20%>NPM</td>
        <td>:</td>
        <td>$idmahasiswaupdate</td>
      </tr>
      <tr>
        <td>NAMA</td>
        <td>:</td>
        <td>$d[NAMA]</td>
      </tr>
 
					<tr>
						<td >IP ";
               $q="SELECT sksmaksimum.* 
            FROM sksmaksimum ,mahasiswa
            WHERE 
            mahasiswa.IDPRODI=sksmaksimum.IDPRODI
              AND mahasiswa.ID='$idmahasiswaupdate'
            ";
            $hs=mysqli_query($koneksi,$q);
            //echo mysqli_error($koneksi);
            if (sqlnumrows($hs)>0) {
              $ds=sqlfetcharray($hs);
              $sksmaksimum=$ds[SKS];
              $semesteracuan=$ds[SEMESTER];
            }

        $thnlalu=$tahunupdate-1;
        $semlalu=$semesterupdate;
        
        if ($semesteracuan > 0) {
          if ($semlalu % 2 ==0 ) { // Genap       
            $thnlalu=$thnlalu-floor($semesteracuan/2);
            if ($semesteracuan % 2 ==0) {
              $semlalu=2;
            } else {
              $semlalu=1;
            }
          } else {// Ganjil
            $thnlalu=$thnlalu-ceil($semesteracuan/2);
            if ($semesteracuan % 2 ==0) {
              $semlalu=1;
            } else {
              $semlalu=2;
            }
          }
        }

          if ($data[semester]==2) {
            $tahunsemesterlalu=($data[tahun]-1)."1";
          } else {
            $tahunsemesterlalu=($data[tahun]-2)."2";
          }


    		      $q="
    			SELECT NLIPSTRAKM
    			FROM  trakm
    			WHERE
    		  NIMHSTRAKM='$idmahasiswaupdate' AND
    		  THSMSTRAKM<='$thnlalu$semlalu'
    		  ORDER BY THSMSTRAKM DESC LIMIT 0,1
    		  
     		";
     		$hip=mysqli_query($koneksi,$q);
        if (sqlnumrows($hip)>0) {
          $dip=sqlfetcharray($hip);
          $ips=$dip[NLIPSTRAKM];
        } else {
          $ips="Tidak ada";
        }

						
						if ($semesteracuan>0) {
              echo "$semesteracuan Semester Lalu";
             } else {
              echo  "semester ini";
             }            
            echo "</td>
						 <td>:</td>
             <td ><b>$ips</td>
					</tr>


    </table>
    
    </td>


  </tr>
  <tr>
    <td colspan=2 align=center style= border:none;>
    ";
/*
    $q="
    				SELECT 
				pengambilanmk.*,
				makul.NAMA,
				SKSMAKUL AS SKS,
				jadwalkuliahkurikulum.HARI,
				jadwalkuliahkurikulum.JAM,
				jadwalkuliahkurikulum.JAMSELESAI,
				jadwalkuliahkurikulum.RUANGAN
				FROM makul,pengambilanmk LEFT JOIN jadwalkuliahkurikulum ON
				(
        pengambilanmk.IDMAKUL=jadwalkuliahkurikulum.IDMAKUL AND
        pengambilanmk.TAHUN=jadwalkuliahkurikulum.TAHUN AND
        pengambilanmk.SEMESTER=jadwalkuliahkurikulum.SEMESTER AND
        pengambilanmk.KELAS=jadwalkuliahkurikulum.KELAS AND
        pengambilanmk.JENISKELAS=jadwalkuliahkurikulum.JENISKELAS AND
        SUBSTR(pengambilanmk.JAM,1,8)=jadwalkuliahkurikulum.JAM AND 
				jadwalkuliahkurikulum.IDPRODI='$d[IDPRODI]'
        )
				WHERE
				pengambilanmk.IDMAHASISWA='$idmahasiswaupdate'
				AND pengambilanmk.IDMAKUL=makul.ID
				AND pengambilanmk.SEMESTER='$semesterupdate'
				AND pengambilanmk.TAHUN='$tahunupdate'
				
				ORDER BY 
				pengambilanmk.IDMAKUL

				AND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  
				AND CONCAT(pengambilanmk.TAHUN-1,pengambilanmk.SEMESTER)=tbkmk.THSMSTBKMK  
				AND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK
				AND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK
				AND msmhs.NIMHSMSMHS=pengambilanmk.IDMAHASISWA
    ";
*/

    $q="
    				SELECT 
				pengambilanmk.*,
				tbkmk.NAKMKTBKMK  AS NAMA,
				SKSMAKUL AS SKS,
				jadwalkuliahkurikulum.HARI,
				jadwalkuliahkurikulum.JAM,
				jadwalkuliahkurikulum.JAMSELESAI,
				jadwalkuliahkurikulum.RUANGAN
				FROM msmhs,tbkmk,pengambilanmk LEFT JOIN jadwalkuliahkurikulum ON
				(
        pengambilanmk.IDMAKUL=jadwalkuliahkurikulum.IDMAKUL AND
        pengambilanmk.TAHUN=jadwalkuliahkurikulum.TAHUN AND
        pengambilanmk.SEMESTER=jadwalkuliahkurikulum.SEMESTER AND
        pengambilanmk.KELAS=jadwalkuliahkurikulum.KELAS AND
        pengambilanmk.JENISKELAS=jadwalkuliahkurikulum.JENISKELAS AND
        SUBSTR(pengambilanmk.JAM,1,8)=jadwalkuliahkurikulum.JAM AND 
				jadwalkuliahkurikulum.IDPRODI='$d[IDPRODI]'
        )
				WHERE
				pengambilanmk.IDMAHASISWA='$idmahasiswaupdate'
				AND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  
				AND  pengambilanmk.THNSM=tbkmk.THSMSTBKMK  
				AND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK
				AND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK
				AND msmhs.NIMHSMSMHS=pengambilanmk.IDMAHASISWA


				AND pengambilanmk.SEMESTER='$semesterupdate'
				AND pengambilanmk.TAHUN='$tahunupdate'
				
				ORDER BY 
				pengambilanmk.IDMAKUL

    ";


    $h2=mysqli_query($koneksi,$q);
    //echo $q.mysqli_error($koneksi);
    if (sqlnumrows($h2)>0) {
      $semesterx=((($tahunupdate-1-$d[ANGKATAN])*2)+$semesterupdate);
      echo "
        <br><Br> 
      <table class='bordertop' width=90% cellpadding=0 cellspacing=0 >
        <tr align=center>
          <td style=background-color:1px solid #000;>NO</td>
          <td>KODE MK</td>
          <td>MATA KULIAH</td>
          <td>KODE KELAS</td>
          <td>SKS</td>
           <td>HARI</td>
          <td>JAM</td>
          <td>RUANGAN</td>
             <td>TTD PENGAWAS</td>
        </tr>
      ";
      $i=0;
      $totalsks=0;
      while ($d2=sqlfetcharray($h2)) {
        $i++;
      echo "
        <tr class='trborderthin'>
          <td align=cente>$i&nbsp;</td>
          <td>$d2[IDMAKUL]&nbsp;</td>
          <td nowrap>$d2[NAMA]&nbsp;</td>
          <td nowrap align=center>$d2[KELAS]&nbsp;</td>
          <td align=center>$d2[SKS]&nbsp;</td>          
          <td>$d2[HARI]&nbsp;</td>
          <td>$d2[JAM]-$d2[JAMSELESAI]&nbsp;</td>
          <td>$d2[RUANGAN]&nbsp;</td> 
          <td></td>
        </tr>
      ";
      $totalsks+=$d2[SKS];

      }
      echo "
        <tr>
          <td colspan=4><b>JUMLAH SKS DIAMBIL</td>
          <td align=center><b>$totalsks&nbsp;</td>  
          <td >&nbsp;</td>
          <td>&nbsp;</td>          
          <td>&nbsp;</td> 
               
          <td>&nbsp;</td> 
        </tr>
      ";
      echo "</table>";
    }


    
   $q="SELECT penandatangan.* from penandatangan,mahasiswa 
   WHERE 
   mahasiswa.IDPRODI=penandatangan.IDPRODI AND
   mahasiswa.ID='$idmahasiswaupdate'";
  $httd=mysqli_query($koneksi,$q);
   if (sqlnumrows($httd)>0) {
    $dttd=sqlfetcharray($httd);
    if ($dttd[JABATAN2]!="" && $dttd[NAMA2]!="") {
      $jabatanbaak=$dttd[JABATAN2];
      $namabaak=$dttd[NAMA2];
      $gambarttd=$dttd[FILE2];
      $idprodix=$dttd[IDPRODI];
      $field="FILE2";
      
    }
   }
    echo "
    
    </td>
  </tr>
  <tr valign=top>
    <td align=center colspan=2 style= border:none;>
    <br>
    <table  width=100% >
      <tr valign=top>
        <td width=30% style= 'border:none;' class=loseborder>";
        if ($UNIVERSITAS!="UNILAK") {
          echo "$jabatanbaak";
								if ($gambarttd=="") {
								echo "
								<br><br><br><br><br>  ";
								} else {
								echo "
								<br>
								<img src='../nilai/lihat.php?idprodi=$idprodix&field=$field' height=80> 
								 ";
                }
                echo "
                <br>
        $namabaak
        ";
        
            }  

        echo "
        </td>
 
        <td class=loseborder></td>
 
        <td width=30% style = 'border:none;' class=loseborder>$lokasikantor, $waktu[mday] ".$arraybulan[$waktu[mon]-1]." $waktu[year]
        <br><br><br><br><br><br> 
        $d[NAMA]&nbsp;
        
        </td>
 
      </tr>
 
    </table>";
    
    echo "
    
    </td>
 


  </tr>  
<table>
";
 
?>
