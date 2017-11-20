var intTextBox=0;

//FUNCTION TO ADD TEXT BOX ELEMENT
function addElement(){
	intTextBox = intTextBox + 1;
	var contentID = document.getElementById("content");
	var newTBDiv = document.createElement("div");
	newTBDiv.setAttribute("id","strText"+intTextBox);
	newTBDiv.innerHTML = "<input type='text' id='graded_item_type' name='additional_graded_item_type[]' value=\"New Item Type\" placeholder=\"New Item Type\">&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' id='portion_of_grade' name='portion_of_grade[]'>%<br>";
	contentID.appendChild(newTBDiv);
}

//FUNCTION TO REMOVE TEXT BOX ELEMENT
function removeElement()
{
	if(intTextBox != 0){
		var contentID = document.getElementById("content");
		contentID.removeChild(document.getElementById("strText"+intTextBox));
		intTextBox = intTextBox-1;
	}
}