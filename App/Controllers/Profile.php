<?php

namespace App\Controllers;

use App\Auth;
use \Core\View;
use \App\Models\Categories;
use App\Models\Profile_model;
use App\Serviceable;


/**
 * Login controller
 *
 * PHP version 7.0
 */
class Profile extends Authenticated {

    /**
     * Show the addIncome page
     *
     * @return void
     */
    public function showProfileAction()
    {
        
        $incomeCat = Categories::getIncomeCategories(Auth::getUser()->id);
        $expenseCat = Categories::getExpenseCategories(Auth::getUser()->id);
        //$_SESSION['income_cat'] = $incomeCat;
        //$_SESSION['expense_cat'] = $expenseCat;
     
        View::renderTemplate('Profile/profile.html',[
            'income_cat' => $incomeCat,
            'expense_cat' => $expenseCat
        ]);
    }

    /**
     * edit Category Name
     *
     * @return void
     */
    public function editCategoryNameAction()
    {
   
        if(isset($_POST["submitCategory"])){


            $category = new Profile_model($_POST);

            if($category->categoryType == 'income'){
                $category->updateIncomeCategoryName();
            } elseif ($category->categoryType == 'expense'){
                $category->updateExpenseCategoryName();
            } else {
                exit;
            }
            
            $incomeCat = Categories::getIncomeCategories(Auth::getUser()->id);
            $expenseCat = Categories::getExpenseCategories(Auth::getUser()->id);

        
            View::renderTemplate('Profile/profile.html', [
                'income_cat' => $incomeCat,
                'expense_cat' => $expenseCat,
                'category_name' =>$category->categoryName
            ]);

        }
    }

    public function deleteCategoryAction()
    {
   
        if(isset($_POST["submitDeleteCategory"])){

            $category = new Profile_model($_POST);

            if($category->categoryType == 'income'){
                $category->deleteIncomeCategory();
            } elseif ($category->categoryType == 'expense'){
                $category->deleteExpenseCategory();
            } else {
                exit;
            }
            
            $incomeCat = Categories::getIncomeCategories(Auth::getUser()->id);
            $expenseCat = Categories::getExpenseCategories(Auth::getUser()->id);

        
            View::renderTemplate('Profile/profile.html', [
                'income_cat' => $incomeCat,
                'expense_cat' => $expenseCat
            ]);

        }
    }

    public function addCategoryAction()
    {
   
        if(isset($_POST["submitAddCategory"])){

            $category = new Profile_model($_POST);

            if($category->categoryType == 'income'){
                $category->addIncomeCategory();
            } elseif ($category->categoryType == 'expense'){
                $category->addExpenseCategory();
            } else {
                exit;
            }
            
            $incomeCat = Categories::getIncomeCategories(Auth::getUser()->id);
            $expenseCat = Categories::getExpenseCategories(Auth::getUser()->id);

        
            View::renderTemplate('Profile/profile.html', [
                'income_cat' => $incomeCat,
                'expense_cat' => $expenseCat,
                'category_name' => $category->newCategoryName
            ]);

        }
    }

}
