<!doctype html>
<html lang="en" class="menu_branded theme-sky font-poppins" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">

	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon/favicon.ico">

    <!--data tables-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom_datatables_styles.css">

    <script src='<?= base_url() ?>assets/angular-1.8.2/angular.min.js'></script>

    <script src="<?php echo  base_url() ?>assets/js/sweetalert.min.js"></script>

    <title>Hour By Hour | Andon</title>
</head>

<body>
    <!-- Top Bar -->
    <header class="top-bar">
        <!-- Menu Toggler -->
        <button type="button" class="menu-toggler la la-bars" data-toggle="menu"></button>
        <!-- Brand -->
        <span class="brand">
            <img width="150" src="<?php echo base_url(); ?>assets/images/transparente.png" alt="">
        </span>
        <!-- Right -->
        <div class="flex items-center ltr:ml-auto rtl:mr-auto">
            <!-- Notifications -->
            <div class="dropdown self-stretch">
                <button type="button" class="relative flex items-center h-full btn-link ltr:ml-1 rtl:mr-1 px-2 text-2xl leading-none la la-bell" data-toggle="custom-dropdown-menu" data-tippy-arrow="true" data-tippy-placement="bottom-end">
                    <span class="absolute top-0 right-0 rounded-full border border-primary -mt-1 -mr-1 px-2 leading-tight text-xs font-body text-primary">3</span>
                </button>
                <div class="custom-dropdown-menu">
                    <div class="flex items-center px-5 py-2">
                        <h5 class="mb-0 uppercase">Notifications</h5>
                        <button class="btn btn_outlined btn_warning uppercase ltr:ml-auto rtl:mr-auto">Clear All</button>
                    </div>
                    <hr>
                    <div class="p-5 hover:bg-primary hover:bg-opacity-5">
                        <a href="#">
                            <h6 class="uppercase">Heading One</h6>
                        </a>
                        <p>Lorem ipsum dolor, sit amet consectetur.</p>
                        <small>Today</small>
                    </div>
                    <hr>
                    <div class="p-5 hover:bg-primary hover:bg-opacity-5">
                        <a href="#">
                            <h6 class="uppercase">Heading Two</h6>
                        </a>
                        <p>Mollitia sequi dolor architecto aut deserunt.</p>
                        <small>Yesterday</small>
                    </div>
                    <hr>
                    <div class="p-5 hover:bg-primary hover:bg-opacity-5">
                        <a href="#">
                            <h6 class="uppercase">Heading Three</h6>
                        </a>
                        <p>Nobis reprehenderit sed quos deserunt</p>
                        <small>Last Week</small>
                    </div>
                </div>
            </div>

            <!-- User Menu -->
            <div class="dropdown">
                <button class="flex items-center ltr:ml-4 rtl:mr-4" data-toggle="custom-dropdown-menu" data-tippy-arrow="true" data-tippy-placement="bottom-end">
                    <span class="avatar">JD</span>
                </button>
                <div class="custom-dropdown-menu w-64">
                    <div class="p-5">
                        <h5 class="uppercase">John Doe</h5>
                        <p>Editor</p>
                    </div>
                    <hr>
                    <div class="p-5">
                        <a href="#" class="flex items-center text-normal hover:text-primary">
                            <span class="la la-user-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                            View Profile
                        </a>
                        <a href="#" class="flex items-center text-normal hover:text-primary mt-5">
                            <span class="la la-key text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                            Change Password
                        </a>
                    </div>
                    <hr>
                    <div class="p-5">
                        <a href="#" class="flex items-center text-normal hover:text-primary">
                            <span class="la la-power-off text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Menu Bar -->
    <aside class="menu-bar menu_branded">
        <div class="menu-items">
            <div class="menu-header hidden">
                <a href="#" class="flex items-center mx-8 mt-8">
                    <span class="avatar w-16 h-16">JD</span>
                    <div class="ltr:ml-4 rtl:mr-4 ltr:text-left rtl:text-right">
                        <h5>John Doe</h5>
                        <p class="mt-2">Editor</p>
                    </div>
                </a>
                <hr class="mx-8 my-4">
            </div>
            <a href="<?php echo base_url() ?>" class="link" data-toggle="tooltip-menu" data-tippy-content="Dashboard">
                <span class="icon las la-tachometer-alt"></span>
                <span class="title">Dashboard</span>
            </a>
            <a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">
                <span class="icon las la-traffic-light"></span>
                <span class="title">Andon</span>
            </a>
            <a href="#no-link" class="link" data-target="[data-menu=pages]" data-toggle="tooltip-menu" data-tippy-content="Pages">
                <span class="icon las la-hourglass-half"></span>
                <span class="title">Hour by Hour</span>
            </a>
        </div>
        <!-- UI -->
        <div class="menu-detail" data-menu="ui">
            <div class="menu-detail-wrapper">
                <a href="<?php echo base_url(); ?>index.php/andon_dashboard">
                    <span class="icon las la-tachometer-alt"></span>
                    Dashboard
                </a>
                <a href="<?php echo base_url(); ?>index.php/plants">
                    <span class="las la-warehouse"></span>
                    Plants
                </a>
                <a href="<?php echo base_url(); ?>index.php/sites">
                    <span class="las la-sitemap"></span>
                    Sites
                </a>
                <a href="<?php echo base_url(); ?>index.php/machines">
                    <span class="las la-cogs"></span>
                    Assets
                </a>
            </div>
        </div>

        <!-- Pages -->
        <div class="menu-detail" data-menu="pages">
            <div class="menu-detail-wrapper">
                <a href="<?php echo base_url(); ?>index.php/">
                    <span class="icon las la-tachometer-alt"></span>
                    Dashboard
                </a>
                <a href="#no-link" class="active" data-toggle="collapse" data-target="#plant_admon">
                    <span class="collapse-indicator la la-arrow-circle-down"></span>
                    Manage By Plant
                </a>
                <div id="plant_admon" class="collapse">

                    <?php
                        $CI =& get_instance();
                        $CI->load->model('plant');
                        $plants = $CI->plant->getAllActive();

                        foreach($plants as $plant)
                        {
                            echo '<a class="active" data-toggle="collapse" data-target="#plant_' . $plant['plant_id'] . '">';
                            echo '<span class="collapse-indicator la la-arrow-circle-down"></span>';
                            echo $plant['plant_name'];
                            echo '</a>';

                            echo '<div id="plant_' . $plant['plant_id'] . '" class="collapse">';
                            echo '<a href="' . base_url() . 'index.php/cell?plant_id=' . $plant['plant_id'] .'">';
                            echo '    Load Plan';
                            echo '</a>';
                            echo '<a href="' . base_url() . 'index.php/manual_capture?plant_id=' . $plant['plant_id'] . '">';
                            echo '    Manual Capture';
                            echo '</a>';
                            echo '<a href="' . base_url() . 'index.php/measuring_point">';
                            echo '    Measuring Point';
                            echo '</a>';
                            echo '</div>';
                        }
                    ?>

                </div>
                <a href="#no-link" class="active" data-toggle="collapse" data-target="#production">
                    <span class="collapse-indicator la la-arrow-circle-down"></span>
                    Production Plan
                </a>
                <div id="production" class="collapse">
                    <a href="<?php echo base_url(); ?>index.php/planners">
                        Load Plan
                    </a>
                </div>
                <a href="#no-link" class="active" data-toggle="collapse" data-target="#reports">
                    <span class="collapse-indicator la la-arrow-circle-down"></span>
                    Reports
                </a>
                <div id="reports" class="collapse">
                    <a href="<?php echo base_url(); ?>index.php/daily_report">
                        Daily Report
                    </a>
                    <a href="<?php echo base_url(); ?>index.php/custom_report">
                        Custom Report
                    </a>
                </div>
            </div>
        </div>
    </aside>

    <!-- Customizer -->

    <main class="workspace">
