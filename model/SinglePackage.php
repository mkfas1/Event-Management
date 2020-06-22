
<?php
class SinglePackage
{
    private $category;
    private $packageName;
    private $vendorName;
    private $price;
    private $transportCost;
    private $availableStatus;
    private $description;
    private $image;
    private $rating;

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }
    public function getPackageName()
    {
        return $this->packageName;
    }
    public function setPackageName($packageName)
    {
        $this->packageName = $packageName;

        return $this;
    }
    public function getVendorName()
    {
        return $this->vendorName;
    }
    public function setVendorName($vendorName)
    {
        $this->vendorName = $vendorName;

        return $this;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }
    public function getTransportCost()
    {
        return $this->transportCost;
    }
    public function setTransportCost($transportCost)
    {
        $this->transportCost = $transportCost;

        return $this;
    }
    public function getAvailableStatus()
    {
        return $this->availableStatus;
    }
    public function setAvailableStatus($availableStatus)
    {
        $this->availableStatus = $availableStatus;

        return $this;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function setImage($image)
    {
        $this->image = $image;

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
    public function SinglePackage($category, $packageName, $vendorName, $price, $transportCost, $availableStatus, $description, $image, $rating)
    {
        $this->category = $category;
        $this->packageName = $packageName;
        $this->vendorName = $vendorName;
        $this->price = $price;
        $this->transportCost = $transportCost;
        $this->availableStatus = $availableStatus;
        $this->description = $description;
        $this->image = $image;
        $this->rating = $rating;
    }
}
