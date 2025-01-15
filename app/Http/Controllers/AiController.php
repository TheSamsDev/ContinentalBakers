<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AIController extends Controller
{
    public function sendMessage(Request $request)
    {
        dd("a");
        $request->validate(['message' => 'required|string']);
        $userMessage = $request->input('message');
    
        // Log the user's message
        // \Log::info('User message:', ['message' => $userMessage]);
    
        $response = $this->callDeepSeekAPI($userMessage);
    
        // Log the API response
        // \Log::info('API response:', ['response' => $response]);
    
        return response()->json(['response' => $response]);
    }

    private function callDeepSeekAPI($message)
    {
        $apiKey = config('services.deepseek.api_key');
        $apiUrl = 'https://api.deepseek.com/v1/chat'; 
        //  dd($apiKey);
        $payload = [
            'model' => 'deepseek/deepseek-chat',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                ['role' => 'user', 'content' => $message],
            ],
        ];
        // dd($payload);
    
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->post($apiUrl, $payload);
            dd($response);

        if ($response->successful()) {
            return response()->json([
                'response' => $response->json()['choices'][0]['message']['content'],
            ]);
        } else {
            return response()->json([
                'error' => 'API request failed',
                'status' => $response->status(),
                'details' => $response->json(),
            ], $response->status());
        }
    }
}