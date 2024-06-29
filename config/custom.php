<?php

return [
    'infant' => env('INFANT') ?? 1,
    'toddler' => env('TODDLER') ?? 3,
    'preschooler' => env('PRESCHOOLER') ?? 5,
    'child' => env('CHILD') ?? 12,
    'teenager_or_adolescent' => env('TEENAGER_OR_ADOLESCENT') ?? 19,
    'young_adult' => env('YOUNG_ADULT') ?? 39,
    'middle_aged_adult' => env('MIDDLE_AGED_ADULT') ?? 60,
    'senior_citizen_elderly' => env('SENIOR_CITIZEN_ELDERLY') ?? 100,
];
