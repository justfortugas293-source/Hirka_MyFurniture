<?php
$url = 'http://127.0.0.1:8000/login';
$email = 'admin@example.com';
$pass = 'password';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$response = curl_exec($ch);
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$header = substr($response, 0, $header_size);
$body = substr($response, $header_size);

// parse cookies
preg_match_all('/Set-Cookie: ([^;]+);/mi', $header, $cookie_matches);
$cookies = [];
if (!empty($cookie_matches[1])) {
    foreach ($cookie_matches[1] as $c) {
        $cookies[] = $c;
    }
}
$cookie_header = implode('; ', $cookies);

// parse csrf token
if (preg_match('/name="_token" value="([^"]+)"/', $body, $m)) {
    $token = $m[1];
} else {
    echo "No CSRF token found in login form\n";
    echo "Body snippet:\n" . substr($body, 0, 1000) . "\n";
    exit(1);
}

// do POST
$post = [
    '_token' => $token,
    'email' => $email,
    'password' => $pass,
    'remember' => '1'
];

curl_setopt($ch, CURLOPT_URL, 'http://localhost/login');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Cookie: $cookie_header"]);
curl_setopt($ch, CURLOPT_HEADER, true);
$response2 = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

$header_size2 = $info['header_size'];
$header2 = substr($response2, 0, $header_size2);
$body2 = substr($response2, $header_size2);

echo "REQUEST POST /login HTTP status: " . $info['http_code'] . "\n";
echo "Response headers:\n" . $header2 . "\n";
echo "Body snippet:\n" . substr($body2, 0, 1000) . "\n";
