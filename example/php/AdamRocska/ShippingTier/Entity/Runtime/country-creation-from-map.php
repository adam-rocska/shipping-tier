<?php

use AdamRocska\ShippingTier\Entity\Runtime\Country;

include_once "../../../../../../vendor/autoload.php";

$countries = Country::createFromMap([
                                        "HU" => "Hungary",
                                        "DE" => "Germany",
                                        "US" => "United States"
                                    ]);

foreach ($countries as $country) {
    echo "ISO Code      : " . $country->getIsoCode() . "\n";
    echo "Label         : " . $country->getLabel() . "\n";
    echo "Equals itself : "
         . ($country->equals($country) ? "yes" : "no")
         . "\n";
    foreach ($countries as $comparedCountry) {
        echo "    Equals " . $comparedCountry->getIsoCode() . " : "
             . ($country->equals($comparedCountry) ? "yes" : "no")
             . "\n";
    }
    echo "——————————————|\n";
}