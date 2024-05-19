<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!--<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
		text-decoration: none;
	}

	a:hover {
		color: #97310e;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
		min-height: 96px;
	}

	p {
		margin: 0 0 10px;
		padding:0;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Welcome to CodeIgniter!</h1>

	<div id="body">
		<p>The page you are looking at is being generated dynamically by CodeIgniter.</p>

		<p>If you would like to edit this page you'll find it located at:</p>
		<code>application/views/welcome_message.php</code>

		<p>The corresponding controller for this page is found at:</p>
		<code>application/controllers/Welcome.php</code>

		<p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="userguide3/">User Guide</a>.</p>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to the Q&A Website</title>
    <!--<link rel="stylesheet" href="<?php echo base_url('application/assests/css/welcome.css'); ?>">-->

	
	<style>

		/* Basic Reset 
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			font-family: Arial, sans-serif;
			background-color: #f4f4f4;
			color: #333;
			line-height: 1.6;
			padding: 20px;
		}*/

		/* Container */
		body{
            background-color: #E6E6FA;

        }
		/*.container {
			max-width: 1200px;
			margin: 0 auto;
			padding: 20px;
			background: #fff;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
			border-radius: 8px;
			text-align: center;
			display: flex; /* Add flexbox 
			justify-content: center; /* Horizontal alignment 
			align-items: center; /* Vertical alignment 
			
		}*/

		.container {
            width: 80%;
			height: 400px;
            margin: 0 auto;
            background-color: #D8BFD8;
			padding: 20px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
			border-radius: 8px;
			text-align: center;
			justify-content: center;
			
			
        }

		 /*Headings*/
		h1 {
			margin-bottom: 20px;
			font-size: 45px;
			color: #8B4513;
		}

		p {
			margin: 10px 0;
			font-size: 18px;
			font-weight: bold;
		}

		h3 {
			margin: 10px 0;
			font-size: 20px;
		}

		
		a {
			color: #007bff;
			text-decoration: none;
			margin: 0 10px;
		}

		a:hover {
			text-decoration: underline;
		}

		
		button {
			background-color: #007bff;
			color: #fff;
			border: none;
			padding: 10px 20px;
			border-radius: 5px;
			cursor: pointer;
			font-size: 1em;
		}

		button:hover {
			background-color: #0056b3;
		}

		.footer {
			margin-top: 20px;
			font-size: 0.9em;
			color: #666;
		} 
	</style>

</head>
<?php $this->load->view('navbar'); ?>

<body>
	<br>
    <div class="container">
        <h1>Welcome to the Q&A Website</h1>
		<br>
        <h3>This is the home page of our technical question and answer platform.</h3>
		<br>
        <p><a href="<?php echo site_url('signup'); ?>">Sign Up</a> | <a href="<?php echo site_url('login'); ?>">Log In</a></p>
		<br>
        <p><a href="<?php echo site_url('questions'); ?>">View Questions</a></p>
    </div>

</body>


</html>

