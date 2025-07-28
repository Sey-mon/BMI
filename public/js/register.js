document.addEventListener('DOMContentLoaded', function() {
    const steps = Array.from(document.querySelectorAll('.register-step'));
    const progress = document.getElementById('register-progress');
    const nextBtns = document.querySelectorAll('.register-next');
    const prevBtns = document.querySelectorAll('.register-prev');
    let currentStep = 0;

    function showStep(idx) {
        steps.forEach((step, i) => {
            step.style.display = (i === idx) ? 'block' : 'none';
        });
        if (progress) {
            progress.textContent = `Step ${idx + 1} of ${steps.length}`;
        }
    }

    function validateStep(idx) {
        // Remove previous errors
        steps[idx].querySelectorAll('.error-message').forEach(e => e.remove());
        let valid = true;
        // Required fields per step (update as needed to match your backend/database)
        const requiredFields = [
            // Step 0: Account Information
            ['name', 'email', 'password', 'password_confirmation', 'role'],
            // Step 1: Basic Information
            ['municipality', 'barangay', 'age_months', 'sex', 'date_of_admission', 'admission_status'],
            // Step 2: Household Information
            ['total_household_members', 'household_adults', 'household_children'],
            // Step 3: Nutritional Measurements
            ['weight', 'height', 'whz_score'],
            // Step 4: Medical Problems (optional fields, skip validation)
            []
        ];
        requiredFields[idx].forEach(field => {
            const input = steps[idx].querySelector(`[name="${field}"]`);
            if (input && !input.value) {
                valid = false;
                const err = document.createElement('div');
                err.className = 'error-message';
                err.textContent = 'This field is required.';
                input.parentNode.appendChild(err);
            }
        });
        // Password confirmation match
        if (idx === 0) {
            const pw = steps[0].querySelector('[name="password"]');
            const pwc = steps[0].querySelector('[name="password_confirmation"]');
            if (pw && pwc && pw.value !== pwc.value) {
                valid = false;
                const err = document.createElement('div');
                err.className = 'error-message';
                err.textContent = 'Passwords do not match.';
                pwc.parentNode.appendChild(err);
            }
        }
        return valid;
    }

    nextBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (validateStep(currentStep)) {
                if (currentStep < steps.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                }
            }
        });
    });
    prevBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });
    showStep(currentStep);
}); 