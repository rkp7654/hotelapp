<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiscountType;
use App\Models\RoomType;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class HomeController extends Controller
{
    public function index(Request $request){
        return view('search');
    }

    public function discount(Request $request)
    {
        $longStay = DiscountType::with('discounts')
                    ->where('name', 'Long Stay')
                    ->first();

        $lastMinute = DiscountType::with('discounts')
                    ->where('name', 'Last Minute')
                    ->first();

        $longStayDiscounts = $longStay ? $longStay->discounts->map(function ($d) {
            return [
                'min_nights' => $d->days,
                'discount'   => $d->discount,
            ];
        }) : [];

        $lastMinuteDiscounts = $lastMinute ? $lastMinute->discounts->map(function ($d) {
            return [
                'days_ahead' => $d->days,
                'discount'   => $d->discount,
            ];
        }) : [];

        return view('discount', compact('longStayDiscounts', 'lastMinuteDiscounts'));
    }

    public function inventory(Request $request)
    { 
        $roomTypeSlug = $request->input('room', 1);
        // Get Room Type
        $roomType = RoomType::where('id', $roomTypeSlug)->firstOrFail();

        

        // Date range (next 15 days)
        $startDate = Carbon::today();
        $endDate   = Carbon::today()->addDays(30);

        // Fetch inventory with prices
        $inventories = $roomType->inventories()
            ->whereBetween('available_on', [$startDate, $endDate])
            ->with('prices')
            ->orderBy('available_on')
            ->get();

        // $inventories = json_encode($inventories);
        // $inventories = json_decode($inventories, true);
        //  echo '<pre>'; print_r($inventories); die('Hii');
        $data = [];

        foreach ($inventories as $inv) {

            // Default prices
            $price1 = 0;
            $price2 = 0;
            $price3 = 0;

            foreach ($inv->prices as $price) {
                if ($price->person_count == 1) {
                    $price1 = $price->price;
                }
                if ($price->person_count == 2) {
                    $price2 = $price->price;
                }
                if ($price->person_count == 3) {
                    $price3 = $price->price;
                }
            }

            $data[] = [
                'room_number' => $inv->room_number,
                'room_type' => $roomType->name,
                'date'      => Carbon::parse($inv->available_on)->format('d M Y'),
                'day'       => Carbon::parse($inv->available_on)->format('D'),
                'avail'     => $inv->available_rooms,
                'price_1'   => $price1,
                'price_2'   => $price2,
                'price_3'   => $price3,
                'breakfast' => $inv->breakfast_price,
            ];
        }

       

        return view('inventory', compact('data', 'roomTypeSlug'));
    }

    public function searchRooms(Request $request)
    {
        $checkin  = $request->checkin;
        $checkout = $request->checkout;
        $guests   = $request->guests;

        $dates = CarbonPeriod::create($checkin, Carbon::parse($checkout)->subDay());

        $roomTypes = RoomType::with(['inventories' => function ($q) use ($checkin, $checkout) {
            $q->whereBetween('available_on', [$checkin, $checkout])
            ->where('available_rooms', '>', 0)
            ->with('prices');
        }])->get();

        $result = [];

        foreach ($roomTypes as $room) {

            if ($room->inventories->isEmpty()) continue;

            $priceOptions = [];

            // 🔥 Group inventories by date
            $inventoriesByDate = $room->inventories->keyBy(function ($item) {
                return Carbon::parse($item->available_on)->format('Y-m-d');
            });

            $totalRoomOnly = 0;
            $totalWithBreakfast = 0;

            $isAvailable = true;

            foreach ($dates as $date) {

                $dateStr = $date->format('Y-m-d');

                if (!isset($inventoriesByDate[$dateStr])) {
                    $isAvailable = false;
                    break;
                }

                $inv = $inventoriesByDate[$dateStr];

                // ✅ Get price for guest count
                $priceRow = $inv->prices->firstWhere('person_count', $guests);

                if (!$priceRow) {
                    $isAvailable = false;
                    break;
                }

                // ✅ Sum per day price
                $totalRoomOnly += $priceRow->price;
                $totalWithBreakfast += ($priceRow->price + $inv->breakfast_price);
            }

            if (!$isAvailable) continue;

            $nights = count($dates);

            // ✅ Apply discounts on TOTAL
            $longStayDiscount   = ($nights >= 3) ? 10 : 0;
            $lastMinuteDiscount = (now()->diffInDays(Carbon::parse($checkin)) <= 3) ? 9 : 0;

            // Room Only
            $finalRoomOnly = $totalRoomOnly;
            $finalRoomOnly -= ($finalRoomOnly * $longStayDiscount / 100);
            $finalRoomOnly -= ($finalRoomOnly * $lastMinuteDiscount / 100);

            // With Breakfast
            $finalBreakfast = $totalWithBreakfast;
            $finalBreakfast -= ($finalBreakfast * $longStayDiscount / 100);
            $finalBreakfast -= ($finalBreakfast * $lastMinuteDiscount / 100);

            $priceOptions[] = [
                'meal_type' => 'Room Only',
                'original_price' => $totalRoomOnly,
                'final_price' => round($finalRoomOnly),
                'long_stay_discount' => $longStayDiscount,
                'last_minute_discount' => $lastMinuteDiscount,
                'nights' => $nights
            ];

            $priceOptions[] = [
                'meal_type' => 'With Breakfast',
                'original_price' => $totalWithBreakfast,
                'final_price' => round($finalBreakfast),
                'long_stay_discount' => $longStayDiscount,
                'last_minute_discount' => $lastMinuteDiscount,
                'nights' => $nights
            ];

            $result[] = [
                'name' => $room->name,
                'description' => 'Comfortable stay',
                'image' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a',
                'prices' => $priceOptions
            ];
        }

        return response()->json([
            'rooms' => $result
        ]);
    }
}