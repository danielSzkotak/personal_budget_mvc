
//Eye password

const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#inputPassword');

if(togglePassword){
  togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('fa-eye-slash');
    });
}                
  
//---end-----



//Bootstrap validation
(function () {
   'use strict'
   // Fetch all the forms we want to apply custom Bootstrap validation styles to
   var forms = document.querySelectorAll('.needs-validation')
 
   // Loop over them and prevent submission
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
 })()
 //------end---------


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

function showBalance(){

    var startDate = document.getElementById("startDate1");
    var endDate = document.getElementById("endDate1");

    wrongDates.style.display = "grid"; 

      if(startDate.value == "" && endDate.value == ""){
        document.getElementById("wrongDates").innerHTML = "Pola z datmi nie mogą być puste";
        startDate.style.border = "2px solid red";
        endDate.style.border = "2px solid red";
    } else if (startDate.value == "") {
        document.getElementById("wrongDates").innerHTML = "Pole z pierwszą datą nie może być puste";
        startDate.style.border = "2px solid red";
        endDate.style.border = "2px solid #8db856";
    } else if (endDate.value == "") {
        document.getElementById("wrongDates").innerHTML = "Pole z drugą datą nie może być puste";
        startDate.style.border = "2px solid #8db856";
        endDate.style.border = "2px solid red";
    } else if((startDate.value > endDate.value) && (startDate.value != "" || endDate.value != "")) {
        startDate.style.border = "2px solid red";
        document.getElementById("wrongDates").innerHTML = "Pierwsza data nie może być większa od drugiej";    
    }     
       document.getElementById("selectedPeriodParagraph").innerHTML = "Bilans od " + reversedStartDate + " do " + reversedEndDate;
  
}



