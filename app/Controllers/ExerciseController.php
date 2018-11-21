<?php
namespace App\Controllers;

use App\Engine\Storage;
use App\Engine\Validator;
class ExerciseController extends Controller {

    public function fibonacci()
    {
        $number = $this->request->getParam('n');
        if ($number == 0)
            return 0;
        else if ($number == 1)
            return 1;

        // Recursive Call to get the upcoming numbers
        else
            return (Fibonacci($number-1) +
                Fibonacci($number-2));
    }



}
