<?php

    enum Status {
    case Pending;
    case Approved;
    case Rejected;
}

class Order {
    public function __construct(public Status $status) {}
}

$order = new Order(Status::Approved);


?>