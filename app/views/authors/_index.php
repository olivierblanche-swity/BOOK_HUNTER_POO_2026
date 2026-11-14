    <?php

    /**
     * 
     * @var array $authors
     * 
     */

    ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php foreach ($authors as $author):; ?>
        <article class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
            <img
                class="w-full h-48 object-cover"
                src="<?php echo \Core\Helpers::e($author->picture); ?>"
                alt="<?php echo \Core\Helpers::e($author->firstname); ?> <?php echo \Core\Helpers::e($author->lastname); ?>" />
            <div class="p-4">
                <h3 class="text-xl font-bold mb-2"><?php echo \Core\Helpers::e($author->firstname); ?> <?php echo \Core\Helpers::e($author->lastname); ?></h3>
                <div class="flex items-center mb-2">
                    <span class="text-yellow-500 mr-1"><i class="fas fa-star"></i></span>
                    <span>8.9</span>
                </div>
                <p class="text-gray-400">
                    <?php echo \Core\Helpers::e($author->biography); ?>
                </p>
                <a
                    href="authors/<?php echo \Core\Helpers::e($author->id); ?>/<?php echo \Core\Helpers::e(\Core\Helpers::slugify($author->firstname)); ?>-<?php echo \Core\Helpers::e(\Core\Helpers::slugify($author->lastname)); ?>.html"
                    class="inline-block mt-4 bg-red-500 hover:bg-red-800 rounded-full px-4 py-2 text-white">
                    More details
                </a>
            </div>
        </article>
    <?php endforeach; ?>
    </div>