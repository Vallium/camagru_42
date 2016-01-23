<?php

namespace controller;

class GalleryController extends Controller
{
    public function index() {
        $this->render('gallery.php');
    }
}