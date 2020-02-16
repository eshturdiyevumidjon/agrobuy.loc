  $(function () {
    // add
    $('.avtorization_class').on('click', function () {
        $('#avtorization').find('#avtorizationContent').load($(this).attr('value'));
    });

    $('.delete_ads').on('click', function () {
        $('#delete-ads-popup').find('#deleteAdsContent').load($(this).attr('value'));
    });

    $('.complaint_class').on('click', function () {
        $('#send-complaint').find('#complaintContent').load($(this).attr('value'));
    });

    $('.star_class').on('click', function () {
        $('#star-popup').find('#starContent').load($(this).attr('value'));
    });

    $('.premium_ads').on('click', function () {
        $('#ad-promotion').find('#premiumContent').load($(this).attr('value'));
    });
    
  });