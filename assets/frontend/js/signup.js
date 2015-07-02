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

    SignupForm.init = function() {
        SignupForm.registerEventHandlers();
        
        // Trigger a change on the profession dropdown to make sure the correct
        // profession specific fields are shown when the page is loaded
        $('#signupform-profession').trigger('change');    
    };
    
    SignupForm.registerEventHandlers = function() {
        $(document)
            .on('change', '#signupform-profession', SignupForm.toggleProfessionSpecificFields)
            .on('keyup', '#signupform-email', SignupForm.copyEmailToUsername);    
    };
    
    /**
     * Toggles the specific fields for a profession
     * 
     * @param   Event 
     */
    SignupForm.toggleProfessionSpecificFields = function(event) {
        var profession = $(this).val();
        
        switch (profession) {
            case '':
                $('.field-signupform-responsible_pneumologist').hide();
                $('.container-workplace-fields').hide();
                $('.field-signupform-riziv_number').hide();
                $('.field-signupform-apb_number').hide();
                break;
            
            case SignupForm.PROFESSION_PNEUMOLOGIST:
                $('.field-signupform-responsible_pneumologist').hide();
                $('.container-workplace-fields').show();
                $('.field-signupform-riziv_number').show();
                $('.field-signupform-apb_number').hide();    
                break;
                
            case SignupForm.PROFESSION_NURSE:
                $('.field-signupform-responsible_pneumologist').show();
                $('.container-workplace-fields').show();
                $('.field-signupform-riziv_number').show();
                $('.field-signupform-apb_number').hide();
                break;
                
            case SignupForm.PROFESSION_PHARMACIST:
                $('.field-signupform-responsible_pneumologist').hide();
                $('.container-workplace-fields').hide();
                $('.field-signupform-riziv_number').hide();
                $('.field-signupform-apb_number').show();
                break;
                
            default:
                $('.field-signupform-responsible_pneumologist').hide();
                $('.container-workplace-fields').hide();
                $('.field-signupform-riziv_number').show();
                $('.field-signupform-apb_number').hide();
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