$(document).ready(function () {
    $('#property-like-button').on("click", function (event){
        let propertyId = $('#property-id').val();
        console.log(propertyId);
        $.ajax({
            url: '/property/like',
            type: 'POST',
            data: { propertyId: propertyId },

            success: function (data) {
                if (!data || (data && data.error())) {
                    return;
                }

                $('#property-likes').value += 1;
            },

            error: function (data) {
                alert('Liking this property failed');
            }
        })
    })
})