<?php

use App\Observable\LoginObservable;
use App\Observer\LoginObserver;

return [
    LoginObservable::class => [
        LoginObserver::class
    ],
];