<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon/favicon.ico">
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
        <!-- Search -->
        <form class="hidden md:block ltr:ml-10 rtl:mr-10" action="#">
            <label class="form-control-addon-within rounded-full">
                <input type="text" class="form-control border-none" placeholder="Search">
                <button type="button" class="btn btn-link text-gray-300 dark:text-gray-700 dark:hover:text-primary text-xl leading-none la la-search ltr:mr-4 rtl:ml-4"></button>
            </label>
        </form>
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
    <aside class="menu-bar menu-sticky">
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
                <span class="icon la la-laptop"></span>
                <span class="title">Dashboard</span>
            </a>
            <a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">
                <span class="icon la la-cube"></span>
                <span class="title">Andon</span>
            </a>
            <a href="#no-link" class="link" data-target="[data-menu=pages]" data-toggle="tooltip-menu" data-tippy-content="Pages">
                <span class="icon la la-file-alt"></span>
                <span class="title">Hour by Hour</span>
            </a>
        </div>
        <!-- UI -->
        <div class="menu-detail" data-menu="ui">
            <div class="menu-detail-wrapper">
            <a href="<?php echo base_url(); ?>index.php/andon_dashboard">
                    <span class="la la-cubes"></span>
                    Dashboard
                </a>
                <a href="<?php echo base_url(); ?>index.php/plants">
                    <span class="la la-stop"></span>
                    Plantas
                </a>
                <a href="<?php echo base_url(); ?>index.php/sites">
                    <span class="la la-th-large"></span>
                    Areas
                </a>
                <a href="<?php echo base_url(); ?>index.php/assets">
                    <span class="la la-check-circle"></span>
                    Maquinas
                </a>
            </div>
        </div>

        <!-- Pages -->
        <div class="menu-detail" data-menu="pages">
            <div class="menu-detail-wrapper">
                <a href="auth-login.html">
                    <span class="la la-user"></span>
                    Dashboard
                </a>
                <a href="#no-link" class="active" data-toggle="collapse" data-target="#plant_admon">
                    <span class="collapse-indicator la la-arrow-circle-down"></span>
                    Administrar por planta
                </a>
                <div id="plant_admon" class="collapse">
                    <a href="#no-link" class="active" data-toggle="collapse" data-target="#moldeo">
                        <span class="collapse-indicator la la-arrow-circle-down"></span>
                        Moldeo
                    </a>
                    <div id="moldeo" class="collapse">
                        <a href="<?php echo base_url(); ?>index.php/planners">
                            <span class="la la-layer-group"></span>
                            Cargar Plan
                        </a>
                        <a href="#no-link">
                            <span class="la la-layer-group"></span>
                            Captura Manual
                        </a>
                        <a href="#no-link">
                            <span class="la la-layer-group"></span>
                            Puntos de medicion
                        </a>
                    </div>
                    <a href="#no-link" class="active" data-toggle="collapse" data-target="#ensamble">
                        <span class="collapse-indicator la la-arrow-circle-down"></span>
                        Ensamble
                    </a>
                    <div id="ensamble" class="collapse">
                        <a href="<?php echo base_url(); ?>index.php/planners">
                            <span class="la la-layer-group"></span>
                            Cargar Plan
                        </a>
                        <a href="#no-link">
                            <span class="la la-layer-group"></span>
                            Captura Manual
                        </a>
                        <a href="#no-link">
                            <span class="la la-layer-group"></span>
                            Puntos de medicion
                        </a>
                    </div>
                    <a href="#no-link" class="active" data-toggle="collapse" data-target="#planta_3">
                        <span class="collapse-indicator la la-arrow-circle-down"></span>
                        Planta 3
                    </a>
                    <div id="planta_3" class="collapse">
                        <a href="<?php echo base_url(); ?>index.php/planners">
                            <span class="la la-layer-group"></span>
                            Cargar Plan
                        </a>
                        <a href="#no-link">
                            <span class="la la-layer-group"></span>
                            Captura Manual
                        </a>
                        <a href="#no-link">
                            <span class="la la-layer-group"></span>
                            Puntos de medicion
                        </a>
                    </div>
                </div>
                <a href="#no-link" class="active" data-toggle="collapse" data-target="#production">
                    <span class="collapse-indicator la la-arrow-circle-down"></span>
                    Plan de produccion
                </a>
                <div id="production" class="collapse">
                    <a href="<?php echo base_url(); ?>index.php/planners">
                        <span class="la la-layer-group"></span>
                        Cargar Plan
                    </a>
                </div>
                <a href="#no-link" class="active" data-toggle="collapse" data-target="#reports">
                    <span class="collapse-indicator la la-arrow-circle-down"></span>
                    Reportes
                </a>
                <div id="reports" class="collapse">
                    <a href="#no-link">
                        <span class="la la-layer-group"></span>
                        Reporte Diario
                    </a>
                    <a href="#no-link">
                        <span class="la la-arrow-circle-right"></span>
                        Reporte Personalizado
                    </a>
                </div>
            </div>
        </div>
    </aside>

    <!-- Customizer -->
    <aside id="customizer" class="sidebar sidebar_customizer">
        <!-- Toggler -->
        <button class="sidebar-toggler" data-toggle="customizer"><span class="la la-gear animate-spin-slow"></span></button>

        <!-- Theme Customizer -->
        <div class="flex items-center justify-between h-20 p-4">
            <div>
                <h2>Theme Customizer</h2>
                <p>Customize & Preview</p>
            </div>
            <button type="button" class="close text-2xl leading-none hover:text-primary la la-times" data-toggle="customizer"></button>
        </div>
        <hr>
        <div class="overflow-y-auto">
            <div class="flex items-center justify-between p-4">
                <h5>Dark Mode</h5>
                <label class="switch switch_outlined">
                    <input data-toggle="dark-mode" type="checkbox">
                    <span></span>
                </label>
            </div>
            <hr>
            <div class="flex items-center justify-between p-4">
                <h5>RTL</h5>
                <label class="switch switch_outlined">
                    <input data-toggle="rtl" type="checkbox">
                    <span></span>
                </label>
            </div>
            <hr>
            <div class="flex items-center justify-between p-4">
                <div>
                    <h5>Branded Menu</h5>
                    <small>Menu will be set to primary color</small>
                </div>
                <label class="switch switch_outlined">
                    <input data-toggle="branded-menu" type="checkbox">
                    <span></span>
                </label>
            </div>
            <hr>
            <div class="p-4">
                <h5>Menu Type</h5>
                <div class="flex flex-col space-y-2 mt-5">
                    <label class="custom-radio">
                        <input type="radio" name="menuType" checked data-toggle="menu-type" data-value="default">
                        <span></span>
                        <span>Default</span>
                    </label>
                    <label class="custom-radio">
                        <input type="radio" name="menuType" data-toggle="menu-type" data-value="hidden">
                        <span></span>
                        <span>Hidden</span>
                    </label>
                    <label class="custom-radio">
                        <input type="radio" name="menuType" data-toggle="menu-type" data-value="icon-only">
                        <span></span>
                        <span>Icon Only</span>
                    </label>
                    <label class="custom-radio">
                        <input type="radio" name="menuType" data-toggle="menu-type" data-value="wide">
                        <span></span>
                        <span>Wide</span>
                    </label>
                </div>
            </div>
            <hr>
            <div class="p-4">
                <h5>Themes</h5>
                <div class="themes">
                    <button data-toggle="theme" data-value="default">
                        <span class="color bg-[#0284C7]"></span>
                        <span>Sky</span>
                    </button>
                    <button data-toggle="theme" data-value="red">
                        <span class="color bg-[#DC2626]"></span>
                        <span>Red</span>
                    </button>
                    <button data-toggle="theme" data-value="orange">
                        <span class="color bg-[#EA580C]"></span>
                        <span>Orange</span>
                    </button>
                    <button data-toggle="theme" data-value="amber">
                        <span class="color bg-[#D97706]"></span>
                        <span>Amber</span>
                    </button>
                    <button data-toggle="theme" data-value="yellow">
                        <span class="color bg-[#CA8A04]"></span>
                        <span>Yellow</span>
                    </button>
                    <button data-toggle="theme" data-value="lime">
                        <span class="color bg-[#65A30D]"></span>
                        <span>Lime</span>
                    </button>
                    <button data-toggle="theme" data-value="green">
                        <span class="color bg-[#65A30D]"></span>
                        <span>Green</span>
                    </button>
                    <button data-toggle="theme" data-value="emerald">
                        <span class="color bg-[#059669]"></span>
                        <span>Emerald</span>
                    </button>
                    <button data-toggle="theme" data-value="teal">
                        <span class="color bg-[#0D9488]"></span>
                        <span>Teal</span>
                    </button>
                    <button data-toggle="theme" data-value="cyan">
                        <span class="color bg-[#0891B2]"></span>
                        <span>Cyan</span>
                    </button>
                    <button data-toggle="theme" data-value="blue">
                        <span class="color bg-[#2563EB]"></span>
                        <span>Blue</span>
                    </button>
                    <button data-toggle="theme" data-value="indigo">
                        <span class="color bg-[#4F46E5]"></span>
                        <span>Indigo</span>
                    </button>
                    <button data-toggle="theme" data-value="violet">
                        <span class="color bg-[#7C3AED]"></span>
                        <span>Violet</span>
                    </button>
                    <button data-toggle="theme" data-value="purple">
                        <span class="color bg-[#9333EA]"></span>
                        <span>Purple</span>
                    </button>
                    <button data-toggle="theme" data-value="fuchsia">
                        <span class="color bg-[#C026D3]"></span>
                        <span>Fuchsia</span>
                    </button>
                    <button data-toggle="theme" data-value="pink">
                        <span class="color bg-[#DB2777]"></span>
                        <span>Pink</span>
                    </button>
                    <button data-toggle="theme" data-value="rose">
                        <span class="color bg-[#E11D48]"></span>
                        <span>Rose</span>
                    </button>
                </div>
            </div>
            <hr>
            <div class="p-4">
                <div>
                    <h5>50 Shades of Gray</h5>
                    <small>5 x 10 Shades</small>
                </div>
                <div class="themes">
                    <button data-toggle="gray" data-value="default">
                        <span class="color bg-[#4B5563]"></span>
                        <span>Pure</span>
                    </button>
                    <button data-toggle="gray" data-value="slate">
                        <span class="color bg-[#475569]"></span>
                        <span>Slate</span>
                    </button>
                    <button data-toggle="gray" data-value="zinc">
                        <span class="color bg-[#52525B]"></span>
                        <span>Zinc</span>
                    </button>
                    <button data-toggle="gray" data-value="neutral">
                        <span class="color bg-[#525252]"></span>
                        <span>Neutral</span>
                    </button>
                    <button data-toggle="gray" data-value="stone">
                        <span class="color bg-[#57534E]"></span>
                        <span>Stone</span>
                    </button>
                </div>
            </div>
            <hr>
            <div class="p-4">
                <h5>Fonts</h5>
                <div class="themes fonts">
                    <button data-toggle="font" data-value="default">
                        <h5 class="font-['Nunito']">Nunito</h5>
                        <p class="font-['Nunito_Sans']">Nunito Sans</p>
                    </button>
                    <button data-toggle="font" data-value="montserrat">
                        <h5 class="font-['Montserrat']">Montserrat</h5>
                        <p class="font-['Montserrat']">Montserrat</p>
                    </button>
                    <button data-toggle="font" data-value="raleway">
                        <h5 class="font-['Raleway']">Raleway</h5>
                        <p class="font-['Raleway']">Raleway</p>
                    </button>
                    <button data-toggle="font" data-value="poppins">
                        <h5 class="font-['Poppins']">Poppins</h5>
                        <p class="font-['Poppins']">Poppins</p>
                    </button>
                    <button data-toggle="font" data-value="oswald">
                        <h5 class="font-['Oswald']">Oswald</h5>
                        <p class="font-['Oswald']">Oswald</p>
                    </button>
                    <button data-toggle="font" data-value="roboto-condensed-roboto">
                        <h5 class="font-['Roboto_Condensed']">Roboto Condensed</h5>
                        <p class="font-['Roboto']">Roboto</p>
                    </button>
                    <button data-toggle="font" data-value="inter">
                        <h5 class="font-['Inter']">Inter</h5>
                        <p class="font-['Inter']">Inter</p>
                    </button>
                    <button data-toggle="font" data-value="yantramanav">
                        <h5 class="font-['Yantramanav']">Yantramanav</h5>
                        <p class="font-['Yantramanav']">Yantramanav</p>
                    </button>
                </div>
            </div>
        </div>
    </aside>
    <main class="workspace">