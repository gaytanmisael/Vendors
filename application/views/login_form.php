<!doctype html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Login Form</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon(s) in the root directory -->
        <link rel="shourtcut icon" type="image/png" href="<?php echo base_url(); ?>favicon.png" />
        
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
        <div id="wrapper">
            <div id="infoMessage"><?php echo $message;?></div>
            <div id="login_form" class="section group">
                <h1>Area de Dise&ntilde;adores</h1>
                    
                <?php 
                    echo form_open('login/validate_credentials'); 

                     // Gave Input Class - ID - So that i can control with jQuery
                    $username_input = array('class' => 'username form-control', 'id' => 'property_type', 'name' => 'username', 'placeholder' => 'Username');
                    echo form_input($username_input);


                    // Gave Input Class - ID = so that it can be controled by jQuery
                    $password_input = array('type' => 'password form-control', 'id' => 'property_type', 'class' => 'password', 'name' => 'password', 'placeholder' => 'Password');
                    echo form_password($password_input);

                    //Create Account btn
                    echo form_label('Remember','remember');
                    echo form_checkbox('remember', '1', FALSE, 'id="remember"') . '<br/></br>';

                    echo '<span id="blue">blue</span><span id="flare">Flare</span><span id="dust">dust</span><span id="shadow">shadow</span><span id="smoke">Smoke</span> </br>';
                    // Submit BTN
                    echo form_submit('submit', 'Ingresar');
                ?>
            </div>
        </div>
    </body>
</html>