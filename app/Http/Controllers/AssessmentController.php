<?php

namespace App\Http\Controllers;

use App\Services\MalnutritionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AssessmentController extends Controller
{
    protected $malnutritionService;

    public function __construct(MalnutritionService $malnutritionService)
    {
        $this->malnutritionService = $malnutritionService;
    }

    /**
     * Assess a patient
     */
    public function assess(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'age_months' => 'required|numeric|min:0|max:60',
            'weight' => 'required|numeric|min:0.1|max:50',
            'height' => 'required|numeric|min:30|max:150',
            'sex' => 'required|in:Male,Female',
            'municipality' => 'nullable|string|max:255',
            'patient_id' => 'nullable|string|max:50',
            'total_household' => 'nullable|integer|min:1|max:20',
            'adults' => 'nullable|integer|min:1|max:10',
            'children' => 'nullable|integer|min:0|max:15',
            'is_twin' => 'nullable|boolean',
            'fourps_beneficiary' => 'nullable|in:Yes,No',
            'breastfeeding' => 'nullable|in:Yes,No',
            'tuberculosis' => 'nullable|in:Yes,No',
            'malaria' => 'nullable|in:Yes,No',
            'congenital_anomalies' => 'nullable|in:Yes,No',
            'other_medical_problems' => 'nullable|in:Yes,No',
            'edema' => 'nullable|boolean',
        ]);

        $result = $this->malnutritionService->assessPatient($validatedData);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Assessment completed successfully',
                'data' => $result['data']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Assessment failed',
            'error' => $result['error']
        ], 422);
    }

    /**
     * Check API health
     */
    public function healthCheck(): JsonResponse
    {
        $health = $this->malnutritionService->healthCheck();

        if ($health) {
            return response()->json([
                'success' => true,
                'message' => 'API is healthy',
                'data' => $health
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'API is not available'
        ], 503);
    }

    /**
     * Get treatment protocols
     */
    public function getProtocols(): JsonResponse
    {
        $result = $this->malnutritionService->getTreatmentProtocols();

        return response()->json($result);
    }
}