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
use App\Models\CategoriesModel;
use App\Models\UserModel;

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
        $categoriesModel = new CategoriesModel();
        $userModel = new UserModel();

        return view('template/tickets', [
            'title'                 => 'Shoei | Todos los Tickets',
            'countTicketsByStatus'  => $ticketModel->countByStatus(),
            'tickets'               => $ticketModel->withRelations()->findAll(),
            'priorityLabel'         => TicketsModel::PRIORITY_LABELS,
            'categories'            => $categoriesModel->findAll(),
            'users'                 => $userModel->getUsersWithProfileDetails(),
        ]);
    }
    
    public function create()
    {
        if (! $this->validate('createTicket')) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'success' => false,
                    'errors'  => $this->validator->getErrors(),
                    'csrf'    => csrf_hash(),
                ]);
        }

        $ticketModel = new TicketsModel();

        $data = [
            'subject'      => $this->request->getPost('subject'),
            'category_id'  => $this->request->getPost('category_id') ?: null,
            'description'  => $this->request->getPost('description'),
            'status'       => TicketsModel::STATUS_OPEN,
            'priority'     => $this->request->getPost('priority'),
            'applicant_id' => $this->request->getPost('applicant_id'),
        ];

        $created = (bool) $ticketModel->insert($data);

        if ($created) {
            session()->setFlashdata('success', 'Ticket creado correctamente');
        } else {
            session()->setFlashdata('error', 'Error al crear el ticket');
        }

        return $this->response->setJSON([
            'success'  => $created,
            'redirect' => base_url('tickets/all'),
            'csrf'     => csrf_hash(),
        ]);
    }
}
