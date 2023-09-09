<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>My First Own To Do App</title>
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="max-w-sm min-h-screen bg-sky-950  mx-auto flex flex-col">
        <div class="w-full bg-gradient-to-r from-sky-800 to-sky-900 h-14 flex items-center justify-between p-4 rounded-b-lg">
            <div class="">
                <x-iconsax-bul-gameboy class="w-7 h-9 text-yellow-300" />
                <p class="m-0 p-0 text-white text-sm">chat</p>
            </div>
            <a class="flex items-center flex-col" href="/profile">
                <x-css-profile class="text-yellow-400 w-7 h-9" />
                <p class="m-0 p-0 text-white text-sm text-center">profile</p>
            </a>
        </div>

        <div class="mx-2 my-3 flex-auto flex-col-reverse h-96 bg-slate-200 rounded-lg p-4 overflow-y-scroll">
            <ul class="w-full">
                <li class="hover:bg-sky-700 hover:rounded-md p-3 m-0 w-full flex items-center">
                    <input id="id-2" type="checkbox" value=""
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">

                    <label for="id-2" class="ml-2 text-sm font-medium text-gray-900 w-full">To do</label>

                    <input class="hidden mx-2 text-sm font-medium text-gray-900 w-full border-0 rounded-md focus:border-indigo-700" type="text" value="To do">

                    <div>
                        <x-bx-edit class=" w-6 h-6 hover:cursor-pointer" />
                        <x-bx-check class="hidden w-6 h-6 hover:cursor-pointer text-green-700" />
                    </div>

                    <div class="ml-3">
                        <x-bx-trash class="w-6 h-6 hover:cursor-pointer" />
                    </div>
                </li>


                @forelse ($todos as $item)
                    <li class="hover:bg-sky-700 hover:rounded-md p-3 m-0 w-full flex items-center">
                        <input id="id-{{ $item->id }}" type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">

                        <label for="id-{{ $item->id }}"
                            class="ml-2 text-sm font-medium text-gray-900 w-full">{{ $item->activity }}</label>

                        <div>
                            <x-bx-edit class="w-6 h-6 hover:cursor-pointer" />
                        </div>

                        <div class="ml-3">
                            <x-bx-trash class="w-6 h-6 hover:cursor-pointer" />
                        </div>
                    </li>
                @empty
                    <div class="text-lg font-medium text-center w-full h-full my-auto">Belum ada aktivitas</div>
                @endforelse

            </ul>
        </div>

        @if ($errors->any())
            <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    @foreach ($errors->all() as $error)
                        <span class="font-medium">Error!</span> {{ $error }}
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mx-2 my-2 ">
            <form action="{{ route('todo.store') }}" method="POST" class="flex gap-3">
                @csrf
                <input type="text" class="bg-sky-50 p-2 rounded-md w-full active:border-none" name="activity">
                <button type="submit" class="p-2 bg-gradient-to-l from-emerald-600 to-green-900 rounded-md text-white hover:bg-emerald-800">GO</button>
            </form>
        </div>
    </div>
</body>

</html>
