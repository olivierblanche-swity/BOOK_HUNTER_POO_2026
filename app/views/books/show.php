<?php 
/**
 * @var object $book
 * 
 */
?>

<?php \Core\AppTemplate::section('title'); ?>
<?php echo sprintf(TITLE_BOOKS_SHOW, $book->title); ?>
<?php \Core\AppTemplate::stop(); ?>


<?php \Core\AppTemplate::section('content'); ?>
<div class="bg-gray-700 rounded-lg shadow-lg p-4">
    <div class="flex flex-wrap">
        <div class="w-full lg:w-1/3 px-1 lg:px-4 mb-4">
            <img
                class="w-full h-auto rounded-lg"
                src="<?php echo \Core\Helpers::e($book->cover); ?>"
                alt="<?php echo \Core\Helpers::e($book->title); ?>" />
        </div>
        <div class="w-full lg:w-2/3 px-1 lg:px-4 mb-4">
            <h2 class="font-bold text-2xl mb-2"><?php echo \Core\Helpers::e($book->title); ?></h2>
            <p class="text-gray-300 mb-4">
                Par
                <a
                    href="authors/<?php echo \Core\Helpers::e($book->author->id); ?>/<?php echo \Core\Helpers::e(\Core\Helpers::slugify($book->author->firstname . '-' . $book->author->lastname )); ?>.html"
                    class="hover:text-red-500 underline font-medium"><?php echo \Core\Helpers::e($book->author->firstname); ?> <?php echo \Core\Helpers::e($book->author->lastname); ?></a>
            </p>
            <p class="text-gray-300 mb-4"><?php echo \Core\Helpers::e(\Core\Helpers::dateFormator($book->publicated_at)); ?></p>
            <p class="text-gray-300 mb-4">Genre: <?php //echo $book->category; ?></p>
            <div class="flex items-center mb-4">
                <span class="text-yellow-500 mr-1">
                    <i class="fas fa-star"></i>
                </span>
                <span><?php echo \Core\Helpers::e($book->notation); ?></span>
            </div>
            <div class="flex flex-wrap">
                <?php foreach($book->tags as $tag): ?>
                <a
                    href="tags/<?php echo \Core\Helpers::e($tag->id); ?>/<?php echo \Core\Helpers::e(\Core\Helpers::slugify($tag->name)); ?>.html"
                    class="bg-gray-500 text-white px-3 py-1 rounded-full text-sm font-semibold mr-2 hover:bg-gray-800 hover:text-white"><?php echo \Core\Helpers::e($tag->name); ?></a>
                    <?php endforeach; ?>
                
            </div>
            <a
                href="#"
                class="inline-block mt-4 bg-red-500 hover:bg-red-800 rounded-full px-4 py-2 text-white">
                Ajouter à ma collection
            </a>
        </div>
    </div>
    <div>
        <h3 class="font-bold text-lg mb-2">Résumé</h3>
        <p class="text-gray-300">
            <?php echo \Core\Helpers::e($book->resume); ?>
        </p>
    </div>
</div>
<?php \Core\AppTemplate::stop(); ?>
