<?php

namespace BASE2;

class Test
{
    public string $company_name;
    public string $hp;
    public string $mp;

    public function __construct(string $company_name, int $hp, int $mp)
    {
        $this->company_name = $company_name;
        $this->address = $address;
        $this->category = $category;
    }

    public function detail()
    {
        return "この会社:".$this->company_name."です\n";
    }

    public function getName():string
    {
        return $this->company_name;
    }

    public function setName(string $company_name):void
    {
        $this->company_name = $company_name;
    }
}
