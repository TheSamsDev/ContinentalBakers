<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataAnalysisController extends Controller
{
    //Option 1
   
//     public function generateSQL(Request $request)
//     {
//         // dd("a");

//         $request->validate(['message' => 'required|string']);

//         $userQuery = $request->input('message');

//         $data = [
//             'model' => 'gpt-4',
//             'messages' => [
//                 ['role' => 'system', 'content' => 'You are an expert SQL query generator for a MySQL database.'],
//                 ['role' => 'user', 'content' => "Convert this into an SQL query: $userQuery"]
//             ],
//         ];

//         $response = openaiRequest('chat/completions', $data);

//         if (isset($response['choices'][0]['message']['content'])) {
//             $generatedSQL = $response['choices'][0]['message']['content'];
//             return response()->json(['sql_query' => $generatedSQL]);
//         }

//         return response()->json(['error' => 'Failed to generate SQL query'], 500);
//     }
//     public function executeSQL(Request $request)
// {
//     $sqlQuery = $request->input('sql_query');

//     try {
//         $results = DB::select($sqlQuery);
//         return response()->json(['data' => $results]);
//     } catch (\Exception $e) {
//         return response()->json(['error' => $e->getMessage()], 400);
//     }
// }

// public function analyzeData(Request $request)
// {
//     $data = $request->input('data'); // Results from SQL query

//     $formattedData = json_encode($data); // Convert data to JSON

//     $analysisRequest = [
//         'model' => 'gpt-4',
//         'messages' => [
//             ['role' => 'system', 'content' => 'You are a data analysis assistant.'],
//             ['role' => 'user', 'content' => "Analyze this dataset and provide insights:\n$formattedData"]
//         ],
//     ];

//     $response = openaiRequest('chat/completions', $analysisRequest);

//     if (isset($response['choices'][0]['message']['content'])) {
//         $analysis = $response['choices'][0]['message']['content'];
//         return response()->json(['analysis' => $analysis]);
//     }

//     return response()->json(['error' => 'Failed to analyze data'], 500);
// }

//Option 2


    // Generate SQL, execute it, and analyze data in one flow
    public function generateAndAnalyzeData(Request $request)
    {
        // Step 1: Generate SQL query from natural language
        $request->validate(['message' => 'required|string']);
        $userQuery = $request->input('message');
        
        $data = [
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'system', 'content' => 'You are an expert SQL query generator for a MySQL database.'],
                ['role' => 'user', 'content' => "Convert this into an SQL query: $userQuery"]
            ],
        ];
    //    dd($data);
        // Send request to OpenAI to generate SQL
        $response = openaiRequest('chat/completions', $data);
        if (!isset($response['choices'][0]['message']['content'])) {
            return response()->json(['error' => 'Failed to generate SQL query'], 500);
        }

        // Clean up the response to extract the valid SQL query
        $generatedSQL = $response['choices'][0]['message']['content'];
        dd($generatedSQL);

        // Clean the response by removing explanatory text
        // Assuming the SQL query starts with "SELECT", you can clean up any extra text before it
        if (preg_match('/SELECT .*/i', $generatedSQL, $matches)) {
            $generatedSQL = $matches[0]; // Extract only the SQL query part
        } else {
            return response()->json(['error' => 'Generated query is not valid SQL'], 400);
        }


        // Step 2: Execute the SQL query against the database
        try {
            $results = DB::select($generatedSQL);
            dd($results);

        } catch (\Exception $e) {
            dd('fale');
            return response()->json(['error' => $e->getMessage()], 400);
        }
        // dd($results);

        // Step 3: Analyze the data with OpenAI
        $formattedData = json_encode($results);
        $analysisRequest = [
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a data analysis assistant.'],
                ['role' => 'user', 'content' => "Analyze this dataset and provide insights:\n$formattedData"]
            ],
        ];

        // Send the data to OpenAI for analysis
        $analysisResponse = openaiRequest('chat/completions', $analysisRequest);
        if (!isset($analysisResponse['choices'][0]['message']['content'])) {
            return response()->json(['error' => 'Failed to analyze data'], 500);
        }

        // Return the full analysis result
        $analysis = $analysisResponse['choices'][0]['message']['content'];
        return response()->json(['analysis' => $analysis]);
    }

    //option 3
    // public function generateAndAnalyzeData(Request $request)
    // {
    //     $request->validate(['message' => 'required|string']);
    //     $userMessage = $request->input('message');

    //     // Step 1: Use OpenAI to generate the response based on the user's message
    //     // We'll prompt the AI to generate a query directly without asking unnecessary questions
    //     $data = [
    //         'model' => 'gpt-4',
    //         'messages' => [
    //             ['role' => 'system', 'content' => 'You are a helpful assistant. If the user asks for data, you provide the exact SQL query to retrieve it. If the user asks anything else, respond conversationally.'],
    //             ['role' => 'user', 'content' => "Respond to: $userMessage"]
    //         ],
    //     ];

    //     // Send request to OpenAI for a conversational response or SQL generation
    //     $response = openaiRequest('chat/completions', $data);
    //     if (!isset($response['choices'][0]['message']['content'])) {
    //         return response()->json(['error' => 'Failed to generate AI response'], 500);
    //     }

    //     $aiResponse = $response['choices'][0]['message']['content'];

    //     // Step 2: Check if the AI response contains SQL-like query (e.g., "SELECT" keyword)
    //     if (strpos(strtolower($aiResponse), 'select') !== false) {
    //         // If AI's response contains a SQL query, execute it
    //         try {
    //             $results = DB::select($aiResponse);

    //             // Step 3: Analyze the data with OpenAI
    //             $formattedData = json_encode($results);
    //             $analysisRequest = [
    //                 'model' => 'gpt-4',
    //                 'messages' => [
    //                     ['role' => 'system', 'content' => 'You are a data analysis assistant.'],
    //                     ['role' => 'user', 'content' => "Analyze this dataset and provide insights:\n$formattedData"]
    //                 ],
    //             ];

    //             // Send the data to OpenAI for analysis
    //             $analysisResponse = openaiRequest('chat/completions', $analysisRequest);
    //             if (!isset($analysisResponse['choices'][0]['message']['content'])) {
    //                 return response()->json(['error' => 'Failed to analyze data'], 500);
    //             }

    //             // Return the full analysis result along with the data
    //             $analysis = $analysisResponse['choices'][0]['message']['content'];
    //             return response()->json(['data' => $results, 'analysis' => $analysis]);
    //         } catch (\Exception $e) {
    //             return response()->json(['error' => 'Failed to execute query: ' . $e->getMessage()], 400);
    //         }
    //     } else {
    //         // If no SQL query is involved, just send the AI's conversational response
    //         return response()->json(['response' => $aiResponse]);
    //     }
    // }
}
