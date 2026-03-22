@extends('layouts.app')

@section('title', 'Rooms')

@section('content')

<div class="container">

    <h2>Select your stay at Zotel Demo Property.</h2>
    <p class="sub-text">1 night · 1 adult · 10% long stay discount · 9% last minute deal</p>

    <!-- Another Room -->
    <div class="room-card">
        <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a" />

        <div class="room-details">
            <h3>Deluxe Room</h3>
            <p>Spacious room with king bed, seating area, and panoramic city views. 36 sqm.</p>

            <div class="option">
                <div>
                    <strong>Room Only</strong><br>
                    <span class="discount">-10%</span>
                    <span class="discount red">-9%</span>
                    <span class="old-price">₹2,000</span>
                </div>

                <div class="price-box">
                    <h4>₹1,638</h4>
                    <small>1 night</small>
                    <button>Select</button>
                </div>
            </div>

            <div class="option">
                <div>
                    <strong>With Breakfast</strong><br>
                    <span class="discount">-10%</span>
                    <span class="discount red">-9%</span>
                    <span class="old-price">₹2,400</span>
                </div>

                <div class="price-box">
                    <h4>₹1,966</h4>
                    <small>1 night</small>
                    <button>Select</button>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection