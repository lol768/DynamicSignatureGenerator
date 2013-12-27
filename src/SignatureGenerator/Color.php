<?php


namespace SignatureGenerator;


class Color {

    private $red;
    private $green;
    private $blue;

    public function __construct($blue, $green, $red) {
        $this->blue = $blue;
        $this->green = $green;
        $this->red = $red;
    }

    /**
     * @return int Amount of blue
     */
    public function getBlue() {
        return $this->blue;
    }

    /**
     * @return int Amount of green
     */
    public function getGreen() {
        return $this->green;
    }

    /**
     * @return int Amount of red
     */
    public function getRed() {
        return $this->red;
    }


} 