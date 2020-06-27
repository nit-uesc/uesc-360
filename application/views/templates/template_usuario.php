<!DOCTYPE html>
<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<!--[if IE 9]><html class="lt-ie10" lang="pt-br" > <![endif]-->
<html class="no-js" lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>UESC 360º</title>

  <link rel="shortcut icon" href="<?php echo base_url('assets/img/icone.ico'); ?>">

  <link rel="stylesheet" href="<?php echo base_url('assets/css/normalize.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/foundation.css'); ?>">

  <!-- <link rel="stylesheet" href="<?php echo base_url('assets/css/jquery-ui.min.css'); ?>"> -->

  <link rel="stylesheet" href="<?php echo base_url('assets/css/tipografia.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/estilo.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/background.css'); ?>">

  <!-- <link rel="stylesheet" href="<?php echo base_url('assets/css/layout-home.css'); ?>"> -->
  <!-- <link rel="stylesheet" href="<?php echo base_url('assets/css/layout-contato.css'); ?>"> -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/layout-quemsomos.css'); ?>">
  <!-- <link rel="stylesheet" href="<?php echo base_url('assets/css/layout-explore.css'); ?>"> -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/layout-search-pessoa.css'); ?>">
  <!-- <link rel="stylesheet" href="<?php echo base_url('assets/css/layout-search-laboratorio.css'); ?>"> -->
  <!-- <link rel="stylesheet" href="<?php echo base_url('assets/css/layout-search-equipamento.css'); ?>"> -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/layout-cadastro.css'); ?>">
  <!-- <link rel="stylesheet" href="<?php echo base_url('assets/css/layout-login.css'); ?>"> -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/app.css'); ?>">

  <!-- Script para adicionar campos dinamicamente -->
  <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
  <!-- // <script src="<?php echo base_url('assets/js/functions.js'); ?>"></script> -->

  <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.maskedinput.js');?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/masks.js');?>"></script>

  <script src="<?php echo base_url('assets/js/vendor/modernizr.js'); ?>"></script>
  <!-- // <script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script> -->
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-60713364-1', 'auto');
    ga('send', 'pageview');
  </script>

</head>
<body>
  <div class="layout">


<!-- menu -->
<?php $this->load->view('includes/menu2'); ?>

<div class="conteudo">
  <br>
  <div class="row">
    <div class="large-2 columns">
      <!-- sidebar menu -->
      <?php
        if($this->session->userdata('permissao_usu')==3):
          $this->load->view('usuario/menuLateral');
        elseif($this->session->userdata('permissao_usu')==2):
          $this->load->view('coordenador/menuLateral');
        elseif($this->session->userdata('permissao_usu')==1):
          $this->load->view('includes/menuLateral');
        endif;
      ?>
    </div>
    <div class="large-10 columns">
      <!-- main content -->
      <?php if ($main!='') $this->load->view($main); ?>
    </div>
  </div>
</div>
<!-- footer -->
<?php $this->load->view('includes/footer'); ?>
