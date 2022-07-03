

const getCategoryName = (value) =>{
   return fetchCategoryName = (value.split("|"))[1];
}

const getCategoryID = () => {
   let select = document.getElementById("selectedExpenseCategory");
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
   let url = `/api/limit/GET/${categoryID}`;
   try {
      let res = await fetch(url);
      return await res.json();
   } catch (error) {
      console.log(error);
   }
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

document.getElementById("expenseAddLimitButton").addEventListener("click", editLimit);
document.getElementById("flexSwitchCheckChecked").addEventListener("click", switchCheckBox);
document.getElementById("submitLimitCategory").addEventListener("click", setLimit);



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
      if(limitState.checked){
         let setLimit = await turnOnLimit(getCategoryID());
         let setAmount = await setLimitAmount(getCategoryID()); 
         $('#limitModal').modal('hide');
      } else {
         let setLimit = await turnOffLimit(getCategoryID());
         $('#limitModal').modal('hide');
      }
   }
}

async function editLimit() {

   document.getElementById('category').textContent = getCategoryName(document.getElementById('selectedExpenseCategory').value);
   let editCategoryState = document.getElementById('editCategoryLimit');
   let isLimit = await checkLimit(getCategoryID());
   if (isLimit.is_limit){
     
      let limitAmount = await getCategoryLimit(getCategoryID());
   
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






