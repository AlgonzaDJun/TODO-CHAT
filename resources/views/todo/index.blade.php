@extends('layouts.main')

@section('body')
    <div class="mx-2 my-3 flex-auto flex-col-reverse h-44 bg-slate-200 rounded-lg p-4 overflow-y-scroll">
        <ul class="w-full" id="todos">

            @forelse ($todos as $item)
                <li class="hover:bg-sky-700 hover:rounded-md p-3 m-0 w-full flex items-center" id="{{ $item->id }}">
                    <input onchange="checkedTodo({{ $item->id }})" id="id-{{ $item->id }}" type="checkbox"
                        {{ $item->done === 1 ? 'checked' : '' }} value=""
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">

                    <label for="id-{{ $item->id }}"
                        class="ml-2 text-sm font-medium text-gray-900 w-full">{{ $item->activity }}
                    </label>

                    <input
                        class="hidden mx-2 text-sm font-medium text-gray-900 w-full border-0 rounded-md focus:border-indigo-700"
                        id="input-{{ $item->id }}" type="text" value="{{ $item->activity }}">

                    <div class="flex">
                        <x-bx-edit class="w-6 h-6 hover:cursor-pointer" onclick="ubahTodo({{ $item->id }})"
                            id="edit-{{ $item->id }}" />

                        <form action="{{ route('todo.update', $item->id) }}" method="POST"
                            id="update-{{ $item->id }}" class="">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="activity" id="activity-edit-{{ $item->id }}" value="">
                            <button type="button" onclick="updateTodo({{ $item->id }})">
                                <x-bx-check class="hidden w-6 h-6 hover:cursor-pointer text-green-700"
                                    id="check-{{ $item->id }}" />
                            </button>
                        </form>

                    </div>

                    <form class="ml-3 flex" action="{{ route('todo.destroy', $item->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="confirm-button">
                            <x-bx-trash class="w-6 h-6" />
                        </button>

                    </form>
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
            <button type="submit"
                class="p-2 bg-gradient-to-l from-emerald-600 to-green-900 rounded-md text-white hover:bg-emerald-800">GO</button>
        </form>
    </div>
@endsection


@push('footer-script')
    <script type="text/javascript" src="{{ url('js/todo-index.js') }}"></script>
@endpush
