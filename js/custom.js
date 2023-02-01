var test = 'daaaaaaaaaaaaaaaa';
var apiData = {};

// Load DOM 
$(document).ready(function(){
    // Add the active page class via jquery
    var li_element = $('li[data-activepage="'+ current_page +'"]'); // current_page passed by when loaded
    li_element.addClass("active");
    
    var test2 = 'xoxoxoxoxoxoxoxoxo';  

    // Initial loading the data from the api
    apiCall();
    
    apiData = apiCall() === undefined ? 'dummyData' : apiCall();
    console.log(apiData);
});

// Make the API ajax call
function apiCall(){

        $.ajax({
            type: "GET",
            url: "https://picsum.photos/v2/list?limit=100",
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
                // return response;
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
