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
        <!-- EXAMPLE CSS -->
        <?php if($w_current_route == 'main_example') : ?>
            <link rel="stylesheet" href="<?= $this->assetUrl('css/example/example.css') ?>" />
        <?php endif; ?>
        <!-- TITLE -->
        <title><?= $w_site_name . ' - ' . $this->e($title) ?></title>
        <!-- SITE DESCRIPTION -->
        <meta name="description" content="" />
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
            <script src="<?= $this->assetUrl('js/kiwwwi-slider.js') ?>"></script>
            <script src="<?= $this->assetUrl('js/example.js') ?>"></script>
        <?php endif; ?>

    </body>
</html>
