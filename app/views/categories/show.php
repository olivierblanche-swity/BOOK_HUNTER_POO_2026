<?php
/** @var \App\Models\Category $category */
?>
<?php \Core\AppTemplate::section('title'); ?>
Catégorie : <?php echo $category->name; ?>
<?php \Core\AppTemplate::stop(); ?>

<?php \Core\AppTemplate::section('content'); ?>
<h2 class="text-2xl font-bold mb-4">Livres de la catégorie « <?php echo \Core\Helpers::e($category->name); ?> »</h2>
<?php $books = $category->books; ?>
<?php if (empty($books)): ?>
    <p class="text-gray-300">Aucun livre dans cette catégorie.</p>
<?php else: ?>
    <?php include __DIR__ . '/../books/_index.php'; ?>
<?php endif; ?>
<?php \Core\AppTemplate::stop(); ?>
