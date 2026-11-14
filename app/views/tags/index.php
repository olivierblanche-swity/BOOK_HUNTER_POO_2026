<?php
/** @var array $tags */
$tagSizes = ['text-sm', 'text-base', 'text-lg', 'text-xl'];
?>

<?php foreach ($tags as $index => $tag): ?>
    <a class="text-gray-300 hover:text-white <?php echo \Core\Helpers::e($tagSizes[$index % count($tagSizes)]); ?>"
       href="tags/<?php echo \Core\Helpers::e($tag->id); ?>/<?php echo \Core\Helpers::e(\Core\Helpers::slugify($tag->name)); ?>.html">  <?php echo \Core\Helpers::e($tag->name); ?></a>
<?php endforeach; ?>
