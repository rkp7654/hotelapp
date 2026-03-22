@extends('layouts.app')

@section('title', 'Inventory')

@section('content')

<div class="container">

    <h2>Inventory & Pricing</h2>

    <!-- Tabs -->
    <div class="tabs">
        <a href="/inventory?room=1" class="{{ $roomTypeSlug === 1 ? 'active' : '' }}">Standard Room</a>
        <a href="/inventory?room=2" class="{{ $roomTypeSlug === 1 ? 'active' : '' }}">Deluxe Room</a>
    </div>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th>ROOM NO</th>
                <th>ROOM TYPE</th>
                <th>DATE</th>
                <th>AVAIL.</th>
                <th>1 PERSON</th>
                <th>2 PERSONS</th>
                <th>3 PERSONS</th>
                <th>BREAKFAST</th>
            </tr>
        </thead>

        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item['room_number'] }}</td>
                <td>{{ $item['room_type'] }}</td>

                <td>
                    {{ $item['date'] }}<br>
                    <small>{{ $item['day'] }}</small>
                </td>

                <td>{{ $item['avail'] }}</td>
                <td>₹{{ number_format($item['price_1']) }}</td>
                <td>₹{{ number_format($item['price_2']) }}</td>
                <td>₹{{ number_format($item['price_3']) }}</td>
                <td>₹{{ $item['breakfast'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection