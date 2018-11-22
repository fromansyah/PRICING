<!DOCTYPE html>
<html>
    <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajax CRUD with Bootstrap modals and Datatables</title>
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.checkboxes.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/buttons.dataTables.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/jquery-ui.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
    <script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/dataTables.buttons.min.js')?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/buttons.html5.min.js')?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/dataTables.checkboxes.js')?>"></script>
    <script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
    <script type="text/javascript" src="<?=$this->config->item('base_url');?>js/numeral.min.js"></script>
    </head> 
<body>
    <div class="container">
        <font size="5">Asset Management</font>
        <br/>
        <br/>
        <button class="btn btn-success" onclick="add_asset()"><i class="glyphicon glyphicon-plus"></i> Add Asset</button>
        <button class="btn btn-info" id="button_test"><i class="glyphicon"></i>Selected Row</button>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Barcode</th>
                    <th>Name</th>
                    <th>Ctgry.</th>
                    <th>Pymnt. Status</th>
                    <th>Curr.</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th style="width:125px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Barcode</th>
                    <th>Name</th>
                    <th>Ctgry.</th>
                    <th>Pymnt. Status</th>
                    <th>Curr.</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>

<script type="text/javascript">
var _base_url = '<?= base_url() ?>';

var save_method; //for save method string
var table;

$(document).ready(function() {
    
    //datatables
    table = $('#table').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [0,'desc'], //Initial no order.
        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
        "pageLength": 25,
        //"dom": 'Bfrtip',
        "button": [
        'copy', 'excel'
    ],
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('Asset/ajax_list')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false //set not orderable
        }
        ]
    });
    
    table.buttons().container()
        .insertBefore( '#table_filter' );

    $('#table tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
        $(this).toggleClass('active');
    } );
    
    $('#button_test').click( function () {
        $result = 'Data: ';
        for (var i = 0; i < table.rows('.selected').data().length; i++) { 
            $result = $result + table.rows('.selected').data()[i][1] + '; ';
        }
        //alert( table.rows('.selected').data().length +' row(s) selected' );
        alert($result);
    } );

    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "mm-dd-yyyy",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true
    });

});


function barcode(barcode) {
  new_barcode = barcode.replace(/\//g,':');
  
  window.location = _base_url + 'Asset/generate_barcode/' + new_barcode;
  
//  $.ajax({
//            url : "<?php echo site_url('Asset/generate_barcode')?>/"+new_barcode,
//            type: "POST",
//            dataType: "JSON",
//            success: function(data)
//            {
//                if(data.status) //if success close modal and reload ajax table
//                {
//                    alert('TRUE');
//                }else{
//                    alert('FALSE '+data.error);
//                }
//            },
//            error: function (jqXHR, textStatus, errorThrown)
//            {
//                alert('Error deleting data');
//            }
//        });
}

function add_asset()
{
    window.location = _base_url + 'Asset/add/';
}

function edit_asset(id) {
    window.location = _base_url + 'Asset/edit/' + id;
}

function view_depreciation(asset_id) {
  window.location = _base_url + 'Depreciation/lists/' + asset_id;
}

function view_location(asset_id) {
  window.location = _base_url + 'Asset_location/lists/' + asset_id;
}

function view_payment(asset_id) {
  window.location = _base_url + 'Installment/lists/' + asset_id;
}

function put_location(asset_id) {
//  window.location = _base_url + 'Asset_location/add/' + asset_id;
    save_method = 'add_location';
    
    $('#form_location')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('Asset/ajax_edit/')?>/" + asset_id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="assetId"]').val(data.asset_id);
            $('[name="assetBarcode"]').val(data.barcode);
            $('[name="assetName"]').val(data.name);
            $('#modal_form_location').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Add Asset Location'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function return_asset(asset_id) {
//  window.location = _base_url + 'Asset_location/get_return_asset/' + id;
    save_method = 'return';
    
    $('#form_return')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('Asset_location/ajax_edit/')?>/" + asset_id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="returnAssetLocationId"]').val(data.asset_location_id);
            $('[name="returnAssetId"]').val(data.asset_id);
            $('[name="returnAssetBarcode"]').val(data.asset_barcode);
            $('[name="returnAssetName"]').val(data.asset_name);
            $('[name="returnLocationName"]').val(data.location_name);
            $('[name="returnEmpName"]').val(data.emp_name);
            $('[name="returnStartDate"]').val(data.start_date);
            $('[name="returnEndDate"]').val(data.end_date);
            $('#modal_form_return').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Return Asset'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function dispose(asset_id){
    save_method = 'dispose';
//    $('#form_disposal')[0].reset(); // reset form on modals
//    $('.form-group').removeClass('has-error'); // clear error class
//    $('.help-block').empty(); // clear error string
//    $('#modal_form_disposal').modal('show'); // show bootstrap modal
//    $('.modal-title').text('Disposal Form'); // Set Title to Bootstrap modal title
    
    $('#form_disposal')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('Asset/ajax_edit_for_dispose/')?>/" + asset_id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data.balance == null){
                $('[name="disposeNbv"]').val(numeral(data.idr_value).format('0,0.00'));
            }else{
                $('[name="disposeNbv"]').val(numeral(data.balance).format('0,0.00'));
            }

            $('[name="disposeAssetId"]').val(data.asset_id);
            $('[name="disposeAssetBarcode"]').val(data.barcode);
            $('[name="disposeAssetName"]').val(data.name);
            $('#modal_form_disposal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Disposal Form'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function cancel_dispose(asset_id, asset_name)
{
    if(confirm('Are you sure want to cancel '+asset_name+' disposal ?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('Asset/ajax_cancel_disposal')?>/"+asset_id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}

function view_asset(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('Asset/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="id"]').val(data.EMPLOYEE_ID);
            $('[name="empInitial"]').val(data.EMP_INITIAL);
            $('[name="firstName"]').val(data.FIRST_NAME);
            $('[name="middleName"]').val(data.MIDDLE_NAME);
            $('[name="lastName"]').val(data.LAST_NAME);
            $('[name="email"]').val(data.EMAIL);
            $('[name="status"]').val(data.RECORD_STATUS);
            $('[name="dob"]').datepicker('update',data.dob);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Asset'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('Asset/ajax_add')?>";
    } else {
        url = "<?php echo site_url('Asset/ajax_update')?>";
    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            }

            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

function saveLocation()
{
    $('#btnSaveLocation').text('saving...'); //change button text
    $('#btnSaveLocation').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add_location') {
        url = "<?php echo site_url('Asset_location/ajax_add')?>";
    } else {
        url = "<?php echo site_url('Asset_location/ajax_update')?>";
    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form_location').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form_location').modal('hide');
                reload_table();
            }else{
                serr = 'Fail to save data.';
                try {
                  serr = serr + ' ' + data.error;
                } catch(e) {}
                
                alert(serr);
            }
            
            $('#btnSaveLocation').text('save'); //change button text
            $('#btnSaveLocation').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSaveLocation').text('save'); //change button text
            $('#btnSaveLocation').attr('disabled',false); //set button enable 

        }
    });
}

function saveReturn()
{
    $('#btnSaveReturn').text('saving...'); //change button text
    $('#btnSaveReturn').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'return') {
        url = "<?php echo site_url('Asset_location/ajax_return')?>";
    } else {
        url = "<?php echo site_url('Asset_location/ajax_update')?>";
    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form_return').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form_return').modal('hide');
                reload_table();
            }else{
                serr = 'Fail to save data.';
                try {
                  serr = serr + ' ' + data.error;
                } catch(e) {}
                
                alert(serr);
            }
            
            $('#btnSaveReturn').text('save'); //change button text
            $('#btnSaveReturn').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSaveReturn').text('save'); //change button text
            $('#btnSaveReturn').attr('disabled',false); //set button enable 

        }
    });
}

function saveDisposal()
{
    $('#btnSaveDiposal').text('saving...'); //change button text
    $('#btnSaveDiposal').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'dispose') {
        url = "<?php echo site_url('Disposal/ajax_add')?>";
    } else {
        url = "<?php echo site_url('Disposal/ajax_update')?>";
    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form_disposal').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form_disposal').modal('hide');
                reload_table();
            }else{
                serr = 'Fail to save data.';
                try {
                  serr = serr + ' ' + data.error;
                } catch(e) {}
                
                alert(serr);
            }
            
            $('#btnSaveDiposal').text('save'); //change button text
            $('#btnSaveDiposal').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSaveDiposal').text('save'); //change button text
            $('#btnSaveDiposal').attr('disabled',false); //set button enable 

        }
    });
}

function delete_asset(id, asset_name)
{
    if(confirm('Are you sure delete this data: '+asset_name+' ?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('Asset/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}



function payment(asset_id){
    save_method = 'payment';
//    $('#form_disposal')[0].reset(); // reset form on modals
//    $('.form-group').removeClass('has-error'); // clear error class
//    $('.help-block').empty(); // clear error string
//    $('#modal_form_disposal').modal('show'); // show bootstrap modal
//    $('.modal-title').text('Disposal Form'); // Set Title to Bootstrap modal title
    
    $('#form_installment')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('Asset/ajax_edit_for_installment/')?>/" + asset_id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="installmentPrice"]').val(numeral(data.ori_value).format('0,0.00'));
            $('[name="installmentAssetId"]').val(data.asset_id);
            $('[name="installmentAssetBarcode"]').val(data.barcode);
            $('[name="installmentAssetName"]').val(data.name);
            $('[name="installmentTotal"]').val(numeral(data.installment_amount).format('0,0.00'));
            $('[name="lastInstallment"]').val(data.installment_status_name);
            $('[name="installmentStatus"]').val(data.installment_status+1);
            $('[name="installmentCurrency"]').val(data.currency);
            $('[name="installmentPriceCurrency"]').val(data.currency);
            $('[name="installmentAmount"]').val(numeral(data.ori_value - data.installment_amount).format('0,0.00'));
            
            $('#modal_form_installment').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Installment Form'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function saveInstallment()
{
    $('#btnSaveInstallment').text('saving...'); //change button text
    $('#btnSaveInstallment').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'payment') {
        url = "<?php echo site_url('Installment/ajax_add')?>";
    } else {
        url = "<?php echo site_url('Installment/ajax_update')?>";
    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form_installment').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form_installment').modal('hide');
                reload_table();
            }else{
                serr = 'Fail to save data.';
                try {
                  serr = serr + ' ' + data.error;
                } catch(e) {}
                
                alert(serr);
            }
            
            $('#btnSaveInstallment').text('save'); //change button text
            $('#btnSaveInstallment').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSaveInstallment').text('save'); //change button text
            $('#btnSaveInstallment').attr('disabled',false); //set button enable 

        }
    });
}
</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Asset Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">ID</label>
                            <div class="col-md-9">
                                <input name="id" placeholder="ID" class="form-control" type="text" disabled="true">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Emp. Initial</label>
                            <div class="col-md-9">
                                <input name="empInitial" placeholder="Emp. Initial" class="form-control" type="text" disabled="true">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">First Name</label>
                            <div class="col-md-9">
                                <input name="firstName" placeholder="First Name" class="form-control" type="text" disabled="true">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Middle Name</label>
                            <div class="col-md-9">
                                <input name="middleName" placeholder="Middle Name" class="form-control" type="text" disabled="true">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Last Name</label>
                            <div class="col-md-9">
                                <input name="lastName" placeholder="Last Name" class="form-control" type="text" disabled="true">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Email</label>
                            <div class="col-md-9">
                                <input name="email" placeholder="Email" class="form-control" type="text" disabled="true">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Status</label>
                            <div class="col-md-9">
                                <select name="status" class="form-control" disabled="true">
                                    <option value="">--Select Gender--</option>
                                    <option value="A">Active</option>
                                    <option value="D">Non Active</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
<!--                        <div class="form-group">
                            <label class="control-label col-md-3">Date of Birth</label>
                            <div class="col-md-9">
                                <input name="dob" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>-->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <!--<button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>-->
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<!--FORM ADD LOCATION -->
<div class="modal fade" id="modal_form_location" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Location Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_location" class="form-horizontal">
                    <input name="assetId" class="form-control" type="hidden">
                    <div class="form_location-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Asset Barcode</label>
                            <div class="col-md-9">
                                <input name="assetBarcode" placeholder="Asset Barcode" class="form-control" type="text" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Asset Name</label>
                            <div class="col-md-9">
                                <input name="assetName" placeholder="Asset Name" class="form-control" type="text" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Location</label>
                            <div class="col-md-9">
                                <?php echo form_dropdown('location', $location_list, '', 'name="location" placeholder="Location" class="form-control" type="text"'); ?>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Employee</label>
                            <div class="col-md-9">
                                <?php echo form_dropdown('employeeId', $employee_list, '', 'name="employeeId" placeholder="Employee" class="form-control" type="text"'); ?>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Start Date</label>
                            <div class="col-md-9">
                                <input name="startDate" placeholder="mm-dd-yyyy" class="form-control datepicker" format="mm-dd-yyyy" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">End Date</label>
                            <div class="col-md-9">
                                <input name="endDate" placeholder="mm-dd-yyyy" class="form-control datepicker" data-date-format="mm/dd/yyyy" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Description</label>
                            <div class="col-md-9">
                                <textarea name="desc" placeholder="Description" class="form-control" type="text"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSaveLocation" onclick="saveLocation()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!--END FORM ADD LOCATION -->

<!--FORM RETURN -->
<div class="modal fade" id="modal_form_return" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Location Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_return" class="form-horizontal">
                    <input name="returnAssetId" class="form-control" type="hidden">
                    <input name="returnAssetLocationId" class="form-control" type="hidden">
                    <div class="form_return-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Asset Barcode</label>
                            <div class="col-md-9">
                                <input name="returnAssetBarcode" placeholder="Asset Barcode" class="form-control" type="text" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Asset Name</label>
                            <div class="col-md-9">
                                <input name="returnAssetName" placeholder="Asset Name" class="form-control" type="text" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Location</label>
                            <div class="col-md-9">
                                <input name="returnLocationName" placeholder="Location" class="form-control" type="text" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Employee</label>
                            <div class="col-md-9">
                                <input name="returnEmpName" placeholder="Employee" class="form-control" type="text" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Start Date</label>
                            <div class="col-md-9">
                                <input name="returnStartDate" placeholder="mm-dd-yyyy" class="form-control" format="mm-dd-yyyy" type="text" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">End Date</label>
                            <div class="col-md-9">
                                <input name="returnEndDate" placeholder="mm-dd-yyyy" class="form-control datepicker" data-date-format="mm/dd/yyyy" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Note</label>
                            <div class="col-md-9">
                                <textarea name="returnNote" placeholder="Note" class="form-control" type="text"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSaveReturn" onclick="saveReturn()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!--END FORM RETURN -->

<!--FORM DISPOSAL -->
<div class="modal fade" id="modal_form_disposal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Location Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_disposal" class="form-horizontal">
                    <input name="disposeAssetId" class="form-control" type="hidden">
                    <input name="disposeId" class="form-control" type="hidden">
                    <div class="form_disposal-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Net Book Value</label>
                            <div class="col-md-9">
                                <input name="disposeNbv" placeholder="Net Book Value" class="form-control" type="text" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Asset Barcode</label>
                            <div class="col-md-9">
                                <input name="disposeAssetBarcode" placeholder="Asset Barcode" class="form-control" type="text" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Asset Name</label>
                            <div class="col-md-9">
                                <input name="disposeAssetName" placeholder="Asset Name" class="form-control" type="text" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Date</label>
                            <div class="col-md-9">
                                <input name="disposeDate" placeholder="mm-dd-yyyy" class="form-control datepicker" data-date-format="mm-dd-yyyy" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Currency</label>
                            <div class="col-md-9">
                                <select name="disposeCurrency" class="form-control">
                                    <option value="IDR">IDR</option>
                                    <option value="USD">USD</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Rate</label>
                            <div class="col-md-9">
                                <input name="disposeRate" placeholder="Rate" class="form-control" type="text" value="1">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Cost Adjustment</label>
                            <div class="col-md-9">
                                <input name="disposeCostAdjustment" placeholder="Cost Adjustment" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Reason</label>
                            <div class="col-md-9">
                                <textarea name="disposeReason" placeholder="Reason" class="form-control" type="text"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSaveDisposal" onclick="saveDisposal()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!--END FORM DISPOSAL -->


<!--FORM INSTALLMENT -->
<div class="modal fade" id="modal_form_installment" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Installment Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_installment" class="form-horizontal">
                    <input name="installmentAssetId" class="form-control" type="hidden">
                    <input name="installmentId" class="form-control" type="hidden">
                    <div class="form_installment-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Asset Price Currency</label>
                            <div class="col-md-9">
                                <input name="installmentPriceCurrency" placeholder="Price" class="form-control" type="text" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Asset Price</label>
                            <div class="col-md-9">
                                <input name="installmentPrice" placeholder="Price" class="form-control" type="text" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Asset Barcode</label>
                            <div class="col-md-9">
                                <input name="installmentAssetBarcode" placeholder="Asset Barcode" class="form-control" type="text" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Asset Name</label>
                            <div class="col-md-9">
                                <input name="installmentAssetName" placeholder="Asset Name" class="form-control" type="text" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Date</label>
                            <div class="col-md-9">
                                <input name="installmentDate" placeholder="mm-dd-yyyy" class="form-control datepicker" data-date-format="mm-dd-yyyy" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Total Installment</label>
                            <div class="col-md-9">
                                <input name="installmentTotal" placeholder="Total Installment" class="form-control" type="text" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Last Installment</label>
                            <div class="col-md-9">
                                <input name="lastInstallment" class="form-control" type="text" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Installment Status</label>
                            <div class="col-md-9">
                                <?php echo form_dropdown('installmentStatus', $installment_status_list, '', 'name="installmentStatus" placeholder="Installment Status" class="form-control" type="text"'); ?>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Currency</label>
                            <div class="col-md-9">
                                <select name="installmentCurrency" class="form-control">
                                    <option value="IDR">IDR</option>
                                    <option value="USD">USD</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Rate</label>
                            <div class="col-md-9">
                                <input name="installmentRate" placeholder="Rate" class="form-control" type="text" value="1">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Amount</label>
                            <div class="col-md-9">
                                <input name="installmentAmount" placeholder="Installment Amount" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Note</label>
                            <div class="col-md-9">
                                <textarea name="installmentNote" placeholder="Note" class="form-control" type="text"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSaveInstallment" onclick="saveInstallment()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!--END FORM INSTALLMENT -->
</body>
</html>
