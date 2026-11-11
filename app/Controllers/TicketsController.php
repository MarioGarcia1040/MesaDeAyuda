<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Controlador muestra la lista de tickets.
 * 2-Octubre-2026 | 11-Noviembre-2026
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
        $ticketModel = new TicketsModel();
        $categoriesModel = new CategoriesModel();
        $userModel = new UserModel();

        return view('template/tickets', [
            'title'                 => 'Mis Tickets',
            'countTicketsByStatus'  => $ticketModel->applicant(auth()->id())->countByStatus(),
            'tickets'               => $ticketModel->withRelations()->applicant(auth()->id())->findAll(),
            'priorityLabel'         => TicketsModel::PRIORITY_LABELS,
            'categories'            => $categoriesModel->findAll(),
            'users'                 => $userModel->getUsersWithProfileDetails(),
        ]);
    }

    public function all()
    {
        $ticketModel = new TicketsModel();
        $categoriesModel = new CategoriesModel();
        $userModel = new UserModel();

        return view('template/tickets', [
            'title'                 => 'Todos',
            'countTicketsByStatus'  => $ticketModel->countByStatus(),
            'tickets'               => $ticketModel->withRelations()->findAll(),
            'priorityLabel'         => TicketsModel::PRIORITY_LABELS,
            'categories'            => $categoriesModel->findAll(),
            'users'                 => $userModel->getUsersWithProfileDetails(),
        ]);
    }
    
    public function assigned()
    {
        $ticketModel = new TicketsModel();
        $categoriesModel = new CategoriesModel();
        $userModel = new UserModel();

        return view('template/tickets', [
            'title'                 => 'Asignados',
            'countTicketsByStatus'  => $ticketModel->assigned(auth()->id())->countByStatus(),
            'tickets'               => $ticketModel->withRelations()->assigned(auth()->id())->findAll(),
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
