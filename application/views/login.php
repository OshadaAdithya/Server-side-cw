<style>
    /*body {
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
		.container {
			max-width: 1200px;
			margin: 0 auto;
			padding: 20px;
			background: #B0E0E6;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
			border-radius: 8px;
			text-align: center;
			
		}

		/* Headings */
		h2 {
			margin-bottom: 20px;
			font-size: 2.5em;
			color: #007bff;
		}

		p {
			margin: 10px 0;
			font-size: 1.1em;
		}

		/* Links */
		a {
			color: #007bff;
			text-decoration: none;
			margin: 0 10px;
		}

		a:hover {
			text-decoration: underline;
		}

		/* Button Styles */
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

		.form-group {
            margin-bottom: 15px;
            text-align: center;
        }

		input[type="email"],
        input[type="password"] {
            width: 50%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }

		label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 1.2em; /* Increase the font size of the labels */

        }

</style>
<br>
<div class="container">
    <h2>Login</h2>
    <?php if($this->session->flashdata('loginMessage')): ?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('loginMessage'); ?></div>
    <?php endif; ?>
    <?php echo validation_errors(); ?>
    <?php echo form_open('user/userLogin'); ?>
	<input type="hidden" name="redirect_url" value="<?php echo $redirect_url; ?>">
	<form>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>
    <p>Don't have an account? <a href="<?php echo site_url('signup'); ?>">Sign Up</a></p>
</div>


