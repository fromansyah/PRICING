<html>
    <head>
        <title>FIX ASSET</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>

    </head>
    <body>
        <h2 style="margin-top:0px">Bukutelepon List</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('bukutelepon/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <form action="<?php echo site_url('bukutelepon/search'); ?>" class="form-inline" method="post">
                    <input name="keyword" class="form-control" value="<?php echo $keyword; ?>" />
                    <?php 
                    if ($keyword <> '')
                    {
                        ?>
                        <a href="<?php echo site_url('bukutelepon'); ?>" class="btn btn-default">Reset</a>
                        <?php
                    }
                    ?>
                    <input type="submit" value="Search" class="btn btn-primary" />
                </form>
            </div>
        </div>
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>nama</th>
		<th>alamat</th>
		<th>notelepon</th>
		<th>Action</th>
            </tr><?php
            foreach ($bukutelepon_data as $bukutelepon)
            {
                ?>
                <tr>
			<td><?php echo ++$start ?></td>
			<td><?php echo $bukutelepon->nama ?></td>
			<td><?php echo $bukutelepon->alamat ?></td>
			<td><?php echo $bukutelepon->notelepon ?></td>
			<td style="text-align:center">
				<?php 
				echo anchor(site_url('bukutelepon/read/'.$bukutelepon->id),'Read'); 
				echo ' | '; 
				echo anchor(site_url('bukutelepon/update/'.$bukutelepon->id),'Update'); 
				echo ' | '; 
				echo anchor(site_url('bukutelepon/delete/'.$bukutelepon->id),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    </body>
</html>