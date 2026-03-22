@extends('layouts.app')

@section('title', 'Rooms')

@section('content')

    <div class="center-content">

        <div id="roomResults"></div>

        <!-- Sticky Bottom Summary -->
        <div id="bookingSummary"></div>

        <!-- Booking Success Page -->
        <div id="bookingConfirmation"></div>
        
        <div class="dashboard" id="dashboard">
            <div class="icon">🔍</div>
            <h2>Zotel Demo Property</h2>
            <p>Select your dates and number of guests, then search to see available rooms with transparent pricing.</p>
        
            <div class="buttons">
                <a class="button" href="/discount">⚙ Discounts</a> | 
                <a class="button" href="/inventory">📦 Inventory</a>
            </div>
        </div>
        
    </div>

@endsection