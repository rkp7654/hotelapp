<header class="top-bar">
    <div class="search-container">

        <!-- Check-in -->
        <div class="field fieldshowhide">
            <label>CHECK-IN</label>
            <input type="date" id="checkin">
        </div>

        <!-- Check-out -->
        <div class="field fieldshowhide">
            <label>CHECK-OUT</label>
            <input type="date" id="checkout">
        </div>

        <!-- Guests -->
        <div class="field guests fieldshowhide">
            <label>ADULTS</label>
            <div class="guest-box">
                <button onclick="changeGuest(-1)">-</button>
                <span id="guestCount">1</span>
                <button onclick="changeGuest(1)">+</button>
            </div>
        </div>

        <!-- Search Button -->
        <button class="search-btn fieldshowhide" onClick="FetchAvailableRooms()">
            🔍 Search
        </button>

        <!-- Menu -->
        <div class="menu-btn" onclick="toggleMenu()">
            ☰
        </div>

    </div>

    <!-- Dropdown Menu -->
    <div class="menu-dropdown" id="menu">
        <a href="/">Home</a>
        <a href="/discount">⚙ Discounts</a>
        <a href="/inventory">📦 Inventory</a>
    </div>
</header>