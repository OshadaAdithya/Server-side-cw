<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <!--<link rel="stylesheet" href="<?php echo base_url('assets/css/styles.css'); ?>">-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>

    <style>

        /* Navbar styles */
.navbar {
    background-color: #2F4F4F;
    color: #fff;
    padding: 10px 0;
}

.navbar .container1 {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.navbar-brand {
    font-size: 1.5em;
    color: #fff;
    text-decoration: none;
}

.navbar-nav {
    list-style: none;
    display: flex;
    margin: 0;
    padding: 0;
}

.navbar-nav li {
    margin-left: 20px;
}

.navbar-nav a {
    color: #fff;
    text-decoration: none;
    padding: 10px 15px;
    border-radius: 5px;
}

.navbar-nav a:hover {
    background-color: #575757;
}

    </style>
</head>
<body>
        <nav class="navbar">
            <div class="container1">
                <a href="<?php echo base_url(); ?>" class="navbar-brand">Home</a>
                <ul class="navbar-nav">
                    <li><a href="<?php echo site_url('questions'); ?>">Questions</a></li>
                    <?php if ($this->session->userdata('user_id')): ?>
                        <li><a href="<?php echo site_url('user/profile'); ?>">Profile</a></li>
                        <li><a href="<?php echo site_url('logout'); ?>">Logout</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo site_url('signup'); ?>">Sign Up</a></li>
                        <li><a href="<?php echo site_url('login'); ?>">Log In</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
</body>
</html>
    
