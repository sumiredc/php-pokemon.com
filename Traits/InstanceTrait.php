<?php

trait InstanceTrait
{
    /**
    * インスタンス化関数
    * @param string $class_name
    * @return object
    */
    protected function getInstance($class_name)
    {
        // 存在チェックをして読み込み
        if(class_exists($class_name)){
            return new $class_name();
        }else{
            false;
        }
    }

}
