<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Determine base path for links depending on deployment. Use root-relative paths to avoid
// broken links when pages are served from subfolders.
$is_private_admin = (strpos($_SERVER['SCRIPT_NAME'], '/private_admin/') !== false) || (strpos($_SERVER['REQUEST_URI'], '/private_admin/') !== false);
// Compute a robust root path based on the current request so links work both when the
// project is served from a subfolder (e.g. http://host/blog_omeng/) or directly from
// the webserver root. We take the first path segment as the project folder if present.
// Find the project root URL by walking up from current script directory until we find an index.php
$script_parts = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));
$docRoot = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$checkDir = $scriptDir;
$found = false;
while (true) {
    if ($checkDir === '/' || $checkDir === '.') {
        // reached webroot
        if (file_exists($docRoot . '/index.php')) {
            $base_path = '/';
        } else {
            $base_path = '/';
        }
        break;
    }
    if (file_exists($docRoot . $checkDir . '/index.php')) {
        $base_path = rtrim($checkDir, '/') . '/';
        $found = true;
        break;
    }
    $parent = dirname($checkDir);
    if ($parent === $checkDir) {
        $base_path = '/';
        break;
    }
    $checkDir = $parent;
}
include_once __DIR__ . "/../../backend/config/visitor_track.php";

// Helper: map a filesystem path to a web path by removing the server document root.
$docRoot = rtrim($_SERVER['DOCUMENT_ROOT'], '\\');
function url_for_fs($fsPath) {
    global $docRoot;
    $real = realpath($fsPath);
    if (!$real) return $fsPath;
    $real = str_replace('\\', '/', $real);
    $doc = str_replace('\\', '/', $docRoot);
    $url = str_replace($doc, '', $real);
    if ($url === '') $url = '/';
    return $url;
}

$current_page = basename($_SERVER['SCRIPT_FILENAME']);
?>
<header>
    <nav class="main-nav">
        <div class="container main-nav-content">
            <div class="nav-left">
                <button class="nav-toggle" aria-expanded="false">
                    <span class="burger-bar"></span>
                    <span class="burger-bar"></span>
                    <span class="burger-bar"></span>
                </button>
                <nav class="nav-secondary">
                    <div class="secondary-nav-content">
                        <div class="secondary-nav-header"><h3>Omeng Menu</h3></div>
                        <div class="nav-items">
                            <a href="<?php echo url_for_fs(__DIR__ . '/../html/settings.php'); ?>" class="<?php echo ($current_page == 'settings.php') ? 'active' : ''; ?>"><span class="material-icons">settings</span> Settings</a>
                            <a href="<?php echo url_for_fs(__DIR__ . '/../html/feedback.php'); ?>" class="<?php echo ($current_page == 'feedback.php') ? 'active' : ''; ?>"><span class="material-icons">feedback</span> Feedback</a>
                            <a href="<?php echo url_for_fs(__DIR__ . '/../html/qna.php'); ?>" class="<?php echo ($current_page == 'qna.php') ? 'active' : ''; ?>"><span class="material-icons">help_outline</span> QNA</a>
                            
                            <!-- Admin Link: Always 'Admin Panel' -->
                                                    <?php
                                                        // Point admin links to private_admin and show logout only when inside admin area
                                                        $is_in_private_admin = $is_private_admin;
                                                        if ($is_in_private_admin) {
                                                            $admin_target = $base_path . 'private_admin/' . (isset($_SESSION['admin_logged_in']) ? 'index.php' : 'login.php');
                                                        } else {
                                                            // always use root-relative admin links
                                                            $admin_target = $base_path . 'private_admin/' . (isset($_SESSION['admin_logged_in']) ? 'index.php' : 'login.php');
                                                        }
                                                    ?>
                                                    <a href="<?php echo url_for_fs(dirname(__DIR__) . '/../private_admin/' . (isset($_SESSION['admin_logged_in']) ? 'index.php' : 'login.php')); ?>" class="admin-link">
                                <span class="material-icons">admin_panel_settings</span> Admin Panel
                            </a>

                            <?php if (isset($_SESSION['admin_logged_in']) && $is_in_private_admin): ?>
                                <a href="<?php echo url_for_fs(__DIR__ . '/../../backend/admin/logout.php'); ?>" class="admin-link" style="color: #ff4757;">
                                    <span class="material-icons">logout</span> Logout
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </nav>
                <a href="<?php echo url_for_fs(dirname(__DIR__) . '/../index.php'); ?>" class="nav-brand">
                    <img src="<?php echo url_for_fs(__DIR__ . '/../images/logo-navbar.png'); ?>" class="nav-logo" alt="Omeng logo">
                </a>
            </div>
            <form class="search-bar" action="<?php echo url_for_fs(dirname(__DIR__) . '/../search.php'); ?>" method="GET">
                <div class="search-wrapper">
                    <input type="text" name="q" placeholder="Cari..." class="search-input" value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
                </div>
            </form>
            <div class="nav-right">
                <div class="nav-link">
                    <a href="<?php echo url_for_fs(dirname(__DIR__) . '/../index.php'); ?>" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a>
                    <a href="<?php echo url_for_fs(dirname(__DIR__) . '/../about.php'); ?>" class="<?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">About Us</a>
                    <a href="<?php echo url_for_fs(dirname(__DIR__) . '/../shop.php'); ?>" class="<?php echo ($current_page == 'shop.php') ? 'active' : ''; ?>">Shop</a>
                    <a href="<?php echo url_for_fs(dirname(__DIR__) . '/../myproject.php'); ?>" class="<?php echo ($current_page == 'myproject.php' || $current_page == 'detail.php') ? 'active' : ''; ?>">My Project</a>
                </div>
            </div>
        </div>
    </nav>
</header>
