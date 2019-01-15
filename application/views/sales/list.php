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
            &nbsp;<font size="5" style="font-weight: bold; color: #737373">Sales Management</font>
        </span>
        <br/>
        <?if($this->session->userdata("role") == 1 || $this->session->userdata("role") == 3):?>
        <button class="btn btn-success" onclick="add_sales()"><i class="glyphicon glyphicon-plus"></i> Add Sales</button>
        <button class="btn btn-success" onclick="upload_sales()"><i class="glyphicon glyphicon-plus"></i> Upload Sales</button>
        <?endif;?>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>SP</th>
                    <th>Cust. No.</th>
                    <th>Site</th>
                    <th>Product</th>
                    <th>Currency</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th style="width:30px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>SP</th>
                    <th>Cust. No.</th>
                    <th>Site</th>
                    <th>Product</th>
                    <th>Currency</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
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
            "url": "<?php echo site_url('index.php/Sales/ajax_list')?>",
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
    
    
  
  $('#cust').change(function(){ //any select change on the dropdown with id country trigger this code
                $("#site > option").remove();
                var cust_id = $('#cust').val();
                var post_url = _base_url + 'index.php/Cust_site/getCustSiteList/' + cust_id;
                    $.ajax({
                        type: "POST",
                        url: post_url,
                        success: function(site) //we're calling the response json array 'cities'
                        {
                            $('#site').empty();
                            var data = eval('(' + site + ')')
                            $.each(data,function(site_id,note)
                            {
                                var opt = $('<option />'); // here we're creating a new select option for each group
                                opt.val(site_id);
                                opt.text(note);
                                $('#site').append(opt);
                            });
                        } //end success
                    });
                });  
   
  $('#site').change(function(){ //any select change on the dropdown with id country trigger this code
                $("#price > option").remove();
                var cust_id = $('#cust').val();
                var site_id = $('#site').val();
                var product_no = $('#product').val();
                var post_url = _base_url + 'index.php/Agreement/getAgreementListForSale/' + cust_id + '/' + site_id + '/' + product_no.replace('/', 'slash');
                    $.ajax({
                        type: "POST",
                        url: post_url,
                        success: function(agreement) //we're calling the response json array 'cities'
                        {
                            $('#price').empty();
                            var data = eval('(' + agreement + ')')
                            $.each(data,function(agreement_id,price)
                            {
                                var opt = $('<option />'); // here we're creating a new select option for each group
                                opt.val(agreement_id);
                                opt.text(price);
                                $('#price').append(opt);
                            });
                        } //end success
                    });
                }); 
                
                
  $('#product').change(function(){ //any select change on the dropdown with id country trigger this code
                $("#price > option").remove();
                var cust_id = $('#cust').val();
                var site_id = $('#site').val();
                var product_no = $('#product').val();
                var post_url = _base_url + 'index.php/Agreement/getAgreementListForSale/' + cust_id + '/' + site_id + '/' + product_no.replace('/', 'slash');
                    $.ajax({
                        type: "POST",
                        url: post_url,
                        success: function(agreement) //we're calling the response json array 'cities'
                        {
                            $('#price').empty();
                            var data = eval('(' + agreement + ')')
                            $.each(data,function(agreement_id,price)
                            {
                                var opt = $('<option />'); // here we're creating a new select option for each group
                                opt.val(agreement_id);
                                opt.text(price);
                                $('#price').append(opt);
                            });
                        } //end success
                    });
                }); 

});



function add_sales()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    
    $('[name="salesId"]').attr("readOnly", false);
    
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Sales'); // Set Title to Bootstrap modal title
}

function upload_sales()
{
    window.location = _base_url + 'index.php/Sales/new_upload_sales/';
}


function view_price(id){
    window.location = _base_url + 'index.php/Sales_price/lists/' + id.replace('/', 'slash');
}

function edit_sales(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
//    $('#modal_form').modal('show'); // show bootstrap modal
//    $('.modal-title').text('Edit Sales'); // Set Title to Bootstrap modal title

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('index.php/Sales/ajax_edit/')?>/" + id.replace('/', 'slash'),
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            var cust_id = data.cust_no;
            var site_id = data.site_id;
            var product_no = data.product_no;
            $("#site > option").remove();
                var post_url = _base_url + 'index.php/Cust_site/getCustSiteList/' + cust_id;
                    $.ajax({
                        type: "POST",
                        url: post_url,
                        success: function(site) //we're calling the response json array 'cities'
                        {
                            $('#site').empty();
                            var data_list = eval('(' + site + ')')
                            var i = 0;
                            var selection = null;
                            $.each(data_list,function(site_id,note)
                            {
                                var opt = $('<option />'); // here we're creating a new select option for each group
                                opt.val(site_id);
                                opt.text(note);
                                $('#site').append(opt);
                                
                                if(data.site_id == site_id){
                                    selection = i;
                                }
                                
                                i++;
                            });
                            document.getElementById('site').options[selection].selected = true;
                        } //end success
                    });
                    
            $("#price > option").remove();
                var post_url = _base_url + 'index.php/Agreement/getAgreementListForSale/' + cust_id + '/' + site_id + '/' + product_no.replace('/', 'slash');
                    $.ajax({
                        type: "POST",
                        url: post_url,
                        success: function(agreement) //we're calling the response json array 'cities'
                        {
                            $('#price').empty();
                            var data_list = eval('(' + agreement + ')')
                            var i = 0;
                            var selection = null;
                            $.each(data_list,function(agreement_id,price)
                            {
                                var opt = $('<option />'); // here we're creating a new select option for each group
                                opt.val(agreement_id);
                                opt.text(price);
                                $('#price').append(opt);
                                
                                if(data.agreement_id == agreement_id){
                                    selection = i;
                                }
                                
                                i++;
                            });
                            document.getElementById('price').options[selection].selected = true;
                        } //end success
                    });

            $('[name="salesId"]').val(data.sale_id);
            $('[name="date"]').val(data.date);
            $('[name="sp"]').val(data.sp_id);
            $('[name="cust"]').val(data.cust_no);
            $('[name="site"]').val(data.site_id);
            $('[name="product"]').val(data.product_no);
            $('[name="price"]').val(data.agreement_id);
            $('[name="quantity"]').val(data.quantity);
//            $('[name="price"]').val(data.total);
            
            $('[name="salesId"]').attr("readOnly", true);
            
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Sales'); // Set title to Bootstrap modal title

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
        url = "<?php echo site_url('index.php/Sales/ajax_add')?>";
    } else {
        url = "<?php echo site_url('index.php/Sales/ajax_update')?>";
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
            }else{
                serr = 'Fail to save data.';
                try {
                  serr = serr + ' ' + data.error;
                } catch(e) {}
                
                alert(serr);
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

function delete_sales(id, sales)
{
    if(confirm('Are you sure delete this sales: ' + sales + ' ?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('index.php/Sales/ajax_delete')?>/"+ id.replace('/', 'slash'),
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
                <h3 class="modal-title">Sales Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <input name="salesId" placeholder="Sales ID" class="form-control" type="hidden" readonly="true">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Date</label>
                            <div class="col-md-9">
                                <input name="date" placeholder="yyyy-mm-dd" class="form-control datepicker" data-date-format="mm-dd-yyyy" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Sales Person</label>
                            <div class="col-md-9">
                                <?php echo form_dropdown('sp', $sp_list, '', 'id="sp" name="sp" placeholder="Sales Person" class="form-control" type="text"'); ?>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Customer</label>
                            <div class="col-md-9">
                                <?php echo form_dropdown('cust', $cust_list, '', 'id="cust" name="cust" placeholder="Customer" class="form-control" type="text"'); ?>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Site</label>
                            <div class="col-md-9">
                                <?php echo form_dropdown('site', $site_list, '', 'id="site" name="site" placeholder="Site" class="form-control" type="text"'); ?>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Product</label>
                            <div class="col-md-9">
                                <?php echo form_dropdown('product', $product_list, '', 'id="product" name="product" placeholder="Product" class="form-control" type="text"'); ?>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Price</label>
                            <div class="col-md-9">
                                <?php echo form_dropdown('price', $price_list, '', 'id="price" name="price" placeholder="Price" class="form-control" type="text"'); ?>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Quantity</label>
                            <div class="col-md-9">
                                <input name="quantity" placeholder="Quantity" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
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
