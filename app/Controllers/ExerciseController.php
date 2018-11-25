<?php
namespace App\Controllers;

use App\Engine\Storage;
use App\Engine\Validator;
use NumberFormatter;

class ExerciseController extends Controller {

    public function fibonacci()
    {
        $n = $this->request->getParam('n');

        $result = [1, 1];

        for($i = 2; $i <= $n; $i++ ) {
            $result[] = $result[$i-1] + $result[$i-2];
        }
        return $this->response->json($result);
    }

    public function get_price()
    {
        $numbers = $this->request->getParam('number');
        $lang = $this->request->getParam('lang');
        $f = new NumberFormatter("$lang", NumberFormatter::SPELLOUT);
         return $this->response->json($f->format($numbers));
    }



}
