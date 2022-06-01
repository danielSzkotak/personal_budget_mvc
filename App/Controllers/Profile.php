<?php

namespace App\Controllers;

use App\Auth;
use \Core\View;
use \App\Models\Categories;
use App\Models\Profile_model;
use App\Models\User;
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
        $paymentCat = Categories::getExpensePayment(Auth::getUser()->id);
     
        View::renderTemplate('Profile/profile.html',[
            'income_cat' => $incomeCat,
            'expense_cat' => $expenseCat,
            'payment_cat' => $paymentCat
        ]);
    }

    /**
     * edit Category Name
     *
     * @return void
     */
    public function editCategoryNameAction()
    {
   
            $category = new Profile_model($_POST);

            if($category){

                if($category->categoryType == 'income'){
                    $category->updateIncomeCategoryName();
                }
                if ($category->categoryType == 'expense'){
                    $category->updateExpenseCategoryName();
                }
                if ($category->categoryType == 'payment'){
                    $category->updatePaymentCategoryName();
                } 
                
                $incomeCat = Categories::getIncomeCategories(Auth::getUser()->id);
                $expenseCat = Categories::getExpenseCategories(Auth::getUser()->id);
                $paymentCat = Categories::getExpensePayment(Auth::getUser()->id);
    
            
                View::renderTemplate('Profile/profile.html', [
                    'income_cat' => $incomeCat,
                    'expense_cat' => $expenseCat,
                    'payment_cat' => $paymentCat,
                    'category_name' => $category->categoryName
                ]);
            }

            
        
    }

    public function deleteCategoryAction()
    {
   
            $category = new Profile_model($_POST);

            if($category){

                if ($category->categoryType == 'income') {

                    if (Categories::getIncomeIndelibleCategoryID() != $category->categoryID) {
                       
                        if (($category->isIncomeCategoryEmpty())) {
    
                            $category->deleteEmptyIncomeCategory();
                        } else {
    
                            $category->transportIncomesFromDeletedCategory();
                            $category->deleteEmptyIncomeCategory();
                        }
                    }
                                
                } elseif ($category->categoryType == 'expense'){
    
                    if (Categories::getExpenseIndelibleCategoryID() != $category->categoryID) {
    
                        if (($category->isExpenseCategoryEmpty())) {
    
                            $category->deleteEmptyExpenseCategory();
                        } else {
    
                            $category->transportExpensesFromDeletedCategory();
                            $category->deleteEmptyExpenseCategory();
                        }
                    }
                } elseif ($category->categoryType == 'payment'){
    
                    if (Categories::getPaymentIndelibleCategoryID() != $category->categoryID) {
    
                        if (($category->isPaymentCategoryEmpty())) {
    
                            $category->deleteEmptyPaymentCategory();
                        } else {
                            $category->transportPaymentFromDeletedCategory();
                            $category->deleteEmptyPaymentCategory();
                        }
                    }
                }
                
                $incomeCat = Categories::getIncomeCategories(Auth::getUser()->id);
                $expenseCat = Categories::getExpenseCategories(Auth::getUser()->id);
                $paymentCat = Categories::getExpensePayment(Auth::getUser()->id);
    
                View::renderTemplate('Profile/profile.html', [
                    'income_cat' => $incomeCat,
                    'expense_cat' => $expenseCat,
                    'payment_cat' => $paymentCat
                ]);
            }  
        
    }

    public function addCategoryAction()
    {

            $category = new Profile_model($_POST);

            if($category){

                if($category->categoryToAddType == 'income'){
                    $category->addIncomeCategory();
                }
                if ($category->categoryToAddType == 'expense'){
                    $category->addExpenseCategory();
                }
                if ($category->categoryToAddType == 'payment'){
                    $category->addPaymentCategory();
                } 
    
                $incomeCat = Categories::getIncomeCategories(Auth::getUser()->id);
                $expenseCat = Categories::getExpenseCategories(Auth::getUser()->id);
                $paymentCat = Categories::getExpensePayment(Auth::getUser()->id);
    
                View::renderTemplate('Profile/profile.html', [
                    'income_cat' => $incomeCat,
                    'expense_cat' => $expenseCat,
                    'payment_cat' => $paymentCat,
                    'category_name' => $category->categoryToAddName
                ]);
    
            }
    }


    public function validateCategoryEditAction()
    { 

        if ($_GET['categoryType'] == 'income'){
            $is_valid = !Categories::incomeCategoryExists($_GET['categoryName']);
        }
        if ($_GET['categoryType'] == 'expense'){
            $is_valid = !Categories::expenseCategoryExists($_GET['categoryName']);
        }
        if ($_GET['categoryType'] == 'payment'){
            $is_valid = !Categories::paymentCategoryExists($_GET['categoryName']);
        }
        
        header('Content-Type: application/json');
        echo json_encode($is_valid);
    }

    public function validateCategoryAddAction()
    { 

        if ($_GET['categoryToAddType'] == 'income'){
            $is_valid = !Categories::incomeCategoryExists($_GET['categoryToAddName']);
        }
        if ($_GET['categoryToAddType'] == 'expense'){
            $is_valid = !Categories::expenseCategoryExists($_GET['categoryToAddName']);
        }
        if ($_GET['categoryToAddType'] == 'payment'){
            $is_valid = !Categories::paymentCategoryExists($_GET['categoryToAddName']);
        }
        
        header('Content-Type: application/json');
        echo json_encode($is_valid);
    }


}
