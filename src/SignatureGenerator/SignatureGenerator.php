<?php
namespace SignatureGenerator;

/**
 * Class SignatureGenerator
 * Handles the actual generation of the images.
 *
 * @package SignatureGenerator
 * @author lol768, Hoolean
 */
class SignatureGenerator {

    /**
     * @var resource The current image context.
     */
    private $imageContext;

    /**
     * Function to create the image.
     */
    public function createImage($lines) {

        if (!count($lines) == 4) {
            throw new \InvalidArgumentException("Must supply 4 lines to paint.");
        }

        $image = imagecreate(Configuration::getImageWidth(), Configuration::getImageHeight());

        imagealphablending($image, true);
        imagesavealpha($image, true);
        if (function_exists("imageantialias")) {
            imageantialias($image, true);
        }

        $randomColor = Configuration::getRandomColor();
        $bg = imagecolorallocate($image, $randomColor->getRed(), $randomColor->getBlue(), $randomColor->getGreen());
        $foregroundColor = Configuration::getForegroundColor();
        $fg = imagecolorallocate($image, $foregroundColor->getRed(), $foregroundColor->getBlue(), $foregroundColor->getGreen());

        imagefill($image, 0, 0, $bg);

        //Draw $header
        //image, font size, angle, x, y, colour, font, text
        $fontPath = Configuration::getFontPath();
        imagettftext($image, 32, 0, 32, 64, $fg, $fontPath, $lines[0]);

        //gets the x offset of the line and later, the bar
        $box = imagettfbbox(32, 0, $fontPath, $lines[0]);
        $offset = $box[4] + 64;

        imagefilledrectangle($image, $offset, 0, $offset + 5, 100, $fg);

        $offset += 37;

        imagettftext($image, 10, 0, $offset, 38, $fg, $fontPath, $lines[1]);
        imagettftext($image, 10, 0, $offset, 50, $fg, $fontPath, $lines[2]);
        imagettftext($image, 10, 0, $offset, 64, $fg, $fontPath, $lines[3]);

        //watermark
        $dimensions = imagettfbbox(Configuration::getWatermarkSize(), 0, $fontPath, Configuration::getWatermark());
        $textWidth = abs($dimensions[4] - $dimensions[0]) + Configuration::getWatermarkPaddingX();

        $textHeight = abs($dimensions[7] - $dimensions[1]) + Configuration::getWatermarkPaddingY();
        imagettftext($image, Configuration::getWatermarkSize(), 0, Configuration::getImageWidth() - $textWidth, Configuration::getImageHeight() - $textHeight, $fg, $fontPath, Configuration::getWatermark());

        $this->imageContext = $image;
        return $this;
    }

    /**
     * Throws the image at the browser.
     */
    public function showToBrowser() {
        header("Content-Type: image/png");
        imagepng($this->imageContext);
        imagedestroy($this->imageContext);
    }


} 