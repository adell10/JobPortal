<?php

namespace App\Http\Controllers;

use App\Exports\ApplicationsExport;
use App\Jobs\SendApplicationMailJob;
use App\Mail\ApplicationStatusMail;
use App\Mail\JobAppliedMail;
use App\Models\Application;
use App\Models\User;
use App\Notifications\NewApplicationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;


class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $applications = Application::with('user', 'job')->get();
        return view('applications.index', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $jobId)
    {
        $request->validate([
            'cv' => 'required|mimes:pdf|max:2048',
        ]);

        $cvPath = $request->file('cv')->store('cvs', 'public');

        $application = Application::create([
            'user_id' => Auth::id(),
            'job_id' => $jobId,
            'cv' => $cvPath,
        ]);

        $application->load('job', 'user');

        // Mail::to($application->user->email)
        // ->send(new JobAppliedMail($application->job, $application->user));

        //baru dikomen
        // SendApplicationMailJob::dispatch($application);

        SendApplicationMailJob::dispatch($application->id)
        ->delay(now()->addSeconds(5));
        
        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            $admin->notify(new NewApplicationNotification($application));
        } else {
            Log::warning('Admin tidak ditemukan!');
        }

        return back()->with('success', 'Lamaran berhasil dikirim!');
    }


   


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $application = Application::findOrFail($id);

        $application->update([
            'status' => $request->status
        ]);

        Mail::to($application->user->email)
        ->send(new ApplicationStatusMail($application));

        return back()->with('success', 'Status pelamar berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function export(Request $request)
    {
        $jobId = $request->job_id; 

        return Excel::download(new ApplicationsExport($jobId), 'applications.xlsx');
    }

}
