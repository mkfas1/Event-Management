<?php
class Rating
{
    private $package_name;
    private $vendor_name;
    private $customer_name;
    private $rating;

    public function getPackage_name()
    {
        return $this->package_name;
    }

    public function setPackage_name($package_name)
    {
        $this->package_name = $package_name;

        return $this;
    }

    public function getVendor_name()
    {
        return $this->vendor_name;
    }

    public function setVendor_name($vendor_name)
    {
        $this->vendor_name = $vendor_name;

        return $this;
    }

    public function getCustomer_name()
    {
        return $this->customer_name;
    }

    public function setCustomer_name($customer_name)
    {
        $this->customer_name = $customer_name;

        return $this;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }
    public function Rating($package_name, $vendor_name, $customer_name, $rating)
    {
        $this->package_name = $package_name;
        $this->vendor_name = $vendor_name;
        $this->customer_name = $customer_name;
        $this->rating = $rating;
    }
}
