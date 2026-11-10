<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Controlador muestra el dashboard de la aplicación.
 * 09-Septiembre-2026 | 04-Noviembre-2026
 * 
 */

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TicketsModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $usersTotal = auth()->getProvider()->countAllResults();
        $ticketsModel = new TicketsModel();
               
        return view('template/dashboard', [
            'title'              => 'Dashboard',
            'usersTotal'         => $usersTotal,
        ]);
    }
}
