<!DOCTYPE html>
<?php if(isset($lang)) : ?>
<html lang="<?= $lang ?>">
<?php else : ?>
<html>
<?php endif ; ?>
    <head>
        <!-- CHARSET -->
        <meta charset="utf-8" />
        <!-- MOBILE WIDTH -->
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!-- FAVICON -->
        <link rel="shortcut icon" type="image/png" href="" />
        <!-- CSS -->
        <link rel="stylesheet" href="<?= $this->assetUrl('css/reset.css') ?>" />
        <link rel="stylesheet" href="<?= $this->assetUrl('css/layout.css') ?>" />
        <link rel="stylesheet" href="<?= $this->assetUrl('css/mobile-menu.css') ?>" />
        <!-- EXAMPLE CSS -->
        <?php if($w_current_route == 'main_example') : ?>
            <link rel="stylesheet" href="<?= $this->assetUrl('css/example/example.css') ?>" />
        <?php endif; ?>
        <!-- TITLE -->
        <title><?= $w_site_name . ' - ' . $this->e($title) ?></title>
        <!-- SITE DESCRIPTION -->
        <meta name="description" content="" />
        <!-- FONT AWESOME CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
        <!-- OPENGRAPH -->
        <meta property="og:title" content="" />
        <meta property="og:description" content="" />
        <meta property="og:url" content="" />
        <meta property="og:image" content="" />
        <meta property="og:type" content="website" />
    </head>

    <body>

        <!-- HEADER -->
        <header>
            <!-- NAVIGATION (MOBILE) -->
            <div class="mobile-bar">
                <a href="<?= $this->url('main_example', array('lang' => $lang)) ?>"><img src="<?= $this->assetUrl('img/logo.png') ?>"></img></a>
                <i class="fa fa-bars" aria-hidden="true"></i>
            </div>
            <nav class="mobile-nav">
                <ul>
                    <li><i class="fa fa-times" aria-hidden="true"></i></li>
                    <li><a href="<?= $this->url('main_example', array('lang' => $lang)) ?>"><img src="<?= $this->assetUrl('img/logo.png') ?>" alt=""></a></li>
                    <li><a href="<?= $this->url('main_example', array('lang' => $lang)) ?>"><?= translate('home') ?></a></li>
                    <li><a href="<?= $this->url('main_home', array('lang' => $lang)) ?>">Blabla</a></li>
                    <li>
                        <form action="" method="GET" >
                            <input type="search" name="search" placeholder="<?= translate('search') ?>" />
                            <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </form>
                    </li>
                    <li>
                        <a href="https://www.facebook.com/"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
                        <a href="https://www.instagram.com"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        <a href="https://www.linkedin.com/"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a href="<?= substr_replace($_SERVER['REQUEST_URI'], 'fr', 1, 2) ?>">FR</a>
                        <a href="<?= substr_replace($_SERVER['REQUEST_URI'], 'en', 1, 2) ?>">EN</a>
                    </li>
                </ul>
            </nav>
        </header>
        <!-- MAIN CONTENT -->
    	<main>
    		<?= $this->section('main_content') ?>
    	</main>

        <!-- FOOTER -->
    	<footer>
    	</footer>

        <!-- EXAMPLE SCRIPT -->
        <?php if($w_current_route == 'main_example') : ?>
            <script src="<?= $this->assetUrl('js/kiwwwi-slider.min.js') ?>"></script>
            <script src="<?= $this->assetUrl('js/example.js') ?>"></script>
        <?php endif; ?>
        <!-- MOBILE-NAV SCRIPT -->
        <script src="<?= $this->assetUrl('js/mobile-menu.js') ?>"></script>

    </body>
</html>
