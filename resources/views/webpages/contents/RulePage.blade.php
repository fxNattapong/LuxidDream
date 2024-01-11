@extends('webpages.layouts.Layout')

@section('Content')
  <link href="{{ asset('css/webpages/rule-page.css') }}" rel="stylesheet">

  <div class="banner">
    <div class="story">
      <div class="header text-center">
        <p>SET UP</p>
        <img
          class="mx-auto"
          src="../../../assets/images/72.jpg"
          alt=""
          width="80%"
          height="40%" />
      </div>
      <!-- Board -->
      <div>
        <p class="topic mt-5">BOARD</p>
        <div class="paragraph">
          1. Randomly pick one nightmare for each type of nightmares and shuffle
          with dream location. <br />
          2. Form a cycle with 5 locations in random order where every player can
          reach and place connection tokens between each location to form a cycle.
          <br />
          3. Exchange 2 connections next to dream location with 2 blanks
          stabilizer. <br />
          4. Shuffle the rest of locations together, calm face up, to form a
          location pile. <br />
          5. Put the location pile in the cycle. <br />
          6. Shuffle all skills cards together and separate roughly equally into 2
          piles and place next to the cycle where every player can reach one of
          the piles. <br />
          7. Draw 2 skill cards for each nightmare location and place them in the
          area where arrow is positioned.
        </div>
        <hr class="line" />
        <!-- Player -->
        <div>
          <p class="topic mt-5">Player</p>
          <div class="paragraph">
            1. Each player picks a reference and a dream traveler with the same
            color, put the rest back in the box. <br />
            2. Everyone chooses a starting location by placing dream traveler on
            the dream location or the location immediately next to the dream
            location. <br />
            3. Give each player 5 dice, put the rest back in the box.
          </div>
        </div>
        <hr class="line" />
        <!-- Gameplay -->
        <div class="header text-center">
          <p>GAME PLAY</p>
          <div class="paragraph text-center">
            The objective of the game is to close dream cycles <br />
            depending on the number of players within the given rounds.
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection