<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('User Avatar') }}
        </h2>
    </header>

    <img width="50" height="50" src="{{ "/storage/avatars/$user->id/$user->avatar" }}" alt="user avatar"
        class="rounded-full">

    <form action="{{ route('profile.avatar.ai') }}" method="post" class="mt-4">
        @csrf

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Generate avatar from Ai
        </p>
        <x-primary-button>Generate Avatar</x-primary-button>
    </form>


    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        {{ __('or') }}
    </p>



    @if (session('message'))
        <div class="text-red-500">
            {{ session('message') }}
        </div>
    @endif

    <form method="post" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" >
        @method('patch')
        @csrf

        {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
        <div>
            <x-input-label for="avatar" value="Upload Avatar from Computer" />
            <x-text-input id="avatar" name="avatar" type="file" class="mt-1 block w-full" :value="old('avatar', $user->avatar)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>



        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
