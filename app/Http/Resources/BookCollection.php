<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

//resurs koji je zapravo kolekcija, tj.radi sa nekim nizom
class BookCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = 'books';
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
