<?php
// --- Configuration ---
$scriptUrl = 'https://script.google.com/macros/s/AKfycbyIApRIJCCFTSSWJr57j6aU_uZ_o6o1YyGvBTclTVhlvOtQz6t3qskRSsQb5GLXn15t/exec';
$fetchLimit = 30;
$fetchOffset = 0;

// --- Data Fetching ---
$error_message = null; // Variable to hold potential errors
$inboxes = [];       // Default to empty array

$postData = http_build_query([
    'action' => 'inboxList',
    'limit'  => $fetchLimit,
    'offset' => $fetchOffset,
]);

$ch = curl_init($scriptUrl);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,         // Return response as string
    CURLOPT_FOLLOWLOCATION => true,         // Follow redirects
    CURLOPT_SSL_VERIFYPEER => true,          // ****** CRITICAL: Always verify SSL ******
    // CURLOPT_CAINFO => '/path/to/your/cacert.pem', // Uncomment and set path if needed for specific environments
    CURLOPT_POST           => true,         // Use POST method
    CURLOPT_POSTFIELDS     => $postData,    // Set POST data
    CURLOPT_TIMEOUT        => 30,           // Set a timeout (e.g., 30 seconds)
]);

$raw = curl_exec($ch);
$err = curl_error($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get HTTP status code
curl_close($ch);

if ($err) {
    $error_message = "cURL Error: " . htmlspecialchars($err);
} elseif ($http_code >= 400) {
     $error_message = "HTTP Error: Received status code " . htmlspecialchars($http_code);
} else {
    $result = json_decode($raw, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $error_message = "JSON Decode Error: " . json_last_error_msg();
    } elseif (!$result || !isset($result['status'])) {
         $error_message = "API Error: Invalid response format received.";
    } elseif ($result['status'] !== 'success') {
        $msg = $result['message'] ?? 'Unknown API error';
        $error_message = "API Error: " . htmlspecialchars($msg);
    } elseif (!isset($result['data']) || !is_array($result['data'])) {
         $error_message = "API Error: Invalid data format received.";
    } else {
        // Success! Assign data
        $inboxes = $result['data'];
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="dark"> {/* Consider starting without 'dark' unless it's the default preference */}
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gmail Inbox</title>
    {/* Use specific Flowbite version if needed, or latest */}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@latest/dist/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Tailwind config - consider moving to a separate tailwind.config.js for build processes
        tailwind.config = {
            darkMode: 'class',
            content: ['./**/*.php', './**/*.html'], // Adjust paths as needed
            theme: {
                extend: {}
            },
            plugins: [
                // Ensure Flowbite plugin is correctly initialized if needed via JS
                // window.Flowbite // Often Flowbite relies on data attributes
            ],
        }

        // Theme toggle logic (consider saving preference to localStorage)
        document.addEventListener('DOMContentLoaded', () => {
            const themeToggleBtn = document.getElementById('theme-toggle');
            const htmlElement = document.documentElement;

            // Function to apply theme
            const applyTheme = (theme) => {
                if (theme === 'dark') {
                    htmlElement.classList.add('dark');
                } else {
                    htmlElement.classList.remove('dark');
                }
            };

             // Load saved theme preference
             const savedTheme = localStorage.getItem('theme') || 'dark'; // Default to dark or system preference
             applyTheme(savedTheme);


            themeToggleBtn.addEventListener('click', () => {
                 const isDark = htmlElement.classList.toggle('dark');
                 const newTheme = isDark ? 'dark' : 'light';
                 localStorage.setItem('theme', newTheme); // Save preference
                 applyTheme(newTheme);
            });
        });
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" /> {/* Ensure Flowbite CSS is included */}

</head>
<body class="bg-white dark:bg-gray-900 transition-colors duration-300 text-gray-900 dark:text-gray-100 min-h-screen">
    {/* Header / Theme Toggle */}
    <header class="sticky top-0 z-50 bg-white dark:bg-gray-800 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <h1 class="text-xl font-semibold">Gmail Inbox</h1>
            <button id="theme-toggle" type="button" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 text-sm">
                <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 5.05a1 1 0 00-1.414 1.414l.707.707a1 1 0 001.414-1.414l-.707-.707zM3 11a1 1 0 100-2H2a1 1 0 100 2h1zM11 17a1 1 0 10-2 0v1a1 1 0 102 0v-1zm2.828-2.828a1 1 0 00-1.414 1.414l.707.707a1 1 0 001.414-1.414l-.707-.707z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Toggle theme</span>
             </button>
        </div>
    </header>
    {/* Main Content Area */}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <?php if ($error_message): ?>
            {/* Display Error Message */}
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline"><?= $error_message ?></span>
            </div>
        <?php elseif (empty($inboxes)): ?>
             {/* Display Message when no emails are found */}
             <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Info:</strong>
                <span class="block sm:inline">No inbox messages found or returned by the API.</span>
            </div>
        <?php else: ?>
            {/* Display Inbox Table */}
            <div class="overflow-x-auto shadow-md rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Sender</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subject</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php foreach ($inboxes as $inbox):
                            // Sanitize data for output
                            $name     = htmlspecialchars($inbox['name'] ?? 'N/A');
                            $email    = htmlspecialchars($inbox['email'] ?? '');
                            $primary  = htmlspecialchars($inbox['profilePicUrl'] ?? '');
                            $fallback = 'https://ui-avatars.com/api/?name=' . rawurlencode($name) . '&size=40&background=random&color=fff'; // Added random bg
                            $subject  = htmlspecialchars($inbox['subject'] ?? '(No Subject)');
                            $date_str = htmlspecialchars($inbox['date'] ?? '');
                            $id       = urlencode($inbox['id'] ?? '');

                            // Attempt to format date nicely
                            $formatted_date = $date_str;
                            try {
                                $date_obj = new DateTime($date_str);
                                // Example Format: Apr 18, 2025 12:57 PM
                                $formatted_date = $date_obj->format('M d, Y g:i A');
                            } catch (Exception $e) {
                                // Keep original string if formatting fails
                            }
                        ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                            {/* Sender + avatar */}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                <div class="flex items-center space-x-3">
                                    <img
                                        src="<?= $primary ?>"
                                        alt="Avatar of <?= $name ?>"
                                        class="h-8 w-8 rounded-full flex-shrink-0 object-cover"
                                        onerror="this.onerror=null; this.src='<?= $fallback ?>';"
                                        loading="lazy" /* Add lazy loading */
                                    >
                                    <span><?= $name ?></span>
                                </div>
                            </td>

                            {/* Email */}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                <?php if ($email): ?>
                                <a href="mailto:<?= $email ?>" class="text-blue-600 dark:text-blue-400 hover:underline">
                                    <?= $email ?>
                                </a>
                                <?php endif; ?>
                            </td>

                            {/* Subject */}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                <?php if ($id): ?>
                                <a href="isapa.php?id=<?= $id ?>" class="hover:underline"> {/* Link to detail page */}
                                    <?= $subject ?>
                                </a>
                                <?php else: ?>
                                    <?= $subject ?>
                                <?php endif; ?>
                            </td>

                            {/* Date */}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300"><?= $formatted_date ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

    </main>

    {/* Footer Optional */}
    <footer class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 mt-8 text-center text-gray-500 dark:text-gray-400 text-xs">
        Inbox powered by Google Apps Script
    </footer>

    {/* Flowbite JS (already included in head) */}
</body>
</html>