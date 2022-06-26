var obj;

//Jquery Validation
$.validator.setDefaults({
   errorClass: 'invalid-feedback',
   highlight: function (element) {
      $(element)
         .addClass('is-invalid');
   },
   unhighlight: function (element) {
      $(element)
         .removeClass('is-invalid')
      //.addClass('is-valid')
   },
});


$.validator.addMethod('validDates',
   function (value, element, param) {
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



$(document).ready(function () {

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


   $("#myButton").click(function () {


      if ($("#addExpenseForm").valid()) {
         if(window.isLimit){
            $('#expense_date').text('Data: ' + $('#inputExpenseDate').val());
            $('#expense_payment').text('Typ płatności: ' + $('#selectExpensePayment option:selected').text());
            $('#expense_amount').text('Kwota: ' + $('#inputExpenseAmount').val() + ' zł');
            $('#exampleModalLabel').text('Kategoria: ' + $('#selectExpenseCategory option:selected').text());
            renderUpdatedLimitInModal();
            $('#exampleModal').modal('show');
         } else {
            document.getElementById("addExpenseForm").submit();
         }
      }
   });
});

const renderUpdatedLimitInModal = () => {
  
     if(window.isLimit){
      let expenseAmount = document.getElementById('inputExpenseAmount').value;
      let updatedLimit = -(Number(expenseAmount) - Number(window.value));
      if (updatedLimit < 0){
         document.getElementById('myLimit').style.color = "red";
         document.getElementById('myLimit').textContent = 'Uwaga: limit po transakcji: ' + updatedLimit.toFixed(2) + ' zł';
      } else {
         document.getElementById('myLimit').style.color = "green";
         document.getElementById('myLimit').textContent = 'Limit po transakcji: ' + updatedLimit.toFixed(2) + ' zł';
      }
     } else {
      document.getElementById('myLimit').textContent = '';
     }
}

document.addEventListener("DOMContentLoaded", function () {
   document.getElementById('inputExpenseDate').valueAsDate = new Date();
   renderLimit(getSelectedCategoryID());
});

const getSelectedCategoryID = () => {
   let select = document.getElementById("selectExpenseCategory");
   let value = select.options[select.selectedIndex].value;
   if (value) {
      let id = value.split("|");
      return id[0];
   }
}

const checkLimit = async (categoryID) => {
   let url = `/api/limit/check/${categoryID}`;
   try {
      let res = await fetch(url);
      return await res.json();
   } catch (error) {
      console.log(error);
   }
}

const getCategoryLimit = async (categoryID) => {
   let url = `/api/limit/${categoryID}`;
   try {
      let res = await fetch(url);
      return await res.json();
   } catch (error) {
      console.log(error);
   }
}

const getSelectedMonthExpenses = async (categoryID) => {
   let date = document.getElementById("inputExpenseDate").value;
   let url = `api/expenses/${categoryID}?date=${date}`;
   try {
      let res = await fetch(url);
      return await res.json();
   } catch (error) {
      console.log(error);
   }
}

const calculateLimit = async (categoryID) => {
   let categoryExpenses = await getSelectedMonthExpenses(categoryID);
   let limit = await getCategoryLimit(categoryID);
   let calculateLimit = (limit[0].control_limit - categoryExpenses[0].category_sum).toFixed(2);
   return calculateLimit;
}


const renderLimit = async (categoryID) => {
   let isLimit = await checkLimit(categoryID);
   window.isLimit = false;
   if (isLimit.is_limit) {
      let calculatedLimit = await calculateLimit(categoryID);
      let limitDescritpion = document.getElementById("limit-description");
      let limitAmount = document.getElementById("limitAmount");
      window.value = calculatedLimit;
      window.isLimit = true;
      limitAmount = calculatedLimit;
      if (calculatedLimit < 0) {
         limitDescritpion.style.color = "red";
         limitDescritpion.textContent = 'Limit: ' + limitAmount 
         + ' zł';
      } else {
         limitDescritpion.style.color = "dimgrey";
         limitDescritpion.textContent = 'Limit: ' + limitAmount + ' zł';
      }
   } else document.getElementById("limit-description").textContent = '';
}


document.getElementById("selectExpenseCategory").onchange = function () {
   renderLimit(getSelectedCategoryID());
}






