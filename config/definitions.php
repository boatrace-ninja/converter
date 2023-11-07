<?php

return [
    'Converter' => \DI\create('\Boatrace\Ninja\Converter')->constructor(
        \DI\get('MainConverter')
    ),
    'MainConverter' => function ($container) {
        return $container->get('\Boatrace\Ninja\MainConverter');
    },
];
