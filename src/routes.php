<?php

return [
    '~^articles/add$~' => [\MyProject\Controllers\ArticlesController::class, 'add'],
    '~^articles/(\d+)$~' => [\MyProject\Controllers\ArticlesController::class, 'view'],
    '~^articles/(\d+)/comments$~' => [\MyProject\Controllers\CommentsController::class, 'add'],
    '~^articles/(\d+)/delete$~' => [\MyProject\Controllers\ArticlesController::class, 'delete'],
    '~^comments/(\d+)/edit$~' => [\MyProject\Controllers\CommentsController::class, 'edit'],
    '~^comments/(\d+)/delete$~' => [\MyProject\Controllers\CommentsController::class, 'delete'],
    '~^article/(\d+)/edit$~' => [\MyProject\Controllers\ArticlesController::class, 'edit'],
    '~^hello/(.*)$~'     => [\MyProject\Controllers\MainController::class, 'sayHello'],
    '~^bye/(.*)$~'       => [\MyProject\Controllers\MainController::class, 'sayBye'],
    '~^about-me$~'       => [\MyProject\Controllers\MainController::class, 'aboutMe'],
    '~^$~'               => [\MyProject\Controllers\MainController::class, 'main'],
];


