<?php 
/**
 * @var array $categories
 */
?>

<?php foreach ($categories as $category): ?>
    <li>
        <a class="text-gray-300 hover:text-white"
           href="categories/<?php echo \Core\Helpers::e($category->id); ?>/<?php echo \Core\Helpers::e(\Core\Helpers::slugify($category->name)); ?>.html"><?php echo \Core\Helpers::e($category->name); ?></a>
    </li>
<?php endforeach; ?>
