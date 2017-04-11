// JavaScript Document
//console.log("Works")
var navi = document.querySelectorAll(".navigation");
var fill = document.querySelector("#fill");

var array = [
	{content: "Hello"},
	{content: "Hi"},
	{content: "hey"}
];

function yay(e){
	var target = document.querySelector("#"+e.target.id);
	console.log(target);
	 
	if(target.id==='one'){
		fill.innerHTML = array[0].content;
		
	}if(target.id==='two'){
		fill.innerHTML = array[1].content;
}if(target.id==='three'){
	fill.innerHTML = array[2].content;
}
}

for(var i = 0; i<navi.length; i++){
	navi[i].addEventListener("click", yay, false);
}