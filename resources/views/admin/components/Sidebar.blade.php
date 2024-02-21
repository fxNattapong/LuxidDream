<!-- START SIDEBAR -->
<nav id="sidebar" class="z-[100] relative sticky fixed top-0 left-0 min-w-[250px] max-w-[250px] max-md:min-w-0 max-md:max-w-[60px] bg-white min-h-[100vh] drop-shadow duration-300">
    <!-- START SWITCH -->
    <div id="btn-menu-switch" class="z-[100] hidden max-md:block absolute right-0 mr-[-9px] mt-[25px] flex items-center bg-[#8388d1] rounded-full duration-300">
        <i class='bx bx-chevron-right text-xl text-white'></i>
    </div>
    <!-- END SWITCH -->

    <div class="flex flex-col h-[100vh] px-6 max-md:px-[10px]">
        <div class="z-1 absolute top-0 left-0 w-full h-full">
            <img src="{{ URL('/assets/bg.png') }}" alt="bg" class="w-full h-full object-cover">
        </div>

        <!-- START HEADER -->
        <div class="flex items-center justify-center gap-2 mt-5">
            <div id="img-logo" class="z-50 relative bg-white rounded-full w-auto max-md:min-w-[45px] h-[80px] max-md:h-full p-1 overflow-hidden">
                <img src="{{ URL('/assets/mini-logo.png') }}" alt="logo" class="w-full h-full object-cover my-auto">
            </div>
            <div id="text-logo" class="z-50 relative w-auto w-[100px] h-[80px] p-1 overflow-hidden max-md:hidden">
                <img src="{{ URL('/assets/logo.png') }}" alt="logo" class="w-full h-full object-cover my-auto">
            </div>
        </div>
        <!-- END HEADER -->
        <hr>

        <!-- START CONTENT -->
        <nav class="z-50 flex-1 grow mt-4">
            <ul class="flex-col flex justify-between h-full ">
                <!-- START MENU -->
                <li class="grow overflow-hidden">
                    <ul class="text-gray-200 space-y-2 whitespace-nowrap">
                        <li>
                            <a href="{{ Route('Dashboard') }}" id="Dashboard" class="flex items-center font-medium gap-2 w-full p-2 hover:text-blue-700 hover:bg-[#E4E9F7] duration-300 rounded">
                                <i class='bx bxs-dashboard text-2xl'></i>
                                <span>ภาพรวม</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ Route('Players') }}" id="Players" class="flex items-center font-medium gap-2 w-full p-2 hover:text-indigo-600 hover:bg-[#E4E9F7] duration-300 rounded">
                                <i class='bx bxs-user-rectangle text-2xl'></i>
                                <span>ผู้เล่น</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- END MENU -->

                <!-- START SETTINGS -->
                <li class="relative flex-col flex w-auto mt-auto mb-3 bottom-0">
                    <a onClick="openMenuLogged()" id="btnLoggedMenu" class="relative flex w-[100%] px-2 hover:bg-[#E4E9F7] rounded duration-300 cursor-pointer overflow-hidden">
                        <div class="z-20 flex items-center w-full text-gray-700 gap-2 py-1">
                            <div class="relative bg-white w-[40px] max-md:min-w-[30px] h-[40px] max-md:h-[30px] max-md:ml-[-3px] rounded-full p-1 overflow-hidden border">
                                @if(Session::get('image'))
                                    <img src="{{ URL('/uploads/'.Session::get('image')) }}" alt="" class="w-full h-full object-cover my-auto scale-125" alt="logo">
                                @else
                                    <img src="{{ URL('/assets/member.png') }}" alt="" class="w-full h-full object-cover my-auto scale-125" alt="logo">
                                @endif
                            </div>
                            <span id="btn-logged" class="text-lg overflow-x-hidden">{{ Session::get('username') }}</span>
                            <i id="icon-settings" class='bx bx-chevron-down text-2xl ml-auto mr-0 duration-300'></i>
                        </div>
                        <div class="z-10 w-full h-full absolute top-0 left-0 bg-indigo-200 opacity-50 rounded"></div>
                    </a>

                </li>

                <li class="-mt-2 mb-3 ml-[20px] max-md:ml-0">
                    <div id="menu-logged" class="z-[100] hidden space-y-1 text-white rounded-md duration-800 h-0 duration-300 overflow-hidden">
                        <button id="btn-account-edit" class="relative w-full"
                        onClick="FetchAccountData(this)" data-route="" data-username="{{ Session::get('username') }}">
                            <div class="flex items-center font-medium gap-2 w-full p-2 hover:text-indigo-600 hover:bg-indigo-100 duration-300 rounded">
                                <i class='z-20 bx bxs-edit text-2xl' ></i>
                                <span class="z-20 whitespace-nowrap">ข้อมูลของฉัน</span>
                            </div>
                            <div class="z-10 w-full h-full absolute top-0 left-0 bg-indigo-300 opacity-50 rounded"></div>
                        </button>
                        <button id="btn-logout" class="relative w-full"
                        data-route="{{ Route('Logout') }}">
                            <div class="flex items-center font-medium gap-2 w-full p-2 hover:text-indigo-600 hover:bg-red-100 duration-300 rounded">
                                <i class='z-20 bx bx-log-out text-2xl' ></i>
                                <span class="z-20 whitespace-nowrap">ออกจากระบบ</span>
                            </div>
                            <div class="z-10 w-full h-full absolute top-0 left-0 bg-red-300 opacity-50 rounded"></div>
                        </button>
                    </div>
                </li>
                <!-- END SETTINGS -->
            </ul>
        </nav>
        <!-- END CONTENT -->
    </div>
</nav>
<!-- END SIDEBAR -->


<!-- START MODAL ACCOUNT EDIT -->
<div id="modal-account-edit" class="modal hidden z-[100] fixed flex left-0 top-0 w-[100%] h-[100%] overflow-auto max-md:p-[10px]">
    <!-- START MODAL CONTENT -->
    <div class="modal-content bg-white m-auto p-[20px] rounded-md drop-shadow-xl xl:w-[40%] lg:w-[60%] md:w-[60%] sm:w-[70%]">
        <div class="flex items-center">
            <p class="text-xl font-bold w-full ml-4 text-center">แก้ไขบัญชีนี้</p>
            <span id="icon-account-edit-close" class="text-gray-500 text-[30px] font-medium absolute top-0 right-0 mr-4 hover:text-indigo-600 cursor-pointer">&times;</span>
        </div>
        <hr class="mt-4">
        <div class="mt-2">
            <form id="form-account-edit" action="#!" method="post" onsubmit="return false;"
            data-route="">
                <input type="text" id="account_id" class="hidden" readonly>
                <div class="grid gap-6 mb-6 grid-cols-2">
                    <div class="max-sm:col-span-2">
                        <label for="account_username" class="block mb-2 text-md font-medium text-gray-700">ชื่อผู้ใช้ <span class="text-white text-xl">*</span></label>
                        <input type="text" id="account_username" class="bg-gray-200 border border-gray-300 text-gray-700 text-md font-light rounded-lg  block w-full p-2 outline-none cursor-not-allowed" readonly>
                    </div>
                    <div class="relative w-full max-sm:col-span-2">
                        <label for="account_password" class="block mb-2 text-md font-medium text-gray-700">รหัสผ่าน <span class="text-red-800 text-xl">*</span></label>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 z-10 mt-9">
                            <input class="hidden js-password-toggle" id="toggle" type="checkbox" />
                            <label class="js-password-label bg-gray-300 hover:bg-gray-400 duration-300 rounded px-2 py-1 text-sm text-gray-600 cursor-pointer" for="toggle">แสดง</label>
                        </div>
                        <div class="relative float-label-input">
                            <input type="password" id="account_password" class="js-password bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="รหัสผ่านขั้นต่ำ 4 ตัวอักษร">
                        </div>
                    </div>
                    <div>
                        <label for="account_firstname" class="block mb-2 text-md font-medium text-gray-700">ชื่อ <span class="text-red-800 text-xl">*</span></label>
                        <input type="text" id="account_firstname" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="กรุณากรอกชื่อ" required>
                    </div>
                    <div>
                        <label for="account_lastname" class="block mb-2 text-md font-medium text-gray-700">นามสกุล <span class="text-red-800 text-xl">*</span></label>
                        <input type="text" id="account_lastname" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="กรุณากรอกนามสกุล" required>
                    </div>
                    <div class="max-md:col-span-2">
                        <div class="inline-flex gap-2">
                            <label for="account_phone" class="whitespace-nowrap mb-2 text-md font-medium text-gray-700">หมายเลขโทรศัพท์</label>
                            <span id="phoneLengthWarning" class="hidden text-sm text-rose-700 font-light mt-[2px] max-sm:mt-[3px]"></span>
                        </div>
                        <input type="text" id="account_phone" class="bg-gray-50 border border-gray-300 text-gray-700 text-md font-light rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 outline-none" placeholder="กรุณากรอกหมายเลขโทรศัพท์">
                    </div>
                    <div class="max-md:col-span-2">
                        <p class="mb-2 text-md font-medium text-gray-700">รูปภาพผู้ใช้</p>
                        <div class="flex items-center space-x-2 bg-gray-200 rounded-lg w-full">
                            <div class="shrink-0 ml-1 mt-1 mb-1 bg-white rounded-full">
                                <img id='account_image' class="h-11 w-11 object-cover rounded-full" src="{{ URL('/assets/'.'admin.png') }}" alt="Current profile photo" />
                            </div>
                            <label class="block w-fit">
                                <span class="sr-only">Choose profile photo</span>
                                <input type="file" onChange={fileChosen_Single(event)} id="account_image" name="image" accept="image/png, image/jpeg" class="block w-full text-sm text-slate-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100 duration-300
                                "/>
                            </label>
                        </div>
                    </div>
                </div>
                <hr class="mb-1 mt-3">
                <button type="submit" onClick="SubmitAccountEdit()" class="w-full text-md font-medium text-white text-center bg-blue-700 hover:bg-blue-800 rounded-lg px-5 py-2 duration-300 focus:ring-4 focus:outline-none focus:ring-blue-300">บันทึก</button>
            </form>
        </div>
    </div>
    <!-- END MODAL CONTENT -->
</div>
<!-- END MODAL ACCOUNT EDIT -->