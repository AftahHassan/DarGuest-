<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Notifications</h2>
            <form method="POST" action="{{ route('notifications.read-all') }}">
                @csrf
                <button class="text-sm text-indigo-600">Tout marquer comme lu</button>
            </form>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded shadow divide-y">
                @forelse ($notifications as $notification)
                    <div class="p-4 flex justify-between items-start {{ $notification->is_read ? '' : 'bg-indigo-50' }}">
                        <div>
                            <p class="font-medium text-sm
                                @if($notification->type === 'emergency') text-red-600 @endif">
                                {{ $notification->title }}
                            </p>
                            <p class="text-sm text-gray-600 mt-1">{{ $notification->content }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                        @unless ($notification->is_read)
                            <form method="POST" action="{{ route('notifications.read', $notification) }}">
                                @csrf
                                <button class="text-xs text-indigo-600">Marquer comme lu</button>
                            </form>
                        @endunless
                    </div>
                @empty
                    <p class="p-6 text-sm text-gray-500 text-center">Aucune notification.</p>
                @endforelse
            </div>
            {{ $notifications->links() }}
        </div>
    </div>
</x-app-layout>