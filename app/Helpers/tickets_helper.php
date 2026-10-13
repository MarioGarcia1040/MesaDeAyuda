<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Helper para manejar la lógica de tickets.
 * 12-Octubre-2026 | 13-Octubre-2026
 * 
 */

use App\Models\TicketModel;

if (! function_exists('active_tickets_count')) {
    function active_tickets_count(): int
    {
        $user = auth()->user();
        if (! $user) {
            return 0;
        }

        $esStaff = $user->inGroup('admin', 'user');
        
        return model(TicketsModel::class)->countActive($user->id, $esStaff);
    }
}