<?php

/**
 * @var array $tags
 */
?>

<?php foreach ($tags as $tag): ?>
    <span
        class="bg-gray-500 text-white px-3 py-1 rounded-full text-sm font-semibold mr-2">
        <?php echo \Core\Helpers::e($tag->name); ?>
    </span>
<?php endforeach; ?>