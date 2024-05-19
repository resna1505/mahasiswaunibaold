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
#print_r($_SESSION);
#$_SESSION['tokenlogin'] = '123AA';
#$_SESSION['antispamlogin'] = '123AA';


?>
<!-- BEGIN SAMPLE FORM PORTLET-->
<?php 
echo "<script language=JAVASCRIPT>
	function teslogin (form) {
		if (form.iduser.value=='') {
			alert('ID harus diisi');
			form.iduser.focus();
		}else if (form.password.value=='') {
			alert('Password harus diisi');
			form.password.focus();
		} else {
			return true;
		}
		return false;
	}
	</script>
<!--  form login -->";
echo "<form class=\"form-horizontal\" role=\"form\" name=log action=index.php method=post>";
?>
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">Login Form</div>
                        </div>
                        <div class="portlet-body form">
                            <form class="form-horizontal" role="form">
                                <div class="form-body">
                                  
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">User ID</label>
                                        <div class="col-md-9">
                                            <div class="input-inline input-medium">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                    </span>
                                                    <input name="iduser" type="text" class="form-control" placeholder="ID User" style="z-index:0;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label class="col-md-3 control-label">Password</label>
                                        <div class="col-md-9">
                                            <div class="input-inline input-medium">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                    <i class="fa fa-lock"></i>
                                                    </span>
                                                    <input name="password" type="password" class="form-control" placeholder="Password" style="z-index:0;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"></label>
                                        <div class="col-md-9">
                                            <div class="input-inline input-medium">
                                                <div class="input-group">
                                                    <img class="codenumber" src="antispam.php?idspam=1" width='220' height='50'/>
                                                </div>
                                            </div>
                                            <span class="help-inline">
                                            Masukan Kode Spam </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Anti Spam</label>
                                        <div class="col-md-9">
                                            <div class="input-inline input-medium">
                                                <div class="input-group">
                                                    <input name="randlogin" type="text" class="form-control" placeholder="Masukan Kode Diatas" style="z-index:0;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions left">
                            <?php
                            echo "<input name=aksi class=\"btn blue\" type=\"submit\" value=\"Login\" onClick=\"return teslogin(log);\"/>
                                  <input class=\"btn default\" type=\"reset\" value=\"Reset\"/>";
                            ?>
                                    
                                </div>
                            </form>
			<div>&nbsp;</div>
							<div align="center">--- Atau Login Menggunakan Gmail Mahasiswa Universitas Batam ---</div>
							<div>&nbsp;</div>
						<?php	
							echo  '<div align="center"><a href="'.$google_client->createAuthUrl().'"><img src="gambar/btn_google_signin.png" /></a></div>';
						?>
						<div>&nbsp;</div>
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
