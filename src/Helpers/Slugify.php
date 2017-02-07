<?php
/**
 * Created by PhpStorm.
 * User: antoniobg
 * Date: 2/6/17
 * Time: 1:51 PM
 */

namespace So2platform\Publicprofile\Helpers;


class Slugify
{
    /**
     * Slugify the provided nickname
     *
     * @return String
     */
    function slugString($string){
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-',transliterator_transliterate("Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove; Lower();", $string))));
    }

}