<?php

    class User {
    public string $name {
        get => $this->name;
        set => $this->name = ucfirst($value);
    }
    }

    $user = new User();
    $user->name = "ana";
    echo $user->name; // Ana


?>