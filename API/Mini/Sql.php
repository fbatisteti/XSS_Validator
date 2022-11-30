<?php

namespace Mini;

class Sql {
    public static $CLAUSES = [
        [
            "regex" => "/(.*)select(.*)from/iu",
            "name" => "SELECT clause"
        ],
        [
            "regex" => "/(.*)insert into(.*)/iu",
            "name" => "INSERT clause"
        ],
        [
            "regex" => "/(.*)insert(.*)select/iu",
            "name" => "INSERT clause"
        ],
        [
            "regex" => "/(.*)update(.*)set/iu", 
            "name" => "UPDATE clause"
        ],
        [
            "regex" => "/(.*)delete from(.*)/iu",
            "name" => "DELETE clause"
        ],
        [
            "regex" => "/(.*)drop(.*)/iu",
            "name" => "DROP clause"
        ],
        [
            "regex" => "/(.*)create(.*)/iu",
            "name" => "CREATE clause"
        ],
        [
            "regex" => "/(.*)alter(.*)/iu",
            "name" => "ALTER clause"
        ]
    ];
}

