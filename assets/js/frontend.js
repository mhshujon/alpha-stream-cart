jQuery(document).ready(function($) {
    let streamActive = false;
    let commentsInterval;

    function initializeStream(streamId) {
        // Initialize Facebook Live player
        FB.XFBML.parse();
        
        streamActive = true;
        startCommentsFetch();
        updateStreamStats();
    }

    function startCommentsFetch() {
        commentsInterval = setInterval(function() {
            if (!streamActive) {
                clearInterval(commentsInterval);
                return;
            }

            $.get(ajaxurl, {
                action: 'streamcart_fetch_comments'
            }).done(function(response) {
                if (response.success) {
                    updateComments(response.data.comments);
                }
            });
        }, 5000);
    }

    function updateComments(comments) {
        const container = $('#stream-comments');
        comments.forEach(function(comment) {
            container.prepend(`
                <div class="comment">
                    <span class="author">${comment.author}</span>
                    <span class="message">${comment.message}</span>
                </div>
            `);
        });
    }

    function updateStreamStats() {
        $.get(ajaxurl, {
            action: 'streamcart_get_stats'
        }).done(function(response) {
            if (response.success) {
                $('#viewers').text(response.data.viewers);
                $('#likes').text(response.data.likes);
            }
        });
    }

    // Product interactions
    $(document).on('click', '.add-to-cart', function() {
        const productId = $(this).data('product-id');
        
        $.post(ajaxurl, {
            action: 'streamcart_add_to_cart',
            product_id: productId
        }).done(function(response) {
            if (response.success) {
                showNotification('Product added to cart');
            }
        });
    });

    function showNotification(message) {
        const notification = $('<div class="streamcart-notification"></div>')
            .text(message)
            .appendTo('body');
            
        setTimeout(function() {
            notification.fadeOut(function() {
                $(this).remove();
            });
        }, 3000);
    }
});