jQuery(document).ready(function($) {
    let currentPage = 1;
    let searchTimeout;

    // Tab navigation
    $('.streamcart-tabs .nav-tab').on('click', function(e) {
        e.preventDefault();
        const target = $(this).attr('href').substring(1);
        
        $('.nav-tab').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
        
        $('.tab-pane').removeClass('active');
        $(`#${target}`).addClass('active');
    });

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

    // Product search and pagination
    $('#product-search').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            currentPage = 1;
            loadProducts();
        }, 500);
    });

    $(document).on('click', '.pagination-link', function(e) {
        e.preventDefault();
        currentPage = $(this).data('page');
        loadProducts();
    });

    // Product list
    function loadProducts() {
        const search = $('#product-search').val();
        
        $.get(ajaxurl, {
            action: 'streamcart_get_products',
            search: search,
            page: currentPage
        }).done(function(response) {
            if (response.success) {
                renderProducts(response.data.products);
                renderPagination(response.data.total_pages);
            }
        });
    }

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

    function renderPagination(totalPages) {
        const pagination = $('#product-pagination');
        pagination.empty();

        if (totalPages <= 1) return;

        for (let i = 1; i <= totalPages; i++) {
            pagination.append(`
                <a href="#" class="pagination-link ${i === currentPage ? 'current' : ''}" 
                   data-page="${i}">${i}</a>
            `);
        }
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

    // Settings form
    $('#streamcart-settings').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        
        $.post(ajaxurl, {
            action: 'streamcart_save_credentials',
            data: formData
        }).done(function(response) {
            if (response.success) {
                showNotification('Settings saved successfully');
            } else {
                showNotification(response.data, 'error');
            }
        });
    });

    // Utilities
    function formatPrice(price) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(price);
    }

    function showNotification(message, type = 'success') {
        const notification = $('<div></div>')
            .addClass(`notice notice-${type}`)
            .text(message)
            .insertBefore('.streamcart-tabs');
            
        setTimeout(function() {
            notification.fadeOut(function() {
                $(this).remove();
            });
        }, 3000);
    }

    // Initialize
    loadProducts();
});