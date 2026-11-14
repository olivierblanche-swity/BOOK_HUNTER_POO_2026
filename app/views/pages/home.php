

<?php \Core\AppTemplate::section('title'); ?>
<?php echo \Core\Helpers::e(TITLE_HOME); ?>
<?php \Core\AppTemplate::stop(); ?>

<?php \Core\AppTemplate::section('content'); ?>
<?php include __DIR__ . '/../books/_populars.php'; ?>
        
<?php include __DIR__ . '/../authors/_populars.php'; ?>
<?php \Core\AppTemplate::stop(); ?>

        
