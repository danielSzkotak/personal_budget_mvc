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
      .then((data) => console.log(data))
      .catch((e) =>{console.log(e)});
};

const checkCategory = () => {
   getLimitForCategory(getSelectedCategoryID());
};

document.getElementById("selectExpenseCategory").addEventListener("change", checkCategory);

