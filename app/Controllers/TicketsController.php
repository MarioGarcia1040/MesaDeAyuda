<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Controlador muestra la lista de tickets.
 * 2-Octubre-2026 | 10-Octubre-2026
 * 
 */

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TicketsController extends BaseController
{
    public function index()
    {
        return view('template/tickets', [
            'title' => 'Shoei | Tickets'
        ]);
    }

    public function myTickets()
    {
        return view('template/tickets', [
            'title' => 'Shoei | Mis Tickets'
        ]);
    }

    public function all()
    {
        return view('template/tickets', [
            'title' => 'Shoei | Todos los Tickets'
        ]);
    }
}
