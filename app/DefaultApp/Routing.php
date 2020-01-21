<?php
use app\DefaultApp\DefaultApp as App;
App::get("/", "default.index", "index");
App::post("/", "default.index","index_post");
App::post("/send", "default.send","");
App::get("/send", "default.send","");


