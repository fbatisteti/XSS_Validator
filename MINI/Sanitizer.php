<?php

namespace Mini;

use Mini\SanitizerHtml;
use Mini\SanitizerSql;

class Sanitizer {
    public static function sanitize(string $string_to_sanitize, array $html_tags, array $sql_clauses) {
        $html = new SanitizerHtml($html_tags);
        $sql = new SanitizerSql($sql_clauses);
    
        $output = [
            strip_tags($string_to_sanitize),
            $html->sanitize($string_to_sanitize),
            $sql->sanitize($string_to_sanitize)
        ];
    
        return $output;
    }
}
