<?php
// リクエスト（送信データの格納オブジェクト）
class Request
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
    private function sanitize($array): array
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
    * 送信データの取得（ドット記法対応）
    * @param dot_key:string
    * @return mixed
    */
    public function request($dot_key)
    {
        $keys = explode('.', $dot_key);
        $values = $this->post;
        foreach($keys ?? [] as $key){
            $values = $values[$key] ?? null;
            // valuesが配列でなくなれば処理終了
            if(!is_array($values)){
                break;
            }
        }
        return $values;
    }

}
