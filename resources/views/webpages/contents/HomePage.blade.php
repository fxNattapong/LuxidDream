@extends('webpages.layouts.Layout')

@section('Content')
  <link href="{{ asset('css/webpages/homepage.css') }}" rel="stylesheet">

  <div class="banner flex items-center justify-center">
    <div class="story">
      <div class="grid grid-cols-2">
        <div>
          <h2 class="pt-8 text-2xl text-gray-400">Overview</h2>
          <h1 class="pt-6 text-5xl">Luxid Dream</h1>
          <div class="pt-6 text-xl text-gray-400">
            <p>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;In 253 ME (Mythical Era), the
              Magical Empire was a dream land where all living creatures lived
              together peacefully. <br />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unfortunately, there was a
              mythical illness spreading, Luxid Dream, causing patients unable to
              wake up. With the help of Dream Travelers, they are finding the
              cause of this illness and curing affected creatures. <br />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;In Luxid Dream, players play as
              Dream Travelers who can travel between Dream and Reality to learn
              about the nightmares and try to find calmness so that the patient
              can wake up willingly.
            </p>
          </div>
        </div>
        <div class="flex justify-center items-center">
          <img
            class="img-fluid"
            src="../../../assets/images/item-11.png"
            width="500"
            height="500" />
        </div>
      </div>
    </div>
  </div>
@endsection