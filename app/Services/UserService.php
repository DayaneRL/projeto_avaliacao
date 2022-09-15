<?php

namespace App\Services;

class UserService{
    public static function getDashboardRouteBasedOnUserRole($userRole){
        if($userRole === 'user'){
            return route('dashboard.index');
        }

        if($userRole === 'admin'){
            return route('users.index');
        }
    }
}

?>
