<!doctype html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- You can Switch them to the CDN to load faster -->
        
        <!-- HTML5 Reset -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/html5reset.css" media="all">
        
        <!-- col, 3cols, 2cols, Responsive CSS Files -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/col.css" media="all">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/3cols.css" media="all">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/2cols.css" media="all">
        
        <!-- Main = Style.css -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/main.css">

        <!-- jQuery CSS Files -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery.fancybox.css">
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />

        
        <!-- Modernizr CSS3 and HTML 5 for all browsers -->
        <script type="text/javascript" src="<?php echo base_url(); ?>js/modernizr-2.5.3-min.js"></script>
        
        <!-- jQuery w/Fancybox & Autocomplete -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>js/jquery.fancybox.pack.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
        
    </head>
    <body>
        
        <?php
    $usr = $this->ion_auth->user()->row();
    
?>
        <div id="wrapper">
            <div id="headcontainer">
                <div class="section group">
                    <header>
                        <div id="left" class="col span_1_of_3">
                            <a href="<?php echo base_url();?>dashboard" class="logo">
                                <img src="<?php echo base_url(); ?>css/logo.png" title="Nuestra Gente" alt="Nuestra Gente"/>
                            </a>
                        </div>

                        <div id="middle" class="col span_1_of_3">
                            <h1 class="main-user"><?php echo $usr->first_name . ' ' . $usr->last_name; ?></h1>
                        </div>

                        <div id="right" class="col span_1_of_3">                            
                            <?php echo anchor('login/logout', 'Sign Out'); ?>
                            
                            <?php 

                                $usr = $this->ion_auth->user()->row()->id;
                                echo $usr;

                                if ($usr === '51') {
                                    echo anchor('report/', 'Report'); 
                                } else {
    
                                }
                            ?>
                            
                        </div>
                    </header>
                </div>
            </div>