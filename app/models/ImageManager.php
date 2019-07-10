<?php

namespace App\models;

use Intervention\Image\ImageManagerStatic as Image;


class ImageManager{


    public function uploadImage()
    {
        Image::configure(array('driver' => 'gd'));

        $image = Image::make($_FILES['image']['tmp_name']);
        $image->backup(); // backup status

        $filename = uniqid() . '.' . strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $image->fit(632, 380)->save('uploads/'. $filename);
        $image->fit(362, 135)->save('uploads/th-pagination/'. $filename);


        $image->reset(); // reset image (return to backup state)
        $image->fit(103, 76)->save('uploads/thumbnail/'. $filename);

        return $filename;
    }


    public function uploadAvatar()
    {
        Image::configure(array('driver' => 'gd'));

        $image = Image::make($_FILES['image']['tmp_name']);
        $image->backup(); // backup status

        $filename = uniqid() . '.' . strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $image->fit(215, 215)->save('uploads/avatars/'. $filename);

        $image->reset(); // reset image (return to backup state)
        $image->fit(60, 60)->save('uploads/avatars/comments/'. $filename);

        return $filename;
    }

}