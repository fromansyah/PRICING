<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Bukutelepon Read</h2>
        <table class="table">
	    <tr><td>nama</td><td><?php echo $nama; ?></td></tr>
	    <tr><td>alamat</td><td><?php echo $alamat; ?></td></tr>
	    <tr><td>notelepon</td><td><?php echo $notelepon; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('bukutelepon') ?>" class="btn btn-default">Cancel</button></td></tr>
	</table>
    </body>
</html>