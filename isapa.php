<?php
  $id = $_GET['id'] ?? '';
  $scriptUrl = "https://script.google.com/macros/s/AKfycbyXRd8yNXQdgXAZcSGOdt_CkijD8CIY3zSz0x5h5WUdL0-qifl1ctL2fTSNulZuWASA/exec";
 

  // Fetch messages from Apps Script
  $post = [ 'action'=>'inboxRead', 'id'=>$id ];
  $ch = curl_init($scriptUrl);
  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $post
  ]);
  $raw = curl_exec($ch);
  echo "<pre>RAW RESPONSE:\n" . htmlspecialchars($raw) . "</pre>";

  if (curl_errno($ch)) {
    die("CURL Error: " . curl_error($ch));
  }
  curl_close($ch);

  $resp = json_decode($raw, true);
  if (!$resp || $resp['status'] !== 'success') {
    $err = $resp['message'] ?? 'Unknown error';
    die("API Error: " . htmlspecialchars($err));
  }

  $msgs = $resp['data']['messages'];
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thread <?= htmlspecialchars($id) ?></title>
  <!-- Flowbite for optional components -->
  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: { extend: {} },
      content: ['./**/*.php', './**/*.html'],
      plugins: [window.Flowbite]
    };
  </script>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen">
  <div class="flex justify-end p-4">
    <button id="theme-toggle" class="px-3 py-1 bg-gray-200 dark:bg-gray-700 rounded focus:outline-none">
      🌓 Toggle Theme
    </button>
  </div>

  <div class="max-w-3xl mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Conversation: Thread <?= htmlspecialchars($id) ?></h1>

    <?php foreach ($msgs as $m):
      $dt = new DateTime($m['date']);
      $formatted = $dt->format('F j, Y g:i a');
    ?>
      <div class="mb-8 p-6 bg-gray-50 dark:bg-gray-800 rounded-lg shadow">
        <p class="mb-1"><span class="font-semibold">From:</span> <?= htmlspecialchars($m['from']) ?></p>
        <p class="mb-1"><span class="font-semibold">Date:</span> <?= htmlspecialchars($formatted) ?></p>
        <p class="mb-4"><span class="font-semibold">Subject:</span> <?= htmlspecialchars($m['subject']) ?></p>

        <div class="mb-4">
          <!-- HTML body (may include inline images) -->
          <?= $m['body'] ?>
        </div>

        <?php if (!empty($m['attachments'])): ?>
          <div class="mt-4">
            <p class="font-semibold mb-2">Attachments:</p>
            <?php foreach ($m['attachments'] as $att): ?>
              <div class="mb-4">
                <p class="italic mb-1"><?= htmlspecialchars($att['name']) ?></p>
                <?php if (strpos($att['contentType'], 'image/') === 0): ?>
                  <img src="data:<?= $att['contentType'] ?>;base64,<?= $att['base64'] ?>"
                       class="max-w-full rounded" alt="<?= htmlspecialchars($att['name']) ?>">
                <?php else: ?>
                  <a download="<?= htmlspecialchars($att['name']) ?>"
                     href="data:<?= $att['contentType'] ?>;base64,<?= $att['base64'] ?>"
                     class="text-blue-600 hover:underline">
                    Download <?= htmlspecialchars($att['name']) ?>
                  </a>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>

  <script>
    document.getElementById('theme-toggle').addEventListener('click', () => {
      document.documentElement.classList.toggle('dark');
    });
  </script>
</body>
</html>
