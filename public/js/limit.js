
const getCategoryName = (value) =>{
   return value.split("|")[1];
}

const getCategoryID = (v) => {
   let value = v.options[v.selectedIndex].value;
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
   let url = `/api/limit/GET/${categoryID}`;
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
   if (isLimit.is_limit == 1) {
      let calculatedLimit = await calculateLimit(categoryID);
      let limitDescritpion = document.getElementById("limit-description");
      let selectAmount = document.getElementById('inputExpenseAmount').value;
      let limitAmount = (calculatedLimit - selectAmount).toFixed(2);
      window.value = calculatedLimit;
      window.isLimit = true;
      if (limitAmount < 0) {
         limitDescritpion.style.color = "red";
         limitDescritpion.textContent = 'Pozostały limit: ' + limitAmount 
         + ' zł';
      } else {
         limitDescritpion.style.color = "dimgrey";
         limitDescritpion.textContent = 'Pozostały limit: ' + limitAmount + ' zł';
      }
   } else document.getElementById("limit-description").textContent = '';
}



const turnOnLimit = async (categoryID) => {
     
   let url = `/api/limit/turnOn/${categoryID}`;
   try {
      response = await fetch(url);
      
   } catch (error) {
      console.log(error);
   }
}

const turnOffLimit = async (categoryID) => {
     
   let url = `/api/limit/turnOff/${categoryID}`;
   try {
      response = await fetch(url);
   } catch (error) {
      console.log(error);
   }
}

const setLimitAmount = async (categoryID) => {

   let amount = document.getElementById("editCategoryLimit").value;
   let url = `/api/limit/setAmount/${categoryID}?amount=${amount}`;
   try {
      response = await fetch(url);
   } catch (error) {
      console.log(error);
   }
}


let editLimitButton = document.getElementById("expenseAddLimitButton");
if(editLimitButton) editLimitButton.addEventListener("click", editLimit);

let switchLimitButton = document.getElementById("flexSwitchCheckChecked");
if(switchLimitButton) switchLimitButton.addEventListener("click", switchCheckBox);

let saveLimitButton = document.getElementById("submitLimitCategory");
if(saveLimitButton) saveLimitButton.addEventListener("click", setLimit);

function switchCheckBox() {
   let switchState = document.getElementById('flexSwitchCheckChecked');
   let editCategoryState = document.getElementById('editCategoryLimit');

   if(switchState.checked) {
      editCategoryState.disabled = false; 
   }
   else {
      editCategoryState.disabled = true; 
     
   }
}

async function setLimit(){

   if ($("#categoryLimit").valid()) {
      let limitState = document.getElementById('flexSwitchCheckChecked');
      if(limitState.checked == true){
         let setLimit = await turnOnLimit(getCategoryID(document.getElementById("selectedExpenseCategory")));
         let setAmount = await setLimitAmount(getCategoryID(document.getElementById("selectedExpenseCategory"))); 
         $('#limitModal').modal('hide');
      } else {
         let setLimit = await turnOffLimit(getCategoryID(document.getElementById("selectedExpenseCategory")));
         $('#limitModal').modal('hide');
      }
   }
}

async function editLimit() {

   document.getElementById('category').textContent = getCategoryName(document.getElementById('selectedExpenseCategory').value);
   let editCategoryState = document.getElementById('editCategoryLimit');
   let isLimit = await checkLimit(getCategoryID(document.getElementById("selectedExpenseCategory")));
   if (isLimit.is_limit == 1){
     
      let limitAmount = await getCategoryLimit(getCategoryID(document.getElementById("selectedExpenseCategory")));
   
      editCategoryState.value = limitAmount[0].control_limit;
      document.getElementById('flexSwitchCheckChecked').checked = true;
      editCategoryState.disabled = false;
   } else {
      document.getElementById('flexSwitchCheckChecked').checked = false;
      editCategoryState.disabled = true;
      editCategoryState.value = '';
      $('#editCategoryLimit').removeClass('is-invalid');
   }
   $('#limitModal').modal('show');
}

let selectCategory = document.getElementById("selectExpenseCategory");

if (selectCategory) {
   selectCategory.onchange = function () {
      renderLimit(getCategoryID(selectCategory));
   }
}

let selectDate = document.getElementById("inputExpenseDate");

if (selectDate) {
   selectDate.onchange = function () {
      renderLimit(getCategoryID(selectCategory));
   }
}

let selectAmount = document.getElementById('inputExpenseAmount');

var invalidChars = [
   "-",
   "+",
   "e",
 ];

if (selectAmount) {
   selectAmount.onkeydown = function (e) {
      if (invalidChars.includes(e.key)) {
         e.preventDefault();
      }
      renderLimit(getCategoryID(selectCategory));

   }
   selectAmount.onchange = function () {
      renderLimit(getCategoryID(selectCategory));
   }
}

