<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Inventory;
use App\Models\Rental;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{
    // Formulario: seleccionar película, tienda, cliente, staff
    public function create()
    {
        $selectedFilmId = (int) request('film_id');

        $films = Film::orderBy('title')->get();
        $customers = Customer::orderBy('customer_id')->get();
        $staff = Staff::orderBy('staff_id')->get();

        return view('rentals.create', compact('films', 'customers', 'staff', 'selectedFilmId'));
    }


    // Crear renta
    public function store(Request $r)
    {
        $data = $r->validate([
            'film_id'     => 'required|integer|exists:film,film_id',
            'store_id'    => 'required|integer|exists:store,store_id',
            'customer_id' => 'required|integer|exists:customer,customer_id',
            'staff_id'    => 'required|integer|exists:staff,staff_id',
        ]);

        return DB::transaction(function () use ($data) {
            // Bloqueo por adeudo:
            $hasDebt = Rental::where('customer_id', $data['customer_id'])
                ->whereNull('return_date')
                ->lockForUpdate()
                ->exists();

            if ($hasDebt) {
                return back()
                    ->withErrors('El cliente tiene rentas pendientes. Debe devolver todas las películas antes de rentar nuevamente.')
                    ->withInput(['film_id' => $data['film_id']]); // conserva solo la película elegida
            }

            $inventory = Inventory::where('film_id', $data['film_id'])
                ->where('store_id', $data['store_id'])
                ->whereDoesntHave('rentals', fn($q) => $q->whereNull('return_date'))
                ->lockForUpdate()
                ->first();

            if (!$inventory) {
                return back()->withErrors('No hay copias disponibles en esta tienda.');
            }

            $rental = Rental::create([
                'rental_date' => now(),
                'inventory_id' => $inventory->inventory_id,
                'customer_id' => $data['customer_id'],
                'staff_id'    => $data['staff_id'],
                'return_date' => null,
            ]);

            $film = $inventory->film; // ← será la misma $data['film_id']
            Payment::create([
                'customer_id' => $data['customer_id'],
                'staff_id'    => $data['staff_id'],
                'rental_id'   => $rental->rental_id,
                'amount'      => $film->rental_rate,
                'payment_date' => now(),
            ]);

            return redirect()
                ->route('rentals.create', ['film_id' => $film->film_id])
                ->with('ok', 'Renta registrada y pago creado.');
        });
    }


    // Devolución
    public function return(Rental $rental)
    {
        if ($rental->return_date) {
            return back()->withErrors('Esta renta ya fue devuelta.');
        }
        $rental->update(['return_date' => now()]);
        return back()->with('ok', 'Devolución registrada.');
    }
}
