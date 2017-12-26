<?php
namespace app\packages\Extend\Test;
use Yii;
class TestRelyBind extends \Codeception\TestCase\Test
{
    protected function _before()
    {
        parent::_before();
    }

    /**
     * 打桩
     * @param $className string 类名
     * @param $methodMap array 类的方法集合 ['方法名1' => '返回值', '方法名2' => '回调函数', .....]
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function stub($className, $methodMap = [])
    {
        if (empty($methodMap)) {
            return null;
        }
        $obj = $this->createMock($className);
        foreach ($methodMap as $methodName => $returnValue) {
            if (is_callable($returnValue)) {
                $obj->expects($this->any())
                    ->method($methodName)
                    ->will($this->returnCallback($returnValue));
            } else {
                $obj->expects($this->any())
                    ->method($methodName)
                    ->will($this->returnValue($returnValue));
            }
        }

        return $obj;
    }
    /*
   * 私有方法测试
   */
    public function _method($obj,$method,$param=[]){
        $classMethod = new \ReflectionMethod($obj,$method);
        $classMethod->setAccessible(true);
        return $classMethod->invokeArgs($obj,$param);
    }
}
