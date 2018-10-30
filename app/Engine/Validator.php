<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 30.10.18
 * Time: 10:01
 */

namespace App\Engine;


class Validator
{
    /**
     * @var array
     */
    public $rules;

    /**
     * @var array
     */
    public $data;

    /**
     * @var array
     */
    public $errors;

    /**
     * Validator constructor.
     */

    public function __construct(array $rules)
    {
        $this->request = Storage::get('Request');
        $this->data = $this->request->getPostParams();
        $this->rules = $rules;
        $this->errors = [];
    }

    public function check()
    {
        foreach ($this->rules as $key => $rules) {
            $rules_arr = explode('|', $rules);

            foreach ($rules_arr as $rule) {
                $tmp_rule = explode(':', $rule);
                switch ($tmp_rule[0]) {
                    case 'required':
                        if (!isset($this->data[$key]) || !$this->data[$key]) {
                            $this->errors = array_push_assoc($this->errors, $key, [$tmp_rule[0] => 'field ' . $key . ' required']);
                        }
                        break;
                    case 'string':
                        if (isset($this->data[$key]) && !is_string($this->data[$key])) {
                            $this->errors = array_push_assoc($this->errors, $key, [$tmp_rule[0] => 'field ' . $key . ' must be a string']);
                        }
                        break;
                    case 'integer':
                        if (isset($this->data[$key]) && !is_numeric($this->data[$key])) {
                            $this->errors = array_push_assoc($this->errors, $key, [$tmp_rule[0] => 'field ' . $key . ' must be a integer']);
                        }
                        break;
                    case 'min':
                        if (isset($this->data[$key]) && mb_strlen($this->data[$key]) < $tmp_rule[1]) {
                            $this->errors = array_push_assoc($this->errors, $key, [$tmp_rule[0] => 'field ' . $key . ' must be min ' . $tmp_rule[1] . ' length']);
                        }
                        break;
                    case 'max':
                        if (isset($this->data[$key]) && mb_strlen($this->data[$key]) > $tmp_rule[1]) {
                            $this->errors = array_push_assoc($this->errors, $key, [$tmp_rule[0] => 'field ' . $key . ' must be max ' . $tmp_rule[1] . ' length']);
                        }
                        break;
                }

            }
        }

        return $this;
    }

    public function errors() :array
    {
        return $this->errors;
    }
}