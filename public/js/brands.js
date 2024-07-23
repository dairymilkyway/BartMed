$(document).ready(function() {
    const brandListApi = $('#brandList'); // For AJAX API results
    const resultsCount = $('#resultsCount');
    let page = 1;
    let isLoading = false;

    // Fetch brands from /api/brand-fetch API
    function fetchApiBrands(page, reset = false) {
        if (isLoading) return;
        isLoading = true;

        $.ajax({
            url: `/api/brand-fetch?page=${page}`,
            type: 'GET',
            beforeSend: function() {
                $('#loadingSpinner').removeClass('hidden');
            },
            success: function(response) {
                $('#loadingSpinner').addClass('hidden');

                if (reset || page === 1) {
                    brandListApi.empty();
                }

                if (response.data && response.data.length) {
                    response.data.forEach(brand => {
                        const apiBrandHtml = `
                            <a href="#" class="group block overflow-hidden" onclick="openBrandModal(${brand.id}, '${brand.brand_name}', '${brand.img_path}')">
                                <img
                                    src="${brand.img_path}"
                                    alt="${brand.brand_name}"
                                    class="h-[250px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[300px]"
                                />
                                <div class="relative bg-white pt-3 p-4">
                                    <h1 class="text-xl font-bold text-gray-700 group-hover:underline group-hover:underline-offset-4">
                                        ${brand.brand_name}
                                    </h1>
                                </div>
                            </a>
                        `;
                        brandListApi.append(apiBrandHtml);
                    });

                    const displayedCount = brandListApi.find('a').length;
                    const totalResults = response.total;
                    resultsCount.text(`Showing ${displayedCount} of ${totalResults} results`);

                    if (response.next_page_url) {
                        $(window).on('scroll', onScroll);
                    } else {
                        $(window).off('scroll', onScroll);
                        brandListApi.append('<p class="text-gray-500 text-center mt-4">End of Brand Results</p>');
                    }
                } else {
                    brandListApi.append('<p class="text-gray-500 text-center mt-4">No brands found.</p>');
                }

                isLoading = false;
            },
            error: function(err) {
                console.error('Error fetching brands from backend:', err);
                $('#loadingSpinner').addClass('hidden');
                isLoading = false;
            }
        });
    }

    // Handle scrolling to fetch more brands and reset when at top
    function onScroll() {
        const scrollTop = $(window).scrollTop();
        const windowHeight = $(window).height();
        const documentHeight = $(document).height();

        if (scrollTop + windowHeight >= documentHeight - 200 && !isLoading) { 
            page++;
            fetchApiBrands(page);
        } else if (scrollTop === 0 && !isLoading) { 
            page = 1;
            fetchApiBrands(page, true);
        }
    }

    $(window).on('scroll', onScroll);

    fetchApiBrands(page);
});

function openBrandModal(brandId, brandName, brandImage) {
    $('#brandName').text(brandName);
    $('#brandImage').attr('src', brandImage);
    $('#brandId').text(brandId);
    $('#brandModal').removeClass('hidden');
}

function closeBrandModal() {
    $('#brandModal').addClass('hidden');
}
