document.addEventListener("DOMContentLoaded", function (event) {
   document.getElementById('inputExpenseDate').valueAsDate = new Date();
});

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

const getLimitForCategory = (id) => {
   
   fetch(`/api/limit/${id}`)
      .then((response) => response.json())
      .then((data) => showLimit(data[0].control_limit))
      .catch((e) =>{console.log(e)});
};

const showLimit =(limit) =>{
   if (limit > 0) document.getElementById("myLimit").textContent = 'Limit kategorii: ' + limit + ' zł';
   else document.getElementById("myLimit").textContent = '';
}

const checkCategory = () => {
   getLimitForCategory(getSelectedCategoryID());
};


