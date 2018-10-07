<?php

namespace App\Helpers;

class BggHelper
{
    public static function getDataFromBGG($id){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.boardgamegeek.com/xmlapi/boardgame/" . $id . "?stats=1",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $xml = simplexml_load_string($response);

        $json = json_encode($xml);
        $array = json_decode($json,TRUE);

        $nameIndex = 0;

        $i = 0;

        foreach($xml->boardgame->name as $key => $name) {
            if ($name['primary']) {
                $nameIndex = $i;
            }
            $i++;
        }

        if (is_array($array['boardgame']['name'])) {
            $array['boardgame']['name'] = $array['boardgame']['name'][(int)$nameIndex];
        }

        return $array['boardgame'];
    }
}