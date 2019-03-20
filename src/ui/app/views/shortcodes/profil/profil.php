
<?php
include_once 'profilController.php';
$profilCont = new profilController();
$data = $profilCont->getData();

?>

<div class="row" id="informantion">

    <div class="form-group">
        <h3><?php echo $GLOBALS['string']['bilgiler'];?></h3>
    </div>
    <form action="http://localhost/footsphere_profil/" method="POST">
        <div class="form-group">
            <div class="col-xs-6"><label for="name"><h5><?php echo $GLOBALS['string']['Adi'];?>
                    </h5></label> <input type="text" class="form-control" name="name" id="name" value="<?php echo $data['name'];?>"
                                                                                            >
            </div>
        </div>


        <div class="form-group">
            <div class="col-xs-6"><label for="email"><h5><?php echo $GLOBALS['string']['mail'];?>
                    </h5></label> <input type="email" class="form-control" name="email" id="email" value="<?php echo $data['mail'];?>"></div>
        </div>


        <div class="form-group">
            <div class="col-xs-6"><label for="lenght"><h5><?php echo $GLOBALS['string']['backend_profil_boyText'];?></h5></label> <input type="text" class="form-control"
                                                                                      id="lenght"  value="<?php echo $data['lenght'];?>"></div>
        </div>
        <div class="form-group">
            <div class="col-xs-6"><label for="age"><h5><?php echo $GLOBALS['string']['backend_profil_yasText'];?></h5></label> <input type="text" class="form-control"
                                                                                       id="age"  value="<?php echo $data['age'];?>"></div>
        </div>
        <div class="form-group">
            <div class="col-xs-6"><label for="weight"><h5><?php echo $GLOBALS['string']['backend_profil_kiloText'];?></h5></label> <input type="text" class="form-control"
                                                                                       id="weight"  value="<?php echo $data['weight'];?>"></div>
        </div>
        <div class="form-group">
            <div class="col-xs-6"><label for="footsize"><h5><?php echo $GLOBALS['string']['backend_profil_aOlcuText'];?></h5></label> <input type="text" class="form-control"
                                                                                       id="footsize"  value="<?php echo $data['footsize'];?>"></div>
        </div>
        <div class="form-group">
            <div class="col-xs-12"><label for="ekstrabilgi"><h5><?php echo $GLOBALS['string']['backend_profil_exBilgiText'];?></h5></label> <input type="text" class="form-control"
                                                                                                                                             id="ekstrabilgi"  value="<?php echo $data['ekstrabilgi'];?>"></div>
        </div>



            <div class="col-xs-12"><br>
                <button id="UpdateButton" name="UpdateButton" type="submit" class="btn btn-primary"><?php echo $GLOBALS['string']['degistir'];?></button>
            </div>

    </form>
</div>
<br>
<br>

<div class="row" id="files">

    <div class="form-group">
        <h3><?php echo $GLOBALS['string']['backend_profil_ekstraDosyaBaslik'];?></h3>
    </div>

        <div class="form-group">
            <div class="col-xs-6">

                <form action="" enctype="multipart/form-data" method="POST">

                <label for="name"><h5><?php echo $GLOBALS['string']['files'];?>
                    </h5></label>
                <input id="extrafile" name="extrafile" class="uploadfiles" data-icon="false" type="file">

                    <div class="col-xs-12"><br>
                        <button id="uploadButton" name="uploadButton" type="submit" class="btn btn-primary"><?php echo $GLOBALS['string']['backend_profil_ekstraDosyaYukleButton'];?></button>
                    </div>


                </form>

            </div>
        </div>


        <div class="form-group">
            <div class="col-xs-6">
                <label for="email"><h4><?php echo $GLOBALS['string']['smcomp_yuklenmisDosyalarBaslik'];?></h4></label>
<br>
                <?php echo $data['yuklenmisdosyalar'];?>
            </div>


        </div>







</div>
<br>
<br>

<div class="row" id="footsphere">

    <div class="form-group">
        <h3><?php echo $GLOBALS['string']['backend_profil_footsphereBilgiBaslik'];?></h3>
    </div>
        <div class="form-group">
            <div class="col-xs-4"> <img src="<?php echo $data['image'];?>"></div>
        </div>
    <div class="form-group">
        <div class="col-xs-4"> <img src="<?php echo $data['image2'];?>"></div>
    </div>

    <div class="form-group">
        <div class="col-xs-4"> <img src="<?php echo $data['image3'];?>"></div>
    </div>

    <div class="form-group">
        <img src="<?php echo $data['3d'];?>">
    </div>


</div>




<style>

    .fa-remove {
        color: red;
    }

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