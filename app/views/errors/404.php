<?php \Core\AppTemplate::section('title'); ?>
<?php echo \Core\Helpers::e(TITLE_ERROR_404); ?>
<?php \Core\AppTemplate::stop(); ?>

<?php \Core\AppTemplate::section('content'); ?>
<div class="bg-gray-700 rounded-lg shadow-lg p-4">
    <h2 class="text-2xl font-bold mb-4"><?php echo \Core\Helpers::e(TITLE_ERROR_404); ?></h2>
    <p class="mb-4">La ressource demandée est introuvable.</p>
    <a href="./" class="underline hover:text-red-500">
        Retour à l’accueil
    </a>
</div>
<?php \Core\AppTemplate::stop(); ?>
