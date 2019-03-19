




    <div class="row">

        <div class="col-md-6">
            <form role="form" action="" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <p><b>   <? echo $GLOBALS['string']['komisyonOraniBaslik'];?></b></p>
                    <label for="komisyonorani" class="loginFormElement">
                        <? echo $GLOBALS['string']['komisyonOraniAciklama'];?></label>
                    <input class="form-control" id="komisyonorani" name="komisyonorani" type="text"
                           value="<? echo $data['komisyonorani'];?>">
                </div>


                <div class="form-group">
                    <p><b>   <? echo $GLOBALS['string']['istekSuresiAyarBaslik'];?></b></p>
                    <label for="isteksuresi" class="loginFormElement">
                        <? echo $GLOBALS['string']['istekSuresiAyarAciklama'];?></label>
                    <input class="form-control" id="isteksuresi" name="isteksuresi" type="text"
                           value="<? echo $data['isteksuresi'];?>">
                </div>


                <div class="form-group">
                    <p><b>   <? echo $GLOBALS['string']['ureticiUrunLimitBaslik'];?></b></p>
                    <label for="ureticiurunlimiti" class="loginFormElement">
                        <? echo $GLOBALS['string']['ureticiUrunLimitAciklama'];?></label>
                    <input class="form-control" id="ureticiurunlimiti" name="ureticiurunlimiti" type="text"
                           value="<? echo $data['ureticiurunlimiti'];?>">
                </div>

                <div class="form-group">
                    <p><b>   <? echo $GLOBALS['string']['ureticiTeklifSiniriBaslik'];?></b></p>
                    <label for="ureticiteklifsiniri" class="loginFormElement">
                        <? echo $GLOBALS['string']['ureticiTeklifSiniriAciklama'];?></label>
                    <input class="form-control" id="ureticiteklifsiniri" name="ureticiteklifsiniri" type="text"
                           value="<? echo $data['ureticiteklifsiniri'];?>">
                </div>






                <button id="settingsUpdate" name="settingsUpdate" type="submit" class="btn btn-sm btn-success btn-white btn-round">
                    <?php echo $GLOBALS['string']['degistir'];?>
                </button>

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