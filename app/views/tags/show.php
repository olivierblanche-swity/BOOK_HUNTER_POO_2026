<?php
/** @var \App\Models\Tag $tag */
?>
<?php \Core\AppTemplate::section('title'); ?>
Tag : <?php echo \Core\Helpers::e($tag->name); ?>
<?php \Core\AppTemplate::stop(); ?>

<?php \Core\AppTemplate::section('content'); ?>
<h2 class="text-2xl font-bold mb-4">Livres avec le tag « <?php echo \Core\Helpers::e($tag->name); ?> »</h2>
<?php $books = $tag->books; ?>
<?php if (empty($books)): ?>
    <p class="text-gray-300">Aucun livre associé à ce tag.</p>
<?php else: ?>
    <?php include __DIR__ . '/../books/_index.php'; ?>
<?php endif; ?>
<?php \Core\AppTemplate::stop(); ?>
