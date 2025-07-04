<?php

namespace App\Http\Controllers;

use App\Models\NutritionAssessment;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NutritionistController extends AdminController
{
    /**
     * Show the nutritionist dashboard.
     */
    public function dashboard()
    {
        // Get total patients count
        $totalPatients = Patient::count();
        
        // Get total assessments count
        $totalAssessments = NutritionAssessment::count();
        
        // Get patients with critical nutrition status
        $criticalCases = NutritionAssessment::where('nutrition_status', 'severe_malnutrition')
            ->orderBy('assessment_date', 'desc')
            ->with('patient')
            ->take(5)
            ->get();
        
        // Get nutrition status distribution
        $nutritionStats = [
            'normal' => NutritionAssessment::where('nutrition_status', 'normal')->count(),
            'mild_malnutrition' => NutritionAssessment::where('nutrition_status', 'mild_malnutrition')->count(),
            'moderate_malnutrition' => NutritionAssessment::where('nutrition_status', 'moderate_malnutrition')->count(),
            'severe_malnutrition' => NutritionAssessment::where('nutrition_status', 'severe_malnutrition')->count(),
        ];
        
        // Get assessments needing follow-up
        $followupNeeded = NutritionAssessment::whereDate('next_assessment_date', '<=', now()->addDays(7))
            ->with('patient')
            ->take(5)
            ->get();
            
        return view('nutritionist.dashboard', [
            'totalPatients' => $totalPatients,
            'totalAssessments' => $totalAssessments,
            'criticalCases' => $criticalCases,
            'nutritionStats' => $nutritionStats,
            'followupNeeded' => $followupNeeded,
        ]);
    }
    
    /**
     * Show all patients (specific to nutritionist permissions)
     */
    public function patients()
    {
        $patients = Patient::with('latestAssessment')->get();
        
        return view('nutritionist.patients', [
            'patients' => $patients
        ]);
    }
    
    /**
     * Show nutrition assessments view
     */
    public function nutrition()
    {
        $assessments = NutritionAssessment::with('patient')->get();
        $patients = Patient::all();
        
        return view('nutritionist.nutrition', [
            'assessments' => $assessments,
            'patients' => $patients
        ]);
    }
    
    /**
     * Store a new nutrition assessment
     */
    public function storeNutrition(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'assessment_date' => 'required|date',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
            'muac' => 'nullable|numeric',
            'nutrition_status' => 'required|in:normal,mild_malnutrition,moderate_malnutrition,severe_malnutrition',
            'clinical_signs' => 'nullable|string',
            'next_assessment_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);
        
        // Calculate BMI
        $weight = $validated['weight'];
        $height = $validated['height'] / 100; // Convert cm to m
        $bmi = $weight / ($height * $height);
        $validated['bmi'] = round($bmi, 2);
        
        // Create assessment
        NutritionAssessment::create($validated);
        
        return redirect()->route('nutritionist.nutrition')->with('success', 'Nutrition assessment added successfully');
    }
    
    /**
     * Show a specific assessment
     */
    public function showNutrition(NutritionAssessment $nutrition)
    {
        return view('nutritionist.nutrition-details', [
            'assessment' => $nutrition->load('patient')
        ]);
    }
    
    /**
     * Show reports view
     */
    public function reports()
    {
        // Get critical cases
        $criticalCases = NutritionAssessment::where('nutrition_status', 'severe_malnutrition')
            ->with('patient')
            ->take(10)
            ->get();
            
        // Get nutrition status distribution
        $nutritionStats = [
            'normal' => NutritionAssessment::where('nutrition_status', 'normal')->count(),
            'mild_malnutrition' => NutritionAssessment::where('nutrition_status', 'mild_malnutrition')->count(),
            'moderate_malnutrition' => NutritionAssessment::where('nutrition_status', 'moderate_malnutrition')->count(),
            'severe_malnutrition' => NutritionAssessment::where('nutrition_status', 'severe_malnutrition')->count(),
        ];
        
        $totalAssessments = NutritionAssessment::count();
        
        return view('nutritionist.reports', [
            'criticalCases' => $criticalCases,
            'nutritionStats' => $nutritionStats,
            'totalAssessments' => $totalAssessments,
        ]);
    }
    
    /**
     * Show a specific patient record
     */
    public function showPatient(Patient $patient)
    {
        $assessments = $patient->nutritionAssessments()->orderBy('assessment_date', 'desc')->get();
        
        return view('nutritionist.patient-details', [
            'patient' => $patient,
            'assessments' => $assessments
        ]);
    }
    
    /**
     * Store a new patient
     */
    public function storePatient(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_contact' => 'nullable|string|max:255',
            'medical_history' => 'nullable|string'
        ]);
        
        // Create patient
        Patient::create($validated);
        
        return redirect()->route('nutritionist.patients')->with('success', 'Patient added successfully');
    }
}
