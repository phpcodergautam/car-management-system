<main class="card p-3">
    <div class="col-lg-12 mt-3">
        <h4>Manage Brand</h4>
        <?= $this->session->flashdata('success'); ?>
        <hr>
    </div>
    <?php date_default_timezone_set('Asia/Calcutta'); ?>
    <?php $atime = date("h:i:s A"); ?>
    <div class="col-lg-12">
        <?php echo $this->session->flashdata('success'); ?>
        <form name="myForm" class="form-horizontal" id="myForm" action="<?= base_url('admin/addNewbrand'); ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="form-group col-4">
                    <label for="name">brand</label>
                    <input type="text" class="form-control" name="brandname" autocomplete="off">
                </div> 
                 <div class="form-group col-4">
                    <label for="name">brand Icon</label>
                    <input type="file" class="form-control form-control-sm" name="brandicon" autocomplete="off">
                </div> 
                <!-- <div class="form-group col-4">
                    <label for="name">Profile Website Link</label>
                    <input type="text" class="form-control" name="brandwebsite" autocomplete="off">
                </div>
 -->
                <div class="form-group text-right col-2">
                    <div class="mt-4"></div>
                    <input type="submit" class="btn btn-info btn-block" value="Create Now">
                </div>
            </div>
        </form>
    </div>
    <?php if(!empty($brand)): ?>
    <div class="col-lg-12 mt-4">
        <div style="overflow-x:scroll">
            <table id="pass" class="table table-hover table-sm table-bordered" cellspacing="0" width="100%">
                <thead class="text-white bg-info">
                    <tr>
                        <th width="40%">brand</th>
                        <th width="30%">brand Icon</th>
                        <th width="30%">OPTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($brand as $brand): ?>
                    <?php $brandId = $brand->brandId ?>
                    <tr>
                        <td>
                            <?= $brand->brandName; ?>
                        </td>
                        <td>
                            <img src="<?= base_url('assets/image/brand/'.$brand->brandIcon) ?>" alt="<?= $brand->brandName; ?>" height="60px" width="60px" style="border-radius: 50%">
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm mx-1 btn-warning" onclick="editbrand(<?= $brand->brandId; ?>)"><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-sm mx-1 btn-danger" onclick="deletebrand(<?= $brand->brandId; ?>)"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php else: ?>
    <div class="col-lg-12">
        <div class="jumbotron text-center">
            <h4>There isn't any brand available</h4>
        </div>
    </div>
    <?php endif; ?>
</main>

<script type="text/javascript">
    $(document).ready(function() {
        $('#pass').DataTable({
            "pageLength": 10
        });
    });

</script>

<script type="text/javascript">
    (function($, W, D) {
        var JQUERY4U = {};
        JQUERY4U.UTIL = {
            setupFormValidation: function() {
                //form validation rules
                $("#myForm").validate({
                    rules: {
                        brandname: "required",
                        brandicon: "required",
                    },
                    messages: {},
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
            }
        }
        //when the dom has loaded setup form validation rules
        $(D).ready(function($) {
            JQUERY4U.UTIL.setupFormValidation();
        });
    })(jQuery, window, document);

</script>


<script type="text/javascript">
    $(document).ready(function() {
        $('#whour').DataTable();
    });
    var save_method; //for save method string
    var table;

    function editbrand(id) {
        save_method = 'update';
        $('#myForm2')[0].reset(); // reset form on modals

        //Ajax Load data from ajax
        $.ajax({
            url: "<?= base_url('admin/brandEdit/')?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="brandId"]').val(data.brandId);
                $('[name="brandName"]').val(data.brandName);
                $('[name="brandIcon"]').val(data.brandIcon);

                $('#updateData').modal('show');
                $('.modal-title').text('Edit Data');

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function saveEditedbrand() {
        var url;
        if (save_method == 'add') {
            url = "<?php echo site_url('')?>";
        } else {
            url = "<?= base_url('admin/updatebrand')?>";
        }
        $.ajax({
            url: url,
            type: "POST",
            data: $('#myForm2').serialize(),
            dataType: "JSON",
            success: function(data) {
                //if success close modal and reload ajax table
                $('#updateData').modal('hide');
                location.reload(); // for reload a page
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
            }
        });
    }

    function deletebrand(id) {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function(isConfirm) {
            if (!isConfirm) return;
            $.ajax({
                url: "<?= base_url('admin/brandDelete/')?>" + id,
                type: "POST",

                success: function() {
                    location.reload();
                    swal("Done!", "It was succesfully deleted!", "success");
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal("Error deleting!", "Please try again", "error");
                }
            });
        });
    }

</script>


<!-- Bootstrap modal -->
<div class="modal fade" id="updateData" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Update brand</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body form">
                <form action="#" id="myForm2" class="form-horizontal">
                    <input type="hidden" value="" name="brandId" />
                    <div class="form-body">
                        <div class="form-group row">
                            <label class="control-label col-md-3">brand</label>
                            <div class="col-md-9">
                                <input name="brandName" class="form-control" type="text" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Brand Icon</label>
                            <div class="col-md-9">
                                <input name="brandIcon" class="form-control" type="file" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="saveEditedbrand()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- End Bootstrap modal -->

<script type="text/javascript">
    (function($, W, D) {
        var JQUERY4U = {};
        JQUERY4U.UTIL = {
            setupFormValidation: function() {
                //form validation rules
                $("#myForm2").validate({
                    rules: {
                        brandname: "required",
                        brandicon: "required",
                    },
                    messages: {},
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
            }
        }
        //when the dom has loaded setup form validation rules
        $(D).ready(function($) {
            JQUERY4U.UTIL.setupFormValidation();
        });
    })(jQuery, window, document);

</script>
