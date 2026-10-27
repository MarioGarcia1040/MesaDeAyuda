<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Controlador muestra la lista de tickets.
 * 2-Octubre-2026 | 25-Octubre-2026
 * 
 */

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TicketsModel;

class TicketsController extends BaseController
{
    public function myTickets()
    {
        return view('template/tickets', [
            'title' => 'Shoei | Mis Tickets',
        ]);
    }

    public function all()
    {
        $ticketModel = new TicketsModel();

        return view('template/tickets', [
            'title'                 => 'Shoei | Todos los Tickets',
            'countTicketsByStatus'  => $ticketModel->countByStatus(),
            'tickets'               => $ticketModel->withRelations()->findAll(),
            'priorityLabel'         => TicketsModel::PRIORITY_LABELS,
        ]);
    }
}
