<?php

namespace App\Services;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Output\QRMarkupSVG;

class QrCodeService
{
    /**
     * Generate an inline SVG element or raw SVG string for a given payload/URL.
     */
    public static function svg(string $data, int $scale = 5): string
    {
        $options = new QROptions([
            'outputInterface' => QRMarkupSVG::class,
            'eccLevel'        => EccLevel::M,
            'scale'           => $scale,
            'outputBase64'    => false,
            'svgAddXmlHeader' => false,
            'addQuietzone'    => true,
            'quietzoneSize'   => 1,
        ]);

        $qrcode = new QRCode($options);
        return $qrcode->render($data);
    }

    /**
     * Generate a base64 Data URI for <img> tags.
     */
    public static function dataUri(string $data, int $scale = 5): string
    {
        $options = new QROptions([
            'outputInterface' => QRMarkupSVG::class,
            'eccLevel'        => EccLevel::M,
            'scale'           => $scale,
            'outputBase64'    => true,
            'svgAddXmlHeader' => true,
            'addQuietzone'    => true,
            'quietzoneSize'   => 1,
        ]);

        $qrcode = new QRCode($options);
        return $qrcode->render($data);
    }
}

