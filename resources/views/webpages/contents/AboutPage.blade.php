<title>About | LuxidDream</title>

@extends('webpages.layouts.Layout')

@section('Content')
  <link href="{{ asset('css/webpages/aboutpage.css') }}" rel="stylesheet">

  <div class="banner">
      <div class="story h-full flex justify-center items-center flex p-8 max-md:p-4 scale-125">
              @php
                  $AboutPages = [];
                  for ($i = 1; $i <= 13; $i++) {
                      $AboutPages[] = 'aboutTH_' . $i . '.png';
                  }
              @endphp

              @include('webpages.components.Slider', ['Pages' => $AboutPages])

      </div>
  </div>

@endsection