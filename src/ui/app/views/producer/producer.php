




    <div class="row">

        <div class="col-md-6">
            <form role="form" action="/wp-admin/admin.php?page=footsphere&Producers" method="POST" enctype="multipart/form-data">

                <? echo  $data['username'];?>


                <div class="form-group"><label for="Adi" class="loginFormElement">
                        <? echo $GLOBALS['string']['Adi'];?></label>
                    <input class="form-control" id="Adi" name="Adi" type="text"
                              value="<? echo $data['Adi'];?>">
                </div>

                <div class="form-group"><label for="mail" class="loginFormElement">
                        <? echo $GLOBALS['string']['mail'];?></label>
                    <input class="form-control" id="mail" name="mail" type="text"
                           value="<? echo $data['mail'];?>">
                </div>

                <div class="form-group"><label for="password" class="loginFormElement">
                        <? echo $GLOBALS['string']['sifre'];?></label>
                    <input class="form-control" id="password" name="password" type="text"
                           value="">
                </div>


                <div class="form-group"><label for="sirketAdi" class="loginFormElement">
                        <? echo $GLOBALS['string']['sirketAdi'];?></label>
                    <input class="form-control" id="sirketAdi" name="sirketAdi" type="text"
                           value="<? echo $data['sirketAdi'];?>">
                </div>

                <? echo  $data['maxminlayer'];?>



                <div class="form-group"><label for="tel" class="loginFormElement">
                        <? echo $GLOBALS['string']['tel'];?></label>
                    <input class="form-control" id="tel" name="tel" type="text"
                           value="<? echo $data['tel'];?>">
                </div>

                <div class="form-group"><label for="tel2" class="loginFormElement">
                        <? echo $GLOBALS['string']['tel'];?> - 2</label>
                    <input class="form-control" id="tel2" name="tel2" type="text"
                           value="<? echo $data['tel2'];?>">
                </div>

                <div class="form-group"><label for="adres" class="loginFormElement">
                        <? echo $GLOBALS['string']['adres'];?></label>
                    <input class="form-control" id="adres" name="adres" type="text"
                           value="<? echo $data['adres'];?>">
                </div>

                <div class="form-group"><label for="odemeBilgi" class="loginFormElement">
                        <? echo $GLOBALS['string']['odemeBilgi'];?></label>
                    <input class="form-control" id="odemeBilgi" name="odemeBilgi"type="text"
                           value="<? echo $data['odemeBilgi'];?>">
                </div>

                <div class="form-group"><label for="kargoBilgi" class="loginFormElement">
                        <? echo $GLOBALS['string']['kargoBilgi'];?></label>
                    <input class="form-control" id="kargoBilgi" name="kargoBilgi"type="text"
                           value="<? echo $data['kargoBilgi'];?>">
                </div>




                <?php echo $data['editButton']; ?>
                <a href="/wp-admin/admin.php?page=footsphere&Producers" class="btn btn-danger">
                    <?php echo $GLOBALS['string']['kapatYazisi'];?></a>

                <input type="hidden" id="userId" name="userId" value="<?php echo $data['userId']?>">



            </form>

        </div>













    <!-- /.container -->



<div id="push"></div>


        <style>



            #thumbwrap {
                margin:75px auto;
                width:500px; height:500px;
            }
            .thumb {
                float:left; /* must be floated for same cross browser position of larger image */
                position:relative;
                margin:3px;
            }
            .thumb img {
                border:1px solid #000;
                vertical-align:bottom;
            }
            .thumb:hover {
                border:0; /* IE6 needs this to show large image */
                z-index:1;
            }
            .thumb span {
                position:absolute;
                visibility:hidden;
            }
            .thumb:hover span {
                visibility:visible;
                top:37px; left:37px;
            }

        </style>