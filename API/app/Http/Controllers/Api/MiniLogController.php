<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Request as Solicitacao;

use function Mini\sanitize;

class MiniLogController extends LogController
{
    public static function get(array $data)
    {
        $return = [
            'uid' => Str::uuid()->toString(),
            'userUid' => $data['uid'],
            'content' => []
        ];

        $validations = Solicitacao::all()
            ->where('usuarioUid', '=', $data['uid'])
            ->whereBetween('created_at', [$data['startDate'], $data['endDate']]);

        $json = [];
            
        if ($data['startDate'] != '1970-1-1') {
            $return['startDate'] = $data['startDate'];
        };

        if ($data['endDate'] != '9999-12-31') {
            $return['endDate'] = $data['endDate'];
        };

        $json['content'] = [];

        foreach ($validations as $validation) {
            $entry = [];

            $entry['validationUid'] = $validation['uid'];

            $entry['requestDate'] = date_format($validation['created_at'], "Y-m-d");

            $entry['isSafe'] = $validation['isSafe'];

            $entry['originalInput'] = $validation['input'];

            $entry['information'] = [];

            $risks = json_decode($validation['results']);
            $risks = $risks->risks;

            foreach ($risks as $risk) {
                if ($risk->type == 'HTML') {
                    $message = "Mini detected the opening of a HTML ".$risk->content." while validating the input passed. During the parse, all risky tags where removed for Mini's response, but it is advised to make new validations to ensure safety while using that input";
                } else {
                    $message = "Mini detected a pattern very similar to a SQL ".substr($risk->content, 10).". It was not removed from the input, as Mini does not make a semantic check, so it is advised to make new validations to ensure safety while using that input.";
                };

                array_push($entry['information'], $message);
            };

            array_push($return['content'], $entry);
        };

        Log::create([
            'uid' => $return['uid'],
            'userUid' => $return['userUid'],
            'content' => json_encode($return['content'])
        ]);

        return $return;
    }
}