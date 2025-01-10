<?php
/**
 * Set a flash message to be displayed on the next page load
 * 
 * @param string $type The type of message (success, error, warning, info)
 * @param string $message The message to display
 */
function setFlashMessage($type, $message) {
    if (!isset($_SESSION['flash_messages'])) {
        $_SESSION['flash_messages'] = [];
    }
    $_SESSION['flash_messages'][] = [
        'type' => $type,
        'message' => $message
    ];
}

/**
 * Display and clear any flash messages
 */
function displayFlashMessages() {
    if (isset($_SESSION['flash_messages']) && !empty($_SESSION['flash_messages'])) {
        foreach ($_SESSION['flash_messages'] as $message) {
            $alertClass = match($message['type']) {
                'success' => 'alert-success',
                'error' => 'alert-danger',
                'warning' => 'alert-warning',
                'info' => 'alert-info',
                default => 'alert-secondary'
            };
            echo "<div class='alert {$alertClass} alert-dismissible fade show' role='alert'>";
            echo htmlspecialchars($message['message']);
            echo "<button type='button' class='btn-close' data-bs-dismiss='alert'></button>";
            echo "</div>";
        }
        // Clear the flash messages
        $_SESSION['flash_messages'] = [];
    }
}

/**
 * Handle file upload
 * 
 * @param array $file The uploaded file ($_FILES array element)
 * @param string $directory The target directory
 * @return string|false The path to the uploaded file or false on failure
 */
function handleFileUpload($file, $directory) {
    $upload_dir = __DIR__ . '/uploads/' . $directory . '/';
    
    // Create directory if it doesn't exist
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $extension;
    $filepath = $upload_dir . $filename;
    
    // Validate file type
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array(strtolower($extension), $allowed_types)) {
        throw new Exception('Type de fichier non autorisé');
    }
    
    // Validate file size (max 5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        throw new Exception('Le fichier est trop volumineux (max 5MB)');
    }
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return $directory . '/' . $filename;
    }
    
    return false;
}

/**
 * Format a number as currency
 * 
 * @param float $amount The amount to format
 * @param string $currency The currency symbol (default: €)
 * @return string Formatted amount
 */
function formatCurrency($amount, $currency = '€') {
    return number_format($amount, 2, ',', ' ') . ' ' . $currency;
}

/**
 * Format a date in French format
 * 
 * @param string $date The date to format
 * @param bool $withTime Include time in the output
 * @return string Formatted date
 */
function formatDate($date, $withTime = false) {
    $format = $withTime ? 'd/m/Y H:i' : 'd/m/Y';
    return date($format, strtotime($date));
}

/**
 * Sanitize a string for output
 * 
 * @param string $string The string to sanitize
 * @return string Sanitized string
 */
function sanitizeOutput($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Check if user has required permission
 * 
 * @param string $permission The permission to check
 * @return bool True if user has permission, false otherwise
 */
function hasPermission($permission) {
    // Implement your permission checking logic here
    return isset($_SESSION['user_permissions']) && 
           in_array($permission, $_SESSION['user_permissions']);
}

/**
 * Log an action in the system
 * 
 * @param string $action The action performed
 * @param array $data Additional data to log
 */
function logAction($action, $data = []) {
    $log = [
        'timestamp' => date('Y-m-d H:i:s'),
        'user_id' => $_SESSION['user_id'] ?? null,
        'action' => $action,
        'data' => json_encode($data),
        'ip' => $_SERVER['REMOTE_ADDR']
    ];
    
    // Implement your logging logic here (database, file, etc.)
}