<?php

interface IOrder
{
    public function addProduct(Product $p);

    public function removeProduct($pid);

    public function getCartDetails();

    public function getProductFromCart($pid);

    public function productCount();

    public function getCartPrice();
}

class ProductNotFoundException extends Exception
{}

class Product
{
    public $pid;

    public $pname;

    public $qty;

    public $price;

    public function __construct($pid, $pname, $qty, $price)
    {
        $this->pid = $pid;
        $this->pname = $pname;
        $this->qty = $qty;
        $this->price = $price;
    }

    public function getPid()
    {
        return $this->pid;
    }

    public function setPid($pid)
    {
        $this->pid = $pid;
    }

    public function getQty()
    {
        return $this->qty;
    }

    public function setQty($qty)
    {
        $this->qty = $qty;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getPname()
    {
        return $this->pname;
    }

    public function setPname($pname)
    {
        $this->pname = $pname;
    }


}

class Order implements IOrder, IteratorAggregate
{
    public $uid;

    private $list = array();

    public function __construct($uid)
    {
        $this->uid = $uid;
        $this->list = array();
    }

    public function addProduct(Product $p)
    {
        if(isset($this->list[$p->getPid()])) {
            $p1 = $this->list[$p->getPid()];
            $p1->setPrice($p1->getPrice() + $p->getPrice());
            $p1->setQty($p1->getQty() + $p->getQty());
            return true;
        }
        $this->list[$p->getPid()] = $p;
        return false;
    }

    public function removeProduct($pid)
    {
        if(isset($this->list[(int)$pid])) {
            unset($this->list[$pid]);
            return true;
        } else {
            throw new ProductNotFoundException("Product with ID $pid not found.");
        }
    }

    public function getIterator()
    {
        return new ArrayIterator($this->list);
    }

    public function getCartDetails()
    {
        return $this->list;
    }

    public function getProductFromCart($pid)
    {
        if(isset($this->list[$pid])) {
            return $this->list[$pid];
        } else {
            throw new ProductNotFoundException("Product with ID $pid not found.");
        }
    }

    public function productCount()
    {
        return count($this->list);
    }

    public function getCartPrice()
    {
        $price = 0.0;

        $iterator = $this->getIterator();

        while($iterator->valid()) {
            $price += $iterator->current()->getPrice();

            $iterator->next();
        }
        return $price;
    }

}


$order = new Order("Robert");
$order->addProduct(new Product("p101", "Soap", 12, 120));
$order->addProduct(new Product("p102", "Oil", 4, 140));
$order->addProduct(new Product("p103", "Carrot", 3, 90));

printf("Total sum: %s", $order->getCartPrice());
printf("%s", "<br>");
printf("Number of Product: %s", $order->productCount());

$iterator = $order->getIterator();

printf("%s", "<br>");
printf("%s", "<br>");
printf("%s", "Product details:");


while($iterator->valid()) {

    printf("%s", "<br>");
    printf("Product Pid: %s", $iterator->current()->getPid());
    printf("%s", "<br>");
    printf("Product Pname: %s", $iterator->current()->getPname());
    printf("%s", "<br>");
    printf("Product Qty: %d", $iterator->current()->getQty());
    printf("%s", "<br>");
    printf("Product Price: %.2f", $iterator->current()->getPrice());
    printf("%s", "<br>");

    $iterator->next();
}
