<?php
// Requêtes GET uniquement ; le serveur Apache doit déjà être lancé.
$base = $argv[1] ?? 'http://localhost/scripts/BES/framework%20serveur/BOOK_HUNTER_POO_2026/public/';
$expectedBase = parse_url($base, PHP_URL_PATH);
$checks = 0;
function requestPage(string $path, int $expected, bool $spoofHost = false): string {
    global $base, $expectedBase, $checks;
    $context = stream_context_create(['http' => [
        'ignore_errors' => true, 'timeout' => 15,
        'header' => $spoofHost ? "Host: untrusted.example\r\n" : '',
    ]]);
    $html = file_get_contents($base . $path, false, $context);
    $status = $http_response_header[0] ?? '';
    if ($html === false || !str_contains($status, ' ' . $expected . ' ')) {
        throw new RuntimeException('Statut HTTP inattendu : ' . $status);
    }
    if (!str_contains($html, '<base href="' . $expectedBase . '">')
        || preg_match('/(?:Fatal error|Warning|Deprecated):/', $html)) {
        throw new RuntimeException('Base URL ou rendu HTTP incorrect');
    }
    $checks++;
    return $html;
}
$home = requestPage('', 200);
requestPage('index.php', 200);
requestPage('index.html?test=1', 200);
requestPage('books.html', 200);
requestPage('authors.html', 200);
preg_match_all('~href="((books|authors|categories|tags)/[^"<>]+\.html)"~', $home, $links, PREG_SET_ORDER);
$seen = [];
foreach ($links as $link) {
    if (!isset($seen[$link[2]])) {
        requestPage(html_entity_decode($link[1], ENT_QUOTES, 'UTF-8'), 200);
        $seen[$link[2]] = true;
    }
}
if (count($seen) !== 4) { throw new RuntimeException('Détails des quatre ressources non testés'); }
requestPage('route-inconnue.html', 404);
requestPage('books/999999999/inexistant.html', 404);
requestPage('books/0/invalide.html', 404);
requestPage('', 200, true);
echo $checks . " contrôles HTTP Apache réussis (listes, détails, 404, sous-dossier, Host).\n";
