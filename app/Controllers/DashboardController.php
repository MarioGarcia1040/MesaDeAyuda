<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Controlador muestra el dashboard de la aplicación.
 * 09-Septiembre-2026
 * 
 */

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $usersTotal = auth()->getProvider()->countAllResults();
        $ticketsModel = new \App\Models\TicketsModel();

        $activeTicketsCount = array_merge(
            array_fill_keys(\App\Models\TicketsModel::ACTIVE_STATUSES, 0),
            $ticketsModel->countByStatus($ticketsModel->scopeFor(auth()->getUser()))
        );
               
        return view('template/dashboard', [
            'title' => 'Shoei | Dashboard',
            'usersTotal' => $usersTotal,
            'activeTicketsCount' => array_sum($activeTicketsCount),
        ]);
    }
}
