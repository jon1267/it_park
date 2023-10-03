<?php

namespace App\Services\Image;

use Illuminate\Support\Str;
use Image;

class Img
{
    public function getPoster($request): string
    {
        $imgPath = 'img/default.jpg'; // default poster

        if($request->hasFile('poster')) {
            $image = $request->file('poster');
            if ($image->isValid()) {
                $ext = $image->getClientOriginalExtension();
                $filename = time() . '-' . Str::random(8) . '.' . $ext; //dd($image, $filename, $ext);

                $img = Image::make($image);
                $img->save(public_path() . '/' . 'img/' . $filename);
                $imgPath = 'img/'.$filename;
            }
        }

        return $imgPath;
    }

    public function updatePoster($request, $film)
    {
        $imgPath = $film->poster;

        if ($request->hasFile('poster')) {
            $image = $request->file('poster');
            if ($image->isValid()) {
                $imgPath = $this->getPoster($request);
            }
        }

        return $imgPath;
    }
}