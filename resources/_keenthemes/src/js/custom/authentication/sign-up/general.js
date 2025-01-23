"use strict";

document.addEventListener("DOMContentLoaded", function () {
    const subscriptionType = document.getElementById("subscription_type");
    const enterpriseOptions = document.querySelector(".enterprise-options");
    const inviteCodeInput = document.getElementById("invite_code");
    const newEnterpriseCheckbox = document.getElementById("new_enterprise");

    subscriptionType.addEventListener("change", function () {
        if (this.value === "institution") {
            enterpriseOptions.classList.remove("d-none");
        } else {
            enterpriseOptions.classList.add("d-none");
            inviteCodeInput.value = "";
            newEnterpriseCheckbox.checked = false;
            inviteCodeInput.disabled = false;
            newEnterpriseCheckbox.disabled = false;
        }
    });

    inviteCodeInput.addEventListener("input", function () {
        newEnterpriseCheckbox.disabled = this.value.trim() !== "";
    });

    newEnterpriseCheckbox.addEventListener("change", function () {
        inviteCodeInput.disabled = this.checked;
    });
});

// Class definition
var KTRegisterGeneral = (function () {
    // Elements
    var form;
    var submitButton;
    var validator;

    // Handle form
    var handleValidation = function () {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(form, {
            locale: window.chosenLocale,
            localization: window.chosenLocale,
            fields: {
                first_name: {
                    validators: {
                        notEmpty: {
                            message: {
                                en_US: "First name is required",
                                fr_FR: "Le prénom est requis",
                                ar_SA: "الاسم الأول مطلوب",
                            },
                        },
                    },
                },
                last_name: {
                    validators: {
                        notEmpty: {
                            message: {
                                en_US: "Last name is required",
                                fr_FR: "Le nom est requis",
                                ar_SA: "اسم العائلة مطلوب",
                            },
                        },
                    },
                },
                email: {
                    validators: {
                        regexp: {
                            regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                            message: {
                                en_US: "The email address is not valid",
                                fr_FR: "L'adresse e-mail n'est pas valide",
                                ar_SA: "عنوان البريد الإلكتروني غير صالح",
                            },
                        },
                        notEmpty: {
                            message: {
                                en_US: "The email address is required",
                                fr_FR: "L'adresse e-mail est requise",
                                ar_SA: "عنوان البريد الإلكتروني مطلوب",
                            },
                        },
                    },
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: {
                                en_US: "The password is required",
                                fr_FR: "Le mot de passe est requis",
                                ar_SA: "كلمة المرور مطلوبة",
                            },
                        },
                    },
                },
                password_confirmation: {
                    validators: {
                        notEmpty: {
                            message: {
                                en_US: "The password confirmation is required",
                                fr_FR: "La confirmation du mot de passe est requise",
                                ar_SA: "تأكيد كلمة المرور مطلوب",
                            },
                        },
                        identical: {
                            compare: function () {
                                return form.querySelector('[name="password"]')
                                    .value;
                            },
                            message: {
                                en_US: "The password and its confirm are not the same",
                                fr_FR: "Le mot de passe et sa confirmation ne sont pas identiques",
                                ar_SA: "كلمة المرور وتأكيدها غير متطابقين",
                            },
                        },
                    },
                },
                subscription_type: {
                    validators: {
                        notEmpty: {
                            message: {
                                en_US: "The subscription type is required",
                                fr_FR: "Le type d'abonnement est requis",
                                ar_SA: "نوع الاشتراك مطلوب",
                            },
                        },
                    },
                },
                invite_code: {
                    validators: {
                        callback: {
                            message: {
                                en_US: "Either invite code or new institution must be provided",
                                fr_FR: "Le code d'invitation ou la nouvelle entreprise doit être fourni",
                                ar_SA: "يجب تقديم رمز الدعوة أو المؤسسة الجديدة",
                            },
                            callback: function (input) {
                                const subscriptionType = form.querySelector('[name="subscription_type"]').value;
                                const inviteCode = form.querySelector('[name="invite_code"]').value.trim();
                                const newEnterprise = form.querySelector('[name="new_enterprise"]').checked;

                                if (subscriptionType === "institution") {
                                    return inviteCode !== "" || newEnterprise;
                                }
                                return true;
                            }
                        },
                        regexp: {
                            regexp: /^[A-Za-z0-9]+$/,
                            message: {
                                en_US: "The invite code is not valid",
                                fr_FR: "Le code d'invitation n'est pas valide",
                                ar_SA: "رمز الدعوة غير صالح",
                            }
                        }
                    }
                },
                new_enterprise: {
                    validators: {
                        callback: {
                            message: {
                                en_US: "Either invite code or new institution must be provided",
                                fr_FR: "Le code d'invitation ou la nouvelle entreprise doit être fourni",
                                ar_SA: "يجب تقديم رمز الدعوة أو المؤسسة الجديدة",
                            },
                            callback: function (input) {
                                const subscriptionType = form.querySelector('[name="subscription_type"]').value;
                                const inviteCode = form.querySelector('[name="invite_code"]').value.trim();
                                const newEnterprise = form.querySelector('[name="new_enterprise"]').checked;

                                if (subscriptionType === "institution") {
                                    return inviteCode !== "" || newEnterprise;
                                }
                                return true;
                            }
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger({
                    event: {
                        first_name: false,
                        last_name: false,
                        email: false,
                        password: false,
                        password_confirmation: false,
                        subscription_type: false,
                        invite_code: false,
                        new_enterprise: false,
                    },
                }),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: ".fv-row",
                    eleInvalidClass: "", // comment to enable invalid state icons
                    eleValidClass: "", // comment to enable valid state icons
                }),
            },
        });

        validator.setLocale(window.chosenLocale);
    };

    var handleSubmit = function (e) {
        // Handle form submit
        submitButton.addEventListener("click", function (e) {
            // Prevent button default action
            e.preventDefault();

            // Trigger validation manually
            validator.validate().then(function (status) {
                if (status == "Valid") {
                    // Show loading indication
                    submitButton.setAttribute("data-kt-indicator", "on");

                    // Disable button to avoid multiple click
                    submitButton.disabled = true;

                    // Check axios library docs: https://axios-http.com/docs/intro
                    axios
                        .post(
                            submitButton.closest("form").getAttribute("action"),
                            new FormData(form)
                        )
                        .then(function (response) {
                            if (response) {
                                form.reset();

                                // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                                Swal.fire({
                                    text: "You have successfully registered!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                    },
                                });

                                const redirectUrl = form.getAttribute(
                                    "data-kt-redirect-url"
                                );

                                if (redirectUrl) {
                                    location.href = redirectUrl;
                                }
                            } else {
                                // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                                Swal.fire({
                                    text: "Sorry, there was an error with your registration, please try again.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                    },
                                });
                            }
                        })
                        .catch(function (error) {
                            Swal.fire({
                                text: "Sorry, looks like there are some errors detected, please try again.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                },
                            });
                        })
                        .then(() => {
                            // Hide loading indication
                            submitButton.removeAttribute("data-kt-indicator");

                            // Enable button
                            submitButton.disabled = false;
                        });
                } else {
                    // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                    Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                    });
                }
            });
        });
    };

    // Public functions
    return {
        // Initialization
        init: function () {
            form = document.querySelector("#kt_sign_up_form");
            submitButton = document.querySelector("#kt_sign_up_submit");

            handleValidation();
            handleSubmit();
        },
    };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTRegisterGeneral.init();
});
