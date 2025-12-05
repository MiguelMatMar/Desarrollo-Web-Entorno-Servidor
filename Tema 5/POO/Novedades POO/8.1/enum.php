<?php

    enum Status {
        case Pending;
        case Approved;
        case Rejected;
    }

    function show(Status $s) {
        echo $s->name;
    }

    show(Status::Approved);


?>