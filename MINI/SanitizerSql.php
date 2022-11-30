<?php

namespace Mini;

interface iSanitizerSql {
    function sanitize(string $string_to_sanitize);
}

class SanitizerSql implements iSanitizerSql {
    public function __construct(private array $sql_clauses) {}

    function sanitize(string $string_to_sanitize) {
        $sql_found = [];

        foreach ($this->sql_clauses as $clause) {
            if (preg_match($clause["regex"], $string_to_sanitize)) {
                array_push($sql_found, $clause['name']);
            };
        };
        return $sql_found;
    }
}