<?php
$categories = \App\Models\CategoriesManager::findAll(null, 'name');
$tags = \App\Models\TagsManager::findAll(null, 'name');
?>

<aside class="w-full md:w-1/4 p-3">
    <div class="bg-gray-700 rounded-lg shadow-lg p-4">
        <h2 class="font-bold text-lg mb-4">Categories</h2>
        <ul class="list-reset">
            <?php include __DIR__ . '/../../categories/_index.php'; ?>
        </ul>
    </div>
    <div class="bg-gray-700 rounded-lg shadow-lg p-4 mt-4">
        <h2 class="font-bold text-lg mb-4">Tags</h2>
        <div class="tag-cloud">
            <?php include __DIR__ . '/../../tags/_cloud.php'; ?>
        </div>
    </div>
</aside>
