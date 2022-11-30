<?php

namespace Mini;

interface iSanitizerHtml {
    function sanitize(string $string_to_sanitize);
}

class SanitizerHtml implements iSanitizerHtml {
    public function __construct(private array $html_tags) {}

    function sanitize(string $string_to_sanitize) {
        $tags_found = [];

        foreach ($this->html_tags as $tag) {
            if (str_contains($string_to_sanitize, $tag)) {
                array_push($tags_found, $tag);
            };
        };

        return $tags_found;
    }
}