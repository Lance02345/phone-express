<?php

return [
    'inventory_stale_after_hours' => (int) env('INVENTORY_STALE_AFTER_HOURS', 24),

    // Product names promoted as "New · Available now" on the home page, shop and product pages.
    'new_arrivals' => ['iPhone 18 Pro', 'iPhone 18 Pro Max', 'iPhone Duo'],
];
