<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AACC</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?= base_url('assets/js/select2/css/select2.min.css');?>">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css');?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/font-awesome/css/font-awesome.min.css');?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/css/AdminLTE.min.css');?>">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="<?= base_url('assets/css/skins/skin-blue.min.css');?>">
  <link href="<?= base_url('assets/css/bootstrap-timepicker.min.css');?>" rel="stylesheet">
  <link href="<?= base_url('assets/css/custom.css');?>" rel="stylesheet">
 </head>
<body class="hold-transition skin-blue fixed">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <?php $link = ($this->session->userdata('nivel')=='admin')?base_url('admin/dashboard'):base_url('aluno/dashboard');?>
    <a href="<?=$link;?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>AACC</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>AACC</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <?php
                $id_usuario = $this->session->userdata('id_usuario');
                $link = ($this->session->userdata('nivel')=='admin')?base_url('admin/administrador/editar/'.$id_usuario):base_url('aluno/editar/'.$id_usuario)
            ;?>
            <li><a href="<?=$link;?>">Olá! <?=$this->session->userdata('nome_usuario');?></a></li>
            <li><a href="<?=base_url('logout');?>"><i class="fa fa-sign-out"></i> Sair</a></li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->
