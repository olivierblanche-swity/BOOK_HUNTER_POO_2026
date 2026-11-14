<?php 
/**
 * @var object $author
 */
?>


<div class="bg-gray-700 rounded-lg shadow-lg p-4">
    <div class="flex flex-wrap">
        <div class="w-full lg:w-1/3 px-1 lg:px-4 mb-4">
            <img
                class="w-full h-auto rounded-lg"
                src="<?php echo \Core\Helpers::e($author->picture); ?>"
                alt="<?php echo \Core\Helpers::e($author->firstname); ?> <?php echo \Core\Helpers::e($author->lastname); ?>" />
        </div>
        <div class="w-full lg:w-2/3 px-1 lg:px-4 mb-4">
            <h2 class="font-bold text-2xl mb-2"><?php echo \Core\Helpers::e($author->firstname); ?> <?php echo \Core\Helpers::e($author->lastname); ?> <?php echo \Core\Helpers::e($author->lastname); ?></h2>
            <p class="text-gray-300 mb-4">Biographie:</p>
            <p class="text-gray-300 mb-4">
                <?php echo \Core\Helpers::e($author->firstname); ?> <?php echo \Core\Helpers::e($author->biography); ?>
            </p>
            <div class="flex items-center mb-4">
                <span class="text-yellow-500 mr-1">
                    <i class="fas fa-star"></i>
                </span>
                <span><?php echo \Core\Helpers::e($author->notation ?? 'Pas encore de note'); ?></span>
            </div>
            <h3 class="font-bold text-lg mb-2">Ses derniers livres</h3>
            <ul class="list-disc list-inside text-gray-300">
                <?php foreach($author->books as $book): ?>
                <li>
                    <a
                        href="books/<?php echo \Core\Helpers::e($book->id); ?>/<?php echo \Core\Helpers::e(\Core\Helpers::slugify($book->title)); ?>.html"
                        class="hover:text-red-500 underline font-medium"><?php echo \Core\Helpers::e($book->title); ?></a>
                </li>
                <?php endforeach; ?>
                
            </ul>
        </div>
    </div>
</div>
