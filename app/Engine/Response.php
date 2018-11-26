<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 29.10.18
 * Time: 15:26
 */

namespace App\Engine;


class Response
{
    /**
     * @var string
     */
    public $content;

    /**
     * @var string
     */
    public $template_path;

    /**
     * @var Request
     */
    public $request;


    /**
     * Response constructor.
     */
    public function __construct()
    {
        $this->template_path = dirname(__FILE__) . '/../Template/';
        $this->request = Storage::get('Request');
    }
    
    public function json($data)
    {
        $node = getenv('NODE');
        $data = [
            'content' => $data,
            'node' => $node
        ];
        $this->content = json_encode($data);
        return $this;
    }

    public function render()
    {
        if (!json_decode($this->content)) {
            header('Content-Type: text/html');
            echo $this->content;
        } else {
            header('Content-Type: application/json');
            echo $this->content;
        }
    }

}