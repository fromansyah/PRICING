<script type="text/javascript" src="<?= base_url() ?>js/datetimepicker_css.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.csv-0.71.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-csv/0.71/jquery.csv-0.71.min.js"></script>
<!DOCTYPE html>
<head>
<script type="text/javascript">  
$_base_url = '<?= base_url() ?>';

$(document).ready(function() {

    // The event listener for the file upload
    document.getElementById('txtFileUpload').addEventListener('change', upload, false);

    // Method that checks that the browser supports the HTML5 File API
    function browserSupportFileUpload() {
        var isCompatible = false;
        if (window.File && window.FileReader && window.FileList && window.Blob) {
        isCompatible = true;
        }
        return isCompatible;
    }

    // Method that reads and processes the selected file
    function upload(evt) {
        if (!browserSupportFileUpload()) {
            alert('The File APIs are not fully supported in this browser!');
            } else {
                var data = null;
                var file = evt.target.files[0];
                var reader = new FileReader();
                if(confirm('Are you sure want to upload this file? '+file.name)){
                    reader.readAsText(file);
                    reader.read
                    reader.onload = function(event) {
                        var csvData = event.target.result;
                        data = $.csv.toArrays(csvData);
                        $.post(
                                $_base_url + 'index.php/Product/ajax_upload',
                                {
                                    data: data
                                },
                                function(data) {
                                    alert(data.text);
                                },
                                'json'
                            );
                    };
                    reader.onerror = function() {
                        alert('Unable to read ' + file.fileName);
                    };
                }
            }   
        }

    $('#btn_cancel').click(function(){
        window.location = $_base_url + 'index.php/Product/';
    });

    $('#download_template').click(function(){
        window.location = $_base_url + 'index.php/Product/download_template';
    });

    $('#show_log_file').click(function(){
        window.location = $_base_url + 'index.php/Product/log_file';
    });
});
</script>
    </head>
    <body>
<!--    <div id="dvImportSegments" class="fileupload ">
        <fieldset>
            <legend>Upload your CSV File</legend>
            <input type="file" name="File Upload" id="txtFileUpload" accept=".csv" />
        </fieldset>
    </div>-->
    </body>
</html>


<br/><br/><br/><br/>
<div align="center">
<fieldset style="position: relative; width: 500px; height: 400px;">
    <legend>Upload Product</legend>
    <br/>
    <br/>
    <table>
        <tr>
            <td>
                <input type="button" value="Download Template" id="download_template"  class="btn btn-primary"/>&nbsp;&nbsp;&nbsp;
            </td>
            <td>
                <input type="button" value="Log File" id="show_log_file"  class="btn btn-primary"/>
            </td>
        </tr>
    </table>

    <br/>
    <br/>
    <p>
    Product CSV File : <input type="file" name="txtFileUpload" id="txtFileUpload" size="20" class="input_text" accept=".csv"/>
    </p>
    <br/>
    <p>
        <input type="button" value="Cancel" id="btn_cancel" class="button_cancel"/>
    </p>
</fieldset>
</div>


<!--<script type="text/javascript">  
    $_base_url = '<?= base_url() ?>';
    $(document).ready(function() {

    // The event listener for the file upload
    document.getElementById('txtFileUpload').addEventListener('change', upload, false);

    // Method that checks that the browser supports the HTML5 File API
    function browserSupportFileUpload() {
        var isCompatible = false;
        if (window.File && window.FileReader && window.FileList && window.Blob) {
        isCompatible = true;
        }
        return isCompatible;
    }

    // Method that reads and processes the selected file
    function upload(evt) {
        if (!browserSupportFileUpload()) {
            alert('The File APIs are not fully supported in this browser!');
            } else {
                var data = null;
                var file = evt.target.files[0];
                var reader = new FileReader();
                reader.readAsText(file);
                reader.read
                reader.onload = function(event) {
                    var csvData = event.target.result;
                    data = $.csv.toArrays(csvData);
                    var i;
                    var text_alert = '';
                    var success = 0;
                    var failed = 0;
                    $.post(
                            $_base_url + 'Product/ajax_upload',
                            {
                                data: data
                            },
                            function(data) {
//                                if (data.result == 'FALSE') {
//                                    failed++;
//                                } else {
//                                    success++;
//                                }
                                alert(data.text);
                            },
                            'json'
                        );
//                    for(i=1; i<data.length; i++){
//                        $.post(
//                            $_base_url + 'Product/ajax_upload',
//                            {
//                                productNo: data[i][0],
//                                productName: data[i][1],
//                                desc: data[i][2],
//                                row: i
//                            },
//                            function(data) {
//                                if (data.result == 'FALSE') {
//                                    failed++;
//                                } else {
//                                    success++;
//                                }
////                                text_alert = text_alert + data.text;
//                            },
//                            'json'
//                        );
//                        text_alert = success + ' row(s) has been uploaded.\n' + failed + ' row(s) fail to upload.\n' + 'See Log file for detail.';
//                    }
                    
                };
                reader.onerror = function() {
                    alert('Unable to read ' + file.fileName);
                };
            }
        }
    });
</script>-->
