<?php

// サニタイズ
class Sanitize
{

    /**
    * @var array
    */
    private $post = [];

    /**
    * @return void
    */
    public function __construct()
    {
        $this->post = $this->sanitize($_POST);
    }

    /**
    * @return array
    */
    public function sanitize($array)
    {
        $post = [];
        foreach($array ?? [] as $key => $data){
            if(preg_match('/^__/', $key)){
                // 接頭語にアンダーバーが２つついていればサニタイズ不要
                continue;
            }
            if(is_array($data)){
                // 配列ならループ
                $post[htmlspecialchars($key)] = $this->sanitize($data);
            }else{
                $post[htmlspecialchars($key)] = htmlspecialchars($data);
            }

        }
        return $post;
    }

    /**
    * @return array
    */
    public function getPost()
    {
        return $this->post;
    }

}
