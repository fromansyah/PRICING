<!DOCTYPE html>
<html>
    <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajax CRUD with Bootstrap modals and Datatables</title>
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">

    </head> 
<body>
    <div class="container">
        <span width="100" style="background-color: #e0e0e0; display: block;">
            &nbsp;<font size="5" style="font-weight: bold; color: #737373">Product Price : [<?echo str_replace('slash', '/', $product_no)?>] <?echo $product_name?></font>
        </span>
        <br/>
        <button class="btn btn-warning" onclick="back_to_product()"><i class="glyphicon glyphicon-backward"></i> Back</button>
        <button class="btn btn-success" onclick="add_price()"><i class="glyphicon glyphicon-plus"></i> Add Price</button>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Year</th>
                    <th>Periode</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Catalogue Price</th>
                    <th style="width:30px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Year</th>
                    <th>Periode</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Catalogue Price</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>

<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>


<script type="text/javascript">

var _base_url = '<?= base_url() ?>';

var save_method; //for save method string
var table;

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('index.php/Product_price/ajax_list/'.$product_no)?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false //set not orderable
        },
        ]

    });

    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true
    });

});

function back_to_product()
{
    window.location = _base_url + 'index.php/Product/';
}

function add_price()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Product Price'); // Set Title to Bootstrap modal title
}

function edit_price(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    
//    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
//    $('.modal-title').text('Edit Product Price'); // Set title to Bootstrap modal title

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('index.php/Product_price/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="priceId"]').val(data.price_id);
            $('[name="year"]').val(data.periode_year);
            $('[name="periode"]').val(data.periode_month);
            $('[name="price"]').val(data.catalogue_price);
//            $('[name="sbPrice"]').val(data.sb_price);
            $('[name="startDate"]').val(data.start_date);
            $('[name="endDate"]').val(data.end_date);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Product Price'); // Set title to Bootstrap modal title

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
        url = "<?php echo site_url('index.php/Product_price/ajax_add')?>";
    } else {
        url = "<?php echo site_url('index.php/Product_price/ajax_update')?>";
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

                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
            }else{
                serr = 'Fail to save data.';
                try {
                  serr = serr + ' ' + data.error;
                } catch(e) {}
                
                alert(serr);
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

function delete_price(id, price)
{
    if(confirm('Are you sure delete this data: ' + price + ' ?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('index.php/Product_price/ajax_delete')?>/"+id,
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

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Product Price Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="<?=str_replace('slash', '/', $product_no)?>" name="productNo"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">ID</label>
                            <div class="col-md-9">
                                <input name="priceId" placeholder="ID" class="form-control" type="text" readonly="true">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Year</label>
                            <div class="col-md-9">
                                <input name="year" placeholder="Year" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Period</label>
                            <div class="col-md-9">
                                <?php echo form_dropdown('periode', $periode_list, '', 'name="periode" placeholder="Period" class="form-control" type="text"'); ?>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Start Date</label>
                            <div class="col-md-9">
                                <input name="startDate" placeholder="yyyy-mm-dd" class="form-control datepicker" data-date-format="mm-dd-yyyy" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">End Date</label>
                            <div class="col-md-9">
                                <input name="endDate" placeholder="yyyy-mm-dd" class="form-control datepicker" data-date-format="mm-dd-yyyy" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Catalogue Price</label>
                            <div class="col-md-9">
                                <input name="price" placeholder="Catalogue Price" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
<!--                        <div class="form-group">
                            <label class="control-label col-md-3">S&B Price</label>
                            <div class="col-md-9">
                                <input name="sbPrice" placeholder="S&B Price" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>-->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
</body>
</html>
