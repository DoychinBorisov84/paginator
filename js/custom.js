// var test = 'daaaaaaaaaaaaaaaa';
// var dataSource;

// Load DOM 
$(document).ready(function(){
    // Add the active page class via jquery
    var li_element = $('li[data-activepage="'+ current_page +'"]'); // current_page passed by when loaded
    li_element.addClass("active");
    
    var test2 = 'xoxoxoxoxoxoxoxoxo';  

    // Set the selectselected based on http-query param
    var urlParams = (new URL(document.location)).searchParams;
    var urlDatasource = urlParams.get('dataSource');
    $('#dataSource').val(urlDatasource);

    // Init data loaded, to use size, etc ... on page load ??? 
    initDataCall();
    // console.log(dataSource, current_page);

    ///////////////////
    $("#dataSource").on('change', function () {  
        // initDataCall();return
        // Add url params Without reload !!!!
        // const url = new URL(window.location);
        // console.log(url);
        // return;
        // url.searchParams.set('foo', 'bar');
        // window.history.pushState({}, '', url);
        // return;

        // get/set/redirect to index based on the dataSource params from the <select>
        var currentUrl = new URL(window.location.href);
        var params = new URLSearchParams(currentUrl.search);
        var selectedDatasource = $('#dataSource').find(":selected").val();

        params.set('dataSource', selectedDatasource);
        currentUrl.search = params;
        // Refactor and remove if possible to ?
        window.location.href = currentUrl;
    });
    ///////////

});

// Make the API ajax call
function apiCall(){
    var paginator;
        $.ajax({
            type: "GET",
            //url: "https://picsum.photos/v2/list?limit=100",
            url : "https://random-data-api.com/api/v2/users?size=88&response_type=json",
            // data: "dummyDataSent",
            dataType: "json",
            beforeSend: function(){
                // console.log('before');
            },
            complete: function(jqXHR, status){
                // console.log(status);
            },
            success: function (response) {  
                // Pass cookie to index.php
                // document.cookie = "response_size="+response.length+"; expires=Thu, 18 Dec 2023 12:00:00 UTC";
                // document.cookie = "items="+JSON.stringify(response[0])+";response_size="+response.length+"; expires=Thu, 18 Dec 2023 12:00:00 UTC";
                // console.log(JSON.stringify(response[0]), response.length);

                // Test with another ajax to load the prepared Paginator
                paginator = initiatePaginator(response);
                // console.log(paginator);
                


                // Set the items and offset based on the GET['page']
                // TODO: how to manage page=2? ....
                var urlParams = (new URL(document.location)).searchParams;
                var urlPage = urlParams.get('page');
                var offset = ((urlPage * 12) - 12); // +1
                // console.log(urlPage, offset);

                // Fill the DOM with the data received
                $('.container .row .col').each(function(index, element){
                    // console.log(index, $(this), response[index]);
                    // console.log(urlPage, offset, index);
                    // console.log(index+offset+1);
                    //TODO:  Clean, document, optimize, bring into the js-file from content if possible, and continue with DB option
                    // console.log(response[index+offset+1]);
                    

                    // console.log($(this), index);
                    // console.log(element, response);
                    $(element).find('.card img').attr('src', response[index+offset+1].avatar);
                    $(element).find('.card-body .card-title').text(response[index+offset+1].first_name);
                    $(element).find('.card-body .card-text').text(response[index+offset+1].address.city + ', ' + response[index+offset+1].email);

                    if( $(element).find('.card-body .card-text').text().length > 25 ) {
                        var originText = $(element).find('.card-body .card-text').text();
                        var slicedText = $(element).find('.card-body .card-text').text().slice(0, 22)+'...';
                        $(element).find('.card-body .card-text').text($(element).find('.card-body .card-text').text().slice(0, 22)+'...');
                        // console.log($(element).find('.card-body .card-text').text().slice(0, 25));
                        // TODO.... continue here Click to expand the sliced text.
                        // console.log($(this));
                        $(this).hover(
                            function(){
                                // console.log('entered');
                                // console.log($(this), originText, $(element).find('.card-body .card-text').text());
                                $(element).find('.card-body .card-text').addClass('onFocus');
                                $(element).find('.card-body .card-text').text(originText);
                                // $(this).append($("<span>***</span>"));
                            },
                            function(){
                                // console.log('left');
                                $(element).find('.card-body .card-text').removeClass('onFocus');
                                $(element).find('.card-body .card-text').text(slicedText);
                                // $(this).find("span").last().remove();
                            }
                        );
                    }

                    
                    // $('.card-body .card-title').text(response[index].first_name);
                    // $('.card-text').text(response[0].address.city + ', ' + response[0].address);

                    // $.each(response, function(index2, value) {
                    //     console.log($(this), index2, value);
                    // });
                });




                var html = $('.container').html();
                // console.log(html);
                $(html).each(function(index) {                    

                    //iterate over api data .... counters for html el/response data obj
                    $.each(response, function(index, value) {
                        // console.log(index, value);
                        // $('.card-body .card-title').text(index.first_name);
                        // $('.card-text').text(response[0].address.city + ', ' + response[0].addr
                    });
                    // $('.card .card-body .card-title').text();
                    // console.log($('.card .card-body .card-title').text());
                    // console.log(index + $(this).text());
                });
                // $('.card img').attr('src', response[0].avatar);
                // $('.card-body .card-title').text(response[0].first_name);
                // $('.card-text').text(response[0].address.city + ', ' + response[0].address.country);
                // console.log(response[0]);
            },
            error: function(jqXHR, status, error){
                // console.log(error);
            }       
        });
}

function databaseCall(){
    // var data = (new URL(document.location)).search;
    // console.log(data);
    // test();

    $.ajax({
        type: "GET",
        url : "/paginator/api/data_sources.php",
        data: ((new URL(document.location)).search).slice(1),
        dataType: "json",
        beforeSend: function(){
            // console.log('before');
        },
        complete: function(jqXHR, status){
            // console.log(status);
        },
        success: function (response) {  
            // console.log(response); //, response.length
            // document.cookie = "items="+JSON.stringify(response[0])+";response_size="+response.length+"; expires=Thu, 18 Dec 2023 12:00:00 UTC";
            // console.log(JSON.stringify(response[0]), response.length);
            // test();
            // dataSource = response;
            // return;
            // Set the items and offset based on the GET['page']
            var urlParams = (new URL(document.location)).searchParams;
            var urlPage = urlParams.get('page');
            var offset = ((urlPage * 12) - 12); // +1
            // console.log(urlPage, offset);

            // Fill the DOM with the data received
            $('.container .row .col').each(function(index, element){
                // console.log(index, $(this), response[index]);
                // console.log(urlPage, offset, index);
                // console.log(index+offset+1);
                //TODO:  Clean, document, optimize, bring into the js-file from content if possible, and continue with DB option
                // console.log(response[index+offset]);
                

                // console.log($(this), index);
                // console.log(element, response);
                $(element).find('.card img').attr('src', 'assets/database_user.jpg'); // ,response[index+offset+1].avatar
                $(element).find('.card-body .card-title').text(response[index+offset].first_name);
                $(element).find('.card-body .card-text').text(response[index+offset].email);
                // $(element).find('.card img').attr('src', response[index+offset+1].avatar);
                // $('.card-body .card-title').text(response[index].first_name);
                // $('.card-text').text(response[0].address.city + ', ' + response[0].address);

                // TODO: keep the text size in limit to prevent overlapping divs
                // $('.row .col .card-body .card-text').each(function(index){
                // console.log( $(element).find('.card-body .card-text').text(), $(element).find('.card-body .card-text').text().length );
                
                if( $(element).find('.card-body .card-text').text().length > 25 ) {
                    var originText = $(element).find('.card-body .card-text').text();
                    var slicedText = $(element).find('.card-body .card-text').text().slice(0, 22)+'...';
                    $(element).find('.card-body .card-text').text($(element).find('.card-body .card-text').text().slice(0, 22)+'...');
                    // console.log($(element).find('.card-body .card-text').text().slice(0, 25));
                    // TODO.... continue here Click to expand the sliced text.
                    // console.log($(this));
                    $(this).hover(
                        function(){
                            // console.log('entered');
                            // console.log($(this), originText, $(element).find('.card-body .card-text').text());
                            $(element).find('.card-body .card-text').addClass('onFocus');
                            $(element).find('.card-body .card-text').text(originText);
                            // $(this).append($("<span>***</span>"));
                        },
                        function(){
                            // console.log('left');
                            $(element).find('.card-body .card-text').removeClass('onFocus');
                            $(element).find('.card-body .card-text').text(slicedText);
                            // $(this).find("span").last().remove();
                        }
                    );
                }
                // });

                

                // $.each(response, function(index2, value) {
                //     console.log($(this), index2, value);
                // });
            });
        },
        error: function(jqXHR, status, error){
            // console.log(error);
        }       
    });
}

function defaultDataCall(){
    // Todo
}

function emptySelect(){
    // Todo
}

// Call the function into the success() when data is collected via rest-api/database...
function initiatePaginator(responseSending){
    var urlParams1 = (new URL(document.location)).searchParams;
    // console.log(urlParams1);
    $.ajax({
        type: "POST",
        url: "/paginator/api/Initiator.php",
        data: { "page" : urlParams1.get('page'), "ajaxDataSize" : responseSending.length, "ajaxData" : responseSending },
        dataType: "json",
        // contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        beforeSend: function(){
            // console.log(responseSending)
        },
        success: function (response) {
            console.log(response);
            applyDom(response)
            // return response;
        },
        error: function(response){
            console.log(response);
        }
    });
}

function applyDom(response){
    var paginator = response;

    // Testing Last page applying element
    // $(element).find('.page-link').attr('src', 'assets/database_user.jpg');
    $('.pagination .page-item').each(function(index, element){
        console.log(element);
        $(element).find('#last-page').attr('href', paginator.last_page); // ,response[index+offset+1].avatar

        if(paginator.current_page < paginator.total_pages){
            $(element).find('#last-page').removeClass('link-danger'); 
        }
    });

    console.log(response);
}


// Init the call, so we can have base dataSource
function initDataCall(){
    var selectedDatasource = $('#dataSource').find(":selected").val();    
    
    if(selectedDatasource == 'restapi'){
        apiCall(); //'api'; 
        console.log('apiCall()');
    }else if(selectedDatasource == 'database'){
        databaseCall();
        console.log('databaseCall()');
    }else if(selectedDatasource == 'defaultData'){
        defaultDataCall();
        console.log('defaultDataCall() 50items');
    }
    else{

    }
    
}

// function test(){
//     console.log('testing from custom.js');
//     var xxx = 'Paginator object?';
//     return xxx;
// }
