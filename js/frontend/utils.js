$ = jQuery;
var validator;

$(document).ready(function () {
    validator = $("form").kendoValidator({
        rules: {
            radio: function (input) {
                if (input.is(':radio')) {
                    if (input.filter("[type=radio]") && input.attr("required")) {
                        return $("form").find("[type=radio][name=" + input.attr("name") + "]").is(":checked");
                    }
                    return true;
                }
                return true;
            },
            verifyPasswords: function (input) {
                var ret = true;
                if (input.is("[name=RetypePassword]")) {
                    ret = input.val() === $("#Password").val();
                }
                return ret;
            },
            passwordComplexity: function (input) {
                var pass = true;
                if (input.is("[name=Password]")) {
                    pass = input.val().match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$/);
                }
                return pass;
            },
            maxInputLength: function (input) {
                if (input.val() != "") {
                    var maxlength = input.attr("maxlength");
                    var value = input.value();
                    return value.replace(/<[^>]+>/g, "").length <= maxlength;
                }
                return true;
            }
        },
        messages: {
            radio: "This is a required field",
            verifyPasswords: "Passwords do not match!",
            passwordComplexity: "Please enter a password which is at least 8 characters long and contains a lowercase character, an uppercase character and a number"
        }
    }).data("kendoValidator");

    // Masked Text box rules
    $(".phone-number").kendoMaskedTextBox({
        mask: "(999) 000-0000"
    });

    $(".creditcard-number").kendoMaskedTextBox({
        mask: "0000 0000 0000 0000"
    });
});

function displayLoading(target) {
    var element = $(target);
    kendo.ui.progress(element, true);
}
function hideLoading(target) {
    var element = $(target);
    kendo.ui.progress(element, false);
}