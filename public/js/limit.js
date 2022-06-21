

 //Jquery Validation
$.validator.setDefaults({
errorClass: 'invalid-feedback',
highlight: function(element){
   $(element)
       .addClass('is-invalid');
},
unhighlight: function(element){
   $(element)
       .removeClass('is-invalid')
       .addClass('is-valid')
},
});


$.validator.addMethod('validDates',
function(value, element, param){
   if (value != '') {
       if (value < '2000-01-01') {
           return false;
       }
   }
   return true;
},
'Data musi być większa od 01-01-2000'

);

jQuery.validator.addMethod("validAmount", function (value, element) {
     return this.optional(element) || /^\d{0,4}(\,||.\d{0,2})?$/i.test(value);
}, "Wprowadź poprawną datę, max 2 miejsca po przecinku");



$(document).ready(function(){

$('#addExpenseForm').validate({
   rules: {
      expenseAmount: { 
       required: true,
       validAmount: true 
       },
      expenseDate: {
         required: true,
         validDates: true
      }                    
   },
   messages: {
      expenseAmount: {
           required: '<span class="text-danger">To pole jest wymagane</span>'
       },
      expenseDate: {
      required: '<span class="text-danger">To pole jest wymagane</span>' 
      }
   }
});           

$("#myButton").click(function(){  // capture the click
     if($("#addExpenseForm").valid()){   // test for validity
         // do stuff if form is valid
         $('#expense_date').text('Data: ' +  $('#inputExpenseDate').val());
         $('#expense_payment').text('Typ płatności: ' +  $('#selectExpensePayment option:selected').text());
         $('#expense_amount').text('Kwota: ' +  $('#inputExpenseAmount').val() + ' zł');
         $('#exampleModalLabel').text('Kategoria: ' +  $('#selectExpenseCategory option:selected').text());
         
         checkCategory();

         $('#exampleModal').modal('show');
     } else {
         // do stuff if form is not valid
     }
 });

// document.getElementById("myButton").onclick = function() {
//    if($("#addExpenseForm").valid()){
 
//    }
// };

});


const getSelectedCategoryID = () => {
   let select = document.getElementById("selectExpenseCategory");
   let value = select.options[select.selectedIndex].value;
   if(value){
      let id = value.split("|");
      return id[0];
   }
}



   // const getLimitForCategory = (id) => {
   
   //    fetch(`/api/limit/${id}`)
   //       .then((response) => response.json())
   //       //.then((data) => data[0].control_limit)
   //       .then((data) => console.log(data))
   //       .catch((e) =>{console.log(e)});
   // };

//    async function fetchCategoryLimit(id) {
//       let response = await fetch(`/api/limit/${id}`);
//       if (response.status === 200) {
//          let data = await response.json();
//          console.log(data);
//      }
//   }

  async function getCategoryLimit(id) {
   let url = `/api/limit/${id}`;
   try {
       let res = await fetch(url);
       return await res.json();
   } catch (error) {
       console.log(error);
   }
}

async function showLimit(id) {
   let limit = await getCategoryLimit(id);
   limit.forEach(limit => {
     let categoryLimit = `${limit.control_limit}`;
     document.getElementById("limit-description").textContent = 'Limit kategorii: ' + categoryLimit + ' zł'; 
   });
}


const showLimitInModal =(limit) =>{
   if (limit > 0) document.getElementById("myLimit").textContent = 'Pozostały limit kategorii: ' + limit + ' zł';
   else document.getElementById("myLimit").textContent = '';
}

document.getElementById("selectExpenseCategory").onchange = function(){
   showLimit(getSelectedCategoryID());
} 

document.addEventListener("DOMContentLoaded", function () {
   document.getElementById('inputExpenseDate').valueAsDate = new Date();
   showLimit(getSelectedCategoryID());
});





