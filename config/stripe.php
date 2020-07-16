<?php

return [
    'secret' => env('STRIPE_KEY_SECRET'),
    'public' => env('STRIPE_KEY_PUBLIC'),
    'webhook' => [
		'secret' => env('STRIPE_WEBHOOK_SECRET'),
	],
];
