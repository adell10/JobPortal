<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobApiController extends Controller
{

    public function publicIndex(Request $req)
    {
        $q = JobVacancy::query();

        if ($req->filled('keyword')) {
            $kw = $req->keyword;
            $q->where(function ($s) use ($kw) {
                $s->where('title', 'like', "%$kw%")
                  ->orWhere('company', 'like', "%$kw%")
                  ->orWhere('location', 'like', "%$kw%");
            });
        }

        if ($req->filled('company')) {
            $q->where('company', 'like', '%' . $req->company . '%');
        }

        if ($req->filled('location')) {
            $q->where('location', 'like', '%' . $req->location . '%');
        }

        $jobs = $q->orderBy('created_at', 'desc')
                 ->paginate($req->get('per_page', 10));

        return response()->json($jobs);
    }

    /**
     * @OA\Get(
     *     path="/api/jobs",
     *     tags={"Jobs"},
     *     summary="List all jobs",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="keyword",
     *         in="query",
     *         required=false,
     *         description="Keyword search (title, company, location)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         description="Items per page",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     )
     * )
     */

    public function index(Request $req)
    {
        $q = JobVacancy::query();

        if ($req->filled('keyword')) {
            $kw = $req->keyword;

            $q->where(function ($s) use ($kw) {
                $s->where('title', 'like', "%$kw%")
                  ->orWhere('company', 'like', "%$kw%")
                  ->orWhere('location', 'like', "%$kw%");
            });
        }

        if ($req->filled('company')) {
            $company = $req->company;
            $q->where('company', 'like', "%{$company}%");
        }

        if ($req->filled('location')) {
            $location = $req->location;
            $q->where('location', 'like', "%{$location}%");
        }

        $perPage = (int) $req->get('per_page', 5);
        $jobs = $q->paginate($perPage);
        $jobs = $q->orderBy('created_at', 'desc')
                    ->paginate($req->get('per_page', 10));

        return response()->json($jobs);
    }

    public function show(JobVacancy $job)
    {
        return response()->json($job);
    }


    public function store(Request $req)
    {
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $req->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'company' => 'required',
            'salary' => 'nullable|integer',
        ]);

        $job = JobVacancy::create($data);

        return response()->json([
            'message' => 'Created',
            'job' => $job
        ], 201);
    }

    public function update(Request $req, JobVacancy $job)
    {
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $req->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'location' => 'sometimes|required',
            'company' => 'sometimes|required',
            'salary' => 'nullable|integer',
        ]);

        $job->update($data);

        return response()->json([
            'message' => 'Updated',
            'job' => $job
        ]);
    }

    public function destroy(Request $req, JobVacancy $job)
    {
        if ($req->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $job->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
