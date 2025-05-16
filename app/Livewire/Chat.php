<?php

namespace App\Livewire;

use App\Models\ChatMessage;
use App\Models\User;
use Livewire\Component;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    public $users ;
    public $selectedUser;
    public $newMessage;
    public $messages;


    public function mount(){
        $this->users = User::whereNot('id',Auth::id())->latest()->get();
        $this->selectedUser = $this->users->first();
        $this->loadMessages();

    }
    public function selectUser($Id)
    {
        $this->selectedUser = User::find($Id);
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = ChatMessage::query()
                ->where(function($q){
                    $q->where('sender_id',Auth::id())
                          ->Where('receiver_id', $this->selectedUser->id);
                })->orwhere(function($q){
                    $q->where('sender_id', $this->selectedUser->id)
                          ->Where('receiver_id', Auth::id());
                })->get();
    }

    //submit message
    public function submit()
    {
        if(!$this->newMessage){
            return;
        }
        $message = ChatMessage::create([
            "sender_id" => Auth::id(),
            "receiver_id" => $this->selectedUser->id,
            "message" => $this->newMessage,
        ]);
        $this->messages->push($message);

        $this->newMessage = '';
    }




    public function render()
    {
        return view('livewire.chat');
    }
}
