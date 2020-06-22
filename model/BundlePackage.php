<?php
class BundlePackage
{
    private $packageType;
    private $packageName;
    private $caterersAvailableStatus;
    private $decorFloristsAvailableStatus;
    private $makeupAndHairAvailableStatus;
    private $weddingCardsAvailableStatus;
    private $mehandiAvailableStatus;
    private $cakesAvailableStatus;
    private $djAvailableStatus;
    private $photographersAvailableStatus;
    private $entertainmentAvailableStatus;
    private $price;
    private $transportCost;
    private $description;
    private $availableStatus;
    private $vendorName;
    private $rating;

    public function getPackageType()
    {
        return $this->packageType;
    }
    public function setPackageType($packageType)
    {
        $this->packageType = $packageType;

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
    public function getCaterersAvailableStatus()
    {
        return $this->caterersAvailableStatus;
    }
    public function setCaterersAvailableStatus($caterersAvailableStatus)
    {
        $this->caterersAvailableStatus = $caterersAvailableStatus;

        return $this;
    }
    public function getDecorFloristsAvailableStatus()
    {
        return $this->decorFloristsAvailableStatus;
    }
    public function setDecorFloristsAvailableStatus($decorFloristsAvailableStatus)
    {
        $this->decorFloristsAvailableStatus = $decorFloristsAvailableStatus;

        return $this;
    }
    public function getMakeupAndHairAvailableStatus()
    {
        return $this->makeupAndHairAvailableStatus;
    }
    public function setMakeupAndHairAvailableStatus($makeupAndHairAvailableStatus)
    {
        $this->makeupAndHairAvailableStatus = $makeupAndHairAvailableStatus;

        return $this;
    }
    public function getWeddingCardsAvailableStatus()
    {
        return $this->weddingCardsAvailableStatus;
    }
    public function setWeddingCardsAvailableStatus($weddingCardsAvailableStatus)
    {
        $this->weddingCardsAvailableStatus = $weddingCardsAvailableStatus;

        return $this;
    }
    public function getMehandiAvailableStatus()
    {
        return $this->mehandiAvailableStatus;
    }
    public function setMehandiAvailableStatus($mehandiAvailableStatus)
    {
        $this->mehandiAvailableStatus = $mehandiAvailableStatus;

        return $this;
    }
    public function getCakesAvailableStatus()
    {
        return $this->cakesAvailableStatus;
    }
    public function setCakesAvailableStatus($cakesAvailableStatus)
    {
        $this->cakesAvailableStatus = $cakesAvailableStatus;

        return $this;
    }
    public function getDjAvailableStatus()
    {
        return $this->djAvailableStatus;
    }
    public function setDjAvailableStatus($djAvailableStatus)
    {
        $this->djAvailableStatus = $djAvailableStatus;

        return $this;
    }
    public function getPhotographersAvailableStatus()
    {
        return $this->photographersAvailableStatus;
    }
    public function setPhotographersAvailableStatus($photographersAvailableStatus)
    {
        $this->photographersAvailableStatus = $photographersAvailableStatus;

        return $this;
    }
    public function getEntertainmentAvailableStatus()
    {
        return $this->entertainmentAvailableStatus;
    }
    public function setEntertainmentAvailableStatus($entertainmentAvailableStatus)
    {
        $this->entertainmentAvailableStatus = $entertainmentAvailableStatus;

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
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;

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
    public function getVendorName()
    {
        return $this->vendorName;
    }
    public function setVendorName($vendorName)
    {
        $this->vendorName = $vendorName;

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
    public function BundlePackage(
        $packageType,
        $packageName,
        $caterersAvailableStatus,
        $decorFloristsAvailableStatus,
        $makeupAndHairAvailableStatus,
        $weddingCardsAvailableStatus,
        $mehandiAvailableStatus,
        $cakesAvailableStatus,
        $djAvailableStatus,
        $photographersAvailableStatus,
        $entertainmentAvailableStatus,
        $price,
        $transportCost,
        $description,
        $availableStatus,
        $vendorName,
        $rating
    ) {
        $this->packageType = $packageType;
        $this->packageName = $packageName;
        $this->caterersAvailableStatus = $caterersAvailableStatus;
        $this->decorFloristsAvailableStatus = $decorFloristsAvailableStatus;
        $this->makeupAndHairAvailableStatus = $makeupAndHairAvailableStatus;
        $this->weddingCardsAvailableStatus = $weddingCardsAvailableStatus;
        $this->mehandiAvailableStatus = $mehandiAvailableStatus;
        $this->cakesAvailableStatus = $cakesAvailableStatus;
        $this->djAvailableStatus = $djAvailableStatus;
        $this->photographersAvailableStatus = $photographersAvailableStatus;
        $this->entertainmentAvailableStatus = $entertainmentAvailableStatus;
        $this->price = $price;
        $this->transportCost = $transportCost;
        $this->description = $description;
        $this->availableStatus = $availableStatus;
        $this->vendorName = $vendorName;
        $this->rating = $rating;
    }
}
