<?php
// Global Meta Tags & SEO Configuration
$site_name = "Omeng Creations";
$site_description = "Portofolio Design & Digital Art Omeng Creations. Temukan berbagai karya kreatif dan merchandise unik di sini.";
$site_url = "http://localhost/blog_omeng/"; // Update later when hosting
$site_image = $site_url . "frontend/images/logo-omeng.png";
?>
<!-- SEO Meta Tags -->
<meta name="description" content="<?= $site_description ?>">
<meta name="keywords" content="Omeng Creations, Digital Art, Design, Merchandise, Portofolio">
<meta name="author" content="Omeng">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="<?= $site_url ?>">
<meta property="og:title" content="<?= $site_name ?>">
<meta property="og:description" content="<?= $site_description ?>">
<meta property="og:image" content="<?= $site_image ?>">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="<?= $site_url ?>">
<meta property="twitter:title" content="<?= $site_name ?>">
<meta property="twitter:description" content="<?= $site_description ?>">
<meta property="twitter:image" content="<?= $site_image ?>">
