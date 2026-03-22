let guests = 1;

function changeGuest(val) {
    console.log(guests);
    if(guests < 3){
        guests += val;
    }
    
    if (guests < 1) guests = 1;
    document.getElementById("guestCount").innerText = guests;
}

function toggleMenu() {
    let menu = document.getElementById("menu");
    menu.style.display = menu.style.display === "block" ? "none" : "block";
}

document.addEventListener("DOMContentLoaded", function () {

    let today = new Date();
    let todayStr = today.toISOString().split('T')[0];

    // Calculate max date (today + 30 days)
    let maxDate = new Date();
    maxDate.setDate(today.getDate() + 30);
    let maxDateStr = maxDate.toISOString().split('T')[0];

    let checkin = document.getElementById("checkin");
    let checkout = document.getElementById("checkout");

    // ✅ Check-in rules
    checkin.min = todayStr;
    checkin.max = maxDateStr;

    // ✅ Checkout rules
    checkin.addEventListener("change", function () {

        // Checkout must be >= checkin
        checkout.min = this.value;

        // Checkout must be within 30 days
        checkout.max = maxDateStr;

        // Optional: auto set next day
        let nextDay = new Date(this.value);
        nextDay.setDate(nextDay.getDate() + 1);

        let nextDayStr = nextDay.toISOString().split('T')[0];

        if (nextDayStr <= maxDateStr) {
            checkout.value = nextDayStr;
        }
    });

    let page = window.location.pathname.split('/')[1];

    let elements = document.getElementsByClassName('fieldshowhide');

    for (let i = 0; i < elements.length; i++) {
        if (page === 'inventory' || page === 'discount') {
            elements[i].style.display = 'none';
        } else {
            elements[i].style.display = '';
        }
    }

console.log(page);

});

function toggleSection(id) {
    let section = document.getElementById(id);

    if (section.style.display === "none") {
        section.style.display = "block";
    } else {
        section.style.display = "none";
    }
}

function FetchAvailableRooms() {

    let checkin  = document.getElementById('checkin').value;
    let checkout = document.getElementById('checkout').value;
    let guests   = document.getElementById('guestCount').innerText;

    if (!checkin || !checkout) {
        alert('Please select check-in and check-out date');
        return;
    }

    fetch('/search-rooms', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            checkin: checkin,
            checkout: checkout,
            guests: guests
        })
    })
    .then(res => res.json())
    .then(data => {
        
        document.getElementById('dashboard').style.display = 'none';
        
        let html = '';

        if (data.rooms.length === 0) {
            html = '<p>No rooms available</p>';
        }

        data.rooms.forEach(room => {

            html += `
            <div class="room-card">
                <img src="${room.image}" />

                <div class="room-details">
                    <h3>${room.name}</h3>
                    <p>${room.description}</p>
            `;

            room.prices.forEach(price => {

                html += `
                    <div class="option">
                        <div>
                            <strong>${price.meal_type}</strong><br>
                            <span class="discount">-${price.long_stay_discount}%</span>
                            <span class="discount red">-${price.last_minute_discount}%</span>
                            <span class="old-price">₹${price.original_price}</span>
                        </div>

                        <div class="price-box">
                            <h4>₹${price.final_price}</h4>
                            <small>${price.nights} night</small>
                            <button onclick='selectRoom(${JSON.stringify({
                                room: room.name,
                                plan: price.meal_type,
                                price: price.final_price,
                                original: price.original_price,
                                long: price.long_stay_discount,
                                last: price.last_minute_discount,
                                nights: price.nights
                            })})' style="cursor:pointer;">Select</button>
                        </div>
                    </div>
                `;
            });

            html += `</div></div>`;
        });

        document.getElementById('roomResults').innerHTML = html;

    })
    .catch(error => console.error(error));
}

function selectRoom(data) {

    let checkin  = document.getElementById('checkin').value;
    let checkout = document.getElementById('checkout').value;
    let guests   = document.getElementById('guestCount').innerText;

    selectedBooking = {
        roomName: data.room,
        plan: data.plan,
        price: data.price,
        original: data.original,
        longDiscount: data.long,
        lastDiscount: data.last,
        nights: data.nights,
        checkin,
        checkout,
        guests
    };

    renderSummary();

     // ✅ Scroll to bottom
    window.scrollTo({
        top: document.body.scrollHeight,
        behavior: 'smooth'
    });

    document.getElementById('footer').style.bottom = "-21.5%";
}

function renderSummary() {
    
    document.getElementById('bookingSummary').style.opacity = 1;

    let html = `
    <div class="fixed bottom-0 left-0 right-0 z-50 border-t bg-white shadow-lg" style="align-items:center;width:100%;">
        <div class="mx-auto max-w-3xl px-4 py-4">
            <div class="flex justify-between items-center">

                <div>
                    <h3>Stay Summary</h3>
                    <p>${selectedBooking.roomName} · ${selectedBooking.plan}</p>
                    <p>${formatDate(selectedBooking.checkin)} – ${formatDate(selectedBooking.checkout)} · 
                       ${selectedBooking.guests} adult</p>

                    <div>
                        <span style="color:green;">
                            ${selectedBooking.longDiscount + selectedBooking.lastDiscount}% saved
                        </span>
                        <strong>₹${selectedBooking.price}</strong>
                    </div>
                </div>

                <div>
                    <button onclick="clearSelection()" class="clear">Clear</button>
                    <button onclick="confirmBooking()" class="booknow">Book Now</button>
                </div>

            </div>
        </div>
    </div>
    `;

    document.getElementById('bookingSummary').innerHTML = html;
}

function clearSelection() {
    selectedBooking = {};
    document.getElementById('bookingSummary').innerHTML = '';
}

function confirmBooking() {

    
    document.getElementById('roomResults').style.display = 'none';
    document.getElementById('bookingSummary').style.display = 'none';

    let ref = generateRef();

    let html = `
    <div class="flex min-h-screen items-center justify-center bg-gray-100">
        <div class="max-w-md bg-white p-6 rounded shadow text-center">

            <h2>✅ Booking Confirmed</h2>
            <p>Ref: ${ref}</p>

            <div style="text-align:left; margin-top:20px;">
                <p><strong>Room:</strong> ${selectedBooking.roomName}</p>
                <p><strong>Plan:</strong> ${selectedBooking.plan}</p>
                <p><strong>Dates:</strong> ${formatDate(selectedBooking.checkin)} – ${formatDate(selectedBooking.checkout)}</p>
                <p><strong>Guests:</strong> ${selectedBooking.guests} adult</p>

                <p><strong>Long Stay:</strong> -${selectedBooking.longDiscount}%</p>
                <p><strong>Last Minute:</strong> -${selectedBooking.lastDiscount}%</p>

                <h3>Total: ₹${selectedBooking.price}</h3>
            </div>

            <button onclick="reloadPage()">Make Another Booking</button>

        </div>
    </div>
    `;

    document.getElementById('bookingConfirmation').innerHTML = html;
}

function formatDate(dateStr) {
    let d = new Date(dateStr);
    return d.toDateString();
}

function generateRef() {
    return 'ZTL-' + Math.random().toString(36).substring(2, 10).toUpperCase();
}

function reloadPage() {
    location.reload();
}