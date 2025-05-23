// Stepper lement
var element = document.querySelector("#kt_stepper_example_basic");

// Initialize Stepper
var stepper = new KTStepper(element);


const translations = {
    en_US: {
        firstNameRequired: 'First Name is required',
        lastNameRequired: 'Last Name is required.',
        dobRequired: 'Date of Birth is required.',
        cobRequired: 'Country of Birth is required.',
        officeEmailRequired: 'A valid Office Email is required.',
        officeEmailInvalid: 'Please enter a valid email address.',
        addressLine1Required: 'Address Line 1 is required.',
        townRequired: 'Town is required.',
        stateRequired: 'State/Province is required.',
        postcodeRequired: 'Postcode is required.',
        languageRequired: 'Language selection is required.',
        spokenLevelRequired: 'Spoken Level is required.',
        writtenLevelRequired: 'Written Level is required.',
        validEmail: 'Please enter a valid email address.',
        validDate: 'Please enter a valid date.',
        validNumber: 'Please enter a valid number.',
        employerNameRequired: 'Employer Name is required.',
        countryRequired: 'Country is required.',
        startYearRequired: 'Start Year is required.',
        endYearRequired: 'End Year is required.'
    },
    fr_FR: {
        firstNameRequired: 'Le prénom est requis.',
        lastNameRequired: 'Le nom de famille est requis.',
        dobRequired: 'La date de naissance est requise.',
        cobRequired: 'Le pays de naissance est requis.',
        officeEmailRequired: 'Un e-mail de bureau valide est requis.',
        officeEmailInvalid: 'Veuillez entrer une adresse e-mail valide.',
        addressLine1Required: 'L\'adresse 1 est requise.',
        townRequired: 'La ville est requise.',
        stateRequired: 'L\'État/Province est requis.',
        postcodeRequired: 'Le code postal est requis.',
        languageRequired: 'La sélection de la langue est requise.',
        spokenLevelRequired: 'Le niveau parlé est requis.',
        validEmail: 'Veuillez entrer une adresse e-mail valide.',
        writtenLevelRequired: 'Le niveau écrit est requis.',
        validDate: 'Veuillez entrer une date valide.',
        validNumber: 'Veuillez entrer un nombre valide.',
        employerNameRequired: 'Le nom de l\'employeur est requis.',
        countryRequired: 'Le pays est requis.',
        startYearRequired: 'L\'année de début est requise.',
        endYearRequired: 'L\'année de fin est requise.'
    },
    ar_SA: {
        firstNameRequired: 'الاسم الأول مطلوب',
        lastNameRequired: 'اسم العائلة مطلوب',
        dobRequired: 'تاريخ الميلاد مطلوب.',
        cobRequired: 'بلد الميلاد مطلوب.',
        officeEmailRequired: 'البريد الإلكتروني الرسمي صالح مطلوب.',
        officeEmailInvalid: 'يرجى إدخال عنوان بريد إلكتروني صالح.',
        addressLine1Required: 'السطر الأول للعناوين مطلوب',
        townRequired: 'المدينة مطلوبة ويجب أن تكون أقل من 255 حرفًا.',
        stateRequired: 'الولاية/المقاطعة مطلوبة ويجب أن تكون أقل من 255 حرفًا.',
        postcodeRequired: 'الرمز البريدي مطلوب ويجب أن يكون أقل من 20 حرفًا.',
        languageRequired: 'اختيار اللغة مطلوب.',
        spokenLevelRequired: 'مستوى اللغة المحكية مطلوب.',
        writtenLevelRequired: 'مستوى اللغة المكتوبة مطلوب.',
        validDate: 'يرجى إدخال تاريخ صالح.',
        validEmail: 'يرجى إدخال عنوان بريد إلكتروني صالح.',
        validNumber: 'يرجى إدخال رقم صالح.',
        employerNameRequired: 'اسم صاحب العمل مطلوب.',
        countryRequired: 'البلد مطلوب.',
        startYearRequired: 'سنة البدء مطلوبة.',
        endYearRequired: 'سنة الانتهاء مطلوبة.'
    }
};

// Update validation rules with localized messages
const validationRules = {
    1: {
        first_name: {
            required: true,
            type: 'string',
            maxLength: 255,
            message: translations[locale].firstNameRequired
        },
        last_name: {
            required: true,
            type: 'string',
            maxLength: 255,
            message: translations[locale].lastNameRequired
        },
        birth_date: {
            required: true,
            type: 'date',
            message: translations[locale].dobRequired
        },
        country_id: {
            required: true,
            type: 'integer',
            message: translations[locale].cobRequired
        },
    },
    2: {
        country_of_residence: {
            required: true,
            type: 'integer',
            message: translations[locale].cobRequired
        },
        address_line_1: {
            required: true,
            type: 'string',
            maxLength: 255,
            message: translations[locale].addressLine1Required
        },
        city: {
            required: true,
            type: 'string',
            maxLength: 255,
            message: translations[locale].townRequired
        },
        state: {
            required: true,
            type: 'string',
            maxLength: 255,
            message: translations[locale].stateRequired
        },
        postcode: {
            required: true,
            type: 'string',
            maxLength: 20,
            message: translations[locale].postcodeRequired
        }
    },
    3: {
        // Assuming dynamic language fields
        // No static fields, handled separately
    },
    4: {
        employer_name: {
            required: true,
            type: 'string',
            maxLength: 255,
            message: translations[locale].employerNameRequired
        },
        country_id: {
            required: true,
            type: 'integer',
            message: translations[locale].countryRequired
        },
        start_year: {
            required: true,
            type: 'integer',
            message: translations[locale].startYearRequired
        },
        end_year: {
            required: true,
            type: 'integer',
            message: translations[locale].endYearRequired
        }
    }
    // Add more steps and their rules as needed
};

// Function to validate a single field
function validateField(field, rules) {
    let value = field.value.trim();
    let isValid = true;
    let errorMessage = '';

    // Check if the field is end_year and if the corresponding is_current checkbox is checked
    if (field.name.includes('end_year')) {
        const isCurrentCheckbox = field.closest('[data-repeater-item]').querySelector('input[name*="is_current"]');
        if (isCurrentCheckbox && isCurrentCheckbox.checked) {
            rules.required = false; // Make end_year not required if is current is checked
        } else {
            rules.required = true; // Make end_year required if is current is not checked
        }
    }

    if (rules.required && !value) {
        isValid = false;
        errorMessage = rules.message;
    }

    if (isValid && rules.type === 'email') {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            isValid = false;
            errorMessage = translations[locale].validEmail;
        }
    }

    if (isValid && rules.type === 'string' && rules.maxLength) {
        if (value.length > rules.maxLength) {
            isValid = false;
            errorMessage = rules.message;
        }
    }

    if (isValid && rules.type === 'date') {
        const date = new Date(value);
        if (isNaN(date.getTime())) {
            isValid = false;
            errorMessage = translations[locale].validDate;
        }
    }

    if (isValid && rules.type === 'integer') {
        if (!Number.isInteger(Number(value))) {
            isValid = false;
            errorMessage = translations[locale].validNumber;
        }
    }

    if (!isValid) {
        showError(field, errorMessage);
    } else {
        clearError(field);
    }

    return isValid;
}

// Function to validate all fields in the current step
function validateStep(step) {
    let isStepValid = true;
    const rules = validationRules[step];

    // Iterate over each rule in the current step
    for (let fieldName in rules) {
        const fields = document.querySelectorAll(`[name*="${fieldName}"]`);
        fields.forEach(field => {
            if (field) {
                const fieldIsValid = validateField(field, rules[fieldName]);
                if (!fieldIsValid) {
                    isStepValid = false;
                }
            }
        });
    }
    return isStepValid;
}

// Function to show error message
function showError(field, message) {
    clearError(field);
    const errorSpan = document.createElement('span');
    errorSpan.classList.add('text-danger', 'd-block', 'mt-2');
    errorSpan.textContent = message;
    field.parentElement.appendChild(errorSpan);
}

// Function to clear error message
function clearError(field) {
    const errorSpan = field.parentElement.querySelector('.text-danger');
    if (errorSpan) {
        errorSpan.remove();
    }
}

// Handle next step
stepper.on("kt.stepper.next", function (stepperObj) {
    const currentStep = stepperObj.currentStepIndex;
    const isValid = validateStep(currentStep);
    if (isValid) {
        stepperObj.goNext(); // Proceed to next step
    } else {
        // Stay on current step
    }
});

// Handle previous step
stepper.on("kt.stepper.previous", function (stepper) {
    stepper.goPrevious(); // go previous step
});

// Handle form submission with Axios
document.getElementById('kt_stepper_example_basic_form').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    
    axios.post('/professors/complete-registration', formData)
        .then(function(response) {
            // Handle success
            console.log(response);
            // Redirect to dashboard
            window.location.href = '/dashboard';
        })
        .catch(function(error) {
            // Handle error
            console.error(error);
            // Possibly show error message
        });
});

// Function to handle form submission
stepper.on("kt.stepper.submit", function (stepper) {
    const form = document.getElementById('kt_stepper_example_basic_form');
    form.submit(); // Submit the form via Livewire
});


$("#date_of_birth").daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1901,
    drops: "up",
    maxYear: parseInt(moment().format("YYYY"),12)
});

$('#languages_repeater').repeater({
    initEmpty: false,

    defaultValues: {
        'language': 1,
        'written': 0,
        'spoken_level': 0,
    },

    show: function () {
        $(this).slideDown();
    },

    hide: function (deleteElement) {
        $(this).slideUp(deleteElement);
    }
});

$('#employments_repeater').repeater({
    initEmpty: false,

    defaultValues: {
        'employer_name': '',
        'country_id': '',
        'is_current': 0,
        'is_full_time': 0,
    },

    show: function () {
        $(this).slideDown();
        // Add validation logic for new repeater item
        const fields = $(this).find('input, select');
        fields.each(function() {
            var fieldName = $(this).attr('name');
            const matches = fieldName.match(/\[.*?\]\[(.*?)\]/);
            fieldName = matches ? matches[1] : fieldName;
            if (validationRules[4][fieldName]) {
                $(this).on('input change', function() {
                    validateField(this, validationRules[4][fieldName]);
                });
            }
        });

        // Add change event listener to is_current checkbox to re-validate end_year
        const isCurrentCheckbox = $(this).find('input[name*="is_current"]');
        isCurrentCheckbox.on('change', function() {
            const endYearField = $(this).closest('[data-repeater-item]').find('input[name*="end_year"]');
            validateField(endYearField[0], validationRules[4]['end_year']);
        });
    },

    hide: function (deleteElement) {
        $(this).slideUp(deleteElement);
    }
});

$('#educations_repeater').repeater({
    initEmpty: false,

    show: function () {
        $(this).slideDown();
    },

    hide: function (deleteElement) {
        $(this).slideUp(deleteElement);
    }
});

$('#teaching_interests_repeater').repeater({
    initEmpty: false,

    show: function () {
        $(this).slideDown();
    },

    hide: function (deleteElement) {
        $(this).slideUp(deleteElement);
    }
});

$('#expertise_areas_repeater').repeater({
    initEmpty: false,

    show: function () {
        $(this).slideDown();
    },

    hide: function (deleteElement) {
        $(this).slideUp(deleteElement);
    }
});