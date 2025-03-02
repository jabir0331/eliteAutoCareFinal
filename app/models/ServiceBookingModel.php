<?php

    class ServiceBookingModel{
        
        use Model;

        protected $table = "service_booking";

        protected $allowed_columns = [
            'booking_id',
            'user_id',
            'vehicle_id',
            'service_date',
            'time_slot',
            'service_status',
            'total_cost'
        ];
    }