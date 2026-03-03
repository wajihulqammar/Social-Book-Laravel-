<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiAIService
{
    private $apiKey;
    private $baseUrl = 'https://generativelanguage.googleapis.com/v1beta';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
    }

    /**
     * Generate content using Gemini API
     */
    public function generateContent($prompt, $context = null)
    {
        try {
            if (!$this->apiKey) {
                Log::error('Gemini API key not configured');
                return [
                    'success' => false,
                    'message' => 'API key not configured. Please check your .env file.'
                ];
            }

            $systemPrompt = "You are SocialBook AI, a friendly and helpful AI assistant. Keep responses concise and helpful.";
            
            if ($context) {
                $systemPrompt .= " Context: " . $context;
            }

            $fullPrompt = $systemPrompt . "\n\nUser: " . $prompt;

            $requestData = [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $fullPrompt
                            ]
                        ]
                    ]
                ]
            ];

            Log::info('Making Gemini API request', [
                'url' => $this->baseUrl . '/models/gemini-pro:generateContent?key=' . substr($this->apiKey, 0, 10) . '...',
                'prompt_length' => strlen($fullPrompt)
            ]);

            $response = Http::timeout(30)
                ->post($this->baseUrl . '/models/gemini-1.5-flash:generateContent?key=' . $this->apiKey, $requestData);

            Log::info('Gemini API response received', [
                'status' => $response->status(),
                'successful' => $response->successful(),
                'body_length' => strlen($response->body())
            ]);

            if (!$response->successful()) {
                Log::error('Gemini API HTTP Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'headers' => $response->headers()
                ]);

                $errorBody = $response->json();
                if (isset($errorBody['error']['message'])) {
                    return [
                        'success' => false,
                        'message' => 'API Error: ' . $errorBody['error']['message']
                    ];
                }

                return [
                    'success' => false,
                    'message' => 'API request failed with status: ' . $response->status()
                ];
            }

            $data = $response->json();
            
            Log::info('Gemini API response data', [
                'has_candidates' => isset($data['candidates']),
                'candidates_count' => isset($data['candidates']) ? count($data['candidates']) : 0,
                'response_structure' => array_keys($data)
            ]);

            if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                $responseText = $data['candidates'][0]['content']['parts'][0]['text'];
                Log::info('Successfully got AI response', ['response_length' => strlen($responseText)]);
                
                return [
                    'success' => true,
                    'message' => $responseText
                ];
            }

            // Check for safety issues or other blocks
            if (isset($data['candidates'][0]['finishReason'])) {
                $finishReason = $data['candidates'][0]['finishReason'];
                Log::warning('Response blocked', ['finish_reason' => $finishReason]);
                
                if ($finishReason === 'SAFETY') {
                    return [
                        'success' => false,
                        'message' => 'I cannot provide a response to that request due to safety guidelines.'
                    ];
                }
            }

            Log::error('Gemini API Error: Unexpected response format', ['response' => $data]);
            
            return [
                'success' => false,
                'message' => 'Unexpected response format from API'
            ];

        } catch (\Exception $e) {
            Log::error('Gemini Service Exception', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'message' => 'Service error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Generate post suggestions
     */
    public function generatePostSuggestion($userInterests = null, $mood = null)
    {
        $prompt = "Generate a creative social media post";
        
        if ($userInterests) {
            $prompt .= " about " . implode(', ', $userInterests);
        }
        
        if ($mood) {
            $prompt .= " with a " . $mood . " mood";
        }
        
        $prompt .= ". Keep it under 150 characters.";
        
        return $this->generateContent($prompt);
    }

    /**
     * Help with creative writing
     */
    public function helpWithWriting($topic, $type = 'general')
    {
        $prompts = [
            'caption' => "Help me write a social media caption about: {$topic}",
            'story' => "Help me write a short story about: {$topic}",
            'general' => "Help me write something creative about: {$topic}"
        ];

        $prompt = $prompts[$type] ?? $prompts['general'];
        
        return $this->generateContent($prompt);
    }

    /**
     * Answer general questions
     */
    public function answerQuestion($question)
    {
        return $this->generateContent($question);
    }
}