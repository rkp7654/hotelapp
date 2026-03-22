@extends('layouts.app')

@section('title', 'Discount Configuration')

@section('content')

<div class="container">

    <h2>Discount Configuration</h2>

    <!-- LONG STAY -->
    <div class="section">

        <div class="section-header" onclick="toggleSection('longStay')">
            <h3>LONG STAY DISCOUNTS</h3>
            <span>▼</span>
        </div>

        <p>Applied when the stay meets minimum night thresholds.</p>

        <div id="longStay">

            <!-- Disabled Input Box -->
            <div class="card disabled" style="display:none;">
                <div>
                    <label>MIN NIGHTS</label>
                    <input type="number" value="1" disabled>
                </div>

                <div>
                    <label>DISCOUNT %</label>
                    <input type="number" value="10" disabled>
                </div>
            </div>

            <!-- List -->
            @foreach($longStayDiscounts as $item)
            <div class="list-item">
                <span class="badge">{{ $item['discount'] }}%</span>
                <span>{{ $item['min_nights'] }}+ nights</span>
            </div>
            @endforeach

        </div>

    </div>

    <!-- LAST MINUTE -->
    <div class="section">

        <div class="section-header" onclick="toggleSection('lastMinute')">
            <h3>LAST MINUTE DISCOUNTS</h3>
            <span>▼</span>
        </div>

        <p>Applied when check-in is within a specified number of days from today.</p>

        <div id="lastMinute">

            <div class="card disabled" style="display:none;">
                <div>
                    <label>DAYS AHEAD</label>
                    <input type="number" value="3" disabled>
                </div>

                <div>
                    <label>DISCOUNT %</label>
                    <input type="number" value="9" disabled>
                </div>
            </div>

            @foreach($lastMinuteDiscounts as $item)
            <div class="list-item">
                <span class="badge">{{ $item['discount'] }}%</span>
                <span>{{ $item['days_ahead'] }} days ahead</span>
            </div>
            @endforeach

        </div>

    </div>

</div>

@endsection