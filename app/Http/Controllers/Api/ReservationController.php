<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationStatusRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Services\ReservationService;

class ReservationController extends Controller
{
    public function __construct(protected ReservationService $reservations) {}

    public function index()
    {
        $user = auth()->user();

        $query = $user->isOwner()
            ? Reservation::whereHas('property', fn ($q) => $q->where('owner_id', $user->id))
            : Reservation::where('guest_id', $user->id);

        return ReservationResource::collection(
            $query->with('property', 'guest')->latest()->paginate(15)
        );
    }

    public function store(StoreReservationRequest $request)
    {
        $reservation = $this->reservations->create($request->user(), $request->validated());

        return new ReservationResource($reservation);
    }

    public function show(Reservation $reservation)
    {
        $this->authorize('view', $reservation);

        return new ReservationResource($reservation->load('property', 'guest', 'conversation'));
    }

    public function update(UpdateReservationStatusRequest $request, Reservation $reservation)
    {
        $reservation = $this->reservations->updateStatus($reservation, $request->validated('status'));

        return new ReservationResource($reservation);
    }

    public function cancel(Reservation $reservation)
{
    $this->authorize('cancel', $reservation);

    $reservation = $this->reservations->cancel($reservation, auth()->user());

    return new ReservationResource($reservation);
}
}