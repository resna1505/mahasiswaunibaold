<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot();
$hasil = generaterandomcaptcha(4);
$_SESSION['tokenlogin'] = $hasil['token'];
$_SESSION['antispamlogin'] = $hasil['rand'];
?>
 <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                Pengumuman
                            </div>
                            
                        </div>
                        <div class="portlet-body form">
                            <div class="m-timeline-3">
								<div class="m-timeline-3__items">

                                    <?php 
                                        if ( $aksi == "detil" )
                                        {
                                            $query = "SELECT ID,DATE_FORMAT(TANGGALMULAI,'%d-%m-%Y %H:%i:%s') AS TGL,JUDUL,\r\n           SUBSTRING(RINCIAN,1,LENGTH(RINCIAN)+1) AS RINCIAN2,\r\n           IF(TO_DAYS(TANGGALMULAI)>=TO_DAYS(NOW())-3,'Baru,','') AS BARU,IDUSER,LOKASI  FROM\r\n           pengumuman WHERE ID='{$id}'";
                                        }
                                        else
                                        {
                                            $query = "SELECT ID,DATE_FORMAT(TANGGALMULAI,'%d-%m-%Y %H:%i:%s') AS TGL,JUDUL,\r\n            SUBSTRING(RINCIAN,1,500) AS RINCIAN2,\r\n            IF(LENGTH(RINCIAN)>500,1,0) AS P, \r\n            IF(TO_DAYS(TANGGALMULAI)>=TO_DAYS(NOW())-3,'Baru,','') AS BARU,IDUSER,LOKASI  FROM\r\n            pengumuman ORDER BY TANGGALMULAI DESC LIMIT 3";
                                        }
					#echo $query;					
                                        $hasil = mysqli_query($koneksi, $query);
                                        if ( 0 < mysqli_num_rows( $hasil ) )
                                        {
                                            $i = 1;
                                            while ( $data = mysqli_fetch_array( $hasil ) )
                                            {
                                                if ( file_exists( "pengumuman/gambar/".$data['ID'].".txt" ) )
                                                {
                                                    $logo = file( "pengumuman/gambar/".$data['ID'].".txt" );
                                                    $filelogo = $logo[0];
                                                    $size = imgsizeprop( "pengumuman/gambar/{$filelogo}", 150 );
                                                    $img = "<a target='_blank' href='pengumuman/gambar/{$filelogo}'>\r\n        \t\t\t<img  border=0 align=left height={$size['1']} width={$size['0']} \r\n        \t\t\tsrc='pengumuman/gambar/{$filelogo}'>\r\n        \t\t\t</a>";
                                                }
                                                $selengkapnya = "";
                                                if ( $data['P'] == 1 )
                                                {
                                                    $selengkapnya = "<a href='index.php?pilihan=berita&aksi=detil&id={$data['ID']}'><b>Selengkapnya...</b></a>";
                                                }
                                                
												/*echo "<h4>$data[JUDUL]</h4>";
												echo "<p>ditulis oleh (".$data[IDUSER]."), ".$arraylokasi[$data[LOKASI]].", ".$data[TGL]."</p>";
												echo "<p>".$img.html_entity_decode( "{$data['RINCIAN2']}...." )."</p>";
												*/
												if($i==1){
													$item="info";
												}elseif($i==2){
													$item="warning";
												}else{
													$item="success";
												}
												echo "	<div class=\"m-timeline-3__item m-timeline-3__item--$item\">
															<div class=\"m-timeline-3__item-desc\">
																<span class=\"m-timeline-3__item-text\">
																	".$data['JUDUL']."
																</span>
																<br>
																<span class=\"m-timeline-3__item-user-name\">
																	<a href=\"#\" class=\"m-link m-link--metal m-timeline-3__item-link\">
																		Oleh (".$data['IDUSER']."), ".$arraylokasi[$data['LOKASI']].", ".$data['TGL']."
																	</a>
																</span>
																<br>
																<span class=\"m-timeline-3__item-text\" style=\"font-size:13px;\">
																	".html_entity_decode( "{$data['RINCIAN2']}...." )."
																</span>
																<span class=\"m-timeline-3__item-text\" style=\"font-size:13px;\">
																	".$selengkapnya."
																</span>
																
															</div>
														</div>	";
														$i++;
											}
                                        }else
                                        {
                                            echo "<tr><td colspan=\"2\"><br><br><br><br><br><br><br><br><br><br><br><br><br><br><p class='alert'>Belum ada pengumuman saat ini..</p><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td></tr>";
                                        }
                                        echo "</table></form>";
                                    ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->

<?php
if ( $errlogin != "" )
{
    echo "<SCRIPT>";
    if ( $errlogin == "id" )
    {
        echo "log.iduser.focus();";
    }
    else
    {
        echo "log.password.focus();";
    }
    echo "</SCRIPT>";
}
?>
