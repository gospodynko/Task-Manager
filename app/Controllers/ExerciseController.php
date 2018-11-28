<?php
namespace App\Controllers;


use NumberFormatter;

class ExerciseController extends Controller
{

    public function fibonacci()
    {
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
                    $rc =$rc * $a + $rd * $c;
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
    }

    function morph($n, $f1, $f2, $f5) {
        $n = abs(intval($n)) % 100;
        if ($n>10 && $n<20) return $f5;
        $n = $n % 10;
        if ($n>1 && $n<5) return $f2;
        if ($n==1) return $f1;
        return $f5;
    }
    public function get_price()
    {
        $num = $this->request->getParam('number');
        $lang = $this->request->getParam('lang');
        if($lang == 'ru'){
        $nul='ноль';
        $ten=array(
            array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
            array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
        );
        $a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
        $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
        $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
        $unit=array( // Units
            array('копейка' ,'копейки' ,'копеек',  1),
            array('рубль'   ,'рубля'   ,'рублей'    ,0),
            array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
            array('миллион' ,'миллиона','миллионов' ,0),
            array('миллиард','милиарда','миллиардов',0),
        );
        }
        else{
            $nul='нуль';
            $ten=array(
                array('','один','два','три','чотири','пʼять','шість','сім', 'вісім','девʼять'),
                array('','один','два','три','чотири','пʼять','шість','сім', 'вісім','девʼять'),
            );
            $a20=array('десять','одинадцять','дванадцять','тринадцять','четырнадцать' ,'пʼятнадцять','шістнадцять','сімнадцять','вісімнадцять','девʼятнадцять');
            $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
            $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
            $unit=array( // Units
                array('копейка' ,'копейки' ,'копеек',  1),
                array('рубль'   ,'рубля'   ,'рублей'    ,0),
                array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
                array('миллион' ,'миллиона','миллионов' ,0),
                array('миллиард','милиарда','миллиардов',0),
            );
        }
        //
        list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub)>0) {
            foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
                if (!intval($v)) continue;
                $uk = sizeof($unit)-$uk-1; // unit key
                $gender = $unit[$uk][3];
                list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
                else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                // units without rub & kop
                if ($uk>1) $out[]= $this->morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
            } //foreach
        }
        else $out[] = $nul;
        $out[] = $this->morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
        $out[] = $kop.' '.$this->morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
        var_dump(trim(preg_replace('/ {2,}/', ' ', join(' ',$out))));
        return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
    }



function num2text_ua() {
    $num = $this->request->getParam('number');
$num = trim(preg_replace('~s+~s', '', $num)); // отсекаем пробелы
if (preg_match("/, /", $num)) {
$num = preg_replace("/, /", ".", $num);
} // преобразует запятую
if (is_numeric($num)) {
    $num = round($num, 2); // Округляем до сотых (копеек)
    $num_arr = explode(".", $num);
    $amount = $num_arr[0]; // переназначаем для удобства, $amount - сумма без копеек
    if (strlen($amount) <= 3) {
        $res = implode(" ", $this->Triada($amount)) . $this->Currency($amount);
    } else {
        $amount1 = $amount;
        while (strlen($amount1) >= 3) {
            $temp_arr[] = substr($amount1, -3); // засовываем в массив по 3
            $amount1 = substr($amount1, 0, -3); // уменьшаем массив на 3 с конца
        }
        if ($amount1 != '') {
            $temp_arr[] = $amount1;
        } // добавляем то, что не добавилось по 3
        $i = 0;
        foreach ($temp_arr as $temp_var) { // переводим числа в буквы по 3 в массиве
            $i++;
            if ($i == 3 || $i == 4) { // миллионы и миллиарды мужского рода, а больше миллирда вам все равно не заплатят
                if ($temp_var == '000') {

                    $temp_res[] = '';
                } else {
                    $temp_res[] = implode(" ", $this->Triada($temp_var, 1)) . $this->GetNum($i, $temp_var);
                } # if
            } else {
                if ($temp_var == '000') {
                    $temp_res[] = '';
                } else {
                    $temp_res[] = implode(" ", $this->Triada($temp_var)) . $this->GetNum($i, $temp_var);
                } # if
            } # else
        } # foreach
        $temp_res = array_reverse($temp_res); // разворачиваем массив
        $res = implode(" ", $temp_res) . $this->Currency($amount);
    }
    if (!isset($num_arr[1]) || $num_arr[1] == '') {
        $num_arr[1] = '00';
    }
    var_dump($res);
    return $res . ', ' . $num_arr[1] . ' коп.';
}
}

function Triada($amount, $case = null) {
    global $_1_2, $_1_19, $des, $hang; // объявляем массив переменных
    $count = strlen($amount);
    for ($i = 0; $i < $count; $i++) {
        $triada[] = substr($amount, $i, 1);
    }
    $triada = array_reverse($triada); // разворачиваем массив для операций
    if (isset($triada[1]) && $triada[1] == 1) { // строго для 10-19
        $triada[0] = $triada[1] . $triada[0]; // Объединяем в единицы
        $triada[1] = ''; // убиваем десятки
        $triada[0] = $_1_19[$triada[0]]; // присваиваем
    } else { // а дальше по обычной схеме
        if (isset($case) && ($triada[0] == 1 || $triada[0] == 2)) { // если требуется м.р.
            $triada[0] = $_1_2[$triada[0]]; // единицы, массив мужского рода
        } else {
            if ($triada[0] != 0) {
                $triada[0] = $_1_19[$triada[0]];
            } else {
                $triada[0] = '';
            } // единицы
        } # if
        if (isset($triada[1]) && $triada[1] != 0) {
            $triada[1] = $des[$triada[1]];
        } else {
            $triada[1] = '';
        } // десятки
    }
    if (isset($triada[2]) && $triada[2] != 0) {
        $triada[2] = $hang[$triada[2]];
    } else {
        $triada[2] = '';
    } // сотни
    $triada = array_reverse($triada); // разворачиваем массив для вывода
    foreach ($triada as $triada_) { // вычищаем массив от пустых значений
        if ($triada_ != '') {
            $triada1[] = $triada_;
        }
    } # foreach
    return $triada1;
}

function Currency($amount) {
    global $namecurr; // объявляем масиив переменных
    $last2 = substr($amount, -2); // последние 2 цифры
    $last1 = substr($amount, -1); // последняя 1 цифра
    $last3 = substr($amount, -3); //последние 3 цифры
    if ((strlen($amount) != 1 && substr($last2, 0, 1) == 1) || $last1 >= 5 || $last3 == '000') {
        $curr = $namecurr[3];
    } // от 10 до 19
    else if ($last1 == 1) {
        $curr = $namecurr[1];
    } // для 1-цы
    else {
        $curr = $namecurr[2];
    } // все остальные 2, 3, 4
    return ' ' . $curr;
}

function GetNum($level, $amount)
{
    global $nametho, $namemil, $namemrd; // объявляем массив переменных
    if ($level == 1) {
        $num_arr = null;
    } else if ($level == 2) {
        $num_arr = $nametho;
    } else if ($level == 3) {
        $num_arr = $namemil;
    } else if ($level == 4) {
        $num_arr = $namemrd;
    } else {
        $num_arr = null;
    }
    if (isset($num_arr)) {
        $last2 = substr($amount, -2);
        $last1 = substr($amount, -1);
        if ((strlen($amount) != 1 && substr($last2, 0, 1) == 1) || $last1 >= 5) {
            $res_num = $num_arr[3];
        } // 10-19
        else if ($last1 == 1) {
            $res_num = $num_arr[1];
        } // для 1-цы
        else {
            $res_num = $num_arr[2];
        } // все остальные 2, 3, 4
        return ' ' . $res_num;
    } # if
}

}
$_1_2[1] = "один";
$_1_2[2] = "два";

$_1_19[1] = "одна";
$_1_19[2] = "дві";
$_1_19[3] = "три";
$_1_19[4] = "чотири";
$_1_19[5] = "п'ять";
$_1_19[6] = "шість";
$_1_19[7] = "сім";
$_1_19[8] = "вісім";
$_1_19[9] = "дев'ять";
$_1_19[10] = "десять";

$_1_19[11] = "одинадцять";
$_1_19[12] = "дванадцять";
$_1_19[13] = "тринадцять";
$_1_19[14] = "чотирнадцять";
$_1_19[15] = "п'ятнадцять";
$_1_19[16] = "шістнадцять";
$_1_19[17] = "сімнадцять";
$_1_19[18] = "вісімнадцять";
$_1_19[19] = "дев'ятнадцять";


$des[2] = "двадцять";
$des[3] = "тридцять";
$des[4] = "сорок";
$des[5] = "п'ятдесят";
$des[6] = "шістдесят";
$des[7] = "сімдесят";
$des[8] = "вісімдесят";
$des[9] = "дев'яносто";

$hang[1] = "сто";
$hang[2] = "двісті";
$hang[3] = "триста";
$hang[4] = "чотириста";
$hang[5] = "п'ятсот";
$hang[6] = "шістсот";
$hang[7] = "сімсот";
$hang[8] = "вісімсот";
$hang[9] = "дев'ятьсот";

$namecurr[1] = "гривня"; // 1
$namecurr[2] = "гривні"; // 2, 3, 4
$namecurr[3] = "гривень"; // >4

$nametho[1] = "тисяча"; // 1
$nametho[2] = "тисячі"; // 2, 3, 4
$nametho[3] = "тисяч"; // >4

$namemil[1] = "мільйон"; // 1
$namemil[2] = "мільйона"; // 2, 3, 4
$namemil[3] = "мільйонів"; // >4

$namemrd[1] = "мільярд"; // 1
$namemrd[2] = "мільярда"; // 2, 3, 4
$namemrd[3] = "мільярдів"; // >4