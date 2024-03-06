<title>Room Play</title>

@extends('game.layouts.Layout')

@section('Content')

    <!-- <audio id="audioPlayer" autoplay loop>
    <source src="https://www.computerhope.com/jargon/m/example.mp3" type="audio/mp3">
    Your browser does not support the audio element.
    </audio> -->

    <!-- START CONTENT -->
    <div class="flex-col flex items-center justify-center">
        <h1 class="z-[100] text-white text-2xl font-bold">รอบที่ <span id="round-text">{{ $room->round }}</span></h1>
        <input id="room_id" type="hidden" value="{{ $room->room_id }}">

        <!-- START CIRCLE -->
        @if(count($room_nightmares) == 5)
        <div class="z-50 relative w-[400px] max-sm:w-full h-[400px] overflow-hidden">
        @else
        <div class="z-50 relative w-[400px] max-sm:w-full h-[450px] overflow-hidden">
        @endif
            <div class="z-50 flex justify-center items-center h-full">
                <h1 class="z-[100] absolute top-2 right-2 text-white text- font-medium bg-indigo-900 rounded-full px-2 py-1">วงที่ {{ $room->circle }}</h1>
                <div class="z-10 w-full h-full absolute top-0 left-0 bg-indigo-100 opacity-50"></div>

                <!-- START NIGHTMARE CARD -->
                @if(count($room_nightmares) == 5)
                <div class="mt-[-35px] w-[300px] h-[300px] flex justify-center items-center relative">
                @else
                <div class="mt-[25px] w-[300px] h-[300px] flex justify-center items-center relative">
                @endif

                    <!-- START TIMER -->
                    <div class="z-50 w-full h-full flex">
                        <div class="w-fit m-auto text-center flex-col flex justify-center items-center">
                            <h1 class="text-xl text-white font-bold uppercase">สิ้นสุดใน:</h1>
    
                            <div id="div-countdown_timer" class="relative mx-auto w-[100px] h-fit p-3 rounded-full overflow-hidden text-center">
                                <div class="z-10 w-full h-full absolute top-0 left-0 bg-white opacity-50"></div>
                                <span id="countdown_timer" class="z-20 relative text-[#EE609A] text-xl font-bold whitespace-nowrap">00 : 00</span>
                            </div>
    
                            @if(Session::get('creator'))
                                <div class="w-[75px]">
                                    <div id="btn-start-countdown" class="hidden bg-[#EE609A] rounded-full py-1.5 px-2 w-full border border-white text-white text-center hover:bg-[#d62c65] duration-300 cursor-pointer">เริ่ม</div>
                                </div>

                                <button id="btn-timeout" class="hidden z-[100] mt-2 bg-[#EE609A] hover:bg-[#d62c65] rounded-full py-1 px-1.5 w-[60px] border border-white text-white text-center text-sm whitespace-nowrap duration-300">จบรอบ</button>

                                <button id="btn-end-timer" class="hidden z-[100] mt-2 bg-[#EE609A] hover:bg-[#d62c65] rounded-full py-1 px-1.5 w-[60px] border border-white text-white text-center text-sm whitespace-nowrap duration-300">สิ้นสุด</button>

                                <button id="btn-next-circle" class="hidden z-[100] mt-2 bg-[#EE609A] hover:bg-[#d62c65] rounded-full py-1 px-1.5 w-[60px] border border-white text-white text-center text-sm whitespace-nowrap duration-300">ยืนยัน</button>

                                <button id="btn-next-round" class="hidden z-[100] mt-2 bg-[#EE609A] hover:bg-[#d62c65] rounded-full py-1 px-1.5 w-[60px] border border-white text-white text-center text-sm whitespace-nowrap duration-300">เริ่ม</button>

                                <button id="btn-new-room" class="hidden z-[100] mt-2 bg-[#EE609A] hover:bg-[#d62c65] rounded-full py-1 px-1.5 w-[75px] border border-white text-white text-center text-sm whitespace-nowrap duration-300">เล่นอีกครั้ง</button>
                            @endif

                        </div>
                    </div>
                    <!-- END TIMER -->

                    @if(count($room_nightmares) == 5)
                        <!-- START NIGHTMARE CARD 1 -->
                        <div class="z-[100] absolute bottom-0 left-1/5 transform translate-y-14 cursor-pointer rounded-full">
                            <div class="relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[90px] h-full overflow-hidden">
                                    <img src="{{ URL('/uploads/' . $room_nightmares[0]->nm_image) }}" class="nm_image btn-image-zoom w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="btn-link z-50 absolute bottom-0 right-0 transform -translate-x-5 translate-y-2 rotate-[140deg] cursor-pointer rounded-full"
                        onclick="FetchCards(this)" data-room_link_id="{{ $room_nightmares[0]->room_link_id }}" data-link_status="{{ $room_nightmares[0]->link_status }}"
                        data-nightmare_id_1="{{ $room_nightmares[0]->nightmare_id }}" data-image_1="{{ URL('/uploads/' . $room_nightmares[0]->nm_image) }}" 
                        data-nightmare_id_2="{{ $room_nightmares[1]->nightmare_id }}" data-image_2="{{ URL('/uploads/' . $room_nightmares[1]->nm_image) }}">
                            <div class="z-50 relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[90px] h-full overflow-hidden">
                                    <img src="{{ URL('/uploads/' . $room_nightmares[0]->link_image) }}" class="link_image w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <!-- END NIGHTMARE CARD 1 -->
                        
                        <!-- START NIGHTMARE CARD 2 -->
                        <div class="z-[100] absolute bottom-0 right-1 transform translate-x-8 -translate-y-14 -rotate-[75deg] cursor-pointer rounded-full">
                            <div class="nightmare-select hidden z-[101] w-full h-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-full"
                            data-room_nightmare_id="{{ $room_nightmares[1]->room_nightmare_id }}">
                                <div class="w-8 h-8 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white border-[3px] border-[#7068ec] bg-white rounded-full p-1">
                                    <div class="circle hidden w-5 h-5 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#8586f4] rounded-full"></div>
                                </div>
                            </div>
                            <div class="relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[86px] h-full overflow-hidden">
                                    <img src="{{ URL('/uploads/' . $room_nightmares[1]->nm_image) }}" class="nm_image btn-image-zoom w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="btn-link z-50 absolute top-1/5 right-0 transform translate-x-7 -translate-y-12 rotate-[70deg] cursor-pointer rounded-full"
                        onclick="FetchCards(this)" data-room_link_id="{{ $room_nightmares[1]->room_link_id }}" data-link_status="{{ $room_nightmares[1]->link_status }}"
                        data-nightmare_id_1="{{ $room_nightmares[1]->nightmare_id }}" data-image_1="{{ URL('/uploads/' . $room_nightmares[1]->nm_image) }}" 
                        data-nightmare_id_2="{{ $room_nightmares[2]->nightmare_id }}" data-image_2="{{ URL('/uploads/' . $room_nightmares[2]->nm_image) }}">
                            <div class="z-50 relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[90px] h-[40px] overflow-hidden">
                                    <img src="{{ URL('/uploads/' . $room_nightmares[1]->link_image) }}" class="link_image mt-[-28px] w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <!-- END NIGHTMARE CARD 2 -->

                        <!-- START NIGHTMARE CARD 3 -->
                        <div class="z-[100] absolute top-0 right-0 transform -translate-x-5 -translate-y-7 -rotate-[140deg] cursor-pointer rounded-full">
                            <div class="nightmare-select hidden z-[101] w-full h-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-full"
                            data-room_nightmare_id="{{ $room_nightmares[2]->room_nightmare_id }}">
                                <div class="w-8 h-8 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white border-[3px] border-[#7068ec] bg-white rounded-full p-1">
                                    <div class="circle hidden w-5 h-5 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#8586f4] rounded-full"></div>
                                </div>
                            </div>
                            <div class="relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[85px] h-full overflow-hidden">
                                    <img src="{{ URL('/uploads/' . $room_nightmares[2]->nm_image) }}" class="nm_image btn-image-zoom w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="btn-link z-50 absolute top-0 left-1/5 transform translate-x-1 -translate-y-4 rotate-[0deg] cursor-pointer rounded-full"
                        onclick="FetchCards(this)" data-room_link_id="{{ $room_nightmares[2]->room_link_id }}" data-link_status="{{ $room_nightmares[2]->link_status }}"
                        data-nightmare_id_1="{{ $room_nightmares[2]->nightmare_id }}" data-image_1="{{ URL('/uploads/' . $room_nightmares[2]->nm_image) }}" 
                        data-nightmare_id_2="{{ $room_nightmares[3]->nightmare_id }}" data-image_2="{{ URL('/uploads/' . $room_nightmares[3]->nm_image) }}">
                            <div class="z-50 relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[90px] h-[40px] overflow-hidden">
                                    <img src="{{ URL('/uploads/' . $room_nightmares[2]->link_image) }}" class="link_image mt-[-28px] w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <!-- END NIGHTMARE CARD 3 -->

                        <!-- START NIGHTMARE CARD 4 -->
                        <div class="z-[100] absolute top-0 left-0 transform translate-x-7 -translate-y-7 rotate-[140deg] cursor-pointer">
                            <div class="nightmare-select hidden z-[101] w-full h-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-full"
                            data-room_nightmare_id="{{ $room_nightmares[3]->room_nightmare_id }}">
                                <div class="w-8 h-8 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white border-[3px] border-[#7068ec] bg-white rounded-full p-1">
                                    <div class="circle hidden w-5 h-5 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#8586f4] rounded-full"></div>
                                </div>
                            </div>
                            <div class="relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[85px] h-full overflow-hidden">
                                    <img src="{{ URL('/uploads/' . $room_nightmares[3]->nm_image) }}" class="nm_image btn-image-zoom w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="btn-link z-50 absolute bottom-1/5 left-0 transform -translate-x-5 -translate-y-12 -rotate-[70deg] cursor-pointer rounded-full"
                        onclick="FetchCards(this)" data-room_link_id="{{ $room_nightmares[3]->room_link_id }}" data-link_status="{{ $room_nightmares[3]->link_status }}"
                        data-nightmare_id_1="{{ $room_nightmares[3]->nightmare_id }}" data-image_1="{{ URL('/uploads/' . $room_nightmares[3]->nm_image) }}" 
                        data-nightmare_id_2="{{ $room_nightmares[4]->nightmare_id }}" data-image_2="{{ URL('/uploads/' . $room_nightmares[4]->nm_image) }}">
                            <div class="z-50 relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[90px] h-[40px] overflow-hidden">
                                    <img src="{{ URL('/uploads/' . $room_nightmares[3]->link_image) }}" class="link_image mt-[-28px] w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <!-- END NIGHTMARE CARD 4 -->

                        <!-- START NIGHTMARE CARD 5 -->
                        <div class="z-[100] absolute bottom-0 left-0 transform -translate-x-7 -translate-y-14 rotate-[75deg] cursor-pointer">
                            <div class="nightmare-select hidden z-[101] w-full h-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-full"
                            data-room_nightmare_id="{{ $room_nightmares[4]->room_nightmare_id }}">
                                <div class="w-8 h-8 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white border-[3px] border-[#7068ec] bg-white rounded-full p-1">
                                    <div class="circle hidden w-5 h-5 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#8586f4] rounded-full"></div>
                                </div>
                            </div>
                            <div class="relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[85px] h-full overflow-hidden">
                                    <img src="{{ URL('/uploads/' . $room_nightmares[4]->nm_image) }}" class="nm_image btn-image-zoom w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="btn-link z-50 absolute bottom-0 left-0 transform translate-x-5 translate-y-2 -rotate-[140deg] cursor-pointer rounded-full"
                        onclick="FetchCards(this)" data-room_link_id="{{ $room_nightmares[4]->room_link_id }}" data-link_status="{{ $room_nightmares[4]->link_status }}"
                        data-nightmare_id_1="{{ $room_nightmares[4]->nightmare_id }}" data-image_1="{{ URL('/uploads/' . $room_nightmares[4]->nm_image) }}" 
                        data-nightmare_id_2="{{ $room_nightmares[0]->nightmare_id }}" data-image_2="{{ URL('/uploads/' . $room_nightmares[0]->nm_image) }}">
                            <div class="z-50 relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[90px] h-full overflow-hidden">
                                    <img src="{{ URL('/uploads/' . $room_nightmares[4]->link_image) }}" class="link_image w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <!-- END NIGHTMARE CARD 5 -->
                    @else
                        <!-- START NIGHTMARE CARD 1 -->
                        <div class="z-[100] absolute bottom-0 left-1/5 transform translate-y-14 cursor-pointer rounded-full">
                            <div class="relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[80px] h-full overflow-hidden">
                                    <img src="{{ URL('/uploads/' . $room_nightmares[0]->nm_image) }}" class="nm_image btn-image-zoom w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="btn-link z-50 absolute bottom-0 right-0 transform -translate-x-6 translate-y-6 rotate-[150deg] cursor-pointer rounded-full"
                        onclick="FetchCards(this)" data-room_link_id="{{ $room_nightmares[0]->room_link_id }}" data-link_status="{{ $room_nightmares[0]->link_status }}" 
                        data-nightmare_id_1="{{ $room_nightmares[0]->nightmare_id }}" data-image_1="{{ URL('/uploads/' . $room_nightmares[1]->nm_image) }}" 
                        data-nightmare_id_2="{{ $room_nightmares[1]->nightmare_id }}" data-image_2="{{ URL('/uploads/' . $room_nightmares[2]->nm_image) }}">
                            <div class="z-50 relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[90px] h-full overflow-hidden">
                                    <img src="{{ URL('/uploads/' . $room_nightmares[0]->link_image) }}" class="link_image w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <!-- END NIGHTMARE CARD 1 -->
                        
                        <!-- START NIGHTMARE CARD 2 -->
                        <div class="z-[100] absolute bottom-0 right-1 transform translate-x-8 -translate-y-8 -rotate-[70deg] cursor-pointer rounded-full">
                            <div class="nightmare-select hidden z-[101] w-full h-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-full"
                            data-room_nightmare_id="{{ $room_nightmares[1]->room_nightmare_id }}">
                                <div class="w-8 h-8 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white border-[3px] border-[#7068ec] bg-white rounded-full p-1">
                                    <div class="circle hidden w-5 h-5 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#8586f4] rounded-full"></div>
                                </div>
                            </div>
                            <div class="relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[80px] h-full overflow-hidden">
                                    <img src="{{ URL('/uploads/' . $room_nightmares[1]->nm_image) }}" class="nm_image btn-image-zoom w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="btn-link z-50 absolute top-1/5 right-0 transform translate-x-12 -translate-y-3 rotate-[90deg] cursor-pointer rounded-full"
                        onclick="FetchCards(this)" data-room_link_id="{{ $room_nightmares[1]->room_link_id }}" data-link_status="{{ $room_nightmares[1]->link_status }}"
                        data-nightmare_id_1="{{ $room_nightmares[1]->nightmare_id }}" data-image_1="{{ URL('/uploads/' . $room_nightmares[1]->nm_image) }}" 
                        data-nightmare_id_2="{{ $room_nightmares[2]->nightmare_id }}" data-image_2="{{ URL('/uploads/' . $room_nightmares[2]->nm_image) }}">
                            <div class="z-50 relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[90px] h-[40px] overflow-hidden">
                                    <img src="{{ URL('/uploads/' . $room_nightmares[1]->link_image) }}" class="link_image mt-[-28px] w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <!-- END NIGHTMARE CARD 2 -->

                        <!-- START NIGHTMARE CARD 3 -->
                        <div class="z-[100] absolute top-0 right-0 transform translate-x-8 translate-y-0 -rotate-[120deg] cursor-pointer rounded-full">
                            <div class="nightmare-select hidden z-[101] w-full h-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-full"
                            data-room_nightmare_id="{{ $room_nightmares[2]->room_nightmare_id }}">
                                <div class="w-8 h-8 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white border-[3px] border-[#7068ec] bg-white rounded-full p-1">
                                    <div class="circle hidden w-5 h-5 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#8586f4] rounded-full"></div>
                                </div>
                            </div>
                            <div class="relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[80px] h-full overflow-hidden">
                                    <img src="{{ URL('/uploads/' . $room_nightmares[2]->nm_image) }}" class="nm_image btn-image-zoom w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="btn-link z-50 absolute top-0 left-1/5 transform translate-x-20 -translate-y-6 rotate-[30deg] cursor-pointer rounded-full"
                        onclick="FetchCards(this)" data-room_link_id="{{ $room_nightmares[2]->room_link_id }}" data-link_status="{{ $room_nightmares[2]->link_status }}"
                        data-nightmare_id_1="{{ $room_nightmares[2]->nightmare_id }}" data-image_1="{{ URL('/uploads/' . $room_nightmares[2]->nm_image) }}" 
                        data-nightmare_id_2="{{ $room_nightmares[3]->nightmare_id }}" data-image_2="{{ URL('/uploads/' . $room_nightmares[3]->nm_image) }}">
                            <div class="z-50 relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[90px] h-[40px] overflow-hidden">
                                    <img src="{{ URL('/uploads/' . $room_nightmares[2]->link_image) }}" class="link_image mt-[-28px] w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <!-- END NIGHTMARE CARD 3 -->

                        <!-- START NIGHTMARE CARD 4 -->
                        <div class="z-[100] absolute top-0 left-1/5 transform translate-x-0 -translate-y-20 rotate-[180deg] cursor-pointer">
                            <div class="nightmare-select hidden z-[101] w-full h-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-full"
                            data-room_nightmare_id="{{ $room_nightmares[3]->room_nightmare_id }}">
                                <div class="w-8 h-8 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white border-[3px] border-[#7068ec] bg-white rounded-full p-1">
                                    <div class="circle hidden w-5 h-5 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#8586f4] rounded-full"></div>
                                </div>
                            </div>
                            <div class="relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[80px] h-full overflow-hidden">
                                    <img src="{{ URL('/uploads/' . $room_nightmares[3]->nm_image) }}" class="nm_image btn-image-zoom w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="btn-link z-50 absolute top-0 left-0 transform translate-x-6 -translate-y-5 -rotate-[30deg] cursor-pointer rounded-full"
                        onclick="FetchCards(this)" data-room_link_id="{{ $room_nightmares[3]->room_link_id }}" data-link_status="{{ $room_nightmares[3]->link_status }}"
                        data-nightmare_id_1="{{ $room_nightmares[3]->nightmare_id }}" data-image_1="{{ URL('/uploads/' . $room_nightmares[3]->nm_image) }}" 
                        data-nightmare_id_2="{{ $room_nightmares[4]->nightmare_id }}" data-image_2="{{ URL('/uploads/' . $room_nightmares[4]->nm_image) }}">
                            <div class="z-50 relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[90px] h-[40px] overflow-hidden">
                                    <img src="{{ URL('/uploads/' . $room_nightmares[3]->link_image) }}" class="link_image mt-[-28px] w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <!-- END NIGHTMARE CARD 4 -->

                        <!-- START NIGHTMARE CARD 5 -->
                        <div class="z-[100] absolute top-0 left-0 transform -translate-x-8 translate-y-1 rotate-[120deg] cursor-pointer">
                            <div class="nightmare-select hidden z-[101] w-full h-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-full"
                            data-room_nightmare_id="{{ $room_nightmares[4]->room_nightmare_id }}">
                                <div class="w-8 h-8 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white border-[3px] border-[#7068ec] bg-white rounded-full p-1">
                                    <div class="circle hidden w-5 h-5 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#8586f4] rounded-full"></div>
                                </div>
                            </div>
                            <div class="relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[80px] h-full overflow-hidden">
                                    <img src="{{ URL('/uploads/' . $room_nightmares[4]->nm_image) }}" class="nm_image btn-image-zoom w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="btn-link z-50 absolute top-1/2 left-0 transform -translate-x-14 -translate-y-14 -rotate-[90deg] cursor-pointer rounded-full"
                        onclick="FetchCards(this)" data-room_link_id="{{ $room_nightmares[4]->room_link_id }}" data-link_status="{{ $room_nightmares[4]->link_status }}"
                        data-nightmare_id_1="{{ $room_nightmares[4]->nightmare_id }}" data-image_1="{{ URL('/uploads/' . $room_nightmares[4]->nm_image) }}" 
                        data-nightmare_id_2="{{ $room_nightmares[5]->nightmare_id }}" data-image_2="{{ URL('/uploads/' . $room_nightmares[5]->nm_image) }}">
                            <div class="z-50 relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[90px] h-full overflow-hidden">
                                    <img src="{{ URL('/uploads/' . $room_nightmares[4]->link_image) }}" class="link_image w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <!-- END NIGHTMARE CARD 5 -->

                        <!-- START NIGHTMARE CARD 6 -->
                        <div class="z-[100] absolute bottom-0 left-0 transform -translate-x-7 -translate-y-9 rotate-[70deg] cursor-pointer">
                            <div class="nightmare-select hidden z-[101] w-full h-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-full"
                            data-room_nightmare_id="{{ $room_nightmares[5]->room_nightmare_id }}">
                                <div class="w-8 h-8 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white border-[3px] border-[#7068ec] bg-white rounded-full p-1">
                                    <div class="circle hidden w-5 h-5 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#8586f4] rounded-full"></div>
                                </div>
                            </div>
                            <div class="relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[80px] h-full overflow-hidden">
                                    <img src="{{ URL('/uploads/' . $room_nightmares[5]->nm_image) }}" class="nm_image btn-image-zoom w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="btn-link z-50 absolute bottom-0 left-0 transform translate-x-6 translate-y-6 -rotate-[150deg] cursor-pointer rounded-full"
                        onclick="FetchCards(this)" data-room_link_id="{{ $room_nightmares[5]->room_link_id }}" data-link_status="{{ $room_nightmares[5]->link_status }}"
                        data-nightmare_id_1="{{ $room_nightmares[5]->nightmare_id }}" data-image_1="{{ URL('/uploads/' . $room_nightmares[5]->nm_image) }}" 
                        data-nightmare_id_2="{{ $room_nightmares[0]->nightmare_id }}" data-image_2="{{ URL('/uploads/' . $room_nightmares[0]->nm_image) }}">
                            <div class="z-50 relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[90px] h-full overflow-hidden">
                                    <img src="{{ URL('/uploads/' . $room_nightmares[5]->link_image) }}" class="link_image w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <!-- END NIGHTMARE CARD 5 -->
                    @endif

                </div>
                <!-- END NIGHTMARE CARD -->

            </div>
        </div>
        <!-- END CIRCLE -->


        <!-- START BOTTOM BUTTON -->
        <div class="z-[100] absolute bottom-3 left-2">
            <button onclick="FetchResults()" id="btn-result" class="bg-[#EE609A] hover:bg-[#d62c65] rounded-full py-1.5 px-2 w-[75px] border border-white text-sm text-white text-center whitespace-nowrap duration-300">ผลลัพธ์</button>
            <button id="btn-actions" class="bg-[#EE609A] hover:bg-[#d62c65] rounded-full py-1.5 px-2 w-[75px] border border-white text-sm text-white text-center whitespace-nowrap duration-300">การกระทำ</button>
            <button id="btn-tips" class="bg-[#EE609A] hover:bg-[#d62c65] rounded-full py-1.5 px-2 w-[75px] border border-white text-sm text-white text-center whitespace-nowrap duration-300">เป้าหมาย</button>
        </div>

        <div class="z-[100] absolute bottom-3 right-2">
            <button id="btn-leave-room" class="bg-indigo-800 hover:bg-indigo-900 rounded-full py-1.5 px-2 w-fit border border-white text-sm text-white text-center whitespace-nowrap duration-300">ออกจากห้อง</button>
        </div>
        <!-- END BOTTOM BUTTON -->

    </div>
    <!-- END CONTENT -->



    <!-- START MODAL TIPS -->
    <div id="modal-tips" class="modal hidden fixed z-[100] flex left-0 top-0 w-[100%] h-[100%] overflow-auto max-md:px-[10px]">
        <!-- START MODAL CONTENT -->
        <div class="modal-content bg-white m-auto rounded-2xl drop-shadow-xl">
        <span id="icon-tips-close" class="z-20 text-black bg-white rounded-full drop-shadow border text-[24px] font-bold h-fit font-medium absolute top-0 right-0 mt-2 mr-2 hover:text-indigo-600 hover:bg-indigo-200 duration-300 cursor-pointer"><i class='bx bx-x'></i></span>
            <div class="relative w-fit max-sm:w-[300px] grid grid-cols-2 max-sm:grid-cols-1 p-3 gap-3">
                TIPS
            </div>
        </div>
        <!-- END MODAL CONTENT -->
    </div>
    <!-- END MODAL TIPS -->

    <!-- START MODAL NIGHTMARE -->
    <div id="modal-nightmare" class="modal hidden fixed z-[100] flex left-0 top-0 w-[100%] h-[100%] overflow-auto max-md:px-[10px]">
        <!-- START MODAL CONTENT -->
        <div class="modal-content w-[350px] bg-[#e6e4f0] m-auto rounded-2xl drop-shadow-xl">
            <span id="icon-nightmare-close" class="z-20 text-black bg-white rounded-full drop-shadow border text-[24px] font-bold h-fit font-medium absolute top-0 right-0 mt-2 mr-2 hover:text-indigo-600 hover:bg-indigo-200 duration-300 cursor-pointer"><i class='bx bx-x'></i></span>
            <div class="relative p-4 flex-col flex items-center justify-center">
                
                <div class="text-gray-900 text-xl font-medium w-full text-center">
                    <h1>รายละเอียดฝันร้าย</h1>
                </div>
                <hr class="my-4 w-full h-px bg-gray-400 border-0">

                <!-- START IMAGE -->
                <div class="flex justify-between w-full">
                    <div class="relative w-[100px] overflow-hidden">
                        <img id="modal_nightmare_1" src="{{ URL('/assets/nightmare_crop/NM for print-01.png') }}" class="btn-image-zoom w-full h-full object-cover my-auto cursor-pointer rounded-full px-[1px]" alt="nightmare-card">
                    </div>
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 translate-y-28 w-[110px] h-[48px] overflow-hidden m-auto rotate-180">
                        <img id="modal_link" src="{{ URL('/assets/web_based_board_game/element add-69.png') }}" class="btn-image-zoom w-full h-full object-cover cursor-pointer rounded-full" alt="link-card">
                    </div>
                    <div class="relative w-[100px] overflow-hidden">
                        <img id="modal_nightmare_2" src="{{ URL('/assets/nightmare_crop/NM for print-02.png') }}" class="btn-image-zoom w-full h-full object-cover my-auto cursor-pointer rounded-full px-[1px]" alt="nightmare-card">
                    </div>
                </div>
                <!-- END IMAGE -->

                <hr class="my-4 w-full h-px bg-gray-400 border-0">
                

                <!-- START INPUT CARDS -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <!-- START INPUT -->
                        <div class="relative">
                            <input type="text" id="card_code_1" placeholder="รหัสการ์ด" class="placeholder-white w-full text-sm font-light bg-[#A39FC6] border-2 border-white rounded-full px-3 py-1.5 focus:outline-none">
                            <button onclick="CardAdd(this)" data-button_input="nm_left" class="absolute top-[5px] right-1.5 w-fit text-white p-1 rounded-full bg-[#EE609A] border border-white hover:bg-[#d62c65] duration-300 focus:ring-4 focus:outline-none focus:ring-indigo-200"><i class='bx bx-plus'></i></button>
                            <style>
                                .placeholder-white::placeholder {
                                    color: white;
                                }
                            </style>
                        </div>
                        <!-- END INPUT -->
        
                        <!-- START IMAGE -->
                        <div class="mt-1 grid grid-cols-1 gap-3">
                            <div class="relative cursor-pointer">
                                <div class="relative h-[120px] overflow-hidden border border-[#EE609A]">
                                    <img id="modal_card_1" src="{{ URL('/assets/skill card crop/element-empty.png') }}" class="btn-image-zoom w-full h-full object-cover my-auto" alt="nightmare-card">
                                </div>
                            </div>
                            <div class="relative cursor-pointer">
                                <div class="relative h-[120px] overflow-hidden border border-[#EE609A]">
                                    <img id="modal_card_2" src="{{ URL('/assets/skill card crop/element-empty.png') }}" class="btn-image-zoom w-full h-full my-auto" alt="nightmare-card">
                                </div>
                            </div>
                        </div>
                        <!-- END IMAGE -->
                    </div>

                    <div>
                        <!-- START INPUT -->
                        <div class="relative">
                            <input type="text" id="card_code_2" placeholder="รหัสการ์ด" class="placeholder-white w-full text-sm font-light bg-[#A39FC6] border-2 border-white rounded-full px-3 py-1.5 focus:outline-none">
                            <button onclick="CardAdd(this)" data-button_input="nm_right" class="absolute top-[5px] right-1.5 w-fit text-white p-1 rounded-full bg-[#EE609A] border border-white hover:bg-[#d62c65] duration-300 focus:ring-4 focus:outline-none focus:ring-indigo-200"><i class='bx bx-plus'></i></button>
                            <style>
                                .placeholder-white::placeholder {
                                    color: white;
                                }
                            </style>
                        </div>
                        <!-- END INPUT -->
        
                        <!-- START IMAGE -->
                        <div class="mt-1 grid grid-cols-1 gap-3">
                            <div class="relative cursor-pointer">
                                <div class="relative h-[120px] overflow-hidden border border-[#EE609A]">
                                    <img id="modal_card_3" src="{{ URL('/assets/skill card crop/element-empty.png') }}" class="btn-image-zoom w-full h-full object-cover my-auto" alt="nightmare-card">
                                </div>
                            </div>
                            <div class="relative cursor-pointer">
                                <div class="relative h-[120px] overflow-hidden border border-[#EE609A]">
                                    <img id="modal_card_4" src="{{ URL('/assets/skill card crop/element-empty.png') }}" class="btn-image-zoom w-full h-full my-auto" alt="nightmare-card">
                                </div>
                            </div>
                        </div>
                        <!-- END IMAGE -->
                    </div>
                </div>
                <!-- END INPUT CARDS -->
                
            </div>
        </div>
        <!-- END MODAL CONTENT -->
    </div>
    <!-- END MODAL NIGHTMARE -->


    <!-- START MODAL RESULT -->
    <div id="modal-result" class="modal hidden fixed z-[100] flex left-0 top-0 w-[100%] h-[100%] overflow-auto max-md:p-[10px]">
        <!-- START MODAL CONTENT -->
        <div class="modal-content bg-[#E6E4F0] w-fit m-auto rounded-2xl drop-shadow-xl">
            <span id="icon-result-close" class="z-20 text-black bg-white rounded-full drop-shadow border text-[24px] font-bold h-fit font-medium absolute top-0 right-0 mt-2 mr-2 hover:text-indigo-600 hover:bg-indigo-200 duration-300 cursor-pointer"><i class='bx bx-x'></i></span>
            <div class="relative p-4 flex-col flex items-center justify-center">
                
                <div class="text-center text-xl text-[#52459A]">
                    <h1 class="font-bold">TIME UP</h1>
                    <h1 class="font-medium">หมดเวลา!</h1>
                </div>

                <hr class="my-4 w-full h-px bg-gray-400 border-0">

                <button id="btn-game-end" class="hidden mb-4 bg-[#EE609A] hover:bg-[#d62c65] rounded-full py-1.5 px-2 w-fit border border-white text-white text-center duration-300">ผลลัพธ์เกม</button>

                <div id="results-items" class="gap-2">
                    
                </div>

                <!-- START RESULT PROTOTYPE -->
                <div class="resultBoxPt w-full bg-[#A39FC6] rounded-lg p-2 border-2 border-white space-y-3">
                    <div class="relative flex-col flex items-center justify-center w-full">
                        <!-- START LINK -->
                        <div class="relative w-[100px] h-[40px] overflow-hidden">
                            <img src="{{ URL('/assets/web_based_board_game/element-48.png') }}" class="modal_link btn-image-zoom w-full h-full object-cover my-auto" alt="nightmare-card">
                        </div>
                        <!-- END LINK -->

                        <i class='bx bxs-up-arrow text-xl text-white mt-[-5px] mb-2 animate-bounce'></i>

                        <!-- START CARDS -->
                        <div class="w-full flex gap-1">
                            <div class="relative">
                                <div class="relative h-[60px] overflow-hidden border border-[#EE609A]">
                                    <img src="{{ URL('/assets/skill card crop/element-24.png') }}" class="modal_card_1 btn-image-zoom w-full h-full object-cover my-auto" alt="nightmare-card">
                                </div>
                            </div>
                            <div class="relative">
                                <div class="relative h-[60px] overflow-hidden border border-[#EE609A]">
                                    <img src="{{ URL('/assets/skill card crop/element-empty.png') }}" class="modal_card_2 btn-image-zoom w-full h-full my-auto" alt="nightmare-card">
                                </div>
                            </div>
                            <div class="relative">
                                <div class="relative h-[60px] overflow-hidden border border-[#EE609A]">
                                    <img src="{{ URL('/assets/skill card crop/element-empty.png') }}" class="modal_card_3 btn-image-zoom w-full h-full my-auto" alt="nightmare-card">
                                </div>
                            </div>
                            <div class="relative">
                                <div class="relative h-[60px] overflow-hidden border border-[#EE609A]">
                                    <img src="{{ URL('/assets/skill card crop/element-empty.png') }}" class="modal_card_4 btn-image-zoom w-full h-full my-auto" alt="nightmare-card">
                                </div>
                            </div>
                        </div>
                        <!-- END CARDS -->

                    </div>
                </div>
                <!-- END RESULT PROTOTYPE -->
                
            </div>
        </div>
        <!-- END MODAL CONTENT -->
    </div>
    <!-- END MODAL RESULT -->

    <!-- START MODAL GAME END -->
    <div id="modal-game-end" class="modal hidden fixed z-[100] left-0 top-0 w-[100%] h-[100%] overflow-auto">
        <!-- Modal content -->
        <div class="modal-content fixed inset-0 flex items-center justify-center p-[10px]">
            <div class="relative w-[640px] h-auto min-h-[90vh] object-cover bg-[#e6e4f0] rounded-2xl overflow-hidden">
                <span id="icon-game-end-close" class="text-black bg-white rounded-full drop-shadow border text-[24px] font-bold h-fit font-medium absolute top-0 right-0 mt-2 mr-2 hover:text-indigo-600 hover:bg-indigo-200 duration-300 cursor-pointer"><i class='bx bx-x'></i></span>
                <div class="w-full h-full flex justify-center border-2 rounded p-3">
                    <img id="image_game_end" src="{{ URL('/assets/web_based_board_game/ending-01.png') }}" alt="" class="w-auto h-auto object-cover">
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL IMAGE ZOOM -->

    <!-- START MODAL IMAGE ZOOM -->
    <div id="modal-image-zoom" class="modal hidden fixed z-[100] left-0 top-0 w-[100%] h-[100%] overflow-auto">
        <!-- Modal content -->
        <div class="modal-content fixed inset-0 flex items-center justify-center p-[10px]">
            <div class="relative w-[640px] h-auto max-h-[90vh] object-cover bg-[#e6e4f0] rounded-2xl overflow-hidden">
                <span id="icon-image-zoom-close" class="text-black bg-white rounded-full drop-shadow border text-[24px] font-bold h-fit font-medium absolute top-0 right-0 mt-2 mr-2 hover:text-indigo-600 hover:bg-indigo-200 duration-300 cursor-pointer"><i class='bx bx-x'></i></span>
                <div class="w-auto h-auto flex justify-center border-2 rounded p-3">
                    <img id="image_zoom" src="{{ URL('/assets/mini-logo.png') }}" alt="" class="w-auto h-auto object-cover">
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL IMAGE ZOOM -->

    <!-- START MODAL TIMEUP -->
    <div id="modal-timeup" class="modal hidden fixed z-[100] flex left-0 top-0 w-[100%] h-[100%] overflow-auto max-md:px-[10px]">
        <!-- START MODAL CONTENT -->
        <div class="modal-content bg-[#E6E4F0] m-auto rounded-2xl drop-shadow-xl">
        <span id="icon-timeup-close" class="z-20 text-black bg-white rounded-full drop-shadow border text-[24px] font-bold h-fit font-medium absolute top-0 right-0 mt-2 mr-2 hover:text-indigo-600 hover:bg-indigo-200 duration-300 cursor-pointer"><i class='bx bx-x'></i></span>
            <div class="relative w-fit min-w-[300px] max-sm:w-[300px] p-3">
                <div class="relative text-[#52459A]">
                    <div class="text-center text-xl">
                        <h1 class="font-bold">TIME UP</h1>
                        <h1 class="font-medium">หมดเวลา!</h1>
                    </div>
                    <div class="mt-4 text-center space-y-4">
                        <!-- <p class="font-light">ผู้เล่นสามารถทำภารกิจสุดท้ายได้<br>จนลูกเต๋าหมดมือ</p> -->
                        <i class='bx bxs-time text-4xl animate-bounce'></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MODAL CONTENT -->
    </div>
    <!-- END MODAL TIMEUP -->

@endsection

@push('script')
    <script src="{{ URL('js/game/RoomPlay.js') }}" defer></script>
    <script>
        var isCreator = "<?php echo Session::get('creator') ?>";
        var room_id = "<?php echo $room->room_id ?>";
        var RoomStatus = "<?php echo $room->status ?>";
        var RoomRound = "<?php echo $room->round ?>";
        var RoomCircle = "<?php echo $room->circle ?>";
        var RuleCircle = "<?php echo $room->rule_circle ?>";
        var RuleRound = "<?php echo $room->level_round ?>";
        var Timeout = new Date('<?php echo $room->time ?>').getTime();
        var AmtNextCircle = "<?php echo $amt_next_circle ?>";
        var amtNMSelect = (AmtNextCircle == 5) ? 1 : 2;
        
        const RoutePollLinks = "<?php echo Route('PollLinks'); ?>";
        const RouteStartTimer = "<?php echo Route('StartTimer'); ?>";
        const RouteEndTimer = "<?php echo Route('EndTimer'); ?>";
        const RouteFetchTimeout = "<?php echo Route('FetchTimeout'); ?>";
        const RouteFetchCards = "<?php echo Route('FetchCards'); ?>";
        const RouteFetchResults = "<?php echo Route('FetchResults'); ?>";
        const RouteCardAdd = "<?php echo Route('CardAdd'); ?>";
        const RouteCheckNightmareLink = "<?php echo Route('CheckNightmareLink'); ?>";
        const RouteStartNextRound = "<?php echo Route('StartNextRound'); ?>";
        const RouteStartNextCircle = "<?php echo Route('StartNextCircle'); ?>";
        const RouteGameEnd = "<?php echo Route('GameEnd'); ?>";
    </script>
@endpush