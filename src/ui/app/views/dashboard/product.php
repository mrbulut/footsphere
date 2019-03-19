




    <div class="row">

        <div class="col-md-6">
            <form role="form" action="/wp-admin/admin.php?page=footsphere&Products" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="PName" class="loginFormElement"><? echo $GLOBALS['string']['backend_comp_urunBasligiText'];?></label>
                    <input class="form-control" id="PName" name="PName"type="text" value="<? echo $data['PName'];?>">
                </div>

                <div class="form-group">
                    <label for="DescProduct" class="loginFormElement">
                        <? echo $GLOBALS['string']['backend_comp_urunAciklamasiText'];?></label>
                    <input class="form-control" id="DescProduct" name="DescProduct" type="text" value="<? echo $data['DescProduct'];?>">
                </div>

                <div>

                <div class="form-group">
                    <label for="Type" >
                        <? echo $GLOBALS['string']['backend_comp_turuText'];?></label>
                    <select class="form-control" name="Type" id="Type">
                        <? echo $data['Type_options'];?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="BaseMaterial" class="loginFormElement">
                        <? echo $GLOBALS['string']['backend_comp_tabanMalzemeText'];?></label>
                    <select class="form-control" name="BaseMaterial" id="BaseMaterial">
                        <? echo $data['BaseMaterial_options']?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="ClosureType" class="loginFormElement">
                        <? echo $GLOBALS['string']['backend_comp_kapanisTuru'];?></label>
                    <select class="form-control" name="ClosureType" id="ClosureType">
                        <? echo $data['ClosureType_options'];?>
                    </select>
                </div>



                <div class="form-group">
                    <label for="TopMeterial" class="loginFormElement"><? echo $GLOBALS['string']['backend_comp_ustMalzeme'];?></label>
                    <select class="form-control" name="TopMeterial" id="TopMeterial">
                        <? echo $data['TopMeterial_options'];?>
                    </select>
                </div>


                <div class="form-group">
                    <label for="liningMeterial" class="loginFormElement"><? echo $GLOBALS['string']['backend_comp_astarMalzemesi'];?></label>
                    <select class="form-control" name="liningMeterial" id="liningMeterial">
                        <? echo $data['liningMeterial_options'];?>
                    </select>
                </div>


                <div class="form-group">
                    <label for="Season" class="loginFormElement"><? echo $GLOBALS['string']['backend_comp_sezon'];?></label>
                    <select class="form-control" name="Season" id="Season">
                        <? echo $data['Season_options'];?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="InsideBaseType" class="loginFormElement"><? echo $GLOBALS['string']['backend_comp_icTabanturu'];?></label>
                    <select class="form-control" name="InsideBaseType" id="InsideBaseType">
                        <? echo $data['InsideBaseType_options'];?>
                    </select>
                </div>


                <div class="form-group">
                    <label for="InsideBaseMeterial" class="loginFormElement"><? echo $GLOBALS['string']['backend_comp_icTabanMalzemesi'];?></label>
                    <select class="form-control" name="InsideBaseMeterial"  id="InsideBaseMeterial">
                        <? echo $data['InsideBaseMeterial_options'];?>
                    </select>
                </div>






                <div class="form-group">
                    <label class="control-label"><?php echo $GLOBALS['string']['urun']." ".$GLOBALS['string']['resimyazisi']?> 1</label>
                    <?php echo $data['Image']; ?>

                    <input id="image" name="image" class="uploadfiles" data-icon="false" type="file">
                </div>


                <div class="form-group">
                    <label class="control-label"><?php echo $GLOBALS['string']['urun']. " ".$GLOBALS['string']['resimyazisi']?> 2</label>
                    <?php echo $data['Image2']; ?>

                    <input id="image2" name="image2" class="uploadfiles" data-icon="false" type="file">
                </div>



                <div class="form-group">
                    <label class="control-label"><?php echo $GLOBALS['string']['urun']." ".$GLOBALS['string']['resimyazisi']?> 3</label>
                    <?php echo $data['Image3']; ?>

                    <input id="image3" name="image3" class="uploadfiles" data-icon="false" type="file">
                </div>


                <?php echo $data['editButton']; ?>
                <a href="/wp-admin/admin.php?page=footsphere&Products" class="btn btn-danger">
                    <?php echo $GLOBALS['string']['kapatYazisi'];?></a>

                <input type="hidden" id="urunId" name="urunId" value="<?php echo $data['ID']?>">
                <input type="hidden" id="userId" name="userId" value="<?php echo $GLOBALS['userId']?>">
                <input type="hidden" id="ProducerNO" name="ProducerNO" value="<?php echo $data['ProducerNO']?>">
                <input type="hidden" id="Status" name="Status" value="<?php echo $data['Status']?>">



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