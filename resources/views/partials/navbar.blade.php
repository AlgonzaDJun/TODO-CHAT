<div class="w-full bg-gradient-to-r from-sky-800 to-sky-900 h-14 flex items-center justify-between p-4 rounded-b-lg">
    <div class="">
        @if (Route::currentRouteName() == 'todo')
            <a class="flex items-center flex-col" href="/chat">
                <x-iconsax-bul-gameboy class="w-7 h-9 text-yellow-300" />
                <p class="m-0 p-0 text-white text-sm">chat</p>
            </a>
        @else
            <a class="flex items-center flex-col" href="/">
                <x-bx-task class="w-7 h-9 text-yellow-300" />
                <p class="m-0 p-0 text-white text-sm">To Do</p>
            </a>
        @endif

    </div>
    <a class="flex items-center flex-col" href="/profile">
        <x-css-profile class="text-yellow-400 w-7 h-9" />
        <p class="m-0 p-0 text-white text-sm text-center">profile</p>
    </a>
</div>
