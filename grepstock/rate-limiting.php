<?php
date_default_timezone_set('Singapore'); // Set the timezone to Singapore

// Function to get the client's IP address
function getClientIP() {
    if (getenv('HTTP_CLIENT_IP')) {
        return getenv('HTTP_CLIENT_IP');
    } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
        return getenv('HTTP_X_FORWARDED_FOR');
    } elseif (getenv('HTTP_X_FORWARDED')) {
        return getenv('HTTP_X_FORWARDED');
    } elseif (getenv('HTTP_FORWARDED_FOR')) {
        return getenv('HTTP_FORWARDED_FOR');
    } elseif (getenv('HTTP_FORWARDED')) {
        return getenv('HTTP_FORWARDED');
    } elseif (getenv('REMOTE_ADDR')) {
        return getenv('REMOTE_ADDR');
    } else {
        return 'UNKNOWN';
    }
}

// Function to check rate limit
function checkRateLimit($ip, $limit = 100, $duration = 3600) {
    $sanitized_ip = str_replace(':', '-', $ip); // Replace colons with a valid character
    $filePath = "rate_limiting/" . $sanitized_ip;
    $currentData = [];

    if (file_exists($filePath)) {
        $currentData = json_decode(file_get_contents($filePath), true);
    }

    $currentTime = time();
    $count = 0;

    // Filter out requests outside the current duration
    $oldestRequestTime = null;
    foreach ($currentData as $key => $timestamp) {
        if ($timestamp < $currentTime - $duration) {
            unset($currentData[$key]);
        } else {
            $count++;
            if ($oldestRequestTime === null || $timestamp < $oldestRequestTime) {
                $oldestRequestTime = $timestamp;
            }
        }
    }

    // Save the updated data back to the file
    file_put_contents($filePath, json_encode(array_values($currentData)));

    if ($count >= $limit) {
        // Calculate the time when the user can make a new request
        $retryAfter = $oldestRequestTime + $duration - $currentTime;
        return ['allowed' => false, 'retry_after' => $retryAfter];
    }

    // Log current request
    $currentData[] = $currentTime;
    file_put_contents($filePath, json_encode(array_values($currentData)));

    return ['allowed' => true, 'retry_after' => 0];
}

// Usage
$ip = getClientIP();
$result = checkRateLimit($ip);

if (!$result['allowed']) {
    $retryDate = date('Y-m-d H:i:s', time() + $result['retry_after']);
    die("Rate limit exceeded. Please try again after " . $retryDate);
}