$(document).foundation();

// JavaScript Document

(function() {
	"use strict";
	//onsole.log("SEAF Fired");
	//variables
	// variables
var input = document.querySelector('input');
var results;
var autocomplete_results = document.querySelector("#autocomplete-results");
var i;
var httpRequest;
var filterLinks = document.querySelectorAll("nav a");
var movieSelection = document.querySelector("#movieSelection");

// functions

$(document).ready(function(){
  console.log('loaded');
$.ajax
    ({
      url: 'admin/phpscripts/ajaxQuery.php',
      type: 'GET',
      data: { genre: 'metal' }
    })

    .done(function(data)
    {
      //console.log(data);

      if(data && data !=="null")
      {
        data = JSON.parse(data)

        populateContent(data);
      }
      else
      {
        console.log('something is wrong with your query!');
      }
    })

    .fail(function(ajaxCall, error, status)
    {
      console.log('error');
      console.dir(ajaxCall);
    });

});

function filterLinksClicked(e){
  //console.log(this.id);

  for(i=0 ; i<filterLinks.length ; i++){
    filterLinks[i].classList.remove("active");
  }

  e.currentTarget.classList.add('active');

  if(this.id === 'all'){
    $.ajax
    ({
      url: 'admin/phpscripts/ajaxQuery.php',
      type: 'GET',
      data: { genre: this.id }
    })

    .done(function(data)
    {
      //console.log(data);

      if(data && data !=="null")
      {
        data = JSON.parse(data)

        populateContentFiltered(data);
      }
      else
      {
        console.log('something is wrong with your query!');
      }
    })

    .fail(function(ajaxCall, error, status)
    {
      console.log('error');
      console.dir(ajaxCall);
    });
  }else{
    $.ajax
    ({
      url: 'admin/phpscripts/ajaxQueryFilter.php',
      type: 'GET',
      data: { filter: this.id }
    })

    .done(function(data)
    {
      //console.log(data);

      if(data && data !=="null")
      {
        data = JSON.parse(data)

        populateContentFiltered(data);
      }
      else
      {
        console.log('something is wrong with your query!');
      }
    })

    .fail(function(ajaxCall, error, status)
    {
      console.log('error');
      console.dir(ajaxCall);
    });
  }
}

function populateContentFiltered(data){
  //console.log(data);

  movieSelection.innerHTML = "";

  for(i=0 ; i<data.length ; i++){
    movieSelection.innerHTML += "<div class=\"movieMainPage small-9 small-centered column\"><img src=\"images/"+data[i].movies_thumb+"\"><div class=\"movieMainPageDetails\"><h3>"+data[i].movies_title+"</h3><h4>"+data[i].movies_year+"</h4><a class=\""+data[i].movies_id+"\">Details</a></div></div>";
  }

  var details = document.querySelectorAll(".movieMainPageDetails a");

  for(i=0 ; i<details.length ; i++){
    details[i].addEventListener("click",detailsClicked,false);
  }
}

function populateContent(data){
  //console.log(data[1]);

  for(i=0 ; i<data.length ; i++){
    movieSelection.innerHTML += "<div class=\"movieMainPage small-9 small-centered column\"><img src=\"images/"+data[i].movies_thumb+"\"><div class=\"movieMainPageDetails\"><h3>"+data[i].movies_title+"</h3><h4>"+data[i].movies_year+"</h4><a class=\""+data[i].movies_id+"\">Details</a></div></div>";
  }

  var details = document.querySelectorAll(".movieMainPageDetails a");

  for(i=0 ; i<details.length ; i++){
    details[i].addEventListener("click",detailsClicked,false);
  }
}


input.onkeypress = function(e) {
  var input_val = this.value;

   $.ajax
    ({
      url: 'admin/phpscripts/ajaxQuerySearch.php',
      type: 'GET',
      data: { filter: input_val }
    })

    .done(function(data)
    {
      //console.log(data);

      if(data && data !=="null")
      {
        data = JSON.parse(data)

        populateSearch(data);
      }
      else
      {
        console.log('something is wrong with your query!');
      }
    })

    .fail(function(ajaxCall, error, status)
    {
      console.log('error');
      console.dir(ajaxCall);
    });

    function populateSearch(data){
      //console.log(data[0]);

      autocomplete_results.innerHTML = "";

      if (input_val.length > 0) {
        for(i=0 ; i<data.length ; i++){
          autocomplete_results.innerHTML += '<li><a href=\"javascript:void(0)\" class=\"'+data[i].movies_id+'\">' + data[i].movies_title + '</a></li>';
        }

        autocomplete_results.style.display = 'block';

      } else {
        autocomplete_results.innerHTML = '';
      }

      var searchLink = document.querySelectorAll("#autocomplete-results li a");

      for(i=0 ; i<searchLink.length ; i++){
        searchLink[i].addEventListener("click",searchLinkClicked,false);
      }
}
}

function searchLinkClicked(e){

  //console.log('searchLinkClicked');

  var linkClass = e.currentTarget.classList;
  //console.log(linkClass[0]);

  $.ajax
    ({
      url: 'admin/phpscripts/ajaxQueryIndividual.php',
      type: 'GET',
      data: { filter: linkClass[0] }
    })

    .done(function(data)
    {
      //console.log(data);

      if(data && data !=="null")
      {
        data = JSON.parse(data)

        searchLinkPopulate(data);
      }
      else
      {
        console.log('something is wrong with your query!');
      }
    })

    .fail(function(ajaxCall, error, status)
    {
      console.log('error');
      console.dir(ajaxCall);
    });

    function searchLinkPopulate(data){
      //console.log(data[0]);

      document.querySelector("#autocomplete-input").value = "";

      movieSelection.innerHTML = "";

      movieSelection.innerHTML += "<div class=\"movieMainPage small-9 small-centered column\"><img src=\"images/"+data[0].movies_thumb+"\"><div class=\"movieMainPageDetails\"><h3>"+data[0].movies_title+"</h3><h4>"+data[0].movies_year+"</h4><a class=\""+data[0].movies_id+"\" >Details</a></div></div>";
      

      var details = document.querySelectorAll(".movieMainPageDetails a");

  for(i=0 ; i<details.length ; i++){
    details[i].addEventListener("click",detailsClicked,false);
  }
    }
}
			
function closeSearch(e){
  //console.log(e);

  var specifiedElement = document.querySelector("#autocomplete-input");

  var isClickInside = specifiedElement.contains(e.target)

 if (!isClickInside) {
    //the click was outside the specifiedElement, do something
    //console.log('not searchbar!');

    autocomplete_results.innerHTML = "";
  }
}

function detailsClicked(e){
  var linkClass = e.currentTarget.classList;
  console.log(linkClass[0]);
$.ajax
    ({
      url: 'admin/phpscripts/ajaxQueryIndividual.php',
      type: 'GET',
      data: { filter: linkClass[0] }
    })

    .done(function(data)
    {
      //console.log(data);

      if(data && data !=="null")
      {
        data = JSON.parse(data)

        detailsPopulate(data);
      }
      else
      {
        console.log('something is wrong with your query!');
      }
    })

    .fail(function(ajaxCall, error, status)
    {
      console.log('error');
      console.dir(ajaxCall);
    });

    $.ajax
    ({
      url: 'admin/phpscripts/ajaxQueryIndividualComment.php',
      type: 'GET',
      data: { filter: linkClass[0] }
    })

    .done(function(data)
    {
      //console.log(data);

      if(data && data !=="null")
      {
        data = JSON.parse(data)

        detailsPopulateComment(data);
      }
      else
      {
        console.log('something is wrong with your query!');
      }
    })

    .fail(function(ajaxCall, error, status)
    {
      console.log('error');
      console.dir(ajaxCall);
    });

}

function detailsPopulate(data){

  movieSelection.innerHTML = "";

      movieSelection.innerHTML += "<div class=\"movieDetailPage small-9 small-centered column\"><h3>"+data[0].movies_title+"</h3><h4>"+data[0].movies_year+"</h4>"+data[0].movies_trailer+"<h4>CAST</h4></div>";


      for(i=0 ; i<data.length ; i++){
      movieSelection.innerHTML += "<div class=\"movieDetailPage small-5 small-offset-1 end column\"><p>"+data[i].cast_fname+" "+data[i].cast_lname+"</p></div";
      }

      movieSelection.innerHTML += "<div class=\"movieDetailPage small-9 small-centered column\"><h4>DESCRIPTION</h4><p>"+data[0].movies_storyline+"</p><h4>COMMENTS</h4></div>";

}

function detailsPopulateComment(data){
    for(i=0 ; i<data.length ; i++){
      movieSelection.innerHTML += "<div class=\"movieDetailComment small-9 small-centered column\"><h4>"+data[i].comment_fname+" "+data[i].comment_lname+"</h4><p>"+data[i].comment_content+"</p></div>";
      }

      movieSelection.innerHTML += "<input type=\"text\" name=\"firstName\" placeholder=\"First Name\" class=\"small-9 small-centered column\"><input type=\"text\" name=\"lastName\" placeholder=\"Last Name\" class=\"small-9 small-centered column\"><input type=\"text\" name=\"comment\" placeholder=\"Place a comment here\" class=\"small-9 small-centered column\"><button class=\"button comment\">Submit</button>";

      var submitButton = document.querySelector(".button");
}

for(i=0 ; i<filterLinks.length ; i++){
  filterLinks[i].addEventListener("click",filterLinksClicked,false);
}

window.addEventListener("click",closeSearch,false);

})();