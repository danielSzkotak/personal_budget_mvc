

function clearInputs(){
  var forms = document.querySelectorAll('.needs-validation');
  Array.prototype.slice.call(forms)
  .forEach(function (form) {
    form.addEventListener('submit', function (event) {
     
      if (!form.checkValidity()) {
           
        event.preventDefault()
        event.stopPropagation()   
      }
      form.classList.add('was-validated')
    }, false)
  })
}


function clearInputs(){
  let listOfInputs = document.querySelectorAll('input[type="number"], input[type="date"], .select select');
  for(var i=0; i<listOfInputs.length; i++){
     listOfInputs[i].value = "";
  }
}

function showDateInputs(){
  const myValue = document.getElementById("selectedBalancePeriod").value;
 
  document.getElementById('startDate1').valueAsDate = new Date();
  document.getElementById('endDate1').valueAsDate = new Date();

  if(myValue == "non_standard_period"){
      document.getElementById("selectPeriodId").style.display = "grid";
      document.getElementById("startDate1").style.border = "1px solid #b3b3b3";
      document.getElementById("endDate1").style.border = "1px solid #b3b3b3";
  } else {
     if(document.getElementById("selectPeriodId").style.display == "grid"){
        document.getElementById("selectPeriodId").style.display = "none";
     }
  }
}
