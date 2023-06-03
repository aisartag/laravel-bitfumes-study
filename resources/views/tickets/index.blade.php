<x-app-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="flex flex-col justify-between items-center w-full sm:max-w-xl">
            <h1 class="text-black dark:text-white text-lg font-bold">Support Tickets</h1>
            <a href="{{ route('tickets.create') }}" class="bg-black text-white dark:bg-white rounded-lg  py-2 px-4">Create
                New</a>
        </div>
        <div
            class="w-full sm:max-w-xl mt-6 p-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            @forelse ($tickets as $ticket)
                <div class="dark:text-white flex justify-between py-4">
                    <a href="{{ route('tickets.show', $ticket->id) }}">{{ $ticket->title }}</a>
                    <p>{{ $ticket->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <p>You don't have any support ticket yet.</p>
            @endforelse
        </div>

    </div>

</x-app-layout>
