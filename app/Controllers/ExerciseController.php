<?php
namespace App\Controllers;

use App\Models\User;

class ExerciseController extends Controller
{

    public function fibonacci()
    {

        $headers = apache_request_headers();

        $token = $headers['token'];
        if($token) {
            $user = User::where([['token', '=', $token]]);
            if ($user) {
                $n = $this->request->getParam('n');
                $a = 1;
                $b = 1;
                $c = 1;
                $rc = 0;
                $d = 0;
                $rd = 1;

                while ($n) {
                    if ($n & 1)    // Если степень нечетная
                    {
                        // Умножаем вектор R на матрицу A
                        $tc = $rc;
                        $rc = $rc * $a + $rd * $c;
                        $rd = $tc * $b + $rd * $d;
                    }

                    // Умножаем матрицу A на саму себя
                    $ta = $a;
                    $tb = $b;
                    $tc = $c;
                    $a = $a * $a + $b * $c;
                    $b = $ta * $b + $b * $d;
                    $c = $c * $ta + $d * $c;
                    $d = $tc * $tb + $d * $d;

                    $n >>= 1;  // Уменьшаем степень вдвое

                }
                return $this->response->json($rc);
            } else {
                return $this->response->json(401);
            }
        }else{
             return $this->response->json(401);
        }
    }




    public function get_price()
    {
        $headers = apache_request_headers();

        $token = $headers['token'];
        if($token) {
            $user = User::where([['token', '=', $token]]);
            if ($user) {
        $num = $this->request->getParam('number');
        $lang = $this->request->getParam('lang');
        if ($lang == 'ru') {
            $nul = 'ноль';
            $ten = array(
                array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
                array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
            );
            $a20 = array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать');
            $tens = array(2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто');
            $hundred = array('', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот');
            $unit = array( // Units
                array('копейка', 'копейки', 'копеек', 1),
                array('рубль', 'рубля', 'рублей', 0),
                array('тысяча', 'тысячи', 'тысяч', 1),
                array('миллион', 'миллиона', 'миллионов', 0),
                array('миллиард', 'милиарда', 'миллиардов', 0),
            );
        } else {
            $nul = 'нуль';
            $ten = array(
                array('', 'один', 'два', 'три', 'чотири', 'пʼять', 'шість', 'сім', 'вісім', 'девʼять'),
                array('', 'один', 'два', 'три', 'чотири', 'пʼять', 'шість', 'сім', 'вісім', 'девʼять'),
            );
            $a20 = array('десять', 'одинадцять', 'дванадцять', 'тринадцять', 'чотирнадцять', 'пʼятнадцять', 'шістнадцять', 'сімнадцять', 'вісімнадцять', 'девʼятнадцять');
            $tens = array(2 => 'двадцять', 'тридцять', 'сорок', 'п’ятдесят', 'шістдесят', 'сімдесят', 'вісімдесят', 'дев’яносто');
            $hundred = array('', 'сто', 'двісті', 'чотириста', 'п’ятсот', 'шістсот', 'сімсот', 'вісімсот', 'дев’ятсот');
            $unit = array( // Units
                array('копійка', 'копійки', 'копійок', 1),
                array('гривня', 'гривні', 'гривень', 0),
                array('тисяча', 'тисячі', 'тисяч', 1),
                array('мільйон', 'мільйона', 'мільйонів', 0),
                array('мільярд', 'мільярда', 'мільярдів', 0),
            );
        }
        //
        list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub) > 0) {
            foreach (str_split($rub, 3) as $uk => $v) { // by 3 symbols
                if (!intval($v)) continue;
                $uk = sizeof($unit) - $uk - 1; // unit key
                $gender = $unit[$uk][3];
                list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));

                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2 > 1) $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3]; # 20-99
                else $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                // units without rub & kop
                if ($uk > 1) $out[] = $this->morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
            } //foreach
        } else $out[] = $nul;
        $out[] = $this->morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // rub
        $out[] = $kop . ' ' . $this->morph($kop, $unit[0][0], $unit[0][1], $unit[0][2]); // kop
        var_dump(trim(preg_replace('/ {2,}/', ' ', join(' ', $out))));
        return trim(preg_replace('/ {2,}/', ' ', join(' ', $out)));
            } else {
                return $this->response->json(401);
            }
        }else{
            return $this->response->json(401);
        }
    }
    public function morph($n, $f1, $f2, $f5)
    {
        $n = abs(intval($n)) % 100;
        if ($n > 10 && $n < 20) return $f5;
        $n = $n % 10;
        if ($n > 1 && $n < 5) return $f2;
        if ($n == 1) return $f1;
        return $f5;
    }

}