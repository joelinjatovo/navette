<?php

return [
    'secret' => env('STRIPE_KEY_SECRET'),
    'public' => env('STRIPE_KEY_PUBLIC'),
    'webkook' => [
		'secret' => env('STRIPE_WEBHOOK_SECRET'),
	],
];
