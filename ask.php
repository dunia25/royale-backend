<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

$userInput = $_GET['q'] ?? '';

if (!$userInput) {
  echo json_encode(['error' => '⚠️ لم يتم تلقي أي سؤال.']);
  exit;
}

$data = [
  "model" => "meta-llama/llama-4-maverick:free",
  "messages" => [
    ["role" => "system", "content" => "أنت مساعد ذكي للجمال والصحة بلغة عربية لبقة."],
    ["role" => "user", "content" => $userInput]
  ]
];

$options = [
  'http' => [
    'header'  => [
      "Authorization: Bearer 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",
      "Content-Type: application/json",
      "X-Title: Royale Assistant"
    ],
    'method'  => 'POST',
    'content' => json_encode($data)
  ]
];

$context  = stream_context_create($options);
$result = file_get_contents("https://openrouter.ai/api/v1/chat/completions", false, $context);

echo $result ?: json_encode(['error' => '❌ لم يتم تلقي استجابة.']);