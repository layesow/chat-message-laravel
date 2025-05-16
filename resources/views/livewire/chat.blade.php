<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Chat') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage your profile and account settings') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div class="flex h-[550px] text-sm border rounded-xl shadow-lg overflow-hidden bg-white">
        {{-- Left: User List --}}
        <div class="w-1/4 border-r bg-gradient-to-b from-gray-50 to-gray-100">
            <div class="p-4 font-bold text-gray-700 border-b text-center bg-white shadow-sm">👥 Utilisateurs</div>
            <div class="divide-y">
                @foreach ($users as $user)
                    <div wire:click="selectUser({{ $user->id }})" class="p-4 cursor-pointer hover:bg-blue-100 transition rounded-md mx-2 mt-2 {{ $selectedUser->id === $user->id ? 'bg-blue-100' : '' }}">
                        <div class="text-gray-800 font-medium">{{ $user->name }}</div>
                        <div class="text-xs text-gray-500">{{ $user->email }}</div>
                    </div>
                @endforeach

            </div>
        </div>

        {{-- Right: Chat Area --}}
        <div class="w-3/4 flex flex-col">
            <!-- Header -->
            <div class="p-4 border-b bg-gray-50 flex items-center justify-between">
                <div>
                    <div class="text-lg font-semibold text-gray-800">{{ $selectedUser->name }}</div>
                    <div class="text-xs text-gray-500">{{ $selectedUser->email }}</div>
                </div>
                <div class="text-xs text-gray-400 italic">En ligne</div>
            </div>

            <!-- Messages -->
            <div class="flex-1 p-4 overflow-y-auto space-y-2 bg-gray-100">
                @foreach ($messages as $message)
                    <div class="flex {{ $message->sender_id === auth()->user()->id ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-xs px-4 py-2 rounded-2xl shadow {{ $message->sender_id === auth()->user()->id ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' }}">
                            {{ $message->message }}
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- Input Area -->
            <form wire:submit='submit' class="p-4 border-t bg-white flex items-center gap-3">
                <input
                    wire:model="newMessage"
                    type="text"
                    class="flex-1 border border-gray-300 rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Type your message..."
                />
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-6 py-2 rounded-full transition-all shadow"
                >
                    Envoyer
                </button>
            </form>
        </div>
    </div>
</div>
