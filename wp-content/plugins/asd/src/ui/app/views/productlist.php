<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 11.03.2019
 * Time: 10:58
 */


$columTitleNameArray = array(
    "1", "2", "3", "4", "5", "6", "7", "2", "3"
);
$columNameTitles = null;
foreach ($columTitleNameArray as $key => $value) {
    $columNameTitles = $columNameTitles . "<th>" . $value . "</th>";
}

echo "brda";
?>


<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table id="mytable" class="table table-bordred table-striped">
                <thead>
                <th><input type="checkbox" id="checkall"/></th>
                <?php echo $columNameTitles; ?>
                </thead>
                <tbody>
                <tr>
                    <td><input type="checkbox" class="checkthis"/></td>
                    <td>Mohsin</td>
                    <td>Irshad</td>
                    <td>CB 106/107 Street # 11 Wah Cantt Islamabad Pakistan</td>
                    <td>isometric.mohsin@gmail.com</td>
                    <td>+923335586757</td>
                    <td>
                        <p data-placement="top" data-toggle="tooltip" title="Edit">
                            <button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal"
                                    data-target="#edit"
                            ><span class="glyphicon glyphicon-pencil">Edit</span></button>
                        </p>
                    </td>
                    <td>
                        <p data-placement="top" data-toggle="tooltip" title="Delete">
                            <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal"
                                    data-target="#delete">
                                <span class="glyphicon glyphicon-trash">Delete</span></button>
                        </p>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>
</div>
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                            class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading">Edit Your Detail</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input class="form-control " type="text" placeholder="Mohsin">
                </div>
                <div class="form-group">
                    <input class="form-control " type="text" placeholder="Irshad">
                </div>
                <div class="form-group">
                    <textarea rows="2" class="form-control"
                              placeholder="CB 106/107 Street # 11 Wah Cantt Islamabad Pakistan"></textarea>
                </div>
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-warning btn-lg" style="width: 100%;"><span
                            class="glyphicon glyphicon-ok-sign"></span> Update
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                            class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you
                    want to delete this Record?
                </div>
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Yes
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span
                            class="glyphicon glyphicon-remove"></span> No
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->


    <script>

        $(document).ready(function () {
            $("#mytable #checkall").click(function () {
                if ($("#mytable #checkall").is(':checked')) {
                    $("#mytable input[type=checkbox]").each(function () {
                        $(this).prop("checked", true);
                    });

                } else {
                    $("#mytable input[type=checkbox]").each(function () {
                        $(this).prop("checked", false);
                    });
                }
            });

            $("[data-toggle=tooltip]").tooltip();
        });


    </script>