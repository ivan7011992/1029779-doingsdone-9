<?php


class Student
{
    protected $name;
    protected $age;

    public function __construct($name, $age)
    {
        $this->name = $name;
        $this->age = $age;
        echo '2';
    }


    public function getName()
    {
        return $this->name;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function compareAge($other) {
        if($this->age > $other->age) {
            return 1;
        }
        return -1;
    }

    public function saveToDb() {

    }


}