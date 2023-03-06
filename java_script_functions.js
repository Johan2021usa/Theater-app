function actualArrayGra(actualArray, positionGrid, parameters){
    
    console.log(positionGrid);
    console.log(parameters);
    let chairStatus = ["L","L","L","L","L","L","L","L","L","L","L","L","L","L","L","L","L","L","L","L","L","L","L","L","L"];
    
    sessionStorage.setItem('sessionArray', JSON.stringify(chairStatus));

    let chairArray =  JSON.parse(localStorage.getItem('sessionArray'));
    
    chairArray[positionGrid] = parameters;
    
    localStorage.setItem('sessionArray', JSON.stringify(chairArray));
    
    let finalArray = JSON.parse(localStorage.getItem('sessionArray'));

    console.log(finalArray);
    phpFetchArray(finalArray);
    
    return finalArray;
}

function phpFetchArray(finalArray){
    fetch('index.php',{
        //Method type
        method: 'POST',
        //Body content
        body: JSON.stringify({finalArray: finalArray}),
        headers: {"Content-type": "application/json; charset=UTF-8"}
    })
    .then(response => console.log(response))
    .catch(error => console.error(error));
    //.then(data => console.log(data))
}










/*var avoidUpdate = document.querySelector('.form_orientation');
avoidUpdate.addEventListener('submit', 
    function(objectObtained){
        //objectObtained.preventDefault();
    }      
);*/