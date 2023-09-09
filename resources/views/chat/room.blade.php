@extends('layouts.main')

@push('css')
    {{-- <link rel="stylesheet" href="{{ url('css/chat.css') }}"> --}}
@endpush

@section('body')
    <div class="flex flex-col flex-grow w-full max-w-xl bg-white shadow-xl  overflow-hidden">
        <div class="w-full p-2 bg-lime-500 w-44 text-white flex">
            <a href="/chat" class="">
                <x-bx-arrow-back class="inline w-6 h-6 " />
            </a>
            <div class="mx-auto">
                {{ $receiver_detail->name }}
            </div>

        </div>

        <div class="flex flex-col flex-grow h-64 p-4 overflow-auto" id="chat-box">
            {{-- <div class="flex w-full mt-2 space-x-3 max-w-xs">
                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-300"></div>
                <div>
                    <div class="bg-gray-300 p-3 rounded-r-lg rounded-bl-lg">
                        <p class="text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </div>
                    <span class="text-xs text-gray-500 leading-none">2 min ago</span>
                </div>
            </div>
            <div class="flex w-full mt-2 space-x-3 max-w-xs ml-auto justify-end">
                <div>
                    <div class="bg-blue-600 text-white p-3 rounded-l-lg rounded-br-lg">
                        <p class="text-sm">Lorem ipsum dolor sit amet.</p>
                    </div>
                    <span class="text-xs text-gray-500 leading-none">2 min ago</span>
                </div>
                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-300"></div>
            </div>

            <hr class="p-2"> --}}

            @forelse ($chat as $item)
                @if ($item->sender_id === Auth::user()->id)
                    <div class="flex w-full mt-2 space-x-3 max-w-xs ml-auto justify-end">
                        <div>
                            <div class="bg-blue-600 text-white p-3 rounded-l-lg rounded-br-lg">
                                @if ($item->image)
                                    <img src="{{ Storage::url($item->image) }}" alt="" class="w-32">
                                @endif
                                <p class="text-sm">{{ $item->text }}</p>
                            </div>
                            <span class="text-xs text-gray-500 leading-none">{{ $item->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-300">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" class="rounded-full"
                                alt="">
                        </div>
                    </div>
                @else
                    <div class="flex w-full mt-2 space-x-3 max-w-xs">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-300">
                            <img src="https://ui-avatars.com/api/?name={{ $receiver_detail->name }}" class="rounded-full"
                                alt="">
                        </div>
                        <div>
                            <div class="bg-gray-300 p-3 rounded-r-lg rounded-bl-lg">
                                @if ($item->image)
                                    <img src="{{ Storage::url($item->image) }}" alt="" class="w-32">
                                @endif
                                <p class="text-sm">{{ $item->text }}</p>
                            </div>
                            <span class="text-xs text-gray-500 leading-none">{{ $item->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endif
            @empty
                <p class="w-full mx-auto font-thin flex justify-center text-base" id="text-mulai">silakan memulai pesan😆
                </p>
            @endforelse
        </div>

        {{-- image preview --}}
        <div class="w-full m-auto rounded-t-sm shadow-md hidden" id="img-container">
            <div class="float-right m-2 cursor-pointer" id="remove-img">
                <x-eos-cancel class="h-7 w-7" />
            </div>
            <img src="" id="img-preview" width="200" class="m-auto" alt="">
        </div>
        <div class="bg-gray-300 p-4 w-full flex items-center">

            <form method="POST" class="flex items-center w-full" id="form-data" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="idroom" value="{{ $idroom->id }}">
                <label for="image" class="cursor-pointer">
                    <x-bx-image class="w-6 h-6 text-black" />
                </label>
                <input type="file" name="image" onchange="readURL(this)" id="image" class="hidden">
                <input class="rounded px-3 mx-2 text-sm w-full" type="text" placeholder="Type your message…"
                    name="message">
                <button type="button" class=" bg-green-600 text-white hover:bg-green-950 p-2 rounded-lg">Send</button>
            </form>
        </div>
    </div>
@endsection

@push('head-script')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        var pusher = new Pusher('6718bbe8ac3a4c5f522e', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('room-{{ $idroom->id }}');


        channel.bind('my-event', function(data) {
            $('#text-mulai').addClass('hidden');
            var d = $('#chat-box');
            // Buat elemen HTML yang akan Anda tambahkan

            if (data.sender_id === {{ Auth::user()->id }}) {
                var chatItem = `
                    <div class="flex w-full mt-2 space-x-3 max-w-xs ml-auto justify-end">
                        <div>
                            <div class="bg-blue-600 text-white p-3 rounded-l-lg rounded-br-lg">
                                <p class="text-sm">${data.message}</p>
                            </div>
                            <span class="text-xs text-gray-500 leading-none">just now</span>
                        </div>
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-300">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" class="rounded-full"
                                alt="">
                        </div>
                    </div>
                `;

                if (data.image) {
                    var chatItem = `
                    <div class="flex w-full mt-2 space-x-3 max-w-xs ml-auto justify-end">
                        <div>
                            <div class="bg-blue-600 text-white p-3 rounded-l-lg rounded-br-lg">
                                <img src="{{ Storage::url('${data.image}') }}" alt="" class="w-32">
                                <p class="text-sm">${data.message}</p>
                            </div>
                            <span class="text-xs text-gray-500 leading-none">just now</span>
                        </div>
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-300">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" class="rounded-full"
                                alt="">
                        </div>
                    </div>
                `;
                }
            } else {
                var chatItem =
                    `
                <div class="flex w-full mt-2 space-x-3 max-w-xs">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-300">
                        <img src="https://ui-avatars.com/api/?name={{ $receiver_detail->name }}" class="rounded-full"
                                alt="">
                    </div>
                    <div>
                        <div class="bg-gray-300 p-3 rounded-r-lg rounded-bl-lg">
                            <p class="text-sm">${data.message}</p>
                        </div>
                        <span class="text-xs text-gray-500 leading-none">just now</span>
                    </div>
                </div>
                `;

                if (data.image) {
                    var chatItem =
                        `
                <div class="flex w-full mt-2 space-x-3 max-w-xs">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-300">
                        <img src="https://ui-avatars.com/api/?name={{ $receiver_detail->name }}" class="rounded-full"
                                alt="">
                    </div>
                    <div>
                        <div class="bg-gray-300 p-3 rounded-r-lg rounded-bl-lg">
                            <img src="{{ Storage::url('${data.image}') }}" alt="" class="w-32">
                            <p class="text-sm">${data.message}</p>
                        </div>
                        <span class="text-xs text-gray-500 leading-none">just now</span>
                    </div>
                </div>
                `;
                }
            }

            // Tambahkan elemen ke #chat-box
            $('#chat-box').append(chatItem);
            $("#chat-box").animate({
                scrollTop: $('#chat-box').prop("scrollHeight")
            }, 1000);
            // console.log((JSON.stringify(data.message)));
            // console.log(data.message)
        });
    </script>

    <script>
        const beamsClient = new PusherPushNotifications.Client({
            instanceId: 'cc807c3b-78f3-4bcb-812c-b3e37637df1c',
        });

        beamsClient
            .start()
            .then((beamsClient) => beamsClient.getDeviceId())
            .then((deviceId) =>
                console.log("Successfully registered with Beams. Device ID:", deviceId)
            )
            // delete all device interest
            .then(() => beamsClient.clearDeviceInterests())
            .then(() => beamsClient.addDeviceInterest("{{ Auth::user()->id }}"))
            .then(() => beamsClient.getDeviceInterests())
            .then((interests) => console.log("Current interests:", interests))
            .catch(console.error);
    </script>
@endpush

@push('footer-script')
    <script>
        function readURL(input) {
            $('#img-container').removeClass('hidden');
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#img-preview')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeImg() {
            $('#img-container').addClass('hidden');
            $('#image').val('');
        }
        $('#remove-img').on('click', function() {
            removeImg();
        })
        // var d = $('#chat-box');
        // d.scrollTop(d.prop("scrollHeight"));
        $("#chat-box").animate({
            scrollTop: $('#chat-box').prop("scrollHeight")
        }, 1000);

        $('#form-data').on('submit', function() {
            return false;
        })

        $('#form-data').keypress((e) => {
            // Enter key corresponds to number 13
            if (e.which === 13) {
                sendMessage();
            }
        })

        $('button').on('click', function() {
            sendMessage();

        })

        function sendMessage() {
            // Dapatkan data form (misalnya, dengan serialize() jika menggunakan jQuery)
            var data = new FormData()
            data.append('idroom', $('input[name=idroom]').val())
            data.append('message', $('input[name=message]').val())
            data.append('image', $('input[name=image]')[0].files[0])
            // var data = $('#form-data').serialize();

            // console.log(data)

            $.ajax({
                url: "{{ route('chat.send', $receiver_id) }}",
                type: 'POST', // Ganti dengan metode HTTP yang sesuai
                data: data,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // clear input name and image
                    $('#form-data')[0].reset();
                    removeImg()

                    if (response.response_code === 0) {
                        Swal.fire(
                            'Oops!',
                            'gak boleh kosong yaaa!',
                            'error'
                        );
                        $('#form-data')[0].reset();
                        removeImg()
                    }
                },
                error: function(error) {
                    var msg = 'Something went wrong!';
                    if (error.responseJSON.message) {
                        msg = error.responseJSON.message;
                    }
                    Swal.fire(
                        'Oops!',
                        msg,
                        'error'
                    )
                    removeImg()
                }
            });
        }
    </script>
@endpush
