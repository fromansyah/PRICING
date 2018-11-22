<link href="<?= base_url() ?>css/adminTemplate.css" rel="stylesheet" type="text/css" />

<link href="<?= base_url() ?>css/backoff_ssek.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url() ?>js/utility.js" type="text/javascript"></script>


<link href="<?= base_url() ?>css/datePicker.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url() ?>js/jquery.datePicker.js" type="text/javascript"></script>

<link href="<?= base_url() ?>css/tabbed_new.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url() ?>js/jquery-1.8.0.min.js" type="text/javascript"></script>

<link href="<?=$this->config->item('base_url');?>css/style.css" rel="stylesheet" type="text/css" />
<head>
<link rel="icon" type="image/gif" href="<?= base_url() ?>images/logo_application.gif" />
<title>
    <?
    $title_ = "";
    if (isset($title)) {
        $title_ = " - " . $title;
    }
    if ($this->config->item('nama_aplikasi')):
        echo $this->config->item('nama_aplikasi').$title_;
    endif;
    ?>
</title>
</head>
<body>
<div id="WholePage">
  <div id="Inner">
    <div id="Container">
      <div id="Head">
        <div id="Head_left">
          <div id="Leaf_top"></div>
          <!--<div id="Leaf_bottom"> <a class="registration" href="http://all-free-download.com/free-website-templates/">REGISTRATION</a> <a class="log-in" href="http://all-free-download.com/free-website-templates/">LOG IN</a> </div>-->
        </div>
        <div id="Head_right">
          <div id="Logo">
            <div id="Name"><span class="blue">S</span><span>oewito</span>&nbsp;<span class="blue">S</span><span>uhardiman</span>&nbsp;<span class="blue">E</span><span>ddymurthy</span>&nbsp;<span class="blue">K</span><span>ardono</span> </div>
            <div id="Informations">Good afternoon | It's Friday | Time: 12:51 </div>
          </div>
          <div id="Top_menu"> <a class="kart" href="http://all-free-download.com/free-website-templates/"><span>KART</span></a> <a class="orders" href="http://all-free-download.com/free-website-templates/"><span>ORDERS</span></a> <a class="contact" href="http://all-free-download.com/free-website-templates/"><span>CONTACT</span></a> <a class="help" href="http://all-free-download.com/free-website-templates/"><span>HELP</span></a> <a class="home" href="http://all-free-download.com/free-website-templates/"><span>HOME</span></a> </div>
        </div>
      </div>
        
        <div id="content">
        <?= $content ?>
        </div>
    </div>
  </div>
</div>

</html>