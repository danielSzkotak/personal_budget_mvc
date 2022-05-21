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
   
        if(isset($_POST["submitCategory"])){


            $category = new Profile_model($_POST);

            if($category->categoryType == 'income'){
                $category->updateIncomeCategoryName();
            } elseif ($category->categoryType == 'expense'){
                $category->updateExpenseCategoryName();
            } elseif ($category->categoryType == 'payment'){
                $category->updatePaymentCategoryName();
            } else{
                exit;
            }
            
            $incomeCat = Categories::getIncomeCategories(Auth::getUser()->id);
            $expenseCat = Categories::getExpenseCategories(Auth::getUser()->id);
            $paymentCat = Categories::getExpensePayment(Auth::getUser()->id);

        
            View::renderTemplate('Profile/profile.html', [
                'income_cat' => $incomeCat,
                'expense_cat' => $expenseCat,
                'payment_cat' => $paymentCat,
                'category_name' =>$category->categoryName
            ]);

        }
    }

    public function deleteCategoryAction()
    {
   
        if(isset($_POST["submitDeleteCategory"])){

            $category = new Profile_model($_POST);

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
   
        if(isset($_POST["submitAddCategory"])){

            $category = new Profile_model($_POST);

            if($category->categoryType == 'income'){
                $category->addIncomeCategory();
            } elseif ($category->categoryType == 'expense'){
                $category->addExpenseCategory();
            } elseif ($category->categoryType == 'payment'){
                $category->addPaymentCategory();
            } else {
                exit;
            }
            
            $incomeCat = Categories::getIncomeCategories(Auth::getUser()->id);
            $expenseCat = Categories::getExpenseCategories(Auth::getUser()->id);
            $paymentCat = Categories::getExpensePayment(Auth::getUser()->id);

        
            View::renderTemplate('Profile/profile.html', [
                'income_cat' => $incomeCat,
                'expense_cat' => $expenseCat,
                'payment_cat' => $paymentCat,
                'category_name' => $category->newCategoryName
            ]);

        }
    }

}
