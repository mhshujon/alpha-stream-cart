jQuery(document).ready(function($) {
    // Stream controls
    $('#start-stream').on('click', function() {
        $(this).prop('disabled', true);
        $('#stop-stream').prop('disabled', false);
        
        $.post(ajaxurl, {
            action: 'streamcart_create_stream'
        }).done(function(response) {
            if (response.success) {
                initializeStream(response.data.stream_id);
                showNotification('Stream started successfully');
            } else {
                showNotification(response.data, 'error');
                $('#start-stream').prop('disabled', false);
                $('#stop-stream').prop('disabled', true);
            }
        });
    });

    $('#stop-stream').on('click', function() {
        if (!confirm('Are you sure you want to end the stream?')) {
            return;
        }

        $(this).prop('disabled', true);
        $('#start-stream').prop('disabled', false);
        
        $.post(ajaxurl, {
            action: 'streamcart_stop_stream'
        }).done(function(response) {
            if (response.success) {
                showNotification('Stream ended successfully');
            } else {
                showNotification(response.data, 'error');
            }
        });
    });

    function renderProducts(products) {
        const container = $('#product-list');
        container.empty();
        
        products.forEach(function(product) {
            const buttonClass = product.in_stream ? 'remove-from-stream' : 'add-to-stream';
            const buttonText = product.in_stream ? 'Remove from Stream' : 'Add to Stream';
            
            container.append(`
                <div class="product-item" data-id="${product.id}">
                    <img src="${product.image}" alt="${product.name}">
                    <h4>${product.name}</h4>
                    <p class="price">${formatPrice(product.price)}</p>
                    <p class="stock-status ${product.stock_status}">${product.stock_status}</p>
                    <button class="button ${buttonClass}" data-product-id="${product.id}">
                        ${buttonText}
                    </button>
                </div>
            `);
        });
    }

    // Product stream management
    $(document).on('click', '.add-to-stream', function() {
        const button = $(this);
        const productId = button.data('product-id');
        
        $.post(ajaxurl, {
            action: 'streamcart_add_stream_product',
            product_id: productId
        }).done(function(response) {
            if (response.success) {
                button
                    .text('Remove from Stream')
                    .removeClass('add-to-stream')
                    .addClass('remove-from-stream');
                showNotification('Product added to stream');
            }
        });
    });

    $(document).on('click', '.remove-from-stream', function() {
        const button = $(this);
        const productId = button.data('product-id');
        
        $.post(ajaxurl, {
            action: 'streamcart_remove_stream_product',
            product_id: productId
        }).done(function(response) {
            if (response.success) {
                button
                    .text('Add to Stream')
                    .removeClass('remove-from-stream')
                    .addClass('add-to-stream');
                showNotification('Product removed from stream');
            }
        });
    });

    const handleAccordion = () => {
        const $accordionItems = $('.accordion-item');

        $accordionItems.each(function () {
            const $header = $(this).find('.accordion-header');
            const $connectBtn = $(this).find('.connect-btn');

            // Prevent click on connect button from triggering accordion
            $connectBtn.on('click', function (e) {
                e.stopPropagation(); // Stops the click from affecting parent elements
            });

            $header.on('click', function () {
                // Check if the accordion is marked as "Pro"
                if ($(this).parent().data('pro') === true) {
                    alert('This is a premium feature. Upgrade to access it!');
                    return; // Prevent expansion
                }
                // Close other accordion items
                $accordionItems.not($(this).parent()).removeClass('open');
                $accordionItems.not($(this).parent()).find('.accordion-content').css('max-height', '0');

                // Toggle the clicked item
                const $content = $(this).siblings('.accordion-content');
                if ($(this).parent().hasClass('open')) {
                    $(this).parent().removeClass('open');
                    $content.css('max-height', '0');
                } else {
                    $(this).parent().addClass('open');
                    $content.css('max-height', $content.prop('scrollHeight') + 'px');
                }
            });
        });
    }

    handleAccordion();
});