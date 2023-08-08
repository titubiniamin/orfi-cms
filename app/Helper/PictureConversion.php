<?php

namespace App\Helper;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Session;
use Hash;
use Imagick;
use Howtomakeaturn\PDFInfo\PDFInfo;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Vision\Feature;
use Vision\Request\Image\LocalImage;
use Vision\Vision;

// use NabilAnam\SimpleUpload\SimpleUpload;

trait PictureConversion
{

    public function pdftoimg(Book $book)
    {
        $info = pathinfo($book->book);
        $file_name = $info['basename'];

        $file = public_path() . '\storage\books\\' . $file_name;
        $book_name = strtolower(str_replace([" ", "."], "", $book->name));
        $subject_name = strtolower(str_replace([" ", "."], "", $book->subject->name));

        $out_path = public_path() . '\storage\books\img\\' . $subject_name . '\\' . $book_name;
        $output = $out_path . '\\' . $book_name . '-page.jpg';

        exec("mkdir $out_path");
        exec("magick convert -density 300 $file $output");
        // exec("convert -verbose -density 300 -trim $file -quality 100 -flatten -sharpen 0x1.0 $output");

        $images = glob($out_path . '\*.jpg');
        $data = [];

        foreach ($images as $key => $image) {

            $image_data = [];
            $image_data["book_id"] = $book->id;
            $image_data["screen_shot_base64"] = $this->convertImageToBase64($image);
            $image_data["screen_shot_location"] = str_replace('\\', '/', str_replace([public_path(), ''], '', $image));
            $data[$key] = $image_data;

        }

        return $data;

    }

    public function getScreenShotOfPDF(Request $request)
    {
        $url = $request->base64code;
        $dir = public_path() . "\storage\\";

        $image_parts = explode(";base64,", $url);
        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $dir . uniqid() . '.png';
        file_put_contents($file, $image_base64);

        return response()->json([
            'image' => $file
        ]);

    }

    public function convertImageToBase64($path)
    {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }


    function getBase64ImageToText($base_64_cropped_image): string
    {
        $image_path = self::storeBase64Image($base_64_cropped_image);
        $text = self::imageToTextConversion($image_path);
        self::deleteImage($image_path);
        return $text;
    }

    function getImageToText($image) : string
    {
        $image_path = self::storeImage($image);
        $text = self::imageToTextConversion($image_path);
        self::deleteImage($image_path);
        return $text;
    }

    /**
     * @param $imageUrl
     * @return string
     */
    public function imageToTextConversion($imageUrl) : string
    {
        return config('app.google_vision_api_is_enabled') ? self::googleVisionApiTextAnnotation($imageUrl) : self::tesseractTextAnnotation($imageUrl);
    }

    /**
     * @param $imageUrl
     * @return string
     */
    public function googleVisionApiTextAnnotation($imageUrl)
    {
        $vision = new Vision(
            env("GOOGLE_VISION_API_KEY"),
            [
                new Feature(Feature::DOCUMENT_TEXT_DETECTION, 500),
            ]
        );

        $response = $vision->request(new LocalImage($imageUrl));

        return $response->getfullTextAnnotation() != null ? $response->getfullTextAnnotation()->gettext() : '';
    }

    /**
     * @param $imageUrl
     * @return string
     */
    public function tesseractTextAnnotation($imageUrl) : string
    {
        $text = new TesseractOCR();
        $text = $text->image($imageUrl)
            ->lang('eng', 'ben', 'equ')
            ->run();
        return $text ?? '';
    }

    /**
     * @param $image
     * @return string
     */
    public function storeImage($image) : string
    {
        $location = $image->store('storage', 'public');
        return public_path() . '/storage/' . $location;
    }

    /**
     * @param $base_64_image
     * @return string
     */
    public function storeBase64Image($base_64_image) : string
    {
        $imageName = 'annotation/' . 'annotation-' . Str::random(15) . time() . '.png';
        $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base_64_image));
        Storage::disk('public')->put($imageName, $file);
        return public_path() . '/storage/' . $imageName;
    }

    /**
     * @param $image_path
     * @return void
     */
    public function deleteImage($image_path) : void
    {
        if (File::exists($image_path)) File::delete($image_path);
    }


}
