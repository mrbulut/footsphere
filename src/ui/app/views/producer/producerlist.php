<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 11.03.2019
 * Time: 10:58
 */


?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
<div class="row">

    <div class="panel panel-default panel-table">
        <div class="panel-heading">
            <div class="row">
                <div class="col col-xs-6">

                    <a class="btn btn-sm btn-primary btn-create"
                       href="/wp-admin/admin.php?page=footsphere&Producers&home&0-create">
                        <?php echo $GLOBALS['string']['ureticiEkle']?></a>
                </div>
                <div class="col col-xs-6 text-left">

                </div>
            </div>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered table-list">
                <thead>
                <tr>
                    <?php echo $data['columns']; ?>
                    <th><em class="fa fa-cog"></em></th>

                </tr>
                </thead>
                <tbody>

                    <?php echo $data['products']; ?>


                </tbody>
            </table>

        </div>



    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="openStatusDialog" name="openStatusDialog" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-footer">
                <form  role="form" method="POST" action="admin.php?page=footsphere&Products" >
                    <input type="hidden" id="hiddenValueProductId" name="hiddenValueProductId" value="">
                    <button name="changeButtonClickOnayla" type="submit" class="btn btn-success" ><?php echo $GLOBALS['string']['onayla']?></button>
                    <button name="changeButtonClickReddet" type="submit" class="btn btn-danger"><?php echo $GLOBALS['string']['onaylama']?></button>
                </form>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo $GLOBALS['string']['kapatYazisi']?></button>
            </div>
        </div>
    </div>
</div>

<style>

    .panel-table .panel-body{
        padding:0;
    }

    .panel-table .panel-body .table-bordered{
        border-style: none;
        margin:0;
    }

    .panel-table .panel-body .table-bordered > thead > tr > th:first-of-type {
        text-align:center;
        width: 100px;
    }

    .panel-table .panel-body .table-bordered > thead > tr > th:last-of-type,
    .panel-table .panel-body .table-bordered > tbody > tr > td:last-of-type {
        border-right: 0px;
    }

    .panel-table .panel-body .table-bordered > thead > tr > th:first-of-type,
    .panel-table .panel-body .table-bordered > tbody > tr > td:first-of-type {
        border-left: 0px;
    }

    .panel-table .panel-body .table-bordered > tbody > tr:first-of-type > td{
        border-bottom: 0px;
    }

    .panel-table .panel-body .table-bordered > thead > tr:first-of-type > th{
        border-top: 0px;
    }

    .panel-table .panel-footer .pagination{
        margin:0;
    }

    /*
    used to vertically center elements, may need modification if you're not using default sizes.
    */
    .panel-table .panel-footer .col{
        line-height: 34px;
        height: 34px;
    }

    .panel-table .panel-heading .col h3{
        line-height: 30px;
        height: 30px;
    }

    .panel-table .panel-body .table-bordered > tbody > tr > td{
        line-height: 34px;
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

<script>

    function hiddenValueProductId($id) {
        document.getElementById("hiddenValueProductId").value = $id;
    }
</script>


