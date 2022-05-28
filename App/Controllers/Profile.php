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

    public function addIncomeCategoryAction()
    {
   
        if(isset($_POST["submitAddIncomeCategory"])){

            $category = new Profile_model($_POST);
            $category->addIncomeCategory();

            $incomeCat = Categories::getIncomeCategories(Auth::getUser()->id);
            $expenseCat = Categories::getExpenseCategories(Auth::getUser()->id);
            $paymentCat = Categories::getExpensePayment(Auth::getUser()->id);

            View::renderTemplate('Profile/profile.html', [
                'income_cat' => $incomeCat,
                'expense_cat' => $expenseCat,
                'payment_cat' => $paymentCat,
                'category_name' => $category->newIncomeCategoryName
            ]);

        }
    }

    public function addExpenseCategoryAction()
    {
   
        if(isset($_POST["submitAddExpenseCategory"])){

            $category = new Profile_model($_POST);
            $category->addExpenseCategory();

            $incomeCat = Categories::getIncomeCategories(Auth::getUser()->id);
            $expenseCat = Categories::getExpenseCategories(Auth::getUser()->id);
            $paymentCat = Categories::getExpensePayment(Auth::getUser()->id);

            View::renderTemplate('Profile/profile.html', [
                'income_cat' => $incomeCat,
                'expense_cat' => $expenseCat,
                'payment_cat' => $paymentCat,
                'category_name' => $category->newExpenseCategoryName
            ]);

        }
    }

    public function addPaymentCategoryAction()
    {
   
        if(isset($_POST["submitAddPaymentCategory"])){

            $category = new Profile_model($_POST);
            $category->addPaymentCategory();

            $incomeCat = Categories::getIncomeCategories(Auth::getUser()->id);
            $expenseCat = Categories::getExpenseCategories(Auth::getUser()->id);
            $paymentCat = Categories::getExpensePayment(Auth::getUser()->id);

            View::renderTemplate('Profile/profile.html', [
                'income_cat' => $incomeCat,
                'expense_cat' => $expenseCat,
                'payment_cat' => $paymentCat,
                'category_name' => $category->newPaymentCategoryName
            ]);

        }
    }

     /**
     * Validate if new category name is available (AJAX).
     *
     * @return void
     */
    public function validateIncomeCategoryAction()
    {
        
        $is_valid = !Categories::incomeCategoryExists($_GET['newIncomeCategoryName']);
        
        header('Content-Type: application/json');
        echo json_encode($is_valid);
    }

    public function validateExpenseCategoryAction()
    {
        $is_valid = !Categories::expenseCategoryExists($_GET['newExpenseCategoryName']);

        header('Content-Type: application/json');
        echo json_encode($is_valid);
    }

    public function validatePaymentCategoryAction()
    {
        $is_valid = !Categories::paymentCategoryExists($_GET['newPaymentCategoryName']);

        header('Content-Type: application/json');
        echo json_encode($is_valid);
    }

    public function validateCategoryAction()
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


}
