<?php
// reCAPTCHA Secret Key
$secret = "6Lf7JV8rAAAAAGQWtNsspu_IEZHI-zfE9-shgvmy";

// ইউজার response
$response = $_POST['g-recaptcha-response'] ?? '';
$remoteip = $_SERVER['REMOTE_ADDR'];

// যদি response না থাকে
if (empty($response)) {
    $_SESSION['error'] = "Please complete the reCAPTCHA.";
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

// Google API URL
$verifyURL = 'https://www.google.com/recaptcha/api/siteverify';
$data = [
    'secret' => $secret,
    'response' => $response,
    'remoteip' => $remoteip
];

// HTTP context তৈরি
$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
        'timeout' => 10
    ]
];

$context = stream_context_create($options);
$result = file_get_contents($verifyURL, false, $context);

// যদি API call fail করে
if ($result === false) {
    $_SESSION['error'] = "reCAPTCHA request failed. Try again.";
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

$resultJson = json_decode($result, true);

// ✅ reCAPTCHA Passed
if (!empty($resultJson['success']) && $resultJson['success'] === true) {
    // Allow form submission to continue
    return;
} else {
    $_SESSION['error'] = "reCAPTCHA verification failed. Try again.";
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>
