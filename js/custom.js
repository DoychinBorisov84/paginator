$(document).ready(function(){
    // Add the active page class via jquery
    // var li_element = $('li[data-activepage="'+ current_page +'"]'); // current_page passed by when loaded
    // li_element.addClass("active");
    
    // Set the select->selected based on http-query param
    var urlParams = (new URL(document.location)).searchParams;
    var urlDatasource = urlParams.get('dataSource');
    $('#dataSource').val(urlDatasource);

    // Init data loaded, to use size, etc ... on page load ??? 
    initDataCall();

    // Trigger dataSource change event
    $("#dataSource").on('change', function () {  
        // initDataCall();// return;
        
        var currentUrl = new URL(window.location.href);
        var params = new URLSearchParams(currentUrl.search);
        var selectedDatasource = $('#dataSource').find(":selected").val();
        params.set('dataSource', selectedDatasource);
        currentUrl.search = params;

        window.location.href = currentUrl;
    });
    ///////////

});

// Make the API ajax call
function restApiCall(){
        $.ajax({
            type: "GET",
            url : "https://random-data-api.com/api/v2/users?size=88&response_type=json",
            dataType: "json",
            beforeSend: function(){
                // console.log('before');
            },
            complete: function(jqXHR, status){
                // console.log(status);
            },
            success: function (response) {
                // console.log(response);
                initiatePaginator(response);
            },
            error: function(jqXHR, status, error){
                // console.log(error);
            }       
        });
}

// Call the function into the success() when data is collected via rest-api/database...
function initiatePaginator(rawApiData){
    var currentUrl = ((new URL(document.location)));
    // var currentUrl = ((new URL(document.location)).search).slice(1);    
    // console.log(currentUrl.searchParams.get('dataSource'));
    // console.log(rawApiData);
    if(rawApiData != undefined) {
        $.ajax({
            type: "POST",
            url: "/paginator/api/Initiator.php",
            data: { "page" : currentUrl.searchParams.get('page'), "dataSourceType" : currentUrl.searchParams.get('dataSource'), "current_url" : currentUrl.href, "ajaxDataSize" : rawApiData.length, "ajaxData" : rawApiData },
            dataType: "json",
            // contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            beforeSend: function(){
                // console.log(rawApiData);
            },
            success: function (initPaginatedDataSource) {
                console.log(initPaginatedDataSource, rawApiData);
                setContentHtmlDom(rawApiData, initPaginatedDataSource);
                setPaginatorHtmlDom(initPaginatedDataSource);
            },
            error: function(jqXHR, response){
                console.log(response, jqXHR);
            }
        });
    }else{
        // DefaultDataSource call ....
        // console.log('heree');
        $.ajax({
            type: "POST",
            url: "/paginator/api/Initiator.php",
            data: { "page" : currentUrl.searchParams.get('page'), "dataSourceType" : currentUrl.searchParams.get('dataSource'), "current_url" : currentUrl.href},
            dataType: "json",
            // contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            beforeSend: function(){
                // console.log(rawApiData)
            },
            success: function (initPaginatedDataSource) {
                console.log(initPaginatedDataSource);
                setContentHtmlDom(initPaginatedDataSource.dataSource_data, initPaginatedDataSource);
                setPaginatorHtmlDom(initPaginatedDataSource);
            },
            error: function(jqXHR, response){
                console.log(response, jqXHR);
            }
        });
    }
}

function setContentHtmlDom(rawApiData, initPaginatedDataSource){
    // TODO: Unify based on the initPaginatedDataSource -> how to apply the data to the DOM structure
    // console.log(JSON.parse(rawApiData[0].address).country); // Parsing from DB
    // console.log(rawApiData); 
    
    // Content section create needed rows
    var row = $('.container .row').clone();
    for(var i = 0; i < initPaginatedDataSource.total_rows - 1 ; i++){
        // console.log(i);
        $(row).insertAfter($('.container .row'));    
    }

    // setPaginatorHtmlDom(rawApiData);

    var urlParams = (new URL(document.location)).searchParams;
    var urlPage = urlParams.get('page');
    var offset = ((urlPage * 12) - 12); // +1
    
    // Fill the DOM with the data received
    $('.container .row .col').each(function(index, element){
        // console.log(rawApiData.length, offset, index, element );

        // Unify the approach for the data received
        if (rawApiData.length > (offset + 1 + index) ) {
            // console.log(rawApiData.length, offset, index, element);
            $(element).find('.card img').attr('src', rawApiData[index+offset+1].avatar);
            $(element).find('.card-body .card-title').text(rawApiData[index+offset+1].first_name);
            $(element).find('.card-body .card-text').text(rawApiData[index+offset+1].address.city + ', ' + rawApiData[index+offset+1].email);
    
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

function setPaginatorHtmlDom(paginatorArr){
    var paginator = paginatorArr;    
    // console.log(paginator);    // Pagination section
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

        $(element).find('#last-page').attr('href', paginator.last_page); // ,paginatorArr[index+offset+1].avatar        

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
    var selectedDatasource = $('#dataSource').find(":selected").val();    
    
    if(selectedDatasource == 'restapi'){
        restApiCall();
        console.log('restApiCall()');
    }else if(selectedDatasource == 'database'){
        //Unify and trigger the local data ->  InitiatePaginator with the url params ?
        initiatePaginator();
        console.log('databaseApiCall()');
    }else if(selectedDatasource == 'defaultData'){
        //Unify and trigger the local data ->  InitiatePaginator with the url params ?
        initiatePaginator();
        console.log('defaultDataCall()');
    }
    else{

    }    
}   