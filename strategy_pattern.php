<?php

interface PaymentStrategy
{
    public function pay($amount);
}

class CreditCartStrategy implements PaymentStrategy
{
    private $name;

    private $cardNumber;

    private $cvv;

    private $dateOfExpiry;

    public function __construct($name, $cardNumber, $cvv, $dateOfExpiry)
    {
        $this->name = $name;
        $this->cardNumber = $cardNumber;
        $this->cvv = $cvv;
        $this->dateOfExpiry = $dateOfExpiry;
    }

    public function pay($amount)
    {
        printf("%d paid with Credit cart.<br>", $amount);
    }
}

class PaypalStrategy implements PaymentStrategy
{
    private $emailId;

    private $password;

    public function __construct($emailId, $password)
    {
        $this->emailId = $emailId;
        $this->password = $password;
    }

    public function pay($amount)
    {
        printf("%d paid using Paypal.<br>", $amount);
    }
}

class Item
{
    private $upcCode;

    private $price;

    function __construct($upcCode, $price)
    {
        $this->upcCode = $upcCode;
        $this->price = $price;
    }

    public function getUpcCode()
    {
        return $this->upcCode;
    }

    public function getPrice()
    {
        return $this->price;
    }
}

class ShoppingCart implements IteratorAggregate
{
    private $items = array();

    function __construct()
    {
        $this->items = array();
    }

    public function addItem(Item $item)
    {
        $this->items[$item->getUpcCode()] = $item;
    }

    public function removeItem(Item $item)
    {
        unset($this->items[$item->getUpcCode()]);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    public function calculateTotal()
    {
        $sum = 0;

        $iterator = $this->getIterator();

        while($iterator->valid()) {
            $sum += $iterator->current()->getPrice();

            $iterator->next();
        }
        return $sum;
    }

    public function payment(PaymentStrategy $paymentMethod)
    {
        $amount = $this->calculateTotal();

        $paymentMethod->pay($amount);
    }
}



class ShoppingCartTest
{
    public function __construct()
    {
        $cart = new ShoppingCart();
        $cart->addItem(new Item("123",10));
        $cart->addItem(new Item("456",15));
        $cart->addItem(new Item("789",19));
        $cart->payment(new PaypalStrategy("kel.robert@gmail.com", "psw"));
        $cart->payment(new CreditCartStrategy("Robert", "12345678", "1457", "12/15"));
    }
}

new ShoppingCartTest();
