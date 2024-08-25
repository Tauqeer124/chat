<?php
namespace App\Livewire;

use Log;
use App\Models\User;
use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Events\MessageSendEvent;

class ChatComponent extends Component
{
    public $user;
    public $message = '';
    public $sender_id;
    public $receiver_id;
    public $messages = [];

    // Use the mount method to pass in the user_id
    public function mount($user_id)
    {
        // Set sender and receiver IDs
        $this->sender_id = auth()->user()->id;
        $this->receiver_id = $user_id;
        $this->listeners = [
            'listenForMessage' => 'listenForMessage',
        ];

        // Retrieve messages between sender and receiver
        $messages = Message::where(function($query) {
            $query->where('sender_id', $this->sender_id)
                  ->where('receiver_id', $this->receiver_id);
        })->orWhere(function($query) {
            $query->where('sender_id', $this->receiver_id)
                  ->where('receiver_id', $this->sender_id);
        })
        ->with('sender:id,name', 'receiver:id,name')
        ->get();

        // Append messages to the component's state
        foreach ($messages as $message) {
            $this->appendchatMessages($message);
        }

        // Load user details
        $this->user = User::findOrFail($user_id);
    }

    // Method to send a message
    public function sendMessage()
    {
        // Create a new chat message
        $chatMessage = new Message();
        $chatMessage->sender_id = $this->sender_id;
        $chatMessage->receiver_id = $this->receiver_id;
        $chatMessage->message = $this->message;
        $chatMessage->save();

        // Append the new message to the component's state
        $this->appendchatMessages($chatMessage);

        // Broadcast the message
        broadcast(new MessageSendEvent($chatMessage))->toOthers();

        // Clear the input field
        $this->message = '';
    }

    // Method to handle incoming messages
    #[On('echo-private:chat-channel.{sender_id},MessageSendEvent')]
    public function listenForMessage($event) 
    {
        
        // Retrieve the message from the event
        $nchatMessage = Message::whereId($event['id'])
            ->with('sender:id,name', 'receiver:id,name')
            ->first();

        // Append the new message to the component's state
        if ($nchatMessage) {
            $this->appendchatMessages($nchatMessage);
       
        }
    }

    // Method to render the Livewire component view
    public function render()
    {
        return view('livewire.chat-component', [
            'user' => $this->user,
        ]);
    }

    // Helper method to append messages to the state
    public function appendchatMessages($message)
    {
        $this->messages[] = [
            'id' => $message->id,
            'message' => $message->message,
            'sender' => $message->sender->name,
            'receiver' => $message->receiver->name,
        ];
    }
}
