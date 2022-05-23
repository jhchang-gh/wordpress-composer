<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class BiographyDetailPage extends Controller
{
    public function fields()
    {
        if (function_exists('get_fields')) {
            return get_fields();
        } else {
            return 'ACF DISABLE';
        }
    }



}


