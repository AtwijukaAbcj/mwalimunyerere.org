<?php

require_once('root/config.php');
if (empty($_SESSION['userid'])) {
    redirect_page(SITE_URL);
} else {
    $email = $_SESSION['email'];
    $userid = $_SESSION['userid'];
    $interface = $_SESSION['interface'];
    $fname = $_SESSION['first'];
    if ($interface == 'admin') {
        $role = 'Administrator';
    } else {
        $role = ucfirst($interface);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="dist/css/logo.ico" type="image/x-icon" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <title> mwalimunyerere Web Admin <?php echo (get_url() == 'dash') ? 'Dashboard' : ucfirst(get_url()); ?> </title>
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="dist/css/toastr.css">
    <link rel="stylesheet" href="dist/css/style.css">
    <?php if (get_url() == 'reports' || get_url() == 'ptlist') { ?>
        <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <?php } else { ?>
        <link href="dist/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <?php } ?>
    <link href="dist/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="dist/js/angular.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
    <script src="//cdn.ckeditor.com/4.5.9/standard/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"> </script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <style type="text/css">
        .nav-item button {
            font-size: 12px; /* Reduced font size */
            height: 45px; /* Reduced height */
            padding: 6px 10px; /* Adjust padding */
        }

        /* Submenu items even smaller */
        .nav-treeview .nav-item button {
            font-size: 11px; /* Smaller font size */
            height: 35px; /* Smaller height */
            padding: 4px 8px; /* Smaller padding */
        }

        .nav-item button i {
            font-size: 14px;
            margin-right: 8px;
        }

        .nav-treeview .nav-item button i {
            font-size: 12px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= HOME_URL; ?>" class="nav-link">Home</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" style="font-size:13px">
                        <i class="fas fa-user mr-2"></i><b><?php echo $fname; ?>(<?= $role; ?>) </b>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="password" class="dropdown-item">
                            <i class="fas fa-lock mr-2"></i> Change Password
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="logout" class="dropdown-item">
                            <i class="fas fa-power-off mr-2"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="<?= HOME_URL; ?>" class="brand-link">
                <img src="dist/img/logo.png" alt="Mwalimu Nyerere" class="brand-image elevation-4">
                <span class="brand-text font-weight-light" style="color: white;">Mwalimu Nyerere</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="<?= HOME_URL; ?>" class="nav-link <?php echo (get_url() == 'dash') ? 'active' : ''; ?>">
                                <button class="btn btn-outline-primary btn-lg" style="width: 100%; display: flex; align-items: center; justify-content: flex-start;">
                                    <i class="fas fa-tachometer-alt"></i>
                                    Dashboard
                                </button>
                            </a>
                        </li>
                        
                        <?php if ($interface == 'admin' || $interface == 'Administrator') { ?>
                            <!-- Admin specific menu items -->
                            <li class="nav-item">
                                <a href="users" class="nav-link <?php echo (get_url() == 'users') ? 'active' : ''; ?>">
                                    <button class="btn btn-outline-primary btn-lg">
                                        <i class="fas fa-user-plus"></i> Add Users
                                    </button>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="list_users.php" class="nav-link <?php echo (get_url() == 'list_users.php') ? 'active' : ''; ?>">
                                    <button class="btn btn-outline-primary btn-lg">
                                        <i class="fas fa-user-plus"></i> View Users
                                    </button>
                                </a>
                            </li>
                            

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <button class="btn btn-outline-primary btn-lg">
                                        <i class="fas fa-book"></i> Manage Projects
                                        <i class="right fas fa-angle-left"></i>
                                    </button>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="projects.php" class="nav-link">
                                            <button class="btn btn-outline-secondary btn-md">
                                                <i class="fas fa-cog"></i> Add Projects
                                            </button>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="view_projects.php" class="nav-link">
                                            <button class="btn btn-outline-secondary btn-md">
                                                <i class="fas fa-cog"></i> View Projects
                                            </button>
                                        </a>
                                    </li>
                                </ul>
                            </li>


                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <button class="btn btn-outline-primary btn-lg">
                                        <i class="fas fa-book"></i> Manage Banner
                                        <i class="right fas fa-angle-left"></i>
                                    </button>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="add_banner.php" class="nav-link">
                                            <button class="btn btn-outline-secondary btn-md">
                                                <i class="fa fa-list"></i> Add Banner
                                            </button>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="manage_banner.php" class="nav-link">
                                            <button class="btn btn-outline-secondary btn-md">
                                                <i class="fa fa-list"></i> View Banner
                                            </button>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <button class="btn btn-outline-primary btn-lg">
                                        <i class="fas fa-book"></i> Manage People
                                        <i class="right fas fa-angle-left"></i>
                                    </button>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="add_people.php" class="nav-link">
                                            <button class="btn btn-outline-secondary btn-md">
                                                <i class="fa fa-list"></i> Add People
                                            </button>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="view_people.php" class="nav-link">
                                            <button class="btn btn-outline-secondary btn-md">
                                                <i class="fa fa-list"></i> View People
                                            </button>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <button class="btn btn-outline-primary btn-lg">
                                        <i class="fas fa-book"></i> Manage Events
                                        <i class="right fas fa-angle-left"></i>
                                    </button>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="events.php" class="nav-link">
                                            <button class="btn btn-outline-secondary btn-md">
                                                <i class="fas fa-cog"></i> Add Events
                                            </button>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="view_events.php" class="nav-link">
                                            <button class="btn btn-outline-secondary btn-md">
                                                <i class="fas fa-cog"></i> View Events
                                            </button>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="blogs.php" class="nav-link">
                                            <button class="btn btn-outline-secondary btn-md">
                                                <i class="fas fa-cog"></i> Add Blogs/News
                                            </button>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="view_blogs.php" class="nav-link">
                                            <button class="btn btn-outline-secondary btn-md">
                                                <i class="fas fa-cog"></i> View Blogs
                                            </button>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <button class="btn btn-outline-primary btn-lg">
                                        <i class="fas fa-book"></i> Manage Causes
                                        <i class="right fas fa-angle-left"></i>
                                    </button>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="add_cause.php" class="nav-link">
                                            <button class="btn btn-outline-secondary btn-md">
                                                <i class="fas fa-cog"></i> Add cause
                                            </button>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="admin_cause.php" class="nav-link">
                                            <button class="btn btn-outline-secondary btn-md">
                                                <i class="fas fa-cog"></i> View Caurse
                                            </button>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <!-- Additional Admin Menu Items... -->

                        <?php } else if ($interface == 'approver' || $interface == 'Approver') { ?>
                            <!-- Approver specific menu items -->
                            <li class="nav-item">
                                <a href="requisitions" class="nav-link">
                                    <button class="btn btn-outline-primary btn-lg">
                                        <i class="fa fa-clipboard-list"></i> Requisitions
                                    </button>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="approver" class="nav-link">
                                    <button class="btn btn-outline-primary btn-lg">
                                        <i class="far fa-circle nav-icon"></i> List Of Requests
                                    </button>
                                </a>
                            </li>

                        <?php } else if ($interface == 'User' || $interface == 'user') { ?>
                            <!-- User specific menu items -->
                            <li class="nav-item">
                                <a href="requisitions" class="nav-link">
                                    <button class="btn btn-outline-primary btn-lg">
                                        <i class="fa fa-clipboard-list"></i> Requisitions
                                    </button>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="user_requisitions" class="nav-link">
                                    <button class="btn btn-outline-primary btn-lg">
                                        <i class="fa fa-clipboard-list"></i> User Requisitions
                                    </button>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </aside>
    </div>
</body>

</html>
