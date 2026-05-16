<?php
function get_api($url){
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_USERAGENT => "Mozilla/5.0"
    ]);

    $html = curl_exec($ch);
    curl_close($ch);

    if (preg_match_all('/toNumbers\("([a-f0-9]+)"\)/i', $html, $m) && count($m[1]) >= 3) {

        $key  = hex2bin($m[1][0]);
        $iv   = hex2bin($m[1][1]);
        $data = hex2bin($m[1][2]);

        $dec = openssl_decrypt(
            $data,
            "AES-128-CBC",
            $key,
            OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING,
            $iv
        );

        if ($dec !== false) {
            $cookie = "__test=" . bin2hex($dec);

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTPHEADER => ["Cookie: $cookie"],
                CURLOPT_USERAGENT => "Mozilla/5.0",
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false
            ]);

            $html = curl_exec($ch);
            curl_close($ch);
        }
    }

    return $html;
}
?>