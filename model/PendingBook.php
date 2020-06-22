<?php
class PendingBook
{
    private $transaction;
    private $halfPaid;
    private $fullPaid;


    public function getTransaction()
    {
        return $this->transaction;
    }
    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;
        return $this;
    }



    public function getHalfPaid()
    {
        return $this->halfPaid;
    }
    public function setHalfPaid($halfPaid)
    {
        $this->halfPaid = $halfPaid;

        return $this;
    }

    public function getFullPaid()
    {
        return $this->fullPaid;
    }
    public function setFullPaid($fullPaid)
    {
        $this->fullPaid = $fullPaid;

        return $this;
    }



    public function PendingBook()
    { }
}
