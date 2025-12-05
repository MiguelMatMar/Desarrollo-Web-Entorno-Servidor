<?php

    class User {
    public function __construct(
        public string $name,
        public int $age
    ) {}
    }

    $user = new User("Ana", 30);

    ['name' => $n, 'age' => $a] = $user;

    echo "$n tiene $a años";


?>