<?php

    class ServiceTypesModel{

        use Model;
        
        protected $table = 'service_types';

        protected $allowedColumns = [
            'service_type_id',
            'service_name',
            'description',
            'base_price',
            'estimated_duration',
            'is_available'
        ];


    }