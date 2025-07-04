<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nutritionist Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- Total Patients -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                    <h3 class="font-semibold text-lg mb-2 text-green-600">Total Patients</h3>
                    <p class="text-3xl font-bold">{{ $totalPatients }}</p>
                </div>
                
                <!-- Total Assessments -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                    <h3 class="font-semibold text-lg mb-2 text-green-600">Total Assessments</h3>
                    <p class="text-3xl font-bold">{{ $totalAssessments }}</p>
                </div>
                
                <!-- Nutrition Status -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                    <h3 class="font-semibold text-lg mb-2 text-green-600">Critical Cases</h3>
                    <p class="text-3xl font-bold text-red-500">{{ $nutritionStats['severe_malnutrition'] ?? 0 }}</p>
                </div>
                
                <!-- Follow-ups Needed -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                    <h3 class="font-semibold text-lg mb-2 text-green-600">Upcoming Follow-ups</h3>
                    <p class="text-3xl font-bold">{{ $followupNeeded->count() }}</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Critical Cases -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="font-semibold text-lg mb-4 text-green-600">Critical Cases</h3>
                        @if($criticalCases->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Patient</th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($criticalCases as $case)
                                            <tr>
                                                <td class="py-2 px-4 border-b border-gray-200">{{ $case->patient->name ?? 'Unknown Patient' }}</td>
                                                <td class="py-2 px-4 border-b border-gray-200">{{ $case->assessment_date ? date('M d, Y', strtotime($case->assessment_date)) : 'Not set' }}</td>
                                                <td class="py-2 px-4 border-b border-gray-200">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Severe Malnutrition
                                                    </span>
                                                </td>
                                                <td class="py-2 px-4 border-b border-gray-200">
                                                    @if($case->patient)
                                                        <a href="{{ route('nutritionist.patients.show', $case->patient->id) }}" class="text-green-600 hover:text-green-800">View</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-600">No critical cases found.</p>
                        @endif
                    </div>
                </div>
                
                <!-- Follow-ups Needed -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="font-semibold text-lg mb-4 text-green-600">Upcoming Follow-ups</h3>
                        @if($followupNeeded->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Patient</th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Follow-up Date</th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($followupNeeded as $assessment)
                                            <tr>
                                                <td class="py-2 px-4 border-b border-gray-200">{{ $assessment->patient->name ?? 'Unknown Patient' }}</td>
                                                <td class="py-2 px-4 border-b border-gray-200">{{ $assessment->next_assessment_date ? date('M d, Y', strtotime($assessment->next_assessment_date)) : 'Not set' }}</td>
                                                <td class="py-2 px-4 border-b border-gray-200">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        @if($assessment->nutrition_status == 'severe_malnutrition') bg-red-100 text-red-800
                                                        @elseif($assessment->nutrition_status == 'moderate_malnutrition') bg-orange-100 text-orange-800
                                                        @elseif($assessment->nutrition_status == 'mild_malnutrition') bg-yellow-100 text-yellow-800
                                                        @else bg-green-100 text-green-800 @endif">
                                                        {{ ucwords(str_replace('_', ' ', $assessment->nutrition_status)) }}
                                                    </span>
                                                </td>
                                                <td class="py-2 px-4 border-b border-gray-200">
                                                    @if($assessment->patient)
                                                        <a href="{{ route('nutritionist.patients.show', $assessment->patient->id) }}" class="text-green-600 hover:text-green-800">View</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-600">No upcoming follow-ups.</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg mb-4 text-green-600">Nutrition Status Distribution</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="p-4 border rounded-md bg-green-100">
                            <h4 class="font-semibold">Normal</h4>
                            <p class="text-2xl font-bold">{{ $nutritionStats['normal'] ?? 0 }}</p>
                        </div>
                        <div class="p-4 border rounded-md bg-yellow-100">
                            <h4 class="font-semibold">Mild Malnutrition</h4>
                            <p class="text-2xl font-bold">{{ $nutritionStats['mild_malnutrition'] ?? 0 }}</p>
                        </div>
                        <div class="p-4 border rounded-md bg-orange-100">
                            <h4 class="font-semibold">Moderate Malnutrition</h4>
                            <p class="text-2xl font-bold">{{ $nutritionStats['moderate_malnutrition'] ?? 0 }}</p>
                        </div>
                        <div class="p-4 border rounded-md bg-red-100">
                            <h4 class="font-semibold">Severe Malnutrition</h4>
                            <p class="text-2xl font-bold">{{ $nutritionStats['severe_malnutrition'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
