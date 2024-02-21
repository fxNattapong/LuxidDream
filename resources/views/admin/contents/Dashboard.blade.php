<title>Dashboard | Puenmeaw</title>

@extends('admin/layouts/Layout')

@section('Content')

    <!-- START HEADER -->
    <div class="relative w-[100%]">
        <div class="flex relative max-sm:flex-col">
            <div class="flex items-center whitespace-nowrap text-2xl text-gray-900 font-medium gap-2 overflow-hidden">
                <i class="fi fi-rr-dashboard text-2xl"></i>
                <span class="">ภาพรวม</span>
            </div>
        </div>
        
        <div class="relative mt-6 mb-4">
            <div class="absolute top-[-3px] w-2 h-2 bg-gray-700 rounded-full"></div>
            <hr class="border border-gray-700 my-2">
        </div>
    </div>
    
    <!-- END HEADER -->

    <!-- START CONTENT -->
    <div class="relative">

        <div class="grid grid-cols-3 max-lg:grid-cols-1 gap-[0.938em] max-lg:gap-x-0">

        </div>

    </div>
    <!-- END CONTENT -->

@endsection

@push('script')
    <script src="{{ URL('js/admin/Dashboard.js') }}" defer></script>
@endpush