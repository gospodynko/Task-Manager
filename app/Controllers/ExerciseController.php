<?php
namespace App\Controllers;


use NumberFormatter;

class ExerciseController extends Controller {

    public function fibonacci()
    {
        $n = $this->request->getParam('n');

        $digit = intval($n / 4) + 5;
        $result = '';
        $a1 = [];
        $a2 = [];
        $a3 = [];
        $a1[0] = 1;
        $a2[0] = 1;
        for($j = 2; $j < $n; $j++)
        {
            for($i = 0; $i < $digit; $i++)
            {
                $a1[$i] = isset($a1[$i]) ? $a1[$i] : 0;
                $a2[$i] = isset($a2[$i]) ? $a2[$i] : 0;
                $b = intval(($a1[$i] + $a2[$i])/10);
                $a3[$i] = $a1[$i] + $a2[$i] - $b * 10;
                isset($a1[$i + 1]) ? $a1[$i + 1] += $b : $a1[$i + 1] = $b;
            }
            for($i = 0; $i < $digit; $i++)
            {
                $a1[$i] = $a2[$i];
                $a2[$i] = $a3[$i];
                $a3[$i] = 0;
            }
        }
        $flg = false;
        for($i = count($a2) - 1; $i >= 0; $i--)
        {
            if($a2[$i] >= 1) $flg = true;
            if($flg) $result .= $a2[$i];
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
