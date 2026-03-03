<?php

namespace App\Http\Controllers;

use App\Services\GeminiAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AIController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiAIService $geminiService)
    {
        $this->geminiService = $geminiService;
        $this->middleware('auth');
    }

    /**
     * Show AI chat interface
     */
    public function index()
    {
        return view('ai.chat');
    }

    /**
     * Handle AI chat messages
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $userMessage = $request->input('message');
        $context = "User: " . auth()->user()->first_name . " " . auth()->user()->last_name;
        
        // Log the request for debugging
        Log::info('AI Chat Request', [
            'user' => auth()->user()->id,
            'message' => $userMessage
        ]);

        $response = $this->geminiService->generateContent($userMessage, $context);

        // Log the response for debugging
        Log::info('AI Chat Response', [
            'user' => auth()->user()->id,
            'success' => $response['success'],
            'response_length' => isset($response['message']) ? strlen($response['message']) : 0
        ]);

        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'],
            'timestamp' => now()->format('H:i')
        ]);
    }

    /**
     * Generate post suggestions
     */
    public function generatePost(Request $request)
    {
        $request->validate([
            'mood' => 'nullable|string|max:50',
            'topic' => 'nullable|string|max:100'
        ]);

        $mood = $request->input('mood');
        $topic = $request->input('topic');
        
        $prompt = "Generate a creative social media post";
        if ($topic) {
            $prompt .= " about " . $topic;
        }
        if ($mood) {
            $prompt .= " with a " . $mood . " mood";
        }
        $prompt .= ". Keep it engaging and under 200 characters.";

        $response = $this->geminiService->generateContent($prompt);

        return response()->json($response);
    }

    /**
     * Help with creative writing
     */
    public function helpWriting(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:200',
            'type' => 'in:caption,story,general'
        ]);

        $topic = $request->input('topic');
        $type = $request->input('type', 'general');

        $response = $this->geminiService->helpWithWriting($topic, $type);

        return response()->json($response);
    }
}