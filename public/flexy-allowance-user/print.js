var Index = (function () {
    const csrf_token = $('meta[name="csrf-token"]').attr("content");

    //get detail allowance request to show in card (upper area) start
    var getDetailAllowance = function () {
        $.ajax({
            type: "post",
            url: url + "app/flexy-allowance/allowance-request-route.php",
            data: {
                nomer: noAllowance,
                _token: csrf_token,
                action: "print",
            },
            dataType: "json",
            success: function (response) {
                var tableItem = response.item;
                var detail = response.detail;
                var totalClaimAmount = response.total_claim_amount;
                console.log(totalClaimAmount);
                $('#transaction-date').html(detail.transaction_date);
                $('#requestor').html("Requestor: " + detail.user_name);
                $('#company_name').html("Company: " + detail.company_name);
                $('#period').html(detail.period);
                $('#cost_center').html("Cost Center: " + detail.cost_center_name + " | " + detail.dept_name);
                $('#subject').html("Subject: " + detail.subject);
                $('#total_claim_amount').html(totalClaimAmount);
                $('#detailPrint').append(tableItem);

            },
        });
    };
    return {
        init: function () {
            getDetailAllowance();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});