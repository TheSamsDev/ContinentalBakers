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
            // dd("aa");
            // Step 1: Generate SQL query from natural language
            $request->validate(['message' => 'required|string']);
            $userQuery = "
            Given the following database schema:
            
            1. **Users Table**: 
            - Columns: `id`, `name`, `email`, `phone`, `address`, `state`, `zip_code`, `avatar`, `language`
            - Relationships: 
                - A user has many orders (`orders` table).
                - A user has many stores (`stores` table).
            
            2. **Stores Table**: 
            - Columns: `id`, `name`, `address`, `mainaddress`, `state`, `user_id`, `longitude`, `latitude`
            - Relationships: 
                - A store belongs to a user (`users` table).
                - A store has many orders through the `order_product` pivot table.
            
            3. **Products Table**: 
            - Columns: `id`, `brand_id`, `name`, `image`, `quantity`, `price`
            - Relationships: 
                - A product belongs to a brand (`brands` table).
                - A product has many orders through the `order_product` pivot table.
            
            4. **Orders Table**: 
            - Columns: `id`, `user_id`, `status`
            - Relationships: 
                - An order belongs to a user (`users` table).
                - An order has many products through the `order_product` pivot table.
            
            5. **Brands Table**: 
            - Columns: `id`, `name`, `logo`
            - Relationships: 
                - A brand has many products (`products` table).
            
            6. **Order_Product Pivot Table**: 
            - Columns: `order_id`, `product_id`, `quantity`, `total_price`, `brand_id`, `store_id`, `state`, `order_date`
            - Relationships: 
                - Connects `orders` and `products` tables.
            
            Generate a valid SQL query for the following request: 
            {$request->input('message')}
            ";
            // $systemPrompt = '
            // You are an expert SQL query generator for a MySQL database. 
            // The database has the following structure:

            // 1. **Products Table**: 
            //    - Columns: `id`, `name`, `price`
            //    - Relationships: 
            //      - A product has many orders through the `order_product` pivot table.

            // 2. **Orders Table**: 
            //    - Columns: `id`, `user_id`, `status`, `created_at`
            //    - Relationships: 
            //      - An order has many products through the `order_product` pivot table.

            // 3. **Stores Table**: 
            //    - Columns: `id`, `state`
            //    - Relationships: 
            //      - A store has many orders through the `order_product` pivot table.

            // 4. **Order_Product Pivot Table**: 
            //    - Columns: `order_id`, `product_id`, `quantity`, `store_id`

            // Always generate valid SQL queries based on the above schema. Do not include any explanations or extra text.
            // ';
            $systemPrompt = '
    You are an expert SQL query generator for a MySQL database. 
    The database has the following structure:

    1. **Products Table**: 
    - Columns: `id` (INT, PRIMARY KEY), `name` (VARCHAR), `price` (DECIMAL)
    - Relationships: 
        - A product has many orders through the `order_product` pivot table.

    2. **Orders Table**: 
    - Columns: `id` (INT, PRIMARY KEY), `user_id` (INT, FOREIGN KEY), `status` (VARCHAR), `created_at` (DATETIME)
    - Relationships: 
        - An order belongs to a user (`users` table).
        - An order has many products through the `order_product` pivot table.

    3. **Stores Table**: 
    - Columns: `id` (INT, PRIMARY KEY), `state` (VARCHAR)
    - Relationships: 
        - A store has many orders through the `order_product` pivot table.

    4. **Order_Product Pivot Table**: 
    - Columns: `order_id` (INT, FOREIGN KEY), `product_id` (INT, FOREIGN KEY), `quantity` (INT), `store_id` (INT, FOREIGN KEY)

    Always generate valid SQL queries based on the above schema. Do not include any explanations or extra text.
    ';
            $data = [
                'model' => 'gpt-4',
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userQuery]
                ],
            ];
            //    dd($data);
            // Send request to OpenAI to generate SQL
            $response = openaiRequest('chat/completions', $data);
            // dd($response); // Inspect the raw response

            if (!isset($response['choices'][0]['message']['content'])) {
                return response()->json(['error' => 'Failed to generate SQL query'], 500);
            }

            // Clean up the response to extract the valid SQL query
            // Extract the generated SQL query
            $generatedSQL = $response['choices'][0]['message']['content'];
            // dd($generatedSQL); // Debugging: Check the raw response
    // Prevent destructive queries
    if (preg_match('/\b(DELETE|DROP|TRUNCATE|ALTER|CREATE|UPDATE|INSERT)\b/i', $generatedSQL)) {
        return response()->json(['error' => 'Destructive or modifying queries are not allowed'], 400);
    }

            // Clean the response by removing explanatory text
            if (preg_match('/```sql\s*(SELECT.*?);?\s*```/is', $generatedSQL, $matches)) {
                $generatedSQL = $matches[1]; // Extract the query inside the ```sql block
            } elseif (preg_match('/(SELECT.*?);/is', $generatedSQL, $matches)) {
                $generatedSQL = $matches[0]; // Extract the entire SQL query
            } else {
                return response()->json(['error' => 'Generated query is not valid or incomplete SQL'], 400);
            }

            // Fix the GROUP BY issue dynamically
            if (strpos($generatedSQL, 'GROUP BY') !== false) {
                // Extract all non-aggregated columns from the SELECT clause
                preg_match('/SELECT\s+(.*?)\s+FROM/i', $generatedSQL, $selectMatches);
                if (isset($selectMatches[1])) {
                    $selectColumns = array_map('trim', explode(',', $selectMatches[1]));

                    // Filter out aggregated columns (e.g., SUM, COUNT, AVG, etc.)
                    $nonAggregatedColumns = [];
                    foreach ($selectColumns as $column) {
                        if (!preg_match('/\b(SUM|COUNT|AVG|MIN|MAX)\s*\(/i', $column)) {
                            // Extract the column name (e.g., "p.name AS product_name" -> "p.name")
                            preg_match('/([\w\.]+)(\s+AS\s+\w+)?/i', $column, $columnMatches);
                            if (isset($columnMatches[1])) {
                                $nonAggregatedColumns[] = $columnMatches[1];
                            }
                        }
                    }

                    // Add non-aggregated columns to the GROUP BY clause
                    if (!empty($nonAggregatedColumns)) {
                        $groupByColumns = implode(', ', $nonAggregatedColumns);
                        $generatedSQL = preg_replace('/GROUP BY\s+(.*?)(\s+ORDER BY|\s*;)/i', 'GROUP BY $1, ' . $groupByColumns . ' $2', $generatedSQL);
                    }
                }
            }

        
            // Execute the SQL query
            try {
                $results = DB::select($generatedSQL);
                return response()->json(['analysis' => $results]);
            } catch (\Exception $e) {
                // Log the error
                // Log::error('Query failed: ' . $e->getMessage());
            
                // Return a user-friendly error message
                return response()->json(['error' => 'Query failed. Please try again or rephrase your request.'], 400);
            }
            if (
                stripos($generatedSQL, 'DELETE') !== false ||
                stripos($generatedSQL, 'DROP') !== false ||
                stripos($generatedSQL, 'TRUNCATE') !== false
            ) {
                return response()->json(['error' => 'Destructive queries are not allowed'], 400);
            }
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

    // FOr Optional 
    // public function generateAndAnalyzeData(Request $request)
    // {
    //     // Step 1: Generate SQL query from natural language
    //     $request->validate(['message' => 'required|string']);
    //     $userQuery = $request->input('message');

    //     $data = [
    //         'model' => 'gpt-4',
    //         'messages' => [
    //             ['role' => 'system', 'content' => 'You are an expert SQL query generator for a MySQL database.'],
    //             ['role' => 'user', 'content' => "Convert this into an SQL query: $userQuery"]
    //         ],
    //     ];
    // //    dd($data);
    //     // Send request to OpenAI to generate SQL
    //     $response = openaiRequest('chat/completions', $data);
    //     if (!isset($response['choices'][0]['message']['content'])) {
    //         return response()->json(['error' => 'Failed to generate SQL query'], 500);
    //     }

    //     // Clean up the response to extract the valid SQL query
    //     $generatedSQL = $response['choices'][0]['message']['content'];
    //     // dd($generatedSQL);

    //     // Clean the response by removing explanatory text
    //     // Assuming the SQL query starts with "SELECT", you can clean up any extra text before it
    //     if (preg_match('/SELECT .*/i', $generatedSQL, $matches)) {
    //         $generatedSQL = $matches[0]; // Extract only the SQL query part
    //     } else {
    //         return response()->json(['error' => 'Generated query is not valid SQL'], 400);
    //     }


    //     // Step 2: Execute the SQL query against the database
    //     try {
    //         $results = DB::select($generatedSQL);
    //         dd($results);

    //     } catch (\Exception $e) {
    //         dd('fale');
    //         return response()->json(['error' => $e->getMessage()], 400);
    //     }
    //     // dd($results);

    //     // Step 3: Analyze the data with OpenAI
    //     $formattedData = json_encode($results);
    //     $analysisRequest = [
    //         'model' => 'gpt-4',
    //         'messages' => [
    //             ['role' => 'system', 'content' => 'You are a data analysis assistant.'],
    //             ['role' => 'user', 'content' => "Analyze this dataset and provide insights:\n$formattedData"]
    //         ],
    //     ];

    //     // Send the data to OpenAI for analysis
    //     $analysisResponse = openaiRequest('chat/completions', $analysisRequest);
    //     if (!isset($analysisResponse['choices'][0]['message']['content'])) {
    //         return response()->json(['error' => 'Failed to analyze data'], 500);
    //     }

    //     // Return the full analysis result
    //     $analysis = $analysisResponse['choices'][0]['message']['content'];
    //     return response()->json(['analysis' => $analysis]);
    // }
}
