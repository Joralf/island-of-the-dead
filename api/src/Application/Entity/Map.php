<?php

namespace Application\Entity;

class Map
{
    /**
     * @var Field[]
     */
    protected $fields = [];

    /**
     * Map constructor. Create a rectangle with fields of the given size.
     * @param int $xSize
     * @param int $ySize
     */
    public function __construct($xSize, $ySize)
    {
        for ($x = 1; $x <= $xSize; $x++) {
            for ($y = 1; $y <= $ySize; $y++) {
                $this->fields[] = new Field($x, $y);
            }
        }
    }

    /**
     * @return Field[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Get the surrounding fields of a center coordinate.
     * The center field will also be returned.
     * The border defines how far from the center
     * @param int $xAxis
     * @param int $yAxis
     * @param int $border
     * @return Field[]
     */
    public function getSurroundingFields($xAxis, $yAxis, $border)
    {
        $result = [];
        foreach ($this->fields as $field) {
            if ($field->getXAxis() >= $xAxis - $border
                && $field->getXAxis() <= $xAxis + $border
                && $field->getYAxis() >= $yAxis - $border
                && $field->getYAxis() <= $yAxis + $border
            ) {
                $result[] = $field;
            }
        }
        return $result;
    }

    /**
     * @param double $lat
     * @param double $lon
     * @return Field
     */
    public function getFieldByLatLon($lat, $lon)
    {
        $latDiff = null;
        $lonDiff = null;
        $selectedField = null;
        foreach ($this->getFields() as $field) {
            if (is_null($latDiff)
                && is_null($lonDiff)
            ) {
                $latDiff = $lat - $field->getLatitude();
                $lonDiff = $lon - $field->getLongitude();
                $selectedField = $field;
                continue;
            }
            $currentLatDiff = $lat - $field->getLatitude();
            $currentLonDiff = $lon - $field->getLongitude();
            if (abs($currentLatDiff) <= abs($latDiff)
                && abs($currentLonDiff) <= abs($lonDiff)
            ) {
                $latDiff = $currentLatDiff;
                $lonDiff = $currentLonDiff;
                $selectedField = $field;
            }
        }
        return $selectedField;
    }
}
