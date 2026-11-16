<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../core/Title.php';
set_error_handler(static function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});
class MissingBook extends \App\Models\Book {
    public int $notationLoads = 0;
    public function __construct() {
        $this->id = 1;
        $this->title = 'Livre test';
        $this->resume = '';
        $this->cover = '';
        $this->tags = [];
    }
    protected function setNotation() { $this->notationLoads++; $this->notation = null; }
}
function verify(bool $ok, string $message): void {
    if (!$ok) { throw new RuntimeException($message); }
}
$book = new MissingBook();
$books = [$book];
ob_start();
include __DIR__ . '/../app/views/books/_index.php';
$html = ob_get_clean();
foreach (['Auteur non renseigné', 'Catégorie non renseignée', 'Pas encore de note'] as $text) {
    verify(str_contains($html, $text), 'Carte : ' . $text);
}
include __DIR__ . '/../app/views/books/show.php';
foreach (['Auteur non renseigné', 'Catégorie non renseignée', 'Pas encore de note', 'Date non renseignée'] as $text) {
    verify(str_contains($content, $text), 'Détail : ' . $text);
}
verify(!str_contains($content, 'href="authors/'), 'Lien auteur absent attendu');
verify($book->notationLoads === 1, 'Une moyenne null doit être mémorisée');
verify($book->author === false && $book->category === false, 'Clés nulles : aucune requête nécessaire');
class RatedBook extends MissingBook {
    protected function setNotation() { $this->notationLoads++; $this->notation = '0.0'; }
}
$book = new RatedBook();
verify(($book->notation ?? 'Pas encore de note') === '0.0', 'Une note zéro doit être conservée');
restore_error_handler();
echo "11 contrôles de rendu/modèle réussis, aucun avertissement\n";
