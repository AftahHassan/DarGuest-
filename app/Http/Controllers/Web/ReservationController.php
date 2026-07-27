<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationStatusRequest;
use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function __construct(protected ReservationService $reservations) {}

    public function index(): View
    {
        $user = auth()->user();

        $reservations = $user->isOwner()
            ? Reservation::whereHas('property', fn ($q) => $q->where('owner_id', $user->id))->with('property', 'guest')->latest()->paginate(10)
            : Reservation::where('guest_id', $user->id)->with('property')->latest()->paginate(10);

        return view('reservations.index', compact('reservations'));
    }

    public function store(StoreReservationRequest $request): RedirectResponse
    {
        $reservation = $this->reservations->create($request->user(), $request->validated());

        return redirect()->route('reservations.show', $reservation)
            ->with('status', 'Réservation créée avec succès.');
    }

    public function show(Reservation $reservation): View
    {
        $this->authorize('view', $reservation);

        $reservation->load('property', 'guest', 'conversation.messages.sender');

        return view('reservations.show', compact('reservation'));
    }

    public function updateStatus(UpdateReservationStatusRequest $request, Reservation $reservation): RedirectResponse
    {
        $this->reservations->updateStatus($reservation, $request->validated('status'));

        return back()->with('status', 'Statut mis à jour.');
    }

    public function cancel(Reservation $reservation): RedirectResponse
    {
        $this->authorize('cancel', $reservation);

        $this->reservations->cancel($reservation);

        return back()->with('status', 'Réservation annulée.');
    }
}