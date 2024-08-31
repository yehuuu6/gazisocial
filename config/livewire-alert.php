<?php

/*
 * For more details about the configuration, see:
 * https://sweetalert2.github.io/#configuration
 */
return [
    'alert' => [
        'position' => 'top-end',
        'timer' => 3000,
        'toast' => true,
        'text' => null,
        'animation' => false,
        'iconColor' => 'white',
        'showCancelButton' => false,
        'showConfirmButton' => false,
        'position' =>  'bottom-end',
        'didOpen' => '(toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }',
        'timerProgressBar' => true,
        'customClass' => [
            'popup' => 'colored-toast',
        ]
    ],
];
