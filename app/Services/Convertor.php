<?php

namespace App\Services;

class Convertor
{
    /**
     * @param string $markdown
     * @return array|string|null
     */
    public static function convertMarkdownToBBCode(string $markdown): array|string|null
    {
        // Convertir les titres
        $bbcode = preg_replace('/^###### (.*)/m', '[size=85][b]$1[/b][/size]', $markdown);
        $bbcode = preg_replace('/^##### (.*)/m', '[size=100][b]$1[/b][/size]', $bbcode);
        $bbcode = preg_replace('/^#### (.*)/m', '[size=120][b]$1[/b][/size]', $bbcode);
        $bbcode = preg_replace('/^### (.*)/m', '[size=140][b]$1[/b][/size]', $bbcode);
        $bbcode = preg_replace('/^## (.*)/m', '[size=160][b]$1[/b][/size]', $bbcode);
        $bbcode = preg_replace('/^# (.*)/m', '[size=180][b]$1[/b][/size]', $bbcode);

        // Convertir le gras et l'italique
        $bbcode = preg_replace('/\*\*\*(.*)\*\*\*/m', '[b][i]$1[/i][/b]', $bbcode);
        $bbcode = preg_replace('/\*\*(.*)\*\*/m', '[b]$1[/b]', $bbcode);
        $bbcode = preg_replace('/\*(.*)\*/m', '[i]$1[/i]', $bbcode);

        // Convertir les listes
        $bbcode = preg_replace('/^\s*-\s+(.*)/m', '[*]$1', $bbcode);
        $bbcode = preg_replace('/^\s*\*\s+(.*)/m', '[*]$1', $bbcode);
        $bbcode = preg_replace('/^\s*\d+\.\s+(.*)/m', '[*]$1', $bbcode);
        $bbcode = preg_replace('/\n[*]/m', "\n[list]\n[*]", $bbcode);
        $bbcode = preg_replace('/\[\*](.*)\n(?!\[\*])/m', "$1\n[/list]", $bbcode);

        // Convertir les liens
        $bbcode = preg_replace('/\[(.*?)\]\((.*?)\)/m', '[url=$2]$1[/url]', $bbcode);

        // Convertir les images
        $bbcode = preg_replace('/!\[(.*?)\]\((.*?)\)/m', '[img]$2[/img]', $bbcode);

        return $bbcode;
    }
}
