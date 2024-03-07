"use strict";

jQuery(document).ready(function ($) {

    if ('' == voting_ajax_object.has_voted) {

        $(document).on('click', '.vote-button', function () {

            var button = $(this);
            var post_id = button.data('post-id');
            var vote = button.data('vote');
            var security_key = $('#pvote_submit').val();

            button.addClass('active');
            $('.vote-button').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: voting_ajax_object.ajax_url,
                data: {
                    action: 'pvote_submit_vote',
                    post_id: post_id,
                    vote: vote,
                    pvote_submit: security_key
                },
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.success) {
                        $('.voting-results .voting-panel .positive .percentage').html(response.percentage.positive);
                        $('.voting-results .voting-panel .negative .percentage').html(response.percentage.negative);
                        $('.voting-results').addClass('active');
                        $('.voting-panel label').removeClass('active');
                        $('.voting-panel .' + vote).addClass('active');

                    } else if (response.error) {
                        alert(response.error);
                    }
                },
            });
        });
    }
});