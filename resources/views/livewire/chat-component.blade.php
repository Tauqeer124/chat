<div>
    <!-- Header Section -->
    <div class="fixed w-full bg-green-400 h-16 pt-2 text-white flex justify-between items-center shadow-md top-0 z-50">
        <!-- Back Button -->
        <a href="/dashboard" class="ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-12 h-12 text-green-100">
                <path class="fill-current" d="M9.41 11H17a1 1 0 0 1 0 2H9.41l2.3 2.3a1 1 0 1 1-1.42 1.4l-4-4a1 1 0 0 1 0-1.4l4-4a1 1 0 0 1 1.42 1.4L9.4 11z"/>
            </svg>
        </a>
        <!-- User Name -->
        <div class="text-green-100 font-bold text-lg tracking-wide">
            {{$user->name}}
        </div>
        <!-- Options Button -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-8 h-8 text-green-100 mr-2">
            <path fill="currentColor" fill-rule="evenodd" d="M12 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/>
        </svg>
    </div>
   
    <!-- Chat Messages -->
    <div class="mt-20 mb-16 overflow-y-auto" style="padding-top: 4rem; padding-bottom: 4rem;">
        @foreach($messages as $message)
            @if($message['sender'] != auth()->user()->name)
                <div class="w-full mb-2">
                    <div class="bg-gray-300 w-3/4 mx-4 p-2 rounded-lg">
                        <b>{{$message['sender']}} :</b> {{$message['message']}}
                    </div>
                </div>
            @else
                <div class="w-full mb-2 text-right">
                    <p class="bg-green-300 inline-block mx-4 p-2 rounded-lg">
                        {{$message['message']}} <b>:You</b>
                    </p>
                </div>
            @endif
        @endforeach
    </div>
   
    <!-- Message Input Form -->
    <form wire:submit.prevent="sendMessage" class="fixed bottom-0 w-full flex bg-green-100 p-2">
        <textarea
            class="flex-grow m-2 py-2 px-4 rounded-full border border-gray-300 bg-gray-200 resize-none"
            rows="1"
            wire:model="message"
            placeholder="Message..."
            style="outline: none;"
        ></textarea>
        <button type="submit" class="m-2 text-green-400">
            <svg
                class="w-12 h-12"
                aria-hidden="true"
                focusable="false"
                data-prefix="fas"
                data-icon="paper-plane"
                role="img"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 512 512"
            >
                <path fill="currentColor" d="M476 3.2L12.5 270.6c-18.1 10.4-15.8 35.6 2.2 43.2L121 358.4l287.3-253.2c5.5-4.9 13.3 2.6 8.6 8.3L176 407v80.5c0 23.6 28.5 32.9 42.5 15.8L282 426l124.6 52.2c14.2 6 30.4-2.9 33-18.2l72-432C515 7.8 493.3-6.8 476 3.2z"/>
            </svg>
        </button>
    </form>
</div>
