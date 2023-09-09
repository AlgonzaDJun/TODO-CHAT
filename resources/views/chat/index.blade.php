@extends('layouts.main')

@push('css')
    {{-- <link rel="stylesheet" href="{{ url('css/chat.css') }}"> --}}
@endpush

@section('body')
    <section class="flex flex-col flex-auto justify-center antialiased bg-gray-50 text-gray-600 p-3 my-10 rounded-md">
        <div class="">
            <!-- Card -->
            <div class="relative mx-auto bg-white shadow-lg rounded-lg">
                <!-- Card header -->
                <header class="pt-6 pb-4 px-5 border-b border-gray-200">
                    <div class="flex justify-between items-center mb-3">
                        <!-- Image + name -->
                        <div class="flex items-center">
                            <a class="inline-flex items-start mr-3" href="#0">
                                <img class="rounded-full"
                                    src="https://ui-avatars.com/api/?name={{ Auth::user()->name}}"
                                    width="48" height="48" alt="Lauren Marsano" />
                            </a>
                            <div class="pr-1">
                                <a class="inline-flex text-gray-800 hover:text-gray-900" href="#0">
                                    <h2 class="text-xl leading-snug font-bold">{{Auth::user()->name}}</h2>
                                </a>
                                <a class="block text-sm font-medium hover:text-indigo-500" href="#0">{{ '@' . explode(' ', Auth::user()->name)[0] }}</a>
                            </div>
                        </div>
                    </div>
                </header>


                <!-- Card body -->
                <div class="py-3 px-5 h-full">
                    <h3 class="text-xs font-semibold uppercase text-gray-400 mb-1">Friends</h3>
                    <!-- Chat list -->
                    <div class="divide-y divide-gray-200 overflow-y-scroll h-80">
                        <!-- User -->
                        {{-- <button class="w-full text-left py-2 focus:outline-none focus-visible:bg-indigo-50">
                            <div class="flex items-center">
                                <img class="rounded-full items-start flex-shrink-0 mr-3"
                                    src="https://res.cloudinary.com/dc6deairt/image/upload/v1638102932/user-32-01_pfck4u.jpg"
                                    width="32" height="32" alt="Marie Zulfikar" />
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900">Marie Zulfikar</h4>
                                    <div class="text-[13px]">The video chat ended · 2hrs</div>
                                </div>
                            </div>
                        </button> --}}
                        @foreach ($friends as $item)
                            <button class="w-full text-left py-2 focus:outline-none focus-visible:bg-indigo-50">
                                <a href="{{ route('chat.room', $item['friend']->id) }}">
                                    <div class="flex items-center">
                                        <img class="rounded-full items-start flex-shrink-0 mr-3"
                                            src="https://ui-avatars.com/api/?name={{ $item['friend']->name }}"
                                            width="32" height="32" alt="Patrick Friedman" />
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-900">{{ $item['friend']->name }}</h4>
                                            @if ($item['lastChat'])
                                                <div class="text-[13px]">{{ $item['lastChat']->text }}</div>
                                            @endif

                                        </div>
                                    </div>
                                </a>

                            </button>
                        @endforeach
                    </div>
                </div>


                <!-- Bottom right button -->
                <a href="/add-friends"
                    class="absolute bottom-5 right-5 inline-flex items-center text-sm font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded-full text-center px-3 py-2 shadow-lg focus:outline-none focus-visible:ring-2">
                    <svg class="w-3 h-3 fill-current text-indigo-300 flex-shrink-0 mr-2" viewBox="0 0 12 12">
                        <path
                            d="M11.866.146a.5.5 0 0 0-.437-.139c-.26.044-6.393 1.1-8.2 2.913a4.145 4.145 0 0 0-.617 5.062L.305 10.293a1 1 0 1 0 1.414 1.414L7.426 6l-2 3.923c.242.048.487.074.733.077a4.122 4.122 0 0 0 2.933-1.215c1.81-1.809 2.87-7.94 2.913-8.2a.5.5 0 0 0-.139-.439Z" />
                    </svg>
                    <span>Add Friends</span>
                </a>
            </div>
        </div>
    </section>
@endsection

@push('footer-script')
    {{-- <script src="{{ url('js/chat-index.js')}}"></script> --}}
@endpush
