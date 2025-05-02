<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function save(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|regex:/^[a-zA-Z\s]+$/|max:255',
            'timing' => 'required|string|max:255',
            'doctor_name' => 'required|string|max:255',
        ]);

        $appointment = new Appointment([
            'email' => $request->get('email'),
            'name' => $request->get('name'),
            'timing' => $request->get('timing'),
            'doctor_name' => $request->get('doctor_name'),
        ]);

        if ($appointment->save()) {
            return redirect()->back()->with('success', 'Appointment saved successfully');
        } else {
            return redirect()->back()->withErrors(['error' => 'Failed to save appointment. Please try again.']);
        }
    }
}
