<?php

if (!function_exists('openaiRequest')) {
    /**
     * Make a request to OpenAI API.
     *
     * @param string $endpoint The API endpoint (e.g., 'chat/completions').
     * @param array $data The data to send in the request body.
     * @return array|string The response from OpenAI API or an error message.
     */
    function openaiRequest($endpoint, $data)
    {
        $url = "https://api.openai.com/v1/$endpoint";
        $apiKey = config('services.openai.ai_api_key');

        $headers = [
            "Authorization: Bearer $apiKey",
            "Content-Type: application/json",
        ];

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15); // Timeout after 15 seconds

        $response = curl_exec($ch);
        $error = curl_errno($ch) ? curl_error($ch) : null;

        curl_close($ch);

        if ($error) {
            return ['error' => $error];
        }

        return json_decode($response, true);
    }
}
