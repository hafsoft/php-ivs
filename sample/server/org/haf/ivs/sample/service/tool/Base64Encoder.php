<?php
/**
 * php-ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/3/13 4:36 PM
 */

namespace org\haf\ivs\sample\service\tool;


class Base64Encoder {
    public static function encodeFile($fileName) {
        return 'data:' . mime_content_type($fileName) . ';base64,' . base64_encode(file_get_contents($fileName));
    }
}