<?php

    class ServiceBookingDetailsModel{

        use Model;

        protected $table = 'service_booking_details';

        protected $allowedColumns = [
            'detail_id',
            'booking_id',
            'service_type_id',
            'service_cost'
        ];
    }