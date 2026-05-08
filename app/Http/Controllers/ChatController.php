<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\ChatMessage;
use App\Models\ChatSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function history()
    {
        $session = ChatSession::where('user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        if (!$session) {
            return response()->json(['messages' => []]);
        }

        return response()->json([
            'messages' => $session->messages()->orderBy('created_at', 'asc')->get()
        ]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $user = Auth::user();

        // Find or create an active chat session
        $session = ChatSession::firstOrCreate(
            ['user_id' => $user->id, 'status' => 'active']
        );

        // 1. Save user message
        $userMessage = $session->messages()->create([
            'sender' => 'user',
            'content' => $request->message
        ]);

        // 2. Broadcast user message (in case they have multiple tabs open)
        try {
            broadcast(new MessageSent($userMessage))->toOthers();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Websocket broadcast failed', ['error' => $e->getMessage()]);
        }

        // 3. Generate Gemini AI Response
        $aiContent = $this->generateGeminiResponse($user->name, $session);

        // 4. Save AI Response
        $aiMessage = $session->messages()->create([
            'sender' => 'ai',
            'content' => $aiContent
        ]);

        // 5. Broadcast AI Response back to user
        try {
            broadcast(new MessageSent($aiMessage));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Websocket broadcast failed', ['error' => $e->getMessage()]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Message sent and processed',
            'ai_message' => $aiMessage->content,
            'message_id' => $aiMessage->id
        ]);
    }

    /**
     * Call the Gemini API to generate an intelligent response based on the conversation history.
     */
    private function generateGeminiResponse($userName, $session)
    {
        $apiKey = env('GEMINI_API_KEY');

        if (empty($apiKey)) {
            return "The Gemini API key is missing. Please configure GEMINI_API_KEY in the .env file.";
        }

        // Fetch recent chat history for context (limit to last 15 messages to save tokens)
        $history = $session->messages()->orderBy('created_at', 'asc')->take(15)->get();

        $contents = [];
        foreach ($history as $msg) {
            $role = $msg->sender === 'ai' ? 'model' : 'user';
            $contents[] = [
                'role' => $role,
                'parts' => [['text' => $msg->content]]
            ];
        }

        $systemPrompt = "You are the InsureMate Assistant, a helpful customer support AI for an insurance company named InsureMate. The customer you are speaking with is named {$userName}. You can help them with claims, policies, and billing queries. Be concise, polite, and directly address their needs.";

        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->withoutVerifying()->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                        'system_instruction' => [
                            'parts' => [
                                'text' => $systemPrompt
                            ]
                        ],
                        'contents' => $contents,
                        'generationConfig' => [
                            'temperature' => 0.7,
                            'maxOutputTokens' => 250,
                        ]
                    ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    return $data['candidates'][0]['content']['parts'][0]['text'];
                }
            }

            \Illuminate\Support\Facades\Log::error('Gemini API Error', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);
            return "I'm experiencing a temporary issue analyzing your request. Please try again in a moment.";

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gemini API Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return "I'm having trouble connecting to my servers right now. Can you try again later?";
        }
    }
}
