<?php
function base64_encrypt($plain_text, $password, $iv_len = 16) {
    // Kunci 256-bit dari password
    $key = hash('sha256', $password, true);
    $iv = random_bytes($iv_len);

    // Enkripsi dengan AES-256-CBC
    $encrypted = openssl_encrypt($plain_text, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);

    // Gabungkan IV + ciphertext, lalu encode base64
    $hasil = base64_encode($iv . $encrypted);

    // Ganti + dengan @ (opsional, sesuai versi awal kamu)
    return str_replace('+', '@', $hasil);
}

function base64_decrypt($enc_text, $password, $iv_len = 16) {
    // Balikkan @ ke +
    $enc_text = str_replace('@', '+', $enc_text);
    $enc_text = base64_decode($enc_text);
    if ($enc_text === false || strlen($enc_text) < $iv_len) {
        return false;
    }

    // Ekstrak IV dan ciphertext
    $iv = substr($enc_text, 0, $iv_len);
    $ciphertext = substr($enc_text, $iv_len);

    // Kunci 256-bit dari password
    $key = hash('sha256', $password, true);

    // Dekripsi
    return openssl_decrypt($ciphertext, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
}


?>