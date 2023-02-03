var test = 'daaaaaaaaaaaaaaaa';
var apiData = {};

// Load DOM 
$(document).ready(function(){
    // Add the active page class via jquery
    var li_element = $('li[data-activepage="'+ current_page +'"]'); // current_page passed by when loaded
    li_element.addClass("active");
    
    var test2 = 'xoxoxoxoxoxoxoxoxo';  

    // Initial loading the data from the api
    // apiCall();
    
    // apiData = apiCall() === undefined ? 'dummyData' : apiCall();

    // Set the selectselected based on http-query param
    var urlParams = (new URL(document.location)).searchParams;
    var urlDatasource = urlParams.get('dataSource');
    $('#dataSource').val(urlDatasource);


    // Load the data based on select
    var selectedDatasource = $('#dataSource').find(":selected").val();    
    if(selectedDatasource == 'api'){
        apiData = apiCall();
        // console.log(apiData);
    }else if(selectedDatasource == 'database'){
        apiData = databaseCall();
    }else{
        // default 50 items load
    }
    // console.log(apiData);

    // Keep the text inside the card at minimum width
    // $('.row .col .card-body .card-text').each(function(index){
    //     console.log($(this).text());
    // });

    
    // return;
    // $('#dataSource').val('api');

    // console.log(apiData);
});

// Make the API ajax call
function apiCall(){

        $.ajax({
            type: "GET",
            //url: "https://picsum.photos/v2/list?limit=100",
            url : "https://random-data-api.com/api/v2/users?size=100&response_type=json",
            // data: "dummyDataSent",
            dataType: "json",
            beforeSend: function(){
                // console.log('before');
            },
            complete: function(jqXHR, status){
                // console.log(status);
            },
            success: function (response) {  
                apiData = JSON.stringify(response);
                // console.log(response);
                // Work with the data due to async call, so n/a data into the document.ready()
                // each ... set
               
                
                // console.log(index2, value, $(this));
                // TODO: how to manage page=2? ....
                var urlParams = (new URL(document.location)).searchParams;
                var urlPage = urlParams.get('page');
                var offset = ((urlPage * 12) - 12); // +1
                // console.log(urlPage, offset);

                $('.container .row .col').each(function(index, element){
                    // console.log(index, $(this), response[index]);
                    // console.log(urlPage, offset, index);
                    // console.log(index+offset+1);
                    //TODO:  Clean, document, optimize, bring into the js-file from content if possible, and continue with DB option
                    console.log(response[index+offset+1]);
                    

                    // console.log($(this), index);
                    // console.log(element, response);
                    $(element).find('.card-body .card-title').text(response[index+offset+1].first_name);
                    $(element).find('.card-body .card-text').text(response[index+offset+1].address.city + ', ' + response[index+offset+1].email);
                    $(element).find('.card img').attr('src', response[index+offset+1].avatar);
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
            // console.log(response);
            // return;
            var urlParams = (new URL(document.location)).searchParams;
            var urlPage = urlParams.get('page');
            var offset = ((urlPage * 12) - 12); // +1
            // console.log(urlPage, offset);

            $('.container .row .col').each(function(index, element){
                // console.log(index, $(this), response[index]);
                // console.log(urlPage, offset, index);
                // console.log(index+offset+1);
                //TODO:  Clean, document, optimize, bring into the js-file from content if possible, and continue with DB option
                // console.log(response[index+offset]);
                

                // console.log($(this), index);
                // console.log(element, response);
                $(element).find('.card-body .card-title').text(response[index+offset].first_name);
                $(element).find('.card-body .card-text').text(response[index+offset].email);
                // $(element).find('.card img').attr('src', response[index+offset+1].avatar);
                // $('.card-body .card-title').text(response[index].first_name);
                // $('.card-text').text(response[0].address.city + ', ' + response[0].address);

                // TODO: keep the text size in limit to prevent overlapping divs
                // $('.row .col .card-body .card-text').each(function(index){
                console.log( $(element).find('.card-body .card-text').text(), $(element).find('.card-body .card-text').text().length );
                
                if( $(element).find('.card-body .card-text').text().length > 25 ) {
                    $(element).find('.card-body .card-text').text($(element).find('.card-body .card-text').text().slice(0, 25));
                    console.log($(element).find('.card-body .card-text').text().slice(0, 25));
                    // TODO.... continue here Click to expand the sliced text.
                    $(element).find('.card-body .card-text').text();
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

// Add the active page class
// var li_element = document.querySelector('[data-activepage="'+ current_page +'"]'); // current_page passed by when loaded
// console.log(document.querySelector('li[data-activepage="1"]'));
// li_element.classList.add('active');

// Without submitting the form? Catch the data on change ?
// var form = document.querySelector('#source');
