<?php

namespace Mini;

use Mini\Sanitizer;
use Mini\Sql;
use Mini\Html;

class Validator {
    public static function mini_validate(string $input) {
        [$sanitized_input, $caught_html, $caught_sql]
            = Sanitizer::sanitize($input, Html::$TAGS, Sql::$CLAUSES);

        $result = [
          'input'=> $input, 
          'sanitizedInput'=> $sanitized_input,
          'risks'=>[]
        ];
        
        $is_safe = false;
       
        foreach($caught_html as $html)
               {
                 $arr = [
                  'type' =>'HTML',
                  'content'=> $html . ' tag',
                  'message'=> 'Removed with PHP sanitization'
                 ];
                 array_push($result['risks'], $arr);
               }
               
        foreach($caught_sql as $sql)
               {
                
                 $sarr = [
                        'type'=> 'SQL',
                        'content' => 'Tentative ' . $sql,
                        'message' => 'Possibile SQL injection attempt'
                 ];
                 array_push($result['risks'], $sarr);
               }
        
        if(empty($result['risks']))
          {
            $is_safe = true;
          }
          
        return [
            $sanitized_input,
            $result,
            $is_safe
        ];
    }
}
