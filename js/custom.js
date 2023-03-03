$(document).ready(function(){
    initDataCall();

    // Trigger dataSource change event
    $("#dataSource").on('change', function () {  
        setDataSourceAndRedirect();
    });
});

// External Resource API ajax collect data
function restApiCall(){
        $.ajax({
            type: "GET",
            url : "https://random-data-api.com/api/v2/users?size=88&response_type=json",
            dataType: "json",
            success: function (response) {
                initiatePaginator(response);
            },
            error: function(jqXHR, status, error){
                console.log(error);
            }       
        });
}

// Collect our data from the API | local | database sources and fill the html DOM with the data
function initiatePaginator(rawApiData){
    var currentUrl = ((new URL(document.location)));
    var data = rawApiData !== undefined ? rawApiData : {}; // have|not initial data to send for preparation

        $.ajax({
            type: "POST",
            url: "/paginator/api/initPaginator.php",
            data: {"ajaxData" : data, "ajaxDataSourceType" : currentUrl.searchParams.get('dataSource'), "ajaxCurrentUrl" : currentUrl.href },
            dataType: "json",
            success: function (initPaginatedDataSource) {
                setContentHtmlDom(initPaginatedDataSource);
                setPaginatorHtmlDom(initPaginatedDataSource);
            },
            error: function(jqXHR, response){
                console.log(response, jqXHR);
            }
        });
}

// Dynamically create DOM structure based on the data source 
function setContentHtmlDom(initPaginatedDataSource){
    // Add the rows
    var row = $('.container .row').clone();
    for(let i = 0; i < initPaginatedDataSource.total_rows - 1 ; i++){
        $(row).insertAfter($('.container .row'));
    }

    // Add the columns
    $.each($('.container .row'), function(index, element){
        for (let index = 0; index < initPaginatedDataSource.total_items_per_row - 1; index++) {
            var col = $('.container .row .col').clone();

            $(element).append($(col.first()));
        }  
    });

    // Fill the DOM with the data received
    var offset = initPaginatedDataSource.current_page_images_offset;    
    $('.container .row .col').each(function(index, element){
        if (initPaginatedDataSource.dataSource_data.length > (offset + index) ) {
            $(element).find('.card img').attr('src', initPaginatedDataSource.dataSource_data[offset+index].avatar);
            $(element).find('.card-body .card-title').text(initPaginatedDataSource.dataSource_data[offset+index].first_name);
            $(element).find('.card-body .card-text').text(initPaginatedDataSource.dataSource_data[offset+index].address.city + ', ' + initPaginatedDataSource.dataSource_data[offset+index].email);
    
            if( $(element).find('.card-body .card-text').text().length > 25 ) {
                var originText = $(element).find('.card-body .card-text').text();
                var slicedText = $(element).find('.card-body .card-text').text().slice(0, 22)+'...';
                $(element).find('.card-body .card-text').text($(element).find('.card-body .card-text').text().slice(0, 22)+'...');
                $(this).hover(
                    function(){
                        $(element).find('.card-body .card-text').addClass('onFocus');
                        $(element).find('.card-body .card-text').text(originText);
                    },
                    function(){
                        $(element).find('.card-body .card-text').removeClass('onFocus');
                        $(element).find('.card-body .card-text').text(slicedText);
                    }
                );
            }            
        }
    });
}

// Set the paginator section data, classes, active elements etc based on the data source obj and the current page
function setPaginatorHtmlDom(paginatorArr){
    var paginator = paginatorArr;    
    
    $('.pagination .page-item').each(function(index, element){  
        // Show hide the > ...dots/current-page block in pagination
        if($(element).hasClass('iterator-block') ){
            if(paginator.current_page > 2){
                $(element).removeClass('iterator-block');
            }
            else{
                $(element).addClass('iterator-block')
            }
        }

        $(element).find('#previous-page').attr('href', paginator.previous_page);
        
        if($(element).data('activepage') == 1){
            $(element).children('.page-link').attr('href', paginator.get_page_1);
        }else if($(element).data('activepage') == 2){
            $(element).children('.page-link').attr('href', paginator.get_page_2);
        }        

        if($(element).attr('data-activepage') == paginator.current_page){
            $(element).addClass('active');
        }
        
        $(element).find('#next-page').attr('href', paginator.next_page);

        $(element).find('#last-page').attr('href', paginator.last_page); 

        $(element).find('#current-page').attr('href', paginator.get_page_current);
        $(element).find('#current-page').text(paginator.current_page);
        $(element).find('#current-page').parent().attr('data-activepage', paginator.current_page);
        $(element).find('#current-page').parent().addClass('active');

        if(paginator.current_page < paginator.total_pages){
            $(element).find('#last-page').removeClass('link-danger');
            $(element).find('#next-page').removeClass('link-danger disabled') ;
        }else if(paginator.current_page >= paginator.total_pages){
            $(element).find('#last-page').addClass('link-danger disabled');
            $(element).find('#next-page').addClass('link-danger disabled');
        }

        if(paginator.current_page <= 1){
            $(element).find('#previous-page').addClass('link-danger disabled') ;
        }
    });

}

// Init the call, so we can have base dataSource
function initDataCall(){
    // Set the select->selected based on http-query param
    var urlParams = (new URL(document.location)).searchParams;
    var urlDatasource = urlParams.get('dataSource');    
    $('#dataSource').val(urlDatasource);

    if(urlDatasource != ''){
        if(urlDatasource == 'restapi'){
            restApiCall();
        }else if(urlDatasource == 'database'){
            initiatePaginator();
        }else if(urlDatasource == 'defaultData'){
            initiatePaginator();
        }
    }
}   

function setDataSourceAndRedirect(){
    var currentUrl = new URL(window.location.href);
    var params = new URLSearchParams(currentUrl.search);
    var selectedDatasource = $('#dataSource').find(":selected").val();

    if(selectedDatasource != ''){
        params.set('dataSource', selectedDatasource);
        currentUrl.search = params;
    
        window.location.href = currentUrl;
    }
}