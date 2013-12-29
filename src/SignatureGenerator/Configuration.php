<?php


namespace SignatureGenerator;


/**
 * Class Configuration
 * You may edit the return values of these functions to customise
 * the application to your needs.
 *
 * @package SignatureGenerator
 * @author lol768
 */
class Configuration {

    /**
     * @return array The possible colours.
     */
    public static function getColors() {
        return array(
            array(26, 188, 156),
            array(46, 204, 113),
            array(52, 152, 219),
            array(155, 89, 182),
            array(52, 73, 94),
            array(22, 160, 133),
            array(39, 174, 96),
            array(41, 128, 185),
            array(142, 68, 173),
            array(44, 62, 80),
            array(241, 196, 15),
            array(230, 126, 34),
            array(231, 76, 60),
            array(149, 165, 166),
            array(243, 156, 18),
            array(211, 84, 0),
            array(192, 57, 43),
            array(127, 140, 141)
        );
    }

    /**
     * @return Color RGB color for the background.
     */
    public static function getRandomColor() {
        //As per http://stackoverflow.com/a/10482105?, this will not work if your PHP ver is < 5.4
        //If you find it fails, follow https://gist.github.com/lol768/70f314be0290cce03b17
        $color = self::getColors()[array_rand(self::getColors(), 1)];
        $color = new Color($color[0], $color[1], $color[2]);
        return $color;
    }

    /**
     * @return Color RGB color for the text.
     */
    public static function getForegroundColor() {
        $color = new Color(255, 255, 255);
        return $color;
    }


    /**
     * @return string The path to the font to use.
     */
    public static function getFontPath() {
        $cwd = getcwd();
        return $cwd . DIRECTORY_SEPARATOR . "resources" . DIRECTORY_SEPARATOR . "fonts" . DIRECTORY_SEPARATOR . "Ubuntu-M.ttf";
    }

    /**
     * @return int The image width.
     */
    public static function getImageWidth() {
        return 700;
    }

    /**
     * @return int The image height.
     */
    public static function getImageHeight() {
        return 100;
    }

    public static function getWatermark() {
        return "Hosted by Jade";
    }

    public static function getWatermarkSize() {
        return 8;
    }

    public static function getWatermarkPaddingX() {
        return 5;
    }

    public static function getWatermarkPaddingY() {
        return 0;
    }

    public static function getBaseUrl() {
        return "http://127.0.0.1/gen/";
    }

    public static function getMaxFiles() {
        return 1000;
    }

} 
