$(document).ready(function() {
    SignupForm.init();
});

var SignupForm = (function() {
    'use strict';

    var SignupForm = {};

    // Professions
    SignupForm.PROFESSION_PNEUMOLOGIST      = 'pneumologist';
    SignupForm.PROFESSION_ALLERGIST         = 'allergist';
    SignupForm.PROFESSION_NKO               = 'nko';
    SignupForm.PROFESSION_INTERNIST         = 'internist';
    SignupForm.PROFESSION_DOCTOR            = 'doctor';
    SignupForm.PROFESSION_NURSE             = 'nurse';
    SignupForm.PROFESSION_PHARMACIST        = 'pharmacist';
    SignupForm.PROFESSION_PHYSIOTHERAPIST   = 'physiotherapist';

    // Countries
    SignupForm.COUNTRY_BE = 'BE';
    SignupForm.COUNTRY_LU = 'LU';

    // Hide professions
    SignupForm.hideProfessionsLU = [
        SignupForm.PROFESSION_ALLERGIST,
        SignupForm.PROFESSION_NURSE,
        SignupForm.PROFESSION_INTERNIST,
        SignupForm.PROFESSION_PHYSIOTHERAPIST,
        SignupForm.PROFESSION_PHARMACIST
    ];

    SignupForm.init = function() {
        SignupForm.registerEventHandlers();

        // Trigger a change on the profession dropdown to make sure the correct
        // profession specific fields are shown when the page is loaded
        $('#signupform-profession').trigger('change');
        
        // Trigger a change on the country dropdown to make sure the correct
        // profession are shown when the page is loaded
        $('#signupform-country').trigger('change');
    };

    SignupForm.registerEventHandlers = function() {
        $(document)
            .on('change', '#signupform-profession', SignupForm.toggleProfessionSpecificFields)
            .on('change', '#signupform-country', SignupForm.toggleProfessions)
            .on('keyup', '#signupform-email', SignupForm.copyEmailToUsername);
    };

    /**
     * Toggles the professions
     *
     * @param   Event
     */
    SignupForm.toggleProfessions = function(event) {
   
        if($(this).val() == SignupForm.COUNTRY_LU) {
            $.each(SignupForm.hideProfessionsLU, function(index, value) {
                $('#signupform-profession option[value="'+value+'"]').prop('disabled', true).hide();
            });
        }
        else {
            $('#signupform-profession option').prop('disabled', false).show();
        }
    };

    /**
     * Toggles the specific fields for a profession
     *
     * @param   Event
     */
    SignupForm.toggleProfessionSpecificFields = function(event) {
        var profession = $(this).val(),
            rizivNumberLabelValue = $('.control-label[for="signupform-riziv_number"]').html().replace(' *', '');

        // Update the riziv-number label back to its' original state (without the '*')
        $('.control-label[for="signupform-riziv_number"]').html(rizivNumberLabelValue);
        switch (profession) {
            case '':
                $('.field-signupform-responsible_pneumologist').hide();
                $('.container-workplace-fields').hide();

                $('.field-signupform-riziv_number').hide();
                $('.field-signupform-doctorcode').hide();
                
                $('.field-signupform-apb_number').hide();
                break;

            case SignupForm.PROFESSION_PNEUMOLOGIST:
                $('.field-signupform-responsible_pneumologist').hide();
                $('.container-workplace-fields').show();
                
                if($('#signupform-country').val() == SignupForm.COUNTRY_BE) {
                    $('.field-signupform-riziv_number').show();
                    $('.field-signupform-doctorcode').hide();
                }
                else {
                    $('.field-signupform-riziv_number').hide();
                    $('.field-signupform-doctorcode').show();
                }

                $('.field-signupform-apb_number').hide();

                // Add the '*' to the riziv-number label
                $('.control-label[for="signupform-riziv_number"]').append(' *');
                break;

            case SignupForm.PROFESSION_NURSE:
                $('.field-signupform-responsible_pneumologist').show();
                $('.container-workplace-fields').show();

                if($('#signupform-country').val() == SignupForm.COUNTRY_BE) {
                    $('.field-signupform-riziv_number').show();
                    $('.field-signupform-doctorcode').hide();
                }
                else {
                    $('.field-signupform-riziv_number').hide();
                    $('.field-signupform-doctorcode').show();
                }

                $('.field-signupform-apb_number').hide();
                break;

            case SignupForm.PROFESSION_PHARMACIST:
                $('.field-signupform-responsible_pneumologist').hide();
                $('.container-workplace-fields').hide();

                $('.field-signupform-riziv_number').hide();
                $('.field-signupform-doctorcode').hide();

                $('.field-signupform-apb_number').show();
                break;

            default:
                $('.field-signupform-responsible_pneumologist').hide();
                $('.container-workplace-fields').hide();

                if($('#signupform-country').val() == SignupForm.COUNTRY_BE) {
                    $('.field-signupform-riziv_number').show();
                    $('.field-signupform-doctorcode').hide();
                }
                else {
                    $('.field-signupform-riziv_number').hide();
                    $('.field-signupform-doctorcode').show();
                }

                $('.field-signupform-apb_number').hide();

                // Add the '*' to the riziv-number label
                $('.control-label[for="signupform-riziv_number"]').append(' *');
                break;
        }
    };

    /**
     * Copies the value of the emailaddress to the username field
     *
     * @param   Event
     * @return  void
     */
    SignupForm.copyEmailToUsername = function(event) {
        $('#signupform-username').val($(this).val());
    };

    return SignupForm;
})();